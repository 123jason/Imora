<?php
namespace Oradt\WeixinBizBundle\Controller;
use Oradt\OauthBundle\Controller\BaseController;
use Oradt\Utils\Tables;
use Symfony\Component\HttpFoundation\Response;
use Oradt\Utils\PhpZip;
use Oradt\Utils\Password;
use Oradt\Utils\Errors;
use Oradt\Utils\Codes;
use Oradt\Utils\RandomString;
use Oradt\StoreBundle\Entity\WxBiz;
use Oradt\StoreBundle\Entity\WxBizEmployee;
use Oradt\StoreBundle\Entity\WxBizDepartment;
use PDO;
/**
 * @var 企业相关联接口类
 * @version 0.0.1
 * @author xinggm 
 */
class WxBizController extends BaseController
{ 
    public function postAction($act)
    { 
        switch ($act) {
            case 'regist':
                return $this->_bizRegister();   //企业注册
                break;
            case 'edit':
                return $this->_bizEdit();       //企业修复
                break;
            case 'bizrename':
                return $this->_bizrename();   //企业名是否重名
                break;
            case 'bizcancel':
                return $this->_bizcancel();   //企业名注销
                break;
            case 'addemp':
                return $this->_bizAddOrEditEmployee(1); //添加员工
                break;
            case 'editemp':
                return $this->_bizAddOrEditEmployee(2); //修改员工
                break;
            case 'empscan':
                return $this->_bizScanAddOrEditEnployee();//扫描二维码添加员工
                break;
            case 'depart':
                return $this->_bizAddOrEditDepart(1);   //添加部门
                break;
            case 'edpart':
                return $this->_bizAddOrEditDepart(2);   //修改部门
                break;
            case 'delpart':
                return $this->_bizAddOrEditDepart(3);   //删除部门
                break;
            case 'import':
                return $this->bizImportEmployee();      //批量导入
                break;
            case 'addbiztag':
                return $this->_addBizTag();
                break;
            case 'editbiztag':
                return $this->_editBizTag();
                break;
            case 'delbiztag':
                return $this->_delBizTag();
                break;
            case 'editpass':
                return $this->bizEditEmpPassword();     //修改密码
                break;
            case 'syncwxcardtobiz':
                return $this->syncwxcardtobiz();
                break;
            case 'addshare':
                return $this->_addShare();          //部门分享部门
                break; 
            default:
                return $this->renderJsonFailed(Errors::$HTTP_STATUS_CODE_404);
                break;
        }
    }
 

