<?php
/**
 * 
 * get name design_platform_service
 */
namespace Oradt\ServiceBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Oradt\Utils\Codes;
use Oradt\Utils\RandomString;
use Oradt\ServiceBundle\Services\WxPay\lib\WxPayUnifiedOrder;
use Oradt\ServiceBundle\Services\WxPay\lib\WxPayOrderQuery;
use Oradt\ServiceBundle\Services\WxPay\lib\WxPayRefund;
use Oradt\ServiceBundle\Services\WxPay\lib\WxPayRefundQuery;
use Oradt\ServiceBundle\Services\WxPay\lib\WxPayConfig;
use Oradt\ServiceBundle\Services\WxPay\lib\WxPayApi;
use Oradt\ServiceBundle\Services\WxPay\lib\WxPayBizPayUrl;
use Oradt\ServiceBundle\Services\WxPay\lib\WxPayApiGzh;
use Oradt\ServiceBundle\Services\WxPay\lib\WxPayConfigGzh;
use Oradt\ServiceBundle\Services\WxPay\lib\WxPayJsApiPay;
use Oradt\ServiceBundle\Services\WxPay\WxPaySecondSign;

class WeixinPayService extends BaseService {
    
    public function __construct(EntityManager $entityManager, ContainerInterface $container) {
        parent::__construct($container);

    }

	/**
     * 设计师平台下单方法
     */
	public function GetWxOrder($tradeId,$price,$channel,$product_id="",$product_name){
		ini_set('date.timezone','Asia/Shanghai');
		$total_fee = $price*100;
		$input = new WxPayUnifiedOrder();
		$input->SetBody($product_name);
		$input->SetAttach("e-card");
		$input->SetOut_trade_no($tradeId);
		$input->SetTotal_fee($total_fee);
		$input->SetTime_start(date("YmdHis"));
		$input->SetTime_expire(date("YmdHis", time() + 600));
		$input->SetGoods_tag("card template");
        if(!empty($product_id)){
            $input->SetProduct_id($product_id);
        }
		if(strtoupper($channel) == 'APP'){
			$input->SetTrade_type('APP');
			$input->SetNotify_url(WxPayConfig::NOTIFY_URL);
			$result = WxPayApi::unifiedOrder($input);
		}else{
			$input->SetTrade_type('NATIVE');
			$input->SetNotify_url(WxPayConfigGzh::NOTIFY_URL);		
			$result = WxPayApiGzh::unifiedOrder($input);
		}
		return $result;
	}
    
    /**
     * 2016-10-19 add by  xuejiao
     * 橙脉-微信下单方法【找人、会员充值等】
     * @param string    $tradeId            橙脉订单id
     * @param string    $price              价格
     * @param string    $channel            交易类型 APP  或  NATIVE
     * @param string    $body               订单描述
     * @param string    $product_id         channerl = NATIVE 必填
     * return  array()
     */
    public function GetImoraWxOrder($tradeId,$price,$channel,$body,$product_id=""){
		ini_set('date.timezone','Asia/Shanghai');
		$total_fee = $price*100;
		$input = new WxPayUnifiedOrder();
		$input->SetBody($body);
		$input->SetAttach("e-card");
		$input->SetOut_trade_no($tradeId);
		$input->SetTotal_fee($total_fee);
		$input->SetTime_start(date("YmdHis"));
		$input->SetTime_expire(date("YmdHis", time() + 600));
		$input->SetGoods_tag("card template");
        if(!empty($product_id)){
            $input->SetProduct_id($product_id);
        }
		if(strtoupper($channel) == 'APP'){
			$input->SetTrade_type('APP');
			$input->SetNotify_url(WxPayConfig::WXAPP_IMORA_NOTIFY_URL);
			$result = WxPayApi::unifiedOrder($input,2);    //找人订单
        }else{
//			$input->SetTrade_type('NATIVE');
//			$input->SetNotify_url(WxPayConfigGzh::NOTIFY_URL);
//			$result = WxPayApiGzh::unifiedOrder($input);
		}
		return $result;
	}
    
    
    /**
     * 微信公众号下单
     * @param string    $tradeId            订单id
     * @param string    $price              价格
     * @param string    $body               订单描述
     * @param string    $openId             微信用户openid
     */
    public function GetWxPublicNumOrder($tradeId,$price,$body,$openId){
		ini_set('date.timezone','Asia/Shanghai');
		$total_fee = $price*100;
		$input = new WxPayUnifiedOrder();
		$input->SetBody($body);
		$input->SetAttach("chengyuan");
		$input->SetOut_trade_no($tradeId);
		$input->SetTotal_fee($total_fee);
		$input->SetTime_start(date("YmdHis"));
		$input->SetTime_expire(date("YmdHis", time() + 600));
		$input->SetGoods_tag("chengyuan");
        $input->SetTrade_type('JSAPI');
        $input->SetNotify_url(WxPayConfigGzh::NOTIFY_URL);
        $input->SetOpenid($openId);
        $result = WxPayApiGzh::unifiedOrder($input);
		return $result;
	}
    
