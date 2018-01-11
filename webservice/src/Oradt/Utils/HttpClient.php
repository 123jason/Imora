<?php
namespace Oradt\Utils;

class HttpClient {
    
    private $httpRequestConfig = array(
                'ssltransport' => 'tls',
                'adapter' => 'Zend_Http_Client_Adapter_Curl',
                'curloptions' => array(CURLOPT_SSL_VERIFYPEER => false));
    
    public function __construct() {        
        $includePath = dirname(__FILE__) . PATH_SEPARATOR . get_include_path();
        set_include_path($includePath);
        require_once('Zend/Http/Client.php');
    }
    
    public function getHttpClient($url) {
        return new Zend_Http_Client($url , $this->httpRequestConfig);
    }
    
}