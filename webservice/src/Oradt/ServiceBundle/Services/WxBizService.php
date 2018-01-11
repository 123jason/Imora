<?php
/**
 * @var wxbiz_service
 */
namespace Oradt\ServiceBundle\Services;

use Doctrine\ORM\EntityManager;
use Oradt\Utils\Errors;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Oradt\StoreBundle\Entity\SecurityQuestionVerification;
use Oradt\Utils\Codes;
use Oradt\Utils\Tables;
use Oradt\Utils\Password;
use Oradt\Utils\RedisTrait;
use Oradt\Utils\RandomString;
use Oradt\StoreBundle\Entity\AccountTagmap;
use Oradt\StoreBundle\Entity\WxBizEmployee;
use Oradt\StoreBundle\Entity\WxBizDepartment;
use Oradt\StoreBundle\Entity\WxBizCard;
use Oradt\StoreBundle\Entity\UserCommon;
use Oradt\Utils\Str2PY;
use Doctrine\Common\Cache\FilesystemCache;

class WxBizService extends BaseService 
{
    public function __construct(EntityManager $entityManager, ContainerInterface $container) {
        parent::__construct($container);
    } 
    /**
     * @param  string  $user  登陆账号
     * @param  integer $flag  1手机2邮箱
     * @param  string  $params 其他参数
     * @return array
     */
    public function checkUserIfExist($user,$flag = 1,$params='86')
    {   
        $where = ' enable <> 3 ';
        if (1 == $flag) {
            $where .= ' AND mobile =:mobile AND code=:mcode ';
            $params = array(':mobile' => $user,':mcode'=>$params);
        }else if(2 == $flag){
            $where .= ' AND email =:email '; 
            $params = array(':email' => $user);
        }else if (3 == $flag) {
            $where .= ' AND id = :id AND biz_id = :bizid ';
            $params = array(':id' => $user,':bizid'=>$params);
        }else{
            return array();
        }
        $sql    = "SELECT * FROM " . Tables::TBWXBIZEMPLOYEE . " WHERE ".$where;
        $res    = $this->em->getConnection()->executeQuery($sql,$params)->fetch(); 
        return $res;
    }

    
    /**
     * 检测账户是否存在
     */
    public function checkAccountCommon($account, $type = ""){
        $this->em = $this->getManager();
        $sql        = "SELECT account_no,mobile,wechat_id,union_id,email FROM " . Tables::TBUSERCOMMON . " WHERE ";
        $findArray  = array();
        switch ($type){
            case "mobile":
                $sql .= "  mobile=:mobile";
                $findArray  = array(':mobile'=> $account);
                break;
            case "wechat":
                $sql .= "  union_id=:union_id";
                $findArray  = array(':union_id'=> $account);
                break;
            case "email":
                $sql .= "  email=:email";
                $findArray  = array(':email'=> $account);
                break;
        }
        $res       = $this->em->getConnection()->executeQuery($sql,$findArray)->fetch();
        return $res;
    }
    /**
     * @todo 将新注册的员工添加到搜索common表
     * @var 2017-9-18
     * @return boolean 
     */
    public function insertIntoCommon($type,$emp_Id,$account,$createTime)
    {
        if (empty($type)) {
            $type = 'mobile';
        }
    
        $params=array();
        switch ($type) {
            case 'mobile': 
                $find_arr["mobile"]=$account["mobile"]; 
                $user_common =  $this->em->getRepository('OradtStoreBundle:UserCommon')->findOneBy($find_arr);
                if(empty($user_common)){
                    $account_no=RandomString::make(32, Codes::A);
                    $params[":account_no"]=$account_no;
                    $params[':mobile']=$account["mobile"];
                    $params[':password']=isset($account["password"])?$account["password"]:"";
                    $params[':username']=isset($account["username"])?$account["username"]:"";
                    $params[":create_time"]=$createTime; 
                    $sql = "INSERT INTO `" . Tables::TBUSERCOMMON . "`(account_no, mobile,password,username,create_time)
                        VALUES( :account_no, :mobile, :password,:username,:create_time )";
                    $res=$this->getConnection()->executeQuery( $sql, $params );
                   
                    //员工绑定账号
                    if(!empty($emp_Id)){
                        $params_update[":account_no"]=$params[":account_no"];
                        $params_update[":emp_id"]=$emp_Id;
                        $sql_update = "UPDATE " . Tables::TBWXBIZEMPLOYEE . " SET account_no = :account_no WHERE id=:emp_id";

                        $this->em->getConnection()->executeQuery($sql_update,$params_update);
                    }
                    return  $account_no;
                }else{
                    if(!empty($emp_Id)){
                        $account_no=$user_common->getAccountNo();
                        $params_update[":account_no"]=$account_no;
                        $params_update[":emp_id"]=$emp_Id;
                        $sql_update = "UPDATE " . Tables::TBWXBIZEMPLOYEE . " SET account_no = :account_no WHERE id=:emp_id";
                        $this->em->getConnection()->executeQuery($sql_update,$params_update);
                        return  $account_no;
                    }
                    return  false;
                }
                break;
            case 'wechat': 
                $find_arr["mobile"]=$account["mobile"]; 
                $user_common =  $this->em->getRepository('OradtStoreBundle:UserCommon')->findOneBy($find_arr);
                if(empty($user_common)){
                    $account_no=RandomString::make(32, Codes::A);
                    $params[":account_no"]=$account_no;
                    $params[':mobile']=$account["mobile"]; 
                    $params[':unionid']=$account["unionid"];
                    $params[':wechatid']=$account["wechatid"];
                    $params[":create_time"]=$createTime; 
                    $sql = "INSERT INTO `" . Tables::TBUSERCOMMON . "`(account_no, mobile,wechat_id,union_id,create_time)
                        VALUES( :account_no, :mobile, :wechatid,:unionid,:create_time )";
                    $res=$this->getConnection()->executeQuery( $sql, $params );
                    
                    //员工绑定账号
                    if(!empty($emp_Id)){
                        $params_update[":account_no"]=$params[":account_no"];
                        $params_update[":emp_id"]=$emp_Id;
                        $sql_update = "UPDATE " . Tables::TBWXBIZEMPLOYEE . " SET account_no = :account_no WHERE id=:emp_id";
                        $this->em->getConnection()->executeQuery($sql_update,$params_update);
                    }
                    return  $account_no;
                }else{ 
                    $account_no=$user_common->getAccountNo();
                    $params[":account_no"]=$account_no;
                    $params[':unionid']=$account["unionid"];
                    $params[':wechatid']=$account["wechatid"];
                    $sql_update = "UPDATE " . Tables::TBUSERCOMMON . " SET wechat_id = :wechatid,union_id=:unionid WHERE account_no=:account_no";
                    $this->em->getConnection()->executeQuery($sql_update,$params);
                    return  $account_no;
                }
                break;
         } 
        
       
         
    }
    /*
    * 查询企业名片
    * */
    public function findBizCardOneBy($findArray) {
        $result = $this->em->getRepository ( "OradtStoreBundle:WxBizCard")->findOneBy ( $findArray );
        return $result;
    }
    /**
     * @todo  验证部门是否存在
     */
    public function checkDepartByBizAndName($bizid,$depart)
    {
        $sql    = "SELECT id FROM " . Tables::TBWXBIZDEPARTMENT . " WHERE name =:name AND biz_id = :bizid and is_del=0";
        $params = array(':name' => $depart,'bizid' => $bizid);
        $res    = $this->em->getConnection()->executeQuery($sql,$params)->fetch();
        return $res;
    }
    /**
     * @todo  验证父级部门是否存在
     */
    public function checkDepartByParentid($bizid,$id)
    {
        $sql    = "SELECT id FROM " . Tables::TBWXBIZDEPARTMENT . " WHERE id =:id AND biz_id = :bizid and is_del=0";
        $params = array(':id' => $id,'bizid' => $bizid);
        $res    = $this->em->getConnection()->executeQuery($sql,$params)->fetch();
        return $res;
    }
    /**
     * @todo 添加部门
     */
    public function  insertIntoDepartment($params){
       $this->em->getConnection()->beginTransaction(); //开启事物
        try {
            if(empty($params['parentid']))
                $params['parentid']=0;
            if(empty($params['ename']))
                $params['ename']="";
            if(empty($params['status']))
                $params['status']=1;
            $createTime = $this->getTimestamp();
            // 添加 信息
            $wxBizDepart  = new WxBizDepartment();
            $wxBizDepart->setBizId($params['bizId'] );
            $wxBizDepart->setParentId(intval($params['parentid']));
            $wxBizDepart->setName($params['name'] );
            $wxBizDepart->setCreatedTime($createTime);
            $wxBizDepart->setModifyTime(0);
            $wxBizDepart->setEname($params['ename'] );
            $wxBizDepart->setStatus($params['status'] );
            $wxBizDepart->setAddId($params['addid'] );
            $wxBizDepart->setIsDel(0);
            $this->em->persist($wxBizDepart);
            $this->em->flush();
            $this->em->getConnection()->commit();
            $departid = $wxBizDepart->getId();
            $returnArr = array( 'departid'=>$departid);          //返回数组
            return $returnArr;
        } catch (\Exception $ex) {
            $this->em->getConnection()->rollback();
            throw $ex;
        }
    }


