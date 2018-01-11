<?php
/**
 * 
 * get name account_basic_service
 */
namespace Oradt\ServiceBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Oradt\StoreBundle\Entity\SecurityQuestionVerification;
use Oradt\Utils\Codes;
use Oradt\Utils\RedisTrait;
use Oradt\Utils\RandomString;
use Oradt\StoreBundle\Entity\AccountTagmap;
use Oradt\StoreBundle\Entity\AccountCommon;
use Oradt\StoreBundle\Entity\AccountBasicLockinfo;
use Oradt\Utils\Str2PY;
use Oradt\Utils\Password;
use Doctrine\Common\Cache\FilesystemCache;

class AccountBasicService extends BaseService {
    /**
     * 用户ID  cacheKey
     */
    public $cacheKey   = 'user:maxid' ;                   //最在用户ID缓存键名
    
    public function __construct(EntityManager $entityManager, ContainerInterface $container) {
        parent::__construct($container);
        if($this->container->getParameter('redis_key_pre')){
            $this->cacheKey .= '_'.$this->container->getParameter('redis_key_pre');
        }
        $this->em = $this->getManager("api");
    }
    
    /**
     * 
     * @var 好友消息来源模块
     */
    public $module='';
    
    /**
     * 获取user:maxid的值
     */
    public function getUserMaxid(){
        $maxId      = intval($this->getCache($this->cacheKey));
        if( 1 > $maxId) {
            $userArr    = $this->querySql('SELECT max(id) as uid FROM `account_basic` limit 1') ;       
            $maxId      = 1;
            if(!empty($userArr) && is_numeric($userArr['uid'])){
                $maxId = intval($userArr['uid']);  
            }
        }
        ++$maxId;
        return $maxId;
    }

    /**
     * 生成 accout_id 方法
     */
    public function createAccountId(){
        $userid  = RandomString::make ( 29 ,'A' );  //拼接userId   
        $maxId   = $this->getUserMaxid();
        $userid .= str_pad($maxId,11,'0',STR_PAD_LEFT);         //后11位为用户ID，不够长左边用0补齐，
        if (strlen ( $userid ) !== 40) {
            return FALSE;
        }
        return $userid; 
    }
    /**
     * 设置user:maxid 缓存值
     */
    public function setUserMaxidCache(){
        $maxId   = $this->getUserMaxid();
        $this->setCache($this->cacheKey,$maxId); 
    }

    /**
     * 拼接用户头像
     * @param string $avatarUrl
     * @return string
     */
    public function getAvatarUrl($avatarUrl)
    {
        
        if (!empty ( $avatarUrl ) && $avatarUrl!='null' ) {            
            $hostUrl = $this->container->getParameter("HOST_URL") . '/account/avatar?path=';
            if(strlen($avatarUrl)===40){
                return $hostUrl . $avatarUrl;
            }
            if ( 0 !==stripos ( $avatarUrl, Codes::SYSTEM_AVATAR_PRE )) {
                return $hostUrl . substr ( $avatarUrl, 13 );
            }
            else{
                return $hostUrl . $avatarUrl;
            }
        }else{
            return '';
        }
    }
    
    public function getAccount($account) {
        if(!filter_var($account, FILTER_VALIDATE_EMAIL))
        {
            return $this->getAccountFormMobile($account);
        }
        return $this->getAccountFormEmail($account);
    }
    
    /**
     * 用邮箱获取账号信息
     * @param unknown $email
     * @param string $status
     * @return unknown
     */
    public function getAccountFormEmail($email)
    {
        $findArray = array('email'=> $email);
        return $this->em->getRepository ( 'OradtStoreBundle:AccountBasic' )->findOneBy ($findArray);
    }
    /**
     * 用手机号获取账号信息
     * @param unknown $mobile
     * @param string $status
     * @return unknown
     */
    public function getAccountFormMobile($mobile) {
        $findArray = array (
                'mobile' => $mobile 
        );
        return $this->em->getRepository ( 'OradtStoreBundle:AccountBasic' )->findOneBy ( $findArray );
    }

    /**
     * 获取用户安全设置
     * @param unknown $userId
     * @return unknown
     */
    public function getAccountBasicSecurity($userId) {
        $findArray = array (
                'userId' => $userId
        );
        $repository = $this->em->getRepository ( 'OradtStoreBundle:SecurityQuestion' );
        $list = $repository->findOneBy ( $findArray );
        return $list;
    }
    
    /**
     * 获取用户安全设置
     * @param unknown $userId
     * @return unknown
     */
    public function getAccountBasicSecurityOneBy($findArray) {
       
        $repository = $this->em->getRepository ( 'OradtStoreBundle:SecurityQuestion' );
        return $repository->findOneBy ( $findArray );
    }
   
    
    /**
     * 更改账号状态
     * 
     * @param unknown $userId
     * @param unknown $status
     * @param tinyint $shared           是否共享 1：启用  2：禁用
     * @param tinyint $capacityswitch   名片无限容量开关 1：开  2：关
     * @return boolean
     */
    public function updateAccountStatus($userId,$status,$ifmissing = null,$snslock = null,$regtype = 0,$roleid = null,$shared=null,$capacityswitch=null){
        $code = 0;        
        $array = array('userId' => $userId);
        $accountbasic = $this->em->getRepository ( 'OradtStoreBundle:AccountBasic' )->findOneBy( $array );
        $basicDetail = $this->em->getRepository ( 'OradtStoreBundle:AccountBasicDetail' )->findOneBy( $array );
        if(empty($accountbasic)){
            $code = 1;
            return $code;
        }
        if(!empty($status)){
            $accountbasic->setStatus($status);
            if ('active' == $status) {
               if (!empty($basicDetail)) {
                   $basicDetail->setViolateCount(0);        //违规次数
               }
            }
        }
        if($ifmissing !== null && $ifmissing !== ''){
            $accountbasic->setIfmissing($ifmissing);
        }
        if(null != $snslock && in_array($snslock, array(0,1))){
            $time = $this->getTimestamp();
            $accountbasiclock = $this->em->getRepository ( 'OradtStoreBundle:AccountBasicLockinfo' )->findOneBy( $array );
            $violateCount = 0;
            if(empty($accountbasiclock))
            {
                $accountbasiclock = new AccountBasicLockinfo();
                $accountbasiclock->setUserId($userId);
                $accountbasiclock->setSnsLock($snslock);
                $accountbasiclock->setSnsLockTime($time);
                $accountbasiclock->setViolateCount($violateCount);
            }else{
                $violateCount = $accountbasiclock->getViolateCount();
                if (0 == $snslock) {
                    $violateCount = 0;
                }
            }
            $accountbasiclock->setSnsLock($snslock);
            $accountbasiclock->setSnsLockTime($time);
            $accountbasiclock->setViolateCount($violateCount);
            try{
            $this->em->persist ( $accountbasiclock );
            $this->em->flush ();
            }catch (\Exception $ex){throw $ex;}
        }

        if (in_array($regtype, array(4,5))) {
            $caKey = 'accountoftheservice';
            if (!empty($basicDetail)) {
                $reg_type = $basicDetail->getRegType();
                if (!empty($reg_type) && in_array($reg_type, array(4,5))) {
                    $basicDetail->setRegType($regtype);
                }else{
                    $code = 2;
                    return $code;
                }
            }
            // 删除缓存 
            // if($this->checkCacheKeyExists($caKey)){            
            //     $this->removeCache($caKey);
            // }
            $dir = $this->container->getParameter('kernel.cache_dir');
            $cache = new FilesystemCache($dir);
            $result = $cache->fetch("accountoftheservice");
            $cache->delete($caKey);
        }
        if (null != $roleid) {            
            /**
             * 现在支持一对一:一个虚拟账号只能被一个后台绑定。
             */              
            $customer = $this->em->getRepository ( 'OradtStoreBundle:AccountBasicCustomer' )->findOneBy( $array);
            if (!empty($customer)) {
                $code = 3;
                return $code;
            }else{
                $arr = array(
                    'emplId'=>$roleid,
                    );
                $employee = $this->em->getRepository ( 'OradtStoreBundle:AccountEmployee' )->findOneBy( $arr);
                if (empty($employee)) {
                    $code = 5;
                    return $code;
                }else{
                    $res = $this->insertOrUpdateBintime($userId,$roleid);
                    if (!$res) {
                        $code = 4;
                        return $code;
                    }
                }
            }                      
        }
        if($shared !== null && in_array($shared, array(1,2))){
            $basicDetail->setShared($shared);
        }
        if($capacityswitch !== null && in_array($capacityswitch, array(1,2))){
            $basicDetail->setCapacitySwitch($capacityswitch);
        }
        $this->em->persist ( $basicDetail );
        $this->em->flush ();
        $this->em->persist ( $accountbasic );
        $this->em->flush ();
        return $code;
    }
    /**
     * 添加绑定时间
     */
    /**
     * @param 
     * @return
     * @author xinggm 2016-4-26
     */
    public function insertOrUpdateBintime($userid,$roleid)
    {
        if (!empty($userid)) {
            $time  = $this->getTimestamp();
            /**
             * 首先查看admin是否绑定以账号---删除
             */
            $adminBin = $this->em->getRepository ( 'OradtStoreBundle:AccountBasicCustomer' )->findOneBy( array('adminId'=>$roleid) );
            if (!empty($adminBin)) {
                $sql    = "DELETE FROM `account_basic_customer` WHERE admin_id = :adminid";
                $params = array(':adminid'=>$roleid);
                $res    = $this->em->getConnection()->executeUpdate($sql,$params);
                if (!$res) {
                    return false;
                }
            }
            /**
             * 绑定新的虚拟账号
             */
            $array = array(
                'userId'=>$userid,
            );            
            $customer = $this->em->getRepository ( 'OradtStoreBundle:AccountBasicCustomer' )->findOneBy( $array );
            if (!empty($customer)) {
                $sql = "UPDATE  `account_basic_customer` set
                 `bintime` = :time,`admin_id`=:adminid where user_id = '".$userid."' ";
            }else{
                $sql = "INSERT INTO `account_basic_customer`
                (`user_id`, `bintime`,`admin_id`) VALUES (:userid, :time ,:adminid)";
                $params = array(':userid'=>$userid,);
            }
            $params[':time'] = $time;    
            $params[':adminid'] = $roleid;
            $result = $this->em->getConnection()->executeUpdate($sql,$params);
            if ($result) {
                return true;
            }else{
                return false;
            }
        }
    }
    
