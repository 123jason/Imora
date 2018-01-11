<?php

/**
 * 鉴权接口
 */

namespace Oradt\ServiceBundle\Services;

use Doctrine\ORM\EntityManager;
use Oradt\StoreBundle\Entity\LoginSession;
use Oradt\StoreBundle\Entity\AccountBasicLoginRecord;
use Oradt\StoreBundle\Entity\AccountBizLoginRecord;
use Oradt\StoreBundle\Entity\AccountEmployeeLoginRecord;
use Oradt\Utils\RandomString;
use Oradt\Utils\Password;
use Oradt\Utils\Codes;
use PDO;

/**
 * 用户service，获取账号的信息
 *
 * @author zhiqiang xie <xiezq@oradt.con>
 * @date 2014-08-13
 */
class OauthService extends BaseService
{
    /**
     * 
     * @var 记录登陆日志
     */
    public $upLogininfo = true;

    //private $em;
    private $logger;
    
    public $deviceId='';
    
    //private $container;

    // token有效时间(秒)

    /**
     * __construct
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager, $logger, $container)
    {
        //$this->em = $entityManager;
        $this->logger = $logger;
        //$this->container = $container;
        parent::__construct($container);
    }
    
    /**
     * 根据用户名取账号信息
     */
    public function getAccountInfo($username,$type=self::ACCOUNT_BASIC){
        $functionService = $this->container->get('functionService');
        $userarr = array();
        switch ($type) {
            case self::ACCOUNT_BASIC://基本账户
                $res['query'] = 'OradtStoreBundle:AccountBasic';
                if (!$functionService->checkTelephone($username)) {
                    $res['queryParams'] = array('email' => $username);
                } else {
                    $res['queryParams'] = array('mobile' => $username);
                }
                $user = $this->em->getRepository($res['query'])->findOneBy($res['queryParams']);
                if(!empty($user)){
                    $userarr['accountid'] = $user->getUserId();
                    $userarr['base'] = $user;
                }
                break;
            case self::ACCOUNT_BIZ://企业账户
                $res['query'] = 'OradtStoreBundle:AccountBiz';
                $res['queryParams'] = array('userName' => $username);
                $user = $this->em->getRepository($res['query'])->findOneBy($res['queryParams']);
                if(!empty($user)){
                    $userarr['accountid'] = $user->getBizId();
                    $userarr['base'] = $user;
                }
                break;
            case self::ACCOUNT_ADMIN://管理员账户email登录
                $res['query'] = 'OradtStoreBundle:AccountEmployee';
                $res['queryParams'] = array('email' => $username);
                $user = $this->em->getRepository($res['query'])->findOneBy($res['queryParams']);
                if(!empty($user))
                {
                    $userarr['accountid'] = $user->getEmplId();
                    $userarr['base'] = $user;
                }
                break;
            default:
                break;
        }
        if(!isset($userarr['accountid']))
            return false;
        return $userarr;
    }
    
