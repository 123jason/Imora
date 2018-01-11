<?php
/**
 * 
 * get name design_platform_service
 */
namespace Oradt\ServiceBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Oradt\StoreBundle\Entity\DesignProductDetail;
use Oradt\StoreBundle\Entity\DesignProductStyle;
use Oradt\Utils\Codes;
use Oradt\Utils\RandomString;
use Oradt\ServiceBundle\Services\PayPal\PaypalConfig;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PayPal\Api\Payment;
use PayPal\Api\Payer;
use PayPal\Common\PayPalModel;
class PaypalService extends BaseService {
    
    public function __construct(EntityManager $entityManager, ContainerInterface $container) {
        parent::__construct($container);

    }
	public $errMsg = array();

        //获取token的函数
	function SetExpressCheckout($params) {
		$token = '';
		$serverName = $_SERVER['SERVER_NAME'];
		$serverPort = $_SERVER['SERVER_PORT'];
		$url = dirname('https://'.$serverName.':'.$serverPort.$_SERVER['REQUEST_URI']);
		$payAmount = $params['amount'];
		$currency = $params['currency'];
		$payType = $params['payType'];
		$desc = $params['DESC'];
		$returnURL = urlencode($url.'/'.$params['returnPage'].'?cmd=paypal&currency='.$currency.'&payType='.$payType.'&payAmount='.$payAmount);
		$cancelURL = urlencode($url.'/'.$params['cancelPage'].'?cmd=cancel');
		$nvpstr = "&AMT=".$payAmount."&PAYMENTACTION=".$payType."&RETURNURL=".$returnURL."&CANCELURL=".$cancelURL."&CURRENCYCODE=".$currency."&DESC=".$desc;
		$resArray=self::makeCall("SetExpressCheckout", $nvpstr);
		if(!$resArray) {
			return false;
		}
		if(array_key_exists('ACK', $resArray) AND strtoupper($resArray['ACK']) == 'SUCCESS') {
			if (array_key_exists("TOKEN",$resArray)) {
				$token = urldecode($resArray["TOKEN"]);
			}
			$payPalURL = PaypalConfig::PAYPAL_URL.$token;
			echo $payPalURL;
			return $payPalURL;
		}
		//插入你的异常处理
	}
        //
	function GetExpressCheckoutDetails($params) {
		$token = urlencode($params['token']);
		$nvpstr = "&TOKEN=".$token;
		$resArray = self::makeCall("GetExpressCheckoutDetails",$nvpstr);
		if(!$resArray) {
			return false;
		}
		if(array_key_exists('ACK', $resArray) AND strtoupper($resArray['ACK']) == 'SUCCESS') {
			return $resArray;
		} else {
			//插入你的异常处理
		}
	}
        //确定执行交易
	function DoExpressCheckoutPayment($params) {
		$token = urlencode( $params['token']);
		$payAmount = urlencode ($params['payAmount']);
		$payType = urlencode($params['payType']);
		$payerID = urlencode($params['PayerID']);
		$nvpstr = '&TOKEN='.$token.'&PAYERID='.$payerID.'&PAYMENTACTION='.$payType.'&AMT='.$payAmount ;
		$resArray = self::makeCall("DoExpressCheckoutPayment",$nvpstr);
		if(!$resArray) {
			return false;
		}
		if(array_key_exists('ACK', $resArray) AND strtoupper($resArray['ACK']) == 'SUCCESS') {
			return $resArray;
		} else {
			 //插入你的异常处理
		}
	}

