<?php  
namespace Oradt\CronBundle\Gearman;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Oradt\Utils\BaseTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Oradt\Utils\RandomString;
use Symfony\Component\HttpFoundation\ParameterBag;
/**
* Greaman work 抽象类
*/
abstract class Work
{
	use BaseTrait;
    protected $logger = null;
    protected static $time;

    /**
     * gearman开关
     * @var unknown
     */
    public $isGearman = true;
    
	function __construct(ContainerInterface $container)
	{
		$this->container = $container;
        self::$time = $this->getTimestamp();
		$this->setLoggerName('gearman.log');
	
	}
	abstract function taskRun($data);

    //判断是否连接
    public function isConnected(){
        $now = $this->getTimestamp();
        if( ($now-self::$time)< 600 ) {
            return;
        }
        if($this->getConnection()->isConnected() == true){
            $this->getConnection()->close();
        }
        $this->getConnection()->connect();
    }

    //GearmanJob $job
	public function execute($job)
	{
	    $this->isConnected();
	    $data = '';
	    $result = false;
	    try{
    	    if($this->isGearman) {
    	    	$data = $job->workload();
    	    	$result = $this->taskRun($data);
    	    }
    	    else{
    	    	$data = $job;
    	    	$result =  $this->taskRun($data);
    	    }
	    }catch (\Exception $ex) {
	    	$this->logger->err($ex->getMessage(). ":". $data);
	    	echo $ex->getMessage(). ":".$data;
	    }
	    
		return $result;
	}

	/**
	 * 设置日志文件
	 * @param string $fileName
	 * @param string $logDir
	 */
	public function setLoggerName($fileName , $logDir = null) {
	    if(empty($logDir)) {
	        $logDir = $this->container->getParameter('kernel.logs_dir');
	    }
	    $stream = new StreamHandler( $logDir . DIRECTORY_SEPARATOR . $fileName);
	    $this->logger = new Logger("gearman_logger",array($stream));
	}
}
?>