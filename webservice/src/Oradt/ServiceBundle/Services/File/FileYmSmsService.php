<?php

namespace Oradt\ServiceBundle\Services\File;

require_once dirname(__FILE__) . '/Sms/Client.php';

use Client;
/**
 * $client->setOutgoingEncoding("GBK");
  $client->login();
  login();   //激活序列号
  updatePassword();  //修改密码
  logout();          //注销序列号
  registDetailInfo();//注册企业信息
  getEachFee();      //得到单价
  getMO();           //接收短信
  getVersion();      //得到版本号
  sendSMS();         //发送短信
  getBalance();      //得到余额
  chargeUp();        //充值
  sendVoice();        //发送短信验证码
  ----------------------------------------------------------------------
  注:
  1. 下面是各接口的使用用例，Client.php 还有每一个接口更详细的参数说明
  2. 凡是返回 $statusCode 的, 都是相关操作的状态码
  3. 由于php是弱类型语言，当服务端没返回时，也会等同认为 $statusCode=='0', 所以在判断时应该使用 if ($statusCode!=null && $statusCode==0)
  ----------------------------------------------------------------------
 * @package  File_Sms
 * @author   Zhiqiang xie <xiezq@oradt.com>
 * @version  Release: 0.0.0
 */
class FileYmSmsService
{
    private $container;
    private $client;

    private $gwUrl;                         //短信网关地址
    private $serialNumber;                  //序列号,请通过亿美销售人员获取
    private $password;                      //密码,请通过亿美销售人员获取
    private $sessionKey =  'oradt!123';     //登录后所持有的SESSION KEY，即可通过login方法时创建
    private $connectTimeOut = 2;            //连接超时时间，单位为秒
    private $readTimeOut    = 10;           //远程信息读取超时时间，单位为秒
    
    private $proxyhost = false;             //可选，代理服务器地址，默认为 false ,则不使用代理服务器
    private $proxyport = false;             //可选，代理服务器端口，默认为 false
    private $proxyusername = false;         //可选，代理服务器用户名，默认为 false
    private $proxypassword = false;         //可选，代理服务器密码，默认为 false
    
    function __construct($container)
    {
        $this->container = $container;
        $this->setUseAccount('verify');     //默认使用验证类短信
    }

    /**
     * 选择使用哪个账户来发送短信
     * info：信息类短信  verify：验证类短信 marketing：营销类短信
     */
    public function setUseAccount($useAccount){
        switch ($useAccount){
            case 'verify':          //验证类短信使用账号（验证码）
                $this->gwUrl        = $this->container->getParameter('SMS_YM_URL');
                $this->serialNumber = $this->container->getParameter('SMS_YM_USER');
                $this->password     = $this->container->getParameter('SMS_YM_PASSWD');
                break;
            case 'info':            //信息类 通知类 内部使用
                $this->gwUrl        = $this->container->getParameter('SMS_YM_INFO_URL');
                $this->serialNumber = $this->container->getParameter('SMS_YM_INFO_USER');
                $this->password     = $this->container->getParameter('SMS_YM_INFO_PASSWD');
                break;
            case 'marketing':       //营销类短信 推广使用
                $this->gwUrl        = $this->container->getParameter('SMS_YM_MARKETING_URL');
                $this->serialNumber = $this->container->getParameter('SMS_YM_MARKETING_USER');
                $this->password     = $this->container->getParameter('SMS_YM_MARKETING_PASSWD');
                break;
            case 'marketwo':       //营销类短信2 备用
                $this->gwUrl        = $this->container->getParameter('SMS_YM_MARKETWO_URL');
                $this->serialNumber = $this->container->getParameter('SMS_YM_MARKETWO_USER');
                $this->password     = $this->container->getParameter('SMS_YM_MARKETWO_PASSWD');
                break;
        }
        $this->client = $this->connect($this->gwUrl,$this->serialNumber,$this->password,
                $this->sessionKey,$this->proxyhost,$this->proxyport,$this->proxyusername, 
                $this->proxypassword,$this->connectTimeOut,$this->readTimeOut);
    }
    
    /**
     * 创建连接
     */
    public function connect($gwUrl,$serialNumber,$password,$sessionKey,$proxyhost,$proxyport,$proxyusername,$proxypassword,$connectTimeOut, $readTimeOut){
        $client = new Client($gwUrl,$serialNumber,$password,$sessionKey,$proxyhost,$proxyport,$proxyusername,$proxypassword,$connectTimeOut, $readTimeOut);      
        return $client;
    }
    /**
     * 短信发送 用例
     * int  $seqId  短信唯一标示 获取短信发送报告时使用
     */
    public function sendSms($mobile, $message,$seqId)
    {
        if (!is_array($mobile)) {
            $mobile = explode(',', $mobile);
        }
        $statusCode = $this->client->sendSMS($mobile, iconv("UTF-8", "GBK", $message),'','','GBK',5,$seqId);
        return $statusCode;
    }
    
    /**
     * 接口调用错误查看 用例
     */
    public function chkError()
    {
        $err = $this->client->getError();
        if ($err) {
            /**
             * 调用出错，可能是网络原因，接口版本原因 等非业务上错误的问题导致的错误
             * 可在每个方法调用后查看，用于开发人员调试
             */
            echo $err;
        }
    }

