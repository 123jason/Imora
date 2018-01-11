<?php
namespace Oradt\OauthBundle\Controller;
use Oradt\OauthBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Oradt\Utils\Codes;
use Oradt\Utils\Errors;
use Oradt\Utils\Password;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Request;

class ApiStoreController extends BaseController
{
    
    public function postAction ($act)
    {
        switch ($act)
        {
            case 'smslogin':
                return $this->_postSmsLogin();        //短信验证登陆
                break;
            case 'checkoauth':
                return $this->_checkoauth();          //检查登陆
                break;
            case 'checkaccount':
                return $this->_checkAccount();        //检查账户是否注册
                break;
            case 'checkemail':
                return $this->_checkEmail();          //检测邮箱是否注册
                break;
            case 'checkorange':
                return $this->_checkOrange();          //为橙子恢复出厂前调用，不做任何数据库处理，处理token 3 4
                break;
            case 'bindwechat':
                return $this->_bindWechat();          //进行绑定微信公众号操作
                break;
            default:
                return $this->renderJsonFailed(Errors::$HTTP_STATUS_CODE_404);
                break;
        }        
    }
    /**
     * 为橙子恢复出厂前调用，不做任何数据库处理，主要为处理token 3 4
     * 检测后重新登陆 就会清楚100015的错误码
     * 出现100014场景
     *    1.APP端上报丢失后，云端锁定当前绑定的橙子tooken并给橙子端发送281push消息,此时橙子端调用接口均返回100014错误码，
     *    2.橙子端收到100014错误码或281设备丢失消息后，弹出锁定框，APP扫码解锁后，恢复正常
     * 出现100015场景
     *    1.APP端上报清除橙子数据，云端锁定当前绑定橙子tooken并给橙子端发送282push消息，此时橙子端调用接口均返回100015错误码，
     *    2.橙子端收到100015错误码或282清除数据消息后，恢复出厂前调用云端接口成功后 云端给APP发送 280 已清除数据消息，
     *    3.橙子端恢复出厂，重新登录后，恢复正常
     */
    public function _checkOrange(){
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if ($this->accountType !== self::ACCOUNT_BASIC) {
            return $this->renderJsonFailed(Errors::$ERROR_INVALID_ACCESS);
        }
        return $this->renderJsonSuccess();
    }

    /**
     * 检测用户是否注册
     */
    public function _checkAccount(){
        $request  = $this->getRequest();
        $mcode    = $this->strip_tags($request->get('mcode'));  //默认86
        $mobile   = $this->strip_tags($request->get('mobile'));
        if(empty($mcode)){
            $mcode = '86';
        }
        if (empty($mobile)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $clientid = '';
        //检测公共账户表是否存在
        $accountService = $this->container->get("account_basic_service");
        $findArray      = array('account'=> $mcode.$mobile); 
        $accountCommon  = $accountService->findAccountCommonOneBy($findArray);
        if(!empty($accountCommon)){
            $clientid = $accountCommon->getAccountId();
        }
        return $this->renderJsonSuccess( array('clientid'=>$clientid) );
    }
    /*
     * 检查登陆
     * */
    private function _checkoauth(){
        $this->accesstime = $this->getTimestamp1();
        $request      = $this->getRequest();
        $clientId = $this->strip_tags($request->get('clientid'));
        $time     = $this->strip_tags($request->get('time'));
        if(empty($clientId) || empty($time)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_FORMAT);
        }
        //$sql = "SELECT * FROM login_session WHERE account_id=:clientid limit 1";
        $sql = "SELECT device_type,created_time FROM login_session WHERE device_type in ('ios','android') AND account_id=:clientid ORDER BY created_time DESC limit 1";
        $oauthinfo = $this->getConnection()->executeQuery($sql,array(':clientid'=>$clientId))->fetch();
        $data=array('status'=>0,'lasttime'=>0,'devicetype'=>0);//未登陆过

        if(empty($oauthinfo)){
            return $this->renderJsonSuccess( $data );
        }
        $createdtime = $oauthinfo['created_time']-Codes::TOKEN_EXPIRE_TIME;
        //$time=$time;
        //print_r($oauthinfo);
        //echo $createdtime . '_' . $time;
        if($createdtime > $time){
            $data = array('status'=>1,'lasttime'=>$createdtime,'devicetype'=>$oauthinfo['device_type']);//已登录过
        }
        return $this->renderJsonSuccess( $data );
    }
    /**
     * 根据messageId  获取短信内容
     * @param string $messageid 
     */
    private function getSmsMessageByMid($messageid){
        $data       = array();
        //$globalBase = $this->container->get('global_base');
        $param      = array('smsId' => $messageid);

        $repEntity = $this->getManager("default")->getRepository('OradtStoreBundle:SmsMessage');
        $smsMess = $repEntity->findOneBy($param);
        //$smsMess    = $globalBase->findOneBy('SmsMessage', $param);
        if(!empty($smsMess)){
            $data       = array(
                'messageid'     => $messageid ,
                'mobile'        => $smsMess->getMobile(),
                'code'          => $smsMess->getContent(),
                'createtime'    => $smsMess->getCreatedTime()->format('Y-m-d H:i:s'),
                'usestatue'     => $smsMess->getUseStatus()
            );
        }
        return $data;
    }

