<?php

namespace Oradt\ServiceBundle\Services;

use Oradt\StoreBundle\Entity\ContactCard;
use Oradt\StoreBundle\Entity\Contact;
use Oradt\Utils\RandomString;
use Oradt\Utils\Codes;
use Oradt\StoreBundle\Entity\ContactCardSync;
use Oradt\StoreBundle\Entity\ContactCardGroup;
use Oradt\StoreBundle\Entity\ContactCardGroupSync;
use Oradt\StoreBundle\Entity\ContactCardGroupPassword;
use Oradt\StoreBundle\Entity\ContactGroup;
use Oradt\StoreBundle\Entity\ContactCardExtend;
use Oradt\StoreBundle\Entity\ContactGroupPassword;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Oradt\StoreBundle\Entity\ContactCardProperties;
use Oradt\StoreBundle\Entity\ContactCardGroupMap;
use Oradt\StoreBundle\Entity\ContactFromIntroducation;
use Oradt\StoreBundle\Entity\ContactPrivateLocation;
use Oradt\Utils\PhpZip;
use Oradt\StoreBundle\Entity\ContactCardTagmap;
use Oradt\Utils\SaveFile;
use Oradt\Utils\Str2PY;
use PDO;
use Oradt\StoreBundle\Entity\ContactRelationPermission;
use Doctrine\Common\Cache\FilesystemCache;
use Oradt\StoreBundle\Entity\ContactCardSchedule;
use Oradt\StoreBundle\Entity\ContactCardRemind;
use Symfony\Component\Security\Acl\Exception\Exception;
use Oradt\ServiceBundle\Services\CurlService;
use Oradt\StoreBundle\Entity\ScanCardPicture;
use Oradt\StoreBundle\Entity\ScanCardPictureExt;

/**
 * contact service class
 * @author huangxm
 * get name account_contact_service
 */