    /**
     * 返回问题验证Token
     * @param string $questionId
     * @return string
     */
    public function insertSecurityToken($questionId){
        $securiytToken = new SecurityQuestionVerification();
        $securiytToken->setCreatedTime($this->getDateTime());
        $securiytToken->setQuestionId($questionId);
        $securiytToken->setVerifytooken(RandomString::make(32));
        $this->em->persist($securiytToken);
        $this->em->flush();        
        return $securiytToken->getVerifytooken();
    }
    
    
    public function getAccountBasicDetailBy($userId)
    {
        $findArray = array('userId'=> $userId); 
        return $this->em->getRepository ( 'OradtStoreBundle:AccountBasicDetail' )->findOneBy ($findArray);
    }
    
    public function delAccountBasicDetailBy($id)
    {
        //$this->em->remove($detail);
    }
    
    public function getUserInfo($accountId) {
        $sql = "SELECT a.`user_id`,a.`mobile`,a.`email`,a.`secure_level`,a.`status`,b.`real_name`,
                b.`nick_name`,b.`avatar_path`,b.`gender`,b.`birthday`,b.`imid`,
                e.`en_name`,e.`company`,e.`title` FROM account_basic AS a 
               INNER JOIN `account_basic_detail` AS b ON a.`user_id`=b.`user_id` 
               INNER JOIN `account_basic_detail_extend` AS e ON a.`user_id`=e.`user_id` 
               WHERE a.`user_id`=:accountid";
        $params = array(':accountid' => $accountId);
        
        return $this->em->getConnection()->executeQuery($sql,$params)->fetch();
    }
    /**
     * 检测默认身份是否为好友
     * @param type $userId
     * @param type $fuserid
     * @return array
     */
    public function getFriend($userId,$fuserid) {
        $sourceUuid1 = $this->getQrCardID($userId);
        if($sourceUuid1) return false;
        $sourceUuid2 = $this->getQrCardID($fuserid);
        if($sourceUuid2) return false;
        
        $friend = $this->getFriendV2($userId, $sourceUuid1, $sourceUuid2);
        return $friend;
    }
    /**
     * 检测自己某身份名片与对方某身份名是否为好友
     * @param type $userId
     * @param type $sourceUuid
     * @param type $exchId
     * @return type
     */
    public function getFriendV2($userId, $sourceUuid = '', $exchId ) {
        if( empty( $sourceUuid ) ){
            $sourceUuid = $this->getQrCardID($userId);
        }
        $sql = "SELECT * FROM `contact_card` WHERE user_id=:userid AND source_uuid=:sourceUuid AND exch_id=:exchId AND isfriend=1 AND `status`='active' LIMIT 1";
        $params = array(':userid' => $userId , ':sourceUuid' => $sourceUuid, ':exchId' => $exchId);        
        return $this->em->getConnection()->executeQuery($sql,$params)->fetch();
    }
    