    public function _checkEmail()
    {
        $request = $this->getRequest();
        $email   = $this->strip_tags($request->get('email'));
        if (empty($email)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $globalBase = $this->container->get('global_base');
        $checkCom   = $globalBase->findOneBy('AccountCommon',array('account'=>$email));
        $clientid   = '';
        if (!empty($checkCom)) {
            $clientid = $checkCom->getAccountId();
        }else{
            $checkEmp   = $globalBase->findOneBy('AccountBizEmployee',array('email'=>$email));
            if (!empty($checkEmp)) {
                $clientid = $checkEmp->getEmpId();
            }    
        }
        return $this->renderJsonSuccess( array('clientid'=>$clientid) );
    }

    public function getAction ($act)
    {
        switch ($act)
        {
            case 'bindwechatsms':
                return $this->_getBindWechatSms();
                break;
            default:
                return $this->renderJsonFailed(Errors::$HTTP_STATUS_CODE_404);
                break;
        }
    }
    /**
     * 绑定微信公众号，获取短信验证码
     */
    public function _getBindWechatSms(){
        $this->accountId = "bindWechat";
        $this->accesstime = $this->getTimestamp1();
        $request = $this->getRequest();
        $mcode  = $this->strip_tags($request->get('mcode'));
        if(empty($mcode))   $mcode = '86';
        $mobile = $this->strip_tags($request->get("mobile"));

        $module = "bindWechat";

        if ( empty($mobile) ) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }

        //检查账号是否存在
        $accountService = $this->container->get ( 'account_basic_service' );
        $accountComm    = $accountService->checkAccountCommon($mcode.$mobile);
        if(empty($accountComm)){
            return $this->renderJsonFailed(Errors::$ERROR_ACCOUNT_NOEXISTS);
        }

        $mobileIsNormal = true;
        $functionService = $this->get("function_service");
        if (!$functionService->checkPhonePreg($mcode,$mobile)) {//如果手机号格式不正确 则返回错误信息
            $mobileIsNormal = false;
        }
        //设定短信内容
        $content = Codes::SMS_VERIFICATION_CODE;

        $smsService = $this->container->get('sms_service');
        //查询数据库是否有未使用记录 且发送时间 在10S以内的
        $lastSql = "SELECT sms_id,fseq_id FROM sms_message WHERE mobile=:mobile ORDER BY id DESC LIMIT 1;";
        $lastRecord = $this->getManager()->getConnection()->executeQuery($lastSql, array("mobile"=>$mcode.$mobile))->fetch();
        if(!empty($lastRecord)){
            $lastTime   = $lastRecord['fseq_id'];        //fsegid 该参数 存的time()
            $nowTime    = time();
            $strtotime  = $lastTime + Codes::VERIFY_LENGTH_TIME;    //创建时间+验证时间长度（10S）
            //如果当前时间 < 验证码生成时间+验证时间长度  则不允许发送返回最新一条记录
            if($nowTime < $strtotime){
                return $this->renderJsonSuccess( array('messageid' => $lastRecord['sms_id']) );
            }
        }
        //发送短信
        $data = $smsService->sendSmsByTypeNew($mcode,$mobile,$content,$module,$mobileIsNormal);
        //通过成功状态返回成功信息
        if (is_array($data)) {
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
     * 进行绑定微信公众号操作
     */
    public function _bindWechat(){
        $this->accountId = "bindWechat";
        $this->accesstime = $this->getTimestamp1();
        $request = $this->getRequest();
        $mcode  = $this->strip_tags($request->get('mcode'));
        if(empty($mcode))   $mcode = '86';
        $mobile = $this->strip_tags($request->get("mobile"));
        $messageid  = $this->strip_tags($request->get('messageid'));//短信ID
        $code   = $this->strip_tags($request->get('code')); //短信验证码
        //微信openid
        $wechatid = $this->strip_tags($request->get('wechatid'));

        //1---验证参数是否满足
        if (empty($messageid) || empty($mobile) || $code == '' || empty($wechatid)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        //2---验证短信是否存在 验证码是否正确（查找是否存在）
        $data   = $this->getSmsMessageByMid($messageid);
        if(empty($data)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
        }
        //2-1---判断验证码的状态
        if(!empty($data['usestatue']) && $data['usestatue'] == '2'){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_CODE_EXPIRED);
        }
        //3---验证 验证码是否 过期
        $time       = strtotime($this->getDateTime()->format('Y-m-d H:i:s'));
        $strtotime  = strtotime($data['createtime']) + Codes::VERIFY_SMS_EXPIRE_TIME;    //创建时间加过期时间长度
        if($time > $strtotime){         //如果当前时间 > 验证码生成时间+过期时间  则验证码已失效
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_CODE_EXPIRED);
        }

        //4---没有过期处理相应的逻辑,验证提交数据 是否与 数据库 匹配
        if ($data['mobile'] !== $mcode.$mobile || $data['code'] !== $code) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_VERIFY_CODE);  //验证码错误
        }

