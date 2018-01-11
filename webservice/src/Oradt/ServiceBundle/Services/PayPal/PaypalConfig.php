<?php
/* *
 * 配置文件
 * 版本：3.3
 * 日期：2012-07-19
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。
	
 * 提示：如何获取安全校验码和合作身份者id
 * 1.用您的签约支付宝账号登录支付宝网站(www.alipay.com)
 * 2.点击“商家服务”(https://b.alipay.com/order/myorder.htm)
 * 3.点击“查询合作者身份(pid)”、“查询安全校验码(key)”
	
 * 安全校验码查看时，输入支付密码后，页面呈灰色的现象，怎么办？
 * 解决方法：
 * 1、检查浏览器配置，不让浏览器做弹框屏蔽设置
 * 2、更换浏览器或电脑，重新登录查询。
 */
namespace Oradt\ServiceBundle\Services\PayPal;
require_once dirname(__FILE__).'/../../../../../app/config/design_config.php';
use DesignConfig;

/**
* 	配置账号信息
*/

class PaypalConfig
{
	//const username = 'orapay_api1.oradt.com';
	//const password = 'T6MY67V7K87DKT6E';
	const username = DesignConfig::PAYPAL_USERNAME;
	const password = DesignConfig::PAYPAL_PASSWORD;
	const signature = DesignConfig::PAYPAL_SIGNATURE;
	const NOTIFY_URL = DesignConfig::PAYPAL_NOTIFY_URL;
	const API_ENDPOINT = DesignConfig::PAYPAL_ENDPOINT;  
	const PAYPAL_URL = DesignConfig::PAYPAL_URL;
    const CLIENT_ID = DesignConfig::PAYPAL_CLIENT_ID;
    const CLIENT_SECRET = DesignConfig::PAYPAL_CLIENT_SECRET;
}
?>