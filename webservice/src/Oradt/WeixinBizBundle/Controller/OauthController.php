<?php

namespace Oradt\WeixinBizBundle\Controller;

use Oradt\OauthBundle\Controller\BaseController;
use Oradt\Utils\Password;
use Oradt\Utils\Errors;
use Oradt\Utils\Codes;
use Oradt\StoreBundle\Entity\WeixinUser;
use Oradt\StoreBundle\Entity\WxBizEmployee;
use Oradt\ServiceBundle\Services\CurlService;
use Oradt\Utils\RandomString;
 

class OauthController extends BaseController
{
    public function postAction($act)
    {  
        switch ($act) {
            case 'login'://企业员工账号登录
                return $this->_oauth();
                break;
            case 'smslogin'://企业员工账号登录（验证码登录）
                return $this->_smsoauth();
                break;
            case 'welogin'://企业员工微信登录
                return $this->_welogin();
                break;
            case 'webindusercommon'://微信绑定账号
                return $this->_webindusercommon();
                break;
            case 'webind'://微信登录,绑定员工
                return $this->_webind();
                break;
            case 'logout'://企业员工账号退出登录
                return $this->_logout();
                break;
            case 'bindbiz'://员工账号绑定企业ID
                return $this->_bindbiz();
                break;
            case 'unbindbiz'://账号解除绑定企业ID
                return $this->_unbindbiz();
                break;
            case 'editusercommon'://修改账户信息
                return $this->_edit_user_common();
                break;
            case 'resetpassword'://重新设置密码
                return $this->_resetpassword();
                break;
            case 'delemployee'://删除员工
                return $this->_delemployee();
                break;
            default: 
                return $this->renderJsonFailed(Errors::$HTTP_STATUS_CODE_404);
                break;
        }
    }
    
    public function getAction($act)
    {
        $this->checkAccountV2();
        switch ($act) {
            case 'getusercommon': //获取用户信息
                return $this->_getUserCommon();
                break; 
            default:
                return $this->renderJsonFailed(Errors::$HTTP_STATUS_CODE_404);
                break;
        }
    }
    public function _oauth() 
    {
        $this->accesstime = $this->getTimestamp1();
        $request = $this->getRequest();
        //如果没有token，查看是否有用户名、密码、登录类型参数
        $mcode = $this->strip_tags( $request->get('mcode') );
        if(empty($mcode)){
            $mcode = '86';
        }
        $username = $this->strip_tags( $request->get('user') );
        $password = $this->strip_tags( $request->get('passwd') );
        $ip = $this->strip_tags( $request->get('ip', '::1') );
        $this->accountId = $username;
        //获取token和请求类型
        if (empty($username) || empty($password) ) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }

        $findArray  = array();
        $functionService = $this->container->get('functionService');
        if (!$functionService->checkTelephone($username)) {
            $accountType="email";
            $findArray[':email'] = $username;
            $sql = "SELECT id,account_no,username,mobile,email,password,wechat_id FROM `user_common` WHERE email =:email  LIMIT 1";
        } else {
            $accountType="mobile";
            $findArray[':mobile'] = $username;
            $sql = "SELECT id,account_no,username,mobile,email,password,wechat_id FROM `user_common` WHERE mobile =:mobile  LIMIT 1";
        }
        //查询员工是否存在
        $em = $this->getManager();
        $userRes    = $em->getConnection()->executeQuery($sql,$findArray)->fetch();
        if( empty($userRes) ){
            return $this->renderJsonFailed(Errors::$OAUTH_ERROR_USER_NAME);
        }
        //验证密码
        $pwd = new Password();
        $password = $pwd->encrypt(trim($password)); 
        if( $password !== $userRes["password"] ){
            return $this->renderJsonFailed(Errors::$OAUTH_ERROR_USER_PWD);
        }
        $userInfo["id"]=$userRes["account_no"];
        $userInfo["biz_id"]="";
        $userInfo["name"]=$userRes["username"];
        $userInfo["wechat_id"]=$userRes["wechat_id"];
        $userInfo['role_id']=0;
        //查询员工信息
        $querySql = "SELECT * FROM `wx_biz_employee` WHERE account_no = :account_no LIMIT 1";
        $empInfo = $em->getConnection()->executeQuery($querySql,array(":account_no"=>$userRes['account_no']))->fetch();
 
        if(!empty($empInfo)&&$empInfo["enable"] == '1')// 正常状态
        {
            $userInfo["biz_id"]=$empInfo["biz_id"]; 
            $userInfo["name"]=$empInfo["name"];
            $userInfo['role_id']=$empInfo["role_id"];
            $userInfo["emp_id"]=$empInfo["id"];
        }
        $oauthService = $this->container->get('oauth_service');

        $tokenInfo = $oauthService->setLoginSessionV2( $userInfo, $ip, $accountType);
 