    /**
     * @todo  根据ID查询企业信息
     */
    public function getBizInfoByID($id)
    {
        $sql    = "SELECT * FROM " . Tables::TBWXBIZ . " WHERE id =:id";
        $params = array(':id' => $id);
        $res    = $this->em->getConnection()->executeQuery($sql,$params)->fetch();

        return $res;
    }
    /**
     * @todo 根据企业部门ID检验员工是否存在
     */
    public function getEmpsByDepartId($bizid,$departid)
    {
        $sql    = "SELECT * FROM " . Tables::TBWXBIZEMPLOYEE . " WHERE department =:departid AND biz_id = :bizid and is_del=0";
        $params = array(':departid' => $departid,':bizid'=>$bizid);
        $res    = $this->em->getConnection()->executeQuery($sql,$params)->fetch();
        return $res;
    }

    /**
     * 根据员工ID查询员工详情
     * @param $id
     */
    public function getEmpById($id) {
        $sql    = "SELECT * FROM " . Tables::TBWXBIZEMPLOYEE . " WHERE id =:id";
        $params = array(':id'=>$id);
        $res    = $this->em->getConnection()->executeQuery($sql,$params)->fetch();
        return $res;
    }

    /**
     * 根据部门ID查询部门详情
     * @param $id
     */
    public function getDepartById($id) {
        $sql    = "SELECT * FROM " . Tables::TBWXBIZDEPARTMENT . " WHERE id =:id";
        $params = array(':id' => $id);
        $res    = $this->em->getConnection()->executeQuery($sql,$params)->fetch();
        return $res;
    }

    /**
     * 更新名片表状态
     * @param $id
     * @param $status active使用 inactive 回收站 deleted 管理员删除
     */
    public function changeCardStatus($id, $status) {
        $updateCardSql = "UPDATE " . Tables::TBWXBIZCARD . " SET status=:status WHERE find_in_set(id, :id)";
        $this->em->getConnection()->executeQuery($updateCardSql, array(':status' => $status, ':id' => $id));
    }

    /**
     * 恢复名片为正常状态名片
     * @param $id
     */
    public function delRecycleCard($id) {
        $deleteCardSql = "DELETE FROM  " . Tables::TBWXBIZCARDRECYCLE . " WHERE find_in_set(id, :id)";
        $this->em->getConnection()->executeQuery($deleteCardSql, array(':id' => $id));
    }

    /**
     * 彻底删除名片
     * @param $id
     * @param string $userid
     */
    public function completeDelRecycleCard($id, $userid='') {
        $deletSql = "UPDATE " . Tables::TBWXBIZCARDRECYCLE . " SET status=1,del_user=:deluser WHERE find_in_set(id, :id)";
        $this->em->getConnection()->executeQuery($deletSql, array(':id' => $id, ':deluser' => $userid));
    }

    /*
    * 根据ID获取回收站信息
    * */
    public function getRecycleInfoById($id){
        $sql    = "SELECT * FROM " . Tables::TBWXBIZCARDRECYCLE . " WHERE find_in_set(id, :id)";
        $params = array(':id' => $id);
        $res    = $this->em->getConnection()->executeQuery($sql,$params)->fetchAll();
        return $res;
    }

