<?php
/**
 * service base class
 * @author huangxm
 *
 */
namespace Oradt\ServiceBundle\Services;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Oradt\Utils\BaseTrait;
use Oradt\StoreBundle\Entity\Tags;
class BaseService{
    const ACCOUNT_BASIC = 'basic';
    const ACCOUNT_ADMIN = 'admin';
    const ACCOUNT_BIZ = 'biz';
    protected $container;
    use BaseTrait;
    private static $time = null;
    public function __construct(ContainerInterface $container){
        $this->container = $container;
        $this->em = $this->getManager();
        $this->baseLogger = $this->container->get('special_logger');
    }

    public function reSetTime(){
        self::$time = null;
    }
    
    /**
     * add tag
     * @param string $tagname
     * @return int
     */
    public function addTag($tagname) {
        $sql = 'SELECT id FROM tags WHERE tagname=:tagname';
        $id = $this->em->getConnection()->executeQuery($sql,array(':tagname' => $tagname))->fetchColumn();
        if(!empty($id))
            return $id;
        $tags = new Tags();
        $tags->setTagname($tagname);
        $this->em->persist($tags);
        $this->em->flush();
        
        return $tags->getId();
            
    }
    
    /**
     * 返回系统时间
     * @return \DateTime
     */
    public function getDateTime($default='now')
    {
        if($default!='now'){            
            //时区参考 http://php.net/manual/zh/timezones.php
            return new \DateTime($default, new \DateTimeZone('UTC'));           
        }
        if(self::$time === null)
           self::$time = new \DateTime($default, new \DateTimeZone('UTC'));
        return self::$time;
    }
    public function setDateTime($default='now'){
        if(is_object($default))
            $default = $default->format('Y-m-d H:i:s');
        self::$time = new \DateTime($default, new \DateTimeZone('UTC'));
    }
    
    
    /**
     * 记录gearman 日志
     * @param $fun:由程序自动执行的已注册函数
     * @param $param:被处理的序列化数据 数组格式
     */
    public function insertGearmanJobLog($fun,$param){
        //return;
        if(defined('INTERNALPROCESS') ||
        !$this->container->hasParameter('API_LOG_ON-OFF') || 
        !$this->container->getParameter('API_LOG_ON-OFF') ) {
            return true;
        }
        $sql = "INSERT INTO api_statistic (user_id, api_name, method, date_time, call_times, parameter)
                VALUES (:userId, :type, :method, :times, :call_times, :parameter)";
        $type = isset($param['type']) ? $param['type'] : '';
        $parameter = json_encode(array_merge_recursive($param,self::getLog()));
        $params = array(
                ':userId'   => 'gearman_'.$fun,
                ':type'     => $type,
                ':method'   => 'post',
                ':times'    => $this->getTimestamp1(),
                ':call_times' => $this->getTimestamp1(),
                ':parameter'  => $parameter
        );
        $this->getManager('default')->getConnection()->executeQuery($sql,$params);
    }
    
}