        //设置session的数组
        $token = array(
            'accesstoken' => $tokenInfo['token'],
            'expiration' => Codes::TOKEN_EXPIRE_TIME,
            'bizid' => $tokenInfo['bizid'],
            'clientid' =>(isset($userInfo["emp_id"])? $userInfo["emp_id"]:""),
            'accountid' => $tokenInfo['accountId'],
            'roleid' => $userInfo['role_id'],
            'wechat_id'=> $userInfo["wechat_id"],
            'created_time'=> $tokenInfo['created_time'] - Codes::TOKEN_EXPIRE_TIME
        );
        return $this->renderJsonSuccess($token);

    }
    
    /**
     * 短信验证码登录
     */
    public function _smsoauth()
    {
        $this->accesstime = $this->getTimestamp1();
        $request = $this->getRequest();
        //如果没有token，查看是否有用户名、密码、登录类型参数
        $mcode = $this->strip_tags( $request->get('mcode') );
        if(empty($mcode)){
            $mcode = '86';
        }
        $username = $this->strip_tags( $request->get('user') );
        $sms = $this->strip_tags( $request->get('sms') );
        $ip = $this->strip_tags( $request->get('ip', '::1') );
        $this->accountId = $username;
        //获取token和请求类型
        if (empty($username) || empty($sms) ) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }

        //短信验证
        $smsService = $this->container->get('sms_service');
        //查询数据库是否有未使用记录 且发送时间 在10S以内的
        $lastSql = "SELECT sms_id,fseq_id,content,mobile FROM sms_message WHERE mobile =:mobile ORDER BY id DESC LIMIT 1;";
        $lastRecord = $this->getConnection()->executeQuery($lastSql, array("mobile"=>$mcode.$username))->fetch();
        if(!empty($lastRecord)){
            $lastTime   = $lastRecord['fseq_id'];        //fsegid 该参数 存的time()
            $nowTime    = time();
            $strtotime  = $lastTime + Codes::VERIFY_SMS_EXPIRE_TIME;     
            //如果当前时间 < 验证码生成时间+验证时间长度  则不允许发送返回最新一条记录
       
            if($nowTime > $strtotime){
                return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_CODE_EXPIRED);//验证码超时
            }
            if($lastRecord["content"]!=$sms){
                return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_VERIFY_CODE);//验证码错误 
            }
        }else{
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);//没有手机号信息
        }
        
        $findArray  = array();
        $functionService = $this->container->get('functionService');
        if (!$functionService->checkTelephone($username)) {
            $findArray[':email'] = "email";
            $sql = "SELECT id,account_no,email,username,password,wechat_id FROM `user_common` WHERE email =:email  LIMIT 1";
        } else {
            $findArray[':mobile'] = $username;
            $sql = "SELECT id,account_no,mobile,password,username,wechat_id FROM `user_common` WHERE mobile =:mobile  LIMIT 1";
        }
        //查询员工是否存在
        $em = $this->getManager();
        $userRes    = $em->getConnection()->executeQuery($sql,$findArray)->fetch();
        if( empty($userRes) ){
            return $this->renderJsonFailed(Errors::$OAUTH_ERROR_USER_NAME);
        }
       
        $userInfo["id"]=$userRes["account_no"];
        $userInfo["biz_id"]="";
        $userInfo["name"]=$userRes["username"];
        $userInfo["wechat_id"]=$userRes["wechat_id"];
        $userInfo['role_id']=0;
        //查询员工信息
        $querySql = "SELECT * FROM `wx_biz_employee` WHERE account_no = :account_no LIMIT 1";
        $empInfo = $em->getConnection()->executeQuery($querySql,array(":account_no"=>$userRes['account_no']))->fetch();
        
        if(!empty($empInfo)&&$empInfo["enable"] == '1')// 正常状态
        {
            $userInfo["biz_id"]=$empInfo["biz_id"]; 
            $userInfo["name"]=$empInfo["name"];
            $userInfo['role_id']=$empInfo["role_id"];
            $userInfo["emp_id"]=$empInfo["id"];
        }
        
        $oauthService = $this->container->get('oauth_service');

        $tokenInfo = $oauthService->setLoginSessionV2( $userInfo, $ip, "sms");

        //设置session的数组
        $token = array(
            'accesstoken' => $tokenInfo['token'],
            'expiration' => Codes::TOKEN_EXPIRE_TIME,
            'bizid' => $tokenInfo['bizid'],
            'clientid' =>(isset($userInfo["emp_id"])? $userInfo["emp_id"]:""),
            'accountid' => $tokenInfo['accountId'],
            'roleid' => $userInfo['role_id'],
            'wechat_id'=> $userInfo["wechat_id"],
            'created_time'=> $tokenInfo['created_time'] - Codes::TOKEN_EXPIRE_TIME
        );
        return $this->renderJsonSuccess($token);
    
    }
    /**
     * 员工微信登录
     */
    public function _welogin(){
        $this->accountId = "wxWeLogin"; 
        //设置日志记录开始时间
        $this->accesstime = $this->getTimestamp1();

        $request = $this->getRequest();
        $wecode  = $this->strip_tags($request->get('wecode'));
        $ip = $this->strip_tags( $request->get('ip', '::1') );
        if( empty($wecode) ){
            $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $em = $this->getManager();
        $weData = $this->getWeUserInfo( $wecode );
        if( empty($weData) ){
            return $this->renderJsonFailed(Errors::$ERROR_UNKNOWN);
        }
        //查询是否已经绑定用户
        $sql        = "SELECT id,account_no,mobile,username,wechat_id FROM user_common WHERE union_id =:account ";
        $findArray  = array(':account'=> $weData["unionid"]);
        $userRes     = $this->getConnection()->executeQuery($sql,$findArray)->fetch();
        if( empty($userRes) ){
            $data = array(
                "isbind" => 0,
                "bindid" => $weData["bindid"],
                "wechatid" => $weData["openid"],
                "unionid" => $weData["unionid"]
            );
            return $this->renderJsonSuccess( $data );
        }
        
        $userInfo["id"]=$userRes["account_no"];
        $userInfo["name"]=$userRes["username"];
        $userInfo["biz_id"]="";
        $userInfo["wechat_id"]=$userRes["wechat_id"];
        $userInfo['role_id']=0;
        //查询员工信息
        $querySql = "SELECT * FROM `wx_biz_employee` WHERE account_no = :account_no LIMIT 1";
        $empInfo = $em->getConnection()->executeQuery($querySql,array(":account_no"=>$userRes['account_no']))->fetch();
        
        if(!empty($empInfo)&&$empInfo["enable"] == '1')// 正常状态
        {
            $userInfo["biz_id"]=$empInfo["biz_id"];
            $userInfo["name"]=$empInfo["name"];
            $userInfo['role_id']=$empInfo["role_id"];
            $userInfo["emp_id"]=$empInfo["id"];
        }
        
        $oauthService = $this->container->get('oauth_service');
        $tokenInfo = $oauthService->setLoginSessionV2( $userInfo, $ip, 'wechat');

        //设置session的数组
        $token = array(
            "isbind" => 1,
            'accesstoken' => $tokenInfo['token'],
            'expiration' => Codes::TOKEN_EXPIRE_TIME,
            'bizid' => $tokenInfo['bizid'],
            'clientid' =>(isset($userInfo["emp_id"])? $userInfo["emp_id"]:""),
            'accountid' => $tokenInfo['accountId'],
            'roleid' => $userInfo['role_id'],
            'wechat_id'=> $userInfo["wechat_id"],
            'created_time'=> $tokenInfo['created_time'] - Codes::TOKEN_EXPIRE_TIME
        );
        return $this->renderJsonSuccess($token);
    }
    

    /**
     * 微信 绑定 账号
     */
    public function _webindusercommon(){
        $this->accountId = "wxBindWe";
        //设置日志记录开始时间
        $this->accesstime = $this->getTimestamp1();
       
        $request = $this->getRequest();
        $mcode  = $this->strip_tags($request->get('mcode'));
        if(empty($mcode))   $mcode = '86';
        $mobile = $this->strip_tags($request->get("mobile"));
        //绑定记录id
        $bindid = $this->strip_tags($request->get('bindid'));
        $sms = $this->strip_tags( $request->get('sms') );
        $ip = $this->strip_tags( $request->get('ip', '::1') );
        //1---验证参数是否满足
        if ( empty($mobile) || empty($bindid)||empty($sms)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        
        //2---是否 在微信中点击登录
        $querySql = "SELECT * FROM `account_bind_we_login` WHERE bind_id=:bindid LIMIT 1";
        $weData = $this->getConnection()->executeQuery($querySql, array(":bindid"=>$bindid))->fetch();
        if( empty($weData) ){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMTER_ERROR,"paramter bindid values");
        }
        
        //2---是否关注微信
        $weixinuser = $this->getDoctrine()->getRepository('OradtStoreBundle:WeixinUser')->findOneBy( array('unionId'=>$weData["unionid"]));
        if( empty($weixinuser) ){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
        }
         
        //3---短信验证
        $smsService = $this->container->get('sms_service');
        //查询数据库是否有未使用记录 且发送时间 在10S以内的
        $lastSql = "SELECT sms_id,fseq_id,content FROM sms_message WHERE mobile =:mobile ORDER BY id DESC LIMIT 1;";
        $lastRecord = $this->getConnection()->executeQuery($lastSql, array("mobile"=>$mcode.$mobile))->fetch();
        if(!empty($lastRecord)){
            $lastTime   = $lastRecord['fseq_id'];        //fsegid 该参数 存的time()
            $nowTime    = time();
            $strtotime  = $lastTime + Codes::VERIFY_SMS_EXPIRE_TIME;
            //如果当前时间 < 验证码生成时间+验证时间长度  则不允许发送返回最新一条记录
             
            if($nowTime > $strtotime){
                return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_CODE_EXPIRED);//验证码超时
            }
            if($lastRecord["content"]!=$sms){
                return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_VERIFY_CODE);//验证码错误
            }
        }else{
            return $this->renderJsonFailed(Errors::$ERROR_DATA_NULL);//没有手机号信息
        }
    
        //4---验证手机号是否注册
        $findArray = array(
            ':mobile' =>$mobile
        );
        $sql        = "SELECT account_no,username,mobile,wechat_id,union_id FROM `user_common` WHERE mobile =:mobile LIMIT 1";
        $userRes    = $this->getConnection()->executeQuery($sql,$findArray)->fetch();
        
        $wxBizService = $this->container->get("wx_biz_service");
        
        if( empty($userRes) ){//没有账户
            //return $this->renderJsonFailed(Errors::$OAUTH_ERROR_USER_NAME);
            $account["unionid"]=$weixinuser->getUnionId();
            $account["wechatid"]=$weixinuser->getWechatId();
            $account["mobile"]=$mobile; 
            $createTime=$this->getTimestamp();
            $userRes["account_no"]=$wxBizService->insertIntoCommon('mobile', null, $account,$createTime);
            $userRes["wechat_id"]=$account["wechatid"];
            $userRes["username"]="";
        } 
        
        //5---用户存在，则验证该手机号是否已经进行绑定微信账户
        
        if(!empty($userRes["union_id"])){    //该手机号已绑定微信账号
            if( $weData["unionid"] !== $userRes["union_id"] ){
                return $this->renderJsonFailed(Errors::$MOBILE_DUPLICATE);
            }
        }else{//该手机号未绑定微信账号，则直接绑定
            //6---用户存在，则验证该微信账户是否已经进行绑定
             
            //微信公众号绑定员工
          
            $account["unionid"]=$weixinuser->getUnionId();
            $account["wechatid"]=$weixinuser->getWechatId();
            $account["mobile"]=$mobile;
            $createTime=$this->getTimestamp();
            $wxBizService->insertIntoCommon('wechat', null, $account,$createTime);
        }
        
        
        $userInfo["id"]=$userRes["account_no"];
        $userInfo["biz_id"]="";
        $userInfo["name"]=$userRes["username"];
        $userInfo["wechat_id"]=$userRes["wechat_id"];
        $userInfo['role_id']=0;
        //查询员工信息
        $querySql = "SELECT * FROM `wx_biz_employee` WHERE account_no = :account_no LIMIT 1";
        $empInfo = $this->getConnection()->executeQuery($querySql,array(":account_no"=>$userRes['account_no']))->fetch();
        
        if(!empty($empInfo)&&$empInfo["enable"] == '1')// 正常状态
        {
            $userInfo["biz_id"]=$empInfo["biz_id"];
            $userInfo["name"]=$empInfo["name"];
            $userInfo['role_id']=$empInfo["role_id"];
        }
        
        $oauthService = $this->container->get('oauth_service');
        $tokenInfo = $oauthService->setLoginSessionV2( $userInfo, $ip, 'wechat');
        //设置session的数组
        $token = array( 
            'accesstoken' => $tokenInfo['token'],
            'expiration' => Codes::TOKEN_EXPIRE_TIME,
            'bizid' => $tokenInfo['bizid'],
            'clientid' =>(isset($userInfo["emp_id"])? $userInfo["emp_id"]:""),
            'accountid' => $tokenInfo['accountId'],
            'roleid' => $userInfo['role_id'],
            'wechat_id'=> $userInfo["wechat_id"],
            'created_time'=> $tokenInfo['created_time'] - Codes::TOKEN_EXPIRE_TIME
        );
        return $this->renderJsonSuccess($token);
    }
    
    
    /**
     * 微信登录绑定员工账号
     */
    public function _webind(){
        $this->accountId = "wxBindWe";
        //设置日志记录开始时间
        $this->accesstime = $this->getTimestamp1();
        $request = $this->getRequest();
        $mcode  = $this->strip_tags($request->get('mcode'));
        if(empty($mcode))   $mcode = '86';
        $mobile = $this->strip_tags($request->get("mobile"));
        //绑定记录id
        $bindid = $this->strip_tags($request->get('bindid'));

        //1---验证参数是否满足
        if ( empty($mobile) || empty($bindid)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }

        $em = $this->getManager();

        $querySql = "SELECT * FROM `account_bind_we_login` WHERE bind_id=:bindid LIMIT 1";
        $weData = $em->getConnection()->executeQuery($querySql, array(":bindid"=>$bindid))->fetch();
        if( empty($weData) ){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMTER_ERROR,"paramter bindid values");
        }

        //5---验证手机号是否注册
        $findArray = array(
            ':account' => $mcode.$mobile,
            ':type' => "mobile"
        );
        $sql        = "SELECT type,account_id,account FROM `account_common` WHERE account =:account AND type=:type LIMIT 1";
        $userInfo    = $em->getConnection()->executeQuery($sql,$findArray)->fetch();
        if( empty($userInfo) ){
            return $this->renderJsonFailed(Errors::$OAUTH_ERROR_USER_NAME);
        }
        $accountId = $userInfo["account_id"];
        //6---用户存在，则验证该手机号是否已经进行绑定微信账户
        $param = array("accountId"=>$accountId,"type"=>"wechat");
        $sql        = "SELECT type,account_id,account FROM `account_common` WHERE account_id =:accountId AND type=:type LIMIT 1";
        $mUserInfo    = $em->getConnection()->executeQuery($sql,$param)->fetch();

        if(!empty($mUserInfo)){    //该手机号已绑定微信账号
            if( $weData["unionid"] !== $mUserInfo["account"] ){
                return $this->renderJsonFailed(Errors::$MOBILE_DUPLICATE);
            }
        }else{//该手机号未绑定微信账号，则直接绑定
            //7---用户存在，则验证该微信账户是否已经进行绑定
            $findArray = array(
                ':account' => $weData["unionid"],
                ':type' => "wechat"
            );
            $sql        = "SELECT type,account_id,account FROM `account_common` WHERE account =:account AND type=:type LIMIT 1";
            $weUserInfo    = $em->getConnection()->executeQuery($sql,$findArray)->fetch();

            if(!empty($weUserInfo)){    //该公众号已绑定手机号码
                return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_DATA_EXISTS);
            }
            //微信公众号绑定员工
            $params = array(
                ':type'     => 'wechat',
                ':accountid'=> $accountId,
                ':account'  => $weData["unionid"],
                ':createtime' => $this->getTimestamp()
            );
            $insertQuery = "INSERT INTO account_common (type,account_id,account,createtime)
                VALUES(:type,:accountid,:account,:createtime)";
            $this->getConnection()->executeUpdate($insertQuery , $params);
        }

        //查询员工信息
        $querySql = "SELECT * FROM `wx_biz_employee` WHERE id = :accountId LIMIT 1";
        $userInfo = $em->getConnection()->executeQuery($querySql,array(":accountId"=>$accountId))->fetch();

        if( $userInfo["enable"] == '2' ){//邀请状态
            return $this->renderJsonFailed(Errors::$ERROR_BINDING_STATUS);
        }elseif( $userInfo["enable"] == '3' ){//已离职
            return $this->renderJsonFailed(Errors::$ERROR_NOT_HAVE_PERMISSION);
        }
        //$userInfo["enable"] == '1', 正常状态
        $oauthService = $this->container->get('oauth_service');
        $tokenInfo = $oauthService->setLoginSessionV2( $userInfo, $weData["ip"], 'wechat');

        //设置session的数组
        $token = array(
            'accesstoken' => $tokenInfo['token'],
            'expiration' => Codes::TOKEN_EXPIRE_TIME,
            'bizid' => $tokenInfo['bizid'],
            'clientid' => $tokenInfo['accountId'],
            'roleid' => $userInfo['role_id'],
            'created_time'=> $tokenInfo['created_time'] - Codes::TOKEN_EXPIRE_TIME
        );
        return $this->renderJsonSuccess($token);
    }
    /**
     * 获取accesstoken以及用户信息
     * @date 2017-09-04
     * @author tianjianlin@oradt.com
     */
    private function getWeUserInfo( $code = "", $device="", $ip ="" ){

        if( empty($code) ){
            return null;
        }

        $em = $this->getManager();

        if($this->container->hasParameter('WE_WxID') && $this->container->hasParameter('WE_WxSecret')){
            $APPID = $this->container->getParameter('WE_WxID');
            $SECRET = $this->container->getParameter('WE_WxSecret');
            $getAccessTokenUrl = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$APPID}&secret={$SECRET}&code={$code}&grant_type=authorization_code";
            $curl = new CurlService();
            $result = $curl->exec($getAccessTokenUrl, array(),'get',array(
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false
            ));
            self::ssLog('get_access_token',$result);
            //错误码 https://open.weixin.qq.com/cgi-bin/showdocument?action=dir_list&t=resource/res_list&verify=1&id=open1419318634&token=&lang=zh_CN
            if( strpos($result,"errcode") ){
                return null;
            }
            $paramRs = json_decode( $result, true );
            if( !empty($paramRs["unionid"]) && false !== strpos($paramRs["scope"],"snsapi_login")){//是否获得用户获取个人信息权限
                $getWeUserInfoUrl = "https://api.weixin.qq.com/sns/userinfo?access_token=".$paramRs["access_token"]."&openid=".$paramRs["openid"];
                $userInfo = $curl->exec($getWeUserInfoUrl, array(), 'get' ,array(
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false
                ));
                self::ssLog('get_user_info',$userInfo);
                //记录绑定ID
                $bindid = RandomString::make(32);
                self::ssLog('bind_id',$bindid);

                $insertSql = "INSERT INTO `account_bind_we_login` (bind_id, access_token, expire_time, refresh_token, openid, scope, unionid, userinfo, create_time, device, ip)
                          VALUES (:bindid, :accesstoken, :expiretime, :refreshtoken, :openid, :scope, :unionid, :userinfo, :createtime,:device, :ip)";
                $currentTime = $this->getTimestamp();
                $data = array(
                    "bindid" => $bindid,
                    "accesstoken" => $paramRs["access_token"],
                    "expiretime" => $currentTime + $paramRs["expires_in"],
                    "refreshtoken" => $paramRs["refresh_token"],
                    "openid" => $paramRs["openid"],
                    "scope" => $paramRs["scope"],
                    "unionid" => $paramRs["unionid"],
                    "userinfo" => $userInfo,
                    "createtime" => $currentTime,
                    "device" => $device,
                    "ip" => $ip
                );
                $em->getConnection()->executeUpdate( $insertSql, $data);

                if( 0 < $em->getConnection()->lastInsertId()){
                    return $data;
                }
            }
        }

        return null;
    }
    /**
     * account loginout
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function _logout() {
        $this->checkAccountV2();
        $accesstoken =$this->checkLogin();
        $oauthService = $this->container->get('oauth_service');
        $this->removeCache($oauthService->getLoginCacheKey($accesstoken));
        $this->getConnection()->executeUpdate("DELETE FROM login_session WHERE session_id=:accesstoken" ,
            array( ':accesstoken' => $accesstoken));

        return $this->renderJsonSuccess();
    }
    /**
     * 员工绑定企业ID
     */
    public function _bindbiz(){
        $request = $this->getRequest();
        $wechatid = $request->get("wechatid");
        $mcode = $request->get("mcode");
        if( empty($mcode) ){
            $mcode = 86;
        }
        $mobile = $request->get("mobile");//该验证请求在web端控制，调用短信验证接口获取以及验证验证码
        $bizid = $request->get("bizid");
        $name = $request->get("name");
        $email = $request->get("email");
        $passwd = $this->strip_tags($request->get("passwd", ""));
        if( empty($wechatid) || empty($mobile) || empty($bizid) || empty($name) ){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }

        //查询是否存在该wechatid
        $weixinuser = $this->getDoctrine()->getRepository('OradtStoreBundle:WeixinUser')->findOneBy( array('wechatId'=>$wechatid));
        if( empty($weixinuser) ){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
        }
  
        //查询企业是否存在
        $bSql = "SELECT 1 FROM `wx_biz` WHERE biz_id=:bizId LIMIT 1";
        $isBiz = $this->getConnection()->executeQuery( $bSql, array(":bizId"=>$bizid))->fetchColumn();
        if( $isBiz < 1 ){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_BIZ_ENOUGH);
        }
   
        $wxBizService = $this->container->get("wx_biz_service");

        //查询该微信是否已经绑定
        $isWexin = $wxBizService->checkAccountCommon( $weixinuser->getUnionId(), 'wechat');
       

        //查询手机号是否 在员工表中
        $isMobile = $wxBizService->checkUserIfExist( $mobile);

        //查询邮箱是否已注册
        if( empty($email) ){
            $isEmail = "";
        }else{
            $isEmail = $wxBizService->checkAccountCommon( $email, 'email');
        }

        $isUpdate = false;
        if( !empty($isMobile) || !empty($isEmail) ){
            if(!empty($isMobile) && !empty($isEmail)){
                if(！empty($isMobile["account_no"])&& $isMobile["account_no"] != $isEmail["account_no"] ){
                    return $this->renderJsonFailed( Errors::$OAUTH_ERROR_ACCOUNT_ABNORMAL );
                }else{
                    $isUpdate = true;
                }
            }
            if( !empty($isMobile) && empty($isEmail) ){
 
                $isUpdate = true;
                //return $this->renderJsonFailed(Errors::$MOBILE_DUPLICATE);
            }

            if( empty($isMobile) && !empty($isEmail) ){
                return $this->renderJsonFailed(Errors::$EMAIL_DUPLICATE);//邮箱已经被注册
            }

        }
  
        if( $isUpdate ){
           
            if( empty($isMobile) ){
                return $this->renderJsonFailed(Errors::$ERROR_ACCOUNT_NOEXISTS);
            }
         
            $account_no = $isMobile["account_no"];
            $userId = $isMobile["id"];
 
            /* //查询该微信是否已经绑定
            if( !empty($isWexin)){
                return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_DATA_EXISTS);
            } */
            //已注册
            //查询企业是否与员工注册企业是同一个
            if( $bizid !== $isMobile["biz_id"] ){
                return $this->renderJsonFailed(Errors::$ERROR_BINDING_STATUS);
            }
            $userInfo = json_decode( $weixinuser->getWechatInfo(), true );
            if (empty($userInfo['openid']) || empty($userInfo['unionid'])) {
                return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
            }
            //自己注册员工不修改
            $paramArr = array(
                ":account_no"=>$account_no,
                ":mcode" => $mcode,
                ":mobile" => $mobile,
                ":rname" => $name,
                ":openid" => $userInfo["openid"],
                ":unionid" => $userInfo["unionid"],
                ":id" => $userId
            ); 
            $updSql = "UPDATE `wx_biz_employee` SET account_no=:account_no,code=:mcode,mobile=:mobile,`name`=:rname,open_id=:openid,union_id=:unionid";
            if( !empty($passwd) ){
                $passwd = Password::encrypt( $passwd );
                $updSql .= ",passwd=:passwd";
                $paramArr[":passwd"] = $passwd;
            }
            if( !empty($email) ){
                $updSql .= ",email=:email";
                $paramArr[":email"] = $email;
            }
            if( '1' === $isMobile["re_from"] ){
                $updSql .= ",enable=1,ident_status=1";
            }
            $updSql .= " WHERE id=:id LIMIT 1";
            $this->getConnection()->executeUpdate($updSql, $paramArr);
        }else{ 
              
            $userInfo = json_decode( $weixinuser->getWechatInfo(), true ); 
            
            if (empty($userInfo['openid']) || empty($userInfo['unionid'])) {
                return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
            }
 
          
            $paramArr = array( 
                "code" => $mcode,
                "mobile" => $mobile,
                "email" => $email,
                "bizid" => $bizid,
                "type" => 1,
                "name" => $name,
                "openid" => $userInfo["openid"],
                "unionid" => $userInfo["unionid"],
                "password" => $passwd,
                "from" => 2,
                "enable" => 2
            );
            $rs = $wxBizService->insertIntoEmployee( $paramArr );
           
            if($rs == 1 || $rs == 2){
                return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
            }
            $userId = $rs["empid"];
         
        }
        //未绑定微信账号
        if( empty($isWexin) ) {
            //微信公众号绑定员工
            $account["unionid"]=$weixinuser->getUnionId();
            $account["wechatid"]=$weixinuser->getWechatId();
            $account["mobile"]=$mobile;
            $wxBizService->insertIntoCommon('wechat', $userId, $account, $this->getTimestamp());
        }
        //更新weixin_user表
        $updSql = "UPDATE `weixin_user` SET biz_id=:bizId WHERE wechat_id=:wechatid LIMIT 1";
        $this->getConnection()->executeUpdate($updSql,array(":bizId"=>$bizid,":wechatid"=>$wechatid));
        
        $returnArr = array( 'empid'=>$userId); 
        return $this->renderJsonSuccess($returnArr);
    }
    
    /**
     * 员工解除绑定企业ID
     */
    public function _unbindbiz(){
        $request = $this->getRequest();
     
        $type =  $this->strip_tags($request->get('type'));
        if (!empty($type)&&$type=="pc"){
            $this->checkAccountV2();//权限检查
            $bizid =  $this->bizId;
            $accountNo=$this->accountNo;
            $sql_employee        = "SELECT id,role_id FROM wx_biz_employee WHERE account_no =:accountNo  and enable!=3 ";//enable=3离职状态
            $find_employee_Array  = array(':accountNo'=> $accountNo);
        }
        else{//微信解绑
            $wechatid =  $this->strip_tags($request->get('wechatid'));
            $bizid =  $this->strip_tags($request->get('bizid'));
            //查询是否存在该wechatid
            $weixinuser = $this->getDoctrine()->getRepository('OradtStoreBundle:WeixinUser')->findOneBy( array('wechatId'=>$wechatid));
            if( empty($weixinuser) ){
                return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);//未关注微信
            }
            $sql_employee        = "SELECT id,role_id FROM wx_biz_employee WHERE open_id =:openId and  biz_id=:bizId and enable!=3 ";//enable=3离职状态
            $find_employee_Array  = array(':openId'=> $wechatid,':bizId'=> $bizid);
        }
        
        
        
        $employee_info       = $this->getConnection()->executeQuery($sql_employee,$find_employee_Array)->fetch();
        $emp_id=$employee_info["id"];
         
        if( empty($employee_info) ){
            return $this->renderJsonFailed(Errors::$ERROR_ACCOUNT_NOEXISTS);//员工不存在
        }
        
        $wxBizService = $this->container->get('wx_biz_service');
        
        if($employee_info["role_id"]==1){//判断是否还有超级管理员(系统至少需要一个管理员)
            $check_roleid = $wxBizService->checkIfLastOneSuperRole($emp_id,$bizid); 
            if (0 == $check_roleid) {
                return $this->renderJsonFailed(Errors::$WX_BIZ_ERROR_ROLE_LAST); 
            }
        }
        
        $empObj = $this->getDoctrine()->getRepository('OradtStoreBundle:WxBizEmployee')->findOneBy(  array('id'=>$emp_id));
        
        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();
        try {   
            $empObj->setBak("");
            $empObj->setAccountNo("");
            $empObj->setEnable(3);//设置为离职
            $em->persist($empObj);
            $em->flush();
       
            // 如果员工离职需要清除common记录 
            $empid=$empObj->getId();
            $wxBizService->dealWithCommonByEmpid($empid);
        
            $em->getConnection()->commit();
            return $this->renderJsonSuccess();
        } catch (\Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }
        
        
         
    }
    
    

    /**
     * 修改账号信息
     */
    public function _edit_user_common(){
        $this->checkAccountV2();//权限检查
        $accountNo=$this->accountNo;
        $request  = $this->getRequest();  
        $username  = $this->strip_tags($request->get('username'));//用户名
        $email  = $this->strip_tags($request->get('email'));//email
        $password  = $this->strip_tags($request->get('password'));//密码
        $newpwd  = $this->strip_tags($request->get('newpwd'));//新密码
        	
        if(empty($password) &&(empty($username)||empty($email)||empty($newpwd))){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
    
        //查询是否有用户
        $find_arr["accountNo"]=$accountNo; 
        $user_common =  $this->em->getRepository('OradtStoreBundle:UserCommon')->findOneBy($find_arr); 
        
        if(empty($user_common)){
            return $this->renderJsonFailed(Errors::$ERROR_ACCOUNT_NOEXISTS);
        }
        $pwd=$user_common->getPassword(); 
        $password  = Password::encrypt($password);
        if($password!==$pwd){
            return $this->renderJsonFailed(Errors::$ACCOUNT_BASIC_OLD_PASSWD);
        }
        
        //更新密码
        $new_pass = Password::encrypt($password); 
        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();
        try {
        	$modifyTime = $this->getTimestamp();
        	if(!empty($username))
        	   $user_common->setUserName($username);
        	if(!empty($email))
        	    $user_common->setEmail($email);
        	if(!empty($newpwd))
        	    $user_common->setPasswd($newpwd);
        	$user_common->setModifyTime($modifyTime);
        	$em->persist($user_common);
        	$em->flush();
        	$em->getConnection()->commit();
        } catch (\Exception $ex) {
        	$em->getConnection()->rollback();
        	    throw $ex;
        }
        	 
        return $this->renderJsonSuccess();
    }
    
    
    /**
     * 找回密码（修改密码）
     */
    public function _resetpassword(){
   
    	$request  = $this->getRequest();
    	$messageid       = $this->strip_tags($request->get('messageid'));//短息ID
    	$code       = $this->strip_tags($request->get('code'));//验证码
    	$mobile  = $this->strip_tags($request->get('mobile'));//手机号码
    	$password  = $this->strip_tags($request->get('password'));//密码
 	 
    	if( empty($messageid) || empty($code)|| empty($mobile)|| empty($password) ){
    		return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
    	}  
    	 
    	//查询是否有用户
    	$sql_employee        = "SELECT id FROM wx_biz_employee WHERE mobile =:mobile and enable!=3 ";//enable=3离职状态
    	$find_employee_Array  = array(':mobile'=> $mobile);
    	$is_employee       = $this->getConnection()->executeQuery($sql_employee,$find_employee_Array)->fetch(); 
    	$emp_id=$is_employee["id"];
    	// 按断id是否存在
    	if (empty($emp_id)) {
    		return $this->renderJsonFailed(Errors::$ERROR_ACCOUNT_NOEXISTS);
    	} 
    	
    	//查询是否有短信
    	$sql        = "SELECT sms_id,content,use_status,fseq_id FROM sms_message WHERE sms_id =:sms_id ";
    	$findArray  = array(':sms_id'=> $messageid);
    	$data_sms       = $this->getConnection()->executeQuery($sql,$findArray)->fetch(); 
    	 
    	if( !$data_sms ){
    		return $this->renderJsonFailed(Errors::$ERROR_HR_DATA_NOT_EXIST_ERROR);//没有短信信息
    	}elseif($data_sms["content"]!=$code){
    		return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_VERIFY_CODE);//验证码是否正确
    	}
    	elseif($data_sms["use_status"]==2){
    		return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_CODE_EXPIRED);//验证码已经使用过
    	}else{
    		$lastTime   = $data_sms['fseq_id'];        //fsegid 该参数 存的time()
    		$nowTime    = time();
    		$strtotime  = $lastTime +  Codes::PASSWDRESET_VERIFY_SMS_EXPIRE_TIME;    // 
    		//如果当前时间 < 验证码生成时间+验证时间长度  则不允许发送返回最新一条记录
    		if($nowTime > $strtotime){
    			return $this->renderJsonSuccess(Errors::$ERROR_MESSAGE_HAS_BEEN_EXPIRED);//验证码过期
    		}
    	}
    	 
    	//更新短信发送状态
    	$params = array(
    			':use_status'     => 2,
    			':sms_id'		  =>$messageid
    	);
    	$updateQuery = "update sms_message  set use_status=:use_status where sms_id =:sms_id ";    
    	$this->getConnection()->executeQuery($updateQuery , $params);
    	 
    	//更新密码
    	$new_pass = Password::encrypt($password); 
    	$empObj = $this->getDoctrine()->getRepository('OradtStoreBundle:WxBizEmployee')->findOneBy(  array('id'=>$emp_id));
    	$em = $this->getDoctrine()->getManager(); //添加事物
    	$em->getConnection()->beginTransaction();
    	try {
    		$modifyTime = $this->getTimestamp();
    		$empObj->setPasswd($new_pass); 
    		$empObj->setModifyTime($modifyTime);
    		$em->persist($empObj);
    		$em->flush();
    		$em->getConnection()->commit(); 
    	} catch (\Exception $ex) {
    		$em->getConnection()->rollback();
    		throw $ex;
    	}
    	/* $updateQuery = "update wx_biz_employee  set passwd=:passwd  where moblie=  ";
    	$this->getConnection()->executeQuery($updateQuery , $params); */ 
     	 
    	return $this->renderJsonSuccess();
    }
    /**
     * @todo 删除员工
     */
    private function _delemployee()
    {
        $this->checkAccountV2();//权限检查
        $bizId = $this->bizId;  //企业ID 
        $roleid = $this->roleId;   //角色ID
        //判断是否有权限
        if (empty($roleid) || !in_array($roleid, array(1,2))) {
            return $this->renderJsonFailed(Errors::$ERROR_NOT_HAVE_PERMISSION);
        }
        
        $request  = $this->getRequest();
        $emp_id       = $this->strip_tags($request->get('emp_id'));//删除员工ID
        
        if( empty($emp_id)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        
        $empids = explode(',', $emp_id);
        if (count($empids)==1){
           
            $empObj = $this->getDoctrine()->getRepository('OradtStoreBundle:WxBizEmployee')->findOneBy(  array('id'=>$emp_id,'bizId'=>$bizId,'isDel'=>0));
            if( empty($empObj)){
                return $this->renderJsonFailed(Errors::$ERROR_ACCOUNT_NOEXISTS);
            }  
            // 删除
            $em = $this->getDoctrine()->getManager(); //添加事物
            $em->getConnection()->beginTransaction();
            try {
                $empObj->setEnable(3);//删除肯定已经离职
                $empObj->setIsDel(1);
        		$em->persist($empObj);
        		$em->flush();
                $em->getConnection()->commit();
                $returnArr = array( 'emp_id'=>$emp_id);          //返回数组
                //删除账号 登录账号和微信绑定的企业ID
                $wxBizService = $this->container->get("wx_biz_service");
                $wxBizService->dealWithCommonByEmpid($emp_id);
               
                return $this->renderJsonSuccess($returnArr);
            } catch (\Exception $ex) {
                $em->getConnection()->rollback();
                throw $ex;
            }
        }else{//批量删除
            $wxBizService = $this->container->get("wx_biz_service");
            $wechatService = $this->container->get("wechat_service");
            $em = $this->getDoctrine()->getManager(); //添加事物
            $em->getConnection()->beginTransaction();
            //批量删除员工
            try {
                $modifyTime = $this->getTimestamp();
                // 添加员工登录信息
                foreach ($empids as $eid) {
                    if (empty($eid))
                        continue ;
                    $empObj = $this->getDoctrine()->getRepository('OradtStoreBundle:WxBizEmployee')->findOneBy( array('id'=>$eid,'bizId'=>$bizId,"isDel"=>0));
                    if (empty($empObj)) {
                        $fail[] = $eid;
                        continue ;
                    }
                    //删除账号 
                    $wxBizService->dealWithCommonByEmpid($eid); 
                    
                    $empObj->setIsDel(1);
            		$em->persist($empObj);
            		$em->flush();
                    $succ[] = $eid;
                }
                $em->getConnection()->commit();
                $returnArr = array( 'fail'=>$fail,'succ'=>$succ);          //返回数组
                return $this->renderJsonSuccess($returnArr);
            } catch (\Exception $ex) {
                $em->getConnection()->rollback();
                throw $ex;
            }
        }
        
    }
    
    
    /**
     * @todo 获取账户信息  
     */
    private function _getUserCommon()
    {
        $account_no=$this->accountNo;
        $where   = " a.account_no='$account_no'";
        $sqldata = array(
            'fields' => array(
                'id'          => array('mapdb' => 'a.id' , 'w' => ' AND a.id = :id'),
                'account_no'  => array('mapdb' => 'a.account_no' , 'w' => ' AND a.account_no = :account_no'),
                'username'     => array('mapdb' => 'a.username', 'w' => ' AND a.username = :username'),
                'mobile'     => array('mapdb' => 'a.mobile', 'w' => ' AND a.mobile = :mobile'),
                'email'     => array('mapdb' => 'a.email', 'w' => ' AND a.email = :email'),
                'password'    => array('mapdb' => 'a.password'),
                'biz_id'        => array('mapdb' => 'b.biz_id'),
                'biz_name'        => array('mapdb' => 'c.biz_name'),
                'wechat_path'   => array('mapdb' => 'c.wechat_path'),
                'wechat_id'     => array('mapdb' => 'a.wechat_id', 'w' => ' AND a.wechat_id = :wechat_id'),
                'union_id'     => array('mapdb' => 'a.union_id', 'w' => ' AND a.union_id = :union_id'), 
                'status'      => array('mapdb' => 'a.status', 'w' => ' AND a.status = :status'),
                're_from'       => array('mapdb' => 'a.re_from'),
                'createdtime' => array('mapdb' => 'a.create_time' , 'w' => 'Range'),
                'modifytime'  => array('mapdb' => 'a.modify_time' , 'w' => 'Range'), 
            ),
            'default_dataparam' => array(),
            'sql'   => "SELECT %s FROM `user_common` as a  
                        left join `wx_biz_employee` b on a.account_no=b.account_no
                        left join `wx_biz` c on b.biz_id=c.biz_id
                        %s%s",
            'where' => "".$where,
            'order' => '',
            'provide_max_fields' => 'id,account_no,username,mobile,email,biz_name,wechat_path,wechat_id,union_id,status,re_from,createdtime,modifytime',
        ); 
        $check = $this->parseSql($sqldata);
      
        if(true !== $check){
            return $this->renderJsonFailed($check);
        }
        $data = $this->getData($sqldata,'list');
        return $this->renderJsonSuccess ( $data );
    }
}