    /*
    * 获取回收站信息，多条查询
    * */
    public function getRecycleInfo($uuids, $userid){
        $sql    = "SELECT * FROM " . Tables::TBWXBIZCARDRECYCLE . " WHERE user_id=:userid AND find_in_set(card_id, :uuid)";
        $params = array(':userid' => $userid, ':uuid' => $uuids);
        $res    = $this->em->getConnection()->executeQuery($sql,$params)->fetchAll();
        return $res;
    }

    /*
    * 获取sahre表信息
    * */
    public function getCardShareInfoByOne($uuid){
        $sql    = "SELECT * FROM " . Tables::TBWXBIZCARDSHARE . " WHERE card_id=:uuid  limit 1";
        $params = array(':uuid' => $uuid);
        $res    = $this->em->getConnection()->executeQuery($sql,$params)->fetch();
        return $res;
    }


    /**
     * @todo  封装添加员工方法
     * @param array $params
     * @param $param[mobile]  手机号   true
     * @param $param[bizid]   企业ID   true
     * @param $param[from & password]   2 = from(自己注册时候)password true
     * @return 1 参数不够
     * @return 2 手机已注册
     * @version 0.0.1 2017-9-20
     * @author xinggm <[<xinggm@oradt.com>]>
     */
    public function insertIntoEmployee($params)
    {
        // 1、判断参数是否都有
        if (!isset($params['bizid']) || empty($params['bizid']) || !isset($params['mobile']) || empty($params['mobile'])) {
            return 1;
        }

        if (!isset($params['code']) || empty($params['code']))
            $params['code'] = '86';

        if (!isset($params['type']) || empty($params['type']) || !in_array($params['type'], array(1,2)) ) {
            $params['type'] = 1;
        }
        // 2、判断手机是否已注册
        if (1 == $params['type']) {
            $res          = $this->checkUserIfExist($params['mobile'] , 1, $params['code']);
            if (!empty($res)) {
                return 2;
            }
        }else{
            $res          = $this->checkUserIfExist($params['email'],2 );//邮箱是否存在
            if (!empty($res)) {
                return 110012;
            }
        }
        $userId = '';
        if (isset($params['userid'])) {
            $userId = $params['userid'];
            unset($params['userid']);
        }

        /**
         * @todo 验证参数
         */
        if (!isset($params['enable']) || empty($params['enable']) || !in_array($params['enable'], array(1,2,4)))
            $params['enable'] = 1;//1正常2、待认证 3、离职
        if (!isset($params['import']) || empty($params['import']) || !in_array($params['import'], array(1,2)))
            $params['import'] = 2;
        if (!isset($params['from']) || empty($params['from']) || !in_array($params['from'], array(1,2)))
            $params['from']   = 2;
        if (!isset($params['roleid']) || empty($params['roleid']) || !in_array($params['roleid'], array(1,2,3)))
            $params['roleid'] = 3;
        if (!isset($params['identstatus']) || empty($params['identstatus']) || !in_array($params['identstatus'], array(1,2)))
            $params['identstatus'] = 2;
        if (!isset($params['password'])) {
            $params['password'] = '';
        }
        if (!isset($params['email'])) {
            $params['email'] = '';
        }
        if (!isset($params['name'])) {
            $params['name'] = '';
        }
        if (!isset($params['superior'])) {
            $params['superior'] = 0;
        }
        if (!isset($params['depart'])) {
            $params['depart']   = 0;
        }
        if (!isset($params['openid'])) {
            $params['openid']   = '';
        }
        if (!isset($params['unionid'])) {
            $params['unionid']  = '';
        }
        $this->em->getConnection()->beginTransaction(); //开启事物
        try {
            $createTime = $this->getTimestamp();
            // 添加员工登录信息
            if (!empty($params['password']))
                $params['password']  = Password::encrypt($params['password']);

            //判断员工是否在企业
            $wxBizEmp =  $this->em->getRepository('OradtStoreBundle:WxBizEmployee')->findOneBy(  array('mobile'=>$params['mobile'],'bizId'=>$params['bizid']));
            if(empty($wxBizEmp)){
                $wxBizEmp  = new WxBizEmployee();
            }
            $wxBizEmp->setBizId($params['bizid']);
            $wxBizEmp->setCode($params['code'] );
            $wxBizEmp->setMobile($params['mobile'] );
            $wxBizEmp->setPasswd($params['password']);
            $wxBizEmp->setEmail($params['email']);
            $wxBizEmp->setName($params['name']);
            $wxBizEmp->setSuperior( intval($params['superior']) );
            $wxBizEmp->setDepartment(intval($params['depart']) );
            $wxBizEmp->setCreatedTime($createTime);
            $wxBizEmp->setModifyTime(0);
            $wxBizEmp->setEnable($params['enable']);
            $wxBizEmp->setOpenId($params['openid']);
            $wxBizEmp->setUnionId($params['unionid']);
            $wxBizEmp->setRoleId($params['roleid']);
            $wxBizEmp->setImportStatus($params['import']);
            $wxBizEmp->setReFrom($params['from']);
            $wxBizEmp->setIdentStatus($params['identstatus']);
            $wxBizEmp->setIdentTime(0);
            $wxBizEmp->setIsDel(0);
            $this->em->persist($wxBizEmp);
            $this->em->flush();
            $this->em->getConnection()->commit();
            $empid = $wxBizEmp->getId();

            if (1 == $params['type'] ) {
                $emp_type = 'mobile';
                $param_user    = $params['code'].$params['mobile'];
            }else{
                $emp_type = 'email';
                $param_user    = $params['email'];
            }

            // 添加到common
            $account["mobile"]=$params['mobile'];
            $account["password"]=$params['password'];
            $account["username"]=$params['name'];
            if(!empty($params['password']))
                $this->insertIntoCommon($emp_type,$empid,$account,$createTime);
            $returnArr = array(  'bizid'   => $params['bizid'],'empid'=>$empid);//返回数组
            //增加一条系统消息，通知管理员有新员工需要审核
            if ($params['enable'] == 2) {//待审核状态
                //获取该公司的管理员
                $sql = "SELECT id,name,mobile FROM " . Tables::TBWXBIZEMPLOYEE . " WHERE biz_id='".$params['bizid']."' AND role_id IN (1,2) AND enable=1";
                $adminArr = $this->getConnection()->executeQuery($sql)->fetchAll();
                $commonService = $this->container->get('common_service');
                $commonService->auditEmployee(array('emid'=>$empid, 'audit'=>$adminArr, 'userid'=>$userId, 'bizid'=>$params['bizid']));
            }
            return $returnArr;
        } catch (\Exception $ex) {
            $this->em->getConnection()->rollback();
            throw $ex;
        }
    }
    /**
     * @todo  修改员工方法
     */
    public function updateEmployee($params)
    {
        if (empty($params['id'])) {
            return 999003;
        }
        // 检验员工是否
        $empObj =  $this->em->getRepository('OradtStoreBundle:WxBizEmployee')->findOneBy( array('id'=>$params['id'],'bizId'=>$params['bizid']));
        if (empty($empObj)) {
            return 999020;
        }

        $old_roleid = $empObj->getRoleId();
        // roleid 角色，检验修改角色为普通时候判断还有没有其他管理员角色
        if (isset($params['roleid']) && ($old_roleid < 3) && 3 == intval($params['roleid']) ) {
            $check_roleid = $this->checkIfLastOneRole($params['id'],$params['bizid']);
            if (0 == $check_roleid) {
                return 310004;
            }
        }

        //邮箱是否存在
       /*  $empArr=$this->checkUserIfExist($params['email'],2 );
        if($empArr){
            $empObj_email=$empObj->getEmail();
            if($empArr["email"]!=$empObj_email){
                return 110012;
            }
        } */

        if (isset($params['enable']) && !empty($params['enable']) && !in_array($params['enable'], array(1,2,3,4)))
            $params['enable']  = $empObj->getEnable() ;
        if (isset($params['import']) && !empty($import) && !in_array($params['import'], array(1,2)))
            $params['import']  = $empObj->getImport();
        if (isset($params['roleid']) && !empty($params['roleid']) && !in_array($params['roleid'], array(1,2,3)))
            $params['roleid']  = $empObj->getRoleId();
        $old_ident_status = $empObj->getIdentStatus();
        if (isset($params['identstatus']) && !empty($params['identstatus']) && !in_array($params['identstatus'], array(1,2)) ) {
            $params['identstatus'] = $old_ident_status;
        }
        $this->em->getConnection()->beginTransaction();
        try {
            $modifyTime = $this->getTimestamp();
            // 添加员工登录信息
            if (!empty($params['password'])){
                $params['password']  = Password::encrypt($params['password']);
                $empObj->setPasswd($params['password']);
            }
            if (!empty($params['code']))
                $empObj->setCode($params['code'] );
            if (!empty($params['email'])) {

                $empObj->setEmail($params['email']);
            }
            if (!empty($params['name']))
                $empObj->setName($params['name']);
            if (!empty($params['superior']))
                $empObj->setSuperior($params['superior']);
            if (!empty($params['depart']))
                $empObj->setDepartment($params['depart']);
            if (!empty($params['enable'])) {
                $empObj->setEnable($params['enable']);
                if (3 == $params['enable'] && 3 != $empObj->getEnable()) {
                    // 如果员工离职需要清除common记录
                    $this->dealWithCommonByEmpid($params['id']);
                }
                $old_enable = $empObj->getEnable();
            }
            if (!empty($params['openid']))
                $empObj->setOpenId($params['openid']);
            if (!empty($params['unionid']))
                $empObj->setUnionId($params['unionid']);
            if (!empty($params['roleid']))
                $empObj->setRoleId($params['roleid']);
            if (!empty($params['import']))
                $empObj->setImportStatus($params['import']);
            // 1为认证，员工原来为未认证，需修改认证时间
            if (!empty($params['identstatus']) && 1 == $params['identstatus'] && 1 != $old_ident_status) {
                $empObj->setIdentTime($modifyTime);
            }
            if (!empty($params['identstatus'])) {
                $empObj->setIdentStatus($params['identstatus']);
            }
            $empObj->setModifyTime($modifyTime);
            $this->em->persist($empObj);
            $this->em->flush();
            $this->em->getConnection()->commit();
            $returnArr = array( 'empid'=>$params['id']);          //返回数组
            return $returnArr;
        } catch (\Exception $ex) {
            $this->em->getConnection()->rollback();
            throw $ex;
        }
    }