    /**
     * 验证用户名密码是否正确
     * @param type $username
     * @param type $password
     * @param type $type
     * @return type
     */
    public function initGetLoginToken($username, $password, $type, $mcode = null)
    {
        $functionService = $this->container->get('functionService');
        $random = new RandomString();
        $type = strtolower($type);
        $res = array();
        $userarr = array();
        //根据帐户类型，创建查询语句、保存帐户类型
        switch ($type) {
            case self::ACCOUNT_BASIC://基本账户
                $res['query'] = 'OradtStoreBundle:AccountBasic';
                if (!$functionService->checkTelephone($username)) {
                    $res['queryParams'] = array('email' => $username);
                } else {
                    $res['queryParams'] = array('mcode'=>$mcode,'mobile' => $username);
                }
                $user = $this->em->getRepository($res['query'])->findOneBy($res['queryParams']);
                if(!empty($user) && $user->getStatus()==='active')
                {                    
                    $userarr['accountid'] = $user->getUserId();
                    $userarr['password'] = $user->getPassword();
                    $userarr['status'] = $user->getStatus();
                    //$userarr['ifmissing'] = $user->getIfmissing();
                    $userarr['ifmissing'] = 0;
                    //获取当前绑定设备的丢失状态(ifmissing)默认0正常,且绑定状态为1：绑定
                    $sql="SELECT ifmissing FROM account_basic_bingorange WHERE user_id = :userId AND `status` = 1 ORDER BY id DESC LIMIT 1;";
                    $bingOrange = $this->getConnection()->executeQuery($sql,array(':userId'=>$userarr['accountid']))->fetch();
                    if(!empty($bingOrange)){
                        $userarr['ifmissing'] = $bingOrange['ifmissing'];
                    }
                }
                break;
            case self::ACCOUNT_BIZ://企业账户
                $res['query'] = 'OradtStoreBundle:AccountBiz';
                $res['queryParams'] = array('userName' => $username);
                $sql  = "SELECT * FROM `account_biz` WHERE user_name=:userName ";
                $user = $this->getConnection()->executeQuery($sql, array(':userName' => $username))->fetchAll();
                $res['queryParams'] = array('userName' => $username);
                if( !empty($user) )
                {
                    $user = $user[count($user)-1];
                    // if (!in_array($user->getStatus(),array('deleted'))) {
                    //     $userarr['accountid'] = $user->getBizId();
                    //     $userarr['password'] = $user->getPassword();
                    //     $userarr['status'] = $user->getStatus();
                    //     $userarr['unlimited'] = $user->getUnlimited();
                    //     $userarr['type']  = 1;
                    // } 
                    if (!in_array($user['status'],array('deleted'))) {
                        $userarr['accountid'] = $user['biz_id'];
                        $userarr['password'] = $user['password'];
                        $userarr['status'] = $user['status'];
                        $userarr['unlimited'] = $user['unlimited'];
                        $userarr['type']  = 1;
                    }else{
                        return -3;
                    }                    
                }else{
                    $user = $user = $this->em->getRepository('OradtStoreBundle:AccountBizEmployeeLogin')
                   ->findOneBy(array('email'=>$username));
                   if (!empty($user)) {
                       $userarr['accountid'] = $user->getEmpid();
                        $userarr['password'] = $user->getPasswd();
                        $userarr['status'] = $user->getStatus();
                        $userarr['type']  = 2;
                   }
                }
                break;
            case self::ACCOUNT_ADMIN://管理员账户email登录
                $res['query'] = 'OradtStoreBundle:AccountEmployee';
                $res['queryParams'] = array('email' => $username);
                $user = $this->em->getRepository($res['query'])->findOneBy($res['queryParams']);
           
                if(!empty($user) )
                {
                    $userarr['accountid'] = $user->getId();
                    $userarr['password'] = $user->getPassword();
                    $userarr['status'] = $user->getStatus();
                }
                break;
            default:
                break;
        }
        if(!isset($userarr['accountid'])){
            return -1;
        }
        // 已停用|锁定
        if ('inactive'===$userarr['status'] || 'blocked' === $userarr['status']) {
            return -5;
        }
        // 已删除
        if($userarr['status'] === 'deleted'){
            return -3;
        }
        //未激活
        if (isset($userarr['unlimited']) && 'false' === $userarr['unlimited']) {
            return -4;
        }
        // 密码错误
        if($userarr['password'] !== $password){
            $data = array(
                'accountid'=>$userarr['accountid'],
                'error'    =>-2
                );
            return $data;
        }else{
            // 密码正确判断是否锁定
            $data = array(
                'accountid'=>$userarr['accountid'],
                'type'     => 'login',
                'success'  =>1
            );
            $error = $this->getError($data);
            if (!empty($error)) {
                $res = $this->checkErrorTime($data,$error);
                if (5 == $res) {
                    return -6;
                }
            }
        }
        // 帐户类型
        $userarr['accounttype'] = $type;
        unset($userarr['password']);

        return $userarr;
    }

    /**
     * 根据登录类型获取对应模型
     * @access public 
     * @param string $username 用户名、password 密码、$type 帐户类型
     * @param string $ismd5  是否是md5的密码 
     * @return null|token 用户名、密码错误时，返回null，否则返回token
     */
    public function getLoginToken($username, $password, $type, $ip = null, $mcode = null, $device = "",$ismd5="")
    {
        if(empty($ismd5)){
            $pwd = new Password();
            $password = $pwd->encrypt(trim($password));
        }
        // 初始化, 获取用户信息查询的SQL、新token
        $init = $this->initGetLoginToken($username, $password, $type, $mcode);
        //不是数组则登陆失败
        if(!is_array($init))
            return $init;
        if (is_array($init) && isset($init['error'])) 
            return $init;
        if($type === "basic"){
            return $this->setLoginSession($init['accountid'],$type,$init['status'],$ip,$init['ifmissing'],$device);
        }elseif ($type == 'admin') {
            return $this->setLoginSession($init['accountid'],$type,$init['status'],$ip,0,$device);
        }else{
            return $this->setLoginSession($init['accountid'],$type,$init['status'],$ip,0,$device,'',$init['type']);
        }
    }
    
    /**
     * 根据手机号登陆获取tooken
     * @access public 
     * @param string $username  用户名
     * @param string $ip        ip
     * @param string $mcode     区号
     * @param string $device    登陆设备类型
     * @return null|token 用户名、密码错误时，返回null，否则返回token
     */
    public function getSmsLoginToken($username, $ip = null, $mcode = null, $device = "")
    {
        // 初始化, 获取用户信息查询的SQL、新token
        $init         = array();
        $queryParams  = array('mcode'=>$mcode,'mobile' => $username);
        $user         = $this->em->getRepository("OradtStoreBundle:AccountBasic")->findOneBy($queryParams);
        if(!empty($user) && $user->getStatus()==='active'){                    
            $init['accountid']  = $user->getUserId();
            $init['status']     = $user->getStatus();
            $init['ifmissing']  = $user->getIfmissing();
            $init['password']   = $user->getPassword();
        }
        if(!isset($init['accountid'])){
            return -1;
        }
        if($init['status'] === 'deleted'){
            return -2;
        }
        return $this->setLoginSession($init['accountid'],self::ACCOUNT_BASIC,$init['status'],$ip,$init['ifmissing'],$device,$init['password']);
    }

    public function getLoginCacheKey($token) {
        return 'login_userid:' . $token;
    }
    
