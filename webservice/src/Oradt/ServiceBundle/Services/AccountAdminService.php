<?php
namespace Oradt\ServiceBundle\Services;
use Oradt\StoreBundle\Entity\AccountEmployeeLoginRecord;
use Oradt\StoreBundle\Entity\AuthorityPermission;
use Oradt\StoreBundle\Entity\AuthorityAction;
use Oradt\StoreBundle\Entity\AccountEmployee;
use Oradt\StoreBundle\Entity\AuthorityRole;
use Oradt\StoreBundle\Entity\OrangeMerchantInfo;
use Oradt\StoreBundle\Entity\SysCardTemplate;

class AccountAdminService
{
    
    private $em = null;
    
    public function __construct($entityManager)
    {
       // echo __FILE__;
        $this->em = $entityManager;
    }
    
    
    /**
     * 保存角色信息
     * @param AuthorityRole $role
     * @return AuthorityRole
     */
    public function saveRole(AuthorityRole $role)
    {
       // exit('aaa');
        $this->em->persist($role);
        $this->em->flush();
        return $role;
    }
    /**
     * 根据ID获取角色
     * @param number $id
     * @return AuthorityRole
     */
    public function getRoleById($id)
    {
        return $this->em->getRepository('OradtStoreBundle:AuthorityRole')
                ->findOneBy(array('roleId'=>$id));
    }
    
    /**
     * 查找角色
     * @param unknown $array
     * @return 
     */
    public function findRole($array)
    {
        //查询多条数据
        $repository = $this->em->getRepository('OradtStoreBundle:AuthorityRole');
        
        $list = $repository->findBy($array);
        
        return $list;
    }
    
    /**
     * 删除角色
     * @param number $id
     * @return boolean
     */
    public function deleteRole($id)
    {
        $role = $this->getRoleById($id);
        if (!empty($role)) {
            $this->em->remove($role);
            $this->em->flush();
            return true;
        }
        return false;
    }
    
    /**
     * 写入管理员账户信息
     * @param AccountEmployee $employee
     * @return AccountEmployee
     */
    public function saveEmployee(AccountEmployee $employee)
    {
      
        $this->em->persist($employee);
        $this->em->flush();        
        return $employee;
    }
    
   
    
    /**
     * 删除管理员账号
     * @param number $id
     * @return boolean true 删除成功 false 删除失败
     */
    public function deleteEmployee($id)
    {
        $employee = $this->getEmployeeById($id);         
        if (!empty($employee)) {
            $this->em->remove($employee);
            $this->em->flush();
            return true;
        }        
        return false;
    }
    
    /**
     * 根据ID获取管理员账号信息
     * @param string $id
     * @return AccountEmployee|NULL
     */
    public function getEmployeeById($id)
    {
        $employee = $this->em->getRepository('OradtStoreBundle:AccountEmployee')
            ->findOneBy(array('emplId'=>$id));
        return $employee;
    }
    
    public function getEmployeeBy_Id($id)
    {
        $employee = $this->em->getRepository('OradtStoreBundle:AccountEmployee')
        ->findOneBy(array('id'=>$id));
        return $employee;
    }
    
    public function findEmployee($array)
    {
        //查询多条数据
        $repository = $this->em->getRepository('OradtStoreBundle:AccountEmployee');
        
        $list = $repository->findBy($array);
        
        return $list;
    }
    
    
    /**
     * 管理员登陆
     * @param string $account
     * @param string $passwd
     * @param number $type 0|1 0为邮箱，1为手机号
     * @return array|False  False表示登陆失败
     */
    public function adminLogin($account,$passwd,$ip,$type=0){
        $repository = $this->em->getRepository('OradtStoreBundle:AccountEmployee');
        
        $findArray = array();
        
        if ($type==0) {
            $findArray['email'] = $account;
        }
        else{
            $findArray['mobile'] = $account;
        }
        
        $findArray['password'] = $passwd;
        
        $admin = $repository->findOneBy($findArray);
        if(empty($admin))
            return False;
        
        $data = array(
                'adminid' => $admin->getId(),
                'email'   => $admin->getEmail(),
                'realname' => $admin->getRealName(),
       //         'lastname'  => $admin->getLastName(),
                'mobile'    => $admin->getMobile(),
                'roleid'          => $admin->getRoleId()
        );
        //更新最后登陆信息
        $emplId = $admin->getEmplId();
        $this->addAdminLoginLog($emplId, $ip);
        
        return $data;
    }
    
    
    /**
     * 添加授权
     * @param number $actionId
     * @param number $roleId
     * @return number
     */
    public function addPermission($actionId,$roleId)
    {
        $authorPermission = new AuthorityPermission();
        $authorPermission->setActionId($actionId);
        $authorPermission->setRoleId($roleId);
        $this->em->persist($authorPermission);
        $this->em->flush();
        return $authorPermission->getId();
    }
    
    /**
     * 
     * @param string $name
     * @param number $module_id
     * @return number
     */
    public function addAction($name,$moduleId)
    {
        
        $authorAction = new AuthorityAction();
        $authorAction->setName($name);
        $authorAction->setModuleId($moduleId);
        $this->em->persist($authorAction);
        $this->em->flush();
        return $authorAction->getId();
    }
    