    public $extendDetail = array();
    public function setRealname($userId,$realName) {
        $this->em = $this->getManager("api");
        $params = array(':userid' => $userId);
        $sql = 'SELECT real_name,avatar_path,card_id FROM account_basic_detail WHERE user_id=:userid LIMIT 1';
        $userInfo = $this->em->getConnection()->executeQuery($sql,$params)->fetch();
        if(empty($userInfo))
            return false;
        //if(isset($userInfo['real_name']) && empty($userInfo['real_name'])) {
        if(isset($userInfo)) {    
            $params[':realname'] = $realName;
            $params[':avatar'] = empty($this->extendDetail[':AVATAR']) ? '': $this->extendDetail[':AVATAR'];
            $params[':cardId'] = empty($this->extendDetail[':cardId']) ? $userInfo['card_id']: $this->extendDetail[':cardId'];
            $sql = "UPDATE account_basic_detail SET real_name=:realname,avatar_path=:avatar,card_id=:cardId WHERE user_id=:userid";
            $this->em->getConnection()->executeUpdate($sql,$params);
            $this->removeCache( $this->getCacheKey($userId , 'avatar_'));
            //更新个人扩展信息
            //if(!empty($this->extendDetail)){
                $paramArr = array();
                $paramArr[':ENAME'] = empty($this->extendDetail[':ENAME']) ? '': $this->extendDetail[':ENAME'];
                $paramArr[':ORG'] = empty($this->extendDetail[':ORG']) ? '': $this->extendDetail[':ORG'];
                $paramArr[':TITLE'] = empty($this->extendDetail[':TITLE']) ? '': $this->extendDetail[':TITLE'];
                $paramArr[':URLS'] = empty($this->extendDetail[':URLS']) ? '': $this->extendDetail[':URLS'];
                $paramArr[':TELE'] = '';
                $paramArr[':CELL'] = '';
                if(!empty($this->extendDetail[':TEL'])){
                    $arr = explode(',', $this->extendDetail[':TEL']);
                    foreach($arr as $item){
                        $iArr = explode(':', $item);
                        if($iArr[0] === 'CELL'){  
                            $paramArr[':CELL'] = $iArr[1];
                        }else{
                            $paramArr[':TELE'] .= $iArr[1].';';                    
                        }
                    }
                }
                $paramArr[':EMAIL'] = empty($this->extendDetail[':EMAIL']) ? '': $this->extendDetail[':EMAIL'];
                $paramArr[':ADR'] = empty($this->extendDetail[':ADR']) ? '': $this->extendDetail[':ADR'];
                $paramArr[':userid'] = $userId;
                $sql = "UPDATE `account_basic_detail_extend` SET en_name=:ENAME,company=:ORG,title=:TITLE,url=:URLS,
                    telephone=:TELE,cellphone=:CELL,email1=:EMAIL,address=:ADR WHERE user_id=:userid";
                $this->em->getConnection()->executeUpdate($sql,$paramArr);
                $this->removeCache( $this->getCacheKey($userId , Codes::CACHE_KEY_USER_SELF));
            //}
        }
        
        return true;
    }
    /**
     * 获取用户当前交换名片ID（使用扫描名片和对方首页名片交换）
     * 判断二维码扫描名片ID是否存在，不存在则使用当前用户首页名片ID
     * @param string $userId 被扫描二维码名片源用户ID
     * @param string $vcardid 被扫描二维码名片源ID
     */
    public function getQrCardID($userId, $qrcopyvcardid = ''){
        $vcardid = '';
        $contactService = $this->container->get("account_contact_service");
        if(!empty($qrcopyvcardid)){
            //验证此名片ID的真实性
            $exchrow = $contactService->findContactCardOneBy(array('userId'=>$userId,'uuid'=>$qrcopyvcardid,'status'=>'active'));
            if(!empty($exchrow)){
                $vcardid = $qrcopyvcardid;
            }
        }
        //如果二维码扫描名片已经删除，则使用首页名片替换
        if(empty($vcardid)){
            //检测是否有首页名片
            $contact = $contactService->findContactCardOneBy(array('userId'=>$userId,'nindex'=>1,'status'=>'active'));
            if(!empty($contact)){
                $vcardid = $contact->getUuid();
            }
        }
        
        return $vcardid;
    }
    /**
     * create friend
     * @param string $userId
     * @param string $toId
     */
    public $isMessage = false;//是否推送消息给自己
    public $exchangeuuid = "";//交换名片后，返回保存的名片uuid
    public $qrcopyvcardid = "";//二维码扫描 添加好友 交换名片ID
    public $qrcopyvcardid2 = "";//多人名片交换 请求名片交换 交换名片ID
    public $rowMap = array(); //新扫描二维码保存名片时，上报我的当前经纬度（对方）
    public $selfRowMap = array(); //多人名片交换，保存双方雷达坐标（自己）
    protected $sourceCardId = '';// 交换给对方的自己的名片uuid ，目标源名片
    public $exchangeResults = array();
    public $sourcetype = ""; //名片设备来源
    public function createFriend($userId1 , $userId2 , $messageobject) {
        if($userId1===$userId2) {
            return false;
        }
        $userinfo1 = $this->getUserInfo($userId1);
        if(empty($userinfo1))
            return false;
        $userinfo2 = $this->getUserInfo($userId2);
        if(empty($userinfo2))
            return false;
        
        //查询$userId1交换名片ID
        $sourceCardId1 = $this->getQrCardID($userId1, $this->qrcopyvcardid2);
        //查询$userId2交换名片ID
        $sourceCardId2 = $this->getQrCardID($userId2, $this->qrcopyvcardid);

        if(empty($sourceCardId1) || empty($sourceCardId2)){//没有首页名片
            return 2;
        }
            
        $this->em->getConnection()->beginTransaction();
        try{
            //开始交换名片
            $this->qrcopyvcardid  = $sourceCardId1;
            $this->sourceCardId = $sourceCardId2;
            $flag2 = $this->insertFriend($userId2, $userId1, $userinfo1,$type=1 ,$sourceCardId1);//将$userId1的名片复制给$userId2

            $this->qrcopyvcardid  = $sourceCardId2;
            $this->sourceCardId = $sourceCardId1;
            $flag1 = $this->insertFriend($userId1, $userId2, $userinfo2, $type=2 ,$sourceCardId2);//将$userId2的名片复制给$userId1

            if(1 === $flag1 || 1 === $flag2){
                $this->em->getConnection()->rollback();
                return false;
            }
            if(2 === $flag1 || 2 === $flag2){//对方没有首页名片
                $this->em->getConnection()->rollback();
                return false;
            }
            $this->addCardDynamic($sourceCardId1,$sourceCardId2);
            $this->em->getConnection()->commit();
            //$this->exchangeResults = array( $flag1, $flag2);//$flag1为$userId1保存的名片ID,$flag2为$userId2保存的名片ID
        }  catch (\Exception $e){
            $this->em->getConnection()->rollback();
            //throw $e;
            return false;
        }
        $params = array();
        $params['mobile'] = $userinfo1['mobile'];
        $params['realname'] = $userinfo1['real_name'];
        $params['clientid'] = $userinfo1['user_id'];        
        $params['imid'] = $userinfo1['imid'];
        $params['cardid'] = $flag2;//user2保存的user1的uuid
        //系统发送好码添加成功消息
        $title = '好友申请:'.$userinfo1['real_name'].' 同意了你的好友请求';
        if(true === $this->isMessage || 'scancard' === $this->module){
            $title = '好友申请:已经和'.$userinfo1['real_name'].' 交换名片成为好友';
        }
        if(true !== $this->isMessage && 'letter' === $this->module){    //推荐信加好友 交换名片
            $title = $userinfo1['real_name'].'已经与你成为好友';
        }
        if(true === $this->isMessage){
            $module = "exchange";
        }elseif('qrscan' === $this->module){
            $module = "qrscan";
        }elseif('tjet' === $this->module){
            $module = "tjet";
        }elseif('ibeacon' === $this->module){
            $module = "ibeacon";
        }elseif('letter' === $this->module){
            $module = "letter";
        }elseif('communicate' ===$this->module){
            $module = "communicate";
        }elseif('invitaregist' ===$this->module){
            $module = "invitaregist";
        }elseif('recommend' === $this->module){
            $module = "recommend";
        }elseif('wechat' === $this->module){
            $module = "wechat";
        }elseif('wescan' === $this->module){
            $module = "wescan";
        }else{
            $module = "account";
        }
        $params['module'] = $module;
        if( isset($this->fromVcardId) ){
            $params['fromvcardid'] = $this->fromVcardId;
        }
        if( isset($this->fromMessageId) ){
            $params['messageid'] = $this->fromMessageId;
        }
        $this->pushMessage(112, $userId2 , $params, '', $title);
        if(true === $this->isMessage || 'qrscan' === $this->module || 'account' === $module || 'letter' === $module){//是否给自己发送好友信息，用于雷达扫描添加好友
            $params = array();
            $params['mobile'] = $userinfo2['mobile'];
            $params['realname'] = $userinfo2['real_name'];
            $params['clientid'] = $userinfo2['user_id'];        
            $params['imid'] = $userinfo2['imid'];
            $params['cardid'] = $flag1;//user1保存的user2的uuid
            if(!empty($module)){
                $params['module'] = $module;
            }
            //系统发送好码添加成功消息
            $this->pushMessage(112, $userId1 , $params, '', '好友申请:已经和'.$userinfo2['real_name'].' 交换名片成为好友');
        }
        return true;
    }
    private $accountContactService = null;
    public function insertFriend($userId,$fuserid ,$paramArr ,$type ,$cardid) {
        //var_dump( $this->getDateTime()->format("Y-m-d H:i:s") );
        //exit(); 
        //$friendObject = $this->getFriend($userId, $fuserid);
        //print_r($friendObject);
        //if(!empty($friendObject))
            //return 1;
        $this->accountContactService = $this->container->get("account_contact_service");
        
        $source = 0;//正常添加，发送好友请求
        $this->accountContactService->card_module = 'request';
        $sourcetype="app";
        if(true === $this->isMessage){ //名片交换添加好友,isMessage为true,表示是交换名片
            $source = 1;//摇一摇雷达扫描添加好友
            $this->accountContactService->card_module = 'exchage';
        }
        if('qrscan' === $this->module){
            $source = 2;//二维码扫描名片添加好友
            $this->accountContactService->card_module = 'qrscan';
            if($type == 2){
                $sourcetype = $this->sourcetype;
            }
        }
        if('letter' === $this->module){
            $source = 3;//推荐信加好友交换名片
            $this->accountContactService->card_module = 'introduce';
        }
        if ('communicate' ===$this->module) {
            $source = 4;//通讯录添加好友
        }
        if ('invitaregist' ===$this->module) {
            $source = 5;//邀请注册添加好友
        }
        if ('buy' ===$this->module) {       
            $source = 7;//找人订单加好友的
            $this->accountContactService->card_module = 'buy';
        }
        //微信邀请好友
        if ('wxfriends' === $this->module) {
            $source=8;
            $this->accountContactService->card_module = 'recommend';
        }
        if ('wb' === $this->module) {
            $source=9;
            $this->accountContactService->card_module = 'weibo';
        }
        if ('zfbfriends' === $this->module) {
            $source=10;
            $this->accountContactService->card_module = 'alipay';
        }
        if('tjet' === $this->module){
            $source = 11;//近距离传输数据
            $this->accountContactService->card_module = 'tjet';
            $sourcetype = "orange";
        }
        if('ibeacon' === $this->module){
            $source = 12;//蓝牙
            $this->accountContactService->card_module = 'ibeacon';
            $sourcetype = "orange";
        }
        if('sms' === $this->module){
            $source = 13;//短信邀请
            $this->accountContactService->card_module = 'sms';
        }
        if('wechat' === $this->module){
            $source = 14;//微信摇一摇
            $this->accountContactService->card_module = 'wechat';
        }
        if('wescan' === $this->module){
            $source = 15;//微信扫一扫
            $this->accountContactService->card_module = 'wescan';
        }
        //查询我最新一次更新雷达信息位置
        $rowSelf = $this->selfRowMap;
        
        $this->accountContactService->isexchangefriend = true; //是否为添加好友
        $uuid = $this->qrcopyvcardid;
        if(empty($uuid)){
            return 2;
        }
        $sourceCardId = $this->sourceCardId;
        //查询自己和对方首页名片交换记录
        //$selfsql = "SELECT selfuuid FROM `contact_card_exchange_log` WHERE vcardid=:uuid AND user_id=:userId AND isupdate<2 LIMIT 1";
        $selfsql = "SELECT `uuid`,isfriend FROM `contact_card` WHERE exch_id=:exchId AND user_id=:userId AND source_uuid=:sourceuuid AND `status`='active' AND self='false' LIMIT 1";
        $selfRow = $this->em->getConnection()->executeQuery($selfsql,array(':userId'=>$userId,':exchId'=>$uuid,':sourceuuid'=>$sourceCardId))->fetch();
        if( '1' === $selfRow['isfriend']){//已是好友
            $this->exchangeResults[] = $selfRow['uuid'];//此种情况，只返回$flag1
            return 1;
        }
        $selfuuid = $selfRow['uuid'];
        $xyz = '';//定义交换坐标
        if(empty($selfuuid)){//无交换记录
            //设置 源名片 uuid
            $this->accountContactService->sourceId = $sourceCardId;
            $this->accountContactService->xyz = $this->rowMap;
            $this->accountContactService->copyVCard($uuid,$userId,'',false ,$sourcetype);
            $this->pushVcardId = array_merge( $this->pushVcardId, $this->accountContactService->pushVcardId );
        }else{
            $this->exchangeuuid = $selfuuid;
            //更新交换时间，坐标
            $rowMap = $this->rowMap;
            //改为时间始终都用成为好友的那个点
            $xyztime =  $this->getTimestamp();
            if(!empty($rowMap)){
                $xyz = json_encode($rowMap);
            }
            $query = "UPDATE contact_card SET isfriend=1,x_latitude=:xlatitude,x_longitude=:xlongitude,xyz=:xyz,xyztime=:xyztime,last_modified=:last_modified,sort_time=:last_modified WHERE uuid=:uuid";
            $this->getConnection()->executeUpdate($query , array(':xyz' => $xyz ,
                        ':xyztime' => $xyztime ,
                        ':last_modified' => $xyztime ,
                        ':uuid' => $this->exchangeuuid,
                        ':xlatitude' => empty($rowMap["latitude"])?0:$rowMap["latitude"],
                        ':xlongitude' => empty($rowMap["longitude"])?0:$rowMap["longitude"]
                ));
            $this->accountContactService->syncCardAdd($userId,$this->exchangeuuid,Codes::SYNC_MODIFY,'false','','false'); 

//            $sql = "UPDATE `contact_card_exchange_log` SET isupdate=1 WHERE user_id=:userId AND selfuuid=:uuid AND isupdate=0 LIMIT 1";
//            $this->getConnection()->executeQuery($sql, array(':userId'=>$userId,':uuid'=>$selfuuid));
            $this->accountContactService->updateFriendCard( $selfuuid );
        }
        $contactnamesql = "SELECT contact_name FROM contact_card WHERE uuid=:uuid";
        $contactname = $this->em->getConnection()->executeQuery($contactnamesql,array(':uuid'=>$cardid))->fetchColumn();
        //return true;
        //增加重要联系人记录
        $paramsArrs = array(
            'type'=>4,
            'xyz'=>json_encode($this->selfRowMap),
            'channel'=>$source,
            'realname'=>$contactname,
            'sourcetype'=>$sourcetype,
            'createfriend'=>1
        );

        $this->accountContactService->changeRelationPermissionV2($userId, $this->exchangeuuid, $paramsArrs);
        
        //删除复制的名片项目以及扩展富媒体信息
        //$accountContactService = $this->container->get("account_contact_service");
        //$this->accountContactService->delExtendInfo($userId, $fuserid);
        
        //成为好友后，清除名片缓存
        /*if($this->getCacheService()->isActive()){//若redis可用
            $sql = "SELECT uuid FROM `contact_card` WHERE user_id=:userId AND from_uid=:fuserId AND `status`='active'";
            $list = $this->getConnection()->executeQuery($sql, array(':userId'=>$userId, ':fuserId'=>$fuserid))->fetchAll();
            foreach($list as $v){
                $this->removeCache( $this->getCacheKey($v['uuid'], 'vcardid') );
            }
        }*/
        $this->exchangeResults[] = $this->exchangeuuid;//$flag1为$userId1保存的名片ID,$flag2为$userId2保存的名片ID
        return $this->exchangeuuid;//返回交换名片后，保存的名片uuid
    }

