<?php
/**
 * 手动验证类
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



$functionName='execute';

/* $classObj = getClass("Biz");
$classObj->isGearman = false;
$classObj->$functionName('{"id":111}'); */

//测试同步会员卡模板搜索条件
/* $classObj = getClass("FuncCard");
$classObj->isGearman = false;
$classObj->$functionName('{"id":8,"type":"updTempSearchingkwd"}'); */

//删除卡类型相关联的标签
/* $classObj = getClass("FuncCard");
$classObj->isGearman = false;
//$classObj->$functionName('{"id":289,"idtype":"tag","type":"deltag"}'); //删除标签  id多个时："id":"289,290,291"
$classObj->$functionName('{"id":158,"idtype":"tagtype","type":"deltag"}');//删除标签类型 */

$classObj = getClass("WechatDownExcelCard");
$classObj->isGearman = false;
$classObj->$functionName('{"wechatid":"ofIP5vvtlgHrTTESdDuMtgEDQX2o","batchid":"","messageid":"500","enclosurename":"大数据.xlsx","content":"content","fromsend":"fromsend","title":"title","sendurl":"zhanggan@oradt.com"}');
    