    /**
     * @param  string $bizid
     * @param  int    $departid
     * @return boolean true
     */
    public function changeSonDepartParentid($bizid,$departid)
    {
        $parent_id  = 0;
        $sql_parent = " SELECT parent_id as parentid  FROM " . Tables::TBWXBIZDEPARTMENT . " WHERE id = {$departid} AND biz_id = '{$bizid}' and is_del=0;";
        $res        = $this->em->getConnection()->executeQuery($sql_parent)->fetch();
        if (!empty($res)) {
            $parent_id = $res['parentid'];
        }
        $sql_update = "UPDATE " . Tables::TBWXBIZDEPARTMENT . " SET parent_id = {$parent_id} WHERE parent_id = {$departid} AND biz_id = '{$bizid}'  ;";
        $this->em->getConnection()->executeQuery($sql_update);
        return true;
    }

    public function updateBizAddId($bizid,$addid)
    {
        $sql_update = "UPDATE " . Tables::TBWXBIZ . " SET add_id = {$addid} WHERE biz_id = '{$bizid}' ;";
        $this->em->getConnection()->executeQuery($sql_update);
        return true;
    }
    /**
     * @param  int $empid
     * @param  string $bizid
     * @return int
     */
    public function checkIfLastOneRole($empid,$bizid)
    {
        $sql_find = "SELECT COUNT(*) as num  FROM " . Tables::TBWXBIZEMPLOYEE . " WHERE id <> {$empid} AND biz_id = '{$bizid}' AND enable = 1 AND role_id < 3";
        $res_num  = $this->em->getConnection()->executeQuery($sql_find)->fetchColumn();
        return intval($res_num);
    }
    public function checkIfLastOneSuperRole($empid,$bizid)
    {
        $sql_find = "SELECT COUNT(*) as num  FROM " . Tables::TBWXBIZEMPLOYEE . " WHERE id <> {$empid} AND biz_id = '{$bizid}' AND enable = 1 AND role_id =1";
        $res_num  = $this->em->getConnection()->executeQuery($sql_find)->fetchColumn();
        return intval($res_num);
    }
    /**
     * @todo 企业注销
     */
    public function bizCancel($biz_id,$employee_id=null)
    {
        if (empty($biz_id)) {
            return false;
        }

        try {

            if(empty($employee_id))
                $emp_list =  $this->em->getRepository('OradtStoreBundle:WxBizEmployee')->findBy(  array('bizId'=>$biz_id));
            else
                $emp_list =  $this->em->getRepository('OradtStoreBundle:WxBizEmployee')->findBy(  array('bizId'=>$biz_id,'id'=>$employee_id));
            foreach ($emp_list as $emp){
                $emp_id=$emp->getId();
                $emp_enable=$emp->getEnable();
                $account_no=$emp->getAccountNo();
                if($emp_enable==3)continue;//离职员工
                /* //先备份
                $account_list =  $this->em->getRepository('OradtStoreBundle:AccountCommon')->findBy(  array('accountId'=>$emp_id));
                $bak_arr=array();
                foreach ($account_list as $account){
                    $_bak_arr["type"]=$account->getType();
                    $_bak_arr["account"]=$account->getAccount();
                    $_bak_arr["accountid"]=$account->getAccountId();
                    $bak_arr["account"][]= $_bak_arr;
                } */

                $bak_arr["enable"]=$emp_enable;
                $bak_arr["account_no"]=$account_no;
                $bak_json=json_encode($bak_arr);

                $updSql = "UPDATE `" . Tables::TBWXBIZEMPLOYEE . "` SET enable='3',account_no='',bak=:bak WHERE id=:id LIMIT 1";

                $this->em->getConnection()->executeUpdate($updSql,array(":id"=>$emp_id,":bak"=>$bak_json));

                $this->dealWithCommonByEmpid($emp_id);//删除相应数据员工
            }


        } catch (\Exception $ex) {
            throw $ex;
        }


        return true;
    }

