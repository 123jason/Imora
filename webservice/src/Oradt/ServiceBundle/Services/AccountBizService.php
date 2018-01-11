<?php

namespace Oradt\ServiceBundle\Services;

use Doctrine\ORM\EntityManager;
use Oradt\StoreBundle\Entity\BizCardGroup;
use Oradt\StoreBundle\Entity\AccountBizAuthorization;
use Oradt\StoreBundle\Entity\AccountBizEmployee;
use Oradt\StoreBundle\Entity\BizCustomerCompany;
use Oradt\StoreBundle\Entity\BizCustomerCompanyLog;
use Oradt\Utils\RandomString;
use Oradt\Utils\Password;
use Oradt\Utils\Codes;
use Oradt\Utils\Str2PY;
use Oradt\StoreBundle\Entity\AccountBizAuthorizationRole;
use Oradt\StoreBundle\Entity\AccountBizPushlog;
use Oradt\ServiceBundle\Services\CurlService;
/**
 * accountbiz service
 * @author huangxm <huangxm@oradt.com>
 * @date 2014-08-18
 */
class AccountBizService
{

    private $em;
    private $logger;
    private $container;
    private $request;

    /**
     * __construct
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager, $logger, $container)
    {
        $this->em = $entityManager;
        $this->logger = $logger;
        $this->container = $container;
        $this->request = $container->get('request');
    }
    /**
     * 拼接企业账号文件下载地址
     * @param string $path
     * @return string
     */
    public function getFileUrl($path){
        if (!empty($path)) {
            return $this->container->getParameter('HOST_URL') . '/accountbiz/file?path=' . substr($path, 18);
        }
        return "";
    }
    /**
     * 拼接企业新闻资源文件下载地址
     * @param string $path
     * @return string
     */
    public function getNewsFileUrl($path){
    	if (!empty($path)) {
    		return $this->container->getParameter('HOST_URL') . '/accountbiz/newsfile?path='.$path;
    	}
    	return "";
    }

    /**
     * 删除企业账户
     * @param type $bizId
     */
    public function deleteAccountBiz($bizId)
    {
        //获取数据映射
        $accountBizEntity = $this->em->getRepository('OradtStoreBundle:AccountBiz');
        //查询条件
        $criteria = array('bizId' => $bizId);
        //删除企业账户基本信息
        $accountBiz = $accountBizEntity->findOneBy($criteria);
        $accountBiz->setStatus('deleted');
        $this->em->persist($accountBiz);
        $this->em->flush();
    }

    /**
     * 删除企业账户运营人员
     * @param type $bizId
     */
    public function deleteBizOperator($bizId)
    {
        //获取数据映射
        $accountBizEntity = $this->em->getRepository('OradtStoreBundle:BizOperator');
        //查询条件
        $criteria = array('bizId' => $bizId);
        //删除企业账户基本信息
        $accountBiz = $accountBizEntity->findOneBy($criteria);
        $accountBiz->setStatus('deleted');
        $this->em->persist($accountBiz);
        $this->em->flush();
    }

