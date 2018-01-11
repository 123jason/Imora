<?php

namespace Oradt\ServiceBundle\Services;
use Oradt\Utils\RandomString;
use Oradt\Utils\Errors;
use Oradt\StoreBundle\Entity\ScanCardPicture;
use Oradt\StoreBundle\Entity\ScanCardProperties;
use Oradt\StoreBundle\Entity\ScanCardPictureExt;
use Oradt\StoreBundle\Entity\ScanCardRbacOperationLog;
use Oradt\StoreBundle\Entity\ScanCardVcardfieldCount;
use Oradt\StoreBundle\Entity\ScanCardVcardfieldModify;
use Oradt\StoreBundle\Entity\ScanCardHandleInfo;
use Oradt\StoreBundle\Entity\ScanCardVcardHandleInfo;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Oradt\Utils;
class ScanCardService extends BaseService {

    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
        $this->em = $this->getManager('scandb');
    }   
    
    /**
     * 查看一条数据
     * 
     * @param unknown $array
     */
    public function findScanCardByOne($array){
        $repository = $this->em->getRepository ( 'OradtStoreBundle:ScanCardPicture' );
        $list = $repository->findOneBy ( $array );
        return $list;
    }
    
    /**
     * 扫描名片查找
     * 
     * @param array $array            
     * @return Oradt\StoreBundle\Entity\ScanCardPicture array
     */
    public function findScanCard($array) {
        $repository = $this->em->getRepository ( 'OradtStoreBundle:ScanCardPicture' );
        $list = $repository->findBy ( $array );
        return $list;
    }
    
    /**
     * 保存扫描名片
     * 
     * @param ScanCardPicture $scanCard            
     * @return ScanCardPicture
     */
    public function saveScanCard(ScanCardPicture $scanCard) {
        $this->em->persist ( $scanCard );
        $this->em->flush ();
        return $scanCard;
    }
    
    /**
     * 保存扫描名片
     * 
     * @param ScanCardPicture $scanCard            
     * @return ScanCardPicture
     */
    public function saveScanCardPictureExt(ScanCardPictureExt $scanCardExt) {
        $this->em->persist ( $scanCardExt );
        $this->em->flush ();
        return $scanCardExt;
    }
    
    /**
     * 删除名片基本信息数据
     * @param  string $vcardId  名片ID
     */
    public function deleteScanCardInfo($vcardId){
        $query = "DELETE FROM scan_card_vcardinfo WHERE card_id=:vcardid";
        $this->getConnection()->executeUpdate($query , array(':vcardid' => $vcardId));
    }

    /**
     * 更新扫描名片缩略图
     * @param varchar $thumb_picture  缩略图地址
     * @param char $uuid  名片ID
     */
    public function updateScancardThumbnail($thumb_picture,$uuid){
        //$this->setManager("scandb");      //设置数据库为scandb
        $sql = 'UPDATE `scan_card_picture_ext` SET thumbnail=:thumb WHERE cardid=:uuid LIMIT 1';//更新扫描名片缩略图
        $this->getConnection()->executeUpdate($sql,array(':thumb' => $thumb_picture, ':uuid' => $uuid));
    }
    public $firstcreate = false;
    /**
     * 根据扫描名片生成联系人名片
     * 
     * @param Oradt\StoreBundle\Entity\ScanCardPicture $scancardObject
     * @param string $uuid
     * @param string $cardfrom  名片来源
     */
    public function insertContactCard($scancardObject , $self='false',$localuuid='',$cardfrom='',$xyz='',$sorting=0 , $sourceType){
        if(empty($cardfrom)){
            $cardfrom = 'scan';
        }
        $uuid = $scancardObject->getUuid();
        $vcardCon = $this->getScanCardExtInfoByCardId($uuid );
        $accountContactService = $this->container->get("account_contact_service");
        $vcardArr = $accountContactService->setVcard($vcardCon['vcard']);
        //print_r($vcardArr);
        //print_r($scancardObject);
        //$vcardId = RandomString::make(32,'C');
        //$TEL        = !empty($vcardArr['TEL']) ? $vcardArr['TEL'] :'';
        $userId    = $scancardObject->getAccountId();
        $paramArray = array(
                'contactName'   => !empty($vcardArr['FN']) ? $vcardArr['FN'] :'',
                'groupId'       =>'',
                'uuid'          => $uuid,
                'localUuid'     => $localuuid,
                'vcard'         => $vcardCon['vcard'],
                'cardgroupid'   => '',
                'cardres'       => '',
                'remark'        => '',
                'formUid'       => '',
                'inContactId'   => '',
                'cardfrom'      => $cardfrom,
                'xyz'           =>$xyz,
                'cardtype'      => 'scan',
                'markpoint' => $vcardCon['markpoint'],
                'language'  => $scancardObject->getLanguage(),
                'handleState' => $scancardObject->getHandleState(),
                'sorting'    => $sorting,
                'sourceType'    => $sourceType,
                'picture'    => $vcardCon['thumbnail'],
                'picpatha'    => $vcardCon['pic_path_a'],
                'picpathb'    => $vcardCon['pic_path_b']
        );
        //前端传参确认是不是自已扫描自已的名片
        if($self==='true') {
            $paramArray['formUid'] = $userId;
        } else {
            //判断该$userid 电话是否和vcard 中 TEL 匹配 匹配则formUid = $userid
            $accountbasic = $this->getManager()->getRepository ( 'OradtStoreBundle:AccountBasic' )->findOneBy(array(
                'userId'=>$userId
            ));        
            if(!empty($vcardCon['vcard']) && !empty($accountbasic)){
                $mobile = $accountbasic->getMobile();
                if(strpos($vcardCon['vcard'],$mobile) !== FALSE){
                    $paramArray['formUid'] = $userId;
                }
            }  else {
                $paramArray['formUid'] = "";
            }
        }
        
        $result = $accountContactService->addContactCard($userId,$paramArray);
        $this->firstcreate=$accountContactService->firstcreate;
        //名片kafka消息
        $this->pushVcardId = $accountContactService->pushVcardId;
        if(false===$result){
            return Errors::$ERROR_UNKNOWN;
        }
        return true;
    }
    
    /**
     * 根据扫描名片修改联系人名片信息
     * basic 账号修改
     * @param string $userId
     * @param string $uuid
     * @param string $picture_a  图片A
     * @param string $picture_b  图片B
     */
    public function updateContactCard($userId,$uuid,$picture_a='',$picture_b=''){
        //查找该扫描名片是否存在
        $scancardObject = $this->em->getRepository ( 'OradtStoreBundle:ScanCardPicture' )->findOneBy( array(
                'accountId' => $userId, 'uuid' => $uuid
        ));
        if( empty($scancardObject) ){
            return Errors::$ERROR_PARAMETER_NOT_DATA;
        }
        $accountContactService = $this->container->get("account_contact_service");
        //查找联系人名片是否存在
        $contactCard = $accountContactService->findContactCardOneBy(array('uuid' => $uuid ,'userId' => $userId));
        if(empty($contactCard) || $contactCard->getStatus() == 'deleted'){
            return Errors::$CONTACT_CARD_ERROR_NOT_EXISTS ;
        }
        
        //获取vcard数据
        $vcard = $this->getScanCardExtInfoByCardId($uuid , 'vcard');
        
        $findArray = array('uuid' => $uuid);
        $extend = $accountContactService->findContactCardExtendOneBy($findArray);
        $extend->setVcard($vcard);//名片数据vCard
        if(!empty($picture_a)){
            $extend->setPicPathA($picture_a);
            $extend->setPicPathB($picture_b);
            $contactCard->setPicture('');
        }
        $contactCard->setStatus($scancardObject->getStatus());                      //名片状态
        $contactCard->setLastModified($this->getTimestamp());                        //更改时间
        $accountContactService->saveContactCard($contactCard,$extend);                      //更改联系人名片信息
        $accountContactService->syncCardAdd($userId,$uuid,'modify');                //同步数据更新
        //$vcardArr = $accountContactService->parseVcard($scancardObject->getVcard());
        //名片kafka消息
        $this->pushVcardId = $accountContactService->pushVcardId;
        return true;
    }
    
    /**
     * 根据扫描名片修改联系人名片信息
     * admin 账号修改
     * @param string $uuid
     */
    public function adminUpdateContactCard($uuid){
        //查找该扫描名片是否存在
        $scancardObject = $this->em->getRepository ( 'OradtStoreBundle:ScanCardPicture' )->findOneBy( array(
                'uuid' => $uuid
        ));
        if( empty($scancardObject) ){
            return Errors::$ERROR_PARAMETER_NOT_DATA;
        }
        
        //管理员上传，不同步到名片夹
        $userId     = $scancardObject->getAccountId();        
        if(substr($userId, 0,1) !=='A')
        {
            return true;
        }
        
        $accountContactService = $this->container->get("account_contact_service");
        //查找联系人名片是否存在
        $contactCard = $accountContactService->findContactCardOneBy(array('uuid' => $uuid ));
        
        if(empty($contactCard)) {
            return $this->insertContactCard($scancardObject);
        }
        
        if(!empty($contactCard) && $contactCard->getStatus() == 'deleted'){
            return Errors::$CONTACT_CARD_ERROR_NOT_EXISTS ;
        }
        
        $query = "SELECT pic_path_a,pic_path_b,vcard,markpoint FROM 
                scan_card_picture_ext WHERE cardid=:vcardid LIMIT 1";
        $card_ext = $this->getConnection()->executeQuery($query , array(':vcardid' => $uuid))->fetch();
        
        if( empty($card_ext) ){
            return Errors::$ERROR_PARAMETER_NOT_DATA;
        }
        
        $findArray = array('uuid' => $uuid);
        $extend = $accountContactService->findContactCardExtendOneBy($findArray);
        $extend->setVcard($card_ext['vcard']);//名片数据vCard
        $extend->setMarkPoint($card_ext['markpoint']);
        //$contactCard->setVcard($scancardObject->getVcard());                        //名片数据vCard
        $contactCard->setLastModified($this->getTimestamp());                        //更改时间
        $accountContactService->saveContactCard($contactCard , $extend);                      //更改联系人名片信息
                                     //获取扫描名片userid
        $accountContactService->syncCardAdd($userId,$uuid,'modify');                //同步数据更新
        
        return true;
    }
    
     /**
     * 解析VCARD 保存扫描名片扩展信息
     *
     * @param ContactCard $contactCard            
     */
    public function saveScanCardProperties(ScanCardPicture $scanCard , $vcard) {
        if(empty($vcard)){
            return false;
        }
        $cardId = $scanCard->getUuid ();         //名片id
        $userId = $scanCard->getAccountId ();    //用户id
        
        try{
            $contactService = $this->container->get("account_contact_service");
            $insertArray    = $contactService->setVcard($vcard);
            if($insertArray===false)  return false;
            if(isset($insertArray['USERID'])){
                unset($insertArray['USERID']);
            }
            //解析成功，删除原来的名片信息
            /*
            $sql = "DELETE FROM scan_card_properties WHERE account_id=:user_id AND card_id=:card_id";
            $this->getConnection()->executeQuery($sql,array(':user_id' => $userId ,':card_id' => $cardId))->execute();
            foreach ( $insertArray as $k => $v ) {
                if(empty($k) || empty($v) || is_array($v) || strlen($v)>128)
                    continue;
                $cardProperties = new ScanCardProperties ();
                $cardProperties->setCardId ( $cardId );
                $cardProperties->setAccountId ( $userId );
                $cardProperties->setName ( $k );
                $cardProperties->setValue ( $v );
                $this->em->persist ( $cardProperties );
            }
            $this->em->flush ();
            */
            //---结束
            $params = array(':user_id' => $userId ,':card_id' => $cardId);
            $query = "SELECT id FROM scan_card_vcardinfo WHERE user_id=:user_id AND card_id=:card_id";
            $result = $this->getConnection()->executeQuery($query,$params)->fetchColumn();

            if(empty($result)) {
                //insert
                $query = 'INSERT INTO scan_card_vcardinfo (card_id,user_id,FN,ORG,DEPAR,TITLE,URL,CELL,TEL,EMAIL,ADR,INDUSTRY)
                         VALUES (:card_id,:user_id,:FN,:ORG,:DEPAR,:TITLE,:URL,:CELL,:TEL,:EMAIL,:ADR,:INDUSTRY)';

                $params[':FN'] = isset($insertArray['FN']) ? $insertArray['FN'] : '';
                $params[':ORG'] = isset($insertArray['ORG']) ? $insertArray['ORG'] : '';
                $params[':DEPAR'] = isset($insertArray['DEPAR']) ? $insertArray['DEPAR'] : '';
                $params[':TITLE'] = isset($insertArray['TITLE']) ? $insertArray['TITLE'] : '';
                $params[':URL'] = isset($insertArray['URL']) ? $insertArray['URL'] : '';
                $params[':CELL'] = isset($insertArray['MOBILES']) ? $insertArray['MOBILES'] : '';
                $params[':TEL'] = isset($insertArray['TEL']) ? $insertArray['TEL'] : '';
                $params[':EMAIL'] = isset($insertArray['EMAIL']) ? $insertArray['EMAIL'] : '';
                $params[':ADR'] = isset($insertArray['ADR']) ? $insertArray['ADR'] : '';
                $params[':INDUSTRY'] = isset($insertArray['INDUSTRY']) ? $insertArray['INDUSTRY'] : '';

            }else{
                //update
                $params = array(':id' => $result);
                $query = 'UPDATE scan_card_vcardinfo SET FN=:FN,ORG=:ORG,DEPAR=:DEPAR,TITLE=:TITLE,URL=:URL,CELL=:CELL,TEL=:TEL,EMAIL=:EMAIL,ADR=:ADR,INDUSTRY=:INDUSTRY
                        WHERE id=:id';
                $params[':FN'] = isset($insertArray['FN']) ? $insertArray['FN'] : '';
                $params[':ORG'] = isset($insertArray['ORG']) ? $insertArray['ORG'] : '';
                $params[':DEPAR'] = isset($insertArray['DEPAR']) ? $insertArray['DEPAR'] : '';
                $params[':TITLE'] = isset($insertArray['TITLE']) ? $insertArray['TITLE'] : '';
                $params[':URL'] = isset($insertArray['URL']) ? $insertArray['URL'] : '';
                $params[':CELL'] = isset($insertArray['MOBILES']) ? $insertArray['MOBILES'] : '';
                $params[':TEL'] = isset($insertArray['TEL']) ? $insertArray['TEL'] : '';
                $params[':EMAIL'] = isset($insertArray['EMAIL']) ? $insertArray['EMAIL'] : '';
                $params[':ADR'] = isset($insertArray['ADR']) ? $insertArray['ADR'] : '';
                $params[':INDUSTRY'] = isset($insertArray['INDUSTRY']) ? $insertArray['INDUSTRY'] : '';
            }

            $this->getConnection()->executeUpdate($query , $params);
            return true;
        }catch (\Exception $ex){
            return false;
        }
    }
    
    /**
     * 更新扫描名片处理状态
     * @param string $userid    用户ID
     * @param string $vcardid   扫描名片ID
     * @param string $handlestate 处理状态
     */
    public function updateHandleState($userId,$vcardId,$handlestate=NUll,$vcard=""){
        if(empty($userId) && empty($vcardId) && empty($handlestate)){
            return FALSE;
        }
       // if(!in_array($handlestate, array('needhandle','neverhandle'))){
        //    return $this->renderJsonFailed(Errors::$ERROR_PARAMTER_ERROR,"paramter handlestate values");
       // }
        //更新扫描名片数据
        $findArray = array (
            'accountId' => $userId,
            'uuid'      => $vcardId
        );
        $scanCardData   = $this->findScanCardByOne($findArray);
        if(empty($scanCardData)){
            return FALSE;
        }
        $scanCardData->setHandleState ( $handlestate );
        $scanCardData->setHandledTime ( $this->getDateTime() );
        $this->em->persist ( $scanCardData );
        $this->em->flush ();
        if(!empty($vcard)){
            $this->saveScanCardProperties($scanCardData, $vcard);
        }
        return TRUE;
        
    }
    
    /**
     * 存储名片的图片路径信息
     *
     * @param ContactCard $contactCard            
     */
    public function saveScanCardPicturePath($data) 
    {
        $pdo = $this->em->getConnection();
        $res = $pdo->insert('scan_card_picture_ext' , $data);
        return $pdo->lastInsertId();
    }
    
    /**
     * 通过名片uuid 获取名片的图片路径信息
     * @param string $uuid
     * @return array | false
        Array
        (
            [id] => 1486
            [uuid] => C8SkpnFl3xnVwP8rZpsqyFsMtpVxOLAn
            [account_id] => AmcMorlC3oPVgArUoJ9121kWh8nt200000000001
            [handle_state] => needhandle
            [admin_id] => 
            [created_time] => 2015-05-20 07:35:03
            [handled_time] => 
            [status] => active
            [from_account] => wangtingtest
            [temp_id] => 
            [accuracy] => 90
            [ifupdate] => 1
        )
     */
    public function getScanCardByUuid($uuid)
    {
        $stmt = $this->em->getConnection()->prepare('SELECT * FROM `scan_card_picture` WHERE `uuid` = :uuid');
        $stmt->bindValue('uuid' , $uuid);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    /**
     * 通过名片uuid 获取名片的图片路径信息
     * @param string $cardid
     * @param string $single_field
     * @return array | "" 
       Array
       (
           [id] => 1
           [cardid] => C8SkpnFl3xnVwP8rZpsqyFsMtpVxOLAn
           [pic_path_a] => document/m/c/M/AmcMorlC3oPVgArUoJ9121kWh8nt200000000001/C8SkpnFl3xnVwP8rZpsqyFsMtpVxOLAn/1c5ZeBFy3D20150520153503_a.jpg
           [pic_path_b] => document/m/c/M/AmcMorlC3oPVgArUoJ9121kWh8nt200000000001/C8SkpnFl3xnVwP8rZpsqyFsMtpVxOLAn/42xd2QfOZx20150520153503_b.jpg
           [vcard] =>  BEGIN:VCARD
                       ...
           [markpoint] => 
       )
     */
    public function getScanCardExtInfoByCardId($cardid , $single_field='')
    {
        $stmt = $this->em->getConnection()->prepare('SELECT * FROM `scan_card_picture_ext` WHERE `cardid` = :cardid');
        $stmt->bindValue('cardid' , $cardid);
        $stmt->execute();
        $info = $stmt->fetch(\PDO::FETCH_ASSOC);
        if(empty($single_field))
            return $info ? $info : array();
        else
            return $info ? (isset($info[$single_field]) ? $info[$single_field] : '') : '';
    }
    
    /**
     * 更新名片扩展表信息
     * @param string $cardid 名片ID
     * @param array $data    数据
       Array
       (
           [pic_path_a] => document/m/c/M/AmcMorlC3oPVgArUoJ9121kWh8nt200000000001/C8SkpnFl3xnVwP8rZpsqyFsMtpVxOLAn/1c5ZeBFy3D20150520153503_a.jpg
           ...
       )
     * @return int 返回影响的条数 如果更新的信息和数据库中的信息一样 返回影响条数也是0
     */
    public function updateScanCardPictureExt($cardid , array $data)
    {
        $pdo = $this->em->getConnection();
        if($this->getScanCardExtInfoByCardId($cardid))
        {
            $effect_rows = $pdo->update('scan_card_picture_ext' , $data , array('cardid'=>$cardid));
            return $effect_rows;
        }
        else
        {
            //为了兼容由于某种原因附表数据不同步时也可以更新
            $data['cardid'] = $cardid;
            $new_id = $this->saveScanCardPicturePath($data);
            return $new_id ? 1 : 0;
        }
    }
    
    /**
     * 获取图片分辨率
     * getJPEGresolution
     */
    public function getJPEGresolution($filename){
        if(empty($filename))                return -1;
        if(filesize($filename) <= 0)        return -1;   //判断图片的大小
        try{
            $dpiX   = -1;
            $images = new \Imagick($filename);//新建 Imagick 类
            $dpiXy  = @$images->getImageResolution();    //取不到的 x y 值都为0
            if(!is_array($dpiXy))   return -1;
            if(isset($dpiXy['x']) && !empty($dpiXy['x'])){
                $dpiX = $dpiXy['x'];
            }
            return $dpiX;
        }catch (\Exception $ex){
            throw $ex;
            return -1;
        }
    }
    public function saveScanCardHandle($handledata){
        $pdo = $this->em->getConnection();
        $res = $pdo->insert('scan_card_handle' , $handledata);
        return $pdo->lastInsertId();
    }

    /**
     * 合并传过来的vcard和原数组中的vcard。数据顺序与要求顺序一致。替换'name','mobile','company'这一层级
     * @param  [json] $preVcard 原json数据 
     * @param  [json] $newVcard 全端传回来的json数据 要求包括正反两面的信息
     * @return [string]           合并后的json数据
     */
    public function mergeVcard($preVcard, $newVcard)
    {
        $preVcard = json_decode($preVcard, true);
        $newVcard = json_decode($newVcard, true);
        $vcard = array();

        $allowFields = array('name', 'mobile','email','im','company');
        $companyFields = array('company_name', 'department', 'job', 'address', 'telephone', 'fax', 'email', 'web');
        $pages = array('front', 'back');

        foreach ($pages as $page) { //遍历数据结构最外层正反面
            if (isset($newVcard[$page])) { // 姓名 电话 公司项以新json为准
            //后台可以编辑的数据
            foreach ($allowFields as $allowField) { //遍历姓名,电话,公司
                if ($allowField == 'company') {
                    if (isset($newVcard[$page][$allowField])) { //很多个公司
                        foreach ($newVcard[$page][$allowField] as $companykey => $company) { //单个公司
                            foreach ($companyFields as $companyField) { //遍历公司的字段
                                if (isset($newVcard[$page][$allowField][$companykey][$companyField])) {
                                    $newArr = $this->setElementOrder($newVcard[$page][$allowField][$companykey][$companyField]);
                                    $vcard[$page][$allowField][$companykey][$companyField] = $newArr;
                                }
                            }
                        }
                    } 
                } else {
                    if (isset($newVcard[$page][$allowField])) {
                        $newArr = $this->setElementOrder($newVcard[$page][$allowField]);
                        $vcard[$page][$allowField] = $newArr;
                    }
                }
            }
            }
            //后台不可以编辑的数据
            if (isset($preVcard[$page])) { // 企业模板和customize 以原有json为准
                foreach ($preVcard[$page] as $preFieldKey => $preFieldValue) {
                    if (!in_array($preFieldKey, $allowFields)) {
                        $vcard[$page][$preFieldKey] = $preFieldValue;
                    }
                }
            }
        }
        return json_encode($vcard, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 调整数组顺序
     * @param array $preArr [乱序数组]
     * @return array $orderedArr [正序数组]
     */
    private function setElementOrder(array $preArrs)
    {
        $elementOrders = array('title', 'title_self_def', 'value', 'surname', 'given_name', 'is_chinese', 'is_changed', 'input');

        $orderedArr = array();
        foreach ($preArrs as $preArrKey => $preArr) {
            foreach ($elementOrders as $element) {
                if (isset($preArr[$element])) {
                    $orderedArr[$preArrKey][$element] = $preArr[$element];
                }
            }
        }
        return $orderedArr;
    }

    /**
     * 添加数据到scan_card_rbac_operation_log
     * @param  array $op [description]
     * @return array $op;
     */
    public function saveScanCardRbacOperationLog(ScanCardRbacOperationLog $op) {
        $this->em->persist ( $op );
        $this->em->flush ();
        return $op;
    }

    /**
     * updateHandleStateAndExt and update mark workflow
     *
     * @param userId user_id
     * @param vcardId vcard_id
     * @param data ext_data
     * @param handlestate handle_state
     * @param vcard vcard info
     *
     * @return
     */
    public function updateHandleStateAndExt($userId, $vcardId, array $data = array(), $handlestate = null, $vcard = "") {
        $is_change_mark_info = false;
        $handle_state = '';

        if(!empty($data)) {
            if('neverhandle' !== $handlestate &&
               !empty($data['pic_path_a'])) {
                $is_change_mark_info = true;
                $handlestate = 'needhandle';
            }
            $this->updateScanCardPictureExt($vcardId, $data);
        }

        if(!empty($handlestate)) {
            if(!$this->updateHandleState($userId, $vcardId, $handlestate, $vcard)) { return Errors::$ERROR_UNKNOWN;
            }
        }

        if($is_change_mark_info) {
            $markInfoService = $this->container->get("mark_point_handle_info_service");
            $markInfoService->resetMarkPointHandleInfo($vcardId);
        }
        return true;
    }
    /**
     * 全检被修改的字段的数量以及总数量
     * @param  [type] $preVcard 修改之前的vcard
     * @param  [type] $newVcard 修改之后的vcard
     * @return [type]           [description]
     */
    public function fieldCount($preVcard, $newVcard)
    {
        $preVcard = json_decode($preVcard, true);
        $newVcard = json_decode($newVcard, true);
        $allowFields = array('name', 'mobile', 'email','im','company');
        $companyFields = array('department', 'job', 'company_name', 'address', 'telephone', 'fax', 'email', 'web');
        $pages = array('front', 'back');
        $data = array();
        foreach ($pages as $page) { //遍历数据结构最外层正反面
            if (isset($newVcard[$page])) { // 姓名 电话 公司项以新json为准
            //后台可以编辑的数据
            foreach ($allowFields as $allowField) { //遍历姓名,电话,公司
                if ($allowField == 'company') {
                    foreach ($companyFields as $companyField) { //遍历公司的字段
                        if (isset($newVcard[$page][$allowField])) { //很多个公司
                            foreach ($newVcard[$page][$allowField] as $companykey => $company) { //单个公司
                                if (isset($newVcard[$page][$allowField][$companykey][$companyField])) {
                                    @$data[$page][$allowField][$companykey][$companyField] = $this->array_diff_assoc2_deep($newVcard[$page][$allowField][$companykey][$companyField],$preVcard[$page][$allowField][$companykey][$companyField]);
                                }
                            }
                        }
                    }
                } else {
                    if (isset($newVcard[$page][$allowField])) {
                        @$data[$page][$allowField] = $this->array_diff_assoc2_deep($newVcard[$page][$allowField],$preVcard[$page][$allowField]);
                    }
                }
            }
            }
        }
        $data2 = $this->mergeFieldCount($data);
        return $data2;
    }
    public function array_diff_assoc2_deep($arr1,$arr2){
        $i=0;$res =array();$j=0;
        if(is_array($arr1)){
            foreach ($arr1 as $key => $value) {
                if(is_array($arr1)){
                    $count = count($arr1);
                    if($value['value']!=$arr2[$key]['value']){
                        $i++;
                    }
                    if($value['value']==$arr2[$key]['value']){
                        $j++;
                    }
                }else{
                    $data = $this->array_diff_assoc2_deep($value,$arr2[$key]);
                }
            }
        }
        $res['fieldCount'] = $count;
        $res['modifyCount'] = $i;
        $res['vcardHandle'] = $j;
        return $res;
    }
    /**
     * 正面，反面 各字段全检修改的数量合并。
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    function mergeFieldCount($array){
        $result = array();$data = array();
        foreach ($array as $key => $value) {
            foreach($value as $k => $v){
                if(isset($v['fieldCount'])){
                    @$result[$k]['fieldCount'] += $v['fieldCount'];
                    @$result[$k]['modifyCount'] +=$v['modifyCount'];
                    @$result[$k]['vcardHandle'] +=$v['vcardHandle'];
                }else{
                    $data = $this->mergeFieldCount($v);
                }
            }
        }
        $result = array_merge($result,$data);
        return $result;
    }
    public function saveScanCardVcardfieldCount($vcardid,$data) {
       $countinfo = $this->findScanCardVcardfieldCountByOne(array('vcardid'=>$vcardid));
        //先去查看vcardid是否存在，如果存在，则进行修改。否则，添加
        if(empty($countinfo)){
             $countinfo = new ScanCardVcardfieldCount;
             $countinfo->setVcardid($vcardid);
        }
        $countinfo->setName(isset($data['name']['fieldCount'])?$data['name']['fieldCount']:0);
        $countinfo->setMobile(isset($data['mobile']['fieldCount'])?$data['mobile']['fieldCount']:0);
        $countinfo->setCompany(isset($data['company_name']['fieldCount'])?$data['company_name']['fieldCount']:0);
        $countinfo->setDepartment(isset($data['department']['fieldCount'])?$data['department']['fieldCount']:0);
        $countinfo->setJob(isset($data['job']['fieldCount'])?$data['job']['fieldCount']:0);
        $countinfo->setAddress(isset($data['address']['fieldCount'])?$data['address']['fieldCount']:0);
        $countinfo->setTelphone(isset($data['telephone']['fieldCount'])?$data['telephone']['fieldCount']:0);
        $countinfo->setFax(isset($data['fax']['fieldCount'])?$data['fax']['fieldCount']:0);
        $countinfo->setEmail(isset($data['email']['fieldCount'])?$data['email']['fieldCount']:0);
        $countinfo->setWeb(isset($data['web']['fieldCount'])?$data['web']['fieldCount']:0);
        
        $res = $this->findScanCardVcardfieldCountByOne(array('vcardid'=>$vcardid));
        if(empty($res)){
            $this->em->persist ( $countinfo );    
        }
        
        $this->em->flush ();
        return true;
    }
    public function saveScanCardVcardfieldModify($vcardid,$preVcard,$newVcard,$checkoperator,$handled_uid,$data) {
        $countinfo = $this->findScanCardVcardfieldModifyByOne(array('vcardid'=>$vcardid));
        //先去查看vcardid是否存在，如果存在，则进行修改。否则insert
        if(empty($countinfo)){
            $countinfo = new ScanCardVcardfieldModify;
            $countinfo->setVcardid($vcardid);
        }
        
        $employee = $this->getEmployeeById($handled_uid);
        $fullcheck_account = $employee->getEmail();
        $time = new \DateTime('now',new \DateTimeZone('PRC'));
        $time = $time->format("Y-m-d H:i:s");
        $countinfo->setFromvcard($preVcard);
        $countinfo->setTovcard($newVcard);
        $countinfo->setCheckAccount($checkoperator);
        $countinfo->setFullcheckAccount($fullcheck_account);
        $countinfo->setName(isset($data['name']['modifyCount'])?$data['name']['modifyCount']:0);
        $countinfo->setMobile(isset($data['mobile']['modifyCount'])?$data['mobile']['modifyCount']:0);
        $countinfo->setCompany(isset($data['company_name']['modifyCount'])?$data['company_name']['modifyCount']:0);
        $countinfo->setDepartment(isset($data['department']['modifyCount'])?$data['department']['modifyCount']:0);
        $countinfo->setJob(isset($data['job']['modifyCount'])?$data['job']['modifyCount']:0);
        $countinfo->setAddress(isset($data['address']['modifyCount'])?$data['address']['modifyCount']:0);
        $countinfo->setTelphone(isset($data['telephone']['modifyCount'])?$data['telephone']['modifyCount']:0);
        $countinfo->setFax(isset($data['fax']['modifyCount'])?$data['fax']['modifyCount']:0);
        $countinfo->setEmail(isset($data['email']['modifyCount'])?$data['email']['modifyCount']:0);
        $countinfo->setWeb(isset($data['web']['modifyCount'])?$data['web']['modifyCount']:0);
        $countinfo->setModifyTime($time);
        $res = $this->findScanCardVcardfieldModifyByOne(array('vcardid'=>$vcardid));
        if(empty($res)){
            $this->em->persist ( $countinfo );
        }
        $this->em->flush ();
        return true;
    }
    public function saveScanCardHandleInfo($vcardid,$vcard,$data) {
        //先去查看vcardid是否存在，如果存在，则进行修改。否则insert
        $countinfo = $this->findScanCardHandleInfoByOne(array('vcardid'=>$vcardid));
        if(empty($countinfo)){
            $countinfo = new ScanCardHandleInfo;
            $countinfo->setVcardid($vcardid);
        }
        $countinfo->setVcard($vcard);
        $countinfo->setName(isset($data['name'])?$data['name']:0);
        $countinfo->setMobile(isset($data['mobile'])?$data['mobile']:0);
        $countinfo->setCompany(isset($data['company_name'])?$data['company_name']:0);
        $countinfo->setDepartment(isset($data['department'])?$data['department']:0);
        $countinfo->setJob(isset($data['job'])?$data['job']:0);
        $countinfo->setAddress(isset($data['address'])?$data['address']:0);
        $countinfo->setTelphone(isset($data['telephone'])?$data['telephone']:0);
        $countinfo->setFax(isset($data['fax'])?$data['fax']:0);
        $countinfo->setEmail(isset($data['email'])?$data['email']:0);
        $countinfo->setWeb(isset($data['web'])?$data['web']:0);
        $countinfo->setStatus(2);
        $time = new \DateTime('now',new \DateTimeZone('PRC'));
        //$time = $time->format("Y-m-d H:i:s");
        $countinfo->setModifyTime($time);
        $res = $this->findScanCardHandleInfoByOne(array('vcardid'=>$vcardid));
        if(empty($res)){
            $this->em->persist ( $countinfo );
        }
        $this->em->flush ();
        return true;
    }
    /**
     * 根据employeeid查看账户信息
     */
    public function getEmployeeById($id)
    {
        $employee = $this->em->getRepository('OradtStoreBundle:AccountEmployee')
            ->findOneBy(array('emplId'=>$id));
        return $employee;
    }

    /**
     * 查看名片数据扩展表
     */
    public function findScanCardExtByOne($array){
        $repository = $this->em->getRepository ( 'OradtStoreBundle:ScanCardPictureExt' );
        $list = $repository->findOneBy ( $array );
        return $list;
    }
    /**
     * 查看名片数据扩展表
     */
    public function findScanCardVcardfieldModifyByOne($array){
        $repository = $this->em->getRepository ( 'OradtStoreBundle:ScanCardVcardfieldModify' );
        $list = $repository->findOneBy ( $array );
        return $list;
    }
    /**
     * 查看名片数据扩展表
     */
    public function findScanCardVcardfieldCountByOne($array){
        $repository = $this->em->getRepository ( 'OradtStoreBundle:ScanCardVcardfieldCount' );
        $list = $repository->findOneBy ( $array );
        return $list;
    }

    /**
     * 查看名片各字段个数统计表
     */
    public function findScanCardHandleInfoByOne($array){
        $repository = $this->em->getRepository ( 'OradtStoreBundle:ScanCardHandleInfo' );
        $list = $repository->findOneBy ( $array );
        return $list;
    }
    /**
     * 
     */
    public function findScanCardVcardHandleInfoByOne($array){
        $repository = $this->em->getRepository('OradtStoreBundle:ScanCardVcardHandleInfo');
        $list = $repository->findOneBy( $array );
        return $list;
    }
    /**
     * @param  [type] $vcardid 名片id
     * @param  [type] $vcard   Vcard信息
     * @param  [type] $data    添加数据信息
     * @return [type]  添加数据到scan_card_vcard_handle_info表     
     */
    public function saveScanCardVcardHandleInfo($vcardid,$vcard,$data) {
        //先去查看vcardid是否存在，如果存在，则进行修改。否则insert
        $countinfo = $this->findScanCardVcardHandleInfoByOne(array('vcardid'=>$vcardid));
        if(empty($countinfo)){
            $countinfo = new ScanCardVcardHandleInfo;
            $countinfo->setVcardid($vcardid);
        }
        $countinfo->setVcard($vcard);
        $countinfo->setName(isset($data['name']['vcardHandle'])?$data['name']['vcardHandle']:0);
        $countinfo->setMobile(isset($data['mobile']['vcardHandle'])?$data['mobile']['vcardHandle']:0);
        $countinfo->setCompany(isset($data['company_name']['vcardHandle'])?$data['company_name']['vcardHandle']:0);
        $countinfo->setDepartment(isset($data['department']['vcardHandle'])?$data['department']['vcardHandle']:0);
        $countinfo->setJob(isset($data['job']['vcardHandle'])?$data['job']['vcardHandle']:0);
        $countinfo->setAddress(isset($data['address']['vcardHandle'])?$data['address']['vcardHandle']:0);
        $countinfo->setTelphone(isset($data['telephone']['vcardHandle'])?$data['telephone']['vcardHandle']:0);
        $countinfo->setFax(isset($data['fax']['vcardHandle'])?$data['fax']['vcardHandle']:0);
        $countinfo->setEmail(isset($data['email']['vcardHandle'])?$data['email']['vcardHandle']:0);
        $countinfo->setWeb(isset($data['web']['vcardHandle'])?$data['web']['vcardHandle']:0);
        $time = new \DateTime('now',new \DateTimeZone('PRC'));
        $countinfo->setModifyTime($time);
        $res = $this->findScanCardVcardHandleInfoByOne(array('vcardid'=>$vcardid));
        if(empty($res)){
            $this->em->persist ( $countinfo );
        }
        $this->em->flush ();
        return true;
    }
}