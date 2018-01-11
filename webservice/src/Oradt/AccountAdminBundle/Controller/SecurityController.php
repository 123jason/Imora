<?php
namespace Oradt\AccountAdminBundle\Controller;
use Oradt\Utils\Codes;
use Oradt\Utils\Errors;
use Oradt\OauthBundle\Controller\BaseController;


class SecurityController extends BaseController
{   
    public function getAction()
    {
        $request = $this->getRequest ();        
        $sql = "select * from account_security";
        $data = $this->getManager('scandb')->getConnection()->executeQuery($sql)->fetchAll();
        
        return $this->renderJsonSuccess ( $data[0] );
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
        
        $param[':password_complexity'] = $this->strip_tags($request->get('password_complexity'));
        $param[':password_min_length'] = $this->strip_tags($request->get('password_min_length'));
        $param[':password_fail_times'] = $this->strip_tags($request->get('password_fail_times'));
        $param[':password_lock_duration'] = $this->strip_tags($request->get('password_lock_duration'));
        $param[':id'] = $this->strip_tags($request->get('security_id'));
        $sql = "update account_security set password_complexity = :password_complexity,password_min_length=:password_min_length,password_fail_times=:password_fail_times,password_lock_duration=:password_lock_duration where id=:id";
        $result = $this->getManager('scandb')->getConnection()->executeUpdate($sql, $param);
        return $this->renderJsonSuccess();
    }

    
}
