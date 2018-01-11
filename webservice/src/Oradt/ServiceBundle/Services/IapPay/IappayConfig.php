<?php

namespace Oradt\ServiceBundle\Services\IapPay;
require_once dirname(__FILE__).'/../../../../../app/config/design_config.php';
use DesignConfig;

/**
* 	配置账号信息
*/

class IappayConfig
{
	private $iappay_config = array();
	public function getIapConfig(){
		return $this->iappay_config;
	}
    public function __construct() {
		        

    }
	const receipt_url = DesignConfig::IAPPAY_RECEIPT;
}
?>