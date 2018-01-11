<?php
/**
 * @name account_emp_service
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
use Oradt\StoreBundle\Entity\AccountBiz;
use Oradt\StoreBundle\Entity\AccountBizDetail;
use Oradt\StoreBundle\Entity\AccountBizExtendInfo;
use Oradt\StoreBundle\Entity\AccountBizEmployee;
use Oradt\StoreBundle\Entity\AccountBizDepartment;
use Oradt\StoreBundle\Entity\AccountBizGroupMap;
use Oradt\StoreBundle\Entity\AccountBizGroupTitle;
use Oradt\StoreBundle\Entity\AccountBizEmployeeLogin;
use Oradt\StoreBundle\Entity\AccountBizImportEmp;
use Oradt\StoreBundle\Entity\BizAuthorPackage;
use Oradt\StoreBundle\Entity\BizCustomerCompany;
use Oradt\Utils\Str2PY;
use Oradt\Utils\Password;
use Doctrine\Common\Cache\FilesystemCache;

class AccountEmpService extends BaseService {
    /**
     * 用户ID  cacheKey
     */
    public $cacheKey   = 'user:maxid' ;                   //最在用户ID缓存键名

    //添加员工添加的字段及其默认值
    public $configData = array(
        'name'      =>'',
        'superior'  =>'',
        'department'=>'',
        'title'     =>'',
        'ename'     =>'',
        'esuperior' =>'',
        'edepartment'=>'',
        'etitle'    =>'',
        'mobile'    =>'',
        'mobiles'   =>'',
        'email'     =>'',
        'emails'    =>'',
        'phones'    =>'',
        'faxs'      =>'',
        'authorid'  =>'',
        'payid'     =>'',
        'roleid'    =>'',
        'enable'    =>2
    );

    public $globalBase;
    
    public function __construct(EntityManager $entityManager, ContainerInterface $container) {
        parent::__construct($container);
        if($this->container->getParameter('redis_key_pre')){
            $this->cacheKey .= '_'.$this->container->getParameter('redis_key_pre');
        }
        $this->globalBase = $this->container->get('global_base');
    }

    /**
     * @note: 一个员工多个角色
     * @param $role_id string :多个逗号隔开
     * @param $empid 员工id
     * @version 2016-3-8
     */
    public function insertOneEmpMoreRole($role_id,$empid)
    {
        if (empty($role_id) || empty($empid)) {
            return false;
        }
        $roleids = explode(',', $role_id);
        $values  = '';
        foreach ($roleids as $v) {
            $values .="('{$v}','".$empId."',1),";
        }
        $values = rtrim($values,",");
        $insertsql = "INSERT INTO `account_role_map` (roleid,employeeid,status) values {$values}";
        $this->getConnection()->executeQuery($insertsql);
        return true;
    }
    /**
     * @note 判断是否存在，不存在则设置为空值
     * @param $param array();
     * @return array();
     * @version 2016-3-8
     */
    public function checkIsset($param)
    {
        $configData = $this->configData;
        $res = array();
        foreach ($configData as $key => $val) {
            if (isset($param[$key])) {
                $res[$key] = $param[$key];
            }else{
                $res[$key] = $val;
            }
        }
        return $res;
    }
    /**
     * 自动添加员工邮箱账号
     */
    public function registeBizEmployee($data,$bizObj,$detailObj,$infoObj)
    {
        // $functionService = $this->container->get('function_service');           
        //获取service
        $globalBase = $this->globalBase;
        $random     = new RandomString();
        $password   = new Password();
        $bizId      = $random->make(40, Codes::B);     //获取40位字符串ID
        $groupId    = $random->make(32);
        $passwd     = $data['passwd'];
        $email      = $data['email'];
        $name       = $data['name'];
        $biz_id     = $data['bizid'];
        $timef      = $data['timef'];
        $ctime      = $data['ctime'];
        //给企业账户基本信息赋值
        $accountBiz = array(
            'BizId' => $bizId,
            'UserName' => $email, //登录邮箱
            'Password' => $password->encrypt($passwd), //登录密码
            'SecureLevel' => 1, //密码等级
            'Status' => 'limited'//企业用户状态：待激发
        );
        //给会员账号详情赋值
        $basicDetail = array(
            'BizId' => $bizId,
            'BizName' => $name,//员工公司名称和总公司名称一样
            'Prespell' => '',
            'BizAddress' => ' ', 
            'BizEmail' => $email, 
            'BizLicenseCode' => ' ',
            'BizOrgCode' => '', //省id
            'BizInfo' => '', 
            'Website' => '', //企业网址
            'BizSize' => 1, //企业规模
            'BizType' => 1, //企业类型
            'LogoPath' => '', //企业LOGO
            'CountryCode' => 0, //市id
            'Region' => '',//县id
            'Longitude' => '0',
            'Latitude' => '0',
            'Imid'     => 0,
            'Countryid' => 0,
            'CategoryId' => '',
            'CategoryId2' => '',
            'Phone' => '',
            'Contact'=>'',
            'Languageid' => 0,
            'BranchAddress' => '',
            'Bizno' => 'com'.$timef,
            'RegistType' =>1,
            'BizsuperId'=>$biz_id
        );
        //给扩展基本信息赋值
        $basicExtendInfo = array(
          'BizId' => $bizId,
          'CreatedTime' => $ctime, //注册时间
          'RegisterIp' => '', //注册IP
          'AdminId' => ''//管理员操作ID
        );
        // $this->em->getConnection()->beginTransaction();
        try {
            //通过AccountBizService调用查询方法获取相应的数据
            $rs1 = $globalBase->execute($accountBiz, $bizObj);
            $rs2 = $globalBase->execute($basicDetail, $detailObj);
            $rs3 = $globalBase->execute($basicExtendInfo, $infoObj );
            if ($rs1 && $rs2 && $rs3) {
               $res['clientid'] = $bizId;
            }
             // $this->em->getConnection()->commit();
        } catch (\Exception $e) {
              $this->em->getConnection()->rollback();
              throw $e;
        }
        return $res;
    }
    /**
     * 自动添加到员工登录
     */
    public function registeBizEmpLogin($data,$empLoginObj)
    {
        // $functionService = $this->container->get('function_service');          
        //获取service
        $globalBase = $this->globalBase;
        $password   = new Password();
        $empLogin = array(
             'Empid'=>$data['empid'],
            'Email'=>$data['email'],
            'Passwd' => $password->encrypt($data['passwd']), //登录密码
            'Status' => 'active',//企业用户状态：待激发
            'Pwd'  =>$data['passwd']
        );
        // $this->em->getConnection()->beginTransaction();
        try {
            //通过AccountBizService调用查询方法获取相应的数据
            $res1 = $globalBase->execute($empLogin, $empLoginObj);
            if ($res1) {
                $res['id'] = $res1->getId();
            }
            // $this->em->getConnection()->commit();
        } catch (\Exception $e) {
            $this->em->getConnection()->rollback();
            throw $e;
        }
        return $res;
    }
    /**
     * 自动添加department表
     */
    public function insertBizDepart($data,$departObj,$groupMapObj,$groupTitleObj)
    {
        $globalBase = $this->globalBase;
        $random     = new RandomString();
        $departid   = $random->make(32);
        // $name       = $data['group']['name'];
        // $type       = $data['group']['type'];
        // $ctime      = $data['group']['time'];
        $departArr  = array(
            'DepartId'=> $departid,
            'Name'    => $data['group']['name'],
            'Type'    => $data['group']['type'],
            'CreatedTime'=>$data['group']['time'],
            'BizId'   =>$data['group']['bizId'],
            'Status'  =>$data['group']['status'],
            'Language'  =>$data['group']['language'],
            'Ename'   =>''
        );
        $groupArr   = isset($data['groupMap'])?$data['groupMap']:'';
        $titleArr   = $data['groupTit'];
        $groupArr['departid'] = $titleArr['groupid'] = $departid;
        $result = array();
        // $this->em->getConnection()->beginTransaction();
         try {
            //通过AccountBizService调用查询方法获取相应的数据
             $res  = $globalBase->execute($departArr, $departObj);
            // 英文不添加map
            if (2 == $data['group']['language']) {
                $res1 = TRUE;
            }else{
                $res1 = $this->insertBizGroupMap($groupArr,$groupMapObj);
            } 
            $res2 = $this->insertBizGroupTitle($titleArr,$groupTitleObj);
             // $res1 = $globalBase->execute($groupArr,$groupMapObj);
            if ($res && $res1 && $res2) {
                $result['departid'] = $departid;
            }
            // $this->em->getConnection()->commit();
        } catch (\Exception $e) {
            $this->em->getConnection()->rollback();
            throw $e;
        }
         return $result;
    }
    /**
     * 自动添加group_map表 
     */
    public function insertBizGroupMap($data,$groupMapObj){
        $globalBase = $this->globalBase;
        $groupArr   = array(
            "GroupId"=>$data['departid'],
            'EmployeeId'=>$data['employee_id'],
            'Isclosed'=>$data['isclosed'],
            'Isin'=>$data['isin'],
            'CreatedTime'=>$data['created_time']
        );
      $result = false;
      // $this->em->getConnection()->beginTransaction();
      try {
            $res = $globalBase->execute($groupArr,$groupMapObj);
            if ($res) {
                  $result = true;
            }
            // $this->em->getConnection()->commit();
            } catch (\Exception $e) {
                $this->em->getConnection()->rollback();
                throw $e;
            }
        return $result;
    }
    /**
     * 自动添加group_title表
     */
    public function insertBizGroupTitle($data,$groupTitleObj)
    {
        $globalBase = $this->globalBase;
        $groupArr   = array(
            "GroupId" =>$data['groupid'],
            'Title'   =>$data['title'],
            'BizId'   =>$data['bizid'],
            'AddId'   =>$data['addid'],
            'CreatedTime'=>$data['time']
        );
        $result = false;
        $sql = array('title'=>$data['title'],'bizId'=>$data['bizid'],'groupId'=>$data['groupid']);
        $checkTitle = $globalBase->findOneBy('AccountBizGroupTitle',$sql);
        if (!empty($checkTitle)) {
            return true;
        }
        // $this->em->getConnection()->beginTransaction();
        try {
            $res = $globalBase->execute($groupArr,$groupTitleObj);
            if ($res) {
                $result = true;
            }
         // $this->em->getConnection()->commit();
        } catch (\Exception $e) {
            $this->em->getConnection()->rollback();
            throw $e;
        }
        return $result;
    }

    /**
     * 企业名片池 添加或者修改操作
     * @param string $bizId 企业ID
     * @param string $targetId 企业员工帐号ID
     * @param tinyint $cardtype 名片类型  1员工名片 2企业共享客户名片
     */
    public function handleBizCardPool( $bizId = '', $targetId = ''){
        if( empty($bizId) ||  empty($targetId) ){
            return false;
        }
        
        $querySql = "SELECT * FROM `account_biz_employee` WHERE biz_id=:bizId AND user_id=:userId AND `status`=1 LIMIT 1";
        $employee = $this->em->getConnection()->executeQuery($querySql, array(':bizId'=>$bizId, ':userId'=>$targetId))->fetch();
        if( empty($employee) ){
            return false;
        }
        
        $bizSql = "SELECT biz_name,biz_address,website FROM `account_biz_detail` WHERE biz_id=:bizId LIMIT 1";
        $bizRow = $this->em->getConnection()->executeQuery($bizSql, array( ':bizId'=>$bizId ))->fetch();
        
        $vcardData = array();
        $vcardData['FN'] = empty($employee['name']) ? '' : $employee['name'];
        $vcardData['ORG'] = empty($bizRow['biz_name']) ? '' : $bizRow['biz_name'];
        //查询员工所在部门
        $departSql = "SELECT d.name FROM `account_biz_group_map` m LEFT JOIN account_biz_department d ON d.depart_id=m.group_id"
                . " WHERE d.biz_id=:bizId AND employee_id=:empId AND d.type=1";
        $departList = $this->em->getConnection()->executeQuery($departSql, array( ':bizId'=>$bizId, ':empId'=>$employee['emp_id'] ))->fetchAll();
        foreach( $departList as $item ){
            $vcardData['DEPAR'][] = $item['name'];
        }
        $vcardData['TITLE'] = empty($employee['title']) ? array() : explode(',', $employee['title']);
        $vcardData['URL'] = empty($bizRow['website']) ? array() : explode(',', $bizRow['website']);
        
        $vcardData['MOBILES'][] = empty($employee['mobile']) ? '' : $employee['mobile'];
        if( !empty($employee['mobiles']) ){
            $vcardData['MOBILES'] = array_merge($vcardData['MOBILES'],explode(',', $employee['mobiles']));
        }
        $vcardData['EMAIL'][] = empty($employee['email']) ? '' : $employee['email'];
        if( !empty($employee['emails']) ){
            $vcardData['EMAIL'] = array_merge($vcardData['EMAIL'],explode(',', $employee['emails']));
        }
        if( !empty($employee['phones']) ){
            $vcardData['TELS'] = explode(',', $employee['phones']);
        }
        if( !empty($employee['faxs']) ){
            $vcardData['FAXS'] = explode(',', $employee['faxs']);
        }
        $vcardData['ADR'] = empty($bizRow['biz_address']) ? array() : explode(',', $bizRow['biz_address']);
        
        //名片数据
        $vcard = '';
        if( !empty($vcardData) ){
            $vcardService =  $this->container->get('vcard_json_service');
            $vcard = $vcardService->setParam( array( 'front'=> $vcardData ) );
        }
        $cardPoolType = 1;//后台企业添加 企业员工名片
        $param = array(
            "vcard" => $vcard,
            "picture" => '',
            "cardres" => '',
            'cardPoolType' => $cardPoolType,
        );
        //查询是否已存在员工名片
        $sql = "SELECT card_id FROM `biz_card_pool` WHERE biz_id=:bizId AND user_id=:targetId AND cardtype=:cardtype AND isdelete=0 LIMIT 1";
        $cardid = $this->em->getConnection()->executeQuery( $sql, array(
            ':bizId' => $bizId,
            ':targetId' => $targetId,
            ':cardtype' => $cardPoolType,
            ))->fetchColumn();
        if( empty($cardid) ){//不存在则添加
            $this->addBizCardPool($bizId, $targetId, $param, true);
        }else{//存在修改
            $this->modifyBizCardPool($targetId, $cardid, $param);
        }
        return true;
    }
    /**
     * 添加名片池名片
     * @param string $bizId 企业ID
     * @param string $targetId 企业员工帐号ID
     * @param array $paramArr 名片池各个字段
     * array(
            "picture" => $paramArr['picture'], //缩略图
            "vcard" => $paramArr['vcard'], //名片基本信息
            "cardres" =>  $paramArr['cardres'], //模板资源包
        )
     * @param tinyint $cardtype 名片类型  1员工名片 2企业共享客户名片
     */
    public function addBizCardPool( $bizId = '', $targetId = '', $paramArr = array(), $isadmin = false ){
        if( empty($bizId) ||  empty($targetId) ||  empty($paramArr) ){
            return false;
        }
        $this->em->getConnection()->beginTransaction();
        try{
            $currentItme = time();
            $sql = "INSERT INTO `biz_card_pool`(card_id, biz_id, user_id, cardtype,"
                    . " create_time) VALUES (:cardId, :bizId, :userId, :cardtype, :createtime)";
            if(isset($paramArr['cardPoolType'])){
                $cardid = RandomString::make(32,Codes::A);
            }else{
                $cardid = RandomString::make(32,Codes::B);
            }
            $params = array(
                ":cardId" => empty($paramArr['cardid']) ? $cardid : $paramArr['cardid'],
                ":bizId"  => $bizId,
                ":userId" => $targetId,
                ":cardtype" => isset($paramArr['cardPoolType']) ? intval($paramArr['cardPoolType']) : 2,
                ":createtime" => $currentItme
            );
            $this->em->getConnection()->executeQuery( $sql, $params);
            $accountContactService = $this->container->get("account_contact_service");
            //企业员工名片则添加到名片夹
            if( true === $isadmin ){
                //员工名片数据
                $cardData =  array(
                    "uuid" => $params[":cardId"],
                    "vcard" => empty($paramArr['vcard']) ? '': $paramArr['vcard'],
                    "picture" => empty($paramArr['picture']) ? '': $paramArr['picture'],
                    "cardres" => empty($paramArr['cardres']) ? '': $paramArr['cardres'],
                    "cardfrom" => 'enterprise',
                    "cardtype" => 'eps',
                    "formUid" => ($params[":cardtype"] === 1) ? $targetId : '',//自己的名片
                    "handleState" => 'neverhandle',
                    "sourceUuid" => empty($paramArr['sourceUuid']) ? '': $paramArr['sourceUuid'],
                );
                //var_dump($cardData); exit();
                $accountContactService->addContactCard( $targetId, $cardData, $bizId);
            }
            $this->em->getConnection()->commit();
            $accountContactService->kafkaContactCard();
            return true;
        }catch(\Exception $e){
            $this->em->getConnection()->rollBack();
            throw $e;
            return false;
        }
        
    }
    /**
     * 企业后台修改名片池名片
     * @param string $bizId 企业ID
     * @param string $cardId 名片ID
     * @param string $targetId （共享客户）转移到 企业员工帐号ID
     * @param array $paramArr 名片池各个字段 (共享客户重新分配 无需传值)
     *  array(
            "picture" => $paramArr['picture'], //缩略图
            "vcard" => $paramArr['vcard'], //名片基本信息
            "cardres" =>  $paramArr['cardres'], //模板资源包
        )
     */
    public function modifyBizCardPool( $targetId = '', $cardId = '', $paramArr = array()){
        if( empty($targetId) || empty($cardId) || empty($paramArr) ){
            return false;
        }
        try{
            //修改员工个人名片夹数据
            $accountContactService = $this->container->get("account_contact_service");
            $contactCard = $accountContactService->findContactCardOneBy( array( 'uuid' => $cardId , "userId" =>$targetId) );
            if(empty($contactCard) || $contactCard->getStatus() == 'deleted')
            {
                return false;
            }
            if( !empty($paramArr['picture']) )
            {                
                $contactCard->setPicture($paramArr['picture']);
            }
            $currentDate = time();
            $contactCard->setLastModified($currentDate);

            $extend = $accountContactService->findContactCardExtendOneBy( array( 'uuid' => $cardId ));
            //企业员工修改个人信息
            if( !empty($paramArr['vcard']) ){            
                $extend->setVcard($paramArr['vcard']);
            }else{
                //是否更新名片拆分表数据 1不更新
                $accountContactService->updateVcardFilds = 1;
            }
            if( !empty($paramArr['cardres']) ){            
                $extend->getResPath($paramArr['cardres']);
            }
            $accountContactService->saveContactCard($contactCard,$extend);
            $accountContactService->syncCardAdd($targetId,$cardId,Codes::SYNC_MODIFY, $contactCard->getSelf(), '','false');
            return true;
        }catch(\Exception $e){
            throw $e;
            return false;
        }
    }
    /**
     * 删除员工名片
     * @param string $bizId 企业ID
     * @param string $targetId 员工账户ID
     */
    public function delBizCardPool( $bizId = '', $targetId = '' ){
        if( empty($bizId) || empty($targetId) ){
            return false;
        }
        try{
            $querysql = "SELECT id,card_id FROM `biz_card_pool` WHERE biz_id=:bizId AND user_id=:userId AND cardtype=:cardtype AND isdelete=0 LIMIT 1";
            $card = $this->em->getConnection()->executeQuery($querysql, array(
                        ":bizId" => $bizId,
                        ":userId" => $targetId,
                        ':cardtype' => 1
                    ))->fetch();
            if( empty($card) ){
                return false;
            }
            $sql = "UPDATE `biz_card_pool` SET isdelete=1 WHERE id=:id LIMIT 1" ;
            $this->em->getConnection()->executeQuery($sql, array(":id" => $card['id']));
            //删除员工名片
            $accountContactService = $this->container->get("account_contact_service");
            $status = 'deleted';
            $accountContactService->updateCardStatus( $targetId, $card['card_id'], $status);
            return true;
        }catch(\Exception $e){
            throw $e;
        }
    }
    /**
     * 添加企业员工
     * @param $params array() 字段
     */
    public function insertBizEmp($params)
    {
        $empValue = "('$empId','$name','$superior','$department','$title','$ename','$esuperior','$edepartment','$etitle','$mobile','$mobiles','$email','$emails','$phones','$faxs','$author_id','$pay_id','$role_id',$time,$enable,'$bizid',0,$auhorTime,1,'$user_id')";
        $sql = "INSERT INTO account_biz_employee (emp_id,name,superior,department,title,ename,esuperior,edepartment,etitle,mobile,mobiles,email,emails,phones,faxs,auhor_id,pay_id,role_id,created_time,enable,biz_id,modify_time,auhor_time,status,user_id) values {$empValue}";
        $this->getConnection()->executeQuery($sql);
        return TRUE;
    }
    /**
     * 判断部门是否存在
     * @param $group 部门
     * @param $titles 职位
     * @param $flag  1中文2英文
     */
    public function checkDepartInsertAll($groups,$titles,$empId,$bizid,$addid,$flag = 1)
    {
        $globalBase = $this->globalBase;
        foreach ($groups as $key => $depart) {
            $gTitle = $titles[$key];
            $time   = time();
            $checkDepart =$globalBase->findOneBy('AccountBizDepartment',array('name'=>$depart,'bizId'=>$bizid));
            $bizGroupMap = array(
                "employee_id"=>$empId,
                'isclosed'=>2, //默认是关闭的
                'isin'=>1,
                'created_time'=>$time,
            );
            $bizGroupTitle = array(
                'title' =>$gTitle,
                'bizid' =>$bizid,
                'addid' =>$addid,
                'time'  =>$time,
            );
            if (empty($checkDepart)) {
                $departData['group'] = array(
                    'name'=>$depart,
                    'time'=>$time,
                    'type'=>1,
                    'bizId'=>$bizid,
                    'status'=>1,   
                    'language'=>$flag
                );
                $departData['groupMap'] = $bizGroupMap;
                $departData['groupTit'] = $bizGroupTitle;
                $depRes = $this->insertBizDepart($departData,new AccountBizDepartment,new AccountBizGroupMap,new AccountBizGroupTitle);
                if (!empty($depRes)) {
                    $departId = $depRes['departid'];
                }else{
                    continue;
                }
            }else{
                $departId = $checkDepart->getDepartId();
                $bizGroupMap['departid']  = $departId;
                $bizGroupTitle['groupid'] = $departId;
                if (1 == $flag) {
                    $groupRes  = $this->insertBizGroupMap($bizGroupMap,new AccountBizGroupMap);
                }else{
                    $groupRes = TRUE;
                }
                
                $titleRes  = $this->insertBizGroupTitle($bizGroupTitle,new AccountBizGroupTitle);
                if (!$groupRes || !$titleRes) {
                    continue;
                }
            }     
        }
        return TRUE;
    }
    /**
     * 判断role_id、author_id、pay_id是否存在
     */
    public function checkIfEmpty($checkid,$obj,$flag,$bizid)
    {
        switch ($flag) {
            case '1':
                $checkid = explode(',', $checkid);
                foreach ($checkid as $key => $id) {
                    $checkRole = $this->globalBase->findOneBy($obj,array('rid'=>$checkid,'bizId'=>$bizid));
                    if (empty($checkRole)) {
                        return false;
                    }
                }
            break;
            case '2':
                $checkAuthor = $globalBase->findOneBy($obj,array('authorId'=>$checkid,'bizId'=>$bizid));
                if (empty($checkAuthor)) {
                    return false;
                }
                $residueNum = $checkAuthor->getResidueNum();
                return $residueNum;
                break;
            case '3':
                $checkPay   = $globalBase->findOneBy($obj,array('cumId'=>$checkid,'bizId'=>$bizid));
                if (empty($checkPay)) {
                    return false;
                }
                break;
            default:
                return false;
                break;
        }
        return TRUE;              
    }
    /**
     * 手机自动注册
     */
    public function auloadRegisterAccount($mobile)
    {
        //一：说明还没有注册，需要自动注册
        $accountBasicService = $this->container->get ( 'account_basic_service' );
        $passwd = rand(100000, 999999);
        $arr=array('mobile'=>$mobile,'passwd'=>$passwd,'mcode'=>86,'reg_type'=>1);
        //手机注册方法
        $regRes = $accountBasicService->regAccountBasicFast($arr);
        return $regRes;
    }
    /**
     * 邮箱注册
     */
    public function auloadRegisterEmail($email,$empId,$bizid)
    {
        $functionService = $this->container->get('function_service');
        if (!empty($email) && !$functionService->validateEmail($email)) {
            return false;
        }
        $bizObj = $this->globalBase->findOneBy('AccountBizDetail',array('bizId'=>$bizid));     
        $passwd  = rand(100000,999999);
        if (!empty($bizObj)) {
            $bizName    = $bizObj->getBizName();
        }else{
            return false;
        }            
        $data = array(
            'empid'=>$empId,
            'email'=>$email,
            'passwd'=>$passwd,
        );
        // 邮箱注册方法
        //企业员工邮箱登录添加

        $res  = $this->registeBizEmpLogin($data,new AccountBizEmployeeLogin);
        if (!empty($res)) {
            $body  = $bizName."已经添加您为该公司员工<br/>";
            $body .= "您的企业平台登录账号为：" . $email . " , 密码：" . $passwd."<br>";
            $body .= "请登录企业平台修改密码并激活。";
            // $this->sendMail ( $email, '企业平台账号', $body );
        }else{
            return false;
        }
        return TRUE;
    }
    /**
     * 添加企业员工
     */
    public function insertEmployee($data,$bizId)
    {
        if (empty($data)) {
            return FALSE;
        }
        $params = $this->checkIsset($data);
        $name      = $params['name'];        //名称
        $superior  = $params['superior'];    //上级
        $department= $params['department'];  //部门
        $title     = $params['title'];       //职位
        $ename     = $params['ename'];       //英文名称
        $esuperior = $params['esuperior'];   //英文上级
        $edepartment=$params['edepartment']; //英文部门
        $etitle    = $params['etitle'];      //英文职位
        $mobile    = $params['mobile'];      //手机
        $mobiles   = $params['mobiles'];     //多余手机
        $email     = $params['email'];       //邮箱
        $emails    = $params['emails'];      //多余邮箱
        $phones    = $params['phones'];      //电话
        $faxs      = $params['faxs'];        //传真
        $author_id = $params['authorid'];    //授权id
        $pay_id    = $params['payid'];       //支付id
        $role_id   = $params['roleid'];      //角色id
        $enable    = $params['enable'];      //是否使用平台
        // 如果不存在，跳出循环
        if ((empty($name) && empty($ename))  || (empty($title) && empty($etitle)) || empty($mobile) || empty($email)) {
            return FALSE;
        }
        if (empty($enable) || !in_array($enable,array(1,2))) {
            $enable = 2;
        }
        $random     = new RandomString();
        $empId      = $random->make(40);//员工id
        $time = time();                    
        $bizid = $bizId;
        $addid = $bizId;
        $groups = explode(',', $department);
        $titles = explode(',', $title);
        $egroups= explode(',', $edepartment);
        $etitles= explode(',', $etitle);
        if (count($groups) != count($titles)) {
            return FALSE;
        }
        // 检测role_id是否属于该企业并存在
        if (!empty($role_id)) {
            $res = $this->checkIfEmpty($role_id,'AccountBizAuthorizationRole',1,$bizid);
            if (!$res) {
                return FALSE;
            }
        }
        // 检测 author_id 是否属于该企业并检测授权剩余数量
        if (!empty($author_id)) {
            $res = $this->checkIfEmpty($auhor_id,'BizAuthorPackage',2,$bizid);
            if (false == $res) {
                return FALSE;
            }
            if (0 == $res) {
                $auhor_id = '';
            }
        }
        // 检测 pay_id 是否属于该企业
        if (!empty($pay_id)) {
            $res = $this->checkIfEmpty($pay_id,'BizConsumeRule',3,$bizid);
            if (!$res) {
                return FALSE;
            }
        }
        /**
         * 判断手机是否注册？否：注册并添加|是：查看是否已存在？是：取消|否：添加
         */
        $sqlMobile      = array('account'=>'86'.$mobile,'type'=>'mobile');
        $checkAccount   = $this->globalBase->findOneBy('AccountCommon',$sqlMobile);
        $sqlEmp         = array('mobile'=>$mobile);
        $checkEmp       = $this->globalBase->findOneBy('AccountBizEmployee',$sqlEmp);
        // 1、首先判断是否已经绑定到企业
        if (!empty($checkEmp)) {
            //由企业已经添加了每一个手机账号只能绑定到一个企业
            return FALSE;
        }
        // 2、判断是否注册->获取注册个人账号accountid
        if (!empty($checkAccount)) {
            $user_id = $checkAccount->getAccountId();
        }else{
            $res = $this->auloadRegisterAccount($mobile);
            if (false == $res) {
                return FALSE;
            }                        
            $user_id = $res['clientid'];
        }            
        $sqlEmpE       = array('email'=>$email);
        $checkEmpE     = $this->globalBase->findOneBy('AccountBizEmployee',$sqlEmpE);
        if (!empty($checkEmpE)) {
            return FALSE;
        }
        //4、判断是否注册
        $sqlEmail      = array('account'=>$email,'type'=>'email');
        $checkAccount  = $this->globalBase->findOneBy('AccountCommon',$sqlEmail);
        if (!empty($checkAccount)) {
            return FALSE;
        }else{
            //如果可以使用企业平台
            $bizName = '';
            if (1 == $enable) {
                // 二：自动注册邮箱
                //验证邮箱
                $res = $this->auloadRegisterEmail($email,$empId,$bizid);
                if (FALSE == $res) {
                    return FALSE;
                }
            }            
        }
        $auhorTime = empty($author_id)?0:$time;
        // 5、判断部门是否存在，不存在就添加
        if (!empty($groups) && is_array($groups)) {
            $this->checkDepartInsertAll($groups,$titles,$empId,$bizid,$addid,$flag = 1);
        }
        // 5.1、判断英文部门是否存在
        if (!empty($egroups) && is_array($egroups) ) {
            $this->checkDepartInsertAll($egroups,$etitles,$empId,$bizid,$addid,$flag = 2);
        }
        //6、如果有授权Id则授权剩余个数减一
        if (!empty($author_id)) {
            $finalNum   = intval($residueNum) - 1 <= 0?0:intval($residueNum) - 1;
            $authoridArr = array(
                "ResidueNum"=>$finalNum,
            );
            $this->globalBase->execute($authoridArr,new BizAuthorPackage());
        }
        // 6、添加企业员工到数据库
        $empValue = "('$empId','$name','$superior','$department','$title','$ename','$esuperior','$edepartment','$etitle','$mobile','$mobiles','$email','$emails','$phones','$faxs','$author_id','$pay_id','$role_id',$time,$enable,'$bizid',0,$auhorTime,1,'$user_id')";
        $sql = "INSERT INTO account_biz_employee (emp_id,name,superior,department,title,ename,esuperior,edepartment,etitle,mobile,mobiles,email,emails,phones,faxs,auhor_id,pay_id,role_id,created_time,enable,biz_id,modify_time,auhor_time,status,user_id) values {$empValue}";
        $this->getConnection()->executeQuery($sql);
        // 7、如果角色存在，添加到关联表,一个员工多个角色
        if (!empty($role_id)) {
            $this->insertOneEmpMoreRole($role_id,$empId);
        }
        //添加员工名片
        $this->handleBizCardPool($bizid,$user_id);
        // 运行gearman->work : type:epic
        $this->runEmpPicWork($empId);
        return TRUE;
    }
    /**
     * 运行gearman->client:job
     */
    public function runEmpPicWork($empId)
    {
        $workArr = array(
            "type" => 'epic',
            "id"   => $empId
        );
        $gearmanService = $this->container->get ( 'gearman_service');
        $gearmanService->push_job("Biz", $workArr);
        return TRUE;
    }

    public function getCompanyCustomer($company)
    {
        /**
        * 1、首先判断是否已经存储
        */     
        $res = $this->checkCustomerCompany($company);
            if (!empty($res)) {
            return $res;
        }
        /**
        * 2、如果存储就查表，没有存储调用第三方接口在存储
        */
        $res = $this->getCustomerConpany($company);
        return $res;
    }
    /**
     * 检测是否存储企业详情
     */
    public function checkCustomerCompany($company)
    {
        $res = array();
        if (empty($company)) return $res;

        $sql    = "SELECT id,content,due_time FROM biz_customer_company WHERE name=:name";
        $params = array(':name' => $company);
        $res    = $this->em->getConnection()->executeQuery($sql,$params)->fetch(); 
        if(!empty($res['due_time']) && $res['due_time'] < time())
            return false;
        return $res;
    }
    /**
     * 调用天眼
     */
    public function getCustomerConpany($company)
    {
        /**
         * 1、查找
         */
        $api_url = $this->container->getParameter('TYC_URL');
        $params  = array('name'=>$company);
        $request = new CurlService();
        $result  = $request->exec($api_url,$params);
        $res     = json_decode($result,TRUE);//json 解析
        $error   = $res['error_code'];
        if (0 != $error) {
          return array();
        }
        /**
         * 查看是否有被吊销
         */
        $api_url = $this->container->getParameter('TYCM_URL');//'http://api.tianyancha.com/services/v3/open/companyMortgage.json';
        $results  = $request->exec($api_url,$params);
        $ress     = json_decode($results,TRUE);//json 解析
        $error   = $ress['error_code'];
        if (0 != $error) {
            $companymortgage = array();
        }else{
            $companymortgage = isset($ress['result'])?$ress['result']:array();//   
        }
        $companymortgage = json_encode($companymortgage,JSON_UNESCAPED_UNICODE);//构成json
        $content = isset($res['result'])?$res['result']:array();//   
        $content = json_encode($content,JSON_UNESCAPED_UNICODE);//构成json
        $regnumber = isset($res['result']['baseInfo']['regNumber'])?$res['result']['baseInfo']['regNumber']:'';
        $legalperson = isset($res['result']['baseInfo']['legalPersonName'])?$res['result']['baseInfo']['legalPersonName']:'';
        $approvedtime = isset($res['result']['baseInfo']['approvedTime'])?date('Y-m-d',$res['result']['baseInfo']['approvedTime']/1000):'';
        $data    = array(
            "content"=>$content,
            "regnumber" => $regnumber,
          );
        /**
         * 2、入库
         */
        $md5_com= md5($company);
        $time   = time();
        //$due_time = time() + 365*24*3600;//过期时间为一年 
        $due_time = time() + 12*3600;//1;//12*3600;//暂时过期时间为12小时
        $sql = "select id,last_update_time from `biz_customer_company` WHERE name=:name ";
        //$query  = "DELETE from `biz_customer_company` WHERE name=:name ";
        $params = array(':name' => $company);
        //$this->em->getConnection()->executeUpdate($query,$params);
        $res = $this->em->getConnection()->executeQuery($sql,$params)->fetch();
        
        if(!empty($res)){
            $params = array(
                ':content' => $content,
                ':name' => $company,
                ':duetime' => $due_time,
                ':regnumber' => $regnumber,
                ':lastupdatetime' => $time,
                ':legalperson' => $legalperson,
                ':approvedtime' => $approvedtime,
                ':companymortgage' =>$companymortgage
                
                );
            $updatesql = "UPDATE `biz_customer_company` SET content=:content,name=:name,due_time=:duetime,regnumber=:regnumber,last_update_time=:lastupdatetime,legalperson=:legalperson,approved_time=:approvedtime,companymortgage=:companymortgage WHERE name=:name ";
            $this->em->getConnection()->executeUpdate($updatesql,$params);
            
        }else{
            try {
                $bizcustomercompany = new BizCustomerCompany();
                $bizcustomercompany->setContent($content);
                $bizcustomercompany->setCreatedTime($time);
                $bizcustomercompany->setName($company);
                $bizcustomercompany->setMd5Name($md5_com);
                $bizcustomercompany->setDueTime($due_time);
                $bizcustomercompany->setRegnumber($regnumber);
                $bizcustomercompany->setLastUpdateTime($time);
                $bizcustomercompany->setLegalperson($legalperson);
                $bizcustomercompany->setApprovedTime($approvedtime);
                $bizcustomercompany->setCompanymortgage($companymortgage);
                $this->em->persist($bizcustomercompany);
                $this->em->flush(); 
                $res['id'] = $bizcustomercompany->getId();
            }catch (\Exception $ex) {
                $this->em->rollback();
                throw $ex;
            }       
        }
        $sql = "insert into `biz_customer_company_log` (company_id,company_update_time) values (".$res['id'].",".$time.")";
        $this->em->getConnection()->executeQuery($sql,array());
        return $data;
    }
}