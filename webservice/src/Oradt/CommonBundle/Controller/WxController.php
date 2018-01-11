<?php
namespace Oradt\CommonBundle\Controller;
use Oradt\OauthBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Oradt\Utils\Errors;
use Oradt\Utils\RandomString;
use Oradt\StoreBundle\Entity\PushToken;

class WxController extends BaseController
{
    
    public function postAction($act)
    {
        switch ($act) { 
            case 'wxpushtoken':
                return $this->_wxpushtoken();
                break;
            case 'getwxpush':
                return $this->_getwxpush();
                break; 
            case 'syncdownexcelcard'://异步下载名片EXCEL
                return $this->_syncDownExcelCard();
                break; 
            case 'updateempenable':// 
                return $this->_updateEmployeeEnable();
                break;
            default:
                return $this->renderJsonFailed(Errors::$HTTP_STATUS_CODE_404);
                break;
        }
    }
    /**
     * @ 异步下载名片EXCEL
     */
    public function _syncDownExcelCard(){
        $request = $this->getRequest();
        $content  = $request->get('content',''); //短信正文
        $fromsend = $request->get('fromsend',''); //发件人名
        $title = $request->get('title',''); //邮件标题
        $enclosure = $request->files->get('enclosure');//附件
        $sendurl =  $request->get('sendurl');//发送地址
        $wechatid =  $request->get('wechatid','');//微信id
        $enclosureName = $request->get('enclosurename','');
        $batchid = $request->get('batchid','');
    
        if(!empty($enclosure)){
            $dirs_upload = $this->container->get('aws_service');
            $filename ='';
            $file ='';
            if(empty($sendurl)){
                return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
            }
            $pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
            if (!preg_match( $pattern, $sendurl ) ){
                return $this->renderJsonFailed(Errors::$ERROR_EMAIL_FORMAT );
            }
            if(!empty($enclosure)){
                // $file = $dirs_upload->uploadMessageSourcePath($enclosure,$this->getTimestamp());
    
                $file = $dirs_upload->uploadFile($enclosure,array('PATH'=>'wxmail/'));
            }
             
            $param =array(
                ':enclosure'=>$file,
                ':sendname'=>$fromsend,
                ':content'=>$content,
                ':title'=>$title,
                ':createtime'=>$this->getTimestamp(),
                ':mail' => $sendurl,
                ':wechatid'=>$wechatid,
                ':batchid'=>$batchid,
                ':sendtype'=>"sync",
                ':send_time'=>$this->getTimestamp(),
                ':status'=>0
            );
            if(!empty($file) && empty($enclosureName)){
                $filename = substr($file,strrpos($file,'/')+1);
            }else{
                $filename = $enclosureName;
            }
            //print_r($file);
    
            //exit($filename);
            $insertsql = "INSERT INTO send_message_log (enclosure,sendname,content,title,create_time,mail,wechat_id,batchid,send_type,send_time,status) VALUES(:enclosure,:sendname,:content,:title,:createtime,:mail,:wechatid,:batchid,:sendtype,:send_time,:status)";
            $em = $this->getDoctrine()->getManager();
            $em->getConnection()->beginTransaction();
             
            try {
                $this->getConnection()->executeQuery($insertsql, $param);
                // $this->sendMail($sendurl,$title,$content,$file,$fromsend,$filename);
                $em->getConnection()->commit();
    
                //异步发送邮件 在api主库
                $mailtb = 'INSERT INTO message_promotion (type,mobile,email,title,content,created_time,files,fromname)
                 VALUE (:type,:mobile,:mail,:title,:content,:createtime,:files,:fromname)';
    
                $this->setManager('api');
                $param_message =array(
                    ':type'=>2,
                    ':mobile'=>'',
                    ':mail' => $sendurl,
                    ':title' => $title,
                    ':content' => $content,
                    ':createtime'=>$this->getTimestamp(),
                    ':files'=> json_encode(array( array('url' => $file , 'name' => $filename,'sendtype'=>"sync")) , JSON_UNESCAPED_UNICODE),
                    ':fromname' => $fromsend
                );
                $this->getConnection()->executeQuery($mailtb, $param_message);
                $this->setManager();
    
    
                return $this->renderJsonSuccess();
            } catch (\Exception $ex) {
                $em->getConnection()->rollback();
                throw $ex;
            }
        }else{
            $param['content']  = $content;
            $param['fromsend'] = $fromsend;
            $param['title'] = $title;
            $param['sendurl'] =  $sendurl;
            $param['wechatid'] =  $wechatid;
            $param['enclosurename'] = $enclosureName;
            $param['batchid'] = $batchid;
            
            
            $param_send_message =array(
                ':enclosure'=>"",
                ':sendname'=>$fromsend,
                ':content'=>$content,
                ':title'=>$title,
                ':createtime'=>$this->getTimestamp(),
                ':mail' => $sendurl,
                ':wechatid'=>$wechatid,
                ':batchid'=>$batchid
            );
            
            
            $weixin_card_service = $this->container->get('wechat_service');
            $messageid=$weixin_card_service->insert_send_message_log($param_send_message);
            $param['messageid'] = $this->getConnection()->lastInsertId(); 
            
            $gearmanService = $this->container->get('gearman_service');
            
            $gearman_name   = $this->container->getParameter('gearman_wxexcle_sync');
            $gearmanService->push_job($gearman_name, $param);
    
            return $this->renderJsonSuccess();
        }
    }
    
    
    public function _wxpushtoken(){
        $request = $this->getRequest();
        $token    = $this->strip_tags($request->get('token'));          //设备token
        $userId   = $this->strip_tags($request->get('deviceid'));         //设备id
        $devicetype = $this->strip_tags($request->get('type')); //设备类型
        if(empty($token) || empty($userId) || empty($devicetype)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $dates = date('Y-m-d H:i:s',$this->getTimestamp());
        $devParam = array( ':token'=> $token, ':userId'=>$userId );
        $sql = "SELECT 1 FROM `push_token` WHERE device_token=:token AND user_id!=:userId";
        $devRes = $this->getConnection()->executeQuery( $sql, $devParam )->fetchColumn();
        if( $devRes === '1' ){
            $delSql = "DELETE FROM `push_token` WHERE device_token=:token AND user_id!=:userId";
            $this->getConnection()->executeQuery( $delSql, $devParam);
        }
    
        $em = $this->getDoctrine()->getManager();
        $getOldPush = "SELECT id FROM push_token WHERE user_id=:userid  AND device_token=:devicetoken LIMIT 1";
        $res = $this->getConnection()->executeQuery( $getOldPush, array(':userid'=>$userId,':devicetoken'=>$token))->fetch();
        if(empty($res)){
            $getPush = "SELECT id FROM push_token WHERE user_id=:userid AND device_type<>'orange' AND  status=0 LIMIT 1";
            $id = $this->getConnection()->executeQuery( $getPush, array(':userid'=>$userId))->fetchColumn();
            if(!empty($id)){
                $updatePush = "UPDATE push_token SET status=1 WHERE id=:id";
                $this->getConnection()->executeQuery( $updatePush, array(':id'=>$id));
            }
            $pushtoken = new PushToken();
            $pushtoken->setUserId($userId);
            $pushtoken->setDeviceToken($token);
            $pushtoken->setDeviceType($devicetype);
            $pushtoken->setDeviceId('');
            $pushtoken->setStatus(0);
            $pushtoken->setTags('');
            $pushtoken->setCount(0);
            $pushtoken->setSessionId('');
            $em->persist($pushtoken);
            $em->flush();
            $newId = $pushtoken->getId();
        }
        return $this->renderJsonSuccess();
    }
    
    /**
     * @ 更新员工状态
     */
    public function _updateEmployeeEnable(){
        $request = $this->getRequest();
        $wechat_id    = $this->strip_tags($request->get('wechat_id'));          //
        $emp_id   = $this->strip_tags($request->get('emp_id'));         // 
        $enable   = $this->strip_tags($request->get('enable'));
        if(empty($enable))$enable=1;
        if(empty($wechat_id) || empty($emp_id)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        
        $sql_employee        = "SELECT id,role_id,biz_id FROM wx_biz_employee WHERE open_id =:open_id  and enable!=3 ";//enable=3离职状态
        $find_employee_Array  = array(':open_id'=> $wechat_id);
        $employee_info       = $this->getConnection()->executeQuery($sql_employee,$find_employee_Array)->fetch();
        if($employee_info){
            $roleid=$employee_info["role_id"];
            $biz_id=$employee_info["biz_id"];
        }else{
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);//管理员不存在
        }
         
        //判断是否有权限
        if (empty($roleid) || !in_array($roleid, array(1,2))) {
            return $this->renderJsonFailed(Errors::$ERROR_NOT_HAVE_PERMISSION);
        }
          
        $empObj =  $this->em->getRepository('OradtStoreBundle:WxBizEmployee')->findOneBy( array('id'=>$emp_id)); 
        if(empty($empObj)){
            return $this->renderJsonFailed(Errors::$ERROR_DATA_NULL);//没有员工信息
        }
            
        $emp_biz_id=$empObj->getBizId();
        if($biz_id!=$emp_biz_id){
             return $this->renderJsonFailed(Errors::$ACCOUNT_BIZ_EMP_NOTSELF);//不是同一个企业不能操作
        }
         
        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();
        try {
            $modifyTime = $this->getTimestamp(); 
            if (!empty($enable)) {
                $empObj->setEnable($enable);
                if (3 == $enable && 3 != $empObj->getEnable()) {
                    // 如果员工离职需要清除common记录
                    $wxBizService = $this->container->get("wx_biz_service");
                    $wxBizService->dealWithCommonByEmpid($emp_id);
                } 
            }
 
            $empObj->setModifyTime($modifyTime);
            $em->persist($empObj);
            $em->flush(); 
            $em->getConnection()->commit();
            $returnArr = array( 'empid'=>$emp_id);          //返回数组 
        } catch (\Exception $ex) {
            $this->em->getConnection()->rollback();
            throw $ex;
        }
        
        return $this->renderJsonSuccess($returnArr);
    }
    
    public function _getwxpush(){
        $request = $this->getRequest();
        $userId   = $this->strip_tags($request->get('deviceid'));         //设备id
        $sqldata = array(
            'fields' => array(
                'id'    => array('mapdb' => 'id','w'=>' AND id=:id'),
                'nindex'  => array('mapdb' => 'id' , 'w' => 'Range'),
                'nflag'    => array('mapdb' => 'nflag','w'=>' AND nflag=:nflag'),
                'type'    => array('mapdb' => 'type','w'=>' AND type IN (%s)'),
                'isread'    => array('mapdb' => 'isread','w'=>' AND isread=:isread'),
                'contact'    => array('mapdb' => 'content'),
                'datetime'   => array('mapdb' => 'created_time' , 'w' => 'Range'),
                'fromuid'	 => array('mapdb' => 'from_uid' , 'w' => ' AND from_uid=:fromuid'),
                'userId'	 => array('mapdb' => 'to_uid'),
                'status'	 => array('mapdb' => 'status', 'w'=>' AND status=:status'),
                'title'	 => array('mapdb' => 'title'),
                'tb_num'	 => array('mapdb' => 'tb_num'),
            ),
            'default_dataparam' => array(),
            'sql' => "SELECT %s FROM message_queue_history AS a%s%s",
            'where' => " to_uid='".$userId ."' AND nflag<2",
            'order' => ' order by modified_time desc',
            'provide_max_fields' => 'id,type,isread,contact,datetime,fromuid,nflag,status,title',
        );
    
        $check = $this->parseSql($sqldata);
        if(true !== $check)
        {
            return $this->renderJsonFailed($check);
        }
        $data = $this->getData($sqldata,'list', "callable_data");
        if(!empty($this->needupdatearr)){
            $where = implode("','", $this->needupdatearr);
            $updatesql = "UPDATE message_queue_history SET isread=1 WHERE to_uid=:userid AND id in('".$where."')";
            $this->getConnection()->executeUpdate($updatesql,array(':userid'=>$userId));
        }
        return $this->renderJsonSuccess ( $data );
    }
    
    
    
    public function getAction($act)
    {
        switch ($act) { 
            case 'getdownexcelcardlog':// 下载名片EXCEL日志
                 return $this->_getdownexcelcardlog();
                 break;
            case 'getwechatinfobynickname':
                 return $this->_getwechatinfobynickname();
                 break;
            case 'getusercommon':
                 return $this->_getUserCommon();
                 break;
             case 'getadmin':
                     return $this->_getAdmin();
                     break;
            default:
                return $this->renderJsonFailed(Errors::$HTTP_STATUS_CODE_404);
                break;
        }
    }
   
    
    
    /** 
     * @ 获取微信下载excel的日志
     */
    public  function _getdownexcelcardlog(){
        $sqldata = array(
            'fields' => array(
                'wechat_id'       => array('mapdb' => 'a.wechat_id' , 'w' => ' AND a.wechat_id = :wechat_id'),
                'enclosure'         => array('mapdb' => 'a.enclosure' ),
                'content'     => array('mapdb' => 'a.content' ),
                'sendname'   => array('mapdb' => 'a.sendname', 'w' => ' AND a.sendname LIKE :sendname'),
                'title'       => array('mapdb' => 'a.title'),
                'mail'         => array('mapdb' => 'a.mail' ),
                'create_time'        => array('mapdb' => 'a.create_time')
            ), 
            'default_dataparam' => array(),
            'sql'   => "SELECT %s FROM `send_message_log` as a %s%s",
            'where' => " status=0",
            'order' => ' ORDER BY a.id DESC',
            'provide_max_fields' => 'wechat_id,enclosure,content,sendname,title,mail,create_time',
        );
    
        $check = $this->parseSql($sqldata);
        if(true !== $check){
            return $this->renderJsonFailed($check);
        }
        $data = $this->getData($sqldata);
        return $this->renderJsonSuccess ( $data );
    }
    
    /**
     * @ 获取微信信息通过微信昵称
     */
    public  function _getwechatinfobynickname(){
        
        $request = $this->getRequest();
        $nickname  = $request->get('nickname',''); // 
        $wechat_id  = $request->get('wechat_id',''); //
        
        if (empty($nickname)&&empty($wechat_id) ) {
	        return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
	    } 
	    $nickname=json_encode($nickname);  
	    $nickname = str_replace('\\','\\\\\\\\',trim($nickname, '"')); 
	    $where=' a.wechat_info like \'%' . $nickname . '%\'';
        $sqldata = array(
            'fields' => array(
                'wechat_id'       => array('mapdb' => 'a.wechat_id' , 'w' => ' AND a.wechat_id = :wechat_id'),
             
                'wechat_info'   => array('mapdb' => 'a.wechat_info'),
              
            ),
            'default_dataparam' => array(),
            'sql'   => "SELECT %s FROM `weixin_user` as a %s%s",
            'where' => "".$where,
            'order' => ' ORDER BY a.id DESC',
            'provide_max_fields' => 'wechat_id,wechat_info',
        );
        

    
        $check = $this->parseSql($sqldata);
       
    
        if(true !== $check){
            return $this->renderJsonFailed($check);
        }
        $data = $this->getData($sqldata); 
       
        foreach ($data["data"] as $key=>$value){ 
            $wechat_info=json_decode($value["wechat_info"]); 
            $data["data"][$key]=$wechat_info;
        } 
        return $this->renderJsonSuccess ( $data );
    }
    
    /**
     * @todo 获取账户信息
     */
    private function _getUserCommon()
    {      
        $request = $this->getRequest();
        $wechat_id  = $request->get('wechat_id'); //
      
        if (empty($wechat_id) ) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }      
        $sqldata = array(
            'fields' => array( 
                'account_no'  => array('mapdb' => 'a.account_no' , 'w' => ' AND a.account_no = :account_no'),
                'username'     => array('mapdb' => 'a.username', 'w' => ' AND a.username = :username'),
                'mobile'     => array('mapdb' => 'a.mobile', 'w' => ' AND a.mobile = :mobile'),
                'email'     => array('mapdb' => 'a.email', 'w' => ' AND a.email = :email'),  
                'wechat_id'     => array('mapdb' => 'a.wechat_id', 'w' => ' AND a.wechat_id = :wechat_id'),
                'union_id'     => array('mapdb' => 'a.union_id', 'w' => ' AND a.union_id = :union_id'),
                'status'      => array('mapdb' => 'a.status', 'w' => ' AND a.status = :status'),
                're_from'       => array('mapdb' => 'a.re_from'),
                'createdtime' => array('mapdb' => 'a.create_time' , 'w' => 'Range'),
                'modifytime'  => array('mapdb' => 'a.modify_time' , 'w' => 'Range'),
            ),
            'default_dataparam' => array(),
            'sql'   => "SELECT %s FROM `user_common` as a 
                        %s%s",
            'where' => "",
            'order' => '',
            'provide_max_fields' => 'account_no,username,mobile,email,wechat_id,union_id,status,re_from,createdtime,modifytime',
        ); 
        $check = $this->parseSql($sqldata);
        if(true !== $check){
            return $this->renderJsonFailed($check);
        }
        $data = $this->getData($sqldata,'list');
        return $this->renderJsonSuccess ( $data );
    }
    /**
     * @todo 获取管理员列表
     */
    private function _getAdmin()
    {
        $request = $this->getRequest();
        $wechat_id  = $request->get('wechat_id'); //
        $biz_id  = $request->get('biz_id');
        if (empty($wechat_id)||empty($biz_id) ) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        
        $wxBizService = $this->container->get('wx_biz_service');
        $user = $wxBizService->getUserByWechatId($wechat_id);
        if($user){
            $bizId=$user["biz_id"];
        }else{
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);//用户不存在
        }
        
