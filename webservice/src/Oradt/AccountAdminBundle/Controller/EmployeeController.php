<?php
namespace Oradt\AccountAdminBundle\Controller;
use Oradt\Utils\Errors;
use Oradt\Utils\Password;
use Oradt\Utils\RandomString;
use Oradt\OauthBundle\Controller\BaseController;
use Oradt\StoreBundle\Entity\AccountEmployee;
use Symfony\Component\HttpFoundation\JsonResponse;
use PDO;
use Oradt\Utils\Codes;



class EmployeeController extends BaseController
{
    /**
     * 管理员查询
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getAction()
    {
        $request = $this->getRequest ();
        $allUserList = $this->strip_tags($request->get("alluserlist"));
        if (!empty($allUserList) && $allUserList === 'true') {
            $allUsers = $this->_getAllUsers();
            return $this->renderJsonSuccess($allUsers);
        }
        // 检查token
        $this->checkAccount ();
        if($this->accountType!==self::ACCOUNT_ADMIN)
        {
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }

       /* $sqldata = $this->loadSqlConfig();
        $sqldata['fields']['position']['type'] = 'string';
        $sqldata['fields']['position']['mapdb']= 'position';
        $sqldata['fields']['position']['w']    = ' AND position LIKE :position';
        $sqldata['provide_max_fields'] .= ',position';*/

        $sqldata = array(
            'fields'=>array(
                'adminid'     =>array('mapdb'=>'a.id','w'=>'AND a.id IN (%s) '),
                'emplid'     =>array('mapdb'=>'a.empl_id','w'=>'AND a.empl_id IN (%s) '),
                'roleid'      =>array('mapdb'=>'a.role_id','w'=>'AND a.role_id=:roleid '),
                'realname'    =>array('mapdb'=>'a.real_name','w'=>'AND a.real_name LIKE :realname '),
                'mobile'      =>array('mapdb'=>'a.mobile','w'=>'AND a.mobile=:mobile '),
                'email'       =>array('mapdb'=>'a.email','w'=>'AND a.email LIKE :email '),
                'state'       =>array('mapdb'=>'a.status','w'=>'AND a.status=:state '),
                'date'        =>array('mapdb'=>'a.created_time','w'=>'Range'),
                'position'     =>array('mapdb'=>'a.position','w'=>'AND a.position LIKE :position '),
                'lastlogintime'=>array('mapdb'=>"ifnull(e.last_login_time,'')"),
                'lastloginip'  =>array('mapdb'=>"ifnull(e.last_login_ip,'')"),
                'logintime'    =>array('mapdb'=>"ifnull(e.login_time,'')"),
                'loginip'      =>array('mapdb'=>"ifnull(e.login_ip,'')")
            ),
            'default_dataparam'=>array(),
            'sql'=>'SELECT %s FROM account_employee a LEFT JOIN `account_employee_login_record` e ON a.empl_id=e.empl_id %s%s',
            'where'=>'a.id>0 ',
            'order'=>'ORDER BY a.id DESC',
            'provide_max_fields'=>'adminid,emplid,roleid,realname,mobile,email,state,date,position,lastlogintime,lastloginip,logintime,loginip'
        );



        $check = $this->parseSql($sqldata);

