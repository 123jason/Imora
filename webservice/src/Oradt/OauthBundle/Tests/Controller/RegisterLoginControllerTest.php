<?php
/**
 * 
 * @author huangxm
 *
 */
namespace Oradt\OauthBundle\Tests\Controller;
use Oradt\OauthBundle\Tests\Controller\BaseControllerTest;
class RegisterLoginControllerTest extends BaseControllerTest
{
    private $account_basic = 'aaaaa1@163.com';
    private $account_basic_2 = 'aaaaa2@163.com';
    private $account_biz = 'biz@163.com';
    /**
     * basic account register
     */
    public function testBasicPost()
    {
        $this->init(self::ACCOUNT_UNOAUTH);
        $time = time();
        $this->getConnection()->executeQuery("update account_basic set mobile='{$time}',email='{$time}' WHERE email='{$this->account_basic}'");
        
        $client = static::createClient();
        $postdata = array(
                'mobile'=>'13522723131',
                'email'=>$this->account_basic,
                'passwd'=>'123456',
                'realname'=>'huang',
                'nickname'=>'nk',
                'gender'=>'m',
                'birthday'=>'2012-01-10',
                'ip'=>'127.0.0.1');
        $client = static::createClient();
        $cralwar = $client->request('POST', '/account',$postdata);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $result = json_decode( $client->getResponse()->getContent() ,true);
        $this->assertRegExp('/"head":{"status":0/', $client->getResponse()->getContent());
        $clientid = $result['body']['clientid'];
        $this->setUserConfig( array( 'clientid' => $clientid)) ;        
    }

    /**
     * basic account login
     */
    public function testBasicLogin() {
        $this->init(self::ACCOUNT_UNOAUTH);
        $data = $this->getUserConfig();
        $client = static::createClient();
        $postdata = array(
                'type'=>'basic',
                'user'=>$this->account_basic,
                'passwd'=>'123456',                
                'ip'=>'127.0.0.1');
        $cralwar = $client->request('POST', '/oauth',$postdata);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $result = json_decode( $client->getResponse()->getContent() ,true);
        $data['token'] = $result['body']['accesstoken'];
        $data['type'] = $postdata['type'];
        $this->setUserConfig($data);
        $this->assertRegExp('/"head":{"status":0/', $client->getResponse()->getContent());
    }
    
    /**
     * basic account register
     */
    public function testBasic2Post()
    {
        $this->init(self::ACCOUNT_UNOAUTH);
        $time = time();
        $this->getConnection()->executeQuery("update account_basic set mobile='{$time}',email='{$time}' WHERE email='{$this->account_basic_2}'");
        
        $client = static::createClient();
        $postdata = array(
                'mobile'=>'13622723131',
                'email'=>$this->account_basic_2,
                'passwd'=>'123456',
                'realname'=>'huang3',
                'nickname'=>'nk',
                'gender'=>'m',
                'birthday'=>'2012-01-10',
                'ip'=>'127.0.0.1');
        $client = static::createClient();
        $cralwar = $client->request('POST', '/account',$postdata);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $result = json_decode( $client->getResponse()->getContent() ,true);
        $this->assertRegExp('/"head":{"status":0/', $client->getResponse()->getContent());
        $clientid = $result['body']['clientid'];
        $this->setUserConfig( array( 'clientid' => $clientid) ,self::ACCOUNT_BASIC_2) ;        
    }

    /**
     * basic account login
     */
    public function testBasic2Login() {
        $this->init(self::ACCOUNT_UNOAUTH);
        $data = $this->getUserConfig(self::ACCOUNT_BASIC_2);
        $client = static::createClient();
        $postdata = array(
                'type'=>'basic',
                'user'=>$this->account_basic_2,
                'passwd'=>'123456',                
                'ip'=>'127.0.0.1');
        $cralwar = $client->request('POST', '/oauth',$postdata);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $result = json_decode( $client->getResponse()->getContent() ,true);
        $data['token'] = $result['body']['accesstoken'];
        $data['type'] = $postdata['type'];
        $this->setUserConfig($data,self::ACCOUNT_BASIC_2);
        $this->assertRegExp('/"head":{"status":0/', $client->getResponse()->getContent());
    }

    /**
     * admin account login
     */
    public function testAdminLogin() {
        $this->init(self::ACCOUNT_UNOAUTH);
        $data = $this->getUserConfig();
        $client = static::createClient();
        $postdata = array(
                'type'=>'admin',
                'user'=>'admin@qq.com',
                'passwd'=>'123456',                
                'ip'=>'127.0.0.1');
        $cralwar = $client->request('POST', '/oauth',$postdata);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $result = json_decode( $client->getResponse()->getContent() ,true);
        $data['token'] = $result['body']['accesstoken'];
        $data['type'] = $postdata['type'];
        $this->setUserConfig($data,self::ACCOUNT_ADMIN);
        $this->assertRegExp('/"head":{"status":0/', $client->getResponse()->getContent());
    }
    
    /**
     * biz account register
     */
    public function testBizPost()
    {
        $userData = $this->getUserConfig(self::ACCOUNT_BIZ);
        //if(!empty($userData) && isset($userData['clientid'])) {
            $this->getConnection()->executeQuery("DELETE FROM account_biz WHERE user_name=:user_name",
                    array(':user_name' => $this->account_biz));
            $this->getConnection()->executeQuery("DELETE FROM account_biz_detail WHERE biz_email=:user_name",
                    array(':user_name' => $this->account_biz));
        //}
        $this->init(self::ACCOUNT_UNOAUTH);
        
        $client = static::createClient();
        $postdata = array(
                'user'=> $this->account_biz,
                'email'=>$this->account_biz,
                'passwd'=>'a_c123456',
                'name'=>'bizname_test' . \Oradt\Utils\RandomString::make(5),
                'type' => 'tpyeaaa',
                'region' => 'region',
                'size' => 22,
                'ip'=>'127.0.0.1');
        $client = static::createClient();
        $cralwar = $client->request('POST', '/accountbiz',$postdata);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $result = json_decode( $client->getResponse()->getContent() ,true);
        $this->assertRegExp('/"head":{"status":0/', $client->getResponse()->getContent());
        $clientid = $result['body']['clientid'];
        $this->setUserConfig( array( 'clientid' => $clientid) , self::ACCOUNT_BIZ) ;        
    }
    
    /**
     * biz account login
     */
    public function testBizLogin() {
        $this->init();
        $data = $this->getUserConfig(self::ACCOUNT_BIZ);
        $client = static::createClient();
        $postdata = array(
                'type'=>'biz',
                'user'=>$this->account_biz,
                'passwd'=>'a_c123456',
                'ip'=>'127.0.0.1');
        $cralwar = $client->request('POST', '/oauth',$postdata);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $result = json_decode( $client->getResponse()->getContent() ,true);
        $data['token'] = $result['body']['accesstoken'];
        $data['type'] = $postdata['type'];
        $this->setUserConfig($data,self::ACCOUNT_BIZ);
        $this->assertRegExp('/"head":{"status":0/', $client->getResponse()->getContent());
    }
}