    /*
     *名片动态添加
     * */
    public function addCardDynamic($uuid,$fuuid){
        $sql="SELECT uuid,avatar,b.FN as name,created_time as createdtime FROM contact_card as a INNER JOIN contact_card_vcardinfo as b ON a.uuid=b.card_id WHERE a.uuid =:uuid ";
        $res = $this->getConnection()->executeQuery($sql, array(':uuid'=>$uuid))->fetch();
        $fres = $this->getConnection()->executeQuery($sql, array(':uuid'=>$fuuid))->fetch();
        if(empty($res) || empty($fres)){
            return false;
        }
        $time = $this->getTimestamp();
        $json = json_encode(array('username'=>$res['name'],'fname'=>$fres['name'],'uavar'=>$this->getCommondUrl($res['avatar']),'favar'=>$this->getCommondUrl($fres['avatar']),'cftime'=>$time),JSON_UNESCAPED_UNICODE);//,'jointime'=>$fres['createdtime']
        $fjson= json_encode(array('username'=>$fres['name'],'uavar'=>$this->getCommondUrl($fres['avatar']),'fname'=>$res['name'],'favar'=>$this->getCommondUrl($res['avatar']),'cftime'=>$time),JSON_UNESCAPED_UNICODE);//,'jointime'=>$res['createdtime']
        $param=array(
            'createtime'=>$time,
            'modifytime'=>$time,
            'dynamic'=>$json,
            'cardid'=>$uuid,
            'fcardid'=>$fres['uuid'],
        );
        $paramf=array(
            'createtime'=>$time,
            'modifytime'=>$time,
            'dynamic'=>$fjson,
            'cardid'=>$fuuid,
            'fcardid'=>$res['uuid'],
        );
        $insertsql = "INSERT INTO contact_card_dynamic SET dynamic_card=:dynamic,create_time=:createtime,card_id=:cardid,modify_time=:modifytime,fcard_id=:fcardid ";
        $this->getConnection()->executeQuery($insertsql,$param);
        $this->getConnection()->executeQuery($insertsql,$paramf);
    }
    /**
     * 获取账号最后一次提交 交换名片坐标信息
     * @param String $fuserid
     * @return Array()
     */
    public function getExchangeMapInfo($fuserid) {
        //查询雷达坐标
        $sql = "SELECT longitude,latitude,onlinetime FROM `contact_card_exchange_map` WHERE user_id=:userId ORDER BY id DESC LIMIT 1";
        $row = $this->getConnection()->executeQuery($sql, array(':userId'=>$fuserid))->fetch();//自己最后一次提交坐标
        return $row;
    }
    

    /**
     * add tag card map
     * @param string $cardid
     * @param string $tagslist
     * @param string $isadd
     * @return boolean
     */
    public function addTagMap($userId,$fuserId,$tagslist) {
    
        if($tagslist===null)
            return true;
        $tagslist = str_replace(';', ',', $tagslist);
        $tags = array_unique(explode(',', $tagslist));        
        $this->deleteTagMap($userId,$fuserId);
        foreach ($tags as $tag) {
            if(empty($tag))
                continue;
            $tagid = $this->addTag($tag);
            if(empty($tagid))
                continue;
            $usertagmap = new AccountTagmap();
            $usertagmap->setUserId($userId);
            $usertagmap->setFuserId($fuserId);
            $usertagmap->setTagid($tagid);
            $tagType = 'friend';
            if($userId===$fuserId)
                $tagType = 'self';            
            $usertagmap->setTagType($tagType);
            $this->em->persist($usertagmap);
            $this->em->flush();
        }
    }
    
    /**
     * delete tag map
     * @param string $cardid
     */
    public function deleteTagMap($userId,$fuserId) {
        $sql ='DELETE FROM account_tagmap WHERE user_id=:userid AND fuser_id=:fuserid';
        $this->em->getConnection()->executeUpdate($sql,
                array(':userid' => $userId , ':fuserid' => $fuserId));
    }
    
