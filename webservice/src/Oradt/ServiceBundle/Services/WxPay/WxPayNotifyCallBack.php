<?php
namespace Oradt\ServiceBundle\Services\WxPay;

/**
 * 
 * 业务回调
 * @author zhanght
 *
 */
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Oradt\ServiceBundle\Services\WxPay\lib\WxPayNotify;
use Oradt\ServiceBundle\Services\WxPay\lib\WxPayOrderQuery;
use Oradt\ServiceBundle\Services\WxPay\lib\WxPayApi;
class WxPayNotifyCallBack extends WxPayNotify
{
	//查询订单
	protected $ret_values = array();
		
	/**
	 * 获取设置的值
	 */
	public function GetRetValues()
	{

		return $this->ret_values;
	}
	public function Queryorder($transaction_id)
	{
		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$ret_values = WxPayApi::orderQuery($input);
		print_r($ret_values);
		if(array_key_exists("return_code", $ret_values)
			&& array_key_exists("result_code", $ret_values)
			&& $ret_values["return_code"] == "SUCCESS"
			&& $ret_values["result_code"] == "SUCCESS")
		{
			
			return true;
		}
		return false;
	}
	
	//重写回调处理函数
	public function NotifyProcess($data, &$msg)
	{
		$notfiyOutput = array();
		
		if(!array_key_exists("transaction_id", $data)){
			$msg = "输入参数不正确";
			return false;
		}
		$this->ret_values = $data;
		return true;
		//查询订单，判断订单真实性,暂不使用
		if(!$this->Queryorder($data["transaction_id"])){
			$msg = "订单查询失败";
			return false;
		}
		
	}
}

