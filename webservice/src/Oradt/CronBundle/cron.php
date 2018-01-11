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

$runJobs = array ();
$sysjobs = $cronservice->getJobs();
// print_r($sysjobs);die;
foreach ( $sysjobs as $runJob ) {
    $runJobs [$runJob->getName()] = $runJob->getRunStamp();
}

$class    = $argv[1];
$job      = $argv[2];
$interval = $argv[3];
include dirname(__FILE__).'/Cron/'.$class.'.php';
$reflectionMethod = new ReflectionMethod($class, $job);		
$methodName   = $class . '::' . $job;
$runStamp     = (isset ( $runJobs [$methodName] )) ? $runJobs [$methodName] : 0;
$currentStamp = time ();
if (($currentStamp - $runStamp) > $interval * 60) {
	$sysjob = new SystemCron;
	$sysjob->setName($methodName);
	$sysjob->setRunStamp($currentStamp);
	$cronservice->updateJob($sysjob);
	$reflectionMethod->invoke(new $class ($kernel->getContainer()));
	die('ok');
}
die('no excute job');