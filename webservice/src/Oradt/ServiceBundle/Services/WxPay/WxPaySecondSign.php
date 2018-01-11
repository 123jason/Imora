<?php
namespace Oradt\ServiceBundle\Services\WxPay;
use Oradt\ServiceBundle\Services\WxPay\lib\WxPayApi;
use Oradt\ServiceBundle\Services\WxPay\lib\WxPayDataBase;

/**
 * 
 * 生成第二次签名
 * @author zhanght
 *
 */
class WxPaySecondSign extends WxPayDataBase
{	
	/**
	* 设置微信分配的公众账号ID
	* @param string $value 
	**/
	public function SetAppid($value)
	{
		$this->values['appid'] = $value;
	}
	/**
	* 获取微信分配的公众账号ID的值
	* @return 值
	**/
	public function GetAppid()
	{
		return $this->values['appid'];
	}
	/**
	* 判断微信分配的公众账号ID是否存在
	* @return true 或 false
	**/
	public function IsAppidSet()
	{
		return array_key_exists('appid', $this->values);
	}


	/**
	* 设置微信支付分配的商户号
	* @param string $value 
	**/
	public function SetMch_id($value)
	{
		$this->values['partnerid'] = $value;
	}
	/**
	* 获取微信支付分配的商户号的值
	* @return 值
	**/
	public function GetMch_id()
	{
		return $this->values['partnerid'];
	}
	/**
	* 判断微信支付分配的商户号是否存在
	* @return true 或 false
	**/
	public function IsMch_idSet()
	{
		return array_key_exists('partnerid', $this->values);
	}


	/**
	* 设置预支付ID
	* @param string $value 
	**/
	public function SetPrepay_id($value)
	{
		$this->values['prepayid'] = $value;
	}
	/**
	* 获取预支付ID
	* @return 值
	**/
	public function GetPrepay_id()
	{
		return $this->values['prepayid'];
	}
	/**
	* 判断预支付ID
	* @return true 或 false
	**/
	public function IsPrepay_idSet()
	{
		return array_key_exists('prepayid', $this->values);
	}


	/**
	* 设置随机字符串，不长于32位。推荐随机数生成算法
	* @param string $value 
	**/
	public function SetNonce_str($value)
	{
		$this->values['noncestr'] = $value;
	}
	/**
	* 获取随机字符串，不长于32位。推荐随机数生成算法的值
	* @return 值
	**/
	public function GetNonce_str()
	{
		return $this->values['noncestr'];
	}
	/**
	* 判断随机字符串，不长于32位。推荐随机数生成算法是否存在
	* @return true 或 false
	**/
	public function IsNonce_strSet()
	{
		return array_key_exists('noncestr', $this->values);
	}

	/**
	* 设置package
	* @param string $value 
	**/
	public function SetPackage($value)
	{
		$this->values['package'] = $value;
	}
	/**
	* 获取package
	* @return 值
	**/
	public function GetPackage()
	{
		return $this->values['package'];
	}
	/**
	* 判断package
	* @return true 或 false
	**/
	public function IsPackageSet()
	{
		return array_key_exists('package', $this->values);
	}



	/**
	* 设置时间戳
	* @param string $value 
	**/
	public function SetTime_stamp($value)
	{
		$this->values['timestamp'] = $value;
	}
	/**
	* 获取时间戳
	* @return 值
	**/
	public function GetTime_stamp()
	{
		return $this->values['timestamp'];
	}
	/**
	* 判断时间戳
	* @return true 或 false
	**/
	public function IsTime_stampSet()
	{
		return array_key_exists('timestamp', $this->values);
	}


}