class ContactService extends BaseService {
    /**
     *
     * @var 更新名片数据， 0更新，1不更新
     */
    public $updateVcardFilds = 0;
    /**
     *
     * @var 当前操作联系人对像
     */
    private $currentContactObject = null;
    /**
     * 名片删除状态 值
     */
    private $statusDelete = 'deleted';
    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
        $this->em = $this->getManager("api");
    }
    /**
     * 添加名片分组操作记录
     * @param string $userId
     * @param string $groupId
     * @param string $operation
     */
    public function syncCardGroupAdd($userId,$groupId,$operation, $currentDate =''){
        if(empty($currentDate)){
            $currentDate = $this->getTimestamp();
        }
        $sync = $this->em->getRepository("OradtStoreBundle:ContactCardGroupSync")->findOneBy(
                array('userId' => $userId,'groupId' => $groupId)
            );
        if(empty($sync)){
            $sync = new ContactCardGroupSync();
            $sync->setGroupId($groupId);
            $sync->setUserId($userId);
        }
        $this->pushMessage(121, $userId , array('groupid' => $groupId,'modifedtime' => $this->getTimestamp(), 'operation' => $operation ));
        $sync->setOperation($operation);
        $sync->setLastModified( $currentDate);
        $this->em->persist($sync);
        $this->em->flush();
        return $sync;
    }

    /**
     * check the clientId of userId friends
     * @param string $userId
     * @param string $clientId
     * @return bool
     */
    public function checkFriends($userId,$clientId) {
        if(empty($userId) || empty($clientId))
            return 0;
        $query = "SELECT COUNT(*) FROM `account_friend` WHERE user_id=:userId0 AND fuser_id=:userId1";
        $params = array(
                ':userId0' => $userId,
                ':userId1' =>  $clientId
        );
        return intval($this->getConnection()->executeQuery($query , $params)->fetchColumn());
    }
    /**
     * 添加名片操作记录
     * @param string $userId
     * @param string $cardUuid
     * @param string $operation
     * @param string $cardType
     */
    public $isexchange = false;
    public $ifChangeAdr = true; //是否需要更新地址
    public function syncCardAdd($userId,$cardUuid,$operation,$cardType='false',$crontime='', $ifSendMessage='true', $currentDate=''){
        $sync = $this->em->getRepository("OradtStoreBundle:ContactCardSync")->findOneBy(
                array('userId' => $userId,'cardUuid' => $cardUuid)
        );
        if(empty($sync)){
            $sync = new ContactCardSync();
            $sync->setCardUuid($cardUuid);
            $sync->setUserId($userId);
            $sync->setCardType($cardType);
        }else{
            $cardType = $sync->getCardType();
        }

        // $this->getCacheService()->lpush('sync_list',$cardUuid); //redis list push
        //添加企业分发名片标题
        if( 'true' === $ifSendMessage ){
            $title = "";
            if(true === $this->isexchange){
                //查询名片公基本信息
                $query_info = 'SELECT FN,ORG AS company FROM `contact_card_vcardinfo` WHERE card_id=:vcardid';
                $info_arr = $this->em->getConnection()->executeQuery($query_info, array(':vcardid' => $cardUuid))->fetch();
                $title = '名片交换:'.$info_arr['FN'].' '.$info_arr['company'];
            }else{
                if('B' ===  substr($cardUuid, 0, 1)){
                    //查询名片公司名称信息
                    $query_company = 'SELECT ORG AS company FROM `contact_card_vcardinfo` WHERE card_id=:vcardid';
                    $companyname = $this->em->getConnection()->executeQuery($query_company, array(':vcardid' => $cardUuid))->fetchColumn();
                    $title = '企业名片推送:来自 '.$companyname;
                }
            }
            if (!empty($crontime)) {
                $time = intval(strtotime($crontime));
                if($time<1){
                    $time = $this->getTimestamp();
                }
            }else{
                //$time = $this->getDateTime()->format("Y-m-d H:i:s");
                $time = $this->getTimestamp();
            }
            $this->pushMessage(120, $userId,
                    array('vcardid' => $cardUuid,
                            'modifedtime' => $time , 'operation' => $operation ,
                            'cardtype' => $cardType,
                            'types' => 2
            ), '', $title);
        }
        $sync->setOperation($operation);
        if(empty($currentDate)){
            $currentDate = $this->getTimestamp();
        }
        $sync->setLastModified( $currentDate );
        if( true === $this->ifChangeAdr ){
            $sync->setIflag(0);
        }else{
            $sync->setIflag(1);
        }
        $this->em->persist($sync);
        $this->em->flush();
        /*if(true === $this->ifChangeAdr){
            $gearmanService =$this->container->get('gearman_service');
            $gearOp = array("vcardid"=>$cardUuid,"type"=>"updateVcardGeocoder");
            $gearmanService->push_job("ContactCard", $gearOp);
        }*/
        return $sync;
    }
    /**
     * 联系人查找
     *
     * @param array $array
     * @return Oradt\StoreBundle\Entity\Contact array
     */
    public function findContact($array) {
        $repository = $this->em->getRepository ( 'OradtStoreBundle:Contact' );
        $list = $repository->findBy ( $array );
        return $list;
    }

    /**
     * 查找一组名片
     *
     * @param array $array
     * @return ContactCard array
     */
    public function findContactCard($array) {
        $repository = $this->em->getRepository ( 'OradtStoreBundle:ContactCard' );
        $list = $repository->findBy ( $array );
        return $list;
    }
    /**
     * 查询一张名片
     *
     * @param array $findArray
     * @return ContactCard
     */
    public function findContactCardOneBy($findArray) {
        $result = $this->em->getRepository ( "OradtStoreBundle:ContactCard")->findOneBy ( $findArray );
        return $result;
    }

    /**
     * 查询一张名片
     *
     * @param array $findArray
     * @return ContactCardExtend
     */
    public function findContactCardExtendOneBy($findArray) {
        $result = $this->em->getRepository ( "OradtStoreBundle:ContactCardExtend")->findOneBy ( $findArray );
        return $result;
    }

    /**
     * 获取名片信息
     * @param string $vcarId
     */
    public function getCardAll($vcarId)
    {
        $card = $this->findContactCardOneBy(
                    array ('uuid' => $vcarId )
                );
        if( empty($card) )
            return false;
        $contactid = $card->getUuid();
        $contact = $this->findContactOneBy( array('contactId' => $contactid));
        $arr = array(
                'contact'      => $contact,
                'contact_card' => $card
        );
        return $arr;
    }

    /**
     * 更新名片 clientid 针对纸质名片
     * @param unknown $userId
     * @param unknown $vcardid
     * @param unknown $clientid
     * @param string $isSync
     */
    public function updateCardClientId($userId,$vcardid,$clientid , $isSync = true) {
        $query = "UPDATE contact_card SET from_uid=:clientid WHERE uuid=:vcardid AND
                 user_id=:userid AND self='false' AND from_uid=''";
        $result = $this->getConnection()->executeUpdate($query,
                array(':clientid' => $clientid,
                      ':vcardid' => $vcardid
                ,':userid' => $userId
        ));
        if($result && $isSync==true) {
            $this->syncCardAdd($userId, $vcardid, Codes::SYNC_MODIFY);
        }
    }

    public function updateFriendCard($vcarId) {
        $query="SELECT id,vcardid AS uuid FROM contact_card_exchange_log WHERE selfuuid=:vcardid LIMIT 1";

        $connection = $this->getConnection();
        $fcardinfo = $connection->executeQuery($query , array(':vcardid' => $vcarId))->fetch();
        if(empty($fcardinfo))
            return false;
        $fvcardid = $fcardinfo['uuid'];

        $q0 = 'SELECT * FROM contact_card WHERE uuid=:vcardid LIMIT 1';
        $q1 = 'SELECT * FROM contact_card_extend WHERE uuid=:vcardid LIMIT 1';
        $q2 = 'SELECT * FROM contact_card_vcardinfo WHERE card_id=:vcardid LIMIT 1';
        $card0 =  $connection->executeQuery($q0 , array(':vcardid' => $fvcardid))->fetch();
        $card1 =  $connection->executeQuery($q1 , array(':vcardid' => $fvcardid))->fetch();
        $card2 =  $connection->executeQuery($q2 , array(':vcardid' => $fvcardid))->fetch();

        return $this->updateCard($vcarId, $card0, $card1, $card2);
    }



    private function updateCard($uuid,$card0,$card1,$card2) {
        //更新标签
        $query = 'SELECT remark,user_id,from_uid FROM contact_card WHERE uuid=:vcardid LIMIT 1';
        $dbarr = $this->getConnection()->executeQuery($query , array(':vcardid' => $uuid))->fetch();
        if(empty($dbarr))
            return false;
        $remark='';
        if(empty($dbarr['remark']))
            $remark = $dbarr['remark'];
        $userid = $dbarr['user_id'];
        $clientid = $dbarr['from_uid'];

        $this->getConnection()->beginTransaction();
        try{
            $tagslist = trim($card0['self_mark'],',') . ',' . trim($remark,',');
            $this->addTagMap($uuid,$tagslist , false);

            //$dirs_upload =  $this->container->get('dirs_service');
            $rootDir = $this->container->getParameter('DOC_ROOT');

            $resUrl = $card1['res_path'];

            $pictureUrl = $card0['picture'];

            //更新名片基本信息
            $query = 'UPDATE contact_card SET identity_name=:identityname,avatar=:avatar,self_mark=:self_mark,contact_name=:contact_name,latitude=:latitude,longitude=:longitude,name_pre=:name_pre,picture=:picture
                    ,last_modified=:last_modified,ifupdate=3,temp_id=:temp_id,certifcation=:certifcation,signature=:signature,background=:background,card_type=:cardtype WHERE uuid=:vcardid';
            $params = array(':vcardid' => $uuid);
            $params[':identityname'] = $card0['identity_name'];
            $params[':avatar'] = $card0['avatar'];
            $params[':cardtype'] = $card0['card_type'];
            $params[':self_mark'] = $card0['self_mark'];
            $params[':contact_name'] = $card0['contact_name'];
            $params[':latitude'] = $card0['latitude'];
            $params[':longitude'] = $card0['longitude'];
            $params[':name_pre'] = $card0['name_pre'];
            $params[':picture'] = $pictureUrl;
            $params[':last_modified'] = $this->getTimestamp();
            $params[':temp_id'] = $card0['temp_id'];
            $params[':certifcation'] = $card0['certifcation'];
            $params[':signature'] = $card0['signature'];
            $params[':background'] = $card0['background'];
            $flag = $this->getConnection()->executeUpdate($query,$params);

            //扫描名片A面
            $picpathaUrl = $card1['pic_path_a'];
            //扫描名片B面
            $picpathbUrl = $card1['pic_path_b'];

            $query = 'UPDATE contact_card_extend SET vcard=:vcard,res_path=:res_path,mark_point=:mark_point,res_md5=:res_md5,layout=:layout'
                    . ',pic_path_a=:picpatha,pic_path_b=:picpathb,re_order=:reorder WHERE uuid=:vcardid';
            $params = array(':vcardid' => $uuid);
            $params[':vcard'] = $card1['vcard'];
            $params[':res_path'] = $resUrl;
            $params[':mark_point'] = $card1['mark_point'];
            $params[':res_md5'] = $card1['res_md5'];
            $params[':layout'] = $card1['layout'];
            $params[':picpatha'] = $picpathaUrl;
            $params[':picpathb'] = $picpathbUrl;
            $params[':reorder'] = $card1['re_order'];
            $this->getConnection()->executeUpdate($query,$params);

            //更新拆分字段表
            $query = 'UPDATE contact_card_vcardinfo SET FN=:FN,ORG=:ORG,DEPAR=:DEPAR,TITLE=:TITLE,URL=:URL,TEL=:TEL,EMAIL=:EMAIL,ADR=:ADR
                            WHERE card_id=:vcardid';
            $params = array(':vcardid' => $uuid);
            $params[':FN'] = $card2['FN'];
            $params[':ORG'] = $card2['ORG'];
            $params[':DEPAR'] = $card2['DEPAR'];
            $params[':TITLE'] = $card2['TITLE'];
            $params[':URL'] = $card2['URL'];
            $params[':TEL'] = $card2['TEL'];
            $params[':EMAIL'] = $card2['EMAIL'];
            $params[':ADR'] = $card2['ADR'];
            $this->getConnection()->executeUpdate($query,$params);

            $this->getConnection()->commit();
            //$this->ifChangeAdr = false;//更新好友名片，无需触发解析名片地址
            $this->syncCardAdd($userid,$uuid,Codes::SYNC_MODIFY);

            $kafka_data = array("uuid" => $uuid,"operation"=> 'modify');
            $this->pushVcardId[] = $kafka_data;
            return true;
        }catch(\Exception $e){
            $this->getConnection()->rollBack();
            //throw $e;
            return false;
        }
    }

    /**
     * 设置当前操作联系人
     * @param Contact $contactObject
     */
    public function setContactObject($contactObject)
    {
        $this->currentContactObject = $contactObject;
    }
    /**
     * 设置当前操作联系人
     * @return Contact
     */
    public function getContactObject()
    {
        return $this->currentContactObject;
    }
    /**
     *
     * @var 保存联系人名片
     * @param ContactCard $contactCard
     * @param ContactCardExtend $extend
     * @return ContactCard
     */
    public $firstcreate = false;
    public $oldpublic = ''; //设置修改共享开关（旧数据）
    public function saveContactCard(ContactCard $contactCard ,ContactCardExtend $extend ,$currentDate = '') {
        $id = $contactCard->getId();
        if(empty($currentDate)){
            $currentDate = $this->getTimestamp();
        }
        //默认名片是否为企业名片
        $isbizCard = false;
        //初始化默认值
        if(empty($id))
        {
            $status = $contactCard->getStatus();
            if(empty($status))
                $contactCard->setStatus('active');//状态
            $contactCard->setLastModified( $currentDate );
            $contactCard->setSortTime( $currentDate );
            $cardfrom = $contactCard->getCardFrom();
            if(empty($cardfrom))
                $cardfrom='selfadd';
                $contactCard->setCardFrom($cardfrom);
            $remark = $contactCard->getRemark();
            if(empty($remark)){
                $remark = '';
            }
            $picture = $contactCard->getPicture();
            if(empty($picture))
                $contactCard->setPicture('');
            //判断当前是否已有首页名片
            if('true' === $contactCard->getSelf()){
                //初始化客服/短信加好友
                $initIndexCard = false;
                //自动设置首页名片
                if ( 1 ==  $contactCard->getNindex()) {
                    //重置首页名片
                    $resultIndex = $this->updateNindex($contactCard->getUserId());
                    if(0 === $resultIndex) {
                        $initIndexCard = true;
                    }
                }else{
                    $sql = "SELECT count(id) AS num FROM `contact_card` WHERE user_id=:userid AND self='true' AND nindex=1 AND status='active'";
                    $num = $this->em->getConnection()->executeQuery($sql, array(":userid" => $contactCard->getUserId()))->fetchColumn();
                    if($num < 1){
                        $contactCard->setNindex(1);
                        $initIndexCard = true;
                    }
                }
                if(true === $initIndexCard){
                    //echo "__执行初始化首页名片操作___";
                    $this->firstcreate = true;
                }
            }else{
                $contactCard->setNindex(0);
            }
            $contactCard->setContactName('');
            //$contactCard->setCertifcation(0);
            $contactCard->setIfupdate(1);
            $contactCard->setNamePre('');
            $contactCard->setPrivate(0);
            $contactCard->setIsimportant(2);
            $latitude = $contactCard->getLatitude();
            if( !empty($latitude) ){
                $contactCard->setLatitude( $latitude );
            }else{
                $contactCard->setLatitude(0);
            }
            $longitude = $contactCard->getLongitude();
            if( !empty($longitude) ){
                $contactCard->setLongitude( $longitude );
            }else{
                $contactCard->setLongitude(0);
            }
            $background = $contactCard->getBackground();
            if(!empty($background)){
                $contactCard->setBackground( $background );
            }else{
                $contactCard->setBackground('');
            }
            $certifcation = $contactCard->getCertifcation();
            if(!empty($certifcation)){
                $contactCard->setCertifcation( $certifcation );
            }else{
                $contactCard->setCertifcation(0);
            }
            $signature = $contactCard->getSignature();
            if(!empty($signature)){
                $contactCard->setSignature( $signature );
            }else{
                $contactCard->setSignature('');
            }
            $contactCard->setRemark($remark);
            $contactCard->setUseTemp('none');//使用模版
            $contactCard->setVersion('none');//版本
            $contactCard->setShareReference(0);
            $contactCard->setClientTimestamp(0);
            $contactCard->setCreatedTime( $currentDate );
            $cardType = $contactCard->getCardType();
//            if(empty($cardType))
//                $contactCard->setCardType('other');//self or other

            if('true' === $contactCard->getSelf()){
                $contactCard->setFromUid($contactCard->getUserId());
            }
            //名片识别失败状态
            $contactCard->setReasonId(0);
            $sourceId = $contactCard->getSourceUuid();
            if ( empty($sourceId) && ($contactCard->getSelf() ==='true')) {
                $contactCard->setSourceUuid('');//源名片uuid
            }elseif(empty($sourceId) && ($contactCard->getSelf() ==='false')){
                $sql="SELECT uuid,biz_id FROM contact_card WHERE user_id=:userid AND nindex=1 AND  status='active' AND self='true' ";
                $card = $this->em->getConnection()->executeQuery($sql,array("userid"=>$contactCard->getUserId()))->fetch();
                $cardSourceUuid = empty($card['uuid'])? '':$card['uuid'];                
                $isbizCard = empty($card['biz_id'])? false:true;                
                $contactCard->setSourceUuid( $cardSourceUuid );
            }else{
                $contactCard->setSourceUuid($sourceId);
            }
            $contactCard->setPayfee(0);//设置名片价格
            
            $xyz = $contactCard->getXyz();
            if( empty($xyz) ){
                $contactCard->setXyz('');
            }
            $identityname = $contactCard->getIdentityName();
            if(empty($identityname))
                $contactCard->setIdentityName('');
            $avatar = $contactCard->getAvatar();
            if(empty($avatar))
                $contactCard->setAvatar('');
            $isfriend = $contactCard->getIsfriend();
            if( $isfriend < 1 ){
                $contactCard->setIsfriend( 0 );
            }
            //实例化姓名手机MD5
            $contactCard->setMd5ValueFm( '' );
            $sources = $contactCard->getSourceType();
            $extend->setReOrder('');//名片富媒体、个人信息等名片详情页排序字段 初始化为空
            $paramsArrs = array(
                'xyz'=>$xyz,
                'channel'=>$cardfrom,
                'savecontact'=>1,
                'sourcetype'=>$sources
            );
            if($contactCard->getSelf()=='false'){
                $this->systemremindcard($contactCard->getUuid(),$contactCard->getUserId(),$paramsArrs);
            }
            //设置kafka动作(add,modify,delete)
            $kafka_op = "add";

            $extend->setLatLng('');

            //是否显示精准识别按钮
            $contactCard->setShowBtn("1");
        }

        if( !isset($kafka_op) ){
            $kafka_op = "modify";
        }
        $sourcetype = $contactCard->getSourceType();
        if(empty($sourcetype)){
            $contactCard->setSourceType('');
        }
        $localuuid = $contactCard->getLocalUuid();
        if(empty($localuuid)){
            $contactCard->setLocalUuid('');
        }
        $markpoint = $extend->getMarkPoint();
        if(empty($markpoint)) {
            $extend->setMarkPoint('');
        }
        $xlatitude = $contactCard->getXLatitude();
        if(empty($xlatitude)){
            $contactCard->setXLatitude(0);
        }
        $xlongitude = $contactCard->getXLongitude();
        if(empty($xlongitude)){
            $contactCard->setXLongitude(0);
        }
        $xyz = $contactCard->getXyz();
        if(empty($xyz)) {
            $contactCard->setXyz('');
        }
        $xyztime = $contactCard->getXyztime();
        if(empty($xyztime)) {
            $contactCard->setXyztime($currentDate);
        }
        $language = $contactCard->getLanguage();
        if(empty($language)){
            $contactCard->setLanguage('');
        }
        //名片交换ID
        $exchId = $contactCard->getExchId();
        if(empty($exchId)){
            $extId = $contactCard->getUuid();
            $contactCard->setExchId($extId);
        }
        $isimportant = $contactCard->getIsimportant();
        if(empty($isimportant)){
            $contactCard->setIsimportant(2);
        }
        $tempId = $contactCard->getTempId();
        if(empty($tempId)){
            $contactCard->setTempId('');
        }
        $private = $contactCard->getPrivate();
        if(empty($private)){
            $contactCard->setPrivate(0);
        }
        $contactCard->setBasicStatus(0);
        $fromUid = $contactCard->getFromUid();

        $self = $contactCard->getSelf();
        if('false' === $self){
            if(empty($fromUid)) {
                $contactCard->setBasicStatus(1);
                $contactCard->setFromUid('');
            }
        }

        //精准识别状态
        $handleState = $contactCard->getHandleState();
        if(empty($handleState)){
            $contactCard->setHandleState('');
        }
        $resMd5 = $extend->getResMd5();
        //处理zip包文件md5码
        if(empty($resMd5)) {
            $extend->setResMd5('');
        }

        $markpoint = $extend->getMarkPoint();
        if(empty($markpoint)) {
            $extend->setMarkPoint('');
        }
        $picPathA = $extend->getPicPathA();
        if(empty($picPathA)){
            $extend->setPicPathA('');
        }
        $picPathB = $extend->getPicPathB();
        if(empty($picPathB)){
            $extend->setPicPathB('');
        }
        $layout = $extend->getLayout();
        if(empty($layout)) {
            $extend->setLayout('');
        }
        //容余userid
        $extendUserId = $extend->getUserId();
        if(empty($extendUserId)) {
            $extend->setUserId($contactCard->getUserId());
        }

        //如果public为off,则设置payfee为0
        if( 0 < $contactCard->getPayfee() && 'off' == $contactCard->getPublic()){
            $contactCard->setPayfee(0);
        }

        if( 0===$this->updateVcardFilds || 1 == $contactCard->getNindex() ){
            $insertArray = array();
            if(!empty($this->vcard_array)){
                $insertArray = $this->vcard_array;
            }else{
                $insertArray = $this->setVcard($extend->getVcard());
                //$insertArray = $this->vcard_array;
            }
            if( 0===$this->updateVcardFilds ){
                if(isset($insertArray['Md5Value']))
                {
                    $contactCard->setMd5Value( $insertArray['Md5Value'] );
                }
                if(isset($insertArray['Md5ValueFm'])){
                    $contactCard->setMd5ValueFm( $insertArray['Md5ValueFm'] );
                }

                if(isset($insertArray['FN']))
                {
                    $contactName = $insertArray['FN'];
                    if(empty($contactName))
                        $contactName = '';
                    $contactCard->setContactName($contactName);
                }

                $namepre = '';
                if(!empty($contactName)) {
                    $strpy = new Str2PY();
                    $namepre = $strpy->getPre($contactName);
                    $contactCard->setNamePre($namepre);
                }
                //置空名片坐标，如果没有地址信息
                if(empty($insertArray['ADR'])){
                    $contactCard->setLatitude(0);
                    $contactCard->setLongitude(0);
                    $extend->setLatLng('');
                }
            }
        }
        //名片绑定企业ID
        $bizId = $contactCard->getBizId();
        if( empty($bizId) ){
        	$contactCard->setBizId('');
        }
        $this->em->persist($extend);
        $this->em->persist ( $contactCard );
        $this->em->flush ();
        /*if(empty($id)){
            //验证名片容量
            $this->cardcapacity($contactCard->getUserId());
        }*/
        if($contactCard->getId()>0 && ( 0===$this->updateVcardFilds || 1 == $contactCard->getNindex() ))
        {
            $this->saveCardProperties($contactCard,$extend);
        }
        if( 'scan' === $contactCard->getCardType() ) {
            //$extendnews = $this->saveScancardRes($extend);
            if($kafka_op == 'add'){
                $vcardarr = array(
                    "vcard" => $extend->getVcard(),
                    "picture" => $extend->getPicPathA(),
                    "picpatha"=> $extend->getPicPathA(),
                    "picpathb"=> $extend->getPicPathB(),
                    "respath"=> $extend->getResPath(),
                    "markpoint"=>$extend->getMarkPoint()
                );
                $userId = $extend->getUserId();
                $editarr=array("from_uid" => $userId,"card_id" => $contactCard->getUuid(),'newvcard'=>array(),'oldvcard'=>$vcardarr);
                $this->addeditlog($userId,$editarr,$contactCard->getUuid(),1);
            }
        }
        $this->vcard_array = null;
        //处理名片kafka消息
        //$this->kafkaContactCard( $contactCard, $kafkaf_op );
        $kafka_data = array("uuid" => $contactCard->getUuid(),"operation"=> $kafka_op);
        if( isset($initIndexCard) && true === $initIndexCard){
            $kafka_data['initdefaut'] = 1;
        }
        if( 'modify' === $kafka_op ){
            if( !empty( $this->oldpublic ) && $this->oldpublic != $contactCard->getPublic() ){
                $kafka_data['newpublic'] = $contactCard->getPublic();
            }
        }
        //企业客户名片
        if($isbizCard ){
            $kafka_data['bizcard'] = 1;
        }
        $this->pushVcardId[] = $kafka_data;
        //清空语音搜索名片数据缓存
        //$this->clearsearch($contactCard->getUserId());
        return $contactCard;
    }

    /*
     * 个人名片容量判断
     * 如果该service返回false则终止
     * */
    public function cardcapacity($userid){
        $sql="SELECT (a.card_capacity-(SELECT count(*) as cardnum_now FROM contact_card WHERE user_id=:userid AND `status`='active' AND self='false')) as cardnum  FROM account_basic_detail as a WHERE user_id=:userid";
        $cardnum = $this->getManager()->getConnection()->executeQuery($sql,array("userid"=>$userid))->fetch();
        $param=array(
            "userid"=>$userid,
            "num"=>$cardnum['cardnum']
        );
        if(!empty($cardnum) && ($cardnum['cardnum'] == 100 || $cardnum['cardnum'] == 0 )){
            $title = "您的名片夹存储容量还剩".$cardnum['cardnum']."张，要存储更多的名片，请及时扩容。";
            $this->pushMessage(222,$userid,$param,'',$title);
            if($cardnum['cardnum'] <= 0){
                return false;
            }
        }
    }
    /*
     * 添加名片生成为解析的名片系统备注
     * */
    public function systemremindcard($cardid,$userId,$paramArr){
        $cardtypearr=array("scan"=>"拍照录入","selfadd"=>"手动录入","dm"=>"扫描仪录入","appdm"=>"扫描仪录入","contacts"=>"通讯录导入","buy"=>"购买","mail"=>"邮寄","wechatscan"=>"微信公众号同步");//扫描仪scanister
        if(!in_array($paramArr['channel'],array_keys($cardtypearr))){
            return true;
        }
        $time = $this->getTimestamp();
        $json=json_encode(array($paramArr));
        $cardRemark = new ContactCardRemind();
        $cardRemark->setVcardId($cardid);
        $cardRemark->setUserId($userId);
        $cardRemark->setRemark($json);
        $cardRemark->setRemarkDate($time);
        $cardRemark->setRemindTime(-1);
        $cardRemark->setFlagTime(0);
        $cardRemark->setModifyTime($time);
        $cardRemark->setStartTime(0);
        $cardRemark->setEndTime(0);
        $cardRemark->setCycle(0);
        $cardRemark->setStatus(2);
        $cardRemark->setScheduleId(0);
        $cardRemark->setFromId($userId);
        $cardRemark->setSortid(0);
        $cardRemark->setType(1);
        $cardRemark->setClasses(0);
        $cardRemark->setTimeset(1);
        //保存名片项目信息
        $this->em->persist($cardRemark);
        $this->em->flush();
        $id = $cardRemark->getId();
        /*$gearmanService = $this->container->get ('gearman_service');
        $gearOp = array("id"=>$id,"type"=>"sysremind");
        $gearmanService->push_job("ContactCard", $gearOp);*/
        return true;
    }

    /**
     *
     * @param unknown $layout
     * @param unknown $uuid
     * @param unknown $userId
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return boolean|unknown
     */
    public function saveCardLayoutRes($layout,$uuid , $userId, \Symfony\Component\HttpFoundation\Request $request) {

        $dirs_upload = $this->container->get('dirs_service');
        $uparr = $dirs_upload->getCardDir($userId,$uuid);
        $layoutJson = json_decode($layout , true) ;

        //print_r($layoutJson);
        //保存单个文件
        $SaveFile = function($key) use($uparr,$request,$dirs_upload) {
            if(empty($key))
                return false;
            $f = $request->files->get($key);
            if(empty($f))
                return false;

            $uparr['filename'] = $key;//'637f4bd1-d2c4-433b-9619-3d52bb87da6e';

            $picture_Url = $dirs_upload->uploadFile($f,$uparr);
            return $picture_Url;
        };
        if(isset($layoutJson['ITEMS'])) {
            foreach ($layoutJson['ITEMS'] as $item) {
                if(isset($item['resId'])) {
                    $path = $SaveFile($item['resId']);
                    //添加资源文件记录
                    if($item['itemType'] == 'IMAGE'){
                        $this->addFileRecord("resource", $userId, $uuid, $path);
                    }
                }
            }
        }
        if(isset($layoutJson['background'])) {
            if(isset($layoutJson['background']['name'])) {
                $path = $SaveFile($layoutJson['background']['name']);
                //添加资源文件记录
                $this->addFileRecord("resbackground", $userId, $uuid, $path);
            }
        }
        return true;
    }
    public function updateCardLayoutRes($layout,$uuid , $userId, \Symfony\Component\HttpFoundation\Request $request) {
        $dirs_upload = $this->container->get('dirs_service');
        $uparr = $dirs_upload->getCardDir($userId,$uuid);
        $layoutJson = json_decode($layout , true) ;
        //print_r($layoutJson);
        //保存单个文件
        $SaveFile = function($key) use($uparr,$request,$dirs_upload) {
            if(empty($key))
                return false;
            $f = $request->files->get($key);
            if(empty($f))
                return false;
            $uparr['filename'] = $key;//'637f4bd1-d2c4-433b-9619-3d52bb87da6e';
            $picture_Url = $dirs_upload->uploadFile($f,$uparr);
            return $picture_Url;
        };
        $flag = false;
        //组织Items
        $itemArr = array();
        foreach($layoutJson['ITEMS'] as $v){
            $itemArr[$v['resId']] = $v['itemType'];
        }
        if(isset($layoutJson['resources'])) {
            foreach ($layoutJson['resources'] as $item) {
                if(isset($item['name'])) {
                    $path = $SaveFile($item['name']);
                    $flag = true; //是否删除压缩包文件
                    //判断背景
                    if($item['name'] == $layoutJson['background']['name']){
                        $this->addFileRecord("resbackground", $userId, $uuid, $path);
                    }
                    //判断Items
                    if(array_key_exists($item['name'], $itemArr) && $itemArr[$item['name']] == 'IMAGE'){
                        $this->addFileRecord("resource", $userId, $uuid, $path);
                    }
                }
            }
        }
        if(isset($layoutJson['oldResources'])) {
            foreach ($layoutJson['oldResources'] as $item) {
                if(isset($item['name'])) {
                    $filename = $uparr['PATH'].$item['name'].".".$item['suffix'];
                    $this->removeFile($filename);
                    $flag = true;
                }
            }
        }
        if($flag === true){
            $this->removeFile($uparr['PATH'].$uuid."_layout.zip");
        }
        return true;
    }
    /**
     * 添加资源文件记录
     * @param $type 记录类型
     * @param $userId 用户ID
     * @param $uuid 模块id
     * @param $path 文件路径
     * return boolean
     */
    public function addFileRecord($type, $userId, $uuid, $path){
        return true;
        if(empty($path)) {
            return true;
        }
        $dirs_upload = $this->container->get('dirs_service');
        //获取文件存储路径
        $doc_root = $this->container->getParameter('DOC_ROOT');
        //源文件
        $resfile = $doc_root.$path;
        $ext = substr(strrchr($resfile, '.'), 1);

        if(!file_exists($resfile)){
            return true;
        }
        //echo  $resfile ;exit();
        $resmd5 = md5_file($resfile);

        //目标文件
        $path_arr = $dirs_upload->getCardDir($userId);
        $path_arr["PATH"] = $path_arr["PATH"]."resource" ."/";
        $path_arr["filename"] = $resmd5;
        $desfile = $path_arr["DOC_ROOT"] .$path_arr["PATH"] .$resmd5 .'.'.$ext;
        if(file_exists($resfile)&&!file_exists($desfile)){
            $saveFile = new SaveFile($resfile);
            //复制文件
            $resUrl = $dirs_upload->copyFile($saveFile,$path_arr);
            //生成文件缩略图
            $resThumbUrl = $dirs_upload->getThumbPath($resUrl,320,180);
            //生成recordid
            $recordid = RandomString::make(32,Codes::A);
            //插入数据
            $params = array(
                ":userId" => $userId,
                ":recordid" => $recordid,
                ":type" => $type,
                ":uuid" => $uuid,
                ":respath" => $resUrl,
                ":resthumbpath" => $resThumbUrl,
                ":resmd5" => $resmd5,
                ":createtime" => $this->getTimestamp()
            );
            $sql = "INSERT INTO `account_file_record` (user_id,record_id,record_type,uuid,res_path,res_thumb_path,res_md5,create_time)"
                    . " values (:userId,:recordid,"
                    . ":type,:uuid,:respath,:resthumbpath,:resmd5,:createtime)";
            $this->getConnection()->executeUpdate($sql, $params);
        }
    }
    /**
     * 查询好友名片
     * @param string $userId
     * @param string $clientId
     * @param bool $descAsc
     */
    public function getClientFirstCardId($userId,$clientId , $descAsc = true) {
        $query = "SELECT uuid FROM `contact_card` WHERE user_id=:userId AND
                from_uid=:clientId AND status='active' AND self='false'";
        if($descAsc) {
            $query .= " ORDER BY id ASC LIMIT 1";
        }else{
            $query .= " ORDER BY id DESC LIMIT 1";
        }
        return $this->getManager()->getConnection()->executeQuery($query,
                array(':userId' => $userId , ':clientId' => $clientId))->fetchColumn();
    }

    /**
     * 保存扫描名片资源
     * @param ContactCardExtend $extend
     */
    public function saveScancardRes($extend)
    {
        $uuid = $extend->getUuid();
        $picpatha = $extend->getPicPathA();
        if (substr($uuid, 0, 1) === 'C' && empty($picpatha)) {
            //获取图片路径
            $scanCardService = $this->container->get("scancard_pic_service");
            $card = $scanCardService->getScanCardExtInfoByCardId($uuid);
            if (empty($card)) return false;

            $dirs_upload = $this->container->get('dirs_service');
            $thumb_picture = $dirs_upload->getThumbPath($card['pic_path_a'], 1200 / 2, 720 / 2, 'width');

            $resmd5 = '';
            $respath = '';
            if (empty($card['pic_path_a'])) {
                $card['pic_path_a'] = '';
            }
            if (empty($card['pic_path_b'])) {
                $card['pic_path_b'] = '';
            }
            $sql = 'UPDATE contact_card_extend SET res_path=:respath,res_md5=:resmd5,pic_path_a=:picpatha,pic_path_b=:picpathb WHERE uuid=:uuid';
            $this->getConnection()->executeUpdate($sql, array(':respath' => $respath, ':resmd5' => $resmd5, ':picpatha' => $card['pic_path_a'], ':picpathb' => $card['pic_path_b'], ':uuid' => $uuid));
            $sql = 'UPDATE contact_card SET picture=:thumb WHERE uuid=:uuid';
            $this->getConnection()->executeUpdate($sql, array(':thumb' => $thumb_picture, ':uuid' => $uuid));
            $scanCardService->updateScancardThumbnail($thumb_picture, $uuid);
            $extend->setPicPathA($card['pic_path_a']);
            $extend->setPicPathB($card['pic_path_b']);
        }
        return $extend;
    }

    /**
     * 批量移动名片到指定组
     *
     * @param string $userId
     * @param string $cardIds
     * @param string $groupId
     * @param bool $isadd 第一次添加，默认为true
     */
    public function addCardGroupMap($userId,$groupId,$cardIds,$isadd = true)
    {
        if(empty($cardIds) || empty($groupId))
            return false;
        if($isadd){
            return $this->saveCardGroupMap($userId, $cardIds, $groupId);
        }

        $cardIdArr = array_unique(explode(',', $cardIds));
        //$defaultGroupId = $this->getDefaultContactCardGroup ( $userId );
        //$vipGroupId = null;
        //$isDefaultUpdate = false;
//        $isDelete = false;
//        if($defaultGroupId!=$groupId){
//            $isDelete = true;
//        }
        foreach ($cardIdArr as $cardId)
        {
            if(empty($cardId))
                continue;
            $mapObject = $this->em->getRepository ( "OradtStoreBundle:ContactCardGroupMap" )->findBy ( array (
                    'userId' => $userId,
                    'cardId' => $cardId,
                    'groupId' => $groupId
            ) );
            //echo 'aaa';
            if(!empty($mapObject))
            {
                continue;
            }

            $groupList = array();
            foreach($mapObject as $item){
                $groupList[$item->getGroupId()] = '';
            }
            if(key_exists($groupId, $groupList)) {
                continue;
            }
            $this->saveCardGroupMap($userId, $cardId, $groupId);
            //当前组不是默认组时才执行此操作  验证是否要删除默认组
            // 1 “未分组”内名片分组到其他分组内，“未分组”不保留该名片；
            //todo 和删除策略4有冲突
//            if($isDelete && key_exists($defaultGroupId, $groupList)){
//                $this->deleteCardGroupMap($userId, $cardId, $defaultGroupId, $defaultGroupId);
//                $isDefaultUpdate = true;
//            }
        }
        //exit('aaa');
        //更新当前组
        $this->syncCardGroupAdd($userId, $groupId, Codes::SYNC_MODIFY);
        //更新默认组
//        if($isDefaultUpdate){
//            $this->syncCardGroupAdd($userId, $defaultGroupId,  Codes::SYNC_MODIFY);
//        }
        return true;
    }

    /**
     * 添加名片所属分组 映射
     *
     * @param string $userId
     * @param string $cardId
     * @param string $groupId
     * @return boolean
     */
    private function saveCardGroupMap($userId,$cardId,$groupId)
    {
        /*
        $mapObject = $this->em->getRepository ( "OradtStoreBundle:ContactCardGroupMap" )->findOneBy (
                 array (
                         'userId' => $userId,
                'cardId' => $cardId,
                'groupId' => $groupId
        ) );

        if(!empty($mapObject))
            return true;
            */
        //$this->em->createQuery("LOCK TABLES contact_card_group_map WRITE")->execute();
        //$this->getConnection()->exec("LOCK TABLES contact_card_group_map WRITE");
        try{
            $mapObject = new ContactCardGroupMap();
            //$mapId = RandomString::make(32);
            //$mapObject->setMapId($mapId);
            $mapObject->setUserId($userId);
            $mapObject->setCardId($cardId);
            $mapObject->setGroupId($groupId);
            $this->em->persist($mapObject);
            $this->em->flush();
            //$this->em->createQuery("UNLOCK TABLES")->execute();
            //$this->getConnection()->exec("UNLOCK TABLES");
        }catch (\Exception $ex){
            throw $ex;
        }

        return true;
    }

    /**
     * 名片移出名片组
     * @param string $userId
     * @param string $cardId
     * @param string $groupId
     * @param string $defaultGroupId
     * @return boolean
     */
    public function deleteCardGroupMap($userId,$cardId,$groupId,$defaultGroupId)
    {
        $mapObject = $this->em->getRepository ( "OradtStoreBundle:ContactCardGroupMap" )->findBy ( array (
                'userId' => $userId,
                'cardId' => $cardId
        ) );

        $groupList = array();
        foreach($mapObject as $item){
            $groupList[$item->getGroupId()] = $item;
        }
        $sum = count($groupList);
        /*
        echo sprintf("default:%s\r\n",$defaultGroupId);
        echo sprintf("vip:%s\r\n",$vipGroupId);
        echo sprintf("count:%d\r\n",$sum);
        print_r($groupList);
        */
        if(!key_exists($groupId,$groupList)){
            //echo "not found";
            return true;
        }
        // 1 group 只存在“未分组”中，名片被直接删除  (进回收站)；
//        if(key_exists($defaultGroupId,$groupList) && 1==$sum && $groupId==$defaultGroupId){
//            $this->updateCardStatus($userId, $cardId, $this->statusDelete);
//            return true;
//        }

        //if(key_exists($defaultGroupId,$groupList) && key_exists($vipGroupId,$groupList) && 2==$sum && $groupId==$defaultGroupId){
        //    $this->updateCardStatus($userId, $cardId, $this->statusDelete);
        //    return true;
        //}

        //当前操作对像
        $mapObject = $groupList[$groupId];
        //3 存在多个其他名片夹中，名片只从目标名片夹中删除；
        //4 “VIP”+”未分组“中，从未分组中删除，名片会直接删除 (名片删除一个分组)；
        //5 “VIP”+”未分组“中，从vip.中删除，名片会直接删除，但未分组中还保留；
        //7 “VIP”+”已分组“中，从vip.中删除，名片会直接删除，但已分组中还保留。
        //$this->syncCardGroupAdd($userId, $groupId, Codes::SYNC_MODIFY);
        $this->em->remove($mapObject);
        $this->em->flush();
        //删除完后，检查该卡是否还有分组信息，无的话，需要加到默认分组中
        //2 只存在单个其它名片夹中，名片移到“未分组”名片夹中；
        if($sum==1)
        {
            //去除此操作
            //$this->addCardGroupMap($userId, $defaultGroupId, $cardId);
        }
        /*
        else{
            //6 “VIP”+”已分组“中，从已分组中删除，名片会返回到“未分组”；
            if( key_exists($vipGroupId,$groupList)
             && !in_array($groupId, array($defaultGroupId,$vipGroupId)) //当前组为自定义组
             && !key_exists($defaultGroupId,$groupList)) //该张名片不存在 default组中
            {
                $this->addCardGroupMap($userId, $defaultGroupId, $cardId);
            }
        }
        */

        return true;
    }

    /**
     * 保存联系人位置
     * @param ContactCard $contactCard
     * @param string $address
     * @return \Oradt\StoreBundle\Entity\ContactPrivateLocation
     */
    public function saveContactGeocoder(ContactCard $contactCard,$address){

        if(empty($contactCard) || empty($address))
            return null;
        try{
            $mapService = $this->container->get("map_service");

            $mapArray = $mapService->getGeocoder($address);
            if(empty($mapArray) || !isset($mapArray['lng']))
                return null;


            $contactCard->setLatitude($mapArray['lat']);
            $contactCard->setLongitude($mapArray['lng']);
            $this->em->persist($contactCard);
            $this->em->flush();

            return $contactCard;
        }catch(\Exception $ex){
            //echo $ex->getMessage();
            return null;
        }
    }

    private $vcard_array = null;

    public function setVcard($vcard) {
        $insertArray = json_decode($vcard, true);
        if( !empty( $insertArray )){
            //$insertArray = json_decode($vcard, true);
            $vcardJsonService = $this->container->get("vcard_json_service");
            $outArray = $vcardJsonService->setVcard($vcard);
            $this->vcard_array = $outArray;
        }else{
            $this->vcard_array = $this->parseVcard($vcard);
        }
        return $this->getVcardArray();
    }

    public function getVcardArray() {
        return $this->vcard_array;
    }

    /**
     * get contact Id from clientId
     * @param string $userId
     * @param string $clientId
     * @return string
     */
    public function getContactIdFromUid($userId,$clientId) {
        $sql = 'SELECT contact_id FROM contact WHERE user_id=:userId AND from_uid=:clientid LIMIT 1';
        $query = $this->getConnection()->executeQuery($sql,array(':userId' => $userId,':clientid' => $clientId));
        return $query->fetchColumn();
    }

    /**
     * 解析VCARD 保存名片扩展信息
     * @param ContactCard $contactCard
     * @param ContactCardExtend $extend
     */
    public function saveCardProperties(ContactCard $contactCard,ContactCardExtend $extend) {
        //$vcard = $extend->getVcard();
        if(empty($this->vcard_array)){
            return false;
        }
        $cardId = $contactCard->getUuid ();
        $userId = $contactCard->getUserId();
        //事务开始
        //$this->em->beginTransaction();
       // try{
            //$conn = $this->container->get ( 'database_connection' );

            //$insertArray = $this->parseVcard($vcard);
            $insertArray = $this->vcard_array;
            //print_r($insertArray);exit('aa');
            if($insertArray!==false){
                /* 2017-08-14 改为 java 接改kafka消息清加
                if(isset($insertArray['USERID'])){
                    unset($insertArray['USERID']);
                }
                $params = array(':user_id' => $userId ,':card_id' => $cardId);
                $query = "SELECT id FROM contact_card_vcardinfo WHERE user_id=:user_id AND card_id=:card_id";
                $result = $this->getConnection()->executeQuery($query,$params)->fetchColumn();
                if(empty($result)) {
                    //insert
                    $query = 'INSERT INTO contact_card_vcardinfo (card_id,user_id,FN,ORG,DEPAR,TITLE,URL,CELL,TEL,EMAIL,ADR,INDUSTRY)
                             VALUES (:card_id,:user_id,:FN,:ORG,:DEPAR,:TITLE,:URL,:CELL,:TEL,:EMAIL,:ADR,:INDUSTRY)';

                    $params[':FN'] = isset($insertArray['FN']) ? $insertArray['FN'] : '';
                    $params[':ORG'] = isset($insertArray['ORG']) ? trim($insertArray['ORG'],",") : '';
                    $params[':DEPAR'] = isset($insertArray['DEPAR']) ? $insertArray['DEPAR'] : '';
                    $params[':TITLE'] = isset($insertArray['TITLE']) ? $insertArray['TITLE'] : '';
                    $params[':URL'] = isset($insertArray['URLS']) ? $insertArray['URLS'] : '';
                    $params[':CELL'] = isset($insertArray['MOBILES']) ? $insertArray['MOBILES'] : '';
                    $params[':TEL'] = isset($insertArray['TEL']) ? $insertArray['TEL'] : '';
                    $params[':EMAIL'] = isset($insertArray['EMAIL']) ? $insertArray['EMAIL'] : '';
                    $params[':ADR'] = isset($insertArray['ADR']) ? $insertArray['ADR'] : '';
                    $params[':INDUSTRY'] = isset($insertArray['INDUSTRY']) ? $insertArray['INDUSTRY'] : '';

                }else{
                    //update
                    $params = array(':id' => $result);
                    $query = 'UPDATE contact_card_vcardinfo SET FN=:FN,ORG=:ORG,DEPAR=:DEPAR,TITLE=:TITLE,URL=:URL,CELL=:CELL,TEL=:TEL,EMAIL=:EMAIL,ADR=:ADR,INDUSTRY=:INDUSTRY
                            WHERE id=:id';
                    $params[':FN'] = isset($insertArray['FN']) ? $insertArray['FN'] : '';
                    $params[':ORG'] = isset($insertArray['ORG']) ? $insertArray['ORG'] : '';
                    $params[':DEPAR'] = isset($insertArray['DEPAR']) ? $insertArray['DEPAR'] : '';
                    $params[':TITLE'] = isset($insertArray['TITLE']) ? $insertArray['TITLE'] : '';
                    $params[':URL'] = isset($insertArray['URLS']) ? $insertArray['URLS'] : '';
                    $params[':CELL'] = isset($insertArray['MOBILES']) ? $insertArray['MOBILES'] : '';
                    $params[':TEL'] = isset($insertArray['TEL']) ? $insertArray['TEL'] : '';
                    $params[':EMAIL'] = isset($insertArray['EMAIL']) ? $insertArray['EMAIL'] : '';
                    $params[':ADR'] = isset($insertArray['ADR']) ? $insertArray['ADR'] : '';
                    $params[':INDUSTRY'] = isset($insertArray['INDUSTRY']) ? $insertArray['INDUSTRY'] : '';
                }

                $this->getConnection()->executeUpdate($query , $params);
                */
            }
            //更新姓名、头像等信息
            if( 1 == $contactCard->getNindex() && 'true' === $contactCard->getSelf() ) {
                $accountService = $this->container->get("account_basic_service");
                //传递头像
                $params[':AVATAR'] = $contactCard->getAvatar();
                $params[':ENAME'] = isset($insertArray['ENAME']) ? $insertArray['ENAME'] : '';
                $params[':URLS'] = isset($insertArray['URLS']) ? $insertArray['URLS'] : '';
                if( 1 == $contactCard->getNindex() ){
                    $params[':cardId'] = $contactCard->getUuid();
                }
                $accountService->extendDetail = $params;
                $accountService->setRealname($contactCard->getUserId(),$contactCard->getContactName());
            }

            /**
            生成新的符合条件的数组
             */
            // $inserIntoProData =  $this->container->get('vcard_data_service')->parseVcardOneText($vcard,true,true);
            /**
            存储到数据库
             */
            // $this->insertIntoProperties($inserIntoProData[0],$userId,$cardId);

            /*if(isset($insertArray['ADR'])){
                $this->saveContactGeocoder($contactCard, $insertArray['ADR']);
            }*/

            //$this->em->commit();
            return true;

    }
    /**
     * @param array()
     */
    public function insertIntoProperties($params,$userId,$cardId)
    {
        $type = '';
        if (isset($params) && !empty($params)) {
            foreach ($params as $k => $v) {
                /**
                 * 首先判断是否多个，判断是否含有type
                 */
                $param = array(
                    'k'=>$k,
                    'userid'=>$userId,
                    'cardid'=>$cardId,
                    );
                $this->judgeIfADdData($v,$param);
            }
        }
    }
    /**
    判断data是否多个值
     */
    public function judgeIfADdData($data,$param)
    {
            $param['status'] = 0;
            if (!empty($data) && count($data) > 1) {
                $param['status'] = 1;
                foreach ($data as $key => $value) {
                    $this->judgeIfAddType($value,$param);
                }
            }else{
                $this->judgeIfAddType($data[0],$param);
            }
    }
     /**
    判断是否type存在
     */
    public function judgeIfAddType($data,$param)
    {
        $flag = 0;
        if (!empty($data['param']) && !empty($data['param']['TYPE'])) {
            $flag = 1;
            $this->judgeIfADdValus($data,$flag,$param);
        }else{
            $this->judgeIfADdValus($data,$flag,$param);
        }
    }
    /**
    判断value是否存在，多个
     */
    public function judgeIfADdValus($data,$flag,$param)
    {
        // print_r($flag);
        // print_r($data);
        // print_r($param);
        $insertData = array();
        if (1 == $flag) {
            if (!empty($data['value']) && count($data['value']) > 1) {
                $type = '';
                foreach ($data['param']['TYPE'] as $key => $value) {
                    $type .= $value.',';
                }
                foreach ($data['value'] as $key => $value) {
                    $insertData = array(
                    'value' => $value[0],
                    'name'=> $param['k'],
                    'type' => $type,
                    'status'=>$param['status'],
                    );
                    $this->insertIntoProperPub($param['userid'],$param['cardid'],$insertData);
                }
            }else{
                $type = '';
                foreach ($data['param']['TYPE'] as $key => $value) {
                    $type .= $value.',';
                }
                $insertData = array(
                'value' => $data['value'][0][0],
                'name'=> $param['k'],
                'type' => $type,
                'status'=>$param['status'],
                );
               $this->insertIntoProperPub($param['userid'],$param['cardid'],$insertData);
            }
        }else{
            if (!empty($data['value']) && count($data['value']) > 1) {
                foreach ($data['value'] as $key => $value) {
                    $insertData = array(
                    'value' => $value[0],
                    'name'=> $param['k'],
                    'type' => '',
                    'status'=>$param['status'],
                    );
                    $this->insertIntoProperPub($param['userid'],$param['cardid'],$insertData);
                }
            }else{
               $insertData = array(
                'value' => $data['value'][0][0],
                'name'=> $param['k'],
                'type' => '',
                'status'=>$param['status'],
                );
               $this->insertIntoProperPub($param['userid'],$param['cardid'],$insertData);
            }
        }
    }
    public function insertIntoProperPub($userId,$cardId,$data)
    {
        $param = array();
        $query = 'INSERT INTO contact_card_properties (card_id,user_id,name,value,type,status)
                 VALUES (:card_id,:user_id,:name,:value,:type,:status)';
        $param = array(':user_id' => $userId ,':card_id' => $cardId);
        $param[':name']  = $data['name'];
        $param[':value'] = $data['value'];
        $param[':type']  = $data['type'];
        $param[':status']= $data['status'];
        $this->getConnection()->executeUpdate($query , $param);
    }
    public function getCardProperties($userId,$uuid)
    {
        $sql="SELECT *
                    	FROM contact_card_vcardinfo WHERE user_id=:userId AND card_id=:uuid LIMIT 1";
        $conn = $this->getConnection();
        $sth = $conn->prepare ( $sql );
        $sth->bindValue(':uuid',$uuid,PDO::PARAM_STR);
        $sth->bindValue(':userId',$userId,PDO::PARAM_STR);
        $sth->execute();
        return $sth->fetch();
    }

    /**
     * vcard 尾倒数一行插入一行  END:VCARD上面增加一行
     * @param string $vcard
     * @param string $line
     * @return string
     */
    public function vcardInsertLine($vcard,$line){
        $vcards = explode("\n", trim($vcard,"\n"));
        array_splice($vcards, -1,1,array($line,'END:VCARD'));
        $vcard = implode("\n", $vcards);
        return $vcard;
    }

    /**
     * 解析名片数据
     *
     * @param string $vcard
     * @return false|array 解析错误返false
     */
    public function parseVcard($vcard)
    {
        $array = array();
        try {
            $funcService    = $this ->container->get('function_service');
            $fileImcService = $this->container->get('file_imc_service');
            $parse = $fileImcService->parse('Vcard');
            $cardinfo = $parse->fromText($vcard);
            if(empty($cardinfo) || empty($cardinfo['VCARD']))
                return false;
            $valueLen = 127;
            //print_r($cardinfo);exit();
            $card = $cardinfo['VCARD'][0];
            //$array['N'] = $card['N'][0]['value'][0][0];
            if(isset($card['FN'])){
                $array['FN'] = $funcService->cutstr_dis($card['FN'][0]['value'][0][0], 60,'');
            }
            if(isset($card['N'])){
                $array['N'] = $card['N'][0]['value'];
            }
            if(isset($card['X-ENGLISHNAME'])){
                $array['ENAME'] = $card['X-ENGLISHNAME'][0]['value'][0][0];
            }else{
                $array['ENAME']='';
            }
            //if(isset($card['REV'])){
                //$array['REV'] = $card['REV'][0]['value'][0][0];
            //}
            //$array['NICKNAME'] = $card['NICKNAME'][0]['value'][0][0];
            if(isset($card['ORG'])){
                $array['ORG'] = $funcService->cutstr_dis($card['ORG'][0]['value'][0][0], 96,'');
                if(isset($card['ORG'][0]['value'][1][0])){
                    $array['DEPAR'] = $funcService->cutstr_dis($card['ORG'][0]['value'][1][0],96,'');
                }
            }
            //print_r($card);exit();
            if(isset($card['TITLE'])){
                $array['TITLE'] = $funcService->cutstr_dis($card['TITLE'][0]['value'][0][0], 60,'');
            }
            //if(isset($card['USERID'])){
                //$array['USERID'] = $card['USERID'][0]['value'][0][0];
            //}
            if(isset($card['URL'])){
                $array['URL'] = $funcService->cutstr_dis($card['URL'][0]['value'][0][0], 96,'');
            }
            if(isset($card['URL'])){
                $urls='';
                foreach ($card['URL'] as $item)
                {
                    $item =$item['value'][0][0] .';';
                    $urls.= $item;
                }
                $array['URLS'] = rtrim($urls,',');
            }
            //if(isset($card['TITLE'])){
            //    $array['TITLE'] = $card['TITLE'][0]['value'][0][0];
           // }
            //print_r($card['TEL']);
            if(isset($card['TEL'])){
                $tel='';
                foreach ($card['TEL'] as $item)
                {
                    $type = isset($item['param']['TYPE'][0]) ? $item['param']['TYPE'][0] : '';
                    $item =  $type .':' .$item['value'][0][0] .',';
                    if( ( strlen($item) + strlen($tel) ) > $valueLen )
                    {
                        break;
                    }
                    $tel.= $item;
                }
                $array['TEL'] = rtrim($tel,',');
            }
            if(isset($card['EMAIL'])){
                $email='';
                foreach ($card['EMAIL'] as $item)
                {
                    $item =$item['value'][0][0] .',';
                    if( ( strlen($item) + strlen($email) ) > $valueLen )
                    {
                        break;
                    }
                    $email.= $item;
                }
                $array['EMAIL'] = rtrim($email,',');
            }
            //国家
            //$add = $card['ADR'][0]['value'][6][0];
            //市县
           // $add .= $card['ADR'][0]['value'][3][0];
            //街道
            //if(isset($card['LABEL'])){
                //print_r($card['LABEL']);
                //$add = $card['LABEL'][0]['value'][0][0];
                //$array['ADR'] =  substr($add, 0 , 96);
            //}else{
                if(isset($card['ADR'][0]['value'][2][0])){
                    $array['ADR'] =  $funcService->cutstr_dis($card['ADR'][0]['value'][2][0],96,'');
                }
                if(empty($array['ADR']) && isset($card['ADR'][0]['value'][0][0])) {
                    $array['ADR'] =  $funcService->cutstr_dis($card['ADR'][0]['value'][0][0],96,'');
                }
                if(empty($array['ADR']) && isset($card['LABEL'])){
                    //print_r($card['LABEL']);
                    $add = $card['LABEL'][0]['value'][0][0];
                    $array['ADR'] =  $funcService->cutstr_dis($add,96,'');
                }
            //}
            if(isset($card['X-CLIENTID'])){
                $array['USERID'] = $card['X-CLIENTID'][0]['value'][0][0];
            }else{
                if(isset($card['UID'])){
                    $array['USERID'] = $funcService->cutstr_dis($card['UID'][0]['value'][0][0],11,'');
                }
            }

            if(isset($card['X-INDUSTRY'])){
                $array['INDUSTRY'] = $card['X-INDUSTRY'][0]['value'][0][0];
            }else{
                $array['INDUSTRY']='';
            }
            //print_r($array);print_r($card);exit();
        }catch (\Exception $ex){
            //echo $ex->getMessage();
            return false;
        }
        return $array;

    }
    /**
     * add tag card map
     * @param string $cardid
     * @param string $tagslist
     * @param string $isadd
     * @return boolean
     */
    public function addTagMap($cardid,$tagslist,$isadd = true) {

        if($isadd!==true) {
            $this->deleteTagMap($cardid);
        }
        if(empty($tagslist) || $tagslist===',' || $tagslist===';')
            return true;
        $tagslist = str_replace(';', ',', $tagslist);
        $tags = array_unique(explode(',', $tagslist));

        foreach ($tags as $tag) {
            if(empty($tag))
                continue;
            $tagid = $this->addTag($tag);
            if(empty($tagid))
                continue;
            $cardtagmap = new ContactCardTagmap();
            $cardtagmap->setCardid($cardid);
            $cardtagmap->setTagid($tagid);
            $this->em->persist($cardtagmap);
            $this->em->flush();
        }
    }

    /**
     * delete tag map
     * @param string $cardid
     */
    public function deleteTagMap($cardid) {
        $sql ='DELETE FROM contact_card_tagmap WHERE cardid=:cardid';
        $this->em->getConnection()->executeUpdate($sql,array(':cardid' => $cardid));
    }

    /**
     *
     * @var 保存联系人
     * @param Contact $contact
     * @return Contact
     */
    public function saveContact(Contact $contact) {
        $this->em->persist ( $contact );
        $this->em->flush ();
        return $contact;
    }


    public function updateNindex($userId) {
        $sql = "UPDATE contact_card SET nindex = 0 WHERE user_id=:userid AND nindex=1";
        $param = array(':userid' => $userId);
        $getnindex = "SELECT uuid FROM contact_card WHERE user_id=:userid AND nindex = 1";
        $cardid = $this->em->getConnection()->executeQuery($getnindex, $param)->fetchColumn();
        $updatenindex = "UPDATE contact_card_sync SET operation=:operation,last_modified=:lastmodify WHERE card_uuid=:id";
        $this->em->getConnection()->executeUpdate($updatenindex, array(":operation"=>Codes::SYNC_MODIFY,":lastmodify"=>$this->getTimestamp(),":id"=>$cardid));
        return $this->em->getConnection()->executeUpdate($sql,$param);
    }
    /*
    public function updateNindex($userId, $cardid = "") {
        $sql = "UPDATE contact_card SET nindex = 0 WHERE user_id=:userid AND nindex=1";
        $param = array(':userid' => $userId);
        if(!empty($cardid)){
            $where = " AND uuid!=:cardid";
            $param[':cardid'] = $cardid;
            $sql .= $where;
        }
        $result = $this->em->getConnection()->executeUpdate($sql,$param);
        //修改首页名片信息到account_basic_detail
        if(!empty($cardid)){
            $asql = "UPDATE `account_basic_detail` SET card_id=:cardid WHERE user_id=:userid";
            $param[":cardid"] = $cardid;
            $this->em->getConnection()->executeUpdate($asql,$param);
        }

    } */

    public function addContact($userId,$contactName,$groupId='',$clientId='',$remark='') {
        if(empty($groupId)){
            $groupId = $this->getDefaultContactGroup($userId);
        }
        $namepre = '';
        if(!empty($contactName)) {
            $strpy = new Str2PY();
            $namepre = $strpy->getPre($contactName);
        }
        $contactId = RandomString::make(32);
        $contact = new Contact();
        $contact->setContactName($contactName);
        $contact->setContactId($contactId);
        $contact->setCreatedTime($this->getDateTime());
        if(empty($clientId))
            $clientId = '';
        $contact->setFromUid($clientId);
        $contact->setGroupId($groupId);
        $contact->setIntroducation('false');
        $contact->setRemark($remark);
        $contact->setStatus('active');
        $contact->setUserId($userId);
        $contact->setNamePre($namepre);
        if(!empty($contactName) && $userId==$clientId) {
            $accountService = $this->container->get("account_basic_service");
            $accountService->setRealname($userId,$contactName);
        }

        return $this->saveContact($contact);
    }


    /**
     *
     * @var 查询联系人分组
     * @param unknown $array
     * @return
     *
     */
    public function findContactGroup($array) {
        // 查询多条数据
        $repository = $this->em->getRepository ( 'OradtStoreBundle:ContactGroup' );
        $list = $repository->findBy ( $array );
        return $list;
    }
    public function findContactGroupPassword($groupid) {
        // 查询多条数据
        $repository = $this->em->getRepository ( 'OradtStoreBundle:ContactGroupPassword' );
        $list = $repository->findOneBy ( array (
                'groupId' => $groupid
        ) );
        return $list;
    }

    /**
     * 保存联系人分组信息
     *
     * @param AuthorityRole $role
     * @return AuthorityRole
     */
    public function saveConcatGroup(ContactGroup $concatGroup) {
        $this->em->persist ( $concatGroup );
        $this->em->flush ();
        return $concatGroup;
    }
    /**
     * 保存联系人分组密码
     * @param ContactGroupPassword $passwd
     * @return ContactGroupPassword
     */
    public function saveConcatGroupPassword(ContactGroupPassword $passwd) {
        $this->em->persist ( $passwd );
        $this->em->flush ();
        return $passwd;
    }



    /**
     *
     * @var 查询联系人分组
     * @param unknown $array
     * @return
     *
     */
    public function findContactCardGroup($array) {
        // 查询多条数据
        $repository = $this->em->getRepository ( 'OradtStoreBundle:ContactCardGroup' );
        $list = $repository->findBy ( $array );
        return $list;
    }

    /**
     * 查找名片分组密码
     *
     * @param string $groupid
     * @return ContactCardGroupPassword
     */
    public function findContactCardGroupPassword($groupid) {
        // 查询多条数据
        $repository = $this->em->getRepository ( 'OradtStoreBundle:ContactCardGroupPassword' );
        $list = $repository->findOneBy ( array (
                'groupId' => $groupid
        ) );
        return $list;
    }


    /**
     * 返回最大排序ID
     *
     * @param 用户ID $userId
     * @param string $table
     * @return number
     */
    public function getGroupMaxSorting($userId, $table = 'ContactCardGroup') {
        $findArray = array (
                'userId' => $userId
        );
        $result = $this->em->getRepository ( "OradtStoreBundle:" . $table )->findOneBy ( $findArray ,
                array('sorting' => 'desc') );
        if (empty ( $result )) {
            return 10;
        }
        $sort = $result->getSorting ();
        if ($sort >= 10) {
            $sort ++;
        } else {
            $sort = 10;
        }
        return $sort;
    }

    /**
     * 移动联系人分组
     *
     * @param string $userId
     * @param string $groupid
     * @param string $contactids
     */
    public function moveContactGroup($userId,$groupid,$contactids)
    {
        $contactIdList = array_unique(explode(',', $contactids));
        $query = "UPDATE contact SET group_id=:groupid WHERE user_id=:userId AND contact_id=:contact_id";
        $connection = $this->getConnection();
        $connection->beginTransaction();
        try{
            foreach ($contactIdList as $itemid)
            {
                if(empty($itemid))
                    continue;
                $params = array(':groupid' => $groupid,
                        ':userId' => $userId,
                        ':contact_id' => $itemid
                );
                $connection->executeUpdate($query, $params);
            }
            $connection->commit();
            return true;
        }catch (\Exception $ex){
            $connection->rollBack();
            throw $ex;
            return false;
        }
    }

    /**
     * 更新名片分组排序
     *
     * @param int $id
     * @param string $userId
     * @param int $sorting
     * @param int $oldSorting
     */
    public function updateCardGroupSort($id,$userId,$sorting,$oldSorting)
    {
        $conn = $this->getConnection();
        // 更新当前ID排序
        $update = "UPDATE contact_card_group SET sorting=:sorting WHERE id=:id;";
        $conn->executeUpdate($update , array(':id' => $id , ':sorting' => $sorting));

        //更新其他
        //$update1="UPDATE contact_card_group SET sorting=sorting+1 WHERE user_id='{$userId}' AND id<>$id AND sorting>=" .$sorting ." AND sorting<" .$oldSorting .";";
        $update1="UPDATE contact_card_group SET sorting=sorting+1 WHERE user_id=:user_id AND id<>:id AND sorting>=:sorting AND sorting<:oldsorting;";
        $where="user_id=:user_id AND id<>:id AND sorting>=:sorting AND sorting<:oldsorting";
        if($sorting>$oldSorting)
        {
            $update1="UPDATE contact_card_group SET sorting=sorting-1 WHERE user_id=:user_id AND id<>:id AND sorting<=:sorting AND sorting>:oldsorting;";
            $where="user_id=:user_id AND id<>:id AND sorting<=:sorting AND sorting>:oldsorting";
        }
        $selectSql = "SELECT group_id FROM contact_card_group WHERE ".$where;
        //$sth = $conn->prepare($selectSql);
        //$sth->execute();
        $params = array(':user_id' => $userId,
                ':id' => $id,
                ':sorting' => $sorting,
                ':oldsorting' => $oldSorting
        );
        $sth = $conn->executeQuery($selectSql,$params);
        $result = $sth->fetchAll();
        foreach ($result as $item){
            $this->syncCardGroupAdd($userId, $item['group_id'], Codes::SYNC_MODIFY);
        }
        $conn->executeUpdate($update1 , $params);
    }

    /**
     * 更新联系人分组排序
     *
     * @param int $id
     * @param string $userId
     * @param int $sorting
     * @param int $oldSorting
     */
    public function updateGroupSort($id,$userId,$sorting,$oldSorting)
    {
        // 更新当前ID排序
        $update = "UPDATE contact_group SET sorting=:sorting WHERE id=:id;";

        //更新其他
        //$update1="UPDATE contact_group SET sorting=sorting+1 WHERE user_id=:user_id AND id<>:id AND sorting>=:sorting AND sorting<:oldsorting;";
        /*if($sorting>$oldSorting)
        {
            $update1="UPDATE contact_group SET sorting=sorting-1 WHERE user_id=:user_id AND id<>:id AND sorting<=:sorting AND sorting>:oldsorting;";
        }*/
        $conn = $this->getConnection();
        $conn->executeUpdate($update , array(':id' => $id , ':sorting' => $sorting));
        /*$params = array(':user_id' => $userId,
                ':id' => $id,
                ':sorting' => $sorting,
                ':oldsorting' => $oldSorting
        );*/
        //$conn->executeUpdate($update1 , $params);
    }
    /**
     * 返回名片默认分组ID
     * @param string $userId
     * @param string $groupName
     *
     * @return string groupId
     */
    public function getDefaultContactCardGroup($userId,$sort=Codes::CONTACT_CARD_DEFAULT_ORDER) {
        //读取默认组增加缓存
        $cacheKey = 'contactcard:' . $userId . ':' . $sort;
        $groupId = $this->getCache($cacheKey);
        if(!empty($groupId))
            return $groupId;

        $findArray = array (
                'userId' => $userId,
                'sorting' => $sort
        );
        $result = $this->em->getRepository ( "OradtStoreBundle:ContactCardGroup" )->findOneBy ( $findArray );
        if(empty($result)){
            $findArray = array (
                    'userId' => $userId
            );
            $result = $this->em->getRepository ( "OradtStoreBundle:ContactCardGroup" )->findOneBy ( $findArray ,array('sorting' => 'asc') );

        }
        $this->setCache($cacheKey, $result->getGroupId ());
        return $result->getGroupId ();
    }


    /**
     * 返回联系人默认分组ID
     * @param string $userId
     * @param number $sort
     * @return string groupId
     */
    public function getDefaultContactGroup($userId,$sort=Codes::CONTACT_DEFAULT_ORDER) {
        //读取默认组增加缓存
        $cacheKey = 'contact:' . $userId . ':' . $sort;
        $groupId = $this->getCache($cacheKey);
        if(!empty($groupId))
            return $groupId;
        $findArray = array(
                'userId' => $userId,
                'sorting' => $sort
        );
        $result = $this->em->getRepository ( "OradtStoreBundle:ContactGroup" )->findOneBy ( $findArray );
        if(!empty($result)){
            $result = $this->em->getRepository ( "OradtStoreBundle:ContactGroup" )->findOneBy ( array(
                    'userId' => $userId
            ), array (
                    'sorting' => 'asc'
            ) );
        }
        $this->setCache($cacheKey, $result->getGroupId ());
        return $result->getGroupId ();
        //没有默认组时，自动创建
        //return $this->setDefaultContactGroup($userId);

    }
    /**
     * 查找联系人默认分组，如无默认分组，则创建一个分组
     *
     * @param string $userId
     * @return string 返回默认分组ID
     */
    public function setDefaultContactGroup($userId,$groupName=Codes::CONTACT_CARD_DEFAULT_GROUP,$sorting=0) {
        /*
        $groupName = '默认分组';
        $array = array (
                'userId' => $userId,
                'groupName' => $groupName
        );
        $contactGroup = $this->findContactGroup ( $array );
        if (! empty ( $contactGroup )) {
            $contactGroup = $contactGroup [0];
            return $contactGroup->getGroupId ();
        }
        */
        // 未找到分组则自动创建一个
        $groupId = RandomString::make ( 32 );
        $contactGroup = new ContactGroup ();
        $contactGroup->setGroupId ( $groupId );
        $contactGroup->setGroupName ( $groupName );
        $contactGroup->setUserId ( $userId );
        $contactGroup->setType ( "normal" );
        $contactGroup->setSorting ( $sorting );
        $this->saveConcatGroup ( $contactGroup );

//        $contactGroupPwd = new ContactGroupPassword ();
//        $contactGroupPwd->setGroupId ( $groupId );
//        $contactGroupPwd->setPassword ( '' );
//        $this->saveConcatGroupPassword ( $contactGroupPwd );
        return $groupId;
    }

    /**
     * 查找名片默认分组，如无默认分组，则创建一个分组
     *
     * @param string $userId
     * @return string 返回默认分组ID
     */
    public function setDefaultContactCardGroup($userId,$groupName=Codes::CONTACT_DEFAULT_GROUP,$sorting=0) {
        /*
        $groupName = '默认分组';
        $array = array (
                'userId' => $userId,
                'groupName' => $groupName
        );
        $contactCardGroup = $this->findContactCardGroup ( $array );
        if (! empty ( $contactCardGroup )) {
            $contactCardGroup = $contactCardGroup [0];
            return $contactCardGroup->getGroupId ();
        }
        */
        // 未找到分组则自动创建一个
        $groupId = RandomString::make ( 32 );
        $contactCardGroup = new ContactCardGroup ();
        $contactCardGroup->setGroupId ( $groupId );
        $contactCardGroup->setGroupName ( $groupName );
        $contactCardGroup->setUserId ( $userId );
        $contactCardGroup->setType ( "normal" );
        $contactCardGroup->setSorting ( $sorting );
        $contactCardGroup->setGroupColor ( 0 );
        $contactCardGroup->setLastModified($this->getDateTime());
        $this->saveConcatCardGroup ( $contactCardGroup );

//        $contactCardGroupPwd = new ContactCardGroupPassword ();
//        $contactCardGroupPwd->setGroupId ( $groupId );
//        $contactCardGroupPwd->setPassword ( '' );
//        $this->saveConcatCardGroupPassword ( $contactCardGroupPwd );
        $this->syncCardGroupAdd($userId,$groupId,Codes::SYNC_ADD);
        return $groupId;
    }

    /**
     *
     * @var 保存名片分组信息
     * @param ContactCardGroup $role
     * @return ContactCardGroup
     */
    public function saveConcatCardGroup(ContactCardGroup $concatGroup) {

        //设置默认值
        $createdTime = $this->getTimestamp();
        $var = $concatGroup->getCreatedTime();
        if(empty($var))
        {
            $concatGroup->setCreatedTime($createdTime);
        }
        $var = $concatGroup->getLastModified();
        if(empty($var))
        {
            $concatGroup->setLastModified($createdTime);
        }
        $this->em->persist ( $concatGroup );
        $this->em->flush ();
        return $concatGroup;
    }
    /**
     *
     * @var 保存名片分组密码
     * @param ContactCardGroupPassword $passwd
     * @return ContactCardGroupPassword
     */
    public function saveConcatCardGroupPassword(ContactCardGroupPassword $passwd) {
        $this->em->persist ( $passwd );
        $this->em->flush ();
        return $passwd;
    }


    public function deleteContactGroup(ContactGroup $concatGroup, ContactGroupPassword $passwd) {

        $groupId = $concatGroup->getGroupId();
        $userId = $concatGroup->getUserId();
        if($concatGroup->getSorting()<10)
        {
            return false;
        }
        $defaultGroupId = $this->getDefaultContactGroup($userId);
        $updateTable = "UPDATE contact SET group_id=:defaultGroupId WHERE user_id=:user_id AND group_id=:group_id";
        $params = array(':defaultGroupId' => $defaultGroupId , ':user_id' => $userId , ':group_id' => $groupId);
        //用主键ID删除
        $deleteGroup="DELETE FROM contact_group WHERE id=" . $concatGroup->getId();
        //用主键ID删除
        $deleteGroupPasswd="DELETE FROM contact_group_password WHERE id=" . $passwd->getId();
        $conn = $this->getConnection();
        $conn->executeUpdate($updateTable,$params);
        $conn->prepare ( $deleteGroupPasswd )->execute ();
        $conn->prepare ( $deleteGroup )->execute ();
        return true;
        //$this->em->remove ( $concatGroup );
        //$this->em->remove ( $passwd );
        //$this->em->flush ();

    }

    /**
     * 删除名片分组 删除分组后，名片移动到默认分组下面
     *
     * @param ContactCardGroup $concatGroup
     * @param ContactCardGroupPassword $passwd
     */
    public function deleteContactCardGroup(ContactCardGroup $concatGroup/*, ContactCardGroupPassword $passwd*/) {
        $groupId = $concatGroup->getGroupId();
        $userId = $concatGroup->getUserId();
//        if($concatGroup->getSorting()<10)
//        {
//            return false;
//        }
        $defaultGroupId = $this->getDefaultContactCardGroup($userId);
        //$vipGroupId = $this->getDefaultContactCardGroup ( $userId ,Codes::CONTACT_CARD_DEFAULT_VIP_ORDER);
        //$updateTable = "UPDATE contact_card_group_map SET group_id='{$defaultGroupId}' WHERE user_id='{$userId}' AND group_id='{$groupId}'";


        $mapObject = $this->em->getRepository ( "OradtStoreBundle:ContactCardGroupMap" )->findBy (
                array (
                        'userId' => $userId,
                        'groupId' => $groupId
                ) );
        if(!empty($mapObject)){
            foreach ($mapObject as $map){
                $this->deleteCardGroupMap($userId, $map->getCardId(), $groupId, $defaultGroupId);
            }
        }

        //用主键ID删除
        $deleteGroup="DELETE FROM contact_card_group WHERE id=" . $concatGroup->getId();
        //用主键ID删除
        //$deleteGroupPasswd="DELETE FROM contact_card_group_password WHERE id=" . $passwd->getId();

        $conn = $this->getConnection();
        //$conn->prepare ( $updateTable )->execute ();
        //$conn->prepare ( $deleteGroupPasswd )->execute ();
        $conn->prepare ( $deleteGroup )->execute ();
        return true;
    }

    /**
     * 回收站删除名片
     * @param unknown $userId
     * @param unknown $cardId
     * @return boolean
     */
    public function deleteContactCard($userId,$cardId,&$resurl='')
    {
        $contactCard = $this->findContactCardOneBy(
                array('uuid' => $cardId,
                      'userId' => $userId
        ));

        if(empty($contactCard))
            return false;
        $findArray = array('uuid' => $cardId);
        $extend = $this->findContactCardExtendOneBy($findArray);
        if(!empty($extend))
            $resurl = $extend->getResPath();
        $this->deleteTagMap($cardId);
        //用主键ID删除
        //$deleteGroup="DELETE FROM contact_card_group_map WHERE user_id='" . $userId ."' AND card_id='".$cardId."'";
        //$this->getConnection()->prepare($deleteGroup)->execute();
        $query="DELETE FROM contact_card_group_map WHERE user_id=:user_id AND card_id=:card_id";
        $this->getConnection()->executeUpdate($query,array(':user_id' => $userId , ':card_id' => $cardId));
        $this->em->remove($contactCard);
        $this->em->remove($extend);
        $this->em->flush();
        return true;
    }

    /**
     * 修改联系人状态
     *
     * @param string $userId
     * @param string $contactId
     * @param string $status active | inactive
     */
    public function updateContactStatus($userId,$contactId,$status)
    {
        $findArray = array(
                'userId' => $userId,
                'contactId' => $contactId
        );
        $contact = $this->findContactOneBy($findArray);
        if( empty($contact) )
        {
            return false;
        }
        if($contact->getStatus() == $status)
        {
            return true;
        }
        if($status === $this->statusDelete) {
            $calendarService = $this->container->get("calendar_service");
            $calendarService->deleteContactEventmap($contactId);
        }
        $contact->setStatus($status);
        $this->em->persist($contact);
        $this->em->flush();
        return true;
    }
    /**
     * 按联系人批量修改名片状态
     *
     * @param string $userId
     * @param string $contactId
     * @param string $status active | inactive
     */
    public function updateContactCardStatus($userId,$contactId,$status)
    {
        $findArray = array(
                'userId' => $userId,
                'contactId' => $contactId
        );
        $contactCard = $this->findContactCard($findArray);
        //批量保存
        foreach ($contactCard as $item)
        {
            $contactCard->setStatus($status);
            $this->em->persist($contactCard);
            $this->em->flush();
            //删除缓存
            $this->removeCache( $this->getCacheKey($contactCard->getUuid(),'vcardid') );
        }
        return true;
    }

    /**
     * 修改名片状态
     *
     * @param string $userId
     * @param string $cardId
     * @param string $status $status active | inactive
     */
    public function updateCardStatus($userId,$cardId,$status,$isdelete = 0)
    {
        $findArray = array(
                'uuid' => $cardId,
                'userId' => $userId
        );
        $contactCard = $this->findContactCardOneBy($findArray);
        if( empty($contactCard) )
        {
            return false;
        }
        if($contactCard->getStatus() == $status)
        {
            return true;
        }
        $mapObject = $this->em->getRepository ( "OradtStoreBundle:ContactCardGroupMap" )->findBy (
                array (
                        'cardId' => $cardId
                ) );
        foreach ($mapObject as $item){
            $this->em->remove($item);//删除名片与名片分组关系表数据
            $this->syncCardGroupAdd($userId, $item->getGroupId(), Codes::SYNC_MODIFY);
        }

        $this->ifChangeAdr = false;
        if($contactCard->getStatus() == 'deleted'){
            //echo "aaa2\r\n";
            $this->syncCardAdd($userId,$cardId,Codes::SYNC_ADD);
            $query = "UPDATE contact_card_exchange_log SET isupdate=0 WHERE selfuuid=:vcardid";
            $this->getConnection()->executeUpdate($query , array(':vcardid' => $cardId));
        }
        if($contactCard->getStatus() != 'deleted' && $status=='deleted'){
            $query = "UPDATE contact_card_exchange_log SET isupdate=2 WHERE selfuuid=:vcardid";
            $this->getConnection()->executeUpdate($query , array(':vcardid' => $cardId));
            //echo "aaa1\r\n";
            //这里检查联系人是否还有 名片，无名片还需要再删除联系人
            $trashService = $this->container->get("trashbin_service");
            //写入回收站
            $trashService->insertTrash('card', $userId, $cardId);
            $this->syncCardAdd($userId,$cardId, Codes::SYNC_DELETE, $contactCard->getSelf(), '', 'false' );
            //删除缓存
            $this->removeCache( $this->getCacheKey($cardId,'vcardid') );

            $fromuid = $contactCard->getFromUid();

            //若为首页名片，则设置nindex为0，取消首页名片
            if(1 === $contactCard->getNindex()){
                //return false;
                //$this->updateNindex($userId);
                $contactCard->setNindex(0);
            }
            //解除好友关系 ( 去除 $isdelete === '1' 限制，是好友关系则自动解除好友关系 )
            if( 'false' === $contactCard->getSelf() && 1 == $contactCard->getIsfriend()){
                if(!empty($fromuid)){
                    $accountbasic = $this->container->get("account_basic_service");
                    $accountbasic->delCardId = $cardId;
                    $flag = $accountbasic->deleteFriend($userId,$fromuid);
                    if(!$flag){
                        return false;
                    }
                }
                $contactCard->setIsfriend(0);
            }
        }
        $contactCard->setStatus ( $status );
        $this->em->persist($contactCard);
        $this->em->flush();
        //$this->syncDelRelation($cardId);//关联人当前版本无此功能
        //处理kafka消息
//        $kafkadata = array(
//            'uuid' => $cardId
//        );
        //同步更改扫描名片表的状态为删除状态(自己添加的当前类型为scan的名片)
        if( $cardId === $contactCard->getExchId() && 'scan' ===  $contactCard->getCardType()){
            $this->delCardToScan( $cardId );
        }
        $kafka_data = array("uuid" => $cardId,"operation"=> 'delete');
        $this->pushVcardId[] = $kafka_data;
        return true;
    }
    /**
     * 查询一个联系人
     * @param unknown $findArray
     * @return Contact
     */
    public function findContactOneBy($findArray) {
        $result = $this->em->getRepository ( "OradtStoreBundle:Contact" )->findOneBy ( $findArray );
        return $result;
    }

    public function syncWeCard($userId, $uuid, $vcard = "", $markpoint = "",$picture,$picpatha, $picpathb = ""){
        if( empty($userId) || empty($uuid) ||  empty($picture) || empty($picpatha) ){
            return false;
        }

        $param = array(
            "uuid" => $uuid,
            "vcard" => $this->getMergeCard($vcard),
            "markpoint" => $markpoint,
            "picture" => $picture,
            "picpatha" => $picpatha,
            "picpathb" => empty($picpathb) ? "" : $picpathb,
            "cardfrom" => 'wechatscan',
            "cardtype" => 'scan',
            "handleState" => 'neverhandle',
            "sorting" => 0,
            "sourceType"=>"weixin",
        );

        $this->addContactCard( $userId, $param );
    }
    /**
     * 添加一张名片
     */
    public function addContactCard($userId,$paramArray, $bizId=""){
        $contactName = isset($paramArray['contactName']) ? $paramArray['contactName'] : '';
        $uuid = $paramArray['uuid'];
        $vcard = $paramArray['vcard'];
        $groupId = isset($paramArray['groupId']) ? $paramArray['groupId'] : '';
        $cardgroupid = isset($paramArray['cardgroupid']) ? $paramArray['cardgroupid'] : '';
        $cardres = isset($paramArray['cardres']) ? $paramArray['cardres'] : '';
        $picture = isset($paramArray['picture']) ? $paramArray['picture'] : '';
        $picpatha = isset($paramArray['picpatha']) ? $paramArray['picpatha'] : '';
        $picpathb = isset($paramArray['picpathb']) ? $paramArray['picpathb'] : '';
        $remark = isset($paramArray['remark']) ? $paramArray['remark'] : '';
        $formUid = isset($paramArray['formUid']) ? $paramArray['formUid'] : '';
       // $inContactId = isset($paramArray['inContactId']) ? $paramArray['inContactId'] : '';
        $cardfrom = isset($paramArray['cardfrom']) ? $paramArray['cardfrom'] : 'selfadd';
        $cardType = isset($paramArray['cardtype']) ? $paramArray['cardtype'] : 'custom';
        $markPoint = isset($paramArray['markpoint']) ? $paramArray['markpoint'] : '';
        $layout = isset($paramArray['layout']) ? $paramArray['layout'] : '';
        $xyz = isset($paramArray['xyz']) ? $paramArray['xyz'] : '';
        $localUuid = isset($paramArray['localUuid']) ? $paramArray['localUuid'] : '';
        $language  = isset($paramArray['language']) ? $paramArray['language'] : '';
        $handleState  = isset($paramArray['handleState']) ? $paramArray['handleState'] : '';
        $sourceUuid  = isset($paramArray['sourceUuid']) ? $paramArray['sourceUuid'] : '';
        $sourceType  = isset($paramArray['sourceType']) ? $paramArray['sourceType'] : '';
        //当已存在联系人时，不写联系人表
       // $contact = null;
        $createdTime = $this->getTimestamp();
        $preCard = substr($uuid, 0,1);

        $self = 'false';
        //$cardType = 'other';
        if($userId==$formUid && $preCard===Codes::B){
            //$cardType = 'self-eps';
            $self = 'true';
        }else if($userId==$formUid){
            //$cardType = 'self';
            $self = 'true';
        }else if($preCard===Codes::B){
            //$cardType = 'other-eps';
        }

        //组装名片信息
        $extend = new ContactCardExtend();
        $contactCard = new ContactCard();
        $contactCard->setUserId($userId);
        $contactCard->setLocalUuid($localUuid);
        //$contactCard->setContactId( $contactId );
        $contactCard->setFromUid($formUid);
        //名片ID
        $contactCard->setUuid($uuid);
        //名片信息
        $extend->setVcard($vcard);
        $extend->setResPath($cardres);//资源文件
        $extend->setUuid($uuid);
        $extend->setPicPathA($picpatha);
        $extend->setPicPathB($picpathb);
        $extend->setMarkPoint($markPoint);
        $extend->setLayout($layout);
        $contactCard->setSelf($self);
        $contactCard->setStatus('active');//状态
        $contactCard->setLastModified( $createdTime );
        $contactCard->setCardFrom($cardfrom);
        $contactCard->setUseTemp('none');//使用模版
        $contactCard->setVersion('none');//版本
        $contactCard->setShareReference(0);
        $contactCard->setClientTimestamp(0);
        $contactCard->setCreatedTime( $createdTime );
        $contactCard->setCardType($cardType);//self or other
        $contactCard->setPublic('off');
        $contactCard->setMd5Value(md5($vcard));
        $contactCard->setNindex(0);
        $contactCard->setIsimportant(2);
        $contactCard->setSelfMark('');
        $contactCard->setRemark('');
        $contactCard->setSourceType($sourceType);
        $contactCard->setSorting($paramArray['sorting']);
        $contactCard->setPrivate(0);
        $contactCard->setPicture($picture);
        $contactCard->setLanguage($language);
        $contactCard->setXyz($xyz);
        $contactCard->setHandleState($handleState);
        $contactCard->setSourceUuid($sourceUuid);
        if( 'true' === $contactCard->getSelf() && 'enterprise' === $contactCard->getCardFrom() && 'eps' === $contactCard->getCardType()){
            $contactCard->setCertifcation(2);
        }
        if( !empty($bizId) ){
            $contactCard->setBizId( $bizId );
        }
        //开始保存
       // if( empty($inContactId) ){
      //      $this->saveContact($contact);
       // }
        $this->saveContactCard($contactCard,$extend);
        //添加到名片分组表中
        if(!empty($cardgroupid)){
            $this->addCardGroupMap($userId, $cardgroupid, $uuid);
        }
        $this->syncCardAdd($userId, $uuid, Codes::SYNC_ADD,$self);
//        $param = array(
//            'xyz'=>$xyz,
//            'channel'=>$cardfrom,
//            'savecontact'=>1,
//            'sourcetype'=>$sourceType
//        );
//        $this->systemremindcard($uuid,$userId,$param);
        //结束保存
        $arr = array(
                'contact'      => $contactCard,
                'contact_card' => $contactCard,
                'cardgroupid' => $cardgroupid
        );
        //更新账号首页名片
//        if($contactCard->getNindex()==1) {
//            $accountBasicService = $this->container->get("account_basic_service");
//            $accountBasicService->updateNindexCard($userId, $uuid);//更新首页名片
//        }
        return $arr;
    }



    /**
     * 复制名片
     *
     * @param string $sourceCardId  名片信息来源
     * @param string $targetUserId  目标要生成名片的账号
     */
    public $xyz = array(); //定义接收坐标字段
    public $isexchangefriend = false; //是否为交换好友
    public $card_module = '' ;
    public $sourceId = '';
    public function copyVCard($sourceCardId,$targetUserId,$mapId='',$friendadd = true ,$sourcetype = "app")
    {
        //接收坐标
        $data = $this->xyz;//array('longitude'=>$longitude,'latitude'=>$latitude);
        $xyz = '';//定义交换坐标
        $xyztime = '';//定义交换扫描时间
        if(isset($data['onlinetime'])){
            //$xyztime = new \Datetime(date("Y-m-d H:i:s",$data['onlinetime']));
            unset($data['onlinetime']);
        }
        $xyztime = $this->getTimestamp();
        if(!empty($data)){
           $xyz = json_encode($data);
        }
        $vcard = $this->findContactCardOneBy(array('uuid' => $sourceCardId));
        $findArray = array('uuid' => $sourceCardId);
        $extend = $this->findContactCardExtendOneBy($findArray);
        if(empty($vcard) || empty($extend) || $targetUserId === $vcard->getFromUid())
        {
            //$this->errorLogger(null,"不能保存自已的名片");
            return false;
        }

        //定义$touid
        $userid = $vcard->getUserId();
        $preCard = substr($sourceCardId, 0,1);
        if(empty($preCard) || strtoupper($preCard)==='C')
            $preCard = 'A';
        if(!in_array($preCard,array("A", "B", "C") ) ){
            $preCard = 'A';
        }

        $createdTime = $this->getTimestamp();
        $this->em->beginTransaction();
        try{
            $cardgroupid = "";
            //判断是否存在
            $accountBasicService = $this->container->get("account_basic_service");
            if( empty($this->sourceId) ){
                $this->sourceId = $accountBasicService->getQrCardID($targetUserId);
            }
            $selfSourceUuid = $this->sourceId;
            $contactCard = $this->findContactCardOneBy(array('userId' => $targetUserId,'sourceUuid'=>$selfSourceUuid,'exchId'=> $vcard->getExchId(),'status'=>'active'));
            if( !empty($contactCard) ){
                $uuid = $contactCard->getUuid();
                $newExtend = $this->findContactCardExtendOneBy( array( 'uuid' => $uuid ) );
            }else{
                /**/
                //组装名片信息
                $contactCard = new ContactCard();
                $newExtend = new ContactCardExtend();

                $uuid = RandomString::make(32,$preCard);//名片ID
                $contactCard->setUserId($targetUserId);
                if( 'private' === $vcard->getPublic() ){
                    $contactCard->setPublic('private');
                }else{
                    $contactCard->setPublic('off');
                }
                //名片ID
                $contactCard->setUuid($uuid);
                $contactCard->setIdentityName($vcard->getIdentityName());
                $contactCard->setSourceType($vcard->getSourceType());
                $contactCard->setAvatar($vcard->getAvatar());
                //$contactCard->setVcard($vcf);
                if($this->isexchangefriend === true){
                    $contactCard->setIsfriend(1);
                }
                $contactCard->setMd5Value($vcard->getMd5Value());
                $resUrl = $extend->getResPath();
                $pictureUrl = $vcard->getPicture();

                //扫描名片A面
                $picpathaUrl = $extend->getPicPathA();
                //扫描名片B面
                $picpathbUrl = $extend->getPicPathB();
                //名片信息
                $vcf = $extend->getVcard();
                $markpoint = $extend->getMarkPoint();
                $resmd5 = $extend->getResMd5();
                $layout = $extend->getLayout();
                $newExtend->setUuid($uuid);
                $newExtend->setResPath($resUrl);
                $newExtend->setVcard($vcf);
                $newExtend->setMarkPoint($markpoint);
                $newExtend->setResMd5($resmd5);
                $newExtend->setLayout($layout);
                $newExtend->setPicPathA($picpathaUrl);
                $newExtend->setPicPathB($picpathbUrl);
                $newExtend->setReOrder($extend->getReOrder());
                $selfmark = $vcard->getSelfMark();
                //$contactCard->setResPath($resUrl);//资源文件
                $contactCard->setStatus($vcard->getStatus());//状态
                $contactCard->setLastModified($createdTime);
                if(!empty($this->card_module)){
                    $contactCard->setCardFrom($this->card_module);
                }else{
                    $contactCard->setCardFrom('introduce');
                }
                $contactCard->setSelfMark($selfmark);
                $contactCard->setUseTemp($vcard->getUseTemp());//使用模版
                $contactCard->setVersion($vcard->getVersion());//版本
                $contactCard->setShareReference(0);
                $contactCard->setClientTimestamp(0);
                $contactCard->setCreatedTime($createdTime);
                $contactCard->setFromUid($vcard->getFromUid());
                $contactCard->setPicture($pictureUrl);
                $contactCard->setBackground($vcard->getBackground());
                $contactCard->setSignature($vcard->getSignature());
                $contactCard->setIsimportant(2);
                $contactCard->setCertifcation($vcard->getCertifcation());
                $contactCard->setExchId($vcard->getExchId());//获取 交换名片ID
                $contactCard->setSourceType($sourcetype);
                //自己 交换 源名片ID
                if( !empty($this->sourceId) ){
                    $contactCard->setSourceUuid( $this->sourceId);
                }
                //复制模版ID
                $contactCard->setTempId($vcard->getTempId());
                //复制对方坐标
                $contactCard->setLatitude($vcard->getLatitude());
                $contactCard->setLongitude($vcard->getLongitude());
                $self = 'false';
                if($targetUserId === $vcard->getFromUid()){
                    $self = 'true';
                }
                $contactCard->setSelf($self);
                $contactCard->setNindex(0);
                $contactCard->setSorting(0);
                $contactCard->setPrivate(0);
                if(!empty($data)){
                    $contactCard->setXLatitude($data["latitude"]);
                    $contactCard->setXLongitude($data["longitude"]);
                }
                $contactCard->setXyz($xyz);
                $contactCard->setXyztime($xyztime);
                //$cardType='other';
                $cardType=$vcard->getCardType();
                if($preCard===Codes::B){
                    //$cardType = 'other-eps';
                    $cardType = 'eps';
                }

                $contactCard->setCardType($cardType);//other or other-eps
                $contactCard->setHandleState("neverhandle");
                //开始保存

                $this->saveContactCard($contactCard,$newExtend);
                //名片组ID
                //取用户名片默认分组ID
                //$cardgroupid = "";
                //$cardgroupid = $this->getDefaultContactCardGroup($targetUserId);
                //添加到名片分组表中
                //$this->addCardGroupMap($targetUserId, $cardgroupid, $uuid);
                //传递参数：是否是交换名片
                $this->isexchange = true;
                $this->ifChangeAdr = false;
                if( true === $friendadd ){
                    $this->syncCardAdd($targetUserId, $uuid, Codes::SYNC_ADD,$self, '','true');
                }else{
                    $this->syncCardAdd($targetUserId, $uuid, Codes::SYNC_ADD,$self, '','false');
                }
                if(!empty($mapId)) {
                    //关系
                    $contactFromMap = new ContactFromIntroducation();
                    $contactFromMap->setCardId($uuid);
                    $contactFromMap->setContactId($uuid);
                    $contactFromMap->setMapId($mapId);
                    //写关系表
                    $this->em->persist($contactFromMap);
                    $this->em->flush();
                }
                if(!empty($selfmark)) {
                    $this->addTagMap($uuid,$selfmark);
                }
                //验证是否已经保存过该张名片
                //SELECT COUNT(*) FROM contact_card_exchange_log WHERE vcardid='Asresq9ERqmIpF6dWeT4DTJ8QtlmMTyf' AND user_id='AanAftgfIPsqOWjwDs2nxWLEa00ae00000001065' AND isupdate<2
                //日志
                $sql = "INSERT INTO contact_card_exchange_log (user_id,vcardid,created_time,selfuuid)
                        VALUES (:userid,:vcardid,:createdtime,:selfuuid)";
                /*$params = array(':userid' => $targetUserId , ':vcardid' => $sourceCardId ,
                        ':createdtime' => $this->getTimestamp() , ':selfuuid' => $uuid);*/
                //改为最原始名片ID
                $params = array(':userid' => $targetUserId , ':vcardid' => $vcard->getExchId() ,
                        ':createdtime' => $this->getTimestamp() , ':selfuuid' => $uuid);
                $this->em->getConnection()->executeUpdate($sql , $params);

                //$accountBasicService = $this->container->get("account_basic_service");

                /*if($this->isexchangefriend === true){//为雷达扫描交换好友，更新联系时间
                    $relationService = $this->container->get("account_relation_service");
                    $relationService->addContactTime($targetUserId, $uuid , $this->getDateTime()->format('Y-m-d H:i:s'));
                }*/

                //发送好友请求 加好友 5.13后改成发送消息
                /*if($friendadd===true) {
                    //$accountBasicService = $this->container->get("account_basic_service");
                    //$accountBasicService->createFriend($targetUserId,$userid,'');
                    $self = $vcard->getSelf();
                    if($self === 'true'){
                        $fuserid = $userid;
                    }else{
                        $fuserid = $vcard->getFromUid();
                    }
                    //验证是否已是好友
                    $flag = $accountBasicService->getFriend($targetUserId, $fuserid);
                    if(empty($flag) && !empty($fuserid) && $fuserid != $targetUserId){
                        $accountBasicService->doclientId($targetUserId,$fuserid,'');
                    }
                    //if(!$rs){//发送好友请求失败
                    //    return false;
                    //}
                }*/

            }
            $this->em->commit();
            //交换名片成功后，返回保存的uuid
            if(!empty($uuid)){
                $accountBasicService->exchangeuuid = $uuid;
            }
            $arr = array(
                        'contact'      => $newExtend,
                        'contact_card' => $contactCard,
                        'cardgroupid' => $cardgroupid
                );
            return $arr;
        }
        catch (\Exception $ex){
           //echo $ex->getMessage();
            $this->em->rollback();
            //$this->errorLogger($ex,__FILE__ . __FUNCTION__);
            //return false;
            throw $ex;
        }
    }

    /**
     * @version 1.0
     * 重要关系人 最后联系时间
     * @param string $userId 用户ID
     * @param string $clientid 关系人ID
     * @param array $paramArr = array(
     *      'status'=> $status,//开关状态 默认0,仅用于设置开关状态
     *      'lastmodify'=> $this->getTimestamp()
     * )
     */
    public function changeRelationPermission($userId, $clientid, $paramArr = array())
   {
        $lastModify = $this->getTimestamp();
        $param = array(
            'fromUid' => $userId,
            'toUid' => $clientid
        );
        $relationPermission = $this->em->getRepository ( 'OradtStoreBundle:ContactRelationPermission' )->findOneBy ($param);
        if(empty($relationPermission)){
            $relationPermission = new ContactRelationPermission();
            $relationPermission->setFromUid($userId);
            $relationPermission->setToUid($clientid);
            $relationPermission->setLastPush(0);
            $relationPermission->setStatus(2);//默认值
            $relationPermission->setLastModified($lastModify);
        }
        //开启或关闭时调用,需传入status值
        if( isset($paramArr['status']) ){
            $relationPermission->setStatus($paramArr['status']);
        }
        //修改最后联系时间
        if( isset($paramArr['lastmodify']) ){
            $relationPermission->setLastModified($paramArr['lastmodify']);
        }
        try{
            $this->em->persist($relationPermission);
            $this->em->flush();

            return true;
        }catch(\Exception $e){
            throw $e;
            return false;
        }
    }
    /**
     * @version 2.0
     * 重要关系人 最后联系时间
     * @param string $userId 用户ID
     * @param string $selfuuid 名片ID
     * @param array $paramArr = array(
     *      'status'=> $status,//开关状态 默认0,仅用于设置开关状态
     *      'lastmodify'=> $this->getTimestamp()
     * )
     */
    public function changeRelationPermissionV2($userId, $selfuuid, $paramArr = array())
   {
        $lastModify = $this->getTimestamp();
        $param = array(
            ':userId' => $userId,
            ':selfuuid' => $selfuuid
        );
        //开启或关闭时调用,需传入status值
        if( isset($paramArr['status']) ){
            $param[':status'] = $paramArr['status'];
        }
        //修改最后联系时间
        if( isset($paramArr['lastmodify']) ){
            $param[':lastmodified'] = $paramArr['lastmodify'];
        }
        $querySql = "SELECT id,`status`,last_modified FROM `contact_relation_permission_v2` WHERE user_id=:userId AND card_id=:selfuuid LIMIT 1";
        $result = $this->getConnection()->executeQuery($querySql, $param)->fetch();
        if( empty($result) ){
            $sql = "INSERT INTO `contact_relation_permission_v2` SET user_id=:userId,card_id=:selfuuid,`status`=:status,last_modified=:lastmodified";
            if( empty($param[':status']) ){
                $param[':status'] = 2;
            }
            if( empty($param[':lastmodified']) ){
                $param[':lastmodified'] = $lastModify;
            }
        }else{
            $sql = "UPDATE `contact_relation_permission_v2` SET `status`=:status,last_modified=:lastmodified WHERE user_id=:userId AND card_id=:selfuuid";
            if( empty($param[':status']) ){
                $param[':status'] = $result['status'];
            }
            if( empty($param[':lastmodified']) ){
                $param[':lastmodified'] = $result['last_modified'];
            }
        }
       if(isset($paramArr['lastmodify'])){
           $lastdate = date("Y-m-d H:i:s",$paramArr['lastmodify']);
           $lastModify = $paramArr['lastmodify'];
       }else{
           $lastdate = date("Y-m-d H:i:s",$lastModify);
       }
       $content='';
        if($paramArr['type'] == 1){
            $content = "您给".$paramArr['name']."拨打了电话";
        }elseif($paramArr['type'] == 2){
            $content = "您给".$paramArr['name']."发送了短信";
        }elseif($paramArr['type'] == 3){
            $content = "您给".$paramArr['name']."发送了邮件";
        }elseif($paramArr['type'] == 4){
            $content = '';
        }
        try{
            if($paramArr['type'] != 0){
                $contentarr = array(array('type'=>'text'));
                $contentarr[0]['content']=$content;
                if($paramArr['type'] != 4){
                    $contentarr[0]['systype'] = 1;
                }
                $json = json_encode($contentarr,JSON_UNESCAPED_UNICODE);
                /*$reminparam = array(
                    ":selfuuid"=>$selfuuid,
                    ":userid"=>$userId,
                    ":content"=>$json,
                    ":createtime"=>$lastModify,
                );*/
                if($paramArr['type'] == 4){
                    $cardtypearr=array(0=>"消息中好友交换请求",1=>"雷达扫描",2=>"二维码扫描",8=>"微信邀请",7=>"购买",9=>"微博",10=>"支付宝",11=>"TransferJet",
                                        12=>"蓝牙",13=>"短信邀请",14=>"微信摇一摇",15=>"微信扫一扫");
                    if(!in_array($paramArr['channel'],array_keys($cardtypearr))){
                        $this->getConnection()->executeUpdate($sql, $param);
                        return true;
                    }
                    $status=2;
                    $json=json_encode(array($paramArr));
                }else{
                    $status=1;
                }
                $cardRemark = new ContactCardRemind();
                $cardRemark->setVcardId($selfuuid);
                $cardRemark->setUserId($userId);
                $cardRemark->setRemark($json);
                $cardRemark->setRemarkDate($lastModify);
                $cardRemark->setRemindTime(-1);
                $cardRemark->setModifyTime($lastModify);
                $cardRemark->setStartTime(0);
                $cardRemark->setEndTime(0);
                $cardRemark->setFlagTime(0);
                $cardRemark->setScheduleId(0);
                $cardRemark->setCycle(0);
                $cardRemark->setStatus($status);
                $cardRemark->setFromId($userId);
                $cardRemark->setSortid(0);
                $cardRemark->setType(1);
                $cardRemark->setClasses(0);
                $cardRemark->setTimeset(1);
                //保存名片项目信息
                $this->em->persist($cardRemark);
                $this->em->flush();
                $id = $cardRemark->getId();
                /*if($paramArr['type'] == 4){
                    $gearmanService = $this->container->get ('gearman_service');
                    $gearOp = array("id"=>$id,"type"=>"sysremind");
                    $gearmanService->push_job("ContactCard", $gearOp);
                }*/
                $reminparam = array(
                    ":selfuuid"=>$selfuuid,
                    ":userid"=>$userId,
                    ":id"=>$id,
                    ":createtime"=>$lastModify,
                );
                /*$setremind="INSERT INTO contact_card_remind SET vcard_id=:selfuuid,user_id=:userid,remark=:content,remark_date=:createtime,remind_time=-1,modify_time=:createtime,flag_time=0,cycle=0,from_id=:userid,sortid=0,type=1,status=:status";
                $this->getConnection()->executeUpdate($setremind, $reminparam);*/
                if($paramArr['type'] != 4){
                    $setremind="INSERT INTO card_remark_schedule_sync SET card_id=:selfuuid,user_id=:userid,remark_schedule=:id,status='add',type=1,last_modify=:createtime";
                    $this->getConnection()->executeUpdate($setremind, $reminparam);
                }
            }
            $this->getConnection()->executeUpdate($sql, $param);
            return true;
        }catch(\Exception $e){
            throw $e;
            return false;
        }
    }
    /**
     * 复制名片项目以及富媒体扩展信息
     * @param string $userId 用户ID
     * @param string $clientId 用户ID
     * @return boolean true or false
     */
    public function copyExtendInfo($userId, $clientId){
        if(empty($userId) || empty($clientId)){
            return false;
        }
        //获取名片ID
        $cardlist = $this->getExchangeList($userId, $clientId);
        //复制项目列表以及扩展富媒体信息
        if(!empty($cardlist)){
            $this->em->getConnection()->beginTransaction();
            try{
                foreach($cardlist AS $itemid){
                    $this->copyExtendInfoByExchId($userId, $itemid);
                }
                $this->em->getConnection()->commit();
            }catch(\Exception $e){
                $this->em->getConnection()->rollback();
                //throw $e;
                return false;
            }
        }
        return true;
    }
    /**
     * 复制单张名片项目以及富媒体扩展信息
     * @param string $userId 用户ID
     * @param string $exchId 名片唯一ID
     * @return boolean true or false
     */
    public function copyExtendInfoByExchId($userId, $exchId){
        if(empty($userId) || empty($exchId)){
            return false;
        }
        try{
            //扩展富媒体
            $dsql = "INSERT INTO `contact_card_extend_detail_released`(map_id, user_id, uuid, title, small_path, res_path, content, type,
                        create_time) SELECT id AS map_id, :userId AS user_id, uuid, title, small_path, res_path, content, type, create_time FROM
                        `contact_card_extend_detail` WHERE uuid=:uuid";
            //名片项目
            $psql = "INSERT INTO `contact_card_project_experience_released`(map_id, user_id, vcard_id, project_name, project_content, start_time,
                end_time, created_time) SELECT id AS map_id, :userId AS user_id, vcard_id, project_name, project_content, start_time, end_time,
                created_time FROM `contact_card_project_experience` WHERE vcard_id=:uuid";
            $params = array(
                ':userId' => $userId,
                ':uuid' => $exchId
            );
            $this->getConnection()->executeUpdate($dsql, $params);
            $this->getConnection()->executeUpdate($psql, $params);
        }catch(\Exception $e){
            throw $e;
            return false;
        }
        return true;
    }
    /**
     * 删除已复制名片项目以及富媒体扩展信息
     * @param string $userId 用户ID
     * @param string $clientId 用户ID
     * @return boolean true or false
     */
    public function delExtendInfo($userId, $clientId){
        if(empty($userId) || empty($clientId)){
            return false;
        }
        //获取名片ID
        $cardlist = $this->getExchangeList($userId, $clientId);
        //复制项目列表以及扩展富媒体信息
        if(!empty($cardlist)){
            $this->em->getConnection()->beginTransaction();
            try{
                foreach($cardlist AS $itemid){
                    $this->delExtendInfoByExchId($userId, $itemid);
                }
                $this->em->getConnection()->commit();
            }catch(\Exception $e){
                $this->em->getConnection()->rollback();
                return false;
            }
        }
        return true;
    }
    /**
     * 删除单张名片项目以及富媒体扩展信息
     * @param string $userId 用户ID
     * @param string $exchId 名片唯一ID
     * @return boolean true or false
     */
    public function delExtendInfoByExchId($userId, $exchId){
        if(empty($userId) || empty($exchId)){
            return false;
        }
        try{
            //扩展富媒体
            $dsql = "DELETE FROM `contact_card_extend_detail_released` WHERE user_id=:userId AND uuid=:uuid";
            //名片项目
            $psql = "DELETE FROM `contact_card_project_experience_released` WHERE user_id=:userId AND vcard_id=:uuid";
            $params = array(
                ':userId' => $userId,
                ':uuid' => $exchId
            );
            $this->getConnection()->executeQuery($dsql, $params);
            $this->getConnection()->executeQuery($psql, $params);
        }catch(\Exception $e){
            throw $e;
            return false;
        }
        return true;
    }
    /**
     * 获取两个人交换的名片ID列表
     * @param string $userId 用户ID
     * @param string $clientId 用户ID
     * @return array 结果列表
     */
    public function getExchangeList($userId, $clientId){
        $list = array();
        if(!empty($userId) && !empty($clientId)){
            $params = array(
                ':userId' => $userId,
                ':clientId' => $clientId
            );
            $sql = "SELECT exch_id AS exchid FROM `contact_card` WHERE user_id=:userId and from_uid=:clientId and self='false' and status='active'";
            $result = $this->getConnection()->executeQuery($sql, $params)->fetchAll();
            if(!empty($result)){
                foreach($result as $item){
                    $list[] = $item['exchid'];
                }
            }
        }
        return $list;
    }
    /**
     * 添加卡片修改日志
     */
    public function addeditlog($user_id,$editarr,$uuid,$ismove = 0){
        if(empty($editarr)){
            return false;
        }
        if(!empty($editarr['newvcard']) && !empty($editarr['oldvcard'])){
            if(md5(json_encode($editarr['newvcard'])) == md5(json_encode($editarr['oldvcard']))){
                return true;
            }
        }
        if(empty($editarr['newvcard'])){
            $editarr['newvcard'] = $editarr['oldvcard'];
        }
        $jsonarr = json_encode($editarr,JSON_UNESCAPED_UNICODE);
        $create_time = $this->getTimestamp();
        $params = array(
            'userid' => $user_id,
            'uuid'  =>$uuid,
            'jsonarr' => $jsonarr,
            'ismove' => $ismove,
            'createtime' =>$create_time
        );
        try{
            $sql="INSERT INTO  contact_card_edit_log (user_id,uuid,logs,ismove,create_time) VALUES(:userid,:uuid,:jsonarr,:ismove,:createtime)";
            $this->em->getConnection()->executeQuery($sql, $params);
        }catch(\Exception $e){
            throw $e;
        }
       return true;
    }

    /**
     * 获取隐私vcard
     * @param string $userId 用户ID
     * @param string $uuid 名片ID
     * @return string vcard
     */
    public function getContentPrivacyCard($userid,$uuid){
        if(empty($userid) || empty($uuid)){
            return false;
        }
        $sql="SELECT content FROM contact_card_privacy_settings WHERE user_id=:userid AND uuid=:uuid AND status=1";
        $res = $this->getConnection()->executeQuery($sql, array(':userid'=>$userid,':uuid' =>$uuid))->fetch();
        if($res['content'] == ''){
            $sqldef="SELECT content FROM contact_card_privacy_settings  WHERE user_id=:userid AND status=0";
            $resdef = $this->getConnection()->executeQuery($sqldef, array(':userid'=>$userid))->fetch();
            $privacy =  $resdef['content'];
        }else{
            $privacy = $res['content'];
        }
        $vcardsql = "SELECT vcard FROM contact_card_extend WHERE uuid = :uuid limit 1";
        $vcard = $this->getConnection()->executeQuery($vcardsql, array(':uuid'=>$uuid))->fetchColumn();
        if(empty($vcard)){
            return false;
        }
        $cardinfo=array();
        $vcardservice =  $this->container->get('vcard_data_service');
        if(!empty($vcard)){
            $vcardarr = json_decode($vcard,true);
            if(!is_array($vcardarr)){
                if($privacy != ""){
                    $oldcard = $vcardservice->parseVcardText($vcard);
                    $content = explode(',',$privacy);
                    foreach($oldcard[0] as $key => $val){
                        if(in_array($key,$content)){
                            foreach($val as $k=>$v){
                                if($k=='value'){
                                    $val[$k] = "xxxxxx";
                                }
                            }
                        }
                        $cardinfo[$key] = $val;
                    }
                    $card['textItem']=$cardinfo;
                    $newCard = $vcardservice->buildCard($card);
                    return $newCard['vcard'];
                }else {
                    return $vcard;
                }
            }else{
                foreach($vcardarr['front'] as $key=>$val){
                    if($privacy == ""){
                        return $vcard;
                    }
                    $content = explode(',',$privacy);
                    if(in_array($key,$content)){
                        foreach($val as $keys => $setval){
                            //$setval['value'] = "xxxxxx";
                            $vcardarr['front'][$key][$keys]['value'] = "xxxxxx";
                        }
                    }
                }
            return json_encode($vcardarr,JSON_UNESCAPED_UNICODE);
            }

        }else{
            return false;
        }
    }
    /**
     * 获取隐私设置
     * @param string $userId 用户ID
     * @param string $uuid 名片ID
     * @return string 隐私
     */
    public function getcontent($userid,$uuid){
        if(empty($userid) || $uuid){
            return false;
        }
        $sql="SELECT content FROM contact_card_privacy_settings WHERE user_id=:userid AND uuid=:uuid AND status=1";
        $res = $this->getConnection()->executeQuery($sql, array(':userid'=>$userid,':uuid' =>$uuid))->fetch();
        if($res['content'] == ''){
            $sqldef="SELECT content FROM contact_card_privacy_settings  WHERE user_id=:userid AND status=0";
            $resdef = $this->getConnection()->executeQuery($sqldef, array(':userid'=>$userid))->fetch();
            return $resdef['content'];
        }
        return $res['content'];
    }
    /**
     * 获取隐私vcard
     * @param string $vcard 名片
     * @param string $content 隐私设置
     * @return string vcard
     */
    public function getprivacycard($vcard,$content){
        if(empty($vcard)){
            return false;
        }
        $cardinfo=array();
        //$sql = "select e.vcard,p.content from contact_card as c left JOIN contact_card_extend as e on c.uuid=e.uuid left join contact_card_privacy_settings as p on c.uuid=p.uuid  where  c.uuid=:uuid and c.user_id=:userid";
        //$sql="select e.vcard,p.content from contact_card as c left JOIN contact_card_extend as e on c.uuid=e.uuid left join contact_card_privacy_settings as p on c.user_id=p.user_id  where  c.status='active' and c.nindex=1 and c.self='true' and c.user_id=:userid";
        //$data = $this->getConnection()->executeQuery($sql, array(':userid'=>$userid,':uuid' =>$uuid))->fetch();
        $vcardservice =  $this->container->get('vcard_data_service');
        if(!empty($vcard)){
            if($content != ""){
                $oldcard = $vcardservice->parseVcardText($vcard);
                $content = explode(',',$content);
                foreach($oldcard[0] as $key => $val){
                    if(in_array($key,$content)){
                        foreach($val as $k=>$v){
                            if($k=='value'){
                                $val[$k] = "xxxxxx";
                            }
                        }
                    }
                    $cardinfo[$key] = $val;
                }
                $card['textItem']=$cardinfo;
                $newCard = $vcardservice->buildCard($card);
                return $newCard['vcard'];
            }else {
                //$newCard['vcard'] = $vcard;
                //print_r($vcard);die;
                return $vcard;
            }
        }else{
            return false;
        }
    }

    /**
     * 获得名片隐藏策略
     */
    public function getPrivacy($userid='')
    {
        $sql="SELECT * FROM contact_card_privacy_settings WHERE user_id !='' AND content != '' ";
        $res = $this->getConnection()->executeQuery($sql)->fetchAll();
        return $res;
    }
    /**
     * 文件缓存存储
     */
    public function getCache($key='')
    {
        $dir    = $this->container->getParameter('kernel.cache_dir');
        $key    = 'elasticcardprivate';
        $cache  = new FilesystemCache($dir);
        // $cache->delete($key);
        $result = $cache->fetch($key);
        if (empty($result['alltheservice'])) {
            $res = $this->getPrivacy();
            $cache->save($key, array('alltheservice'=>$res), 3600);
            $result = $cache->fetch($key);
        }
        return $result;
    }

    public function adddynamc($cardid,$dynamic){
        if(empty($cardid) || empty($dynamic)) {
            return false;
        }
        $sql="SELECT * FROM contact_card WHERE uuid=:uuid AND status='active'";
        $res = $this->getConnection()->executeQuery($sql,array('uuid'=>$cardid))->fetch();
        if(empty($res)){
            return false;
        }
        $param = array(
            'cardid' =>$cardid,
            'createtime' =>$this->getTimestamp(),
            'modifytime'=> $this->getTimestamp(),
            'dynamic' =>json_encode($dynamic),
        );
        $addsql="INSERT INTO contact_card_dynamic (card_id,create_time,modify_time,dynamic_card) VALUES (:cardid,:createtime,:modifytime,:dynamic)";
        $this->getConnection()->executeQuery($addsql,$param);
    }

    /*
* 备注同步日程
* */
    public function syncschedule($vcardId,$remindtime,$createtime,$content,$cycle=0,$userId,$address='',$title=''){
        //$this->em->getManager(); //添加事物
        $contentarr = json_decode($content,true);
        $this->em->beginTransaction();
        try {
            $cardSchedule = new ContactCardSchedule();
            $cardSchedule->setVcardId($vcardId);
            $cardSchedule->setUserId($userId);
            if(is_array($contentarr) && $contentarr[0]['type'] == "text"){
                $content = $contentarr[0]['content'];
                if(!empty($content)){
                    if(strlen($content) <= 60){
                        $title = $content;
                        $content="";
                    }
                }
            }else{
                $content='';
                $title="备注日程";
            }
            $cardSchedule->setContent($content);
            $cardSchedule->setAddress($address);
            $cardSchedule->setTitle($title);
            $cardSchedule->setStartTime($remindtime);
            $cardSchedule->setEndTime($remindtime);
            $cardSchedule->setIsallday(0);
            $cardSchedule->setremindTime(0);
            $cardSchedule->setFlagTime($remindtime);
            $cardSchedule->setIsRemind(0);
            $cardSchedule->setLatitude(0);
            $cardSchedule->setLongitude(0);
            $cardSchedule->setCreateTime($createtime);
            $cardSchedule->setLastModify($createtime);
            $cardSchedule->setCycle($cycle);
            $cardSchedule->setStatus(1);
            $cardSchedule->setScheduleFrom(1);
            $cardSchedule->setRemindType(0);
            //保存名片项目信息
            $this->em->persist($cardSchedule);
            $this->em->flush();
            $scheduleid = $cardSchedule->getId();
            $addmap="INSERT INTO contact_card_schedule_map (uuid,schedule_id,status,last_modify,operation) VALUES (:uuid,:scheduleid,:status,:last_modify,:operation)";
            $this->getConnection()->executeQuery($addmap, array('uuid'=>$vcardId,'scheduleid'=>$scheduleid,'status'=>2,'last_modify'=>$createtime,'operation'=>'add'));
            $relations_service = $this->container->get('account_relation_service');
            $relations_service->syncRemarkSchedule($scheduleid,$vcardId,$userId,2,'add',$createtime);
            $this->em->commit();
        }catch (\Exception $ex){
            $this->em->rollback();
            throw $ex;
        }
        //$addschedule="INSERT INTO contact_card_schedule (vcard_id,user_id,content,create_time,modify_time,cycle,remind_time) VALUES (:cardid,:createtime,:modifytime,:dynamic)";

    }
    /**
     * 合并日程、备注
     * 相关表 contact_card_schedule\contact_card_schedule_map\contact_card_remind\card_remark_schedule_sync
     */
    public function mergeInfo ( $fromuuid = '', $touuid = '', $operation = 'modify'){
        if( empty( $fromuuid ) || empty( $touuid )){
            return false;
        }
        $currentTime = $this->getTimestamp();
        $params = array(
            ":fromuuid" => $fromuuid,
            ":touuid" => $touuid,
            ':currentTime' => $currentTime
        );

        //增加同步日程、备注信息
//            $syncSql = "INSERT INTO `card_remark_schedule_sync` (card_id,user_id,remark_schedule,`status`,last_modify,type)
//                        SELECT :touuid AS card_id,user_id,remark_schedule,'modify' AS `status`,:currentTime AS last_modify,type FROM `card_remark_schedule_sync` s
//                        WHERE s.card_id=:fromuuid AND s.`status` IN ('add', 'modify') AND s.type IN ( '1', '2')";
//            $this->getConnection()->executeQuery($syncSql, $params);
        //更改之前日程、备注同步信息为删除状态
        //$updateSyncSql = "UPDATE `card_remark_schedule_sync` s SET s.`status`='delete',s.last_modify=:currentTime WHERE s.card_id=:fromuuid"
                //. " AND s.`status` IN ('add', 'modify') AND s.type IN ( '1', '2')";
        //更改之前日程、备注同步信息为modify状态,card_id为新名片ID
        $updateSyncSql = "UPDATE `card_remark_schedule_sync` s SET card_id=:touuid,s.`status`='modify',s.last_modify=:currentTime WHERE s.card_id=:fromuuid"
                . " AND s.`status` IN ('add', 'modify') AND s.type IN ( '1', '2', '3')";
        $this->getConnection()->executeQuery($updateSyncSql, $params);
        //保存现有信息
        //日程
        $scheduleSql = "UPDATE contact_card_schedule s,contact_card_schedule_map m SET s.vcard_id=:touuid,m.uuid=:touuid "
                . " WHERE s.vcard_id=:fromuuid AND s.`status`='1' AND m.uuid=:fromuuid";
        $this->getConnection()->executeQuery($scheduleSql, $params);
        //备注
        $remarkSql = "UPDATE contact_card_remind r SET r.vcard_id=:touuid WHERE r.vcard_id=:fromuuid AND r.`status`='1' ";
        $this->getConnection()->executeQuery($remarkSql, $params);

    }
    /**
     * （人脉）同账户下名片合并产生名片历史记录
     * @param string $userId 账户ID
     * @param string $fromuuid 从哪张名片合并
     * @param string $touuid  合并到哪张名片
     */
    public function addHistoryRecord( $userId = '', $fromuuid = '', $touuid='' ){
        if( empty($userId) || empty($fromuuid) || empty($touuid)){
            return false;
        }
        $querySql = "SELECT e.vcard,c.picture,e.pic_path_a,e.pic_path_b,e.res_path,e.mark_point FROM `contact_card` c"
                    . " INNER JOIN `contact_card_extend` e ON e.uuid=c.uuid WHERE c.uuid=:uuid AND c.user_id=:userid LIMIT 1";
        $result = $this->getConnection()->executeQuery($querySql, array(':uuid'=>$fromuuid, ':userid'=>$userId))->fetch();
        if( !empty($result) ){
           /* $sql = "SELECT e.vcard,c.picture,e.pic_path_a,e.pic_path_b,e.res_path,e.mark_point FROM `contact_card` c"
                    . " INNER JOIN `contact_card_extend` e ON e.uuid=c.uuid WHERE c.uuid=:uuid AND c.user_id=:userid AND c.`status`='active' LIMIT 1";
            $newresult = $this->getConnection()->executeQuery($sql, array(':uuid'=>$touuid, ':userid'=>$userId))->fetch();*/
            $editarr=array(
               "from_uid" => $userId,
               "card_id" => $fromuuid,
               'newvcard'=>array(),
                  /* "vcard" => $newresult['vcard'],
                   "picture" => $newresult['picture'],
                   "picpatha"=> $newresult['pic_path_a'],
                   "picpathb"=> $newresult['pic_path_b'],
                   "respath"=> $newresult['res_path'],
                   "markpoint"=> $newresult['mark_point']
               ),*/
               'oldvcard'=>array(
                   "vcard" => $result['vcard'],
                   "picture" => $result['picture'],
                   "picpatha"=> $result['pic_path_a'],
                   "picpathb"=> $result['pic_path_b'],
                   "respath"=> $result['res_path'],
                   "markpoint"=> $result['mark_point']
            ));    
            //写入历史记录
            $flag = $this->addeditlog($userId,$editarr,$touuid , 1);
            if ( true === $flag ){
                return true;
            }
        }
        return false;
    }
    /*
     * 修改系统备注状态
     * */
    public function updatesysremind($cardid){
        $getsync = "SELECT * FROM card_remark_schedule_sync WHERE type=1 AND card_id=:cardid";
        $result = $this->getConnection()->executeQuery($getsync, array(":cardid"=>$cardid))->fetchAll();
        if(empty($result)){
            return true;
        }
        $time =$this->getTimestamp();
        foreach($result as $val){
            $sql="UPDATE card_remark_schedule_sync SET last_modify=:lastmodify,status=:status WHERE id=:id";
            $this->getConnection()->executeUpdate($sql,array(":lastmodify"=>$time,":status"=>"delete",":id"=>$val['id']));
        }
    }

    /*
     * 名片关联人同步删除
     * */
    public function syncDelRelation($cardid){
        $relasql = "SELECT * FROM contact_related_person WHERE vcardid=:vcardid";
        $person = $this->getConnection()->executeQuery($relasql, array(":vcardid"=>$cardid))->fetchAll();
        if(!empty($person)){
            foreach($person as $val){
                $delsql="UPDATE contact_related_person SET status=2 WHERE id=:id";
                $this->getConnection()->executeUpdate($delsql,array(":id"=>$val['id']));
            }
        }
    }

    /*
   * 形成卡同步日程
   * */
    public function addSchedule($userId,$flightid){
        if(empty($flightid) && empty($userId)){
            return false;
        }
        $schedulesql="SELECT * FROM contact_card_schedule WHERE flight_id=:flightid AND user_id=:userid limit 1";
        $schedulearr = $this->getConnection()->executeQuery($schedulesql, array(":flightid"=>$flightid,":userid"=>$userId))->fetch();
        $sql = "SELECT * FROM orange_flight WHERE id=:id limit 1";
        $res = $this->getConnection()->executeQuery($sql, array(":id" => $flightid))->fetch();
        if(empty($res)){
            return false;
        }
        $flightinfo['fnum'] = $res['fnum'];
        $flightinfo['fdate'] = $res['fdate'];
        $flightinfo['FlightDep'] = $res['FlightDep'];
        $flightinfo['FlightArr'] = $res['FlightArr'];
        $flightinfo['FlightState'] = $res['FlightState'];
        $flightinfo['FlightHTerminal'] = $res['FlightHTerminal'];
        $flightinfojson = json_encode($flightinfo,JSON_UNESCAPED_UNICODE);
        $createtime = $this->getTimestamp();
        $this->em->beginTransaction();
        try {
            if(empty($schedulearr)) {
                $cardSchedule = new ContactCardSchedule();
                $cardSchedule->setVcardId('');
                $cardSchedule->setUserId($userId);
                $cardSchedule->setContent('');
                $cardSchedule->setAddress($res['FlightDep']);
                $cardSchedule->setTitle('');
                $cardSchedule->setStartTime(strtotime($res['FlightDeptimePlanDate']));
                $cardSchedule->setEndTime(0);
                $cardSchedule->setIsallday(0);
                $cardSchedule->setremindTime(0);//后续修改
                $cardSchedule->setFlagTime(0);//后续修改
                $cardSchedule->setIsRemind(0);
                $cardSchedule->setLatitude(0);
                $cardSchedule->setLongitude(0);
                $cardSchedule->setCreateTime($createtime);
                $cardSchedule->setLastModify($createtime);
                $cardSchedule->setCycle(0);
                $cardSchedule->setStatus(1);
                $cardSchedule->setScheduleFrom(4);
                $cardSchedule->setScheduleInfo($flightinfojson);
                $cardSchedule->setFlightId($flightid);
                $cardSchedule->setRemindType(0);
                //保存名片项目信息
                $this->em->persist($cardSchedule);
                $this->em->flush();
                $scheduleid = $cardSchedule->getId();
                $addmap = "INSERT INTO contact_card_schedule_map (schedule_id,status,last_modify,operation) VALUES (:scheduleid,:status,:last_modify,:operation)";
                $this->getConnection()->executeQuery($addmap, array('scheduleid' => $scheduleid, 'status' => 2, 'last_modify' => $createtime, 'operation' => 'add'));
                $relations_service = $this->container->get('account_relation_service');
                $relations_service->syncRemarkSchedule($scheduleid, '', $userId, 2, 'add', $createtime);
            }else{
                $flag = array(
                    ":id"=>$schedulearr['id'],
                    ":address"=>$res['FlightDep'],
                    ":starttime"=>strtotime($res['FlightDeptimePlanDate']),
                    ":lastmodify"=>$createtime,
                    ":scheduleinfo"=>$flightinfojson,
                    ":orangeremind"=>0,
                );
                $updatesql="UPDATE contact_card_schedule SET  address=:address,start_time=:starttime,last_modify=:lastmodify,schedule_info=:scheduleinfo,orange_remind=:orangeremind WHERE id=:id";
                $this->getConnection()->executeQuery($updatesql, $flag);
            }
            $this->em->commit();
        } catch (\Exception $ex) {
            $this->em->rollback();
            throw $ex;
        }
    }

    /*
    *日程开始时间同步系统备注
    * */
    public function setScheduleStart($param){
        if(!empty($param['title'])){
            $title = $param['title'];
        }else{
            $title = $param['content'];
        }
        $time = $this->getTimestamp();
        $contentarr = array(array('type'=>'text'));
        $contentarr[0]['content']=$title;
        $contentarr[0]['location'] = array('latitude' => $param['latitude'],'longitude' => $param['longitude'],"address"=>$param['address']);
        $json = json_encode($contentarr,JSON_UNESCAPED_UNICODE);
        $this->em->beginTransaction();
        try{
            $cardRemark = new ContactCardRemind();
            $cardRemark->setVcardId($param['vcard_id']);
            $cardRemark->setUserId($param['user_id']);
            $cardRemark->setRemark($json);
            $cardRemark->setRemarkDate($time);
            $cardRemark->setRemindTime(-1);
            $cardRemark->setStartTime($param['start_time']);
            $cardRemark->setEndTime($param['end_time']);
            $cardRemark->setModifyTime($time);
            $cardRemark->setScheduleId($param['schedule_id']);
            $cardRemark->setFlagTime($param['flag_time']);
            $cardRemark->setCycle(0);
            $cardRemark->setStatus(1);
            $cardRemark->setFromId($param['user_id']);
            $cardRemark->setSortid(0);
            $cardRemark->setType(3);
            $cardRemark->setClasses(0);
            $cardRemark->setTimeset(1);
            //保存名片项目信息
            $this->em->persist($cardRemark);
            $this->em->flush();
            $id = $cardRemark->getId();
            $sync="INSERT INTO card_remark_schedule_sync SET card_id=:selfuuid,user_id=:userid,remark_schedule=:id,status='add',type=1,class=1,last_modify=:lastmodify";
            $this->getConnection()->executeQuery($sync,array("selfuuid"=>$param['vcard_id'],"userid"=>$param['user_id'],":lastmodify"=>$this->getTimestamp(),":id"=>$id));
            $schedule ="UPDATE contact_card_schedule SET remind_type = 1 WHERE id = :id";
            $this->getConnection()->executeQuery($schedule,array(":id"=>$param['id']));
            $this->em->commit();
        }catch (\Exception $ex){
            $this->em->rollback();
            throw $ex;
        }

    }

    /*
     * 创建递一张名片同步添加行业
     * */
    public function addCategory($uuid,$userId){
        $getCategory = "SELECT category_id  FROM account_basic_category_map WHERE account_id=:userid";
        $res = $this->getConnection()->executequery($getCategory, array(':userid'=>$userId))->fetchAll();
        if(!empty($res)){
            $create_time = $this->getTimestamp();
            $industry = '';
            foreach($res as $val){
                $industry .= $val['category_id'].',';
            }
            $params = array(
                "userid"=>$userId,
                "vcardid"=>$uuid,
                "industry"=>trim($industry,','),
                "createtime"=>$create_time,
                "lastmodify"=>$create_time,
            );
            $sql="INSERT INTO contact_card_person_data SET industry=:industry,user_id=:userid,card_id=:vcardid,custom='',create_time=:createtime,last_modify=:lastmodify";
            $this->getConnection()->executeQuery($sql, $params);
        }
    }
    /**
     * 合并名片正反面信息，并去重
     * @param $oldVcard    名片原数据， Json
     * @return Json
     *  @date 2017-06-30
     * @author tianjianlin
     */
    public function getMergeCard($oldVcard){
        $vcardJsonService = $this->container->get("vcard_json_service");
        $vcardJsonService->load($oldVcard);
        //获取合并后的数组信息
        $vcardData = $vcardJsonService->getMap();

        if( !empty($vcardData['department']) ){
            $vcardData['company'][0]['department'] = $vcardData['department'];
            unset($vcardData['department']);
        }
        if( !empty($vcardData['job']) ){
            $vcardData['company'][0]['job'] = $vcardData['job'];
            unset($vcardData['job']);
        }
        if( !empty($vcardData['company_name']) ){
            $vcardData['company'][0]['company_name'] = $vcardData['company_name'];
            unset($vcardData['company_name']);
        }
        if( !empty($vcardData['address']) ){
            $vcardData['company'][0]['address'] = $vcardData['address'];
            unset($vcardData['address']);
        }
        if( !empty($vcardData['telephone']) ){
            $vcardData['company'][0]['telephone'] = $vcardData['telephone'];
            unset($vcardData['telephone']);
        }
        if( !empty($vcardData['fax']) ){
            $vcardData['company'][0]['fax'] = $vcardData['fax'];
            unset($vcardData['fax']);
        }
        if( !empty($vcardData['email']) ){
            $vcardData['company'][0]['email'] = $vcardData['email'];
            unset($vcardData['email']);
        }
        if( !empty($vcardData['web']) ){
            $vcardData['company'][0]['web'] = $vcardData['web'];
            unset($vcardData['web']);
        }
        if(empty($vcardData)) {
            return '';
        }
        return json_encode(array("front"=>$vcardData), JSON_UNESCAPED_UNICODE);
    }

    /**
     *  判断创建自己身份名片是否超出限制
     * @param $userId  创建人id
     * @return bool
     *  @date 2017-06-21
     * @author quhanlin
     */
    public function selfcard($userId){
        $getselfcardsql = "SELECT count(*) FROM contact_card WHERE user_id=:userid AND status='active' and self='true'";
        $selfcard = $this->getConnection()->executeQuery($getselfcardsql, array(':userid'=>$userId))->fetchColumn();
        $count = $this->container->getParameter('SELF_CARD_NUM');
        if($selfcard >= $count){
            return false;
        }
        return true;
    }
    /**
     * 清空语音搜索名片数据缓存
     * @param array $userArr 需要清空的用户Id
     * @return boolean
     * @date 2017-07-13
     * @author tianjianlin
     */
    public function clearallsearch( $userArr = array())
    {
        if(empty($userArr)) return true;
        $userArr =  array_unique($userArr);
        foreach($userArr as $itemId){
            $this->clearsearch($itemId);
        }
    }
    /**
     * 清空语音搜索名片数据缓存
     * @param string $userId 需要清空的用户Id
     * @return boolean
     * @date 2017-07-13
     * @author tianjianlin
     */
    public function clearsearch( $userId = '')
    {
        if(empty($userId)) return true;
        if($this->container->hasParameter('fullsearch')){
            $api_url = $this->container->getParameter('fullsearch')."/WeixinCard/clean";
        }else{
            return true;
        }
        $post_string = array(
            'user_id' => $userId
        );
        $params = json_encode($post_string);

        $curl = new CurlService();
        $result = $curl->exec($api_url, $params, 'post');
        if( 'success' === $result ){
            return true;
        }else{
            return false;
        }
    }
    /**
     * 扫描名片表记录与联系人名片表记录同步（电子名片与纸质名片互转）
     * @param string $cardid 需要同步的名片ID
     * @param string $operation 需要采取的操作
     * @date 2017-07-14
     * @author tianjianlin
     */
    public function cardToScan( $cardid = '', $operation = 'modify' )
    {
        if( empty($cardid) || empty($operation)) return false;
        if( 'deleted' === $operation ){
            $sSql = "UPDATE `scan_card_picture` SET `status`='deleted' WHERE uuid=:uuid LIMIT 1";
            $this->getManager('scandb')->getConnection()->executeUpdate( $sSql, array(':uuid'=>$cardid));
        }else{
            $param = array(":uuid"=>$cardid);
            $csql = "SELECT user_id,handle_state,FROM_UNIXTIME(created_time,'%Y-%m-%d %H:%i:%s') AS created_time,picture
                  FROM `contact_card` WHERE uuid=:uuid LIMIT 1";
            $contactCard = $this->getConnection()->executeQuery($csql,$param)->fetch();
            $esql = "SELECT vcard,pic_path_a,pic_path_b,mark_point FROM `contact_card_extend` WHERE uuid=:uuid LIMIT 1";
            $extend = $this->getConnection()->executeQuery($esql,$param)->fetch();
            //查询是否存在
            $psql = "SELECT id FROM `scan_card_picture` WHERE uuid=:uuid LIMIT 1";
            $pid = $this->getManager("scandb")->getConnection()->executeQuery($psql,$param)->fetchColumn();
            $pesql = "SELECT id FROM `scan_card_picture_ext` WHERE cardid=:uuid LIMIT 1";
            $peid = $this->getManager("scandb")->getConnection()->executeQuery($pesql,$param)->fetchColumn();

            $pArr = array(
                ":uuid"=>$cardid,
                ":account_id"=>$contactCard['user_id'],
                ":handle_state"=>$contactCard['handle_state'],
                ":created_time"=>$contactCard['created_time'],
                ":status"=> 'active',
                ":accuracy"=>100,
            );
            if( $pid > 0){
                $iScanSql = "UPDATE `scan_card_picture` SET handle_state=:handle_state,`status`=:status WHERE uuid=:uuid LIMIT 1";
            }else{
                $iScanSql = "INSERT INTO `scan_card_picture`( uuid, account_id, handle_state, created_time, `status`,accuracy)
                            VALUES(:uuid, :account_id, :handle_state, :created_time, :status, :accuracy)";
            }
            $this->getManager("scandb")->getConnection()->executeUpdate($iScanSql, $pArr);
            $peArr = array(
                ":uuid"=>$cardid,
                ":picpatha"=>$extend['pic_path_a'],
                ":picpathb"=>$extend['pic_path_b'],
                ":vcard"=>$extend['vcard'],
                ":markpoint"=>$extend['mark_point'],
                ":thumbnail"=>$contactCard['picture']
            );
            if( $peid > 0){
                $iScanExtSql = "UPDATE `scan_card_picture_ext` SET pic_path_a=:picpatha, pic_path_b=:picpathb,
                 vcard=:vcard, markpoint=:markpoint,thumbnail=:thumbnail WHERE cardid=:uuid LIMIT 1";
            }else{
                $iScanExtSql = "INSERT INTO `scan_card_picture_ext`( cardid, pic_path_a, pic_path_b, vcard, markpoint,thumbnail)
                VALUES(:uuid, :picpatha, :picpathb, :vcard, :markpoint, :thumbnail)";
            }
            $this->getManager("scandb")->getConnection()->executeUpdate($iScanExtSql, $peArr);
        }
    }

    /**
     * 同步修改（删除）扫描名片表名片
     * @param string $cardid 需要同步删除的扫描名片ID
     */
    public function delCardToScan( $cardid = "" ){
        if( empty($cardid) ){
            return false;
        }
        $sSql = "UPDATE `scan_card_picture` SET `status`='deleted' WHERE uuid=:uuid LIMIT 1";
        $this->getManager('scandb')->getConnection()->executeUpdate( $sSql, array(':uuid'=>$cardid));
        return true;
    }
    /**
     * 扫描名片表记录与联系人名片表记录同步
     * @param string $cardid 需要同步的名片ID
     * @param string $operation 需要采取的操作
     * @date 2017-08-28
     * @author tianjianlin
     */
    public function cardToScanV2( $cardid = '' )
    {
        if( empty($cardid) ) return false;

        $param = array(":uuid"=>$cardid);

        //查询名片数据
        $contactCard = $this->findContactCardOneBy( array("uuid"=>$cardid) );
        $extend = $this->findContactCardExtendOneBy( array("uuid"=>$cardid) );

        if( empty($contactCard) || empty($extend) ){
            return false;
        }

        //查询扫描名片表是否存在信息
        $accountScanService = $this->get("scancard_pic_service");
        $scanCard = $accountScanService->findScanCardByOne( array("uuid"=>$cardid) );
        $scanCardExt = $accountScanService->findScanCardExtByOne(array("cardid"=>$cardid));

        if( empty($scanCard) ){
            $scanCard   = new ScanCardPicture();
//            $scanCard->setUuid($uuid);
//            $scanCard->setHandleState($handlestate);
//            $scanCard->setStatus($status);
//            $scanCard->setAccountId($userId);
//            $scanCard->setCreatedTime($createdTime);
//            $scanCard->setExchangeTime($this->getDateTime('1970-01-01'));
//            $scanCard->setTempId('');
//            $scanCard->setAccuracy($accuracy);
//            $scanCard->setSource(0);
//            $scanCard->setDpi($dpi);
//            $scanCard->setClass($classValue);
//            $scanCard->setRectify(1);
//            $scanCard->setTypeid(0);
//            $scanCard->setLanguage($language);
//            $scanCard->setOrigin($origin);
//            $scanCard->setIfupdate(1);
//            $scanCard->setFromAccount($fromaccount);

            $accountScanService->saveScanCard( $scanCard );
        }else{
            $iScanSql = "INSERT INTO `scan_card_picture`( uuid, account_id, handle_state, created_time, `status`,accuracy)
                        VALUES(:uuid, :account_id, :handle_state, :created_time, :status, :accuracy)";
        }

        $this->getManager("scandb")->getConnection()->executeUpdate($iScanSql, $pArr);
        $peArr = array(
            ":uuid"=>$cardid,
            ":picpatha"=>$extend['pic_path_a'],
            ":picpathb"=>$extend['pic_path_b'],
            ":vcard"=>$extend['vcard'],
            ":markpoint"=>$extend['mark_point'],
            ":thumbnail"=>$contactCard['picture']
        );
        if( true){
            $iScanExtSql = "UPDATE `scan_card_picture_ext` SET pic_path_a=:picpatha, pic_path_b=:picpathb,
             vcard=:vcard, markpoint=:markpoint,thumbnail=:thumbnail WHERE cardid=:uuid LIMIT 1";
        }else{
            $iScanExtSql = "INSERT INTO `scan_card_picture_ext`( cardid, pic_path_a, pic_path_b, vcard, markpoint,thumbnail)
            VALUES(:uuid, :picpatha, :picpathb, :vcard, :markpoint, :thumbnail)";
        }
        $this->getManager("scandb")->getConnection()->executeUpdate($iScanExtSql, $peArr);
    }

    /**
     * @todo 微信绑定用户
     * @var 跨库处理
     * @param $wechatid string 微信公众号openid
     * @param $userid string 橙子用户ID
     * $date 2017-8-27
     * @author xinggm
     * @return Boolean
     */
    public function wechatBingsOrange($wechatid,$userId, $weinfo)
    {
        $updateSql = "UPDATE `weixin_user` SET user_id=:userId WHERE wechat_id=:wechatid LIMIT 1";
        $this->getManager('default')->getConnection()->executeUpdate($updateSql,array(
                    ":userId" => $userId,
                    ":wechatid"=> $wechatid
            ));
        //更新account_basic_detail表
        $udata = json_decode( $weinfo, true );
        unset( $udata["openid"] );
        unset( $udata["unionid"] );
        $userInfo = json_encode( $udata, JSON_UNESCAPED_UNICODE );

        $updateSql = "UPDATE `account_basic_detail` SET we_info=:userinfo WHERE user_id=:userId LIMIT 1";
        $this->getManager("api")->getConnection()->executeUpdate( $updateSql, array(":userinfo"=> $userInfo,":userId"=>$userId));
        return true;
    }
}