	function RefundTransaction($params) {
		$type = $params['type'];
		$transactionId = $params['transactionId'];
		$amount = urlencode($params['amount']);
		$nvpstr = '&TRANSACTIONID='.$transactionId.'&REFUNDTYPE='.$type;
		if($type == 'Full')
		$nvpstr .= '&AMT='.$amount;
		$resArray = self::makeCall("RefundTransaction", $nvpstr);
		if(!$resArray){
			return false;
		}
		if(array_key_exists('ACK', $resArray) AND strtoupper($resArray['ACK']) == 'SUCCESS') {
			return $resArray;
		} else {
			 //插入你的异常处理
		}
	}
	function GetTransactionDetails($trans_id) {

		$tranid = urlencode($trans_id);
		$nvpstr = "&TRANSACTIONID=".$tranid;
		$resArray = self::makeCall("GetTransactionDetails",$nvpstr);
		if(!$resArray) {
			return false;
		}
		return $resArray;

	}
	function TransactionSearch($name,$value) {
		$name = urlencode($name);
		$value = urlencode($value);
		$nvpstr = "&STARTDATE=2015-08-24T07:34:20Z&".$name."=".$value;
		$resArray = self::makeCall("TransactionSearch",$nvpstr);
		if(!$resArray) {
			return false;
		}
		return $resArray;

	}
	function GetPayDetails($pay_id) {

		$apiContext = new ApiContext(new OAuthTokenCredential(PaypalConfig::CLIENT_ID, PaypalConfig::CLIENT_SECRET));
		
		$payment = Payment::get($pay_id, $apiContext);
		$pay_array = $payment->toArray();
		//var_dump($pay_array);
		$ret_array = array();
		if(array_key_exists('id', $pay_array))
		{
			$ret_array['PAYID'] = $pay_array['id'];
		}
		if(array_key_exists('create_time', $pay_array))
		{
			$ret_array['ORDERTIME'] = $pay_array['create_time'];
		}
		if(array_key_exists('payer', $pay_array))
		{
			$payer = $pay_array['payer'];
			if(array_key_exists('payer_info', $payer))
			{
				$payer_info = $payer['payer_info'];
				if(array_key_exists('email', $payer_info))
				{
					$ret_array['EMAIL'] = $payer_info['email'];	
				}
				if(array_key_exists('payer_id', $payer_info))
				{
					$ret_array['PAYERID'] = $payer_info['payer_id'];	
				}
			}
		}
		if(array_key_exists('transactions', $pay_array))
		{
			$transactions = $pay_array['transactions'];
			if(array_key_exists('amount', $transactions[0]))
			{
				$amount = $transactions[0]['amount'];
				if(array_key_exists('total', $amount))
				{
					$ret_array['AMT'] = $amount['total'];	
				}
				if(array_key_exists('currency', $amount))
				{
					$ret_array['CURRENCYCODE'] = $amount['currency'];	
				}
			}
			if(array_key_exists('related_resources', $transactions[0]))
			{
				$related_resources = $transactions[0]['related_resources'];
				if(array_key_exists('sale', $related_resources[0]))
				{
					$sale = $related_resources[0]['sale'];	
					if(array_key_exists('state', $sale))
					{
						$ret_array['PAYMENTSTATUS'] = $sale['state'];	
					}
				}
			}
			if(array_key_exists('item_list', $transactions[0]))
			{
				$item_list = $transactions[0]['item_list'];
				if(array_key_exists('items', $item_list))
				{
					$items = $item_list['items'];
					if(!empty($items) && array_key_exists('sku', $items[0]))
					{
						$ret_array['TRADENO'] = $items[0]['sku'];
					}
				}
				
			}
			
		}
		
		return $ret_array;

	}
    //通过curl库来发送请求，被以上的函数调用
	function makeCall($methodName,$nvpStr) {
		global $API_Endpoint;
		$version = '82.0';
                //获取商家，亦即卖家的账户名，密码和签名，我将这些放在一个xml文件中读取，读者可自行决定如何取这些
		$username = PaypalConfig::username;
		$password = PaypalConfig::password;
		$signature = PaypalConfig::signature;
		$API_UserName = $username;
		$API_Password = $password;
		$API_Signature = $signature;

        //  $nvp_Header;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,PaypalConfig::API_ENDPOINT);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		/*  if(USE_PROXY)//如果使用代理
		 {
		 curl_setopt ($ch, CURLOPT_PROXY, PROXY_HOST.":".PROXY_PORT);
		 }*/
		$nvpreq = "METHOD=".urlencode($methodName)."&VERSION=".urlencode($version)."&PWD=".urlencode($API_Password)."&USER=".urlencode($API_UserName)."&SIGNATURE=".urlencode($API_Signature).$nvpStr;
		curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);
		$response = curl_exec($ch);
		$nvpResArray=self::deformatNVP($response);
		if (!$response) {
			//插入你的异常处理函数
			return false;
		} else {
			curl_close($ch);
		}
		return $nvpResArray;
	}
        //关于字符串的你懂的
	function deformatNVP($nvpstr) {
		$intial = 0;
		$nvpArray = array();
		while(strlen($nvpstr)) {
			$keypos = strpos($nvpstr, '=');
			$valuepos = strpos($nvpstr,'&') ? strpos($nvpstr,'&') : strlen($nvpstr);
			$keyval = substr($nvpstr, $intial, $keypos);
			$valval = substr($nvpstr, $keypos+1, $valuepos-$keypos-1);
			$nvpArray[urldecode($keyval)] = urldecode($valval);
			$nvpstr = substr($nvpstr, $valuepos+1, strlen($nvpstr));
		}
		return $nvpArray;
	}

}
