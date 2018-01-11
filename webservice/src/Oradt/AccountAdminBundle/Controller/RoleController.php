<?php
namespace Oradt\AccountAdminBundle\Controller;
use Oradt\Utils\Codes;
use Oradt\Utils\Errors;
use Oradt\Utils\RandomString;
use Oradt\OauthBundle\Controller\BaseController;
use Oradt\StoreBundle\Entity\AuthorityRole;
use Oradt\StoreBundle\Entity\ScanCardRbacOperationLog;


class RoleController extends BaseController
{
    
    public function postAction()
    {
        $request = $this->getRequest();
        //检查token
        $this->checkAccount();
        if($this->accountType!==self::ACCOUNT_ADMIN)
        {
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        //获取参数
        $role = new AuthorityRole(); 
        $roleId = RandomString::make(32);
        $name = $this->strip_tags($request->get("name"));
        $dispname = $this->strip_tags($request->get("dispname"));
        $permission = $this->strip_tags($request->get("permission"));
        $status     = $this->strip_tags($request->get('status'));
        $act = $this->strip_tags($request->get('act'));
        $operateId = $this->strip_tags($request->get('operateId'));
        if (empty($status)) $status =1 ;
        if (empty($name) || empty($permission) ) {
            return $this->renderJsonFailed( Errors::$ERROR_PARAMETER_NOT_ENOUGH );
        }
        if(empty($dispname))
            $dispname = $name;
        $adminService = $this->get("account_admin_service");
        $roleObject = $adminService->findRole(array('name'=>$name));
        if(!empty($roleObject)){
            return $this->renderJsonFailed( Errors::$ERROR_SUB_EXISTS ,"name" );
        }
        
        
        $role->setRoleId($roleId);
        $role->setName($name);
        $role->setDisplayName($dispname);
        $role->setPermission($permission);
        $role->setStatus($status);
       
        $role = $adminService->saveRole($role);
        //组织返回数据        
        if (0 < $role->getId()) {
            
            $data['roleid'] = $role->getRoleId();
            //添加数据到scan_card_rbac_operation_log表
            if($data && $act){
                $accountBasicService = $this->get('scancard_pic_service');
                $op = new ScanCardRbacOperationLog();
                $op->setOperateId($operateId);
                $op->setTargetName($name);
                $op->setTargetId($data['roleid']);
                $op->setStatusFrom('');
                $op->setStatusTo($permission);
                $op->setOperation($act);
                $op->setOpTime($this->getDateTime());
                $op = $accountBasicService->saveScanCardRbacOperationLog($op);
            }
            return $this->renderJsonSuccess($data);
        }        
        return $this->renderJsonFailed( Errors::$ERROR_UNKNOWN );
    }
    
    /**
     * 
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function putAction()
    {
        $request = $this->getRequest();
        $this->parse_raw_http_request($request);
        //检查token
        $this->checkAccount();
        if($this->accountType!==self::ACCOUNT_ADMIN)
        {
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        
        $roleId = $request->request->get("roleid");
        if (empty ( $roleId )) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH );
        }
        $act = $request->request->get('act');
        $operateId = $request->request->get('operateId');
        $adminService = $this->get ( "account_admin_service" );
        // 获取角色信息
        $role = $adminService->getRoleById ( $roleId );
        $permissionBefore = ($role->getPermission());

        if (! empty ( $role )) {
            $name = $request->request->get ( "name" );
            if (! empty ( $name )) {
                $role->setName ( $name );
            }
            $dispname = $request->request->get ( "dispname" );
            if (!empty($dispname))
            {
                $role->setDisplayName($dispname);
            }
            $permission = $request->request->get("permission");
            if (!empty($permission))
            {
                $role->setPermission($permission);
            }
            $status = $request->request->get('status');
            if (!empty($status)) {
                $role->setStatus($status);
            }
            $adminService->saveRole($role);
            if($act){
                $accountBasicService = $this->get('scancard_pic_service');
                $op = new ScanCardRbacOperationLog();
                $op->setOperateId($operateId);
                $op->setTargetName($name);
                $op->setTargetId($roleId);
                $op->setStatusFrom($permissionBefore);
                $op->setStatusTo($permission);
                $op->setOperation($act);
                $op->setOpTime($this->getDateTime());
                $op = $accountBasicService->saveScanCardRbacOperationLog($op);
            }
            return $this->renderJsonSuccess();
        }
        else{
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
        }
       
        
    }

    public function getAction()
    {
        $request = $this->getRequest ();
        // 检查token
        $this->checkAccount ();
        if($this->accountType!==self::ACCOUNT_ADMIN)
        {
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        
    
        $sqldata = $this->loadSqlConfig();
        $sqldata['fields']['status'] = array('mapdb' => 'status' , 'w' => 'AND status = :status');
        $sqldata['provide_max_fields'] = $sqldata['provide_max_fields'].',status';
        $check = $this->parseSql($sqldata);
        if(true !== $check)
        {
            return $this->renderJsonFailed($check);
        }
        $this->setParam('function', __FUNCTION__);
        // print_r($sqldata);
        $data = $this->getData($sqldata,'groups');
        //print_r($data);
        return $this->renderJsonSuccess ( $data );
    }
    /**
     * 角色删除
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function deleteAction()
    {
        $request = $this->getRequest();
        //检查token
        $this->checkAccount();
        if($this->accountType!==self::ACCOUNT_ADMIN)
        {
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $roleId = $request->get ( "roleid" );
        $act  = $request->get('act');
        $operateId = $request->get('operateId');
        if (empty ( $roleId )) {
            return $this->renderJsonFailed( Errors::$ERROR_PARAMETER_NOT_ENOUGH );
        }
        $adminService = $this->get ( "account_admin_service" );
        $role = $adminService->getRoleById ( $roleId );
        $permissionBefore = ($role->getPermission());
        $name = ($role->getName());
        $adminService = $this->get ( "account_admin_service" );
        $adminObject = $adminService->findEmployee(array('roleId'=>$roleId));
        if(!empty($adminObject)){
            return $this->renderJsonFailed( Errors::$ERROR_SUB_EXISTS ,'account');
        }
        
        
        
        $result = $adminService->deleteRole ( $roleId );
        if (false !== $result) {
            if($act){
                $accountBasicService = $this->get('scancard_pic_service');
                $op = new ScanCardRbacOperationLog();
                $op->setOperateId($operateId);
                $op->setTargetName($name);
                $op->setTargetId($roleId);
                $op->setStatusFrom($permissionBefore);
                $op->setStatusTo('');
                $op->setOperation($act);
                $op->setOpTime($this->getDateTime());
                $op = $accountBasicService->saveScanCardRbacOperationLog($op);
            }
            return $this->renderJsonSuccess();
        }
        return $this->renderJsonFailed( Errors::$ERROR_UNKNOWN );
    }
}