    /**
     * 删除图片,重新设置新的图片地址
     * @param type $data
     * @param type $criteria
     * @param type $tableName
     */
    public function file($data, $criteria, $tableName)
    {
        //获取数据映射
        $accountBizEntity = $this->em->getRepository('OradtStoreBundle:' . $tableName);
        //删除企业账户基本信息
        $entity = $accountBizEntity->findOneBy($criteria);
        if (!empty($entity)) {
            $docroot = $this->container->getParameter('DOC_ROOT');
            if (!empty($data['LogoPath'])) {
                $logoPath = $docroot . $entity->getLogoPath();
                if (is_file($logoPath) && file_exists($logoPath)) {
                    unlink($logoPath);
                }
                $entity->setLogoPath($data['LogoPath']);
            }
            if (!empty($data['IdcardCopyPath'])) {
                $idcardCopyPath = $docroot . $entity->getIdcardCopyPath();
                if (is_file($idcardCopyPath) && file_exists($idcardCopyPath)) {
                    unlink($idcardCopyPath);
                }
                $entity->setIdcardCopyPath($data['IdcardCopyPath']);
            }
            if (!empty($data['AuthorityCopyPath'])) {
                $authorityCopyPath = $docroot . $entity->getAuthorityCopyPath();
                if (is_file($authorityCopyPath) && file_exists($authorityCopyPath)) {
                    unlink($authorityCopyPath);
                }
                $entity->setAuthorityCopyPath($data['AuthorityCopyPath']);
            }
            if (!empty($data['LicenseCopyPath'])) {
                $licenseCopyPath = $docroot . $entity->getLicenseCopyPath();
                if (is_file($licenseCopyPath) && file_exists($licenseCopyPath)) {
                    unlink($licenseCopyPath);
                }
                $entity->setLicenseCopyPath($data['LicenseCopyPath']);
            }
            if (!empty($data['CodeCopyPath'])) {
                $codeCopyPath = $docroot . $entity->getCodeCopyPath();
                if (is_file($codeCopyPath) && file_exists($codeCopyPath)) {
                    unlink($codeCopyPath);
                }
                $entity->setCodeCopyPath($data['CodeCopyPath']);
            }
            if (!empty($data['LegalidcardCopyPath'])) {
                $legalidcardCopyPath = $docroot . $entity->getLegalidcardCopyPath();
                if (is_file($legalidcardCopyPath) && file_exists($legalidcardCopyPath)) {
                    unlink($legalidcardCopyPath);
                }
                $entity->setLegalidcardCopyPath($data['LegalidcardCopyPath']);
            }
            $this->em->persist($entity);
            $this->em->flush();
            return true;
        }
    }

    /**
     * 初始化企业名片分组
     */
    public function initBizGroup($bizId, $groupId)
    {
        $entity = new BizCardGroup();
        $entity->setBizId($bizId);
        $entity->setGroupId($groupId);
        $entity->setGroupName(Codes::DEFAULT_GROUP);
        //$entity->setParentId(0);
        $entity->setSorting(0);
        $this->em->persist($entity);
        $this->em->flush();
    }

    public function hasRole(array $data = array()) {
        if(empty($data))
            return true;
        $role = $this->em->getRepository("OradtStoreBundle:AccountBizAuthorizationRole")->findOneBy($data);
        if(empty($role))
            return false;
        return true;
    }

    public function getRoleOne(array $data = array()) {
        if(empty($data))
            return false;
        $role = $this->em->getRepository("OradtStoreBundle:AccountBizAuthorizationRole")->findOneBy($data);
        if(empty($role))
            return false;
        return $role;
    }
    
    /**
     * check biz account authorization
     * @param string $bizid bizaccountid
     * @param string $accountid basic userid
     * @return boolean
     */
    public function hasBizManager($bizid,$accountid,$modle='hr') {
        //
        //echo $accountid;
        $sql = "SELECT roleid,b.`permission` FROM `account_biz_authorization` AS a 
                INNER JOIN `account_biz_authorization_role` AS b ON a.`roleid`=b.`id` WHERE 
                a.`accountid`=:accountid AND a.biz_id=:bizid LIMIT 1";
        $role = $this->em->getConnection()->executeQuery($sql ,
                 array(':accountid' => $accountid, ':bizid' => $bizid))->fetch();
        if(empty($role))
        {
            return false;
        }
        $p = json_decode($role['permission'],true);        
        if(!empty($p) && isset($p[$modle]))
            return true;        
        return false;
       // return $this->hasAuthorIzation();
    }

    /**
     * checkout authorization data exists
     * @param array $data
     * @return boolean
     */
    public function hasAuthorIzation(array $data = array()) {
        if(empty($data))
            return false;
        $authorization = $this->em->getRepository("OradtStoreBundle:AccountBizAuthorization")->findOneBy($data);
        if(empty($authorization))
            return false;
        return true;
    }
    
