<?php

namespace Oradt\ServiceBundle\Tests\Controller;
use Oradt\OauthBundle\Tests\Controller\BaseControllerTest;

class ContactSericeControllerTest extends BaseControllerTest
{
    private $service = null;
    protected function setUp()
    {       
        $this->init();
        $this->service = $this->getKernel()->getContainer()->get('account_contact_service');
    }    
    
    public function testCheckFriends() {
        $userId = 'Am0wQ6euzcpmFwKZbCK0rUGZU9kLi00000000002';
        $clientId = 'AGaqWlzLgQpVxd5MWBeVEqv8iFPka00000000001';
        $this->assertTrue( $this->service->checkFriends($userId,$clientId));
    }
    
    public function testFile() {
        $this->service = $this->getKernel()->getContainer()->get('account_document_service');
        //print_r();
        $url = $this->service->findFileUrl('7nGISISRMuMkW4elC6MBEIT6mAKVOAq5');
        echo $url;
        exit();
    }
}