    /**
     * @todo 企业恢复
     */
    public function bizRecover($biz_id,$employee_id=null)
    {

        if (empty($biz_id)) {
            return false;
        }

        try {
            if(empty($employee_id))
                $emp_list =  $this->em->getRepository('OradtStoreBundle:WxBizEmployee')->findBy(  array('bizId'=>$biz_id));
            else
                $emp_list =  $this->em->getRepository('OradtStoreBundle:WxBizEmployee')->findBy(  array('bizId'=>$biz_id,'id'=>$employee_id));

            foreach ($emp_list as $emp){
                $emp_id=$emp->getId();
                $emp_bak=$emp->getBak();
                $emp_moblie=$emp->getMobile();
                $is_exist=$this->checkUserIfExist($emp_moblie);
                if(!empty($is_exist))continue;//已经注册其他企业
                if(empty($emp_bak))continue;//离职员工
                $bak_arr=json_decode($emp_bak,true);
                /* if(isset($bak_arr["account"])){
                    $account=$bak_arr["account"];
                    foreach ($account as $_account){
                        $type=$_account["type"];
                        $accountId=$_account["accountid"];
                        $account=$_account["account"];
                        $time=$this->getTimestamp(); 
                    }

                } */
                $enable=$bak_arr["enable"];
                $account_no=$bak_arr["account_no"];
                if(empty($enable)){
                    $enable=$emp->getEnable();
                }
                $updSql = "UPDATE `" . Tables::TBWXBIZEMPLOYEE . "` SET enable=:enable,account_no=:account_no WHERE id=:id LIMIT 1";
                $this->em->getConnection()->executeUpdate($updSql,array(":id"=>$emp_id,":enable"=>$enable,":account_no"=>$account_no));

                //员工绑定的企业
                $wechatService = $this->container->get("wechat_service");
                $bizId=$emp->getBizId();
                $openid=$emp->getOpenId();
                if($openid)
                    $wechatService->updateBizByWechatid($bizId,$openid);
            }


        } catch (\Exception $ex) {
            throw $ex;
        }


        return true;
    }

    /**
     * @todo 离职员工清除common的该员工检验信息
     * @param  [int] $empid [员工id]
     * @return [Boolean]
     */
    public function dealWithCommonByEmpid($empid)
    {
        if (empty($empid)) {
            return false;
        }
        //去掉微信版本的企业
        $wxBizEmp =  $this->em->getRepository('OradtStoreBundle:WxBizEmployee')->findOneBy(  array('id'=>$empid));
        if($wxBizEmp){
            $wechatid=$wxBizEmp->getOpenId();
            if(!empty($wechatid)){
                $updSql = "UPDATE `" . Tables::TBWEIXINUSER . "` SET biz_id='' WHERE wechat_id=:wechatid LIMIT 1";
                $this->em->getConnection()->executeUpdate($updSql,array(":wechatid"=>$wechatid));
            }

            $account_no=$wxBizEmp->getAccountNo();
            //删除session表中的员工信息
            if(!empty($account_no)){
                $sql_sesson_del  = "DELETE FROM " . Tables::TBLOGINSESSION . " WHERE account_id = {$account_no} ";
                $res_session     = $this->em->getConnection()->executeQuery($sql_sesson_del);
            }


        }

        return true;
    }
    /**
     * @todo  删除session表中的员工信息
     * @return [Boolean]
     */
    public function dealWithLoginSession($account_no)
    {
        if (empty($account_no)) {
            return false;
        }
        //删除session表中的员工信息
        $sql_sesson_del  = "DELETE FROM " . Tables::TBLOGINSESSION . " WHERE account_id = {$account_no} ";
        $res_session     = $this->em->getConnection()->executeQuery($sql_sesson_del);
        return true;
    }