    public function getAuthorIzation(array $data = array()) {
        if(empty($data))
            return false;
        $authorization = $this->em->getRepository("OradtStoreBundle:AccountBizAuthorization")->findOneBy($data);
        if(empty($authorization))
            return false;
        return $authorization;
    }
    
    
    /**
     * 获取某个企业下的角色 [2015-07-06] by xuejiao
     * @param string $bizId 企业ID
     * return array('管理员'=>120084,'员工'=>345960);
     */
    public function getRoleArrByBizId($bizId){
        if(empty($bizId)) return false;
        $sql    = "SELECT id,name FROM account_biz_authorization_role WHERE biz_id=:biz_id";
        $params = array(':biz_id' => $bizId);        
        $role   = $this->em->getConnection()->executeQuery($sql,$params)->fetchAll();
        $roleArr= array();
        if(!empty($role)){
            foreach ($role AS $row){
                $roleArr[$row['name']] = $row['id'];
            }
        }
        return $roleArr;
    }
    
    /**
     * 导入账户
     * @param string $bizId             企业ID
     * @param array  $data              导入数组 
     * @param string $data['name']      姓名
     * @param string $data['username']  用户名（手机号）
     * @param string $data['email']     邮箱
     * @param string $data['mobile']    电话
     * @param string $data['title']     职位
     * @param string $data['joindate']  注册日期（提供）
     * @param string $data['role']      角色
     * @param string $accountid  企业员工账号ID (basic的账户ID)
     * @param string $status     1:新导入  2：正常状态 默认为1
     * return boolen
     */
    public function accountBizImport($bizId,$data=array(),$datetime,$joindate,$accountid='',$status = 1){
        if(empty($bizId) || empty($data)) return FALSE;
            $roleArr = $this->getRoleArrByBizId($bizId);    
            $AccountBizImport =$this->getAuthorIzation(array('bizId' => $bizId, 'account' => $data['username']));
        if(empty($AccountBizImport)){//如果为空，新建鉴权
            $AccountBizImport = new AccountBizAuthorization();
            $AccountBizImport->setBizId($bizId);
            $AccountBizImport->setAccountid($accountid);
            $AccountBizImport->setCreatedTime($datetime);
            $AccountBizImport->setAccount($data['username']);
            $AccountBizImport->setRemark('');
            $AccountBizImport->setStatus($status);
            $AccountBizImport->setIssend(1);
        }
      $name='';
      if(!empty($data['name']))
      	$name=$data['name'];
        $AccountBizImport->setRealname($name);
        $strpy = new Str2PY();
        $prespell = $strpy->getPre($name);
        if(empty($prespell)){
        	$prespell='#';
        }
        $AccountBizImport->setPrespell($prespell);
        $AccountBizImport->setJoindate($joindate);
        $AccountBizImport->setMobile($data['mobile']);
        //$AccountBizImport->setMobile($data['mobile']);
        $AccountBizImport->setTempid(0);
        $AccountBizImport->setEmail($data['email']);
        $AccountBizImport->setTitle($data['title']);
        if(!empty($roleArr) && !empty($data['role'])){
            if(isset($roleArr[$data['role']]) && !empty($roleArr[$data['role']])){
                $AccountBizImport->setRoleid($roleArr[$data['role']]);
            }else{
                $AccountBizImport->setRoleid(0);
            }
        }else{
            $AccountBizImport->setRoleid(0);
        }
        $this->em->persist ( $AccountBizImport );
        $this->em->flush ();
        return TRUE;
    }
    
    /**
     * 公众号推送消息日志记录
     * @param string  $bizId    企业ID
     * @param array   $content  推送内容
     * @param string  $numId    公众号ID
     * @param string  $sendtype  发送对象  1：全部  2：某个组 3：某个人
     * @param string  $type      发送类型  1：文本  2：文章【图文】 3：名片
     * @param array   $jsonparam 推送内容接收的条件
     */
    public function insertBizPushLog($bizId,$content,$numId,$jsonparam='',$sendtype=1,$type=1){
        if(empty($bizId) || empty($content) || empty($numId)){
            return FALSE;
        }
        if(!empty($jsonparam)){
            $jsonparam = json_encode($jsonparam);  //转换为数组
        }
        $content   = json_encode($content);
                
        $pushLog = new AccountBizPushlog();
        $pushLog->setBizId($bizId);
        $pushLog->setContent($content);
        $pushLog->setCreatedTime(time());
        $pushLog->setNumId($numId);
        $pushLog->setType($type);
        $pushLog->setSendtype($sendtype);
        $pushLog->setJsonparam($jsonparam);
        $pushLog->setStatus(1);         //发送状态  1：未发送  2：已发送
        $this->em->persist($pushLog);
        $this->em->flush();
        return $pushLog->getId();
    }
    
