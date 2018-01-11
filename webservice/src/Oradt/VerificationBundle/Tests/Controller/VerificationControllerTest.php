<?php
/**
 * 验证测试控制器（短信、邮箱）
 * create by 2015-01-29
 * @author xuejiao <xuejiao@oradt.com>
 */
namespace Oradt\VerificationBundle\Tests\Controller;

use Oradt\OauthBundle\Tests\Controller\BaseControllerTest;

class VerificationControllerTest extends BaseControllerTest
{
    protected $emailUrl     = '/verification/email';
    protected $smsUrl       = '/verification/sms';
    protected $email        = 'xuejiao@oradt.com';  //发送邮箱验证地址
    protected $module       = 'test_module';        //验证模块
    protected $mobile       = '18600628803';        //发送手机验证号码

    //初始化token
    protected function setUp(){
        $this->init();
    }
    /**
     * 发送短信test
     */
    public function testSmsPost(){
        $client     = static::createClient(array(),$this->headers);
        $insertData = array(
            'mobile'   => $this->mobile,
            'module'   => $this->module
        );
        $cralwar    = $client->request('POST', $this->smsUrl,$insertData,array());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $result     = json_decode( $client->getResponse()->getContent() ,true);
        $messageid  = $result['body']['messageid'];
        $this->assertRegExp('/"head":{"status":0/', $client->getResponse()->getContent());
        return $messageid;
    }
    
    /**
     * 验证短信
     * @depends testSmsPost
     */
    public function testSmsGet($messageid){
        $client = static::createClient(array(),$this->headers);
        $sql    = "SELECT s.mobile,s.content FROM sms_message as s where s.sms_id = '{$messageid}' limit 1";
        $smsArr =  $this->getConnection()->executeQuery($sql)->fetch();
        $getParam    = array(
            'mobile'    => $smsArr['mobile'],
            'messageid' => $messageid,
            'code'      => $smsArr['content']
        );
        $cralwar = $client->request('GET', $this->smsUrl,$getParam);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertRegExp('/"head":{"status":0/', $client->getResponse()->getContent());
    }
    
    /*-----------------邮箱验证--------------------*/
    /**
     * 发送邮箱验证test
     */
    public function testEmailPost(){
        $client     = static::createClient(array(),$this->headers);
        $insertData = array(
            'email'     => $this->email,
            'content'   => 'test_content:<{UUID}>',
            'module'    => $this->module
        );
        $cralwar    = $client->request('POST', $this->emailUrl,$insertData,array());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertRegExp('/"head":{"status":0/', $client->getResponse()->getContent());
    }
    /**
     * 验证邮件
     */
    public function testEmailGet(){
        $client = static::createClient(array(),$this->headers);
        $sql    = "SELECT s.message_id FROM email_message as s where s.email = '{$this->email}' AND s.module = '{$this->module}' ORDER BY id desc limit 1";
        $emailArr =  $this->getConnection()->executeQuery($sql)->fetch();
        $getParam = array(
                'code' => $emailArr['message_id']
        );
        $cralwar = $client->request('GET', $this->emailUrl,$getParam);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertRegExp('/"head":{"status":0/', $client->getResponse()->getContent());
    }
}