    /**
     * 名片分享，部门分享到部门，管理员操作
     * @param $departId     //要被分享的部门ID
     * @param $moduleids    //接收分享的部门ID，可多个
     * @param $bizId        //当前登录用户所在公司
     * @return array|string
     * @throws \Exception
     */
    public function addShare($departId, $moduleids, $bizId) {
        try {  
            //判断当前要被分享的部门，管理员是否设置部门内不可见或公司不可见，设置不可见时则不可分享
            $res = $this->getDepartById($departId); 
            if ($res['is_del'] == 1) {
                return Errors::$ERROR_NOT_HAVE_PERMISSION;//管理员已设置该部门内不可见或该部门已被删除
            } 
            //校验被分享名片所属部门是否与当前登录管理员用户为同一部门
            if ($bizId <> $res['biz_id']) {
                return Errors::$ERROR_NOT_HAVE_PERMISSION;//该超级管理员与要分享的部门不同一公司 
            }
            
            foreach($moduleids as $val){
                if(empty($val)){//|| ($departId == $val)自己给自己分享
                    continue;
                }
                //判断是否已经有过分享
                $res = $this->getDepartShare($departId, $val);
                if (!empty($res)) {
                    continue;
                }
                //判断接受分享的部门是否是在企业内
                $res_dep = $this->getDepartById($val);
                if ($res_dep['is_del'] == 1) {
                    continue;
                } 
                //校验被分享名片所属部门是否与当前登录管理员用户为同一部门
                if ($bizId <> $res_dep['biz_id']) {
                    continue;
                }

                $params = array(
                    ":userId"   => $departId,
                    ":cardid"   => 0,
                    ":type"     => 3,
                    ":moduleid" => $val,
                    ":bizId"    => $bizId
                );
                $sql = "INSERT INTO `" . Tables::TBWXBIZCARDSHARE . "`(user_id, card_id, type, module_id, biz_id)
                        VALUES( :userId, :cardid, :type, :moduleid, :bizId )";
                $res=$this->getConnection()->executeQuery( $sql, $params ); 
            }
            return true;
        } catch(\Exception $e){
            throw $e;
        }
    }

    public function getDepartShare($dep, $module) {
        try {
            $result = array();
            $param = array(':dep' => $dep, ':module' => $module);
            $sql = "SELECT * FROM " . Tables::TBWXBIZCARDSHARE . " WHERE type=3 AND user_id=:dep AND module_id=:module";
            $result = $this->getConnection()->executeQuery($sql, $param)->fetch();
            return $result;
        } catch (\Exception $ex){
            throw $ex;
        }
    }

    /**
     * 获取企业名片详情
     * @param $id
     * @param null $status
     * @return array|mixed
     * @throws \Exception
     */
    public function getCardInfo($id, $status = '') {
        try {
            $result = array();
            if (!empty($status)) {
                $param = array(':id' => $id, ':status' => $status);
                $sql = "SELECT * FROM " . Tables::TBWXBIZCARD . " WHERE id=:id AND status=:status";
            } else {
                $param = array(':id' => $id);
                $sql = "SELECT * FROM " . Tables::TBWXBIZCARD . " WHERE id=:id";
            }
            $result = $this->getConnection()->executeQuery($sql, $param)->fetch();
            return $result;
        } catch (\Exception $ex){
            throw $ex;
        }
    }

    public function updateCard($param){
        $sql = "UPDATE " . Tables::TBWXBIZCARD . " SET remark=:remark WHERE id=:uuid ";
        $this->getConnection()->executeQuery($sql , $param);
    }

    public function getWeixinCardInfo($id, $status = '') {
        try {
            $result = array();
            if (!empty($status) || $status) {
                $param = array(':id' => $id, ':status' => $status);
                $sql = "SELECT * FROM " . Tables::TBWEIXINCARD . " WHERE find_in_set(id, :id) AND status=:status";
            } else {
                $param = array(':id' => $id);
                $sql = "SELECT * FROM " . Tables::TBWEIXINCARD . " WHERE find_in_set(id, :id)";
            }
            $result = $this->getConnection()->executeQuery($sql, $param)->fetch();
            return $result;
        } catch (\Exception $ex){
            throw $ex;
        }
    }

    public function getWeixinOtherPicInfo($id, $status = '') {
        try {
            $result = array();
            if (!empty($status) || $status) {
                $param = array(':id' => $id, ':state' => $status);
                $sql = "SELECT * FROM " . Tables::TBWEIXINOTHERPIC . " WHERE id=:id AND state=:state";
            } else {
                $param = array(':id' => $id);
                $sql = "SELECT * FROM " . Tables::TBWEIXINOTHERPIC . " WHERE id=:id";
            }
            $result = $this->getConnection()->executeQuery($sql, $param)->fetch();
            return $result;
        } catch (\Exception $ex){
            throw $ex;
        }
    }

    /**
     * 获取公司的全部管理员
     * @param $bizid
     * @param $roleid
     * @return string
     */
    public function getAllAdmin($bizid, $roleid='1,2') {
        try {
            $sql = "SELECT id,name FROM " . Tables::TBWXBIZEMPLOYEE . " WHERE find_in_set(role_id, :roleid) AND biz_id=:bizid AND enable=1";
            $res = $this->getConnection()->executeQuery($sql, array(':roleid'=>$roleid, ':bizid'=>$bizid))->fetchAll();
            $uids = array();
            foreach ($res as $key => $val) {
                $uids[$val['id']] = array('id' => $val['id'], 'name' => $val['name']);
            }
            return $uids;
        } catch (\Exception $ex){
            throw $ex;
        }
    }

    public function getUserByWechatId($wechatid)
    {
        try {
            $user = array();
            $sql = "SELECT * FROM " . Tables::TBWXBIZEMPLOYEE . " WHERE open_id=:wechatid AND enable=1";
            $user = $this->getConnection()->executeQuery($sql, array(':wechatid'=>$wechatid))->fetch();
            return $user;
        } catch (\Exception $ex){
            throw $ex;
        }
    }

    public function getCardCountAdmin($userid, $bizid, $where = '') {
        $param = array(':userid' => intval($userid), ':bizid' => $bizid);
        $sql = "SELECT CASE WHEN section=1 THEN 'self' ELSE 'share' END AS section,count(*) AS count
                FROM (SELECT *,CASE WHEN user_id=:userid THEN 1 ELSE 2 END AS section 
                      FROM " . Tables::TBWXBIZCARD . " 
                      WHERE status='active' AND biz_id=:bizid 
                ) AS bc 
                INNER JOIN " . Tables::TBWXBIZEMPLOYEE . " em ON em.id=bc.user_id
                LEFT JOIN (SELECT * from " . Tables::TBWXBIZCARDRECYCLE . " WHERE user_id=:userid) AS r on bc.id=r.card_id ";
        if (empty($where)) {
            $sql .= " GROUP BY section";
        } else {
            $sql .= " WHERE " . $where . " GROUP BY section";
        }

        $res = $this->getConnection()->executeQuery($sql, $param)->fetchAll();
        if (empty($res)) {
            $result = array('self' => 0, 'share' => 0);
        } else {
            $count = count($res);
            switch ($count) {
                case 1:
                    if ($res[0]['section'] == 'self') {
                        $result = array('self' => $res[0]['count'], 'share' => 0);
                    }
                    if ($res[0]['section'] == 'share') {
                        $result = array('self' => 0, 'share' => $res[0]['count']);
                    }
                    break;
                case 2:
                    $result = array('self' => $res[0]['count'], 'share' => $res[1]['count']);
                    break;
                default:
                    break;
            }
        }
        return $result;
    }

