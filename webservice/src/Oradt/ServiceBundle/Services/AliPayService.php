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

class AliPayService extends BaseService {
     
    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
    }
    
    /**
     * 获取支付宝 配置信息 【购买名片 购买会员 购买扩充】
     */
    public function getAliConfig(){
        $alipay_config  = array();
        //合作身份者id，以2088开头的16位纯数字
		$alipay_config['partner']           = $this->container->getParameter('ALIPAY_ACCOUNT');
		//收款支付宝账号
		$alipay_config['seller_email']      = $this->container->getParameter('ALIPAY_EMAIL');
		//安全检验码，以数字和字母组成的32位字符
		$alipay_config['key']               = $this->container->getParameter('ALIPAY_KEY');	
		//↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑	
		//签名方式 不需修改
		$alipay_config['sign_type']     = strtoupper('RSA');	
		//字符编码格式 目前支持 gbk 或 utf-8
		$alipay_config['input_charset'] = strtolower('utf-8');	
		//ca证书路径地址，用于curl中ssl校验
		//请保证cacert.pem文件在当前文件夹目录中
		$alipay_config['cacert']        = dirname(__FILE__).'/AliPay/cacert.pem';	
		//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
		$alipay_config['transport']     = 'http';    
		return $alipay_config;
	}

}