        if($bizId!=$biz_id){
            return $this->renderJsonFailed(Errors::$ACCOUNT_BIZ_EMP_NOTSELF);//不属于一个公司
        }
        
        $where=" enable=1 and role_id in(1,2)";
        $sqldata = array(
            'fields' => array(
                'biz_id'       => array('mapdb' => 'a.biz_id' , 'w' => ' AND a.biz_id = :biz_id'),  
                'name'        => array('mapdb' => 'a.name','w' => ' AND a.name LIKE :name'), 
                'open_id'      => array('mapdb' => 'a.open_id', 'w' => ' AND a.open_id = :open_id'), 
                'unionid'     => array('mapdb' => 'a.union_id', 'w' => ' AND a.union_id = :unionid'),
                'roleid'      => array('mapdb' => 'a.role_id', 'w' => ' AND a.role_id = :roleid'),
            ),
            'default_dataparam' => array(),
            'sql'   => "SELECT %s FROM `wx_biz_employee` as a
                        %s%s",
            'where' => "".$where,
            'order' => '',
            'provide_max_fields' => 'biz_id,name,open_id,unionid,roleid',
        );
        $check = $this->parseSql($sqldata);
        if(true !== $check){
            return $this->renderJsonFailed($check);
        }
        $data = $this->getData($sqldata,'list');
        return $this->renderJsonSuccess ( $data );
    }
    

    /**
     *
     * @var 自动设置已读未读 0为自动，1为关闭
     */
    private $needupdatearr = array();
    private $unautoRead = 0;
    protected function callable_data($item){
        if($this->unautoRead===0) {
            if (isset($item ['isread']) &&   $item ['isread'] !="" ) {
                if ($item ['isread'] == 0) {
                    $this->needupdatearr[] = $item['id'];
                }

            }
        }
        return $item;
    }
}