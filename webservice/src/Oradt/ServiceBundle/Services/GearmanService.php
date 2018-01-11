<?php

namespace Oradt\ServiceBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Serializer\Exception\Exception;
use Symfony\Component\DependencyInjection\ContainerInterface;

class GearmanService extends BaseService
{
    public $work;
    public $client;
    public $job;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);        

        if (class_exists('GearmanClient')) {
            $this->client = new \GearmanClient();
            //$this->client->setTimeout(5000);
            if($this->container->hasParameter('gearman_server')){
                $gearmanServer = $this->container->getParameter('gearman_server');
                if(!empty($gearmanServer)){
                    $this->client->addServers($gearmanServer);
                }else{
                    $this->client->addServer();
                }
            }else{
                throw new \Exception("paramenter.yml not config gearman_server");
            }
        }else{
            if($this->container->getParameterBag()->get("kernel.environment")!="dev") {
                throw new \Exception("Class GearmanClient does not exist");
            }
        }
        if (class_exists('GearmanWork')) {
            //$this->work = new \GearmanWork();
        }
        if (class_exists('GearmanJob')) {
            //$this->job  = new \GearmanJob();
        }
    }
    /**
     * 添加job
     *@param $fun:由程序自动执行的已注册函数
     *@param $param:被处理的序列化数据 数组格式
     */
    public function push_job($fun,$param)
    {
        $client = $this->client;
        if (!empty($client)) {
            $jsonparams = json_encode($param);
            $client->doLowBackground($fun,$jsonparams);
            //记录日志
            $this->insertGearmanJobLog($fun, $param);
            return true;
        }else{
            return false;
        }
    }
    
    
    
    /**
     * 添加job前面输出----》同步
     *@param $fun:由程序自动执行的已注册函数
     *@param $param:被处理的序列化数据 数组格式
     */
    public function doNormal($fun,$param)
    {
        $client = $this->client;
        if (!empty($client)) {
            $param = json_encode($param);
            return $client->doNormal($fun,$param);
        }else{
            return false;
        }
    }
    
    public function getClient() {
        return $this->client;
    }
}