    /**
     * @todo 企业注册表
     * @var 2017-9-18(9.18,莫忘国耻)
     * @param string user 手机号
     * @param string password 密码
     * @param string mcode 国家代码
     * @param string company 企业名称
     * @return [json] [<status:0|1>]
    */
    private function _bizRegister()
    {
        $request  = $this->getRequest();
        $user     = $this->strip_tags($request->get('user'));        //账号：手机号
        $code     = $this->strip_tags($request->get('mcode',''));    //国家区号
        $password = $this->strip_tags($request->get('password'));    //密码
        $company  = $this->strip_tags($request->get('company'));     //企业名称
        $type     = $this->strip_tags($request->get('type'));        //注册类型1、手机2、邮箱
        $name     = $this->strip_tags($request->get('name'));        //注册人名
        $email    = $this->strip_tags($request->get('email'));       //企业邮箱     
        //微信注册   
        $openid    = $this->strip_tags($request->get('openid'));       //微信openid
 
        // 注册类型：1手机2邮箱
        if (empty($type) || !in_array($type, array(1,2))) {
            $type = 1;
        }
        if ( (1 == $type && empty($user)) || (2 == $type && empty($email)) || empty($password) || empty($company) ) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        /**
         * @todo 1、检验手机号是否准确
         */
        if (empty($code)) 
            $code = '86';
        $funcService = $this->get("function_service");
        $checkUser = $funcService->checkCountryMobile($code,$user);
        if (!$checkUser) {
            return $this->renderJsonFailed(Errors::$ERROR_MOBILE_FORMAT);
        }
        // 检验邮箱格式是否正常
        if (!empty($email)) {
            $checkEmail = $funcService->checkEmailAddr($email);
            if (!$checkEmail) {
                return $this->renderJsonFailed(Errors::$ERROR_EMAIL_FORMAT );
            }
        }
        /**
         * @todo 2、检验企业名称是否存在
         */
        //判断企业是否被注册
        $wxBiz = $this->getDoctrine()->getRepository('OradtStoreBundle:WxBiz')->findOneBy( array('bizName'=>$company));
        if($wxBiz){
            return $this->renderJsonFailed(Errors::$ERROR_SUB_EXISTS,"company name" );
        }
    
        $wxBizService = $this->container->get("wx_biz_service");
        if (1 == $type) {
            $res      = $wxBizService->checkUserIfExist($user,1,$code);
            if ($res) {
                return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_DATA_EXISTS);
            }    
        }else{
            $res      = $wxBizService->checkUserIfExist($email,2);
            if ($res) {
                return $this->renderJsonFailed(Errors::$ACCOUNT_BIZ_BOUND_EMAIL);
            }
        }
        /**
         * @todo 3、
         */
        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();        
        try {
            $createTime = $this->getTimestamp();
            $bizId      = RandomString::make(40,Codes::B);
            // 添加企业信息
            $wxbiz   = new WxBiz();
            $wxbiz->setBizId($bizId);
            $wxbiz->setBizName($company);
            $wxbiz->setBizaddress('');
            $wxbiz->setBizEmail($email);
            $wxbiz->setBizInfo('');
            $wxbiz->setWebsite('');
            $wxbiz->setLogoPath('');
            $wxbiz->setBizSize(0);
            $wxbiz->setBizType('');
            $wxbiz->setPhone('');
            $wxbiz->setContact('');
            $wxbiz->setPrespell('');
            $wxbiz->setWechatId('');
            $wxbiz->setWechatPath('');
            $wxbiz->setOpenStatus(1);
            $wxbiz->setCount(0);
            $wxbiz->setStatus('active');
            $wxbiz->setLogoPath('');
            $wxbiz->setCreatedTime($createTime);
            $wxbiz->setModifyTime(0);
            $wxbiz->setQrcodeTime(0);
            $wxbiz->setAddId(0);
            $em->persist($wxbiz);
            $em->flush();
            
            //微信注册
            if($openid){
                $weixinuser = $this->getDoctrine()->getRepository('OradtStoreBundle:WeixinUser')->findOneBy( array('wechatId'=>$openid));
                if($weixinuser){
                    if($weixinuser->getBizId()){
                        return $this->renderJsonFailed(Errors::$ERROR_SUB_EXISTS,"user in bizid ");
                    }
                    $params['openid']=$weixinuser->getWechatId();
                    $params['unionid']=$weixinuser->getUnionId(); 
                }
            }
            // 添加员工登录信息
            $params['bizid']  = $bizId;
            $params['mobile'] = $user;
            $params['code']   = $code;
            $params['password'] = $password;
            $params['email']    = $email;
            $params['name']     = $name;
            $params['enable']   = 1;
            $params['roleid']   = 1;
            $params['import']   = 1;
            $params['from']     = 1;
            // 添加员工
            $returnArr = $wxBizService->insertIntoEmployee($params);
            
            //微信注册
            if($openid&&$weixinuser){   
                $weixinuser->setBizId($bizId);
                $em->persist($weixinuser);
                $em->flush();
                //员工绑定的企业
                $wechatService = $this->container->get("wechat_service");
                $wechatService->updateBizByWechatid($bizId,$openid);
                //微信公众号绑定员工
                $account["unionid"]=$weixinuser->getUnionId();
                $account["wechatid"]=$weixinuser->getWechatId();
                $account["mobile"]=$params['mobile'];
                $wxBizService->insertIntoCommon('wechat', $returnArr["empid"], $account,$createTime);
            }
            
            // 修改到企业信息addid
            $wxBizService->updateBizAddId($returnArr["bizid"],$returnArr["empid"]);
            
            //套餐购买(是否有赠送套餐)
            $wxBizPaymentService = $this->get("wx_biz_payment_service"); 
            $gift_suite=$wxBizPaymentService->getSystemConfig("SUITE_FREE_ID");
            if(!empty($gift_suite)){   
                $pay_res=$wxBizPaymentService->newpurchase(1, 4,$gift_suite["option_value"],$bizId,$returnArr["empid"],2,0,'');
                $returnArr["pay"]=$pay_res;
            }
            
            $em->getConnection()->commit();
            return $this->renderJsonSuccess($returnArr);
        } catch (\Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }
    }
    /**
     * @todo 修改企业信息
     * @var 2017-9-19
     * @param [type] $[name] [<description>]
     */
    private function _bizEdit()
    {
        $this->checkAccountV2();
        $bizId    = $this->bizId;
        $empid    = $this->accountId;
        $request  = $this->getRequest();
        $address  = $this->strip_tags($request->get('address'));           // 公司地址
        $email    = $this->strip_tags($request->get('email'));             //公司邮箱
        $info     = $this->strip_tags($request->get('info'));              //企业详情
        $website  = $this->strip_tags($request->get('website'));           //企业网址
        $logo     = $this->strip_tags($request->get('logo'));              //企业logo
        $size     = $this->strip_tags($request->get('size'));              //公司规模
        $type     = $this->strip_tags($request->get('type'));              //企业性质
        $phone    = $this->strip_tags($request->get('phone'));             //联系电话
        $contact  = $this->strip_tags($request->get('contact'));           //联系人
        $wechatid = $this->strip_tags($request->get('wechatid'));          //企业微信id
        $wepath   = $this->strip_tags($request->get('wechatpath'));        //二维码地址
        $open     = (int)$this->strip_tags($request->get('open'));         //开启状态
        $status   = $this->strip_tags($request->get('status'));            //企业状态
        $count    = (int)$this->strip_tags($request->get('count'));        //员工数量
        
        if (empty($bizId) || empty($empid)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_DATA_EXISTS);
        }
        //检验企业
        $bizObj = $this->getDoctrine()->getRepository('OradtStoreBundle:WxBiz')->findOneBy( array('bizId'=>$bizId));
        if (empty($bizObj)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
        }
        //检验员工
        $empObj = $this->getDoctrine()->getRepository('OradtStoreBundle:WxBizEmployee')->findOneBy( array('id'=>$empid));
        if (empty($empObj)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
        }
        $roleid = $empObj->getRoleId();
        // 检验员工权限是：超级管理员，管理员
        if (!in_array($roleid, array(1,2))) {
            return $this->renderJsonFailed(Errors::$ERROR_NOT_HAVE_PERMISSION );//没有允许
        }
        if (!empty($open) && !in_array($open, array(1,2))) {
            $open = $bizObj->getOpenStatus();
        }
        if (!empty($status) && !in_array($status, array('active','inactive','limited','blocked'))) {
            $status = $bizObj->getStatus();
        }
        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();        
        try {
            $modifyTime = $this->getTimestamp();
            if (!empty($address)) 
                $bizObj->setBizaddress($address);
            if (!empty($email)) 
                $bizObj->setBizEmail($email);
            if (!empty($info)) 
                $bizObj->setBizInfo($info);
            if (!empty($website)) 
                $bizObj->setWebsite($website);
            if (!empty($logo)) 
                $bizObj->setLogoPath($logo);
            if (!empty($size)) 
                $bizObj->setBizSize(intval($size));
            if (!empty($type)) 
                $bizObj->setBizType(intval($type));
            if (!empty($phone)) 
                $bizObj->setPhone($phone);
            if (!empty($contact)) 
                $bizObj->setContact($contact);
            if (!empty($wechatid)) 
                $bizObj->setWechatId($wechatid);
            if (!empty($wepath)) {
                $bizObj->setWechatPath($wepath);
                $bizObj->setQrcodeTime($modifyTime);
            }
            if (!empty($open)) 
                $bizObj->setOpenStatus($open);
            if (!empty($count)) 
                $bizObj->setCount($count);
            if (!empty($status)) 
                $bizObj->setStatus($status);
            $bizObj->setModifyTime($modifyTime);
            $em->persist($bizObj);
            $em->flush();           
            $em->getConnection()->commit();
            return $this->renderJsonSuccess();
        } catch (\Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }
    }
    //判断企业是否被注册
    private function _bizrename(){
        $request  = $this->getRequest();
        $company  = $this->strip_tags($request->get('company'));     //企业名称
        if(empty($company)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $wxBiz = $this->getDoctrine()->getRepository('OradtStoreBundle:WxBiz')->findOneBy( array('bizName'=>$company,'status'=>"active"));
        if($wxBiz){
            $res["biz_id"]=$wxBiz->getBizId();
            /* $res=Errors::$ERROR_PARAMETER_DATA_EXISTS;

            return $this->renderJsonFailed($res);  */
            return $this->renderJsonSuccess($res);
        }else{
            return $this->renderJsonSuccess();
        } 
    }
    //企业注销
    private function _bizcancel(){
        $request  = $this->getRequest();
        $this->checkAccountV2();
        $userId =  $this->accountId;
        $roleId=$this->roleId;//操作人权限
        $bizId    = $this->bizId;
        $biz_id  = $this->strip_tags($request->get('biz_id'));     //企业 ID
        if(empty($biz_id)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        if($bizId!=$biz_id){//只能注销自己的企业
            return $this->renderJsonFailed(Errors::$ACCOUNT_BIZ_EMP_NOTSELF);
        }
        if($roleId!=1){//不是超级管理员，只有超级管理员才能注销企业
            return $this->renderJsonFailed(Errors::$ERROR_NOT_HAVE_PERMISSION);
        } 
        $wxBiz = $this->getDoctrine()->getRepository('OradtStoreBundle:WxBiz')->findOneBy( array('bizId'=>$biz_id,'status'=>"active"));
        if($wxBiz){ 
            $wx_biz_service = $this->container->get('wx_biz_service');
            $res=$wx_biz_service->bizCancel($biz_id);
            return $this->renderJsonSuccess();
        }else{
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA); 
        } 
    }

    private function _bizAddOrEditEmployee($type)
    {
        $this->checkAccountV2();
        $userId =  $this->accountId;
        $roleId=$this->roleId;//操作人权限
        $bizId    = $this->bizId;     
        $request  = $this->getRequest();
        $params   = array();
        $params['mobile']    = $this->strip_tags($request->get('mobile'));           //账号：手机号
        $params['code']      = $this->strip_tags($request->get('mcode'));            //国家区号
        $params['password']  = $this->strip_tags($request->get('password'));         //密码
        // $bizId    = $this->strip_tags($request->get('bizid'));                    //企业id
        $params['name']      = $this->strip_tags($request->get('name'));             //员工人名
        $params['enable']    = (int)$this->strip_tags($request->get('enable'));      //员工起始状态
        $params['openid']    = $this->strip_tags($request->get('openid'));           //微信id
        $params['unionid']   = $this->strip_tags($request->get('unionid'));          //唯一id
        $params['email']     = $this->strip_tags($request->get('email'));            //邮箱
        $params['superior']  = (int)$this->strip_tags($request->get('superior'));    //上级
        $params['depart']    = (int)$this->strip_tags($request->get('depart'));      //部门
        $params['import']    = (int)$this->strip_tags($request->get('import'));      //导入开关
        $params['from']      = (int)$this->strip_tags($request->get('from'));        //来源1后台添加2自己注册 
        $params['roleid']    = (int)$this->strip_tags($request->get('roleid'));      //角色id
        $params['identstatus']= (int)$this->strip_tags($request->get('identstatus'));//员工认证状态
        $params['bizid'] = $bizId;
        $wxBizService = $this->container->get('wx_biz_service');
        // 管理员不能添加/修改  管理员和超级管理员
        if(!empty($params['roleid'])&&$roleId>1&&in_array($params['roleid'],array(1,2) )){
            return $this->renderJsonFailed(Errors::$ERROR_NOT_HAVE_PERMISSION);
        }
        //判断上级是否属于自己
        if (0 != $params['superior']) {
            $res = $wxBizService->checkUserIfExist($params['superior'],3,$bizId);
            if (empty($res)) {
                return $this->renderJsonFailed(Errors::$ERROR_NOTEXISTS,'superior');
            }
        }
        //判断部门是否属于自己
        if (0 != $params['depart']) {
            $res = $wxBizService->checkDepartByParentid($bizId,$params['depart']);
            if (empty($res)) {
                return $this->renderJsonFailed(Errors::$ERROR_NOTEXISTS,'depart');
            }
        }
        /**
         * @todo 1、添加员工2、修改员工
         */
        if (1 == $type) {
            // 添加方法
            $params['userid'] = $userId;
            $res = $this->_bizAddEmployee($params);
        }else{
            $params['id']    = $this->strip_tags($request->get('empid'));      //角色id
            $params['batch']     = $this->strip_tags($request->get('batch'));  //批量修改
            // 修改方法
            $res = $this->_bizEditEmployee($params);
        }
        return $this->renderJsonSuccess($res);
    }

    /**
     * @todo 扫描二维码：1、已有的账号改为正常2、未存在的保存为未认证
     * @return [type]
     */
    private function _bizScanAddOrEditEnployee()
    {
        $request   = $this->getRequest();
        $id_biz    = (int)$request->get('bizid');    //企业自增id
        $params   = array();
        $params['mobile']    = $this->strip_tags($request->get('mobile'));           //账号：手机号
        $params['code']      = $this->strip_tags($request->get('mcode'));            //国家区号
        $params['password']  = $this->strip_tags($request->get('password'));         //密码
        // $bizId    = $this->strip_tags($request->get('bizid'));                    //企业id
        $params['name']      = $this->strip_tags($request->get('name'));             //员工人名
        $params['enable']    = (int)$this->strip_tags($request->get('enable'));      //员工起始状态
        $params['openid']    = $this->strip_tags($request->get('openid'));           //微信id
        $params['unionid']   = $this->strip_tags($request->get('unionid'));          //唯一id
        $params['email']     = $this->strip_tags($request->get('email'));            //邮箱
        if (empty($params['mobile']) || empty($id_biz)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        /**
         * @todo 验证企业id是否存在
         */
        $wxBizService = $this->container->get('wx_biz_service');
        $biz_Info = $wxBizService->getBizInfoByID($id_biz);
        if (empty($biz_Info)) {
            return $this->renderJsonFailed(Errors::$ERROR_NOTEXISTS,'biz');
        }
        $bizid = isset($biz_Info['biz_id'])?$biz_Info['biz_id']:'';
        $params['bizid'] = $bizid;
        /**
         * @todo 验证手机是否存在 1、不存在新增2、存在修改为认证
         */
        if (empty($params['code'])) {
            $params['code'] = '86';
        }
        $res   = $wxBizService->checkUserIfExist($params['mobile'],1,$params['code']);
        if (empty($res)) {
            // 新增自己注册
            $params['from'] = 2;  //来源自己注册2
            $params['enable'] = 2;//待认证
            $params['userid'] = '';//系统消息中的sender，此情况为空
            $res = $this->_bizAddEmployee($params);
        }else{
            $from = isset($res['re_from'])?$res['re_from']:1;
            // 来源
            if (2 == $from) {
                return $this->renderJsonFailed(Errors::$ACCOUNT_BIZ_CONNOT_IDENT);
            }
            // 修改为认证
            $params['id']     = isset($res['id'])?$res['id']:0;
            $params['enable'] = 1;//修改为正常
            $res = $this->_bizEditEmployee($params);
        }
        return $this->renderJsonSuccess($res);
    }

    /**
     * @todo 企业添加员工
     * @var  有企业自己添加和员工扫描企业二维码后添加  2017-9-18 
     * @param string $mobile 手机号码 string $mcode 国家区号 string $password 密码 string $name 员工名称 string $bizid 企业ID int    $enable 员工状态 string $openid 员工微信id string $unionid 微信唯一id string $email 邮箱 string $superior 上级 string $department 部门 int $import 是否开启导入功能1开启2不开启 int $from 来源1、后台企业添加2、自己微信扫描添加
     * @return json 成功OR失败
     * @version 0.0.2 -- 2017-9-20
     */
    public function _bizAddEmployee($params)
    {
        if (empty($params['from']) || !in_array($params['from'], array(1,2))) 
            $params['from'] = 1;
        $wxBizService = $this->container->get('wx_biz_service');
        $res      = $wxBizService->insertIntoEmployee($params);
        // 判断返回结果
        if (is_array($res)) {
            return $res;
        }else if (1 == $res) {
            // 参数不够
            $data = $this->getFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
            $this->outputJson($data);
        }else if (2 == $res) {
            // 手机存在
            $data = $this->getFailed(Errors::$ERROR_PARAMETER_DATA_EXISTS);
            $this->outputJson($data);
        }else{
            $data = $this->getFailed(Errors::$OAUTH_ERROR_UNKNOWN);
            $this->outputJson($data);
        }
    }
    /**
     * @todo 修改员工信息  
     * @var  2017-9-19     
     * @param array $params
     * @return             
     * @version 0.0.1      
     */
    public function _bizEditEmployee($params)
    {
        if (empty($params['id'])) {
            $data = $this->getFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
            $this->outputJson($data);
        }
        // 判断是不是批量操作
        if (1 == $params['batch']) {
            $resArr = $this->_bizBatchEditEmp($params);
            return $resArr; 
        }        
        // 检验员工是否
        $empObj = $this->getDoctrine()->getRepository('OradtStoreBundle:WxBizEmployee')->findOneBy( array('id'=>$params['id'],'bizId'=>$params['bizid']));
        if (empty($empObj)) {
            $data = $this->getFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
            $this->outputJson($data);
        }
         
        $old_roleid = $empObj->getRoleId();
        $roleId=$this->roleId;//操作人权限 
        // 管理员不能添加/修改  管理员和超级管理员
        if($roleId>1&&in_array($old_roleid,array(1,2) )){ 
            $this->outputJson($this->getFailed(Errors::$ERROR_NOT_HAVE_PERMISSION));
        }
        
        $wxBizService = $this->container->get('wx_biz_service');
        /*// roleid 角色，检验修改角色为普通时候判断还有没有其他管理员角色 
        if (isset($params['roleid']) && ($old_roleid < 3) && 3 == intval($params['roleid']) ) {
            $check_roleid = $wxBizService->checkIfLastOneRole($params['id'],$params['bizid']);
            if (0 == $check_roleid) {
                $data = $this->getFailed(Errors::$WX_BIZ_ERROR_ROLE_LAST);
                $this->outputJson($data);
            }
        }  */
       
        if (isset($params['roleid']) && ($old_roleid==1) &&  intval($params['roleid'])>1 ) {
            $check_roleid = $wxBizService->checkIfLastOneSuperRole($params['id'],$params['bizid']); //判断是否还有超级管理员(系统至少需要一个管理员)
            if (0 == $check_roleid) {
                $data = $this->getFailed(Errors::$WX_BIZ_ERROR_ROLE_LAST);
                $this->outputJson($data);
            }
        }
        //邮箱是否存在
       /*  $empArr=$wxBizService->checkUserIfExist($params['email'],2 );
        if($empArr){
            $empObj_email=$empObj->getEmail();
            if($empArr["email"]!=$empObj_email){
                $data = $this->getFailed(Errors::$DESIGN_ERROR_EMAIL);
                $this->outputJson($data);
            }
        } */
        
        if (isset($params['enable']) && !empty($params['enable']) && !in_array($params['enable'], array(1,2,3,4))) 
            $params['enable']  = $empObj->getEnable() ;
        if (isset($params['import']) && !empty($import) && !in_array($params['import'], array(1,2))) 
            $params['import']  = $empObj->getImport();
        if (isset($params['roleid']) && !empty($param['roleid']) && !in_array($params['roleid'], array(1,2,3))) 
            $params['roleid']  = $empObj->getRoleId();
        $old_ident_status = $empObj->getIdentStatus();
        if (isset($params['identstatus']) && !empty($params['identstatus']) && !in_array($params['identstatus'], array(1,2)) ) {
            $params['identstatus'] = $old_ident_status;
        }
        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();        
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
                if (3 === $params['enable'] && 3 != $empObj->getEnable()) {
                    $empObj->setBak("");//清空备注
                    $empObj->setAccountNo("");
                    $check_roleid = $wxBizService->checkIfLastOneSuperRole($params['id'],$params['bizid']); //判断是否还有超级管理员(系统至少需要一个管理员)
                    if (0 == $check_roleid) {
                        $data = $this->getFailed(Errors::$WX_BIZ_ERROR_ROLE_LAST);
                        $this->outputJson($data);
                    }
                    // 如果员工离职需要清除common记录
                    $wxBizService->dealWithCommonByEmpid($params['id']);
                }
                $empObj->setEnable($params['enable']);
                $old_enable = $empObj->getEnable();
            }            
            if (!empty($params['openid'])) 
                $empObj->setOpenId($params['openid']);
            if (!empty($params['unionid'])) 
                $empObj->setUnionId($params['unionid']);
            if (!empty($params['roleid'])){ 
                $empObj->setRoleId($params['roleid']);
                $accountNo = $empObj->getAccountNo();
                $wxBizService->dealWithLoginSession($accountNo); //删除登录信息
            }
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
            $em->persist($empObj);
            $em->flush();            
            $em->getConnection()->commit();
            $returnArr = array( 'empid'=>$params['id']);          //返回数组
            return $returnArr;
        } catch (\Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }
    }
    /**
     * @todo 批量修改：部门，状态
     * @param  array $params 
     * @return array
     */
    public function _bizBatchEditEmp($params)
    {
        $empid  = $params['id'];
        $empids = explode(',', $empid);
        $fail   = $succ = array();
        if (1 == count($empids)) {
            $params['batch'] = 0;
            $resArr = $this->_bizEditEmployee($params);
            return $resArr;
        }

        $wxBizService = $this->container->get('wx_biz_service');
        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();       
        //批量修改员工 
        try {
            $modifyTime = $this->getTimestamp();
            // 添加员工登录信息
            foreach ($empids as $eid) {
                if (empty($eid)) 
                    continue ;
                $empObj = $this->getDoctrine()->getRepository('OradtStoreBundle:WxBizEmployee')->findOneBy( array('id'=>$eid,'bizId'=>$params['bizid']));
                if (empty($empObj)) {
                    $fail[] = $eid;  continue ;
                }

                $old_roleid=$empObj->getRoleId();
                $roleId=$this->roleId;//操作人权限
                // 管理员不能添加/修改  管理员和超级管理员
                if($roleId>1&&in_array($old_roleid,array(1,2) )){
                   $fail[] = $eid;  continue ;
                }
                if (isset($params['depart']) && !empty($params['depart']) ) {
                    $empObj->setDepartment(intval($params['depart']));
                }
                if (isset($params['enable']) && !empty($params['enable'])) { 
                    $check_roleid = $wxBizService->checkIfLastOneSuperRole($eid,$params['bizid']); //判断是否还有超级管理员(系统至少需要一个管理员) 
                    if (0 == $check_roleid) { 
                        $fail[] = $eid;  continue ;
                    }
                    if (3 === $params['enable'] && 3 != $empObj->getEnable()) {
                        $empObj->setBak("");
                        // 如果员工离职需要清除common记录
                        $wxBizService->dealWithCommonByEmpid($eid);
                    }
                    $empObj->setEnable(intval($params['enable']));
                }
                $empObj->setModifyTime($modifyTime);
                $em->persist($empObj); 
                $em->flush();
                $succ[] = $eid;
            }
            $em->getConnection()->commit();
            $returnArr = array( 'fail'=>$fail,'succ'=>$succ);          //返回数组
            return $returnArr;
        } catch (\Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }
            
    }
    /**
     * @todo 添加修改部门公共方法
     * @param  $type 1、添加2、修改
     * @return [type]
     */
    private function _bizAddOrEditDepart($type)
    {
        $this->checkAccountV2();
        $bizId = $this->bizId;
        $empid = $this->accountId;
        // 验证员工权限
        $empObj=  $this->getDoctrine()->getRepository('OradtStoreBundle:WxBizEmployee')->findOneBy( array('id'=>$empid));
        if (empty($empObj)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
        }
        $roleid   = $empObj->getRoleId();
        if (empty($roleid) || !in_array($roleid, array(1,2))) {
            return $this->renderJsonFailed(Errors::$ERROR_NOT_HAVE_PERMISSION);
        }
        $params   = array();
        $request  = $this->getRequest();
        $params['parentid']  = $this->strip_tags($request->get('parentid'));      //账号：父级
        $params['name']      = $this->strip_tags($request->get('name'));          //部门名称
        $params['ename']     = $this->strip_tags($request->get('ename'));         //部门名称
        $params['addid']     = $this->strip_tags($request->get('addid'));         //员工人名
        $params['status']    = (int)$this->strip_tags($request->get('status'));   //开启状态1开启2关闭
        /**
         * @todo 根据type处理参数
         */
        if (1 == $type) {
            $res = $this->_bizAddDepartment($params);
        }else if (2 == $type) {
            $params['departid'] = $this->strip_tags($request->get('departid'));
            $res = $this->_bizEditDepartment($params);
        }else{
            $params['departid'] = $this->strip_tags($request->get('departid'));
            $params['type']     = $type;
            $res = $this->_bizEditDepartment($params);
        }
        return $this->renderJsonSuccess($res);
    }
    /**
     * @todo  添加部门
     * @param  array $params 部分参数
     * @return json
     */
    private function _bizAddDepartment($params)
    {
        $bizId = $this->bizId;
        $empid = $this->accountId;
        $request  = $this->getRequest();
        if (empty($params['name'])) {
            $data = $this->getFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
            $this->outputJson($data);
        }
        if (empty($params['addid'])) 
            $params['addid']  = $empid;
        /**
         * @todo 验证name是否存在
         * @var [type]  
         */
        $wxBizService = $this->container->get('wx_biz_service');
        $result = $wxBizService->checkDepartByBizAndName($bizId,$params['name']);
        if ($result) {
            $data = $this->getFailed(Errors::$ERROR_PARAMETER_DATA_EXISTS);
            $this->outputJson($data);
        }
        /**
         * @todo parentid 有值验证是否存在
         */
        if (!empty($params['parentid'])) {
            $res_parent = $wxBizService->checkDepartByParentid($bizId,$params['parentid'] );
            if (empty($res_parent)) {
                $data = $this->getFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
                $this->outputJson($data);
            }
        }
        if (empty($params['status']) || !in_array($params['status'] , array(1,2))) {
            $params['status']  = 2;
        }
        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();        
        try {
            $createTime = $this->getTimestamp();
            // 添加员工登录信息
            $wxBizDepart  = new WxBizDepartment();
            $wxBizDepart->setBizId($bizId);
            $wxBizDepart->setParentId(intval($params['parentid']));
            $wxBizDepart->setName($params['name'] );
            $wxBizDepart->setCreatedTime($createTime);
            $wxBizDepart->setModifyTime(0);
            $wxBizDepart->setEname($params['ename'] );
            $wxBizDepart->setStatus($params['status'] );
            $wxBizDepart->setAddId($params['addid'] );
            $wxBizDepart->setIsDel(0);
            $em->persist($wxBizDepart);
            $em->flush();            
            $em->getConnection()->commit();
            $departid = $wxBizDepart->getId();
            $returnArr = array( 'departid'=>$departid);          //返回数组
            return $returnArr;
        } catch (\Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }
    }
    /**
     * @todo 修改部门
     */
    private function _bizEditDepartment($params)
    {
        $bizId = $this->bizId;
        $empid = $this->accountId;
        if (empty($params['departid'])) {
            $data = $this->getFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
            $this->outputJson($data);
        }
        /**
         * @var 检验是否存在
         */
        $wxBizService = $this->container->get('wx_biz_service');
        $departObj = $this->getDoctrine()->getRepository('OradtStoreBundle:WxBizDepartment')->findOneBy( array('id'=>$params['departid'],'isDel'=>0));
        if (empty($departObj)) {
            $data = $this->getFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
            $this->outputJson($data);
        }
        if (isset($params['type']) && 3 == $params['type'] ) {
            $res = $this->_bizDelDepartment($departObj,$params['departid']);
            return $res;
        }
        /**
         * @var 如果名称存在，并且是新的部门名称，验证新的名称是否存在
         */
        $oldName = $departObj->getName();
        if (!empty($params['name']) ) {
            $result = array();
            if ($oldName != $params['name']) {
                $result = $wxBizService->checkDepartByBizAndName($bizId,$params['name']);
            }
            if (!empty($result)) {
                $data = $this->getFailed(Errors::$ERROR_PARAMETER_DATA_EXISTS);
                $this->outputJson($data);
            }
        }
        /**
         * @todo 如果父级存在，验证父级id
         */
        if (!empty($params['parentid'])) {
            $res_parent = $wxBizService->checkDepartByParentid($bizId,$params['parentid'] );
            if (empty($res_parent)) {
                $data = $this->getFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
                $this->outputJson($data);
            }
        }
        if (!empty($params['status']) && !in_array($params['status'] , array(1,2))) {
            $status = $departObj->getStatus();
        }
        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();        
        try {
            $modifyTime = $this->getTimestamp();
            // 添加员工登录信息
            if (0 == $params['parentid'] || !empty($params['parentid'])) {
                $departObj->setParentId(intval($params['parentid']));    
            }
            if (!empty($params['name'])) {
                $departObj->setName($params['name'] );    
            }
            if (!empty($params['ename'])) {
                $departObj->setEname($params['ename'] );
            }
            if (!empty($params['status'])) {
                $departObj->setStatus($params['status'] );        
            }
            $departObj->setModifyTime($modifyTime);            
            $em->persist($departObj);
            $em->flush();            
            $em->getConnection()->commit();
            $returnArr = array( 'departid'=>$params['departid']);          //返回数组
            return $returnArr;
        } catch (\Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }
    }
    /**
     * @todo 删除部门
     */
    private function _bizDelDepartment($departObj,$departid)
    {
        /**
         * @var 检验员工是已添加该部门
         */
        $bizId   = $this->bizId;
        $wxBizService = $this->container->get('wx_biz_service');
        $res_emp = $wxBizService->getEmpsByDepartId($bizId,$departid);
        if (!empty($res_emp)) {
            $data = $this->getFailed(Errors::$DOCUMENT_DELETE_DIRECTORY_NO_EMPTY);
            $this->outputJson($data);
        }
        /**
         * @todo 判断是存在下级，将下级的父级改成该部门的父级
         */
        $wxBizService->changeSonDepartParentid($bizId,$departid);
        // 删除
        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();        
        try {
           /* $em->remove($departObj);
            $em->flush();            
            $em->getConnection()->commit(); */
            $departObj->setIsDel(1);
            $em->persist($departObj);
            $em->flush();
            $em->getConnection()->commit();
            $returnArr = array( 'departid'=>$departid);          //返回数组
            return $returnArr;
        } catch (\Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }
    }

    /**
     * 添加标签
     */
    public function _addBizTag(){
        $this->checkAccountV2();
        $userId =  $this->accountId;
        $bizid = $this->bizId;
        $request  = $this->getRequest();
        $tag  = $this->strip_tags($request->get('tag')); //标签

        if(empty($tag)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $em = $this->getDoctrine()->getManager();
        $tagid = RandomString::make(10);
        $time = $this->getTimestamp();
        $getTagSql = "SELECT * FROM wx_biz_tags WHERE tags=:tag AND biz_id=:bizid limit 1";
        $tagRes  = $em->getConnection()->executeQuery($getTagSql, array(':tag'=>$tag,':bizid'=>$bizid))->fetch();
        if(!empty($tagRes)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_DATA_EXISTS);
        }
        $param =array(
            ':tagid'=>$tagid,
            ':bizid'=>$bizid,
            ':tags'=>$tag,
            ':createtime'=>$time,
            ':modifytime'=>$time,
            ':addid'=>$userId,
        );
        $addTagSql = "INSERT INTO wx_biz_tags (tag_id,biz_id,tags,create_time,modify_time,add_id) ";
        $addTagSql .= " VALUES(:tagid,:bizid,:tags,:createtime,:modifytime,:addid)";
        $em->getConnection()->executeQuery($addTagSql, $param);
        $lastid = $em->getConnection()->lastInsertId();
        return $this->renderJsonSuccess(array("id"=>$lastid));
    }

    public function _editBizTag(){
        $this->checkAccountV2();
        $userId =  $this->accountId;
        $bizid = $this->bizId;
        $request  = $this->getRequest();
        $id  = $this->strip_tags($request->get('id'));
        $tag  = $this->strip_tags($request->get('tag')); //标签
        if(empty($id) || empty($tag)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $em = $this->getDoctrine()->getManager();
        $param = array(
            ':tag'=>$tag,
            ':id'=>$id,
            ':bizid'=>$bizid
        );
        $getIdSql = "SELECT * FROM wx_biz_tags WHERE  id=:id limit 1";//OR (tags=:tag AND biz_id=:bizid)
        $getTagSql = "SELECT * FROM wx_biz_tags WHERE  tags=:tag AND biz_id=:bizid limit 1";
        $tagRes  = $em->getConnection()->executeQuery($getTagSql, $param)->fetch();
        $idRes  = $em->getConnection()->executeQuery($getIdSql, $param)->fetch();
        if(empty($idRes)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
        }
        if(!empty($tagRes)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_DATA_EXISTS);
        }
        $editTagSql = " UPDATE wx_biz_tags SET tags=:tag WHERE id=:id";
        $em->getConnection()->executeQuery($editTagSql, $param);
        return $this->renderJsonSuccess();
    }

    public function _delBizTag(){
        $this->checkAccountV2();
        $userId =  $this->accountId;
        $bizid = $this->bizId;
        $request  = $this->getRequest();
        $id  = $this->strip_tags($request->get('id'));
        if(empty($id)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $idArr = explode(',',$id);
        $em = $this->getDoctrine()->getManager();
        if(!empty($idArr)){
            foreach($idArr as $val){
                $param = array(
                    ':id'=>$val,
                );
                $getIdSql = "SELECT * FROM wx_biz_tags WHERE  id=:id limit 1";//OR (tags=:tag AND biz_id=:bizid)
                $idRes  = $em->getConnection()->executeQuery($getIdSql, $param)->fetch();
                if(empty($idRes)){
                    return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
                }
                $editTagSql = " DELETE FROM wx_biz_tags WHERE id=:id";
                $em->getConnection()->executeQuery($editTagSql, $param);
            }
        }
        return $this->renderJsonSuccess();
    }
    /**
     * @todo 修改密码
     * @param [type] $[name] [<description>]
     * @return json [description]
     */
    private function bizEditEmpPassword()
    {
        $this->checkAccountV2();
        $bizid  = $this->bizId;
        $roleid = $this->roleId;
        $empid  = $this->accountId;
        $request  = $this->getRequest();
        $id       = $this->strip_tags($request->get('id'));
        $newpass  = $this->strip_tags($request->get('password'));
        $oldpass  = $this->strip_tags($request->get('oldpass'));
        if (empty($id) || empty($newpass) || empty($oldpass)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);     
        }
        $empObj = $this->getDoctrine()->getRepository('OradtStoreBundle:WxBizEmployee')->findOneBy( array('id'=>$id,'bizId'=>$bizid)); 
        // 按断id是否存在
        if (empty($empObj)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
        }
        // 判断是不是自己的
        if ($id != $empid) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_FORMAT_DYNAMIC,'edit');//没有权限
        }
        $old_pass = $empObj->getPasswd();
        $oldpass  = Password::encrypt($oldpass);
        if ($oldpass != $old_pass ) {
            return $this->renderJsonFailed(Errors::$ACCOUNT_BASIC_OLD_PASSWD);
        }
        $new_pass = Password::encrypt($newpass);
        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();        
        try {
            $modifyTime = $this->getTimestamp();
            $empObj->setPasswd($new_pass);
            $empObj->setModifyTime($modifyTime);
            $em->persist($empObj);
            $em->flush();
            $em->getConnection()->commit();
            $returnArr = array( 'empid'=>$id);          //返回数组
            return $this->renderJsonSuccess($returnArr) ;
        } catch (\Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }
    }
    
    public function syncwxcardtobiz(){
        $request  = $this->getRequest();
        $wechatId     = $this->strip_tags($request->get('wechatid'));
        $batchId     = $this->strip_tags($request->get('batchid'));
        if(empty($wechatId) || empty($batchId)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $param = array(
            ":wechatid"=>$wechatId,
            ":batchid"=>$batchId
        );
        $em = $this->getDoctrine()->getManager();
        $getUserSql = "SELECT * FROM weixin_user as a INNER JOIN weixin_card as b ON a.wechat_id=b.wechat_id  WHERE a.wechat_id=:wechatid AND b.batchid = :batchid";
        $res =  $em->getConnection()->executeQuery($getUserSql, $param);
        if(empty($res)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
        }
        $getUserMateSql = "SELECT * FROM wx_usermeta WHERE wechat_id=:wechatid  limit 1";
        $resMate =  $em->getConnection()->executeQuery($getUserMateSql, $param);
        if(empty($resMate)){
            $insertMateSql = "INSERT INTO wx_usermeta (wechat_id,meta_key,meta_value,medified_time) VALUES(:wechatid,:batchid,1,:time)";
            $em->getConnection()->executeQuery($insertMateSql, array(":wechatid"=>$wechatId,":batchid"=>$batchId,":time"=>$this->getTimestamp()));
        }else{
            $updateMateSql = "UPDATE wx_usermeta SET meta_key=:batchid,medified_time=:time WHERE id=:id";
            $em->getConnection()->executeQuery($updateMateSql, array(":batchid"=>$batchId,":time"=>$this->getTimestamp(),":id"=>$resMate['id']));
        }
    
        $gearmanService = $this->container->get ('gearman_service');
        $gearman_name = $this->container->getParameter('gearman_wxcard_sync');
        $param = array(
            'batchid' => $batchId,
            'wechatid'=>$wechatId
        );
        $gearmanService->push_job($gearman_name,$param);
    
        return $this->renderJsonSuccess();
    }

    /**
     * 分享名片，部门分享给部门，管理员操作
     */
    public function _addShare() {
        try {
            $this->checkAccountV2();
            $userId = $this->accountId;
            $userName = $this->name; 
            $bizId = $this->bizId;
            $roleId = $this->roleId; 

            //校验当前登录用户角色是否为管理员
            if (!in_array($roleId,[1,2])) {
                return Errors::$ERROR_NOT_HAVE_PERMISSION;//非管理员不能分享
            }

            $request = $this->getRequest();
            $department_json = $this->strip_tags($request->get("department_json",""));// json字符串 {"1":[2,3,4],"2":[1,3,5]}
            $department_arr=json_decode($department_json,true);

            $em = $this->getDoctrine()->getManager(); //添加事物
            $em->getConnection()->beginTransaction();
            try {
                $sql_del  = "DELETE FROM `" . Tables::TBWXBIZCARDSHARE . "` WHERE type = 3 AND biz_id=:biz_id";
                $this->em->getConnection()->executeQuery($sql_del, array(':biz_id' => $bizId));
                if(!empty($department_arr)){ 
                    $wxBizService = $this->container->get('wx_biz_service');
                    foreach ($department_arr as $key=>$val){
                        $moduleids = $val;
                        $departId = $key ;//要被分享的部门ID
                        //部门分享给部门，不需要cardid参数，且只能本部门管理员设置，超管可设置任意部门
                        $result = $wxBizService->addShare($departId, $moduleids, $bizId);
                        $department_arr[$key] = $result;
                    } 
                 }
                $em->getConnection()->commit();
            } catch (\Exception $ex) {
                $em->getConnection()->rollback();
                throw $ex;
            } 
            return $this->renderJsonSuccess($department_arr);
        } catch(\Exception $e){
            throw $e;
        }
    }

    /**
     * 取消分享名片，部门给部门的分享，管理员操作
     */
    public function _delShare() {
    }
    
    public function getAction($act)
    {
        switch ($act) {
            case 'getbiz':
                return $this->_getBiz();
                break;
            case 'getemp':
                return $this->_getBizEmployee();
                break;
            case 'getbiztag':
                return $this->_getBizTag();
                break;
            case 'getdepart':
                return $this->_getBizDepartment();
                break;
            case 'getbizincard':
                return $this->_getBizInCard();
                break;
            case 'getbizcard':
                return $this->_getBizCard();
                break;
            default:
                return $this->renderJsonFailed(Errors::$HTTP_STATUS_CODE_404);
                break;
        }
    }

    /*
     * 获取企业标签
     * */
    public function _getBizTag(){
        $this->checkAccountV2();
        $bizId = $this->bizId;
        $where = " a.biz_id = '{$bizId}' ";
        $sqldata = array(
            'fields' => array(
                'id'          => array('mapdb' => 'a.id' , 'w' => ' AND a.id = :id'),
                'bizid'       => array('mapdb' => 'a.biz_id' , 'w' => ' AND a.biz_id = :bizid'),
                'tagid'       => array('mapdb' => 'a.tag_id' , 'w' => ' AND a.tag_id = :tagid'),
                'tags'     => array('mapdb' => 'a.tags'),
                'createtime' => array('mapdb' => 'a.create_time' , 'w' => 'Range'),
                'modifytime'  => array('mapdb' => 'a.modify_time' , 'w' => 'Range'),
                'addid'  => array('mapdb' => 'a.add_id' , 'w' => ' AND a.add_id = :addid'),
            ),
            'default_dataparam' => array(),
            'sql'   => "SELECT %s FROM `" . Tables::TBWXBIZTAGS . "` as a  %s%s",
            'where' => "".$where,
            'order' => '',
            'provide_max_fields' => 'id,bizid,tagid,tags,addid,createtime,modifytime',
        );
        $check = $this->parseSql($sqldata);
        if(true !== $check){
            return $this->renderJsonFailed($check);
        }
        $data = $this->getData($sqldata,'list');
        return $this->renderJsonSuccess ( $data );
    }

    /**
     * @todo 获取企业信息
     * @param int $id 企业int_id
     * @param string $bizid 企业varchar_id 
     * @var  id | bizid 二选一为必填
     */
    private function _getBiz()
    {
        // $this->checkAccountV2();
        // $bizId = $this->bizId;
        // $where = " a.biz_id = '{$bizId}' ";
        $request = $this->getRequest();
        $id      = $this->strip_tags($request->get('id')) ;
        $bizid   = $this->strip_tags($request->get('bizid'));
        if (empty($id) && empty($bizid)) {
             return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
         } 
        $where   = '';
        $sqldata = array(
            'fields' => array(
                'id'          => array('mapdb' => 'a.id' , 'w' => ' AND a.id = :id'),
                'bizid'       => array('mapdb' => 'a.biz_id' , 'w' => ' AND a.biz_id = :bizid'),
                'bizname'     => array('mapdb' => 'a.biz_name'),
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
            'sql'   => "SELECT %s FROM `" . Tables::TBWXBIZ ."` as a  %s%s",
            'where' => "".$where,
            'order' => '',
            'provide_max_fields' => 'id,bizid,bizname,address,bizemail,info,website,logopath,bizsize,biztype,phone,contact,prespell,wechatid,wechatpath,open,status,count,createdtime,modifytime,qrcodetime',
        );
        $check = $this->parseSql($sqldata);
        if(true !== $check){
            return $this->renderJsonFailed($check);
        }
        $data = $this->getData($sqldata,'list');        
        return $this->renderJsonSuccess ( $data );
    }

    /**
     * @todo 获取企业员工信息
     */
    private function _getBizEmployee()
    {
 
        $this->checkAccountV2();
        $bizId = $this->bizId;
        $where = " a.biz_id = '{$bizId}' and a.is_del=0 ";
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
                'wechat_info'       => array('mapdb' => 'c.wechat_info'),
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
            'sql'   => "SELECT %s FROM `" . Tables::TBWXBIZEMPLOYEE . "` as a 
                        LEFT JOIN " . Tables::TBWXBIZDEPARTMENT . " AS b on a.department = b.id
                        LEFT JOIN " . Tables::TBWEIXINUSER . " as c ON a.open_id = c.wechat_id
                         %s%s",
            'where' => "".$where,
            'order' => '',
            'provide_max_fields' => 'id,bizid,code,mobile,email,name,superior,department,department_name,enable,openid,wechat_info,unionid,roleid,import,refrom,createdtime,modifytime,identstatus,identtime',//passwd,
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
        $this->checkAccountV2();
        $bizId = $this->bizId;
        $where = " a.biz_id = '{$bizId}' and a.is_del=0";
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
            'sql'   => "SELECT %s FROM `" . Tables::TBWXBIZDEPARTMENT . "` as a  %s%s",
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

    /**
     * 获取员工所拥有的名片涉及的所有公司
     */
    public function _getBizInCard()
    {
        $request = $this->getRequest();
        $bizName = $this->strip_tags($request->get('bizname'));//公司名称关键字
        $this->checkAccountV2();
        $userId = $this->accountId;
        $roid = $this->roleId;
        $bizId = $this->bizId;

        try {
            /*//普通员工
            $sqlBizCount = "SELECT COUNT(DISTINCT(bcci.company_name)) AS count
                FROM `wx_biz_card_company_info` AS bcci 
                LEFT JOIN wx_biz_card AS bc ON bc.id=bcci.card_id";
            $page = intval($request->get('page'));
            $pageSize = intval($request->get('pagesize'));
            $page = $page ? $page : 1;
            $pageSize = $pageSize ? $pageSize : 10;
            $limitStart = ($page-1) * $pageSize;
            $sqlBiz = "SELECT DISTINCT(bcci.company_name) 
                FROM `wx_biz_card_company_info` AS bcci 
                LEFT JOIN wx_biz_card AS bc ON bc.id=bcci.card_id";

            if ($roid == 1) {//超级管理员
                $sqlBizCount .= " WHERE bc.user_id IN (SELECT id FROM wx_biz_employee WHERE biz_id IN (SELECT biz_id FROM wx_biz_employee WHERE id={$userId}))";
                $sqlBiz .= " WHERE bc.user_id IN (SELECT id FROM wx_biz_employee WHERE biz_id IN (SELECT biz_id FROM wx_biz_employee WHERE id={$userId}))";
            } else {
                $sqlBizCount .= " WHERE bc.user_id={$userId}";
                $sqlBiz .= " WHERE bc.user_id={$userId}";
            }
            $sqlBizCount .= " AND bc.`status`!='deleted'";
            $sqlBiz .= " AND bc.`status`!='deleted'";
            $sqlBiz .= " LIMIT {$limitStart},{$pageSize}";

            $bizListCount = $this->getConnection()->executeQuery($sqlBizCount)->fetch();
            $bizCount = $bizListCount['count'];
            $bizList = $this->getConnection()->executeQuery($sqlBiz)->fetchAll();
            if (!empty($bizList)) {
                $list = array();
                foreach ($bizList as $key => $value) {
                    $list[] = $value['company_name'];
                }
                $bizList = $list;
                unset($list);
            }
            $result = ['count'=>$bizCount, 'page'=>$page, 'pagesize'=>$pageSize, 'list'=>$bizList];
            return $this->renderJsonSuccess($result);*/

            $sql = "SELECT %s 
                      FROM `" . Tables::TBWXBIZCARDCOMPANYINFO . "` AS bcci 
                      LEFT JOIN " . Tables::TBWXBIZCARD . " AS bc ON bc.id=bcci.card_id %s%s";
            $sqldata = array(
                'fields' => array(
                    'name' => array('mapdb' => 'DISTINCT(bcci.company_name)')
                ),
                'default_dataparam' => array(),
                'sql'   => $sql,
                'order' => '',
                'provide_max_fields' => 'name',
            );
            if ($roid == 1) {//超级管理员
                $sqldata['where'] = " bc.user_id IN (SELECT id FROM wx_biz_employee WHERE biz_id='{$bizId}') AND bc.`status`!='deleted'";
            } else {
                $sqldata['where'] = " bc.user_id={$userId} AND bc.`status`!='deleted'";
            }
            if (isset($bizName) &&!empty($bizName)) {
                $sqldata['where'] .= " AND bcci.company_name LIKE '%{$bizName}%'";
            }

            $check = $this->parseSql($sqldata);
            if(true !== $check){
                return $this->renderJsonFailed($check);
            }
            $this->setParam('function', __FUNCTION__);
            $data = $this->getData($sqldata,'list','callable_data_wechat');
            return $this->renderJsonSuccess ( $data );
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * 根据公司名查找对应的名片
     */
    public function _getBizCard()
    {
        $request = $this->getRequest();
        $bizName = $this->strip_tags($request->get('bizname'));//公司名称关键字
        $test = $this->strip_tags($request->get('test'));
        $this->checkAccountV2();
        $userId = $this->accountId;
        if (isset($test) && !empty($test)) {
            $userId = 53;//测试
            $roid = 2;
        }
        $roid = $this->roleId;
        $bizId = $this->bizId;

        try {
            $sql = "SELECT %s 
                    FROM `" . Tables::TBWXBIZCARDCOMPANYINFO . "` AS bcci 
                    LEFT JOIN " . Tables::TBWXBIZCARD . " AS bc ON bc.id=bcci.card_id %s%s";
            $sqldata = array(
                'fields' => array(
                    'name'     => array('mapdb' => 'bcci.company_name'),
                    'bizid'    => array('mapdb' => 'bc.biz_id'),
                    'cardid'   => array('mapdb' => 'bc.card_id'),
                    'vcard'    => array('mapdb' => 'bc.vcard'),
                    'picture'  => array('mapdb' => 'bc.picture'),
                    'picpatha' => array('mapdb' => 'bc.pic_path_a'),
                    'picpathb' => array('mapdb' => 'bc.pic_path_b'),
                    'remark'   => array('mapdb' => 'bc.remark'),
                    'cardfrom' => array('mapdb' => 'bc.card_from'),
                    'cardtype' => array('mapdb' => 'bc.card_type'),
                ),
                'default_dataparam' => array(),
                'sql'   => $sql,
                'order' => '',
                'provide_max_fields' => 'name,bizid,cardid,vcard,picture,picpatha,picpathb,remark,cardfrom,cardtype',
            );
            if ($roid == 1) {//超级管理员
                $sqldata['where'] = " bc.user_id IN (SELECT id FROM wx_biz_employee WHERE biz_id='{$bizId}') AND bc.`status`!='deleted'";
            } else {
                $sqldata['where'] = " bc.user_id={$userId} AND bc.`status`!='deleted'";
            }
            if (isset($bizName) &&!empty($bizName)) {
                $sqldata['where'] .= " AND bcci.company_name LIKE '%{$bizName}%'";
            }

            $check = $this->parseSql($sqldata);
            if(true !== $check){
                return $this->renderJsonFailed($check);
            }
            $this->setParam('function', __FUNCTION__);
            $data = $this->getData($sqldata,'list','callable_data_wechat');
            return $this->renderJsonSuccess ( $data );
        } catch (\Exception $e) {
            throw $e;
        }
    }
}