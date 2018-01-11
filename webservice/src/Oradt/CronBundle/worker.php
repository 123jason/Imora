<?php
/**
 * gearman worker boot file
 *
 * @example php src\Oradt\CronBundle\worker.php -c=Biz,Test
 * @example nohup {$phpdir}php {$pwd}/run.php -c={$className}  > /dev/null 2>&1 &  后台启动命令
 * @param  -c 类名 不带Work
 */
#set_time_limit(0);
use Symfony\Component\Debug\Debug;
//use Oradt\CronBundle\Core\CommandTools;
use Oradt\StoreBundle\Entity\SystemCron;
use Symfony\Component\Console\Input\ArgvInput;


define('INTERNALPROCESS', '1');
define ( 'WEBSERVICE_ROOT', __DIR__ . '/../../../' );

// echo WEBSERVICE_ROOT;

$loader = require_once WEBSERVICE_ROOT . '/app/bootstrap.php.cache';
Debug::enable ();

require_once WEBSERVICE_ROOT . '/app/AppKernel.php';

$kernel = new AppKernel ( 'cron', true );
$kernel->loadClassCache ();

$kernel->boot ();
require_once dirname(__FILE__).'/CronCommon.php';
/**/
$input = new ArgvInput();

/**
  * 判断gearman类是否存在，不存在不实例化（window，本地模式下）
  * 实例化 gearman类
  */ 
if (class_exists('GearmanWorker')) {
	$worker= new GearmanWorker();
        $gearmanServer = '';
        if($kernel->getContainer()->hasParameter('gearman_server')){
            $gearmanServer = $kernel->getContainer()->getParameter('gearman_server');
            if(!empty($gearmanServer)){
                $worker->addServers($gearmanServer);
            }else{
                $worker->addServer();
            }
        }
        
	//$worker->addServer('192.168.30.191',4730);
}else{
    exit("not found GearmanWorker extend\r\n");
}

//示列
///Data/apps/php/bin/php /var/local/oradt_cloud/webservice/src/Oradt/CronBundle/worker.php
// -c OrderU8,Common,ContactCard,MapFriend,FuncCard
$functionName='execute';
if ($input->getParameterOption ( "-c" )) {
    
    $classList = explode ( ',', $input->getParameterOption ( "-c" ) );
    foreach ( $classList as $item ) {
        $worker_arr = explode(":", $item);        
        $tclass = $worker_arr[0];//类名
        $fname = $worker_arr[0]; //队列名
        if(count($worker_arr) > 1) { 
            $tclass = $worker_arr[1]; //使用别名的情况下，类名取第二列  示例 ：队列名:类名
        }
        
        $classObj = getClass ($tclass);
        if($classObj===null) {
            echo 'not found ' . $tclass . ' class file';
            continue;
        }
       
        if (class_exists ( 'GearmanWorker' )) {
            $worker->addFunction ( $fname, array (
                    $classObj,
                    $functionName 
            ) );
            //$worker->setTimeout(5000);
        }
        
    }    
    while ($worker->work());
    
}else{
    exit(' not found -c parameter');
}