    /**
     * 获取用户信息,验证请求信息是否鉴权成功
     * @access public 
     * @param string $token 鉴权token
     * @return array null | userInfo  token无效、过期，返回null，
     * 否则更新token有效期，返回对应登录用户信息
     */
    public function getUserInfo($token = '')
    {
        $time = time();
        if (!empty($token)) {            
            try{
                /* 读取redis 登陆用户信息*/
                $redis = $this->container->get("predis_service");
                if($redis->isActive()){  
                    if($redis->exists($this->getLoginCacheKey($token))){
                        $loginInfo = $redis->hgetall($this->getLoginCacheKey($token));                
                        $strtotime = $loginInfo['created_time'];
                        $login = new LoginSession();
                        $login->setAccountId($loginInfo['account_id']);
                        $login->setAccountType($loginInfo['account_type']);
                        $login->setSessionId($token);
                        // $login->setDeviceType($loginInfo['device_type']);
                        $login->setCreatedTime($loginInfo['created_time']);
                        // $login->setDeviceId($loginInfo['device_id']);
                        //print_r($login);
                        if($time<$strtotime)
                            return $login;
                    }
                }
            }catch(\Exception $ex){
                $this->baseLogger->err(__FILE__ . __LINE__ . ":" .$ex->getMessage());
            }
            /* mysql  */
            // 获取该token对应登录用户信息
            /*$tokenInfo = $this->em->getRepository('OradtStoreBundle:LoginSession')
            ->findOneBy(array('sessionId' => $token));*/
            $sql = "SELECT * FROM `login_session` WHERE session_id=:token LIMIT 1";
            $tokenInfo = $this->getConnection()->executeQuery($sql, array(':token' => $token))->fetch();
            // 如果找到token对应用户信息且token未过期，更新token过期时间，返回用户信息，否则返回null
            if (!empty($tokenInfo)) {
                $strtotime = $tokenInfo['created_time'];
                if ($time < $strtotime) {
                    $login = new LoginSession();
                    $login->setAccountId($tokenInfo['account_id']);
                    $login->setAccountType($tokenInfo['account_type']);
                    $login->setSessionId($token);
                    $login->setCreatedTime($tokenInfo['created_time']);
                    // $login->setIfmissing($tokenInfo['ifmissing']);
                    // $login->setDeviceType($tokenInfo['device_type']);
                    // $login->setDeviceId($tokenInfo['device_id']);
                    return $login;
                }
            }
            
            return null;
        }
        return null;
    }
    public function getUserInfoV2($token = '')
    {
        $time = time();
        if (!empty($token)) {
            try{
                /* 读取redis 登陆用户信息*/
                $redis = $this->container->get("predis_service");
                if($redis->isActive()){
                    if($redis->exists($this->getLoginCacheKey($token))){
                        $loginInfo = $redis->hgetall($this->getLoginCacheKey($token));
                        $strtotime = $loginInfo['created_time'];
                        $login = new LoginSession();
                        $login->setAccountId($loginInfo['account_id']);
                        $login->setAccountType($loginInfo['account_type']);
                        $login->setSessionId($token);
                        $login->setCreatedTime($loginInfo['created_time']);
                        //print_r($login);
                        if($time<$strtotime)
                            return $login;
                    }
                }
            }catch(\Exception $ex){
                $this->baseLogger->err(__FILE__ . __LINE__ . ":" .$ex->getMessage());
            }
            /* mysql  */
            // 获取该token对应登录用户信息
            /*$tokenInfo = $this->em->getRepository('OradtStoreBundle:LoginSession')
            ->findOneBy(array('sessionId' => $token));*/
            $sql = "SELECT * FROM `login_session` WHERE session_id=:token LIMIT 1";
            $tokenInfo = $this->getConnection()->executeQuery($sql, array(':token' => $token))->fetch();
            // 如果找到token对应用户信息且token未过期，更新token过期时间，返回用户信息，否则返回null
            if (!empty($tokenInfo)) {
                $strtotime = $tokenInfo['created_time'];
                if ($time < $strtotime) {
                    $login = new LoginSession();
                    $login->setAccountId($tokenInfo['account_id']);
                    $login->setAccountType($tokenInfo['account_type']);
                    $login->setSessionId($token);
                    $login->setCreatedTime($tokenInfo['created_time']);
                    return $login;
                }
            }

            return null;
        }
        return null;
    }
    /**
     * 设置account_basic_bingorange 中 ifmissing 为 0
     * @param  string $accountId  账号id
     */
    public function setBingOrangeIfmissing($accountId){
        $sql="SELECT id,ifmissing FROM account_basic_bingorange WHERE user_id = :userId AND `status` = 1 ORDER BY id DESC LIMIT 1;";
        $bingOrange = $this->getConnection()->executeQuery($sql,array(':userId'=>$accountId))->fetch();
        if(!empty($bingOrange) && $bingOrange['ifmissing'] == '4'){
            $sql ="UPDATE account_basic_bingorange SET ifmissing=0 WHERE id=:id";
            $this->getConnection()->executequery($sql, array(':id' =>$bingOrange['id']));
        }
        return true;
    }

