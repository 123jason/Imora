<?php
set_time_limit(0);
use Symfony\Component\Debug\Debug;
//use Oradt\CronBundle\Core\CommandTools;
use Oradt\StoreBundle\Entity\SystemCron;
use Symfony\Component\Console\Input\ArgvInput;
// If you don't want to setup permissions the proper way, just uncomment the following PHP line
// read http://symfony.com/doc/current/book/installation.html#configuration-and-setup for more information
// umask(0000);

// This check prevents access to debug front controllers that are deployed by accident to production servers.
// Feel free to remove this, extend it, or make something more sophisticated.
if (isset ( $_SERVER ['HTTP_CLIENT_IP'] ) || isset ( $_SERVER ['HTTP_X_FORWARDED_FOR'] ) || ! (in_array ( @$_SERVER ['REMOTE_ADDR'], array (
		'127.0.0.1',
		'fe80::1',
		'::1' 
) ) || php_sapi_name () === 'cli-server')) {
	// header('HTTP/1.0 403 Forbidden');
	// exit('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');
}
define('INTERNALPROCESS', '1');
define ( 'WEBSERVICE_ROOT', __DIR__ . '/../../../' );

// echo WEBSERVICE_ROOT;

$loader = require_once WEBSERVICE_ROOT . '/app/bootstrap.php.cache';
Debug::enable ();

require_once WEBSERVICE_ROOT . '/app/AppKernel.php';

$kernel = new AppKernel ( 'cron', true );
$kernel->loadClassCache ();

$kernel->boot ();

/**/
$input = new ArgvInput();

$cronservice = $kernel->getContainer()->get ( 'cron_service' );

//执行一次性任务 可在linux crontab 中指定执行时间， 执行时间容易控制

// example php src\Oradt\CronBundle\run.php -c=Basic -f=regbase
// -c 类名 不带Cron -f 方法名
if($input->getParameterOption("-c") && $input->getParameterOption("-f")) {
    //print_r($input);
    $className = $input->getParameterOption("-c") . 'Cron';
    $classFile = dirname(__FILE__).'/Cron/'.$className.'.php';
    if(!file_exists($classFile)) {
        exit($classFile . ' not found' . $className);
    }
    
    include $classFile;
    //$class = new $className($kernel->getContainer());
    $class = new ReflectionClass($className);
    $functionName = $input->getParameterOption("-f");
    $classObj = $class->newInstance($kernel->getContainer());
    if($class->hasMethod($functionName)) {
        $classObj->$functionName();
    }else{
        echo 'not found ' . $functionName . ' Method';
    }
   
    exit(' exit');
}
// 统一调用 cron ，定时不好控制
$runJobs = array ();
$sysjobs = $cronservice->getJobs();
foreach ( $sysjobs as $runJob ) {
    $runJobs [$runJob->getName()] = $runJob->getRunStamp();
}


foreach ( $kernel->getBundles () as $bundle ) {
	
	$name = $bundle->getName ();
	$bundledir = $bundle->getPath ();
	//filter bundle
	if($input->getParameterOption("-b") && stripos($bundledir, $input->getParameterOption("-b"))===false)
	    continue;
	if (file_exists ( $bundledir . '/Cron.php' )) {
	    //echo $bundledir . "\r\n"; print_r($argv); //exit();
		include ($bundledir . '/Cron.php');
		$classes = get_declared_classes ();
		//print_r($classes);
		$class = end ( $classes );
		$cron = new $class ($kernel->getContainer());
		$jobs = $cron->getJobList ();
		foreach ( $jobs as $job => $interval ) {
			$methodName = $class . '::' . $job;
			$runStamp = (isset ( $runJobs [$methodName] )) ? $runJobs [$methodName] : 0;
			$currentStamp = time ();
			if (($currentStamp - $runStamp) > ($interval * 60)) {

				$sysjob = new SystemCron;
				$sysjob->setName($methodName);
				$sysjob->setRunStamp($currentStamp);
				$cronservice->updateJob($sysjob);
			
				$cron->$job ();
			}
		}
	}
	
}