        //5---验证手机号是否注册
        $accountBasicService = $this->container->get ( 'account_basic_service' );
        $userInfo    = $accountBasicService->checkAccountCommon($mcode.$mobile);
        if(empty($userInfo)){    //用户不存在
            return $this->renderJsonFailed(Errors::$ERROR_ACCOUNT_NOEXISTS);
        }

        //6---用户存在，则验证该手机号是否已经进行绑定微信账户
        $param = array("accountId"=>$userInfo["account_id"],"type"=>"wechat");
        $mUserInfo = $accountBasicService->findAccountCommonOneBy( $param );
        if(!empty($mUserInfo)){    //该手机号已绑定微信账号
            return $this->renderJsonFailed(Errors::$MOBILE_DUPLICATE);
        }
        //7---用户存在，则验证该微信公众号账户是否已经进行绑定橙脉
        //根据openid查询当前用户的unionid，查询是否已经进行绑定
        $querySql = "SELECT union_id,wechat_info FROM `weixin_user` WHERE wechat_id=:wechatid LIMIT 1";
        $wechat = $this->getConnection()->executeQuery( $querySql, array(":wechatid"=>$wechatid))->fetch();
        $unionid = $wechat["union_id"];
        if( empty($unionid) ){
            return $this->renderJsonFailed(Errors::$ERROR_ACCOUNT_NOEXISTS);
        }

        $weUserInfo    = $accountBasicService->checkAccountCommon( $unionid );
        if(!empty($weUserInfo)){    //该公众号已绑定手机号码
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_DATA_EXISTS);
        }

        $this->getConnection()->beginTransaction();
        try{
            //写入账户公共表
            $accountBasicService->saveAccountCommon( $userInfo["account_id"], $unionid, "wechat");
            //修改微信用户表weixin_user
            $accountContactService = $this->get("account_contact_service");
            $accountContactService->wechatBingsOrange( $wechatid, $userInfo["account_id"], $wechat["wechat_info"] );
            $this->getConnection()->commit();
            return $this->renderJsonSuccess();
        }catch(\Exception $e){
            $this->getConnection()->rollBack();
            throw $e;
        }
    }
}
