<?php
/**
 * redis class
 * @author huangxm
 *
 */
namespace Oradt\ServiceBundle\Services;
use Symfony\Component\DependencyInjection\ContainerInterface;
class RedisService extends \Redis {
   // private $redis = null;
    private $container = null;
    public function __construct(ContainerInterface $container) {
        parent::__construct();
        $this->container = $container;    
        $this->initRedis();
        
    }
    /**
     * 初始化redis默认连接
     */
    public function initRedis(){
        $this->setRedis($this->container->getParameter('redis_host'),
                $this->container->getParameter('redis_port'),
                $this->container->getParameter('redis_password'));
    }
    /**
     * 设置redis连接
     * @param string $host
     * @param string $port
     * @param string $authPassword
     */
    public function setRedis($host,$port='6379',$authPassword=''){
        //$this->redis = new \Redis();
        $this->connect($host,$port);
        if(!empty($authPassword)){
            $this->auth($authPassword);
        }
    }
}