    /**
     * 查找共同好码
     * @param string $userId
     * @param string $fuserId
     * @param string $type      好友类型 0：为普通好友 1：客服好友
     */
    public function commonFriend($userId,$fuserId,$type=NUll) {
        $where   = "";
        $findArr = array(':userid1' => $userId , ':userid2' => $fuserId);
        if(!empty($type)){
            $findArr[':type'] = $type;
            $where = " and type=:type";
        }
        $sql ='select clientid,realname,avatar_path as avat from (SELECT a.fuser_id AS clientid,a.fusername AS realname FROM (
                SELECT fuser_id,fusername  FROM account_friend WHERE user_id=:userid1'.$where.'
                ) AS a 
                INNER JOIN (
                SELECT fuser_id,fusername FROM account_friend WHERE user_id=:userid2'.$where.'
                ) AS b ON a.fuser_id=b.fuser_id) as com inner join account_basic_detail as ab on com.clientid=ab.user_id
                    ';
        return $this->em->getConnection()->executeQuery($sql,$findArr)->fetchAll();
    }
    /**
     * 查询共同好友 V2版
     * @param type $userId
     * @param type $fuserId
     * @return array 共同好友列表
     */
    public function commonFriendV2( $userId , $fuserId ) {
        if( empty($this->qrcopyvcardid) ){
            $this->qrcopyvcardid = $this->getQrCardID( $fuserId );
        }
        if( empty($this->qrcopyvcardid2) ){
            $this->qrcopyvcardid2 = $this->getQrCardID( $userId );
        }
        
        $findArr = array(':userid1' => $userId , ':userid2' => $fuserId, ':sourceuuid'=>  $this->qrcopyvcardid2, ':exchid'=>  $this->qrcopyvcardid);

        $sql ='select uuid as vcardid,c.user_id as clientid,c.contact_name as realname,c.avatar as avat,c.picture,v.TITLE as position,v.ORG as company from `contact_card` c
            LEFT JOIN `contact_card_vcardinfo` v ON v.card_id=c.uuid WHERE c.uuid IN ( 
SELECT c.exch_id FROM `contact_card` c WHERE c.user_id=:userid1 AND c.source_uuid=:sourceuuid AND c.isfriend=1 AND c.status="active"
AND EXISTS 
(SELECT 1 FROM `contact_card` cc WHERE cc.user_id=:userid2
 AND cc.source_uuid=:exchid AND cc.exch_id=c.exch_id AND cc.isfriend=1 AND cc.status="active"))
            ';
        return $this->em->getConnection()->executeQuery($sql,$findArr)->fetchAll();
    }
    /**
     * 写入账户表
     * 2015-04-29  create by xuejiao
     * @param   string $accountId
     * @param   string $account
     * @param   string $type    类型 是邮箱 还是 mobile
     */
    public function saveAccountCommon($accountId,$account,$type){
        $this->em = $this->getManager("api");
        $params = array( 
            ':type'     => $type, 
            ':accountid'=> $accountId, 
            ':account'  => $account, 
            ':createtime' => $this->getTimestamp()
        );
        $insertQuery = "INSERT INTO account_common (type,account_id,account,createtime) 
                VALUES(:type,:accountid,:account,:createtime)";
        $this->em->getConnection()->executeUpdate($insertQuery , $params);
        return true;
    }
    /*
     * 更新公共账户信息
     * @param string $accountId
     * @param string $email
     * @param string $type
     */
    public function updateAccountCommon($accountId,$account,$type){
        $findParam = array(
            'type'      => $type,
            'accountId' => $accountId
        );
        $accountCommon = $this->findAccountCommonOneBy($findParam);
        //如果没有数据则新加入数据，否则修改数据
        if(empty($accountCommon)){  
            return $this->saveAccountCommon($accountId, $account, $type);
        }else{
            $accountCommon->setAccount($account);
            $this->em->persist ( $accountCommon );
            $this->em->flush ();
            return TRUE;
        }
    }
    
    /**
     * 检测某个账户类型是否存在
     */
    public function findAccountCommonOneBy($array){
        $this->em = $this->getManager("api");
        $repository = $this->em->getRepository ( 'OradtStoreBundle:AccountCommon');
        return $repository->findOneBy ( $array );
    }
    
    /**
     * 检测账户是否存在
     */
    public function checkAccountCommon($account){
        $this->em = $this->getManager("api");
        $sql        = "SELECT type,account_id,account FROM account_common WHERE account =:account";
        $findArray  = array(':account'=> $account); 
        $list       = $this->em->getConnection()->executeQuery($sql,$findArray)->fetch();
        return $list;
    }
    
    /**
     * 获取新注册会员 免费会员天数配置 和 免费容量的配置项
     * type=1 橙子伴侣免费体验   type=3 橙子伴侣容量限制
     * 默认 30天 和 1000 已加入初始化sql 
     */
    public function getFreeTimeAndCardCapacity(){
        $equityTime = 30;       //橙子伴侣免费体验 默认30天（和产品雷确认）
        $equityCapacity = 1000; //橙子伴侣容量限制 默认1000张（和产品雷确认）
        //获取后台价格管理配置的 免费体验
        $onesql  = 'SELECT id,equity_time FROM oradt_recharge_app_price WHERE type=:type LIMIT 1';
        $typeOne = $this->getConnection()->executeQuery($onesql,array(":type"=>1))->fetch();
        if(!empty($typeOne)){
            $equityTime = $typeOne['equity_time'];
        }
        // 获取后台价格管理配置的 容量限制
        $threesql    = 'SELECT id,equity_capacity FROM oradt_recharge_app_price WHERE type=:type LIMIT 1';
        $typeThree = $this->getConnection()->executeQuery($threesql,array(":type"=>3))->fetch();
        if(!empty($typeThree)){ 
            $equityCapacity = $typeThree['equity_capacity'];
        }
        return array('equitytime'=>$equityTime,'equitycapacity'=>$equityCapacity);
    }

    /**
     * 获取后台价格管理配置中  橙子赠送时长 配置单位天
     * 如果没有检测到（该条配置数据） 则默认30天（和产品雷确认） 已加入初始化sql 
     * oradt_recharge_app_price  type=4（固定值） 表示橙子赠送时长配置
     */
    public function getOrangGiveMemberLength(){
        $giveLeng = 30;  //默认30天如果没有数据
        $sql    = 'SELECT id,equity_time FROM oradt_recharge_app_price WHERE type=:type LIMIT 1';
        $freePrice = $this->getConnection()->executeQuery($sql,array(":type"=>4))->fetch();
        if(!empty($freePrice)){
            $giveLeng = $freePrice['equity_time'];
        }
        return $giveLeng;
    }

    /**
     * 获取用户当前名片容量数
     * 逻辑  开启无限容量 为1000 ，关闭则获取后台配置的 橙子伴侣容量配置数
     * @param string $userId    云端账户ID
     */
    public function getAccountCardCapacity($userId,$param=array()){
        $freeArr = $this->getFreeTimeAndCardCapacity();
        $cardNum = (int)$freeArr['equitycapacity'];  //运营后台配置的橙子伴侣容量
        if(empty($param)){
            $sql    = 'SELECT card_capacity,capacity_switch FROM account_basic_detail WHERE user_id=:userid LIMIT 1';
            $userInfo = $this->getConnection()->executeQuery($sql,array(":userid"=>$userId))->fetch();
            if(!empty($userInfo)){
                if($userInfo['capacity_switch'] == 1){  //开启无限容量
                    $cardNum = 10000;
                }
            }
        }else{
            if($param['capacityswitch'] == '1'){  //开启无限容量
                $cardNum = 10000;
            }
        }
        return $cardNum;
    }
    /**
     * 更改 Oradt account 的Imid
     * @param string $userId    云端账户ID
     * @param int    $imId      im账户ID
     */
