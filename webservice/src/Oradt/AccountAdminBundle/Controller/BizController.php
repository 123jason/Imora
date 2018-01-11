<?php  
namespace Oradt\AccountAdminBundle\Controller;
use Oradt\Utils\Errors;
use Oradt\Utils\Password;
use Oradt\Utils\RandomString;
use Oradt\OauthBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use PDO;
use Oradt\Utils\Codes; 

/**
* 企业信息 
* 2017-10-24
*/
class BizController extends BaseController{

	/**
	 * POST
	 */
	public function postAction($act)
	{ 
		switch ($act) { 
		    case 'login': 
		        return $this->_login();
		        break;
		    case 'status':
		        return $this->_status();
		    case 'employeepassword':
		        return $this->_employeePassword();
		        break;
		    case 'employeestatus':
		        return $this->_employeestatus();
		        break;
		    
			default:
				return $this->renderJsonFailed(Errors::$HTTP_STATUS_CODE_404);
				break;
		}
	}
	/**
	 * 管理员登录
	 */
	public function _login()
	{
	    $this->accesstime = $this->getTimestamp1();
	    $request = $this->getRequest();
	    
	    $username = $this->strip_tags( $request->get('user') );//email
	    $password = $this->strip_tags( $request->get('passwd') ); 
	    $ip = $this->strip_tags( $request->get('ip', '::1') );
	    $this->accountId = $username;
	    
 	    if (empty($username) || empty($password) ) {
	        return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
	    }
	    
	    $oauthService = $this->container->get('oauth_service');
	    //查询账户是否存在 
	    $userInfo = $oauthService->getLoginToken($username, $password, "admin", $ip);
 
	    if( empty($userInfo) ){
	        return $this->renderJsonFailed(Errors::$ERROR_ACCOUNT_NOEXISTS);
	    }
	    //用户名错误
 
	    if ($userInfo == '-1') {  
	        return $this->renderJsonFailed(Errors::$OAUTH_ERROR_USER_NAME);
	    }elseif(is_array($userInfo) && isset($userInfo['error']) && -2 == $userInfo['error']){
	        return $this->renderJsonFailed(Errors::$OAUTH_ERROR_USER_PWD); 
	    }elseif ('-5' == $userInfo) { 
	        return $this->renderJsonFailed(Errors::$ACCOUNT_BIZ_USER_INACTIVE); 
        } elseif ('-3' == $userInfo) { 
            return $this->renderJsonFailed(Errors::$ACCOUNT_BIZ_USER_DELETED); 
        } 
        //设置session的数组
        $token = array( 
            'accesstoken' => $userInfo['token'],
            'expiration' => Codes::TOKEN_EXPIRE_TIME,
            'accountstate' => $userInfo['status'],
            'clientid' => $userInfo['accountId'], 
            'created_time'=> $userInfo['created_time'] - Codes::TOKEN_EXPIRE_TIME
        );
        return $this->renderJsonSuccess($token); 
	
	}
	/**
	 * 启用和禁用企业
	 */
	public function _status(){
	    $this->checkAccount();
	    $request = $this->getRequest();
	     
	    $bizid = $this->strip_tags( $request->get('id') );// 
	    $status = $this->strip_tags( $request->get('status') );//  状态 limited:待激活，active:可使用，blocked锁定，deleted：以删除,.
	  
	    if (empty($bizid) ||empty($status) ||!in_array($status, ["limited","active","blocked","deleted","inactive"])) {
	        return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
	    }
	  
	    $em = $this->getDoctrine()->getManager(); //添加事物
	    $em->getConnection()->beginTransaction();
	
	    try {
	        $wx_biz_service = $this->container->get('wx_biz_service');
	        $bizids = explode(',', $bizid);
	        
	        $modifyTime = $this->getTimestamp();
	        if (1 == count($bizids)) { 
 
	            $bizObj = $this->getDoctrine()->getRepository('OradtStoreBundle:WxBiz')->findOneBy( array('id'=>$bizid));
	          
	            if (empty($bizObj)) {
	                return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
	            } 
	            $bizObj->setStatus($status);
	            $bizObj->setModifyTime($modifyTime); 
	            $em->persist($bizObj);
	            $em->flush(); 
	            
	            $_bizId=$bizObj->getBizId();
	            if($status=="active"){//恢复数据 
	                $wx_biz_service->bizRecover($_bizId);
	            }else{//注销信息
	                $list=$wx_biz_service->bizCancel($_bizId);
	            }
	       
	            $returnArr = array( 'Id'=>$bizid);          //返回数组
	        }else{//批量
	            $fail   = $succ = array();
	     
	            foreach ($bizids as $_bizid){
	                $_bizObj = $this->getDoctrine()->getRepository('OradtStoreBundle:WxBiz')->findOneBy( array('id'=>$_bizid)); 
	                if (empty($_bizObj)) {
	                    $fail[]=$_bizid;continue;
	                }
	                $_bizObj->setStatus($status);
	                $_bizObj->setModifyTime($modifyTime);
	                $em->persist($_bizObj);
	                $em->flush();
	                
	                $succ[]=$_bizid;
	                $_bizId=$_bizObj->getBizId();
	                if($status=="active"){//恢复数据
	                    $wx_biz_service->bizRecover($_bizId);
	                }else{//注销信息
	                    $list=$wx_biz_service->bizCancel($_bizId);
	                }
	            }  
	            $returnArr = array( 'succ'=>$succ,'fail'=>$fail);
	        }
	        $em->getConnection()->commit(); 
	        return $this->renderJsonSuccess($returnArr) ;
	    } catch (\Exception $ex) {
	        $em->getConnection()->rollback();
	        throw $ex;
	    }
	}
	/**
	 * 修改密码
	 */
	public function _employeePassword(){
	    $this->checkAccount();
	    $request = $this->getRequest(); 
	    $id = $this->strip_tags( $request->get('id') );//
	    $password = $this->strip_tags( $request->get('password') );//
	    if (empty($id) ||empty($password)) {
	        return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
	    }
	    
	    $em = $this->getDoctrine()->getManager(); //添加事物
	    $em->getConnection()->beginTransaction();
	    
	    try {
	        $ids = explode(',', $id); 
	        $modifyTime = $this->getTimestamp();
	        if (1 == count($ids)) {
	    
	            $empObj = $this->getDoctrine()->getRepository('OradtStoreBundle:WxBizEmployee')->findOneBy( array('id'=>$id));
	    
	            if (empty($empObj)) {
	                return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
	            } 
	            $password  = Password::encrypt($password);
	            $empObj->setPasswd($password);
	            $empObj->setModifyTime($modifyTime);
	            $em->persist($empObj);
	            $em->flush(); 
	            $bizid=$empObj->getBizId();
	            $returnArr = array( 'id'=>$id,"bizid"=>$bizid);          //返回数组
	        }else{//批量
	            $fail   = $succ = array();
	    
	            foreach ($ids as $_id){
	                $empObj = $this->getDoctrine()->getRepository('OradtStoreBundle:WxBizEmployee')->findOneBy( array('id'=>$_id));
	                if (empty($empObj)) {
	                    $fail[]=$_id;continue;
	                }
	                $password  = Password::encrypt($password);
	                $empObj->setPasswd($password);
	                $empObj->setModifyTime($modifyTime);
	                $em->persist($empObj);
	                $em->flush(); 
	                 
	                $succ[]=$_id;
	            }
	            $returnArr = array( 'succ'=>$succ,'fail'=>$fail);
	        }
	        $em->getConnection()->commit();
	        return $this->renderJsonSuccess($returnArr) ;
	    } catch (\Exception $ex) {
	        $em->getConnection()->rollback();
	        throw $ex;
	    }
	}
	/**
	 * 启用和禁用员工
	 */
	public function _employeestatus(){
	    $this->checkAccount();
	    $request = $this->getRequest();
	
	    $id = $this->strip_tags( $request->get('id') );//
	    $status = $this->strip_tags( $request->get('status') );//  状态 limited:待激活，active:可使用，blocked锁定，deleted：以删除,.
	     
	    if (empty($id) ||empty($status) ||!in_array($status, ["limited","active","blocked","deleted","inactive"])) {
	        return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
	    }
	    $status_arr=["limited"=>-1,"active"=>1,"blocked"=>0,"deleted"=>3,"inactive"=>2];
	    $em = $this->getDoctrine()->getManager(); //添加事物
	    $em->getConnection()->beginTransaction();
	
	    try { 
	        $ids = explode(',', $id);
	        //$wx_biz_service = $this->container->get('wx_biz_service');
	        $modifyTime = $this->getTimestamp();
	        if (1 == count($ids)) {
	
	            $empObj = $this->getDoctrine()->getRepository('OradtStoreBundle:WxBizEmployee')->findOneBy( array('id'=>$id));
	             
	            if (empty($empObj)) {
	                return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
	            }
	            $empObj->setEnable($status_arr[$status]);
	            $empObj->setModifyTime($modifyTime);
	            $em->persist($empObj);
	            $em->flush();
	            
	           /*  $_bizId=$empObj->getBizId();
	           if($status=="active"){//恢复数据
	                    $wx_biz_service->bizRecover($_bizId,$id);
	             }else{//注销信息
	                    $wx_biz_service->bizCancel($_bizId,$id);
	            } */
	            
	            $returnArr = array( 'Id'=>$id);          //返回数组
	        }else{//批量
	            $fail   = $succ = array();
	
	            foreach ($ids as $_id){
	                $empObj = $this->getDoctrine()->getRepository('OradtStoreBundle:WxBizEmployee')->findOneBy( array('id'=>$_id));
	                if (empty($empObj)) {
	                    $fail[]=$_id;continue;
	                } 
	                $empObj->setEnable($status_arr[$status]);
	                $empObj->setModifyTime($modifyTime);
	                $em->persist($empObj);
	                $em->flush();
	                 
    	           /* $_bizId=$empObj->getBizId();
    	           if($status=="active"){//恢复数据
    	                 $wx_biz_service->bizRecover($_bizId,$_id);
    	            }else{//注销信息
    	                $wx_biz_service->bizCancel($_bizId,$_id);
    	            } */
	                
	                $succ[]=$_id;
	            }
	            $returnArr = array( 'succ'=>$succ,'fail'=>$fail);
	        }
	        $em->getConnection()->commit();
	        return $this->renderJsonSuccess($returnArr) ;
	    } catch (\Exception $ex) {
	        $em->getConnection()->rollback();
	        throw $ex;
	    }
	}
	/**
	 * get
	 */
	public function getAction($act)
	{
	    switch ($act) {
	        case 'getbizlist':
	            return $this->_getBizList();
	            break; 
	       case 'getemployeelist':
	            return $this->_getEmployeeList();
	            break; 
	       case 'getdepartmentlist':
	            return $this->_getBizDepartment();
	            break;
	        default:
	            return $this->renderJsonFailed(Errors::$HTTP_STATUS_CODE_404);
	            break;
	    }
	}
	/**
	 * @todo 获取企业列表信息 
	 */
	private function _getBizList()
	{
	    $this->checkAccount();
	    
	    $where   = " a.status!='deleted' ";
	    $sqldata = array(
	        'fields' => array(
	            'id'          => array('mapdb' => 'a.id' , 'w' => ' AND a.id = :id'),
	            'bizid'       => array('mapdb' => 'a.biz_id' , 'w' => ' AND a.biz_id = :bizid'),
	            'bizname'     => array('mapdb' => 'a.biz_name', 'w' => ' AND a.biz_name LIKE :bizname'),
	            'emp_count'     => array('mapdb' => 'b.emp_count'),
	            'card_count'     => array('mapdb' => 'c.card_count'),
	            'is_suite'     => array('mapdb' => 'd.id'),
	            'metaid'     => array('mapdb' => 'd.metaid', 'w' => ' AND d.metaid = :metaid'),
	            'suite_json'     => array('mapdb' => 'd.suite_json'),
	            'endtime'     => array('mapdb' => 'd.end_time','w' => 'Range'),
	            'address'     => array('mapdb' => 'a.biz_address'),
	            'bizemail'    => array('mapdb' => 'a.biz_email'),
	            'info'        => array('mapdb' => 'a.biz_info'),
	            'website'     => array('mapdb' => 'a.website'),
	            'logopath'    => array('mapdb' => 'a.logo_path'),
	            'bizsize'     => array('mapdb' => 'a.biz_size'),
	            'biztype'     => array('mapdb' => 'a.biz_type'),
	            'phone'       => array('mapdb' => 'a.phone'),
	            'contact'     => array('mapdb' => 'a.contact'),
	            'prespell'    => array('mapdb' => 'a.prespell'),
	            'wechatid'    => array('mapdb' => 'a.wechat_id'),
	            'wechatpath'  => array('mapdb' => 'a.wechat_path'),
	            'open'        => array('mapdb' => 'a.open_status', 'w' => ' AND a.open_status = :open'),
	            'status'      => array('mapdb' => 'a.status', 'w' => ' AND a.status = :status'),
	            'count'       => array('mapdb' => 'a.count'),
	            'createdtime' => array('mapdb' => 'a.created_time' , 'w' => 'Range'),
	            'modifytime'  => array('mapdb' => 'a.modify_time' , 'w' => 'Range'),
	            'qrcodetime'  => array('mapdb' => 'a.qrcode_time' , 'w' => 'Range'),
	        ),
	        'default_dataparam' => array(),
	        'sql'   => "SELECT %s FROM `wx_biz` as a
	                    left join ( select biz_id,count(1) as emp_count from wx_biz_employee where is_del=0 group by biz_id) as b on a.biz_id=b.biz_id 
	                    left join ( select biz_id,count(1) as card_count from wx_biz_card where STATUS = 'active'  group by biz_id) as c on a.biz_id=c.biz_id 
	                    left join  `wx_biz_suite_term`  d on a.biz_id=d.biz_id 
	                   %s%s
	                   ",
	        'where' => "".$where,
	        'order' => '',
	        'provide_max_fields' => 'id,bizid,bizname,emp_count,card_count,is_suite,suite_json,endtime,address,bizemail,info,website,logopath,bizsize,biztype,phone,contact,prespell,wechatid,wechatpath,open,status,count,createdtime,modifytime,qrcodetime',
	    );
	    $check = $this->parseSql($sqldata);
	    if(true !== $check){
	        return $this->renderJsonFailed($check);
	    }
	    $data = $this->getData($sqldata,'list');
	  
	    foreach ($data["list"] as  $key=>$value){ 
	        $suite_arr=json_decode($value["suite_json"],true) ;
	        $data["list"][$key]["suite_id"]=$suite_arr["id"];
	        $data["list"][$key]["suite_name"]=$suite_arr["name"];
	    }
	    return $this->renderJsonSuccess ( $data );
	}
	/**
	 * @todo 获取企业员工信息
	 */
	private function _getEmployeeList()
	{
	    $this->checkAccount(); 
        $where   = " a.is_del=0 ";
        $sqldata = array(
            'fields' => array(
                'id'          => array('mapdb' => 'a.id' , 'w' => ' AND a.id IN (%s)'),
                'bizid'       => array('mapdb' => 'a.biz_id' , 'w' => ' AND a.biz_id = :bizid'),
                'code'        => array('mapdb' => 'a.code'),
                'mobile'      => array('mapdb' => 'a.mobile', 'w' => ' AND a.mobile = :mobile'),
                // 'passwd'      => array('mapdb' => 'a.passwd'),
                'email'       => array('mapdb' => 'a.email','w' => ' AND a.email = :email'),
                'name'        => array('mapdb' => 'a.name','w' => ' AND a.name LIKE :name'),
                'superior'    => array('mapdb' => 'a.superior', 'w' => ' AND a.superior = :superior'),
                'department'  => array('mapdb' => 'a.department', 'w' => ' AND a.department = :department'),
                'department_name'       => array('mapdb' => 'b.name'),
                'enable'      => array('mapdb' => 'a.enable', 'w' => ' AND a.enable = :enable'),
                'openid'      => array('mapdb' => 'a.open_id', 'w' => ' AND a.open_id = :openid'),
                'unionid'     => array('mapdb' => 'a.union_id', 'w' => ' AND a.union_id = :unionid'),
                'roleid'      => array('mapdb' => 'a.role_id', 'w' => ' AND a.role_id = :roleid'),
                'import'      => array('mapdb' => 'a.import_status', 'w' => ' AND a.import_status = :import'),
                'refrom'      => array('mapdb' => 'a.re_from', 'w' => ' AND a.re_from = :refrom'),
                'createdtime' => array('mapdb' => 'a.created_time' , 'w' => 'Range'),
                'modifytime'  => array('mapdb' => 'a.modify_time' , 'w' => 'Range'),
                'avatarpath'  => array('mapdb' => 'a.avatar_path'),
                'identstatus' => array('mapdb' => 'a.ident_status', 'w' => ' AND a.ident_status = :identstatus'),
                'identtime'  => array('mapdb' => 'a.ident_time' , 'w' => 'Range'),
            ),
            'default_dataparam' => array(),
            'sql'   => "SELECT %s FROM `wx_biz_employee` as a 
                        LEFT JOIN wx_biz_department as b on a.department = b.id 
                         %s%s",
            'where' => "".$where,
            'order' => '',
            'provide_max_fields' => 'id,bizid,code,mobile,email,name,superior,department,department_name,enable,openid,unionid,roleid,import,refrom,createdtime,modifytime,identstatus,identtime',//passwd,
        );
        $check = $this->parseSql($sqldata);
        if(true !== $check){
            return $this->renderJsonFailed($check);
        }
        $data = $this->getData($sqldata,'list');        
        return $this->renderJsonSuccess ( $data );
	}
	
