<?php
/**
 * Test base class
 * @author huangxm
 *
 */

namespace Oradt\OauthBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\Common\Cache\PhpFileCache;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class BaseControllerTest extends WebTestCase
{
    protected $headers = array();
    protected $container = null;
    protected $config = array(
          'userId'  => 'AXg4HDnk5HyDQ9K2K2DAHSrORbKGc00000000003'
    );
    
    const ACCOUNT_BASIC = 'basic' ;
    const ACCOUNT_BASIC_2 = 'basic_2' ;
    const ACCOUNT_BIZ = 'biz' ; 
    const ACCOUNT_ADMIN = 'admin';
    const ACCOUNT_UNOAUTH = 'unoauth';
    private $path = null;
    /**
     * loading token &　container
     * @param string $type
     */
    protected function init( $type = self::ACCOUNT_BASIC) {
        $kernel = $this->getKernel();
        $this->container = $kernel->getContainer();
        
        if(!in_array($type,array(self::ACCOUNT_ADMIN,self::ACCOUNT_BASIC,self::ACCOUNT_BIZ , self::ACCOUNT_BASIC_2)))
            return;
        $userData = $this->getUserConfig($type);
        if(isset($userData['clientid'])) {
            $this->config['userId'] = $userData['clientid'];
        }
        
        if(isset($userData['token']))
        {
            $this->headers['HTTP_accesstoken'] = $userData['token'];            
        }else 
            $this->headers['HTTP_accesstoken'] = 'aaaaa';
        
    }
    
    protected function getKernel() {
        $kernel = static::createKernel();
        $kernel->boot();
        return $kernel;
    }
    
    /**
     * 
     * geting db connection
     * @return \Doctrine\DBAL\Connection
     */
    protected function getConnection() {
        return $this->getKernel()->getContainer()->get("account_contact_service")->getConnection();
    }
    
    /**
     * set user config
     * @param array $data
     * @param string $type
     */
    public function setUserConfig ($data,$type = self::ACCOUNT_BASIC) {
        $type.='_login_info';
        $kernel = $this->getKernel();
        $cacheDriver = new PhpFileCache($kernel->getCacheDir());
        $cacheDriver->save($type,serialize( $data ));
    }
    
    /**
     * get user config
     * @param string $type
     * @return array()
     */
    public function getUserConfig ($type = self::ACCOUNT_BASIC) {
        $type.='_login_info';
        $kernel = $this->getKernel();
        $cacheDriver = new PhpFileCache($kernel->getCacheDir());        
        $data = array();
        $cache = $cacheDriver->fetch($type);
        if(!empty($cache))
            $data = unserialize($cache);
        return $data;
    }
    
    /**
     * query trash Id from document Id
     * @param string $documentId
     * @return string
     */
    protected function getTrash($documentId) {
        $query = "SELECT trash_id FROM trash WHERE document_id='{$documentId}' LIMIT 1";
        return $this->getConnection()->executeQuery($query)->fetchColumn(0);
    }
    
    /**
     * construct Upload File object from path 
     * @param string $path
     * @param string originalName
     * @return \Symfony\Component\HttpFoundation\File\UploadedFile
     */
    public function getUploadedFile($path) {
        $originalName = basename($path);
        $temp_file = tempnam(sys_get_temp_dir(), 'test');
        file_put_contents($temp_file, file_get_contents($path));
        $upfile = new UploadedFile($temp_file,$originalName,null,filesize($path));
        return $upfile;
    }
    
    /**
     * geting current class directory path
     * @return string
     */
    public function getPath()
    {
        if (null === $this->path) {
            $reflected = new \ReflectionObject($this);
            $this->path = dirname($reflected->getFileName());// . $reflected->getName();//var_dump($reflected);
        }        
        return $this->path ;
    }
}