    /**
	 * 
	 * 获取jsapi支付的参数
	 * @param array $UnifiedOrderResult 统一支付接口返回的数据
	 * @throws WxPayException
	 * 
	 * @return json数据，可直接填入js函数作为参数
	 */
	public function GetJsApiParameters($UnifiedOrderResult)
	{
		if(!array_key_exists("appid", $UnifiedOrderResult)
		|| !array_key_exists("prepay_id", $UnifiedOrderResult)
		|| $UnifiedOrderResult['prepay_id'] == "")
		{
			throw new WxPayException("参数错误");
		}
		$jsapi = new WxPayJsApiPay();
		$jsapi->SetAppid($UnifiedOrderResult["appid"]);
		$timeStamp = time();
		$jsapi->SetTimeStamp("$timeStamp");
		$jsapi->SetNonceStr(WxPayApi::getNonceStr());
		$jsapi->SetPackage("prepay_id=" . $UnifiedOrderResult['prepay_id']);
		$jsapi->SetSignType("MD5");
		$jsapi->SetPaySign($jsapi->MakeSign());
		$parameters = json_encode($jsapi->GetValues());
		return $parameters;
	}
    
    /**
     * 查询微信订单方法 2016-10-19 add by  xuejiao
     * @param string    $orderId            橙脉订单id
     * @param string    $transactionId      微信的订单号
     * @param string    $channel            交易类型 APP  或  NATIVE
     * return  array()
     */
    public function getWxPayOrderQuery($orderId,$transactionId='',$channel='APP'){
        $input = new WxPayOrderQuery();
		$input->SetTransaction_id($transactionId);
		$input->SetOut_trade_no($orderId);
		if($channel == 'APP'){
			$ret_values = WxPayApi::orderQuery($input);
		}else{
			$ret_values = WxPayApiGzh::orderQuery($input);
		}
        return $ret_values;
    }
    
    /**
     * 提交退款申请 退款 2016-10-20 add by  xuejiao
     * @param string    $orderId            橙脉订单id
     * @param string    $price              橙脉订单id金额【元】
     * @param string    $transactionId      微信的订单号
     * @param string    $channel            交易类型 APP  或  NATIVE
     * return  array()
     */
    public function getWxPayRefund($orderId,$price,$transactionId='',$channel='APP'){
        $input = new WxPayRefund();
        $input->SetTransaction_id($transactionId);     //微信订单号
        $input->SetTotal_fee($price);                   //订单总金额
        $input->SetRefund_fee($price);                  //退款金额
        $input->SetOut_refund_no(WxPayConfig::MCHID.date("YmdHis"));  //商户退款单号
        $input->SetOp_user_id(WxPayConfig::MCHID);      //操作员 默认为商户好
		if($channel == 'APP'){
			$ret_values = WxPayApi::refund($input);
		}else{
			$ret_values = WxPayApiGzh::refund($input);
		}
        return $ret_values;
    }
    
    /**
     * 查询退款 2016-10-21 add by  xuejiao
     * @param string    $orderId            橙脉订单id
     * @param string    $orderRefundId      橙脉退款单号id
     * @param string    $transactionId      微信订单号
     * @param string    $refundId           微信退款单号
     * return  array()
     */
    public function getWxRefundQuery($orderId,$orderRefundId='',$transactionId='',$refundId='',$channel='APP'){
        $input = new WxPayRefundQuery();
        $input->SetOut_trade_no($orderId);              //橙脉订单id
        if(!empty($orderRefundId)){
            $input->SetOut_refund_no($orderRefundId);       //橙脉退款单号id
        }
        if(!empty($transactionId)){
            $input->SetTransaction_id($transactionId);      //微信订单号
        }
        if(!empty($refundId)){
            $input->SetRefund_id($refundId);                //微信退款单号
        }
		if($channel == 'APP'){
			$ret_values = WxPayApi::refundQuery($input);
		}else{
			$ret_values = WxPayApiGzh::refundQuery($input);
		}
        return $ret_values;
    }
    
    public function GetSecondSign($prepayId){
		ini_set('date.timezone','Asia/Shanghai');
		$ssign = new WxPaySecondSign();
		$ssign->SetAppid(WxPayConfig::APPID);//公众账号ID
		$ssign->SetMch_id(WxPayConfig::MCHID);//商户号
		$ssign->SetNonce_str(WxPayApi::getNonceStr());//随机字符串
		$ssign->SetPrepay_id($prepayId);
		$ssign->SetPackage('Sign=WXPay');
		$ssign->SetTime_stamp(time(0).'');
		$ssign->setSign();
		return $ssign;
	}

	public function insertPayLog($orderId,$result,$code)
	{
		$query_sql = "SELECT order_id FROM `weixin_order_info` where order_id = '{$orderId}'  LIMIT 1";
        $numfound  = $this->getConnection()->executeQuery($query_sql)->fetch();
        if ($numfound) {
        	return true;
        }
		$params = array( 
            ':orderId'   => $orderId, 
            ':result'    => $result, 
            ':code'      => $code, 
            ':time'      => $this->getTimestamp()
        );
        $sql = "INSERT INTO `weixin_order_info` (order_id,result_data,created_time,result_code) values (:orderId,:result,:time,:code)";
        $this->em->getConnection()->executeUpdate($sql , $params);
        return true;
	}
}