	/**
	 * @todo 获取部门
	 */
	public function _getBizDepartment()
	{
	    $this->checkAccount(); 
	    $where = "  a.is_del=0";
	    $sqldata = array(
	        'fields' => array(
	            'id'          => array('mapdb' => 'a.id' , 'w' => ' AND a.id IN (%s)'),
	            'bizid'       => array('mapdb' => 'a.biz_id' , 'w' => ' AND a.biz_id = :bizid'),
	            'parentid'    => array('mapdb' => 'a.parent_id', 'w' => ' AND a.parent_id = :parentid'),
	            'name'        => array('mapdb' => 'a.name', 'w' => ' AND a.name LIKE :name'),
	            'ename'       => array('mapdb' => 'a.ename', 'w' => ' AND a.ename = :ename'),
	            'status'      => array('mapdb' => 'a.status', 'w' => ' AND a.status = :status'),
	            'addid'       => array('mapdb' => 'a.add_id', 'w' => ' AND a.add_id = :addid'),
	            'createdtime' => array('mapdb' => 'a.created_time' , 'w' => 'Range'),
	            'modifytime'  => array('mapdb' => 'a.modify_time' , 'w' => 'Range'),
	        ),
	        'default_dataparam' => array(),
	        'sql'   => "SELECT %s FROM `wx_biz_department` as a  %s%s",
	        'where' => "".$where,
	        'order' => '',
	        'provide_max_fields' => 'id,bizid,parentid,name,ename,status,addid,createdtime,modifytime',
	    );
	    $check = $this->parseSql($sqldata);
	    if(true !== $check){
	        return $this->renderJsonFailed($check);
	    }
	    $data = $this->getData($sqldata,'list');
	    return $this->renderJsonSuccess ( $data );
	}
	 
 
}

?>