    /**
     * 登录时判断 之前是否有有效的token 有 刷新token 并发消息提示
     * @param  string $accountId  账号id
     */
//    public function findOldLoginSession($accountId){
//        $findArr = array(':userId'=>$accountId);
//        $sql="SELECT session_id,account_id,created_time,device_type FROM login_session WHERE device_type IN ('ios','android','web','') AND account_id =:userId order by id DESC;";
//        $tokenCon = $this->getConnection()->executeQuery($sql,$findArr)->fetchAll();
//        if(!empty($tokenCon)){
//            //删除掉数据
//            $deMapSql = "delete from `login_session` where device_type IN ('ios','android','web','') AND account_id =:userId";
//            $this->getConnection()->executeQuery($deMapSql,$findArr);
//            //暂时将删除的token 记录下来 
//            foreach ($tokenCon as $row){
//                $this->insertdeltokenLog($row['session_id'],$row['account_id'],$row['device_type']);//记录日志
//            }
//        }
//    }
    /**
     * 删除除橙子外且登录设备为当前设备$device 的其他token 即：web\android\ios 等只能一个在线 其他被挤下去
     * 登录时判断 之前是否有有效的token 有 刷新token 并发消息提示
     * @param  string $accountId    账号id
     * @param  string $device       登录设备
     */
    public function findOldLoginSession($accountId,$device){
        $findArr = array(':userId'=>$accountId);
        $sql="SELECT session_id,account_id,created_time,device_type FROM login_session WHERE device_type NOT IN ('orange','{$device}') AND account_id =:userId order by id DESC;";
        $tokenCon = $this->getConnection()->executeQuery($sql,$findArr)->fetchAll();
        if(!empty($tokenCon)){
            //删除掉数据
            $deMapSql = "delete from `login_session` where device_type NOT IN ('orange','{$device}') AND account_id =:userId";
            $this->getConnection()->executeQuery($deMapSql,$findArr);
            //暂时将删除的token 记录下来 
            foreach ($tokenCon as $row){
                $this->insertdeltokenLog($row['session_id'],$row['account_id'],$row['device_type']);//记录日志
            }
        }
    }
    //暂时记录下 删除token 的日志 方便token 丢失查找
    public function insertdeltokenLog($sessionId,$accountId,$devicetyp) {
        $sql = "INSERT INTO api_statistic (user_id, api_name, method, date_time, call_times, parameter)
                VALUES (:userId, :type, :method, :times, :call_times, :parameter)";
        $param = array('userid'=>$accountId,'devicetyp'=>$devicetyp);
        $parameter = json_encode(array_merge_recursive($param,$_REQUEST));
        $params = array(
                ':userId' => $sessionId,
                ':type'   => '/oauth',
                ':method' => 'post',
                ':times'  => $this->getTimestamp1(),
                ':call_times' => $this->getTimestamp1(),
                ':parameter'  => $parameter
        );
        $this->getManager('default')->getConnection()->executeQuery($sql,$params);
    }

