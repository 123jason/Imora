<?php
/**
 * predis
 * @author xuejiao
 */
namespace Oradt\ServiceBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
require_once dirname(__FILE__) . '/../../../Predis/src/Autoloader.php';
//use Predis\Autoloader;
//use Predis\Client;

class PredisService {
    private $container = null;
    private static $client    = null;
    
    private $active  = false;
    private $servers = array(
        //'tcp://192.168.30.102:7001', 
        //'tcp://192.168.30.102:7002', 
        //'tcp://192.168.30.102:7003',
        //'tcp://192.168.30.107:7001', 
        //'tcp://192.168.30.107:7002', 
        //'tcp://192.168.30.107:7003',
    );
    private $options = array('cluster' => 'redis'); 


    public function __construct(ContainerInterface $container){
        $this->container = $container;
        if($this->container->getParameter('redis_open')){
            $this->active   = true;
            $this->servers  = $this->getServers();
            if(null === self::$client){
                self::$client   = $this->connect ($this->servers, $this->options );
            }
        }
    }
    
    public function getServers(){
        $predisServer = $this->container->getParameter('predis_clusters');
        return explode(";",$predisServer);
    }

    public function isActive(){
        return $this->active;
    }
    /**
     * 连接服务
     */
    public function connect($servers, $options){
         \Predis\Autoloader::register();
        $client = new \Predis\Client($servers, $options);  
        return $client;
    }
    
    public function __call($method, $args = array()) {
        if(!$this->isActive()) {
            return false;
        }
        return call_user_func_array ( array (
                self::$client,
                $method
        ), $args );
    }
    
    /**
     * 断开连接
     */
    public function disConnect(){
        if(!$this->isActive()) {
            return false;
        }
        self::$client->disconnect();
    }
    
}


