<?php
set_time_limit(0);

$pwd    = dirname(__FILE__);
$phpdir = '';
$p      = getopt('p:');
if(!empty($p)){
	$phpdir = $p['p'];
}

//ClassName_functionName
//ClassName为 CronBundle/Cron/AccountBizCron 的 AccountBizCron 不带Cron  AccountBiz
//functionName为其下面的方法名
$daemonArr = array(
    //'UpdateFriendAddress_updateFriendCard',
    'RemarkCard_updateVcardGeocoder',   //解析名片地址
    //'Account_autoRun',
    'Sms_smsreport',                //短信回调
    'Admin_cardSharedCopy',         //运营后台 名片分享
    'Admin_cancelCardShare',        //运营后台  取消名片分享
    //'Order_getVcardFaild',         //买方支付后卖方在3天内未作出反应，则系统确认发获取名片失败消息，并退款
    //'Order_confirmOrder',          //卖方确认出售5天后，买方未确认
    //'Order_refusedRefund',          //卖方拒绝退款后，买方5天内未处理的 系统自动处理到  待结算订单
    //'Task_cardRun',                //1、通讯录2、活动自动下线
    'Mipush_push',
);
$tick = 0;
while(1){
    sleep(1);
    $tick++;
    if($tick > 10){
        foreach ($daemonArr as $key=>$v){
            $vArr = explode('_',$v);
            $className      = $vArr[0];
            $functionName   = $vArr[1];
            check_daemon($className,$functionName);
        }
        $tick = 0;
    }
}
/**
 * php  /var/local/oradt_cloud/webservice/src/Oradt/CronBundle/daemon.php -p /Data/apps/php/bin/
 * -p /Data/apps/php/bin/ 为php的执行目录
 */
function check_daemon($className,$functionName){
    global $pwd,$phpdir;
	echo $pwd;
    $push_num=`ps -ef | grep {$functionName} | grep -v grep | grep -v ksh | grep -v awk | grep -c {$functionName}`;
	echo "push process number is ".$push_num." time:".date('Y-m-d H:i:s',time())."\n";
	if($push_num != 1){
		$pids =`ps -ef|grep {$functionName}|grep -v catlog |grep -v  ksh |grep -v grep|grep -v awk |awk '{print $2}'`;
		if($pids != ''){
			system('kill -9 '.$pids);
		}
		sleep(1);
		//$phpdir = getenv('PHPDIR');
		//$pwd = getenv('PWD');
		$ret = `nohup {$phpdir}php {$pwd}/run.php -c={$className} -f={$functionName} > /dev/null 2>&1 &`;
		echo "restart push process,time:".date('Y-m-d H:i:s',time())."\n";
	}
}

date_default_timezone_set ('Asia/Shanghai');