    /**
     * @param $userid
     * @param $where
     * @param int $type 0自己的 1分享的
     * @return bool|string
     */
    public function getCardCount($userid,$where,$type = 0){
        if ($type == 0) {
            $sql = "SELECT COUNT(1) AS count
                            FROM (
                                SELECT
                                    c.id
                                FROM
                                    " . Tables::TBWXBIZCARD . " c
                                WHERE
                                    c.user_id = :userId
                                    AND c. STATUS = 'active'
                            ) AS a
                            LEFT JOIN " . Tables::TBWXBIZCARDRECYCLE . " r ON r.card_id = a.id AND r.user_id = :userId
                            WHERE r.card_id IS NULL";
        }
        if ($type == 1) {
            $sql = "SELECT COUNT(1) AS count  FROM (
                            " . $this->getBasicSql() . "
                    ) AS a
                    INNER JOIN " . Tables::TBWXBIZCARD . " bc ON a.id = bc.id
                    -- 下面表示 a集合关联回收站表的筛选
                    LEFT JOIN " . Tables::TBWXBIZCARDRECYCLE . " r ON r.card_id = bc.id and r.user_id = :userId
                    WHERE r.card_id is NULL AND bc.status='active'";
        }
        $res = $this->getConnection()->executeQuery($sql,array(':userId'=>intval($userid)))->fetchColumn();
        return $res;
    }

    /**
     * 获取超管或公司全员共享名片
     * @param $userId
     * @param $bizid
     * @return string
     */
    public function getAllSql($userId, $bizid) {
        return $sql = "SELECT %s FROM (SELECT *,CASE WHEN user_id=".$userId." THEN 1 ELSE 2 END AS section FROM " . Tables::TBWXBIZCARD . " WHERE status='active' AND biz_id='".$bizid."') as bc
             INNER JOIN " . Tables::TBWXBIZEMPLOYEE . " em ON em.id=bc.user_id
             LEFT JOIN (SELECT * from " . Tables::TBWXBIZCARDRECYCLE . " WHERE user_id=".$userId.") AS r on bc.id=r.card_id";
    }

    /**
     * 获取公司是否开启全员共享状态
     * @param $bizid
     * @return bool|string
     */
    public function getBizOpenStatus($bizid) {
        $getBizStatus = " SELECT open_status FROM " . Tables::TBWXBIZ . " WHERE biz_id=:bizid";
        $openstatus = $this->getConnection()->executeQuery($getBizStatus,array(':bizid'=>$bizid))->fetchColumn();
        return $openstatus;
    }

    /**
     * 获取所有的名片
     * @return array
     */
    public function getPrivateSql() {
        return $sql = $this->getCommonSql() . " %s%s";
    }

    /**
     * 获取所有的名片(高级搜索)
     * @return array
     */
    public function getPrivateSqlSenior() {
        return $sql = $this->getCommonSql() . " LEFT JOIN " . Tables::TBWXBIZCARDINFO . " ci ON ci.card_id = bc.id %s%s";
    }

    public function getCommonSql() {
        /*老版查询
        return $sql = "SELECT %s
                        FROM (
                            -- 查询自持名片，section=1
                            SELECT
                                c.id,1 AS section
                            FROM
                                " . Tables::TBWXBIZEMPLOYEE . " e
                            INNER JOIN " . Tables::TBWXBIZCARD . " c ON c.user_id = e.id
                            WHERE
                                e.id = :userId
                                AND c.status = 'active'
                            UNION
                            ".$this->getBasicSql()."
                        ) a -- 下面表示 a集合关联card信息表
                        INNER JOIN " . Tables::TBWXBIZCARD . " bc FORCE INDEX (modified_time_x) ON a.id = bc.id
                        INNER JOIN " . Tables::TBWXBIZEMPLOYEE . " em ON em.id=bc.user_id
                        -- 下面表示 a集合关联回收站表的筛选
                        LEFT JOIN " . Tables::TBWXBIZCARDRECYCLE . " r ON r.card_id = bc.id AND r.user_id = :userId ";*/
        return $sql = "SELECT %s
                        FROM (
                            -- 查询自持名片，section=1
                            SELECT
                                c.id,1 AS section
                            FROM
                                " . Tables::TBWXBIZEMPLOYEE . " e
                            INNER JOIN " . Tables::TBWXBIZCARD . " c ON c.user_id = e.id
                            WHERE
                                e.id = :userId
                            UNION
                            ".$this->getBasicSql()."
                        ) a -- 下面表示 a集合关联card信息表
                        INNER JOIN " . Tables::TBWXBIZCARD . " bc FORCE INDEX (modified_time_x) ON a.id = bc.id
                        INNER JOIN " . Tables::TBWXBIZEMPLOYEE . " em ON em.id=bc.user_id
                        -- 下面表示 a集合关联回收站表的筛选
                        LEFT JOIN " . Tables::TBWXBIZCARDRECYCLE . " r ON r.card_id = bc.id AND r.user_id = :userId ";
    }

    private function getBasicSql() {
        /*老版查询
        return $basicSql = $this->getBasicSql1() . "
                    UNION
                        " . $this->getBasicSql2() . "
                    UNION
                        " . $this->getBasicSql3() . "
                    UNION
                        " . $this->getBasicSql4() . "
                    UNION
                        " . $this->getBasicSql5();*/
        return $basicSql = $this->getBasicSqlSection1() . "
                    UNION
                        " . $this->getBasicSqlSection2() . "
                    UNION
                        " . $this->getBasicSqlSection3() . "
                    UNION
                        " . $this->getBasicSqlSection4();
    }

    //查询别人共享名片，section=2
    private function getBasicSqlSection1() {
        return $basicSql1 = "SELECT
                                c.id,2 AS section
                            FROM
                                " . Tables::TBWXBIZEMPLOYEE . " e
                            INNER JOIN " . Tables::TBWXBIZCARDSHARE . " s ON e.id = s.module_id
                            INNER JOIN " . Tables::TBWXBIZCARD . " c ON c.id = s.card_id
                            WHERE
                                e.id = :userId
                                AND s.type = 1
                                AND c.user_id <> :userId";
    }
    //查询别人分享到我的部门名片，section=3
    private function getBasicSqlSection2() {
        return $basicSql2 = "SELECT
                                c.id,2 AS section
                            FROM
                                " . Tables::TBWXBIZEMPLOYEE . " e
                            INNER JOIN " . Tables::TBWXBIZCARDSHARE . " s ON e.department = s.module_id
                            INNER JOIN " . Tables::TBWXBIZCARD . " c ON s.card_id = c.id
                            INNER JOIN " . Tables::TBWXBIZDEPARTMENT . " d ON e.department = d.id
                            WHERE
                                e.id = :userId
                                AND s.type = 2
                                AND EXISTS (
                                    SELECT
                                        id
                                    FROM
                                        wx_biz_card_share
                                    WHERE
                                        user_id = e.department
                                        AND type = 3
                                        AND module_id = e.department
                                )";
    }
    //查询自身为上级时下属的名片，section=4
    private function getBasicSqlSection3() {
        return $basicSql3 = "SELECT
                                c.id,2 AS section
                            FROM
                                " . Tables::TBWXBIZEMPLOYEE . " e
                            INNER JOIN " . Tables::TBWXBIZCARDSHARE . " s ON e.id = s.module_id
                            INNER JOIN " . Tables::TBWXBIZCARD . " c ON s.card_id = c.id
                            WHERE
                                e.superior = :userId";
    }
    //查询被分享部门是我的部门，并且是部门间分享，那么所有的分享部门里的所有人对应的名片，section=5
    private function getBasicSqlSection4() {
        return $basicSql4 = "SELECT
                                c.id,2 AS section
                            FROM
                                " . Tables::TBWXBIZCARDSHARE . " s
                            INNER JOIN " . Tables::TBWXBIZEMPLOYEE . " ep ON s.user_id = ep.department
                            INNER JOIN " . Tables::TBWXBIZCARD . " c ON ep.id = c.user_id
                            WHERE
                                ep.id <> :userId
                            AND s.type = 3
                            AND s.module_id IN (
                                SELECT
                                    e.department
                                FROM
                                    " . Tables::TBWXBIZEMPLOYEE . " e
                                WHERE
                                    e.id = :userId
                            )";
    }

    //*******老版查询*********/
    //查询别人共享名片，section=2
    private function getBasicSql1() {
        return $basicSql1 = "SELECT
                            c.id,2 AS section
                        FROM
                            " . Tables::TBWXBIZCARDSHARE . " s
                        INNER JOIN " . Tables::TBWXBIZCARD . " c ON c.id = s.card_id
                        WHERE
                            s.module_id = :userId
                            AND s.type = 1
                            AND c.status = 'active'
                            AND c.user_id <> :userId";
    }
    //查询部门内名片，section=3
    private function getBasicSql2() {
        return $basicSql2 = "SELECT
                            c.id,2 AS section
                        FROM
                            " . Tables::TBWXBIZEMPLOYEE . " ep
                        INNER JOIN " . Tables::TBWXBIZCARDSHARE . " s ON ep.id = s.module_id
                        INNER JOIN " . Tables::TBWXBIZCARD . " c ON s.card_id = c.id
                        INNER JOIN " . Tables::TBWXBIZDEPARTMENT . " d ON ep.department = d.id
                        WHERE
                            ep.id <> :userId
                            AND d.`status` = 1 -- 用于部门开关，默认1为开
                            AND ep.department IN (
                                SELECT e.department FROM " . Tables::TBWXBIZEMPLOYEE . " e WHERE e.id = :userId
                            )";
    }
    //查询别人共享到部门的名片，section=4
    private function getBasicSql3() {
        return $basicSql3 = "SELECT
                            c.id,2 AS section
                        FROM
                            " . Tables::TBWXBIZEMPLOYEE . " e
                        INNER JOIN " . Tables::TBWXBIZCARDSHARE . " s ON e.department = s.module_id
                        INNER JOIN " . Tables::TBWXBIZCARD . " c ON s.card_id = c.id
                        INNER JOIN " . Tables::TBWXBIZDEPARTMENT . " d ON e.department = d.id
                        WHERE
                            e.id = :userId
                            AND s.type = 2
                            AND c.status = 'active'
                            AND d.`status` = 1 -- 用于部门开关，默认1为开";
    }
    //查询自身为上级时下属的名片，section=5
    private function getBasicSql4() {
        return $basicSql4 = "SELECT
                            c.id,2 AS section
                        FROM
                            " . Tables::TBWXBIZEMPLOYEE . " e
                        INNER JOIN " . Tables::TBWXBIZCARDSHARE . " s ON e.id = s.module_id
                        INNER JOIN " . Tables::TBWXBIZCARD . " c ON s.card_id = c.id
                        WHERE
                            e.superior = :userId";
    }
    //查询部门分享给部门的名片，section=6
    private function getBasicSql5() {
        return $basicSql5 = "SELECT
                            c.id,2 AS section
                        FROM
                            " . Tables::TBWXBIZCARDSHARE . " s
                        INNER JOIN " . Tables::TBWXBIZEMPLOYEE . " ep ON s.user_id = ep.department
                        INNER JOIN " . Tables::TBWXBIZCARD . " c ON ep.id = c.user_id
                        WHERE
                            ep.id <> :userId
                            AND s.type = 3
                            AND s.module_id IN (
                                SELECT e.department FROM " . Tables::TBWXBIZEMPLOYEE . " e WHERE e.id = :userId
                            )";
    }
    //*******老版查询*********/

    public function getAdminRecycle() {
        return $sql = "SELECT %s FROM " . Tables::TBWXBIZCARD . " bc
                        INNER JOIN " . Tables::TBWXBIZEMPLOYEE . " em ON em.id=bc.user_id
                        RIGHT JOIN " . Tables::TBWXBIZCARDRECYCLE . " r ON r.card_id = bc.id %s%s";
    }
}
