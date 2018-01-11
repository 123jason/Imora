<?php
namespace Oradt\ServiceBundle\Services\AliPaySdk;

require_once(dirname(__FILE__) . '/lib/AopSdk.php');
require_once(dirname(__FILE__) . '/lib/aop/AopClient.php');
use \AopClient;

class AlipaySdkTradeService extends AopClient{
    
    private $container;
//    $config = array (
//		'alipay_public_key_file' => dirname ( __FILE__ ) . "/key/alipay_rsa_public_key.pem",
//		'merchant_private_key_file' => dirname ( __FILE__ ) . "/key/rsa_private_key.pem",
//		'merchant_public_key_file' => dirname ( __FILE__ ) . "/key/rsa_public_key.pem",		
//		'charset' => "GBK",
//		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",
//		'app_id' => "2015050800012345" 
//     );
    public function __construct($container) {
        $this->container  = $container;
        $this->gatewayUrl = $this->container->getParameter('ALIPAY_GATEWAY_URL');
        $this->appId      = $this->container->getParameter('ALIPAY_APPID');
        $this->rsaPrivateKeyFilePath = dirname(__FILE__).'/key/rsa_private_key.pem';    
        $this->alipayPublicKey       = dirname(__FILE__).'/key/alipay_rsa_public_key.pem';
    }
    
    /**
     * 支付宝 统一收单交易退款接口
     * @param string $orderId           橙脉订单id
     * @param float  $refundAmount      退款金额  
     * return array
     */
    public function getAlipayTradeRefund($orderId,$refundAmount){
        //返回数组定义
        $resArr  = array();
        //调用支付宝统一退款接口
        $request = new \AlipayTradeRefundRequest ();
        $bizContent = array(
            "out_trade_no"  => $orderId,
            "refund_amount" => $refundAmount,
            "refund_reason" => "正常退款"
        );
        $bizContent = json_encode($bizContent);
        $request->setBizContent($bizContent);
        $result = $this->execute ( $request); 
        if(!empty($result)){
            $refundResponse = $result->alipay_trade_refund_response;
            if(isset($refundResponse->code) && !empty($refundResponse->code) && $refundResponse->code == 10000){
                $resArr['status']       = 'success';                        //成功
                $resArr['refund_fee']   = $refundResponse->refund_fee;      //退款总金额
                $resArr['order_id']     = $refundResponse->out_trade_no;    //订单id
                $resArr['trade_no']         = $refundResponse->trade_no;        //支付宝交易号
                $resArr['gmt_refund_pay']   = $refundResponse->gmt_refund_pay;  //退款时间
            }else{
                $resArr['status'] = 'err';               //失败
                $resArr['msg']    = $refundResponse->sub_code.":".$refundResponse->sub_msg;            //失败错误码
            }
        }else{
            $resArr['status'] = 'err';               //失败
            $resArr['msg']    = "FAILED";            //失败错误码
        }
        return $resArr;
    }

    /**
     * 获取支付宝用户信息
     * @param string $authcode      客户端 用户授权后 返回的 auth_code
     * @param string $alipayuserid  客户端 用户授权后 返回的 支付宝的 user_id
     * return array
     */
    public function getAlipayUserInfo($authcode){
        //返回数组定义
        $resArr  = array();   
        //换取授权访问令牌 access_token
        $request = new \AlipaySystemOauthTokenRequest ();
        $request->setGrantType("authorization_code");
        $request->setCode($authcode);
        $result = $this->execute ( $request); 
        if(!empty($result)){
            $tookenResponse = $result->alipay_system_oauth_token_response;
            //换取访问令牌失败代码
            if(isset($tookenResponse->code) && !empty($tookenResponse->code) && $tookenResponse->code == 20000){    
                $sub_code = $tookenResponse->sub_code;   //失败错误码
                $resArr['status'] = 'err';               //失败
                $resArr['msg']    = $sub_code;           //失败错误码
                return $resArr;
            }
            //成功继续走获取支付宝access_token 用access_token 获取用户信息
            $accessToken = $tookenResponse->access_token;
            $userRequest = new \AlipayUserUserinfoShareRequest ();
            $userResult  = $this->execute ( $userRequest,$accessToken); 
            if(!empty($userResult)){
                $userInfoResponse = $userResult->alipay_user_userinfo_share_response;
                $userResultCode   = $userInfoResponse->code;
                //获取会员信息失败代码
                if(isset($userInfoResponse->code) && !empty($userInfoResponse->code) && $userInfoResponse->code == 20000){    
                    $sub_code = $userInfoResponse->sub_code;   //失败错误码
                    $resArr['status'] = 'err';          //失败
                    $resArr['msg']    = $sub_code;      //失败错误码
                    return $resArr;
                }
                //获取支付宝账号  邮箱 或手机号
                $email   = $userInfoResponse->email;      //邮箱
                $mobile  = $userInfoResponse->mobile;     //手机
                $rename  = $userInfoResponse->real_name;  //真实姓名
                $account = !empty($email) ? $email : $mobile;
                $resArr['status']   = 'success';          //成功
                $resArr['account']  = $account;           //支付宝账户
                $resArr['name']     = $rename;            //支付宝姓名
                return $resArr;
            }
        }else{
            return $resArr['status'] = 'err';       //失败
        }
    }

        /**
     * 查询订单支付情况
     * @param string $orderId [橙脉订单id]
     */
    public function getAlipayTradeQuery($orderId){
        $result  = array();
        $request = new \AlipayTradeQueryRequest ();
        $content = array(
            'out_trade_no' => $orderId
        );
        $content = json_encode($content);
        $request->setBizContent($content);
        $response = $this->execute($request);     //获取支付结果
        if(!empty($response)){
            $queryResponse = $response->alipay_trade_query_response;
            if($this->querySuccess($queryResponse)){
                //查询返回该订单交易支付成功
                $result['status']   = "SUCCESS";
                $result['trade_no'] = $queryResponse->trade_no;     //支付宝订单号
                $result['buyer_logon_id'] = $queryResponse->buyer_logon_id;      //买家支付宝账户
                $result['trade_status']   = $queryResponse->trade_status;        //交易状态
                $result['total_amount']   = $queryResponse->total_amount;        //订单金额
            }elseif($this->tradeError($queryResponse)){
                //查询发生异常或无返回，交易状态未知
                $result['status'] = "UNKNOWN";
            }
        }else{
            //其他情况均表明该订单号交易失败
            $result['status'] = "FAILED";
        }
        return $result;
    }
    
    // 查询返回“支付成功”
	protected function querySuccess($queryResponse){
		return !empty($queryResponse)&&
				$queryResponse->code == "10000"&&
				($queryResponse->trade_status == "TRADE_SUCCESS"||
					$queryResponse->trade_status == "TRADE_FINISHED");
	}
    
    // 交易异常，或发生系统错误
	protected function tradeError($queryResponse){
		return empty($response)||
					$queryResponse->code == "20000";
	}
    
}