    /**
     * 管理员登陆日志
     * @param string $emplId
     * @param string $lastLoginIp
     * @return void
     */
    public function addAdminLoginLog($emplId,$lastLoginIp)
    {
       
        $emplyeeLoginLog =$this->em->getRepository('OradtStoreBundle:AccountEmployeeLoginRecord')
            ->findOneBy(array('emplId' => $emplId));
        //如果第一次登陆，需要再实例化一次
        if(empty($emplyeeLoginLog)) {
            $emplyeeLoginLog = new AccountEmployeeLoginRecord();
            $emplyeeLoginLog->setEmplId($emplId);                    
        }
        //更新登陆IP 时间
        $loginDate=new  \DateTime(strtotime(time()));        
        $emplyeeLoginLog->setLastLoginIp($lastLoginIp);
        $emplyeeLoginLog->setLastLoginTime($loginDate);       
        $this->em->persist($emplyeeLoginLog);        
        $this->em->flush();
    }

    /**
     * 检查公司是否添加过管理员
     * @param string $emplId 公司ID
     * @return boolean
     */
    public function checkEmplidExists($emplId)
    {
        $employee = $this->em->getRepository('OradtStoreBundle:AccountEmployee')
            ->findOneBy(array('emplId'=>$emplId));
        if(empty($employee))
            return false;
        
        return true;
    }
    

    /**
     * 保存系统名片模版
     * @param SysCardTemplate $template
     * @return SysCardTemplate
     */
    public function saveSysCardTemplate(SysCardTemplate $template)
    {
        $this->em->persist($template);
        $this->em->flush();
        return $template;
    }
    
    public function findSysCardTemplate($findArray)
    {   //查询多条数据
        $repository = $this->em->getRepository('OradtStoreBundle:SysCardTemplate');        
        $list = $repository->findBy($findArray);        
        return $list;
    }

    public function intNewDelOld($id,$filed,$value)
    {        
        $record = $this->em->getRepository('OradtStoreBundle:AccountBasicMoveRecord')
            ->findOneBy(array('id'=>$id));
        if (empty($record)) {
            return true;
        }
        $sql = "INSERT INTO `account_basic_move_record_redu` (user_id,latitude,longitude,country,province,city,mapstate,status,created_time,push_time,md5city) values (:user_id,:latitude,:longitude,:country,:province,:city,:mapstate,:status,:created_time,:push_time,:md5city);";
        $param = array(':user_id'=>$record->getUserId(),':latitude'=>$record->getLatitude(),':longitude'=>$record->getLongitude(),':country'=>$record->getCountry(),':province'=>$record->getProvince(),':city'=>$record->getCity(),':mapstate'=>$record->getMapstate(),':status'=>$record->getStatus(),':created_time'=>$record->getCreatedTime(),':push_time'=>$record->getPushTime(),':md5city'=>$record->getMd5city());
        $this->em->getConnection()->executeQuery($sql,$param);
        $sq2 = "UPDATE `account_basic_move_record_redu` SET ".$filed."=".$value." WHERE id=".$id;
        $this->em->getConnection()->executeQuery($sq2);
        $sql1 = "DELETE FROM `account_basic_move_record` WHERE id=".$id;
        $this->em->getConnection()->executeQuery($sql1);
    }
    public function checkSid($sid)
    {
        $lastSql = "SELECT id FROM scanner WHERE scannerid =:scannerid AND status != 4;";
        $lastRecord = $this->em->getConnection()->executeQuery($lastSql, array(":scannerid"=>$sid))->fetch();
        if(!empty($lastRecord)){
            $res = true;
        }else{
            $res = false;
        }
        return $res;
    }
    /**
     * @return 
     * @param $id int 商户id
     * @param $tempid string  模板ID（多个逗号隔开）
     * @succuss 需保证map表中tempid 只出现一次
     * @date 2017-5-11
     */
    public function checkMerchantTemp($id,$tempid)
    {
        if (empty($id) || empty($tempid) ) {
            return false;
        }
        // 判断id数据是否存在
        $res = $this->em->getRepository('OradtStoreBundle:OrangeMerchantInfo')->findOneBy(array('id' => $id));
        if (empty($res)) {
            return false;
        }
        // 第一步：清除map表里的以前的关联
        $del_sql  = "DELETE FROM `orange_merchant_temp_map` WHERE mid = {$id} ;";
        $this->em->getConnection()->executeQuery($del_sql);
        //判断tempid
        $tempids = explode(',', $tempid);
        $merArr  = array();
        $values  = '';
        $time = time();
        foreach ($tempids as $tid) {
            if (empty($tid)) 
                continue;
            $sql    = "SELECT mid FROM orange_merchant_temp_map WHERE card_temp_id = '{$tempid}' group by mid;";
            $mapObj = $this->em->getConnection()->executeQuery($sql)->fetchAll();
            // 如果存在1、存入一数组方便修改时间2根据tempid删除
            if ($mapObj) {
                foreach ($mapObj as $val) {
                    $merArr[$val['mid']] = $val['mid'];
                }
            }
            $values .="({$id},'{$tid}',1,{$time}),";
        }
        // 删除map重复数据
        $tempid   = rtrim($tempid,',');
        $sql_del  = "DELETE FROM `orange_merchant_temp_map` WHERE card_temp_id in ($tempid) ";
        $this->em->getConnection()->executeQuery($sql_del);
        // 修改merchant时间
        $mids = '';
        if (!empty($merArr)) {
            $mids = implode(',', $merArr);
        }
        if (!empty($mids)) {
            $sql_edit = "UPDATE orange_merchant_info set modify_time = {$time} WHERE id in ({$mids}) ;";
            $this->em->getConnection()->executeQuery($sql_edit);    
        }
        if (!empty($values)) {
            $values = rtrim($values,",");
            // 添加map数据
            $sql_insert = "INSERT INTO `orange_merchant_temp_map` (mid,card_temp_id,status,created_time) values {$values}"; 
            $this->em->getConnection()->executeQuery($sql_insert);   
        }
        
    }
}