    /**
     * 登录 用例
     */
    public function login()
    {
        /**
         * 下面的操作是产生随机6位数 session key
         * 注意: 如果要更换新的session key，则必须要求先成功执行 logout(注销操作)后才能更换
         * 我们建议 sesson key不用常变
         */
        //$sessionKey = $this->client->generateKey();
        //$statusCode = $this->client->login($sessionKey);

        $statusCode = $this->client->login();

        echo "处理状态码:" . $statusCode . "<br/>";
        if ($statusCode != null && $statusCode == "0") {
            //登录成功，并且做保存 $sessionKey 的操作，用于以后相关操作的使用
            echo "登录成功, session key:" . $this->client->getSessionKey() . "<br/>";
        } else {
            //登录失败处理
            echo "登录失败,返回:" . $statusCode;
        }
    }

    /**
     * 注销登录 用例
     */
    public function logout()
    {
        $statusCode = $this->client->logout();
        echo "处理状态码:" . $statusCode;
    }
    
    /**
     * 获取短信发送报告
     */
    public function getReport(){
        $reportList = $this->client->getReport();
        return $reportList;
    }

    /**
     * 获取版本号 用例
     */
    public function getVersion()
    {
        echo "版本:" . $this->client->getVersion();
    }

    /**
     * 取消短信转发 用例
     */
    public function cancelMOForward()
    {
        $statusCode = $this->client->cancelMOForward();
        echo "处理状态码:" . $statusCode;
    }

    /**
     * 短信充值 用例
     */
    public function chargeUp()
    {
        /**
         * $cardId [充值卡卡号]
         * $cardPass [密码]
         * 
         * 请通过亿美销售人员获取 [充值卡卡号]长度为20内 [密码]长度为6
         * 
         */
        $cardId = 'EMY01200810231542008';
        $cardPass = '123456';
        $statusCode = $this->client->chargeUp($cardId, $cardPass);
        echo "处理状态码:" . $statusCode;
    }

    /**
     * 查询单条费用 用例
     */
    public function getEachFee()
    {
        $fee = $this->client->getEachFee();
        echo "费用:" . $fee;
    }

    /**
     * 企业注册 用例
     */
    public function registDetailInfo()
    {
        $eName = "北京橙鑫数据科技有限公司";
        $linkMan = "陈xx";
        $phoneNum = "010-1111111";
        $mobile = "13120469611";
        $email = "xx@yy.com";
        $fax = "010-1111111";
        $address = "xx路";
        $postcode = "111111";

        /**
         * 企业注册  [邮政编码]长度为6 其它参数长度为20以内
         * 
         * @param string $eName 	企业名称
         * @param string $linkMan 	联系人姓名
         * @param string $phoneNum 	联系电话
         * @param string $mobile 	联系手机号码
         * @param string $email 	联系电子邮件
         * @param string $fax 		传真号码
         * @param string $address 	联系地址
         * @param string $postcode  邮政编码
         * 
         * @return int 操作结果状态码
         * 
         */
        $statusCode = $this->client->registDetailInfo($eName, $linkMan, $phoneNum, $mobile, $email, $fax, $address, $postcode);
        echo "处理状态码:" . $statusCode;
    }

    /**
     * 更新密码 用例
     */
    public function updatePassword()
    {
        /**
         * [密码]长度为6
         * 
         * 如下面的例子是将密码修改成: 654321
         */
        $statusCode = $this->client->updatePassword('654321');
        echo "处理状态码:" . $statusCode;
    }

    /**
     * 短信转发 用例
     */
    public function setMOForward()
    {
        /**
         * 向 159xxxxxxxx 进行转发短信
         */
        $statusCode = $this->client->setMOForward('159xxxxxxxx');
        echo "处理状态码:" . $statusCode;
    }

    /**
     * 得到上行短信 用例
     */
    public function getMO()
    {

        $moResult = $this->client->getMO();
        echo "返回数量:" . count($moResult);
        foreach ($moResult as $mo) {
            //$mo 是位于 Client.php 里的 Mo 对象
            // 实例代码为直接输出
            echo "发送者附加码:" . $mo->getAddSerial();
            echo "接收者附加码:" . $mo->getAddSerialRev();
            echo "通道号:" . $mo->getChannelnumber();
            echo "手机号:" . $mo->getMobileNumber();
            echo "发送时间:" . $mo->getSentTime();

            /**
             * 由于服务端返回的编码是UTF-8,所以需要进行编码转换
             */
            echo "短信内容:" . iconv("UTF-8", "GBK", $mo->getSmsContent());

            // 上行短信务必要保存,加入业务逻辑代码,如：保存数据库，写文件等等
        }
    }

    /**
     * 发送语音验证码 用例
     */
    public function sendVoice()
    {
        /**
         * 下面的代码将发送验证码123456给 159xxxxxxxx 
         * $this->client->sendSMS还有更多可用参数，请参考 Client.php
         */
        $statusCode = $this->client->sendVoice(array('159xxxxxxxx'), "123456");
        echo "处理状态码:" . $statusCode;
    }

    /**
     * 余额查询 用例
     */
    public function getBalance()
    {
        $balance = $this->client->getBalance();
        echo "余额:" . $balance;
    }
    /**
     * 查询 余额查询 做统计使用
     */
    public function getBalanceNum()
    {
        return $balance = $this->client->getBalance();
    }
    
    /**
     * 余额查询 用例
     */
    public function getSessionKey()
    {
        $balance = $this->client->getSessionKey();
        echo "getSessionKey:" . $balance;
    }

    /**
     * 短信转发扩展 用例
     */
    public function setMOForwardEx()
    {
        /**
         * 向多个号码进行转发短信
         * 
         * 以数组形式填写手机号码
         */
        $statusCode = $this->client->setMOForwardEx(
            array('159xxxxxxxx', '159xxxxxxxx', '159xxxxxxxx')
        );
        echo "处理状态码:" . $statusCode;
    }

}

