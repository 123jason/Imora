<?php
/**
 * @author wangxy
 */

namespace Oradt\AuthorityBundle\Tests\Controller;
use Oradt\OauthBundle\Tests\Controller\BaseControllerTest;

class EmployeeController2Test extends BaseControllerTest
{
    public function testRolePost(){
        $this->init(self::ACCOUNT_ADMIN);
        $client = static::createClient(array(),$this->headers);
        $insertData = array();
        $insertData['name'] = 'test_rolename1';
        $insertData['dispname'] = 'test_showname';
        $insertData['permission'] = 'test_authority';

        $client->request('POST', '/admin/role', $insertData);
        $result = json_decode($client->getResponse()->getContent(),true);
        $roleid = $result['body']['roleid'];
        $this->assertRegExp('/"status":0/', $client->getResponse()->getContent());
        return $roleid;
    }

    /**
     *@depends testRolePost
     */
    public function testRolePut($roleid)
    {
        $this->init(self::ACCOUNT_ADMIN);
        $client = static::createClient(array(),$this->headers);
        $insertData = array();
        $insertData['roleid'] = $roleid;
        $insertData['name'] = 'test_rolename_update';
        $insertData['dispname'] = 'test_showname';
        $insertData['permission'] = 'test_authority';
        $client->request('PUT', '/admin/role', $insertData);
        $this->assertRegExp('/"status":0/', $client->getResponse()->getContent());
    }

    /**
     * @depends testRolePost
     */
    public function testRoleGet($roleid)
    {
        $this->init(self::ACCOUNT_ADMIN);
        $client = static::createClient(array(), $this->headers);
        $insertData = array();
        $insertData['roleid'] = $roleid;
        $insertData['name'] = 'test_rolename_update';
        $insertData['dispname'] = 'test_showname';
        $insertData['permission'] = 'test_authority';
        $client->request('GET', '/admin/role', $insertData);
        var_dump($client->getResponse()->getContent());
        $this->assertRegExp('/"status":0/', $client->getResponse()->getContent());


    }
    /**
     * @depends testRolePost
     */
    public function testAdminPost($roleid)
    {
        var_dump($roleid);
        $this->init(self::ACCOUNT_ADMIN);
        $client = static::createClient(array(), $this->headers);
        $insertData = array();
        $insertData['realname'] = 'test_realname3';
        $insertData['passwd'] = 'test_email3';
        $insertData['email'] = 'test_email3@163.com';
        $insertData['mobile'] = '13521238212';
        $insertData['roleid'] = $roleid;
        $client->request('POST', '/admin', $insertData);
        var_dump($client->getResponse()->getContent());
        $result = json_decode($client->getResponse()->getContent(),true);
        $adminid = $result['body']['adminid'];
        $this->assertRegExp('/"status":0/', $client->getResponse()->getContent());
        return $adminid;
    }

    /**
     * @depends testRolePost
     * @depends testAdminPost
     */
    public function testAdminUpdate($roleid,$adminid)
    {
        $this->init(self::ACCOUNT_ADMIN);
        $client = static::createClient(array(), $this->headers);
        $insertData = array();
        $insertData['adminid'] = $adminid;
        $insertData['realname'] = 'test_realname3_update';
        $insertData['passwd'] = 'test_email3';
        $insertData['email'] = 'test_email3@163.com';
        $insertData['mobile'] = '13521238212';
        $insertData['roleid'] = $roleid;
        $cralwar = $client->request('PUT', '/admin', $insertData);
        $this->assertRegExp('/"status":0/', $client->getResponse()->getContent());
    }

    /**
     * @depends testRolePost
     * @depends testAdminPost
     */
    public function testAdminGet($roleid,$adminid)
    {
        $this->init(self::ACCOUNT_ADMIN);
        $client = static::createClient(array(), $this->headers);
        $insertData = array();
        $insertData['adminid'] = $adminid;
        $insertData['realname'] = 'test_realname2_update';
        $insertData['email'] = 'test_email2@163.com';
        $insertData['mobile'] = '13521238212';
        $insertData['roleid'] = $roleid;
        //inactive,deleted
        $insertData['state'] = 'active';
        $client->request('GET', '/admin', $insertData);
        var_dump($client->getResponse()->getContent());
        $this->assertRegExp('/"status":0/', $client->getResponse()->getContent());
    }

    /**
     * @depends testAdminPost
     */
    public function testAdminDelete($adminid)
    {
        $this->init(self::ACCOUNT_ADMIN);
        $client = static::createClient(array(), $this->headers);
        $client->request('DELETE', '/admin', array('adminid' => $adminid));
        $this->assertRegExp('/"status":0/', $client->getResponse()->getContent());
    }

    /**
     * @depends testRolePost
     */
    public function testRoleDelete($roleid)
    {
        $this->init(self::ACCOUNT_ADMIN);
        $client = static::createClient(array(),$this->headers);
        $client->request('DELETE', '/admin/role', array('roleid' => $roleid));
        //$this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertRegExp('/"status":0/', $client->getResponse()->getContent());
    }
}