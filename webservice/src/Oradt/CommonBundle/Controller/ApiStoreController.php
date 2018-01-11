<?php
namespace Oradt\CommonBundle\Controller;
use Oradt\OauthBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Oradt\Utils\PhpZip;
use Oradt\Utils\Errors;
use Oradt\Utils\RandomString;
use Oradt\StoreBundle\Entity\LeafDeviceLocation;
use Oradt\StoreBundle\Entity\I18nCityFollows;
use Oradt\StoreBundle\Entity\ContactCardExchangeFriend;
use Oradt\StoreBundle\Entity\ContactCardRemarkDate;
use PDO;

class ApiStoreController extends BaseController
{
    protected $respath = '/cityprc?path=';
    public function getResourceUrl($citycode)
    {
       $url = $this->container->getParameter('HOST_URL') . $this->respath . $citycode;
       return $url;
    }
    
    public function postAction ($act)
    {
        switch ($act)
        {
           
         
            case 'sendmessage':    //发送邮件
                return $this->_sendmessage();
                break;
            default:
                return $this->renderJsonFailed(Errors::$HTTP_STATUS_CODE_404);
                break;
        }        
    }

    public function _sendmessage(){
        $userId   = $this->accountId;
        $request = $this->getRequest();
        $content  = $request->get('content',''); //短信正文
        $fromsend = $request->get('fromsend',''); //发件人名
        $title = $request->get('title',''); //邮件标题
        $enclosure = $request->files->get('enclosure');//附件
        $sendurl =  $request->get('sendurl');//发送地址
        $wechatid =  $request->get('wechatid','');//微信id
        $enclosureName = $request->get('enclosurename','');
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
            ':wechatid'=>$wechatid
        );
        if(!empty($file) && empty($enclosureName)){
            $filename = substr($file,strrpos($file,'/')+1);
        }else{
            $filename = $enclosureName;
        }
        //print_r($file);
        
       
        
        //exit($filename);
        $insertsql = "INSERT INTO send_message_log (enclosure,sendname,content,title,create_time,mail,wechat_id) VALUES(:enclosure,:sendname,:content,:title,:createtime,:mail,:wechatid)";
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
            $param =array(
                    ':type'=>2,
                    ':mobile'=>'',
                    ':mail' => $sendurl,
                    ':title' => $title,
                    ':content' => $content,
                    ':createtime'=>$this->getTimestamp(),
                    ':files'=> json_encode(array( array('url' => $file , 'name' => $filename)) , JSON_UNESCAPED_UNICODE),
                    ':fromname' => $fromsend
            );
            $this->getConnection()->executeQuery($mailtb, $param);
            $this->setManager();
            
            
            return $this->renderJsonSuccess();
        } catch (\Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }

    }
    

    public function getAction ($act)
    {
        switch ($act)
        {
            case 'version':           //api版本
                echo $this->version();
                exit();
                break;
            default:
                return $this->renderJsonFailed(Errors::$HTTP_STATUS_CODE_404);
                break;
        }
    }

    public function version() {
        return $this->container->getParameter('api_version');   
    }
}
