<?php
use Oradt\CronBundle\Core\Cron;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Oradt\CronBundle\Gearman\Work;
use Oradt\Utils\SaveFile;

/**
 * Gearman workclass 
 * example : F execute 为工作方法，executeTest 为window下测试方法：测试代码是否执行
 * @date 2017-2-23 
 * @vertion 1.0.1
 */
class WeChatWork extends Work
{
    public $work;
    public $job;
    public $log;
    public $str;
    public $arr;
    public $res;
    private $cmd_path = '/home/ocrfile/';
    private $serverip = '';


    public function __construct(ContainerInterface $container)
	{
            parent::__construct($container);
            $this->serverip = $this->get_server_ip(); 
                
	}

	public function taskRun($data)
	{
            return $this->ocr($data);
            
	}
        public function ocr($data) {
            if($this->container->hasParameter('OCRFILE')){
                $this->cmd_path = $this->container->getParameter('OCRFILE');
            }
            $data = json_decode($data,true);
            $language = !empty($data['language']) ? $data['language'] : 2;
            $fname = $data['fname'].'_a';
            $ocr_service = $this->container->get('ocr_service');
            $data = $ocr_service->run($this->cmd_path.$data['fname'],$language); 
            $savef = new SaveFile($data['upobject']->getPathname() , $data['upobject']->getClientOriginalName());
            $savef->copy($this->cmd_path.$fname);
            $data['fname'] = $fname;
            $data['serverip'] = $this->serverip; 
            return json_encode($data);
            
        }
        private function  get_server_ip(){
            $ip_cmd = "ifconfig eth0 | sed -n '/inet addr/p' | awk '{print $2}' | awk -F ':' '{print $2}'";
            $ret = trim(exec($ip_cmd));  
            return $ret;  
        }
}