    /**
     * @param string $passwd 账户密码 （smslogin登陆的时候返回）
     */
    public function setLoginSession($accountId,$type,$status,$ip,$ifmissing=0, $device,$passwd='',$flag=1){
        if( self::ACCOUNT_BIZ === $type ){
            $token = "Biz_".RandomString::make(36);
        }else{
            $token = RandomString::make(40);
        }
        //根据$accountId 和 $type
        $realName = $this->getUserRealName($accountId,$type);

        if($this->regtype == 2){
            $sql="UPDATE account_basic_detail SET reg_type=1 WHERE user_id=:userId";
            $this->em->getConnection()->executeUpdate($sql,array(':userId'=>$accountId));
        }
        //$redis = $redisService->getRedis();
        $findToken = array('accountId' => $accountId, 'accountType' => $type);
        if(self::ACCOUNT_BASIC === $type){
            $findToken['deviceType'] = '';
            if(!empty($device)){
                $findToken['deviceType'] = $device;
                if($device == 'orange'){
                    //如果橙子设备重新登陆，则ifmissing = 4 则将ifmissing 设置为正常状态
                    if($ifmissing == '4'){
                        $ifmissing = 0;
                        //如果当前用户绑定的橙子状态 ifmissing 为4  重新登陆后则修改为0 正常状态
                        $this->setBingOrangeIfmissing($accountId);
                    }
                }else{  //如果不是橙子设备登录则ifmissing为0
                    $ifmissing = 0;
                    //查找同一非橙子登录 $device 之前有没有登录的有效数据 如果有发送286 设备消息 
                    //$this->findOldLoginSession($accountId);
                }
            }else{
                $ifmissing = 0;
            }
        }
        //橙子设备状态检查
        if(!empty($this->deviceId)) {
            $findToken['deviceId'] = $this->deviceId;
        }
        // 用户登录过，更新token和token过期时间
        $tokenInfo = $this->em->getRepository('OradtStoreBundle:LoginSession')
        ->findOneBy($findToken);
        $createTime =  time() + Codes::TOKEN_EXPIRE_TIME;
        if (2 == $flag) {
            $bizEmployee = $this->em->getRepository('OradtStoreBundle:AccountBizEmployee')
            ->findOneBy(array('empId' => $accountId));
            if (!empty($bizEmployee)) {
                $bizsuperId = $bizEmployee->getBizId();
                $employeeid = $accountId;                        
            }
        }
        if (!empty($tokenInfo)) {
            if( self::ACCOUNT_BIZ === $type ){//biz                
                //保存之前登录数据到login_session_history
                $sql = "INSERT INTO `login_session_history`(session_id,account_id,account_type,logout_time) VALUES (:sessionid, :accountid, :type, :logouttime)";
                $params = array(
                            ':sessionid' => $tokenInfo->getSessionId(),
                            ':accountid' => $accountId,
                            ':type' => $type,
                            ':logouttime' => $this->getTimestamp()
                            );
                $this->getConnection()->executeQuery($sql, $params);
                //删除之前登录数据,清除redis缓存
                $this->removeCache($this->getLoginCacheKey($tokenInfo->getSessionId()));
                $this->em->remove($tokenInfo);
                $this->em->flush();
                
                //重新生成登录信息
                $bizInfo = new LoginSession();
                $bizInfo->setSessionId($token);
                $bizInfo->setAccountType($type);
                $bizInfo->setAccountId($accountId);
                // $bizInfo->setDeviceType($device);
                $bizInfo->setRealName($realName);
                $bizInfo->setCreatedTime($createTime);
                // $bizInfo->setIfmissing(0);
                // $bizInfo->setDeviceId('');
                $this->em->persist($bizInfo);
                $this->em->flush();
                
            }else{//basic、admin
                // 查看用户是否原来生产过token            
                if( intval($tokenInfo->getCreatedTime()) < time() ){
                    $tokenInfo->setSessionId($token);                    
                }else{
                    $token = $tokenInfo->getSessionId();                    
                }
                $tokenInfo->setCreatedTime($createTime);
                $tokenInfo->setRealName($realName);
                if(!empty($device)){
                	// $tokenInfo->setDeviceType($device);
                }
                // $tokenInfo->setDeviceId($this->deviceId);
                // $tokenInfo->setIfmissing($ifmissing);
                $this->em->persist($tokenInfo);
                $this->em->flush();
            }
        } else { // 未生成过token，新增一条记录
            $tokenInfo = new LoginSession();
            $tokenInfo->setSessionId($token);
            $tokenInfo->setAccountType($type);
            $tokenInfo->setAccountId($accountId);
            // $tokenInfo->setDeviceType($device);
            $tokenInfo->setRealName($realName);
            $tokenInfo->setCreatedTime($createTime);
            // $tokenInfo->setIfmissing($ifmissing);
            // $tokenInfo->setDeviceId($this->deviceId);
            $this->em->persist($tokenInfo);
            $this->em->flush();
        }
        try{
            //写redis     
            $redis = $this->container->get("predis_service");
            if($redis->isActive()){            
                $userKey='userid:' . $accountId;
                $key = $redis->hGet($userKey,'token');
                if(!empty($key)){
                    $redis->del($key);
                }
                $key = $this->getLoginCacheKey($token);
                $params = array(
                    'account_id' => $accountId,
                    'account_type' => $type,
                    'ifmissing' => $ifmissing,
                    'device_id' => $this->deviceId,
                    'device_type' => $device,
                    'created_time' => $createTime
                );
                $redis->hMset($userKey,array('token'=>$key));
                $redis->hMset($key,$params);
                $redis->expire($key,Codes::TOKEN_EXPIRE_TIME);
            } 
        }catch(\Exception $ex){
            $this->baseLogger->err(__FILE__ . __LINE__ . ":" .$ex->getMessage());
        }
        if (null !== $ip) {
            //设置登录日志
            if (2 == $flag) {
                $this->initLoginRecord('emp', $accountId, $ip);
            }else{
                $this->initLoginRecord($type, $accountId, $ip);
            }            
            //记录登陆日志
            $this->initLoginLog($type,$accountId,$device);
        }
        if($type==="basic"){
            $tokenArr = array('token' => $token,'status' =>$status,'accountId' => $accountId,'ifmissing'=>$ifmissing,'created_time'=>$createTime);
            if(!empty($passwd)){
                $tokenArr['passwd'] = $passwd;
            }
            return $tokenArr;
        }else{
            if (isset($employeeid) && !empty($employeeid)) {
                $reData = array('token' => $token,'status' =>$status,'accountId' => $accountId,'created_time'=>$createTime,'employeeid'=>$employeeid,'reg_type'=>1,'bizsuperid'=>$bizsuperId);
            }else{
                $reData = array('token' => $token,'status' =>$status,'accountId' => $accountId,'created_time'=>$createTime);
            }
            return $reData;
        }
    }

