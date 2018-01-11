<?php

namespace Oradt\ServiceBundle\Services\File;

/**
 * 华兴软通短信接口服务(HTTP)
 */
class FileHxSmsService
{

    private $strReg = "";                     //注册号(由华兴软通提供)
    private $strPwd = "";                     //密码(由华兴软通提供)
    private $strSourceAdd = "";               //子通道号，可为空（预留参数一般为空）
    private $sendSmsUrl = "";                 //发送即时短信的Http接口地址  
    private $container;

    /**
     * __construct
     * @param $container
     */
    public function __construct($container)
    {
        $this->container = $container;
        $this->strReg = $this->container->getParameter('SMS_HX_USER');
        $this->strPwd = $this->container->getParameter('SMS_HX_PASSWD');
        $this->strSourceAdd = "";
        $this->sendSmsUrl = $this->container->getParameter('SMS_HX_URL');
    }

    /**
     * 发送即时短信
     * @param string $mobiles   手机号码，多个手机号用半角逗号分开
     * @param string $content   短信内容
     * @return string   result=0&message=短信发送成功&smsid=20140917131429103
     */
    public function sendSms($mobiles, $content)
    {
        if (is_array($mobiles)) {
            $mobiles = implode(',', $mobiles);
        }
        $strSmsParam = "reg=" . $this->strReg . "&pwd=" . $this->strPwd . "&sourceadd=" . $this->strSourceAdd . "&phone=" . $mobiles . "&content=" . $content;
        $strRes = $this->postSend($this->sendSmsUrl, $strSmsParam);
        return $strRes;
    }

    /**
     * 获取
     * @param type $url
     * @param type $param
     * @return type
     */
    public function getSend($url, $param)
    {
        $ch = curl_init($url . "?" . $param);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        $output = curl_exec($ch);
        return $output;
    }

    /**
     * 发送短信
     */
    public function postSend($url, $param)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    /**
     * 字符编码转换
     */
    function gbkToUtf8($str)
    {
        return rawurlencode(iconv('GB2312', 'UTF-8', $str));
    }

}

?>
