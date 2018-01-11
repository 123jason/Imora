<?php

namespace Oradt\VerificationBundle\Controller;

use Oradt\OauthBundle\Controller\BaseController;
use Oradt\Utils\Errors;
use Oradt\Utils\Codes;

/**
 * 对短信验证码/链接的获取和验证操作
 */
class SmsController extends BaseController
{

    private $cache_pre = 'verifySms';
    /**
     * 短信验证方法
     * 注：1、读取时 先读缓存 判断后再根据需要读取数据库
     * 注：2、发现连接过期后删除缓存
     * @return type
     */
    public function getAction(){
        $this->accesstime = $this->getTimestamp1();
        $request = $this->getRequest();
        //获取页面请求的参数
        $mcode  = $request->get('mcode');
        $mobile = $request->get('mobile'); //手机号码必须
        $smsId  = $request->get('messageid'); //短信ID*必须
        $code   = $request->get('code'); //验证码*必须
        //mcode为空默认86
        if(empty($mcode)){
            $mcode = '86';
        }
        //验证不能为空
        if (empty($mobile) || empty($smsId) || empty($code)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }

        $data       = array();
        //先读去缓存,如果没有在查询数据库
        $cacheKey   = $this->getCacheKey($smsId,$this->cache_pre);
        //判断key是否存在，存在则读取缓存，不存在则读取数据库
        if($this->checkCacheKeyExists($cacheKey)){
            $data    = $this->hGetallCache($cacheKey);
        }else{
            $data   = $this->getSmsMessageByMid($smsId);
        }
        //打印日志
//        $logger = $this->container->get('special_logger');
//        $logger->info($this->container->get('request')->getClientIp() . '  /verification/sms  GET messageid：' . $smsId . '-----mobile：' . $mobile . '-----code：' . $code);           
        //判断数据是否存在
        if (empty($data)) {
            $returnArr = $this->getFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
        } else {
            //判断验证码的状态是否正常
            if(!empty($data['usestatue']) && $data['usestatue'] == '2'){
                $returnArr = $this->getFailed(Errors::$ERROR_PARAMETER_CODE_EXPIRED);
            }else{
                // $time = time();
                $time  = strtotime($this->getDateTime()->format('Y-m-d H:i:s'));
                //创建时间加过期时间长度
                $strtotime = strtotime($data['createtime']) + Codes::VERIFY_SMS_EXPIRE_TIME;
                //没有过期处理相应的逻辑
                if ($time < $strtotime) {
                    if ($data['mobile'] == $mcode.$mobile && $data['code'] == $code) {
                        $this->setParam('mcode', $mcode);
                        $this->setParam('mobile', $mobile);
                        $this->setParam('code', $code);
                        $this->setParam('messageid', $smsId);
                        $returnArr = $this->getSuccess();
                    } else {
                        $returnArr = $this->getFailed(Errors::$ERROR_PARAMETER_VERIFY_CODE);    //验证码错误
                    }
                } else {
                    //提示链接过期 检测cachekey 是否存在 存在则删除缓存
                    if($this->checkCacheKeyExists($cacheKey)){
                        $this->removeCache( $this->getCacheKey($smsId,$this->cache_pre));
                    }
                    $returnArr = $this->getFailed(Errors::$ERROR_PARAMETER_CODE_EXPIRED);
                }
            }
        }
        return $this->renderJson($returnArr);
    }
    /**
     * 短信需求-支持国内外（2017-4-6更改）
     */
    public function postAction(){
        $this->accesstime = $this->getTimestamp1();
        $request = $this->getRequest();
        $mcode  = $this->strip_tags($request->get('mcode'));
        if(empty($mcode))   $mcode = '86';
        $type   = $this->strip_tags($request->get('type','1')); //1:登陆验证
        if(empty($type))    $type = '1';
        $mobile = $this->strip_tags($request->get('mobile')); //手机号码*必须
        $module = $this->strip_tags($request->get('module')); //验证模块，按url 的首部分分类，account,accountbiz ...
        if (empty($mobile) || empty($module)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        //获取国家手机区号代码 如果手机区号不在支持范围内
//        $codeArr = $this->getMobileAreaCode();
//        if(!in_array($mcode, $codeArr)){
//            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
//        }
        //$logger = $this->container->get('special_logger');
        //验证是否是手机号-不符合做标记 不发送短信
        $mobileIsNormal = true;
        $functionService = $this->get("function_service");
        if (!$functionService->checkPhonePreg($mcode,$mobile)) {     //如果手机号格式不正确 则返回错误信息
            //$logger->info($this->container->get('request')->getClientIp() . '  /verification/sms  error_mobile：' . $mobile . '-----request:' . print_r($_REQUEST, true));
            $mobileIsNormal = false;
            //return $this->renderJsonFailed(Errors::$ERROR_MOBILE_FORMAT);
        }
        //扩展其他类型的验证短信内容
        switch ($type){
            case 1: //登陆验证
                $content = Codes::SMS_VERIFICATION_CODE;
                break;
            default :
                $content = Codes::SMS_VERIFICATION_CODE;
                break;
        }
        $smsService = $this->container->get('sms_service');
        //查询数据库是否有未使用记录 且发送时间 在10S以内的
        $lastSql = "SELECT sms_id,fseq_id FROM sms_message WHERE mobile =:mobile ORDER BY id DESC LIMIT 1;";
        $lastRecord = $this->getConnection()->executeQuery($lastSql, array("mobile"=>$mcode.$mobile))->fetch();
        if(!empty($lastRecord)){
            $lastTime   = $lastRecord['fseq_id'];        //fsegid 该参数 存的time()
            $nowTime    = time();
            $strtotime  = $lastTime + Codes::VERIFY_LENGTH_TIME;    //创建时间+验证时间长度（10S）
            //如果当前时间 < 验证码生成时间+验证时间长度  则不允许发送返回最新一条记录
            if($nowTime < $strtotime){
                return $this->renderJsonSuccess(array('messageid' => $lastRecord['sms_id']));
            }
        }
        //发送短信
        $data = $smsService->sendSmsByTypeNew($mcode,$mobile,$content,$module,$mobileIsNormal);
        //通过成功状态返回成功信息
        if (is_array($data)) {
            //查找message 数据 设置缓存
            $messageid  = $data['messageid'];
            $smsInfo    = $this->getSmsMessageByMid($messageid);
            if(!empty($smsInfo)){
                $cacheKey   = $this->getCacheKey($messageid,$this->cache_pre);
                $this->hmSetCache($cacheKey, $smsInfo);
                $this->setCacheExpireTime($cacheKey);       //设置cache过期时间默认1小时
            }
            //返回成功信号
            $array = $this->getSuccess($data);
        }elseif ($data == 1) {
            $array = $this->getFailed(Errors::$ERROR_IP_BLACKLIST);
        } else {
            $array = $this->getFailed(Errors::$ERROR_SEND_MESSAGE_FAILE);
        }
        return $this->renderJson($array);
    }

    /**
     * 创建对短信验证码操作
     * 注：设置成功后设置短信验证缓存  key 为 verifySms_messageid
     * @return type
     */
//    public function _OLDpostAction(){
//        $this->accesstime = $this->getTimestamp1();
//        //通过accessToken获取用户的信息
//        $request = $this->getRequest();
//        //获取页面请求的参数
//        $mcode  = $this->strip_tags($request->get('mcode'));
//        if(empty($mcode))   $mcode = '86';
//        $type   = $this->strip_tags($request->get('type','1')); //1:登陆验证
//        if(empty($type))    $type = '1';
//        $mobile = $this->strip_tags($request->get('mobile')); //手机号码*必须
//        $module = $this->strip_tags($request->get('module')); //验证模块，按url 的首部分分类，account,accountbiz ...
//        if (empty($mobile) || empty($module)) {
//            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
//        }
//        //获取国家手机区号代码 如果手机区号不在支持范围内
////        $codeArr = $this->getMobileAreaCode();
////        if(!in_array($mcode, $codeArr)){
////            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
////        }
//        //$logger = $this->container->get('special_logger');
//        //验证是否是手机号-不符合做标记 不发送短信
//        $mobileIsNormal = true;
//        $functionService = $this->get("function_service");
//        if (!$functionService->checkCountryMobile($mcode,$mobile)) {                      //如果手机号格式不正确 则返回错误信息
//            //$logger->info($this->container->get('request')->getClientIp() . '  /verification/sms  error_mobile：' . $mobile . '-----request:' . print_r($_REQUEST, true));
//            $mobileIsNormal = false;
//            //return $this->renderJsonFailed(Errors::$ERROR_MOBILE_FORMAT);
//        }
//        //扩展其他类型的验证短信内容
//        switch ($type){
//            case 1: //登陆验证
//                $content = Codes::SMS_VERIFICATION_CODE;
//                break;
//            default :
//                $content = Codes::SMS_VERIFICATION_CODE;
//                break;
//        }
//        
//        $smsService = $this->container->get('sms_service');
//        
//        //查询数据库是否有未使用记录 且发送时间 在10S以内的
//        $lastSql = "SELECT sms_id,fseq_id FROM sms_message WHERE mobile =:mobile ORDER BY id DESC LIMIT 1;";
//        $lastRecord = $this->getConnection()->executeQuery($lastSql, array("mobile"=>$mcode.$mobile))->fetch();
//        if(!empty($lastRecord)){
//            $lastTime   = $lastRecord['fseq_id'];        //fsegid 该参数 存的time()
//            $nowTime    = time();
//            $strtotime  = $lastTime + Codes::VERIFY_LENGTH_TIME;    //创建时间+验证时间长度（10S）
//            //如果当前时间 < 验证码生成时间+验证时间长度  则不允许发送返回最新一条记录
//            if($nowTime < $strtotime){
//                return $this->renderJsonSuccess(array('messageid' => $lastRecord['sms_id']));
//            }
//        }
//        //发送短信
//        $data = $smsService->sendSmsByType($mcode.$mobile,$content,$module,'verify',NULL,$mobileIsNormal);
//        //通过成功状态返回成功信息
//        if (is_array($data)) {
//            //查找message 数据 设置缓存
//            $messageid  = $data['messageid'];
//            $smsInfo    = $this->getSmsMessageByMid($messageid);
//            if(!empty($smsInfo)){
//                $cacheKey   = $this->getCacheKey($messageid,$this->cache_pre);
//                $this->hmSetCache($cacheKey, $smsInfo);
//                $this->setCacheExpireTime($cacheKey);       //设置cache过期时间默认1小时
//            }
//            //返回成功信号
//            $array = $this->getSuccess($data);
//        }elseif ($data == 1) {
//            $array = $this->getFailed(Errors::$ERROR_IP_BLACKLIST);
//        } else {
//            $array = $this->getFailed(Errors::$ERROR_SEND_MESSAGE_FAILE);
//        }
//        return $this->renderJson($array);
//    }
    
    /**
     * 根据messageId  获取短信内容
     * @param string $messageid 
     */
    private function getSmsMessageByMid($messageid){
        $data    = array();
        $sql     = "SELECT fseq_id,mobile,content,created_time,use_status FROM sms_message WHERE sms_id =:sms_id;";
        $smsMess = $this->getConnection()->executeQuery($sql, array("sms_id"=>$messageid))->fetch();
        if(!empty($smsMess)){
            $data       = array(
                'messageid'     => $messageid ,
                'mobile'        => $smsMess['mobile'],
                'code'          => $smsMess['content'],
                'createtime'    => $smsMess['created_time'],
                'usestatue'     => $smsMess['use_status']
            );
        }
        return $data;
    }
}