    public function setLoginSessionV2( $userInfo, $ip = null ,$accountType = ''){

        $token = RandomString::make(40);
        //根据$accountId 和 $type
        $realName = $userInfo["name"];
        $accountId = $userInfo["id"];
        $type = self::ACCOUNT_BIZ;
        $findToken = array('accountId' => $accountId, 'accountType' => $type);
        // 用户登录过，更新token和token过期时间
        $tokenInfo = $this->em->getRepository('OradtStoreBundle:LoginSession')
            ->findOneBy($findToken);
        $createTime =  time() + Codes::TOKEN_EXPIRE_TIME;

        $bizsuperId = $userInfo["biz_id"];

        if (!empty($tokenInfo)) {
            if( intval($tokenInfo->getCreatedTime()) < time() ){
                $tokenInfo->setSessionId($token);
            }else{
                $token = $tokenInfo->getSessionId();
            }
            $tokenInfo->setCreatedTime($createTime);
            $tokenInfo->setRealName($realName);
            $this->em->persist($tokenInfo);
            $this->em->flush();
        } else { // 未生成过token，新增一条记录
            $tokenInfo = new LoginSession();
            $tokenInfo->setSessionId($token);
            $tokenInfo->setAccountType($type);
            $tokenInfo->setAccountId($accountId);
            $tokenInfo->setRealName($realName);
            $tokenInfo->setCreatedTime($createTime);
            $this->em->persist($tokenInfo);
            $this->em->flush();
        }
        try{
            //写redis
            $redis = $this->container->get("predis_service");
            if($redis->isActive()){
                $userKey='wxuserid:' . $accountId;
                $key = $redis->hGet($userKey,'token');
                if(!empty($key)){
                    $redis->del($key);
                }
                $key = $this->getLoginCacheKey($token);
                $params = array(
                    'account_id' => $accountId,
                    'biz_id' => $bizsuperId,
                    'account_type' => $type,
                    'created_time' => $createTime
                );
                $redis->hMset($userKey,array('token'=>$key));
                $redis->hMset($key,$params);
                $redis->expire($key,Codes::TOKEN_EXPIRE_TIME);
            }
        }catch(\Exception $ex){
            $this->baseLogger->err(__FILE__ . __LINE__ . ":" .$ex->getMessage());
        }
        if (null !== $ip) {
            //记录登陆日志
            $this->initLoginLogV2($accountType,$accountId,$bizsuperId, $ip);
        }

        $reData = array('token' => $token,'accountId' => $accountId,'created_time'=>$createTime,'bizid'=>$bizsuperId);

        return $reData;
    }
    /**
     * 记录登陆日志（累加多条）
     * @param string $accountType   账户类型
     * @param string $accountId     账户ID
     * @param string $device        登陆设备
     */
    public function initLoginLog($type,$accountId,$device){
        if(!$this->upLogininfo) {
            return;
        }
        $logParams = array( 
            ':account_id'   => $accountId ,   
            ':account_type' => $type, 
            ':device_type'  => $device,
            ':created_time' => $this->getDateTime()->format("Y-m-d H:i:s")
        );
        $logQuery = "INSERT INTO login_log (account_id,account_type,device_type,created_time) 
                VALUES(:account_id,:account_type,:device_type,:created_time)";
        $this->getConnection()->executeUpdate($logQuery , $logParams);
    }
    public function initLoginLogV2($accountType,$accountId,$bizid, $ip){
        $logParams = array(
            ':account_id'   => $accountId ,
            ':account_type' => $accountType,
            ':biz_id'  => $bizid,
            ':login_ip'  => $ip,
            ':created_time' => $this->getDateTime()->format("Y-m-d H:i:s")
        );
        $logQuery = "INSERT INTO `wx_biz_login_log` (account_id,account_type,biz_id,login_ip,created_time)
                VALUES(:account_id,:account_type,:biz_id,:login_ip,:created_time)";
        $this->getConnection()->executeUpdate($logQuery , $logParams);
    }
    /**
     * 记录登录日志(一条)
     * @param type $init
     * @param type $accountId
     * @param type $ip
     */
    public function initLoginRecord($accountType, $accountId, $ip)
    {
        if(!$this->upLogininfo) {
            return;
        }
        if ($accountType == 'basic') {
            $entity = $this->em->getRepository('OradtStoreBundle:AccountBasicDetail')->findOneBy(array('userId' => $accountId));
            if (!empty($entity)) {
                $entity->setLastLoginIp($ip);
                $entity->setLastLoginTime($this->getTimestamp());
            }
            $entity->setLoginTime($this->getTimestamp());
        } elseif ($accountType == 'biz') {
            $entity = $this->em->getRepository('OradtStoreBundle:AccountBizLoginRecord')->findOneBy(array('bizId' => $accountId));
            if (empty($entity)) {
                $entity = new AccountBizLoginRecord();
                $entity->setBizId($accountId);
                $entity->setLastLoginIp($ip);
                $entity->setLastLoginTime($this->getDateTime());
            } else {
                $entity->setLastLoginIp($entity->getLoginIp());
                $entity->setLastLoginTime($entity->getLoginTime());
            }
            $entity->setLoginTime($this->getDateTime());
        } else if ('emp' ==$accountType) {
            return;
        } elseif ($accountType == 'admin') {
            $entity = $this->em->getRepository('OradtStoreBundle:AccountEmployeeLoginRecord')->findOneBy(array('emplId' => $accountId));
            if (empty($entity)) {
                $entity = new AccountEmployeeLoginRecord();
                $entity->setEmplId($accountId);
                $entity->setLastLoginIp($ip);
                $entity->setLastLoginTime($this->getDateTime());
            } else {
                $entity->setLastLoginIp($entity->getLoginIp());
                $entity->setLastLoginTime($entity->getLoginTime());
            }
            $entity->setLoginTime($this->getDateTime());
        }
        $entity->setLoginIp($ip);
        //$entity->setLoginTime($this->getDateTime());
        $this->em->persist($entity);
        $this->em->flush();
    }