    /**
     * 根据企业公众号日志ID 更正发送状态
     * @param string $logId  日志ID
     */
    public function updateBizPushLog($logId){
        if(empty($logId))      return  FALSE;
        $query  = "UPDATE account_biz_pushlog SET status=2  WHERE id=:id ";
        $params = array(':id' => $logId);        
        $res    = $this->em->getConnection()->executeUpdate($query,$params);
        return $res;
    }
    /**
     * 获得企业扫描仪数量
     */
    public function getScaner()
    {      
      $arr = array('scannerid','vcardid','accountid');
      $newRes = array();
      foreach ($arr as $key => $value) {
        $sql = "SELECT a.bizid,COUNT(a.bizid) as num from (SELECT * FROM scan_bmiddle_scanner GROUP BY bizid,".$value.") as a GROUP BY a.bizid";
        $res = $this->em->getConnection()->executeQuery($sql)->fetchAll();
        $newRes[$value]=$res;
      }
      return $newRes;
    }
    /**
     * 自动添加员工邮箱账号
     */
    public function registeBizEmployee($data,$bizObj,$detailObj,$infoObj)
    {
      // $functionService = $this->container->get('function_service');           //获取service
      $globalBase = $this->container->get('global_base');
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
      // $functionService = $this->container->get('function_service');           //获取service
      $globalBase = $this->container->get('global_base');
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
      $globalBase = $this->container->get('global_base');
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
      $globalBase = $this->container->get('global_base');
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
      $globalBase = $this->container->get('global_base');
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
     * 添多个员工
     */
    public function InsertBizGroupMaps($data)
    {
      $groupid = $data['groupid'];
      $empids  = $data['empids'];
      $empjson = $data['empjson'];      
      if(!empty($empjson)){
        // $empids = explode(',', $empids);
        if(count($empjson) >= 1){
            $createtime = $data['ctime'];
            $values = '';
            $sql = "delete from `account_biz_group_map` where group_id =:groupid";
            $this->em->getConnection()->executeQuery($sql,array(':groupid'=>$groupid));
            foreach ($empjson as $eids){
                $values .="('{$eids['empid']}','".$groupid."',".$createtime.",'{$eids['isclosed']}','1'),";
            }
            $values = rtrim($values,",");
            $insertsql = "insert into `account_biz_group_map` (employee_id,group_id,created_time,isclosed,isin) values {$values}";               
            $this->em->getConnection()->executeQuery($insertsql,array());
        }
      }
      return true;
    }
    /**
     * 添加角色权限员工控制
     */
    public function addRoleEmployee($roleid,$employeeids,$flag = '')
    {
      if (empty($roleid)) {
        return false;
      }else{
        if(!empty($employeeids)){
          if(count($employeeids) >= 1){
            $values = '';
            $sql = "delete from `account_role_map` where roleid =:id";
            $this->em->getConnection()->executeQuery($sql,array(':id'=>$roleid));
            foreach ($employeeids as $v){
                $values .="('{$v}','".$roleid."',1),";

            }
            $values = rtrim($values,",");
            $insertsql = "insert into `account_role_map` (employeeid,roleid,status) values {$values}"; 
            $this->em->getConnection()->executeQuery($insertsql,array());
          }
        }else{
          if ('del' == $flag) {
            $sql = "delete from `account_role_map` where roleid =:id";
            $this->em->getConnection()->executeQuery($sql,array(':id'=>$roleid));
          }
        }
      }
    }
    /**
     * 修改员工信息里的author_id字段
     * @param $flag 'add' 添加，'del' 删除。
     */
    public function editEmpAuthorId($empid,$roleid,$flag = 'add')
    {
      $globalBase = $this->container->get('global_base');
      $AccountBizEmployee = new AccountBizEmployee();
      // 往员工信息添加
      foreach ($empid as $eid) {
          $eObj = $globalBase->findOneBy('AccountBizEmployee',array('empId'=>$eid));
          if (empty($eObj)) {
            continue;
          }else{
            // 添加
            $oldAuthorId = $eObj->getAuhorId();
            if ('add' == $flag) {
              if ('' == $oldAuthorId) {
                $newAuthorId = $roleid;
              }else{
                $newAuthorId = $oldAuthorId.','.$roleid;
              }
            }else{
              // 删除
              if ($oldAuthorId == $roleid || '' == $oldAuthorId) {
                $newAuthorId = '';
              }else{
                $roleArr = array($roleid);
                $oldArr  = explode(',', $oldAuthorId);
                $diff    = array_diff($oldArr, $roleArr);
                $newAuthorId = implode(',', $diff);
              }
            }
          }
          if (!empty($newAuthorId)) {
            $empArr = array(
              'AuhorId'=>$newAuthorId,
              'Empid'  =>$eid,
            );
            $res = $globalBase->execute($empArr,$AccountBizEmployee);
            if (!$res) {
              continue;
            }
          }
      }
      return TRUE;
    }
    /**
     * 清除员工里的角色信息
     */
    public function delEmpAuthorId($rid)
    {
      $globalBase = $this->container->get('global_base');
      $AccountBizEmployee = new AccountBizEmployee();
      $res = $this->getRoleEmpBy($rid);
      if (!empty($res)) {
        foreach ($res as $empid) {
          $eObj = $globalBase->findOneBy('AccountBizEmployee',array('empId'=>$eid));
          if (empty($eObj)) {
            continue;
          }else{
            $oldAuthorId = $eObj->getAuhorId();
            $roleArr = array($rid);
            $oldArr  = explode(',', $oldAuthorId);
            $diff    = array_diff($oldArr, $roleArr); //取差集
            $newAuthorId = implode(',', $diff);
            $empArr = array(
              'AuhorId'=>$newAuthorId,
              'Empid'  =>$eid,
            );
            $res = $globalBase->execute($empArr,$AccountBizEmployee);
          }
        }
      }
      return TRUE;
    }
    /**
     * 获取角色里的员工
     */
    public function getRoleEmpBy($roleid)
    {
      $res = '';
      if (!empty($roleid)) {
        $sql = "SELECT employeeid  FROM `account_role_map` where roleid =:id";
        $res = $this->em->getConnection()->executeQuery($sql,array(':id'=>$roleid))->fetchAll();
      }
      if (empty($res)) {
        return false;
      }
      return $res;
    }
    /**
     * 企业认证log
     */
    public function insertIdentLog($data,$logObj)
    {
      $globalBase = $this->container->get('global_base');
      if (empty($data)) {
        return false;
      }
      $logArr = array(
        'BizId'=>$data['bizid'],
        'Type' =>$data['type'],
        'CreatedTime'=>$data['ctime'],
        'Content'=>$data['content']
        );
      $res = $globalBase->execute($logArr,$logObj);
      if ($res) {
        return true;
      }else{
        return false;
      }
    }
    /**
     * 解除员工权限
     */
    public function removeRoleEmpMap($empid)
    {
      if(empty($logId))      return  FALSE;
        $query  = "DELETE from `account_role_map` WHERE employeeid=:empid ";
        $params = array(':empid' => $empid);        
        $res    = $this->em->getConnection()->executeUpdate($query,$params);
        return $res;
    }
    /**
     * 检验消费规则是否有员工
     */
    public function checkConsumeHasEmp($cumid)
    {
      $res = array();
      if (!empty($cumid)) {
        $sql    = "SELECT id,name FROM account_biz_employee WHERE pay_id=:cumid AND status = 1";
        $params = array(':cumid' => $cumid);
        $res    = $this->em->getConnection()->executeQuery($sql,$params)->fetchAll();        
      }
      return $res;
    }
}