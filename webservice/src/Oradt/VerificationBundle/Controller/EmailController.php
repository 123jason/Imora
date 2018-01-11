<?php

namespace Oradt\VerificationBundle\Controller;

use Oradt\OauthBundle\Controller\BaseController;
use Oradt\StoreBundle\Entity\AccountBiz;
use Oradt\StoreBundle\Entity\EmailMessage;
use Oradt\Utils\Errors;
use Oradt\Utils\Codes;
use Oradt\Utils\RandomString;

/**
 * 对邮件验证码/链接的获取和验证操作
 */
class EmailController extends BaseController
{
    
    private $cache_pre = 'verifyEmail';
    /**
     * 邮件验证
     * @return type
     */
    public function getAction()
    {
        $globalBase = $this->container->get('global_base');
        $request    = $this->getRequest();
        $code       = $request->get('code'); //验证码*必须
        //验证不能为空
        if (empty($code)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $data       = array();
        //先读去缓存,如果没有在查询数据库
        $cacheKey   = $this->getCacheKey($code,$this->cache_pre);
        //判断key是否存在，存在则读取缓存，不存在则读取数据库
        if($this->checkCacheKeyExists($cacheKey)){
            $data   = $this->hGetallCache($cacheKey);
        }else{
            $data   = $this->getEmailMessageByMid($code);
        }
        $array  = array();
        //判断数据是否存在
        if (empty($data)) {
            $array = $this->getFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
        } else {
            $time = time();
            //创建时间加过期时间长度
            $strtotime = strtotime($data['createtime']) + Codes::VERIFY_EXPIRE_TIME;
            //没有过期处理相应的逻辑
            if ($time < $strtotime) {
                //企业账号验证，修改企业状态
                if ('accountbiz' == $data['module'] && 'text' ==$data['type']) {
                    $param = array('bizEmail' => $data['email']);
                    $accountBizDetail = $globalBase->findOneBy(Codes::ACCOUNT_BIZ_DETAIL, $param);
                    if (!empty($accountBizDetail)) {
                        $accountBiz = $globalBase->findOneBy(Codes::ACCOUNT_BIZ, array('bizId' => $accountBizDetail->getBizId()));
                        if (!empty($accountBiz)) {
                            $globalBase->update(array('Status' => 'inactive'), new AccountBiz(), $accountBiz);
                        }
                    }
                }
                $this->setParam('code', $code);
                $array = $this->getSuccess();
            } else {
                //提示链接过期
                if ($data['type'] == 'verify') {
                    $array = $this->getFailed(Errors::$ERROR_PARAMETER_LINK_EXPIRED);
                } else {
                    $array = $this->getFailed(Errors::$ERROR_PARAMETER_CODE_EXPIRED);
                }
            }
        }
        return $this->renderJson($array);
    }

    /**
     * 创建对邮件验证码操作
     * 注：参数content如果参数content 内容为空则发送验证码，如果不为空则需要拼接URL
     * 例：http://www.oradt.com/verification/email?code=%3C%7BUUID%7D%3E
     * @return type
     */
    public function postAction()
    {
        $request = $this->getRequest();
        //获取页面请求的参数
        $email   = $this->strip_tags($request->get('email')); //邮箱*必须
        $content = $request->get('content'); //验证内容*必须
        $module  = $this->strip_tags($request->get('module')); //验证模块*必须
        $title   = $this->strip_tags($request->get('title'));//邮件标题
        if (empty($email) || empty($module)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        //验证邮箱是否合法
        $functionService = $this->get("function_service");
        if(!$functionService->validateEmail($email)){
            return $this->renderJsonFailed ( Errors::$ERROR_EMAIL_FORMAT );
        }
        $globalBase = $this->container->get('global_base');
        $host   = $this->container->getParameter('HOST_URL');
        $random = new RandomString();
        $messageId = $random->make(32);     //获取40位字符串ID

        if (empty($content)) {
            $content = $messageId;
            $type ='verify';
        } else {
            $type ='text';
            $content = str_replace(array('%3C', '%7B', '%7D', '%3E'), array('<', '{', '}', '>'), $content);
            $content = str_replace('<{UUID}>', $messageId, $content);
        }
        if(empty($title)){
            $title="邮箱验证";
        }
        //验证的链接地址
        $url = $host . '/verification/email?code=' . $messageId;

        //基本信息赋值
        $emailMessage = array(
            'MessageId'     => $messageId, //ID
            'Email'         => $email, //邮箱
            'Type'          => $type, //类型
            'Content'       => $content, //内容
            'Module'        => $module, //验证模块
            'CreatedTime'   => new \DateTime() //创建时间
        );
        //添加数据
            $rs = $globalBase->execute($emailMessage, new EmailMessage());
            if ($rs) {
                //发送邮件
                /*$message = \Swift_Message::newInstance()
                    ->setSubject($title)
                    ->setFrom($this->container->getParameter("mailer_user"))
                    ->setTo($email)
                    ->setBody($content, "text/html")
                    ->setContentType("text/html");
                //->setBody($this->renderView('OradtStoreBundle:Verification:email.html.twig', array('url' => $url, 'host' => $host, 'code' => $messageId)));
                $this->get('mailer')->send($message);*/
                $this->sendMail($email,$title,$content);
                //设置缓存
                $emailInfo = $this->getEmailMessageByMid($messageId);
                if (!empty($emailInfo)) {
                    $cacheKey = $this->getCacheKey($messageId, $this->cache_pre);
                    $this->hmSetCache($cacheKey, $emailInfo);
                    $this->setCacheExpireTime($cacheKey);       //设置cache过期时间默认1小时
                }
                $array = $this->getSuccess();
            } else {
                $array = $this->getFailed(Errors::$ERROR_UNKNOWN);
            }
        return $this->renderJson($array);
    }
    /**
     * 根据messageId  获取邮件记录内容
     * @param string $messageid 
     */
    private function getEmailMessageByMid($messageid){
        $data       = array();
        $globalBase = $this->container->get('global_base');
        $param      = array('messageId'  => $messageid);
        $emailMess  = $globalBase->findOneBy(Codes::EMAIL_MESSAGE, $param);
        if(!empty($emailMess)){
            $data       = array(
                'code'      => $messageid ,
                'module'    => $emailMess->getModule(),
                'email'     => $emailMess->getEmail(),
                'type'      => $emailMess->getType(),
                'createtime'=> $emailMess->getCreatedTime()->format('Y-m-d H:i:s')
            );
        }
        return $data;
    }
    
}
