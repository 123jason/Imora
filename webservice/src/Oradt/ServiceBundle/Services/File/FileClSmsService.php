<?php

namespace Oradt\ServiceBundle\Services\File;

/**
* 
*/
class FileClSmsService
{
	
	/**
	 * 国内账号
	 */
	private $DOMESTIC_API_SEND_URL      = 'http://222.73.117.156/msg/HttpBatchSendSM';//发送地址
	private $DOMESTIC_API_QUERY_BALANCE = 'http://222.73.117.156/msg/QueryBalance';//查看余额
	private $DOMESTIC_API_SEND_ACCOUNT  = 'jiekou-clcs-01';//账号
	private $DOMESTIC_API_SEND_PASSWORD = 'Zs112233';//密码
	/**
	 * 国际账号
	 */
	private $INTERNATIONAL_API_SEND_URL      = 'http://222.73.117.138:7891/mt';//发送地址
	private $INTERNATIONAL_API_QUERY_URL     = 'http://222.73.117.138:7891/bi';
	private $INTERNATIONAL_API_ISENDURL      = 'http://222.73.117.140:8044/mt';
	private $INTERNATIONAL_API_IQUERYURL     = 'http://222.73.117.140:8044/bi';
	private $INTERNATIONAL_API_SEND_ACCOUNT  = 'Z13178892879';//账号
	private $INTERNATIONAL_API_SEND_PASSWORD = '982341';//密码
	/**
	 * 发送短信
	 *
	 * @param string $mobile 手机号码
	 * @param string $msg 短信内容
	 * @param string $needstatus 是否需要状态报告
	 * @param string $extno   扩展码，可选
	 */
	public function sendSms( $mobile, $msg, $needstatus = 'false', $extno = '') {
		$apiSendUrl = $this->DOMESTIC_API_SEND_URL;
		$account    = $this->DOMESTIC_API_SEND_ACCOUNT;
		$password   = $this->DOMESTIC_API_SEND_PASSWORD;
		//创蓝接口参数
		$postArr = array (
				          'account' => $account,
				          'pswd' => $password,
				          'msg' => $msg,
				          'mobile' => $mobile,
				          'needstatus' => $needstatus,
				          'extno' => $extno
                     );
		$result = $this->curlPost( $apiSendUrl , $postArr);
		return $result;
	}
	
	/**
	 * 查询额度
	 *
	 *  查询地址
	 */
	public function queryBalance() {
		$apiBalanceQueryUrl = $this->DOMESTIC_API_QUERY_BALANCE;
		$apiAccount = $this->DOMESTIC_API_SEND_ACCOUNT;
		$apiPswd    = $this->DOMESTIC_API_SEND_PASSWORD;
		//查询参数
		$postArr = array ( 
		          'account' => $apiAccount,
		          'pswd' => $apiPswd,
		);
		$result = $this->curlPost($apiBalanceQueryUrl, $postArr);
		return $result;
	}
	/**
	 * 处理返回值
	 * 
	 */
	public function execResult($result){
		$result=preg_split("/[,\r\n]/",$result);
		return $result;
	}
	/**
	 * 通过CURL发送HTTP请求
	 * @param string $url  //请求URL
	 * @param array $postFields //请求参数 
	 * @return mixed
	 */
	private function curlPost($url,$postFields = '',$flag = 1){		
		$ch = curl_init ();
		if (1 == $flag) {
			$postFields = http_build_query($postFields);
			curl_setopt ( $ch, CURLOPT_POST, 1 );
			curl_setopt ( $ch, CURLOPT_HEADER, 0 );
			curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt ( $ch, CURLOPT_URL, $url );
			curl_setopt ( $ch, CURLOPT_POSTFIELDS, $postFields );	
		}else{
			curl_setopt($ch,CURLOPT_HEADER,0);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch,CURLOPT_URL,$url);	
		}
		$result = curl_exec ( $ch );
		curl_close ( $ch );
		return $result;
	}
	
	/**
	 * 国际短信发送
	 * @param string $phone   	手机号码
	 * @param string $content 	短信内容
	 * @param integer $isreport	是否需要状态报告
	 * @return void
	 */
	public function sendInternational($phone,$content,$isreport=0){
		$requestData=array(
			'un'=>$this->INTERNATIONAL_API_SEND_ACCOUNT,
			'pw'=>$this->INTERNATIONAL_API_SEND_PASSWORD,
			'sm'=>$content,
			'da'=>$phone,
			'rd'=>$isreport,
			'rf'=>2,
			'tf'=>3,
		);
		
		$url=$this->$INTERNATIONAL_API_IQUERYURL.'?'.http_build_query($requestData);
		return $this->curlPost($url,'',0);
	}

	/**
	 *
 	 * 国际短信查询余额
	 * @return String 余额返回
	 */
	public function queryBalanceInternational(){
		$account    = $this->INTERNATIONAL_API_SEND_ACCOUNT;
		$password   = $this->INTERNATIONAL_API_SEND_PASSWORD;
		$requestData=array(
			'un'=>$account,
			'pw'=>$password,
			'rf'=>2
		);

		$url=$this->INTERNATIONAL_API_IQUERYURL.'?'.http_build_query($requestData);
		return $this->curlPost($url,'',0);
	}
}
?>