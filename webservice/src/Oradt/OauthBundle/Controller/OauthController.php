<?php

namespace Oradt\OauthBundle\Controller;

use Oradt\OauthBundle\Controller\BaseController;
use Oradt\Utils\Codes;
use Oradt\Utils\Errors;

/**
 * oauth controller
 * @author zhiqiang xie <xiezq@oradt.com>
 * date   2014-08-11
 */
class OauthController extends BaseController
{
    
    public function indexAction() {
        
        exit('ok');
    }

    /**
     * oauth post action
     * @return type
     */
    public function postAction()
    {
        $this->accesstime = $this->getTimestamp1();
        $request = $this->getRequest();
        //$logger = $this->container->get('special_logger');
        $oauthService = $this->container->get('oauth_service');
        // $errorService = $this->container->get('oauth_error_service');
        //如果没有token，查看是否有用户名、密码、登录类型参数
        $mcode = $this->strip_tags( $request->get('mcode') );
        if(empty($mcode)){
            $mcode = '86';
        }

        $username = $this->strip_tags( $request->get('user') );
        $password = $this->strip_tags( $request->get('passwd') );
        $type = $this->strip_tags( $request->get('type') );
        $ip = $this->strip_tags( $request->get('ip', '::1') );
        $ismd5  = $this->strip_tags( $request->get('ismd5') );
        $device = $this->strip_tags( $request->get('device') );//设备
        $deviceId = $this->strip_tags( $request->get('deviceid') );//设备id
        $this->accountId = $username;
        //$logger->info($this->container->get('request')->getClientIp() . '  ' . $this->container->get('request')->getPathInfo() . ' ' . $this->container->get('request')->getMethod() . ' ' . $this->container->get('request')->getClientIp() . 'mcode:'.$mcode.'-----user:' . $username . '-----passwd:' . $password . '-----type:' . $type . '---IP:' . $ip);
        //获取token和请求类型
        if (empty($username) || empty($password) || empty($type) || empty($ip)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        //如果不为空 则转换为小写
        if(!empty($device)){
            $device = strtolower($device);
        }
        $oauthService->deviceId = $deviceId;
        //验证登录信息, 验证成功返回token，否则返回null
        $userInfo = $oauthService->getLoginToken($username, $password, $type, $ip, $mcode, $device,$ismd5);
        //如果token无效
        if ($userInfo == '-1') {
            //用户名错误
            $array = $this->getFailed(Errors::$OAUTH_ERROR_USER_NAME);
        } elseif (is_array($userInfo) && isset($userInfo['error']) && -2 == $userInfo['error']) {
            //密码错误   只有个人有锁定功能   
            if ('basic' == $type) {
                $data  = array(
                    'accountid' => $userInfo['accountid'],
                    'type'      => 'login'
                    );            
                $errRes= $oauthService->checkError($data);
                if (2 == $errRes) {
                   $array = $this->getFailed(Errors::$OAUTH_ERROR_ACCOUNT_LOCKOUT); 
                }else if (5 == $errRes) {                
                    $array = $this->getFailed(Errors::$OAUTH_ERROR_ACCOUNT_TEN_MINS);
                }else{
                    $array = $this->getFailed(Errors::$OAUTH_ERROR_USER_PWD);
                }
            }else{
                $array = $this->getFailed(Errors::$OAUTH_ERROR_USER_PWD);
            }            
        } elseif ('-5' == $userInfo) {
            // 已停用
            $array = $this->getFailed(Errors::$ACCOUNT_BIZ_USER_INACTIVE);
        } elseif ('-3' == $userInfo) {
            // 已删除
            $array = $this->getFailed(Errors::$ACCOUNT_BIZ_USER_DELETED);
        } elseif ('-4' == $userInfo) {
            // 未激活
            $array = $this->getFailed(Errors::$ACCOUNT_BIZ_USER_LIMITED);
        } elseif ('-6' == $userInfo) {
            $array = $this->getFailed(Errors::$OAUTH_ERROR_ACCOUNT_TEN_MINS);
        }elseif (is_array($userInfo) && !isset($userInfo['error'])) {
            //设置session的数组
            $token = array(
                'accesstoken' => $userInfo['token'],
                'expiration' => Codes::TOKEN_EXPIRE_TIME,
                'accountstate' => $userInfo['status'],
                'clientid' => $userInfo['accountId'],
                'created_time'=> $userInfo['created_time'] - Codes::TOKEN_EXPIRE_TIME
            );
            if (isset($userInfo['employeeid']) && isset($userInfo['reg_type'])) {
                $token['employeeid']= $userInfo['employeeid'];
                $token['reg_type']  = $userInfo['reg_type'];
                $token['bizsuperid']= $userInfo['bizsuperid'];
            } 
            if(isset($userInfo['ifmissing'])){
                $token['ifmissing']=$userInfo['ifmissing'];
            }
            //else{
                //判断是否是朋友推荐注册过来第一次登陆的用户
//                $taskRegSql = "SELECT id,user_id FROM oradt_task_register_list WHERE user_id ='".$token['clientid']."' AND `status` = 0 AND login_device = 0;";
//                $taskRegRow = $this->getConnection()->executeQuery($taskRegSql)->fetch();
//                if(!empty($taskRegRow)){
//                    if(in_array($device, array('ios','android'))){
//                        $upTaskRegsql = "UPDATE `oradt_task_register_list` SET login_device = 1 WHERE id ={$taskRegRow['id']}";
//                        $this->getConnection()->executeQuery($upTaskRegsql);
//                    }
//                }
            //}   
            $array = $this->getSuccess($token);
            //登录成功删除除橙子外且登录设备为当前设备$device的其他token 即：web\android\ios 等只能一个在线 其他被挤下去
            if(!empty($device) && $device != 'orange'){
                $oauthService->findOldLoginSession($userInfo['accountId'],$device);
            }
        } else {
            $array = $this->getFailed(Errors::$ERROR_UNKNOWN);
        }
        return $this->renderJson($array);
    }
    
    /**
     * account loginout
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction() {
        $this->checkAccount();
        $accesstoken =$this->checkLogin();
        $oauthService = $this->container->get('oauth_service');
        $this->removeCache($oauthService->getLoginCacheKey($accesstoken));
        $this->getConnection()->executeUpdate("DELETE FROM login_session WHERE session_id=:accesstoken" ,
                array( ':accesstoken' => $accesstoken));
        $isdelete = (int)$this->getRequest()->get("isdelete");
        if($isdelete == 1){
            $userId = $this->accountId;
            $this->getConnection()->executeUpdate("DELETE FROM `push_token` WHERE user_id=:userId AND session_id=:sessionId", array(':userId'=>$userId,':sessionId'=>$accesstoken));
        }
        return $this->renderJsonSuccess();
    }

}