    /**
     * 根据账号和账号类形，获取用户名称
     * 
     * @param string $userId
     * @param string $userType
     * @return string
     */
    private $regtype;
    public function getUserRealName($userId, $userType = '')
    {
        $userType = strtolower($userType);
        $realName = "";
        switch ($userType) {
            case "basic":
                $user = $this->em->getRepository("OradtStoreBundle:AccountBasicDetail")
                    ->findOneBy(array("userId" => $userId));
                if ($user) {
                    $realName = $user->getRealName();
                    $this->regtype = $user->getRegType();
                }
                break;

            case "biz":
                $user = $this->em->getRepository("OradtStoreBundle:AccountBizDetail")
                    ->findOneBy(array("bizId" => $userId));
                if ($user) {
                    $realName = $user->getBizName();
                }
                break;
            case "admin":
                $user = $this->em->getRepository("OradtStoreBundle:AccountEmployee")
                    ->findOneBy(array("emplId" => $userId));
                if ($user) {
                    $realName = $user->getRealName();
                }
                break;
            case '':
                $sql = "  SELECT real_name FROM account_basic_detail WHERE user_id=:userId LIMIT 1
                        UNION ALL
                        SELECT real_name FROM account_employee WHERE empl_id = :userId LIMIT 1
                        UNION ALL
                        SELECT biz_name AS real_name FROM account_biz_detail WHERE biz_id = :userId LIMIT 1";
                $conn = $this->container->get('database_connection');
                $sth = $conn->prepare($sql);
                $sth->bindValue(':userId', $userId, PDO::PARAM_STR);
                $sth->execute();
                $realName = $sth->fetchColumn();
        }

        return $realName;
    }

    /**
     * 根据账号ID 获取账号信息
     * 
     * @param string $userId
     * @return boolean|array
     */
    public function getUserById($userId)
    {
        if (empty($userId) || strlen($userId) !== 40)
            return false;
        $sql = "SELECT email AS userName,'basic' AS accountType FROM account_basic WHERE user_id=:userId LIMIT 1
            UNION ALL
            SELECT email AS userName,'admin' AS accountType FROM account_employee WHERE empl_id = :userId LIMIT 1
            UNION ALL
            SELECT user_name AS userName, 'biz' AS accountType FROM account_biz WHERE biz_id = :userId LIMIT 1";
        $conn = $this->container->get('database_connection');
        $sth = $conn->prepare($sql);
        $sth->bindValue(':userId', $userId, PDO::PARAM_STR);
        $sth->execute();
        $user = $sth->fetch();
        if (empty($user))
            return false;
        //
        return $user;
    }
    public function updateCommunicate($mobile,$mcode,$userid)
    {   
        $sql="UPDATE account_communicate SET status=:status,fuser_id=:userid WHERE mobile=:mobile AND mcode=:mcode";
        $num = $this->em->getConnection()->executeUpdate($sql,array(':userid'=>$userid,':mobile'=>$mobile,':mcode'=>$mcode,':status'=>2));
        if (0 != $num) {
            $sql="UPDATE contact_card SET from_uid=:fromuid WHERE uuid in(SELECT card_id FROM account_communicate WHERE mobile=:mobile AND mcode=:mcode )";
            $this->em->getConnection()->executeUpdate($sql,array(':fromuid'=>$userid,':mobile'=>$mobile,':mcode'=>$mcode)); 
        }
        return true;
    }
    
    /**
     * 
     * 丢失相关处理
     * 
     * @param String $token
     * @param String $userId
     * @param String $ifmissing   2:用丢失的tooken 拉过数据   4:橙子已清除数据
     * @param String $deviceId    设备id（登录设备id 和 绑定橙子设备id）
     */
    public function missingAction($token,$userId,$ifmissing,$deviceId) {
        $sql ="UPDATE login_session SET ifmissing={$ifmissing} WHERE session_id=:token "
        . "AND device_type=:dtype AND device_id=:deviceid";
        $this->getConnection()->executequery($sql, array(':token' => $token,':dtype'=>'orange',':deviceid'=>$deviceId));
//        $sql ="UPDATE account_basic SET ifmissing={$ifmissing} WHERE user_id=:userid";
//        $this->getConnection()->executequery($sql, array(':userid' =>$userId));
        //查询这个设备$deviceId 这个人最后的一条绑定信息 
        $sql="SELECT id,ifmissing FROM account_basic_bingorange WHERE user_id = :userId AND orauuid =:orauuid ORDER BY id DESC LIMIT 1;";
        $bingOrange = $this->getConnection()->executeQuery($sql,array(':userId'=>$userId,':orauuid'=>$deviceId))->fetch();
        if(!empty($bingOrange) &&  in_array($bingOrange['ifmissing'],array(1,3))){
            $sql ="UPDATE account_basic_bingorange SET ifmissing={$ifmissing} WHERE id=:id";
            $this->getConnection()->executequery($sql, array(':id' =>$bingOrange['id']));
        }
        if($ifmissing=='4'){
           //发送数据已清楚消息
            $messCon = array(
                'content'  => "您好，橙脉已帮您清除您丢失的Ora设备里面的数据，请您放心使用"
            );
            $this->pushMessage(280,$userId, $messCon, '',"数据清除通知"); 
        }
    }
    
    /**
     * @todo checkAccount 判断biz-token方法
     * @param $loginSession Obj 登录  
     * @param $accountid string 账号id
     * @author xinggm
     * @version 2017-6-26
     */
    public function checkBiz($loginSession,$accountid)
    {
        $globalBase = $this->container->get('global_base');
        $bizObj = $globalBase->findOneBy('AccountBiz',array('bizId'=>$accountid));//1
        if (empty($bizObj)) {
            $this->accountEmpId = $loginSession->getAccountId();
            //如果为空,查查是否为员工
            $empObj = $globalBase->findOneBy('AccountBizEmployee',array('empId'=>$accountid));
            if (empty($empObj)) {
                return 1;                
            }
            // 判断是否开启企业使用权限 如果enable ：2 没有登录权限
            $enable = $empObj->getEnable();
            if (2 == $enable) {
                return 2;                
            }
            $this->accountId = $empObj->getBizId();
        }
        return 3;
    }