        if(true !== $check)
        {
            return $this->renderJsonFailed($check);
        }
        $this->setParam('function', __FUNCTION__);
        $data = $this->getData($sqldata,'admins');
        return $this->renderJsonSuccess ( $data );
    }
    /**
     * 添加账号
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function postAction($act)
    {
    
        //检查token
        $this->checkAccount();
        if($this->accountType!==self::ACCOUNT_ADMIN)
        {
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
       
        switch ($act) {
            case 'add':
                return $this->addAdminAccount();
                break;
            case 'edit':   
                return $this->editAdminAccount();
                break;
            case 'delete':
                return $this->delAdminAccount();
                break; 
            default:
                return $this->renderJsonFailed( Errors::$ERROR_PARAMETER_NOT_ENOUGH );
                break;
        }     
    }
    /**
     * @todo 添加管理员
     */
    public function addAdminAccount()
    {
        $request = $this->getRequest();
        //赋值        
        $realname = $this->strip_tags($request->get("realname"));
        $email = $this->strip_tags($request->get("email"));
        $passwd = $this->strip_tags($request->get("passwd"));
        $mobile = $this->strip_tags($request->get("mobile",''));
        $roleid = $this->strip_tags($request->get("roleid",''));
        $position = $this ->strip_tags($request->get("position"));
        if(empty($roleid)){
            $robj = $this->querySql("SELECT role_id FROM `authority_role` ORDER BY id limit 1");
            $roleid = $robj['role_id'];
        }
        $this->setParam('realname', $realname);
        $this->setParam('email', $email);
        $this->setParam('passwd', $passwd);
        $this->setParam('mobile', $mobile);
        $this->setParam('roleid', $roleid);
        $this->setParam('position', $position);
        if( empty($realname) || empty($email) || empty($roleid) || empty($passwd) ){
            
            return $this->renderJsonFailed( Errors::$ERROR_PARAMETER_NOT_ENOUGH );
        }
        // 1、验证邮箱
        $functionService = $this->get('function_service');
        $checkEmail      = $functionService->validateEmail($email);
        if (!$checkEmail) {
            return $this->renderJsonFailed(Errors::$ACCOUNT_BIZ_ERROR_EMAIL );
        }
        $adminService = $this->get("account_admin_service");
        $employee = $adminService->findEmployee(array('email'=>$email));
        if(!empty($employee)){
            return $this->renderJsonFailed( Errors::$ACCOUNT_ADMIN_ERROR_EXISTS );
        }
        $role = $adminService->getRoleById(array('roleId'=>$roleid));
        if(empty($role)){
            return $this->renderJsonFailed( Errors::$ACCOUNT_ADMIN_ERROR_ROLE_NOTEXISTS );
        }
        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();
        try {
            $createTime = $this->getTimestamp();
            $emplId = RandomString::make(40,'C');              
            $employee = new AccountEmployee();
            $passwd = Password::encrypt($passwd);
            $employee->setEmplId ( $emplId );
            $employee->setRealName ( $realname );
            $employee->setEmail ( $email );
            $employee->setMobile ( $mobile );
            $employee->setPassword ( $passwd );
            $employee->setRoleId ( $roleid);        
            $employee->setStatus('active');
            $employee->setCreatedTime($createTime);
            $employee->setPosition($position);
            $employee = $adminService->saveEmployee($employee);
            // if ($employee->getId()>0)
            // {
            //     print_r(1);
            //     $data =array('adminid'=>$emplId);
            //     $this->_setRbacOperation($emplId, $email, '', $role->getName(), 'create_account');
            //     return $this->renderJsonSuccess($data) ;
            // }
            // else{
            //     return $this->renderJsonFailed( Errors::$ERROR_UNKNOWN );
            // } 
            // print_r(2);
            // die();
            $em->persist($employee);
            $em->flush();
            $em->getConnection()->commit();
            $data = array(
                'empid' => $emplId,
            );
            return $this->renderJsonSuccess($data);
        } catch (\Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }
        
             
    }
    
    /**
     * @todo 修改后台管理员
     * @return [type] [description]
     */
    public function editAdminAccount()
    {
       
        $request = $this->getRequest(); 
        $this->parse_raw_http_request($request);
        $adminId = $request->get("adminid");     
      
        if( empty($adminId) ){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
      
        $roleid = $request->get("roleid") ;
        $state = $request->get("state") ;
        $stateArr = array('active','inactive','deleted');
        $arrAdminId = array_unique(explode(',', $adminId));
        $adminService = $this->get("account_admin_service");
        if(!empty($roleid)){
            $role = $adminService->getRoleById(array('roleId'=>$roleid));
            if(empty($role))
            {
                return $this->renderJsonFailed( Errors::$ACCOUNT_ADMIN_ERROR_ROLE_NOTEXISTS );
            }
        }
        
      
        if(count($arrAdminId)>1 && !empty($roleid) || !empty($state)){
            $this->em = $this->getManager();
            $this->em->beginTransaction();
            //批量处理
            try{
                $result = true;                
                if(empty($roleid)){
                    if(!in_array($state, $stateArr)){
                        $this->em->rollback();
                        return $this->renderJsonFailed( Errors::$ERROR_PARAMETER_NOT_ENOUGH );
                    }
                }

                foreach ($arrAdminId as $itemid)
                {
                    if(empty($itemid))
                        continue;
                    $employee = $adminService->getEmployeeBy_Id($itemid);
                    if(empty($employee)){
                        $this->em->rollback();
                        return $this->renderJsonFailed(Errors::$ERROR_UNKNOWN);
                    }
                    if(!empty($role)){ 
                        $employee->setRoleid($roleid);
                    }
                    if(!empty($state)){ 
                        $employee->setStatus($state);
                        if ($state == 'active') {
                            $operation = 'account_active';
                        } else {
                            $operation = 'account_disabled';
                        }
                    }

                    // $this->_setRbacOperation($itemid, $employee->getEmail(), '', '', $operation); // 禁用激活时，原状态和新状态均为空
                    $adminService->saveEmployee($employee);
                }
                $this->em->commit();
                return $this->renderJsonSuccess();
            }catch (\Exception $ex){
                $this->em->rollback();
                $this->errorLogger($ex ,__FILE__ . __FUNCTION__);
                throw $ex;
                return $this->renderJsonFailed(Errors::$ERROR_UNKNOWN);
            }
        }

        
        $employee = $adminService->getEmployeeBy_Id($adminId);
       //if 开始
        if (!empty($employee)) {
            $position = $request->get('position', '');
            if ($position) {
                $employee ->setPosition($position);
            }
            $realName = $request->get("realname");
            if( !empty($realName))
                $employee->setRealName($realName);
            $email = $request->get("email");
            //修改邮箱  修改邮箱里需要验证邮箱是否已注册
            if( !empty($email) && $employee->getEmail()!=$email)
            {
                $checkMail = $adminService->findEmployee(array('email' => $email));
                if (empty ( $checkMail )) {
                    $employee->setEmail ( $email );
                } else {
                    return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_DATA_EXISTS);
                }              
            }
            $mobile = $request->get("mobile");
            if( !empty($mobile))
                $employee->setMobile($mobile);
            
            $passwd = $request->get("passwd") ;
            if( !empty($passwd) )
            {
                $passwd = Password::encrypt($passwd);
                $employee->setPassword($passwd);
            }
            
            if( !empty($roleid) ){ // 前提:只有账号信息时进，激活禁用功能不进入if
                $prePermission = $adminService->getRoleById(array('roleId'=>$employee->getRoleId()))->getName(); // 获取原角色名
                $permission = $adminService->getRoleById(array('roleId'=>$roleid))->getName(); // 获取更新后角色名 
                if ($employee->getRoleId() != $roleid) { // 新角色与原角色不同则记日志
                       $this->_setRbacOperation($adminId, $employee->getEmail(), $prePermission, $permission, 'edit_account_authority'); 
                   }   

                $employee->setRoleid($roleid);     
            }
            
            if(!empty($state)){
                $employee->setStatus($state); 
            }
            
            //保存修改信息
            $adminService->saveEmployee($employee);
            return $this->renderJsonSuccess();
        }
        //if end
        return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
    }
    
    public function delAdminAccount()
    {
        $request = $this->getRequest();
        $adminid = $request->get("adminid");
        if(empty($adminid))
        {
            return $this->renderJsonFailed( Errors::$ERROR_PARAMETER_NOT_ENOUGH );
        }
        $this->setParam("adminid", $adminid);
        $arrAdminId = array_unique(explode(',', $adminid));
        $adminService = $this->get("account_admin_service");
        $this->em = $this->getManager();
        $this->em->beginTransaction();
        //批量处理
        try{
            $result = true;
            foreach ($arrAdminId as $itemid)
            {
                if(empty($itemid))
                    continue;  
                $employee = $adminService->getEmployeeBy_Id($itemid); // 获取用户 
                $result = $adminService->deleteEmployee($itemid);
                if(!$result){
                    $this->em->rollback();
                    return $this->renderJsonFailed(Errors::$ERROR_UNKNOWN);
                }
                // $this->_setRbacOperation($itemid, $employee->getEmail(), '', '', 'delete_account');
            }
        $this->em->commit();
        return $this->renderJsonSuccess();
        }catch (\Exception $ex){
            $this->em->rollback();
            $this->errorLogger($ex ,__FILE__ . __FUNCTION__);
            return $this->renderJsonFailed(Errors::$ERROR_UNKNOWN);
        }
    }

    /**
     * 获取所有用列表，不论激活与否
     * @return [array] 结果集
     */
    protected function _getAllUsers()
    {
        $sql = "select e.empl_id as adminid,e.role_id as roleid,e.real_name as realname,e.mobile,e.email,e.status as state,e.created_time as date,e.position,l.last_login_time as lastlogintime,l.last_login_ip as lastloginip,l.login_time as logintime,l.login_ip as loginip from account_employee as e left join account_employee_login_record as l on e.empl_id=l.empl_id order by e.id desc";
        $results = $this->getManager('scandb')->getConnection()->executeQuery($sql)->fetchAll();
        return $results;
    }

    /**
     * 记录管理操作日志到数据库
     * @param [string] $targetid  被操作对象的adminid
     * @param [string] $prerole   原有权限
     * @param [string] $role      新权限
     * @param [string] $operation 操作名称
     */
    protected function _setRbacOperation($targetid,$targetname,$prerole, $role, $operation)
    {
        $accesstoken = $this->getRequest()->headers->get('accesstoken');
        $loginSession = $this->container->get('oauthService')->getUserInfo($accesstoken);

        $param[':operate_id'] = $loginSession->getAccountId();
        $param[':op_time'] = $this->getDateTime()->format("Y-m-d H:i:s");
        $param[':target_id'] = $targetid;
        $param[':target_name'] = $targetname;
        $param[':status_from'] = $prerole;
        $param[':status_to'] = $role;
        $param[':operation'] = $operation;

        $sql = "insert into scan_card_rbac_operation_log (operate_id,target_id,target_name,status_from,status_to,operation,op_time) values (:operate_id , :target_id, :target_name, :status_from, :status_to, :operation, :op_time)";

        $this->getManager('scandb')->getConnection()->executeUpdate($sql,$param);

    }
/*
    
*/   
}
