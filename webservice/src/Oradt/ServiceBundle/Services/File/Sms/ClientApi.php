<?php

require_once dirname(__FILE__) . '/Client.php';


/**
 * 网关地址
 */
$gwUrl = $this->gwUrl;
/**
 * 序列号,请通过亿美销售人员获取
 */
$serialNumber = $this->serialNumber;

/**
 * 密码,请通过亿美销售人员获取
 */
$password = $this->password;

/**
 * 登录后所持有的SESSION KEY，即可通过login方法时创建
 */
$sessionKey = 'oradt!123';

/**
 * 连接超时时间，单位为秒
 */
$connectTimeOut = 2;

/**
 * 远程信息读取超时时间，单位为秒
 */
$readTimeOut = 10;

/**
  $proxyhost		可选，代理服务器地址，默认为 false ,则不使用代理服务器
  $proxyport		可选，代理服务器端口，默认为 false
  $proxyusername	可选，代理服务器用户名，默认为 false
  $proxypassword	可选，代理服务器密码，默认为 false
 */
$proxyhost = false;
$proxyport = false;
$proxyusername = false;
$proxypassword = false;

$this->client = new Client($gwUrl, $serialNumber, $password, $sessionKey, $proxyhost, $proxyport, $proxyusername, $proxypassword, $connectTimeOut, $readTimeOut);
?>