//    public function setImid($userId,$imId) {
//        $params = array(':userid' => $userId);
//        $sql    = 'SELECT imid FROM account_basic_detail WHERE user_id=:userid LIMIT 1';
//        $userInfo = $this->em->getConnection()->executeQuery($sql,$params)->fetch();
//        if(empty($userInfo))
//            return false;
//        if(isset($userInfo['imid']) && empty($userInfo['imid'])) {
//            $params[':imid'] = $imId;
//            $sql = "UPDATE account_basic_detail SET imid=:imid WHERE user_id=:userid";
//            $this->em->getConnection()->executeUpdate($sql,$params);
//        }
//        return true;
//    }
    
    /**
     * 发送好友请求
     * @param string $fromuid 发送请求人
     * @param string $touid 接收请求人
     * @param string $note
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public $fromVcardId = '';
    public $fromMessageId = ''; //发起好友请求来源消息ID
    public function doclientId($fromuid,$touid,$note='') {
        //echo __FILE__;
        if(empty($fromuid) || empty($touid)){
            return false;
        }
        $userInfo = $this->getUserInfo($touid);
        if(empty($userInfo)) {
            return false;
        }
        $selfInfo = $this->getUserInfo($fromuid);
        $params = array();
        $params['mobile'] = $selfInfo['mobile'];
        $params['realname'] = $selfInfo['real_name'];
        $params['clientid'] = $selfInfo['user_id'];
        //$params['gid'] = 0;
        //$params['note'] = $note;
        $params['imid'] = $selfInfo['imid'];
        $params['module'] = $this->module;


        if(empty($this->qrcopyvcardid)){//二维码扫描添加好友
            $sql="SELECT uuid FROM contact_card WHERE user_id=:userid AND nindex=1 AND status='active' limit 1";
            $nindecardid = $this->getConnection()->executeQuery($sql, array("userid"=>$touid))->fetchColumn();
            $this->qrcopyvcardid =$nindecardid;
        }
        $params['qrcopyvcardid'] = $this->qrcopyvcardid;
        //查询请求人名片信息
        $accountContactService = $this->container->get("account_contact_service");
        if(!empty($this->qrcopyvcardid2)){
            $contactCard = $accountContactService->findContactCardOneBy(array('userId'=>$fromuid,'uuid'=>$this->qrcopyvcardid2,'status'=>'active'));
        }
        if(empty($contactCard)){
            $contactCard = $accountContactService->findContactCardOneBy(array('userId'=>$fromuid,'nindex'=>1,'status'=>'active'));
            $this->qrcopyvcardid2 = $contactCard->getUuid();
        }
        $params['fromcard'] = '';
        if(!empty($contactCard)){
            $contactName = $contactCard->getContactName();
            if( !empty($contactName) ){
                $params['realname'] = $contactName;
            }
            $params['fromuuid'] = $contactCard->getUuid();
            $picture = $contactCard->getPicture();
            $params['fromcard'] = $this->getCommondUrl($picture);
        }
        if( !empty($this->fromVcardId) ){
            $params['fromvcardid'] = $this->fromVcardId;
        }

        $params['messageid'] = $this->fromMessageId;

       /* $params['relationship'] = 0;//默认无关系
        $commonfriend = $this->commonFriendV2($fromuid,$touid);
        if(!empty($commonfriend)){
            foreach($commonfriend as $k=>$val){
                $commonfriend[$k]['avat'] = $this->getCommondUrl($val['avat']);
            }
            if(count($commonfriend) > 5){
                $newcommonfriend = array_slice($commonfriend,0,5);
                $params['commonfriend'] = json_encode($newcommonfriend);
            }else{
                $params['commonfriend'] = json_encode($commonfriend);
            }
            $params['relationship'] = 3;//共同好友（二度人脉）
        }else{//查询是否为同行或者同事关系
            $elastic = $this->container->get('elasticsearch_service');
            $result = $elastic->checkProfession(array('accountid'=>$fromuid,'fromid'=>$touid));//同行关系
            if( !empty($result) ){
                $params['relationship'] = 2;
                $params['relationdata'] = '';
                foreach( $result as $k => $v ){
                    $querySql = "SELECT name FROM account_basic_category WHERE category_id=:cateid LIMIT 1";
                    $name = $this->getConnection()->executeQuery($querySql, array(':cateid' => $v['category_id']))->fetchColumn();
                    if( !empty($name) ){
                        $params['relationdata'] .= $name.',';
                    }
                    $params['relationdata'] = rtrim($params['relationdata'],',');
                }
            }else{
                $querySql = "SELECT ORG FROM `contact_card_vcardinfo` WHERE card_id=:cardid LIMIT 1";
                $org1 = $this->getConnection()->executeQuery($querySql, array(':cardid'=>$params['fromuuid']))->fetchColumn();//自己
                $org2 = $this->getConnection()->executeQuery($querySql, array(':cardid'=>$params['qrcopyvcardid']))->fetchColumn();//对方
                if( !empty($org1) && !empty($org2) ){
                    $argc1 = explode(',', $org1);
                    $argc2 = explode(',', $org2);
                    //获取相同的公司名
                    $commonArgc = array_intersect( $argc1, $argc2);
                }else{
                    $commonArgc = array();
                }
                if( !empty($commonArgc) ){
                    $params['relationship'] = 1;//同事关系
                    $params['relationdata'] = implode(',', $commonArgc);
                }
            }
        }*/
        $messageService = $this->container->get("oradt_message_service" );
        $rs = $messageService->friendMessage($fromuid,$touid,$params);
        if(!$rs){
            return false;
        }else{
            return true;
        }
    }
    /**
     * 删除好友
     * @param string $userid 用户ID
     * @param string $fuserid 好友ID
     * @return boolean
     */
    public $delCardId = '';//3.0版解除好友关系
    public function deleteFriend($userid,$fuserid){
        if(empty($userid)||empty($fuserid)||empty($this->delCardId)){
            return false;
        }
        $sql = '';
        $param = array(':userId'=>$userid);
        $param[':fuserid'] = $fuserid;
        $time = $this->getTimestamp();
        $this->em->getConnection()->beginTransaction();
        try{
            
//            $sql = 'DELETE FROM `account_friend` WHERE user_id=:userId AND fuser_id=:fuserid';
//            $this->em->getConnection()->executeUpdate($sql,$param);
//            $sql2 = 'DELETE FROM `account_friend` WHERE user_id=:fuserid AND fuser_id=:userId';
//            $this->em->getConnection()->executeUpdate($sql2,$param);
            $selfuuid = $this->delCardId;
            //自己
            $param[':selfuuid'] = $selfuuid;
            if( "friend" === $this->module){
                $delSql = "UPDATE `contact_card` SET isfriend=0 WHERE user_id=:userId AND uuid=:selfuuid AND `status`='active' LIMIT 1";
                $this->getConnection()->executeUpdate($delSql, $param);
            }
            //查询自己身份名片ID
            $querySql = "SELECT source_uuid,exch_id FROM `contact_card` WHERE user_id=:userId AND uuid=:selfuuid LIMIT 1";
            $selfRow = $this->getConnection()->executeQuery($querySql, $param)->fetch();
            //查询交换好友名片UUID
            $querySql = "SELECT uuid FROM `contact_card` WHERE user_id=:fuserid AND exch_id=:exch_id AND source_uuid=:sourceId AND `status`='active' LIMIT 1";
            $otheruuid = $this->getConnection()->executeQuery($querySql, array(':fuserid'=>$fuserid, ':exch_id'=>$selfRow['source_uuid'],':sourceId'=>$selfRow['exch_id']))->fetchColumn();
            $otherSql = "UPDATE `contact_card` SET isfriend=0,last_modified=:time,sort_time=:time WHERE user_id=:fuserid AND uuid=:otheruuid LIMIT 1";
            $this->getConnection()->executeUpdate($otherSql, array( ':fuserid'=>$fuserid, ':otheruuid'=>$otheruuid ,':time'=>$time ));
            //更新同步接口
            $syncCard = "UPDATE `contact_card_sync` SET last_modified=:time,operation='modify' WHERE card_uuid=:otheruuid LIMIT 1";
            $this->getConnection()->executeUpdate($syncCard, array(':otheruuid'=>$otheruuid ,':time'=>$time ));
            //END 好友关系接触

            //删除重要关系权限记录
//            $sql5 = "DELETE FROM `contact_relation_permission` WHERE from_uid=:userId AND to_uid=:fuserid";
//            $sql6 = "DELETE FROM `contact_relation_permission` WHERE to_uid=:userId AND from_uid=:fuserid";
//            $this->em->getConnection()->executeUpdate($sql5,$param);
//            $this->em->getConnection()->executeUpdate($sql6,$param);
//            $sql5 = "DELETE FROM  `contact_relation_permission_v2` WHERE card_id=:selfuuid LIMIT 1";
//            $this->em->getConnection()->executeUpdate($sql5,array(':selfuuid'=>$selfuuid));
//            $this->em->getConnection()->executeUpdate($sql5,array(':selfuuid'=>$otheruuid));
            //复制添加名片项目以及扩展富媒体信息
            //$accountContactService = $this->container->get("account_contact_service");
            //$accountContactService->copyExtendInfo($userid, $fuserid);
            //$accountContactService->copyExtendInfo($fuserid, $userid);

            $sqlCommUser="UPDATE account_communicate SET issend=1,send_time=0,friend_time=0 WHERE user_id=:userId AND fuser_id=:fuserId";
            $this->em->getConnection()->executeUpdate($sqlCommUser,array(':userId'=>$userid,':fuserId'=>$fuserid));

            $sqlCommFuser="UPDATE account_communicate SET issend =1,send_time=0,friend_time=0 WHERE user_id=:userId AND fuser_id=:fuserId";
            $this->em->getConnection()->executeUpdate($sqlCommFuser,array(':userId'=>$fuserid,':fuserId'=>$userid));

//            $commonSyncSerivce = $this->container->get("common_sync");
//            $commonSyncSerivce->CommonSyncAdd($userid,$fuserid,"friend","delete");
//            $commonSyncSerivce->CommonSyncAdd($fuserid,$userid,"friend","delete");
            
            //获取imid
            $sql="SELECT imid,real_name AS realname FROM account_basic_detail WHERE user_id='".$userid."' LIMIT 1";
            $acountid1=$this->getConnection ()->executeQuery ( $sql )->fetch();
            $sql="SELECT imid,real_name AS realname FROM account_basic_detail WHERE user_id='".$fuserid."' LIMIT 1";
            $acountid2=$this->getConnection()->executeQuery($sql)->fetch();
            $imid1=$acountid1['imid'];
            $imid2=$acountid2['imid'];
            
            //添加推送消息
            $params = array("clientid"=>$fuserid,'realname'=>$acountid2['realname'],'selfuuid'=>$selfuuid);
            $this->pushMessage(113, $userid , $params, '', '好友删除： 和'.$acountid2['realname'].'解除好友关系');
            $params2 = array("clientid"=>$userid,'realname'=>$acountid1['realname'],'selfuuid'=>$otheruuid);
            $this->pushMessage(113, $fuserid , $params2, '', '好友删除： 和'.$acountid1['realname'].'解除好友关系');
            
            $this->em->getConnection()->commit();
            
            //查询和对方是否仍有好友关系
            //$querySql = "SELECT 1 FROM `contact_card` WHERE user_id=:userId AND from_uid=:fuserid AND isfriend=1 LIMIT 1";
            //$isfriend = $this->getConnection()->executeQuery($querySql, $params)->fetchColumn();
            //if( $isfriend < 1 ){
                //从黑名单删除
                //$soapservice  = $this->container->get("soap_service");
                //$soapservice->DelBlackList($imid1 , $imid2);
            //}
            return true;
        }catch(\Exception $e){
            $this->em->getConnection()->rollback();
            //throw $e;
            return false;
        }
        return false;
    }
    /*
    * 更新用户首页名片
    * */
    public function updateNindexCard($userId, $cardid) {
        $asql = "UPDATE `account_basic_detail` SET card_id=:cardid WHERE user_id=:userid";
        $param = array(':userid' => $userId , ":cardid" => $cardid);
        $this->em->getConnection()->executeUpdate($asql,$param);
        $this->removeCache( $this->getCacheKey($userId , Codes::CACHE_KEY_USER_SELF));
    }


    public function intoDefaultFriend($userId,$uuid){
        //短信邀请自动成为好友
        $ifkafka = false; //不开启kafka，设为true表示开启
        $kafkaKeFu = "";
        if($ifkafka){
            //kafka
            $kafkaService = $this->container->get('kafka_service');
            if($this->container->hasParameter('kafka_mapfriend')){
                $kafkaKeFu = $this->container->getParameter('kafka_mapfriend');
            }
        }

        $sql = "SELECT mobile FROM account_basic WHERE user_id=:userId";
        $result = $this->getConnection()->executeQuery($sql, array(':userId' => $userId))->fetch();
        $selfRow=array(
            'userid'=>$userId,
            'vcardid'=>$uuid,
            'lat'=>0,
            'longitude'=>0,
            'onlinetime'=>time()
        );
        $friendArr = $this->getIntoFriend($result['mobile']);//获取发送短信加好友人自动创建好友
        //print_r($friendArr);echo "---";
        if (!empty($friendArr)) {
            foreach ($friendArr AS $val) {
                if ($val['status'] == 1) {
                    $this->module ='invitaregist';
                    $selcard='SELECT card_id FROM account_basic_detail WHERE user_id=:userId';
                    $vucard =$this->getConnection()->executeQuery($selcard, array(':userId' => $val['user_id']))->fetch();
                    $vRow=array(
                        'userid'=>$val['user_id'],
                        'vcardid'=>$vucard['card_id'],
                        'lat'=>0,
                        'longitude'=>0,
                        'onlinetime'=>time()
                    );
                    $mobileFriendData='';
                    if(true === $ifkafka && !empty($kafkaKeFu) && $kafkaService->isActive()) {
                        //异步加好友
                        $mobileFriendData = json_encode(array("source"=>5,"u1"=>$selfRow,"u2"=>$vRow));
                        $kafkaService->sendKafkaMessage($kafkaKeFu,$mobileFriendData);
                        $kafkaService->disConnect();
                    }else{
                        $this->createFriend($userId, $val['user_id'], '');
                        $query = "UPDATE account_into_friend  SET status=2 WHERE user_id = :userId AND mobile = :mobile";
                        $this->getConnection()->executeUpdate($query, array(':userId' => $userId, ':mobile' => $val['mobile']));
                    }
                }
            }
        }
        //自动添加客服
        /*$sql = "SELECT id,reg_type FROM account_basic_detail WHERE user_id=:userid limit 1";
        $res = $this->em->getConnection()->executeQuery($sql, array(':userid' => $userId))->fetch();
        $sqlfriend = "SELECT id FROM account_friend WHERE user_id=:userid AND type=1";
        $serviceFriend = $this->em->getConnection()->executeQuery($sqlfriend,array(':userid' => $userId))->fetchColumn();
        if ($res['reg_type'] === 4 || !empty($serviceFriend)) {
            return false;
        }
        $dir = $this->container->getParameter('kernel.cache_dir');
        $cache = new FilesystemCache($dir);
        $result = $cache->fetch("accountoftheservice");
        if(empty($result)){
            $sqlcount2 ="SELECT user_id,card_id FROM account_basic_detail WHERE reg_type = 4 AND card_id<>''";
            $res1= $this->em->getConnection()->executeQuery($sqlcount2)->fetchAll();
            $cache->save("accountoftheservice", array('alltheservice'=>$res1), 3600);
            $result =$cache->fetch("accountoftheservice");
        }*/
        /* $cacheKey="accountoftheservice";
         //判断key是否存在，存在则读取缓存，不存在则读取数据库
         if($this->checkCacheKeyExists($cacheKey)){
             $res1    = $this->getCache($cacheKey);
         }else{
             $sqlcount2 ="SELECT user_id,card_id FROM account_basic_detail WHERE reg_type = 4";
             $resource = $this->em->getConnection()->executeQuery($sqlcount2)->fetchAll();
             //print_r($resource);die;
             $res1 =json_encode($resource);
             $this->setCache($cacheKey,$res1);
         }
         $result = json_decode($res1,true);
         if(empty($result)){
             return false;
         }*/
        /*if(empty($result)){
            return false;
        }
        $count = count(array_keys($result['alltheservice']));
        $remainder = $res['id']%$count;
        $fuserid = $result['alltheservice'][$remainder]['user_id'];
        $fcardid = $result['alltheservice'][$remainder]['card_id'];
        $kefuRow=array(
            'userid'=>$fuserid,
            'vcardid'=>$fcardid,
            'lat'=>0,
            'longitude'=>0,
            'onlinetime'=>time()
        );
        $kefuData='';
        if(true === $ifkafka && !empty($kafkaKeFu)  && $kafkaService->isActive()) {
            //异步添加客服
            $kefuData = json_encode(array("source"=>0,"u1"=>$kefuRow,"u2"=>$selfRow));
            $kafkaService->sendKafkaMessage($kafkaKeFu,$kefuData);
            $kafkaService->disConnect();
        }else{
            if (true == $this->createFriend($fuserid,$userId , '')) {
                $sqlup = "UPDATE account_friend SET type=1 WHERE user_id=:userId AND fuser_id=:fuserId";
                $this->getConnection()->executeUpdate($sqlup, array(":userId" => $userId, ":fuserId" => $fuserid));
            }
        }*/

    }
    
    public function getUserInfoByImID($imid) 
    {
        $sql = "SELECT * FROM `account_basic_detail` WHERE `imid`=:imid";
        $params = array(':imid' => $imid);
        return $this->em->getConnection()->executeQuery($sql,$params)->fetch();
    }

    /**
     * 发送好友邀请自动成为好友
     * 注：当被邀请用户第一次创建首页名片式自动成为好友
     * create by 2016-3-23
     * @param string $user_id 用户id
     * @param string $mobile 目标用户电话
     * return  true
     */
    public function intoFriend($user_id,$mobile){
        if(empty($user_id) && empty($mobile)){
            return false;
        }
        $sql = "SELECT * FROM account_into_friend WHERE user_id=:userId AND mobile=:mobile";
        $params = array(':userId' => $user_id,':mobile' => $mobile);
        $result = $this->em->getConnection()->executeQuery($sql,$params)->fetch();
            if(!empty($result)){
                return false;
            }
        $intoFriendPara = array(':user_id' => $user_id , ':mobile' =>$mobile , ':create_time' =>$this->getTimestamp() , ':status' => 1 );
        $intoFriend = "INSERT INTO account_into_friend (user_id,mobile,create_time,status)
                                VALUES(:user_id,:mobile,:create_time,:status)";
        $this->getConnection()->executeUpdate($intoFriend , $intoFriendPara);
    }
    public function getIntoFriend($mobile){
        $sql = "SELECT * FROM account_into_friend WHERE mobile=:mobile AND status=1";
        $params = array(':mobile' => $mobile);
        return $this->em->getConnection()->executeQuery($sql,$params)->fetchAll();
    }
    
    /**
     * 快速注册basic账号
     * 注：调用该方法前  请确保 手机号未被注册过
     * create by 2015-11-24  
     * @author xuejiao <xuejiao@oradt.com>
     * @param string $mobile 手机号
     * @param string $passwd 密码（明文）
     * return  array()
     */
   // public function regAccountBasicFast($mobile,$passwd,$mcode='86'){
    public function regAccountBasicFast($arr){
        if(empty($arr['mobile']) || empty($arr['passwd'])){
            return FALSE;
        }
        $this->em->getConnection()->beginTransaction();
        try{
            //1---拼接userId
//            $userid     = RandomString::make ( 29 ,'A' );  //拼接userId
//            $userArr    = $this->querySql('SELECT max(id) as uid FROM `account_basic` limit 1') ;       
//            $maxId      = 1;
//            if(!empty($userArr) && is_numeric($userArr['uid'])){
//                $maxId = intval($userArr['uid']) + 1;  
//            }
//            $userid .= str_pad($maxId,11,'0',STR_PAD_LEFT);         //后11位为用户ID，不够长左边用0补齐，
            $userid = $this->createAccountId();
            if (strlen ( $userid ) !== 40) {
                return FALSE;
            }
            //2---INSERT account_basic
            $basicParams = array( 
                ':user_id'  => $userid ,   ':mcode'     => $arr['mcode'],
                ':mobile'   => $arr['mobile'],    ':email'    => '' ,
                ':password' => Password::encrypt( $arr['passwd'] ),
                ':secure_level' => Password::secureLevel($arr['passwd']),
                ':status'       => 'active',
            );
            $basicQuery = "INSERT INTO account_basic (user_id,mcode,mobile,email,password,secure_level,status) 
                    VALUES(:user_id,:mcode,:mobile,:email,:password,:secure_level,:status)";
            $this->getConnection()->executeUpdate($basicQuery , $basicParams);
            //3---INSERT account_basic_detail
            //$creatime = $this->getDateTime()->format("Y-m-d H:i:s");
            $creatime = $this->getTimestamp();
            $ExpiryDate = $this->getTimestamp()+3600*24*30;  //这里加 30 天 到期日期 
            $ip       = '127.0.0.1';
            $basicDetailParams = array( 
                ':user_id'      => $userid ,    ':real_name'    => '', 
                ':nick_name'    => '',          ':avatar_path'  => '' , 
                ':country_code' => 156,         ':imid'         => 0,
                ':remark'       => '',          ':latitude'     => '0',
                ':mis_latitude' => '0',         ':longitude'    => '0',
                ':mis_longitude' => '0',        ':languageid'   => 2,
                ':card_id'      => '',          ':reg_from'     => '',
                ':md5city'      => '',          ':reg_type'=>$arr['reg_type'],
                ':last_login_time'  => $creatime,    ':last_login_ip' => $ip,
                ':login_time'   => $creatime,        ':login_ip' => $ip ,
                ':register_ip'  => $ip,         ':card_capacity' => 1000,
                ':created_time' => $creatime,    ':expiry_date'  => $ExpiryDate    
            );
            $basicDetail = "INSERT INTO account_basic_detail (user_id,real_name,nick_name,avatar_path,country_code,imid,
                            remark,latitude,mis_latitude,longitude,mis_longitude,languageid,card_id,reg_from,md5city,reg_type,
                            last_login_time,last_login_ip,login_time,login_ip,register_ip,card_capacity,created_time,expiry_date)
                           VALUES(:user_id,:real_name,:nick_name,:avatar_path,:country_code,:imid,:remark,:latitude,
                            :mis_latitude,:longitude,:mis_longitude,:languageid,:card_id,:reg_from,:md5city,:reg_type,
                            :last_login_time,:last_login_ip,:login_time,:login_ip,:register_ip,:card_capacity,:created_time,:expiry_date)";
            $this->getConnection()->executeUpdate($basicDetail , $basicDetailParams);
            //4---INSERT account_basic_extend_info 该表数据 已并入 basicdetail 表中
//            $basicExtendInfoParams = array( 
//                ':user_id'      => $userid ,   
//                ':register_ip'  => $ip, 
//                ':created_time' => $creatime
//            );
//            $basicExtendInfo = "INSERT INTO account_basic_extend_info (user_id,register_ip,created_time) 
//                                VALUES(:user_id,:register_ip,:created_time)";
//            $this->getConnection()->executeUpdate($basicExtendInfo , $basicExtendInfoParams);
            //5---添加详细信息扩展
            $basicDetailExtendParams = array( 
                ':user_id'      => $userid ,   
                ':en_name'      => '', 
                ':company'      => '',
                ':title'        => '',
                ':url'          => '',
                ':telephone'    => '',
                ':cellphone'    => $arr['mobile'],
                ':email1'       => '',
                ':address'      => '',
                ':created_time' => $creatime
            );
            $basicDetailExtend = "INSERT INTO account_basic_detail_extend (user_id,en_name,company,title,url,telephone,cellphone,email1,address,created_time) 
                                VALUES(:user_id,:en_name,:company,:title,:url,:telephone,:cellphone,:email1,:address,:created_time)";
            $this->getConnection()->executeUpdate($basicDetailExtend , $basicDetailExtendParams);
            
            //6---添加账户公共表结构
            $this->saveAccountCommon($userid,$arr['mcode'].$arr['mobile'],'mobile');
            
            
            //8---setLoginSession
            $oauthService = $this->container->get('oauth_service');
            $oauthService->upLogininfo = false;
            $userInfo     = $oauthService->setLoginSession($userid , 'basic' , 'active' , $ip , 0 , '');
            
            $this->em->getConnection()->commit();
        }catch(\Exception $e){
            $this->em->getConnection()->rollback();
            throw $e;
            return FALSE;
        }
        //7---添加im账户
        $kafkaService = $this->container->get('kafka_service');
        if($kafkaService->isActive()) {
            $kafkaAccountBasic = $this->container->getParameter('kafka_accountbasic');
            //异步注册 //{"userid" : "ctest1000501" , "passwd":"1234567"}
            $userData = array("userid" => $userid , "passwd" => Password::encrypt($arr['passwd']));
            $kafkaService->sendKafkaMessage($kafkaAccountBasic,json_encode($userData));
        }else{
            //5---初始化数据
            $initData = $this->container->get("oradt_initdata_service");
            $initData->basicData($userid);
            //同步注册
            try{
                $soapService = $this->container->get ( 'soap_service' );
                $soapService->addImUser($userid,$arr['mobile'],Password::encrypt($arr['passwd']));
            }catch(\Exception $e){}
        }
        $this->setUserMaxidCache();
        $data = array (
            'clientid'      => $userid,
            'accesstoken'   => $userInfo['token'],
            'expiration'    => Codes::TOKEN_EXPIRE_TIME,
            'passwd'        => Password::encrypt($arr['passwd']),
            'accountstate'  => 'active',
            'ifmissing'     => 0
        );
        return $data;
    }
    public function judgeCustomerPwd($mobile,$passwd)
    {
        $array = array(
            'mobile' => $mobile,
            'password' => md5($passwd),
            );
        $clientid = '';
        $data = $this->em->getRepository ( 'OradtStoreBundle:AccountBasic')->findOneBy($array);
        if (!empty($data)) {
            $clientid = $data->getUserId();
        }
        return $clientid;
    }

    /**
     * 检测Email是否重复使用
     */
    public function checkEmailRepeat($email,$bizid='',$empid='')
    {
        $param  = array(':email' => $email);
        $sql1   = "SELECT user_name FROM account_biz WHERE user_name=:email AND status != 'deleted'";            
        $sql2   = "SELECT account FROM account_common WHERE account=:email";
        if (!empty($bizid)) {
            $param[':bizid']  = $bizid; 
            $sql1   = $sql1." AND biz_id !=:bizid ";            
            $sql2   = $sql2." AND account_id !=:bizid";
        }
        $param3  = array(':email' => $email,':empid'=>$empid);
        $sql3   = "SELECT email FROM account_biz_employee WHERE email=:email AND status != 'deleted'";
        if (!empty($empid)) {
            $param3[':empid']  = $empid;
            $sql3   = $sql3." AND emp_id=:empid ";
        }
        $res1   = $this->em->getConnection()->executeQuery($sql1,$param)->fetch();
        $res2   = $this->em->getConnection()->executeQuery($sql2,$param)->fetch();
        $res3   = $this->em->getConnection()->executeQuery($sql3,$param3)->fetch();
        if (empty($res1) && empty($res2) && empty($res3)) {
            return true;
        }else{
            return false;
        }
    }
    public function checkUsernameRepeat($name,$bizid='')
    {
        if (!empty($bizid)) {
            $sql    = "SELECT a.biz_name FROM account_biz_detail AS a LEFT JOIN account_biz AS b on a.biz_id = b.biz_id WHERE a.biz_name=:name AND a.biz_id !=:bizid AND b.status !='deleted'";
            $params = array(':name' => $name,':bizid' => $bizid);    
        }else{
            $sql    = "SELECT a.biz_name FROM account_biz_detail AS a LEFT JOIN account_biz AS b on a.biz_id = b.biz_id WHERE a.biz_name=:name AND b.status !='deleted'";
            $params = array(':name' => $name);
        }    	
        $res    = $this->em->getConnection()->executeQuery($sql,$params)->fetch();
    	if (empty($res)) {
    		return true;
    	}else{
    		return false;
    	}
    }
    /**
     * 企业|合作商删除
     */
    public function delBizCom($bizArr)
    {        
        $bizs = implode(',', $bizArr);
        if (!empty($bizs)) {
            $sql    = "DELETE FROM `account_common` WHERE account_id IN(".$bizs.") AND type = 'email'";
            $res    = $this->em->getConnection()->executeUpdate($sql);
        }
        return true;        
    }

    /*
    * 版本升级更新文件缓存
    * */
    public function updateVersionCache($key=''){
        $dir    = $this->container->getParameter('kernel.cache_dir');
        $key = 'versionservice';
        $cache  = new FilesystemCache($dir);
        $res = $cache->fetch("versionservice");
        if(!empty($res)){
            $cache->delete($key);
        }
        $sql="SELECT * FROM sys_version WHERE  isdelete = 0 ORDER BY create_time";
        $versionRes = $this->getConnection()->executeQuery($sql)->fetchAll();
        $cache->save("versionservice", array('alltheversion' => $versionRes), 259200);
    }

    /*
     * 行程卡删除同步删除日程
     * */
    public function syncDelSchedule($id){
        $flag = array(":id"=>$id);
        if(!empty($id)){
            $scheduleSql = "SELECT * FROM contact_card_schedule WHERE flight_id= :id AND  status=1 limit 1";
            $scheduleRow = $this->getConnection()->executeQuery($scheduleSql,$flag)->fetch();
            $relations_service = $this->container->get('account_relation_service');
            if(!empty($scheduleRow)){
                $updateSql = "UPDATE contact_card_schedule SET status=0 WHERE flight_id=:id";
                $this->getConnection()->executeUpdate($updateSql,$flag);
                $relations_service->syncRemarkSchedule($scheduleRow['id'],$scheduleRow['vcard_id'],$scheduleRow['user_id'],2,'delete',$this->getTimestamp());
            }
        }
    }
}
