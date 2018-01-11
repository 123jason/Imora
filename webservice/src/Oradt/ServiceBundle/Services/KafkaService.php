<?php
namespace Oradt\ServiceBundle\Services;
use Symfony\Component\DependencyInjection\ContainerInterface;
/**
 * Description of KafkaService
 * @author xuejiao
 */
class KafkaService{
    
    private $kafkaClient;
    private $container = null;
    private $active = false;
    
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
//        if($this->container->hasParameter('kafka_host')){
//            $host = $this->container->getParameter('kafka_host');
//            $this->active = true;
//            $this->kafkaClient= $this->connect($host);
//        }else{
//            if($this->container->getParameterBag()->get("kernel.environment")!="dev") {
//                throw new \Exception("paramenter.yml not config kafka_host");
//            }
//        }
        
        if (class_exists('Kafka')) {
            if($this->container->hasParameter('kafka_host')){
                $host = $this->container->getParameter('kafka_host');
                $this->active = true;
                $this->kafkaClient = new \Kafka($host);
            }else{
                if($this->container->getParameterBag()->get("kernel.environment")!="dev") {
                    throw new \Exception("paramenter.yml not config kafka_host");
                }
            }
        }else{
            if($this->container->getParameterBag()->get("kernel.environment")!="dev") {
                throw new \Exception("Class Kafka does not exist");
            }
        }
    }
        
    /**
     * 连接Kafka
     * @param string $host
     * @return Kafka
     */
//    public function connect($host){
//        if (class_exists('GearmanClient')) {
//            $Kafka = new \Kafka($host);
//            return $Kafka;
//        }else{
//            return null;
//        }
//    }
    /**
     * 发送消息
     * @param string $topic
     * @param string $content
     * @param int $timeout
     */
    public function sendKafkaMessage($topic,$content,$timeout=5000){
        try{
            if(!$this->isActive()) {
                return false;
            }
            $this->kafkaClient->produce($topic,$content);   //发送制造一个
            return TRUE;
        }catch (\Exception $e){
            throw $e;
        }
    }
    /**
     * 发送多条消息
     * @param string $topic
     * @param array  $contentArr
     * @param int $timeout
     */
    public function sendKafkaMessageBatch($topic,$contentArr,$timeout=5000){
        try{
            if(!$this->isActive()) {
                return false;
            }
            $this->kafkaClient->produceBatch($topic,$contentArr);   //发送制造一个
            return TRUE;
        }catch (\Exception $e){
            throw $e;
        }
    }
    
    /**
     * 检测状态
     */
    public function isActive(){
        return $this->active;
    }
    /**
     * 断开连接
     */
    public function disConnect(){
        if(!$this->isActive()) {
            return false;
        }
        $this->kafkaClient->disconnect();
    }
}