    /**
     * -----------------------------------------------------------------------------------------------
     * @todo 合并errorservice 方便登录接口的整合
     * @author xgm                                                       
     * @version 2017-7-12
     * @example
     * @param  checkError
     * @param  addError
     * @param  putError
     * @param  getError
     * @param  checkErrorTime
     * @param  dealWithError1
     * @param  dealWithError2
     *------------------------------------------------------------------------------------------------
     */
    public function checkError($data)
    {
        $accountid = $data['accountid'];
        $type      = $data['type'];
        $result    = $this->getError($data);
        $time = $this->getTimestamp();
        if ('login' == $type) {
            $totalNum = 4;
        }else{
            $totalNum = 5;
        }
        if (empty($result)) {
            //添加
            $this->addError($data);
            $res = 1;
        }else{
            //修改
            $errornum = $result['error_num'];
            $status   = $result['status'];
            //0添加errornum一次或者锁定
            if (0 == $status) {            
                if ($errornum < ($totalNum-1)) {
                    $data['status'] = 0;
                    $data['errornum'] = $errornum+1;
                    $res = 1;
                }else{
                    $data['status'] = 1;
                    $data['errornum'] = $totalNum;
                    $res = 2;
                }
                // 错误累计不能再同一秒内发生
                if ($result['last_error_time'] != $time) {
                    $this->putError($data);
                }                
            }else{
            //status = 1 判断最后当前时间是否大于错误时间
                $res = $this->checkErrorTime($data,$result);
            }            
        }
        return $res;
    }
    /**
     * 添加
     */
    public function addError($data)
    {
        $sql = "INSERT INTO `account_basic_password_error`(user_id,error_num,status,last_login_time,last_error_time,lock_time,type) VALUES (:userid, :errornum, :status, :logintime,:errortime,:locktime,:type)";
        if ('login' == $data['type']) {
            $type = 1;
        }else{
            $type = 2;
        }
            $params = array(
                ':userid'    => $data['accountid'],
                ':errornum'  => 1,
                ':status'    => 0,
                ':logintime' => $this->getTimestamp(),
                ':errortime' => $this->getTimestamp(),
                ':locktime'  => $this->getTimestamp(),
                ':type'      => $type,
                );
        $this->getConnection()->executeQuery($sql, $params);
    }
    /**
     * 修改
     */
    public function putError($data)
    {
        $errornum = $data['errornum'];
        $status   = $data['status'];
        $type     = $data['type'];
        if ('login' == $type) {
            $wt = 1;
        }else{
            $wt = 2;
        }
        $sql="UPDATE account_basic_password_error SET status=:status,error_num=:errornum,last_login_time=:logintime,last_error_time=:errortime,lock_time=:locktime WHERE user_id=:accountid AND type = :type";
        $params = array(
            ':errornum'  => $errornum,
            ':status'    => $status,
            ':logintime' => $this->getTimestamp(),
            ':errortime' => $this->getTimestamp(),
            ':locktime'  => $this->getTimestamp(),
            ':accountid' => $data['accountid'],
            ':type'      => $wt
            );
        $this->em->getConnection()->executeUpdate($sql,$params);
    }
    /**
     * 获得
     */
    public function getError($data)
    {
        $accountid = $data['accountid'];
        $type      = $data['type'];
        if ('login' == $type) {
            $wt = 1;
        }else{
            $wt = 2;
        }
        $sql = "SELECT * FROM `account_basic_password_error` WHERE user_id=:accountid AND type=:type LIMIT 1";
        $error = $this->getConnection()->executeQuery($sql, array(':accountid' => $accountid,":type"=>$wt))->fetch();
        return $error;
    }
    /**
     * 判断时间
     */
    public function checkErrorTime($data,$error)
    {
        $currentime = $this->getTimestamp();
        $errortime  = $error['last_error_time'];    
        $chatime    = $currentime - $errortime;        
        $success   = isset($data['success'])?$data['success']:0;
        //十分钟之后才可以登录
        switch ($success) {
            case 0:
                $res = $this->dealWithError2($data,$chatime,$error);
                break;
            case 1:
                $res = $this->dealWithError1($data,$chatime,$error);
                break;
            default:
                # code...
                break;
        }
        return $res;        
    }
    public function dealWithError1($data,$chatime,$error)
    {
        $status     = $error['status'];
        if ($chatime >= 600 || 0 == $status) {
            $data['status'] = 0;
            $data['errornum'] = 0;
            $this->putError($data);
            return 0;
        }else{
            return 5;
        }        
    }
    public function dealWithError2($data,$chatime,$error)
    {
        $status     = $error['status'];
        $errornum   = $error['error_num'];
        if ($chatime >= 600) {
            if (0 == $status && 0 == $errornum) {
                return 4;
            }else{
                $data['status'] = 0;
                $data['errornum'] = 1;
                $this->putError($data);
                return 1;
            }
        }else{
            return 5;
        }
    }
}
