<?php
namespace Oradt\AuthorityBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EmployeeControllerTest extends WebTestCase
{

   

    public function testadd()
    {

        $client = static::createClient();
        
        $insertData = array();
        $insertData['emplid'] = 'test_empid' . time();
        $insertData['firstname'] = 'test_first';
        $insertData['lastname'] = 'test_last';
        $insertData['email'] = 'test_email';
        $insertData['mobile'] = 'test_mobile';
        $insertData['passwd'] = 'test_passwd';
        $insertData['roleid'] = 3;
        
        $cralwar = $client->request('POST', '/admin',$insertData);
        $this->assertRegExp('/ok/', $client->getResponse()->getContent());
    }

   
    public function testupdate()
    {
        //firstname=a&lastname=dddd&email=t@y.com&mobile=13222222222&passwd=123456&roleid=3&adminid=8
        $client = static::createClient();
        $insertData = array();
        $insertData['adminid'] = 13;
      //  $insertData['emplid'] = 'utest_empid' . time();
        $insertData['firstname'] = 'utest_first';
        $insertData['lastname'] = 'utest_last';
        $insertData['email'] = 'utest_email';
        $insertData['mobile'] = 'utest_mobile';
        $insertData['passwd'] = 'utest_passwd';
        $insertData['roleid'] = 4;
        $cralwar = $client->request('PUT', '/admin',$insertData);
        $this->assertEquals(200,  $client->getResponse()->getStatusCode());
        $this->assertRegExp('/"status":"ok"/', $client->getResponse()->getContent());
           
           
    }
   
   
    public function testdelete()
    {
        $client = static::createClient();
        $cralwar = $client->request('DELETE', '/admin', http_build_query(array('adminid'=>8)));
        $this->assertEquals(200,  $client->getResponse()->getStatusCode());
        $this->assertRegExp('/"ok"/', $client->getResponse()->getContent());
    }
    

}