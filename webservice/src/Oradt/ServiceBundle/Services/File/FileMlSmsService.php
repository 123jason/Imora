<?php

namespace Oradt\ServiceBundle\Services\File;

/**
 * 美联短信平台接口--接口服务(HTTP)
 */
class FileMlSmsService
{

    private $strUsername = "";    //注册号(由华兴软通提供)
    private $strPwd      = "";    //密码(由华兴软通提供)
    private $strApiKey   = "";    //apikey秘钥（请登录 http://m.5c.com.cn 短信平台-->账号管理-->我的信息 中复制apikey）
    private $sendSmsUrl  = "";    //如连接超时，可能是您服务器不支持域名解析，请将下面连接中的：【m.5c.com.cn】修改为IP：【115.28.23.78】
    private $encode      = "UTF-8";  //页面编码和短信内容编码为GBK。重要说明：如提交短信后收到乱码，请将GBK改为UTF-8测试。如本程序页面为编码格式为：ASCII/GB2312/GBK则该处为GBK。如本页面编码为UTF-8或需要支持繁体，阿拉伯文等Unicode，请将此处写为：UTF-8
    private $container;

    /**
     * __construct
     * @param $container
     */
    public function __construct($container)
    {
        $this->container    = $container;
        $this->strUsername  = 'bjcx';       //用户名
        $this->strPwd       = 'asdf123';    //密码
        $this->strApiKey    = 'be532d517a9f90e605194b298468c1e2';     
        $this->sendSmsUrl = "http://m.5c.com.cn/api/send/index.php?"; //如连接超时，可能是您服务器不支持域名解析，请将下面连接中的：【m.5c.com.cn】修改为IP：【115.28.23.78】
    }

    
    /**
     * 发送即时短信
     * @param string $mobiles   手机号码，多个手机号用半角逗号分开 国内短信前面需加 86
     * @param string $content   短信内容
     * @return string   result > -1 提交成功  否则提交失败
     */
    public function sendSMS($mobile,$content)
    {
         //发送链接（用户名，密码，apikey，手机号，内容）
         //$content = iconv("GBK","UTF-8",$content);
         $contentUrlEncode = urlencode($content);  //执行URLencode编码  ，$content = urldecode($content);解码
         $data=array(
             'username'     => $this->strUsername,
             'password_md5' => md5($this->strPwd),
             'apikey'   => $this->strApiKey,
             'mobile'   => $mobile,
             'content'  => $contentUrlEncode,
             'encode'   => $this->encode, 
         );
         $result = $this->curlSMS($this->sendSmsUrl,$data);
         return $result;
     }

    /**
     * 发送短信
     */
    public function curlSMS($url,$post_fields=array())
    {
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);//用PHP取回的URL地址（值将被作为字符串）
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);//使用curl_setopt获取页面内容或提交数据，有时候希望返回的内容作为变量存储，而不是直接输出，这时候希望返回的内容作为变量
        curl_setopt($ch,CURLOPT_TIMEOUT,30);//30秒超时限制
        curl_setopt($ch,CURLOPT_HEADER,1);//将文件头输出直接可见。
        curl_setopt($ch,CURLOPT_POST,1);//设置这个选项为一个零非值，这个post是普通的application/x-www-from-urlencoded类型，多数被HTTP表调用。
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post_fields);//post操作的所有数据的字符串。
        $data = curl_exec($ch);//抓取URL并把他传递给浏览器
        curl_close($ch);//释放资源
        $res = explode("\r\n\r\n",$data);//explode把他打散成为数组
        return $res[2]; //然后在这里返回数组。
    }

    /**
     * 字符编码转换
     */
    function gbkToUtf8($str)
    {
        return rawurlencode(iconv('GB2312', 'UTF-8', $str));
    }

}


