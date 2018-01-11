<?php
/**
 * @author liuping Chen <chenliuping@oradt.com>
 * get name ocr_old_service
 */
namespace Oradt\ServiceBundle\Services;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * ocrold
 */
class OcrOldService extends BaseService {
    
    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
    }
    /**
     * ocrold解析 针对传图片返回xml的
     * @param type $picture 图片地址
     * @return type
     */
    public function ocrXml($picture){
        set_include_path(dirname(dirname(__DIR__)).'/Utils/');
        require_once ('Zend/Http/Client.php');
        $return = array(
            'card_name' =>'',
            'card_emali' =>'',
            'card_job' =>'',
            'card_company' =>'',
            'card_address' =>'',
            'card_zipcode' =>'',
            'card_telephone' =>'',
            'card_mobile' =>'',
            'card_fax' =>'',
            'card_company_url' =>'',
            'card_industry' =>'',
            'wechat_card_xml' =>'',
            'vcard' => ''
        );
        $wechat_card_xml = $this->ocr($picture);
        $return['wechat_card_xml'] = $wechat_card_xml;
        
        //判断是不是正确的xml
        $res = $this->xml_parser($wechat_card_xml);
        if(empty($res)){
            return $return;
        }
        //xml转成名片数据
        $vcard = $this->vcard($wechat_card_xml);

        $dom = new \DOMDocument();
        $dom->loadXML($wechat_card_xml);
        
        $arr = $this->getArray($dom->documentElement);;

        $array = array();
        //if(!empty($arr['data'][0])){
        if(array_key_exists('data',$arr)){
            foreach ( $arr['data'][0] as $key=>$val){
                if($val[0]){
                    foreach ($val[0] as $value) {
                        if(count($value)>1){
                            if($key == 'company'){
                                $array[$key] = implode('###', $this->strlen($this->i_array_column($value, '#text'),40));
                            } elseif ($key == 'card_address') {
                                $array[$key] = implode(',', $this->strlen($this->i_array_column($value, '#text'),80));
                            } elseif ($key == 'card_job' || $key == 'card_industry') {
                                $array[$key] = implode(',', $this->strlen($this->i_array_column($value, '#text'),40));
                            } else {
                                $array[$key] = implode(',', $this->strlen($this->i_array_column($value, '#text'),20));
                            }
                        } else {
                            $array[$key] = $value['#text'];
                        }
                    }
                }
            }
        }
        
        $return['card_name'] = !empty($array['name']) ? $array['name'] : '';
        $return['card_emali'] = !empty($array['email']) ? $array['email'] : '';
        $return['card_industry'] = !empty($array['memo']) ? $array['memo'] : '';
        $return['card_job'] = !empty($array['jobtitle']) ? $array['jobtitle'] : '';
        $return['card_company'] = !empty($array['company']) ? $array['company'] : '';
        $return['card_address'] = !empty($array['address']) ? $array['address'] : '';
        $return['card_zipcode'] = !empty($array['postcode']) ? $array['postcode'] : '';
        $return['card_telephone'] = !empty($array['tel_main']) ? $array['tel_main'] : '';
        $return['card_mobile'] = !empty($array['tel_mobile']) ? $array['tel_mobile'] : '';
        $return['card_fax'] = !empty($array['fax']) ? $array['fax'] : '';
        $return['card_company_url'] = !empty($array['web']) ? $array['web'] : '';
        $return['vcard'] = !empty($vcard) ? $vcard : '';
        return $return;
    }
    /**
     * 解析xml
     * @param type $node
     * @return type
     */
    private function getArray($node){
        if ($node->hasAttributes()) {
            foreach ($node->attributes as $attr) {
                $array[$attr->nodeName] = $attr->nodeValue;
            }
        }
        if ($node->hasChildNodes()) {
            if ($node->childNodes->length == 1) {
                $array[$node->firstChild->nodeName] = $this->getArray($node->firstChild);
            } else {
                foreach ($node->childNodes as $childNode) {
                    if ($childNode->nodeType != XML_TEXT_NODE) {
                        $array[$childNode->nodeName][] = $this->getArray($childNode);
                    }
                }
            }
        } else {
            return $node->nodeValue;
        }
        
        return $array;
    }
    /**
     * 图片识别成xml格式
     * @return type
     */
    private function ocr($wechatpicture){
        $str = "<ACTION>Passpory</ACTION><EXT>".$wechatpicture->getClientOriginalExtension()."<?EXT><file>";        
        $arr = $str.file_get_contents($wechatpicture->getPathname()).'</file>';
        $httpRequestConfig =array(
            'ssltransport' => 'tls',
            'adapter' =>'Zend_Http_Client_Adapter_Curl',
            'curlloptions' => array(CURLOPT_SSL_VERIFYPEER=>false)
        );
        $httpClient = new \Zend_Http_Client("http://192.168.40.92:8080/PIM_NameCard/SrvXMLAPI",$httpRequestConfig);
        $httpClient->setRawData($arr);
        $httpResponse = $httpClient->request("POST")->getRawBody();
        return $httpResponse;
    }
    /**
     * 检查xml格式是否错误
     * @param type $str
     * @return boolean
     */
    private  function xml_parser($str){   
       $xml_parser = xml_parser_create();   
       if(!xml_parse($xml_parser,$str,true)){   
           xml_parser_free($xml_parser);   
           return false;   
       }else {   
           return (json_decode(json_encode(simplexml_load_string($str)),true));   
       }   
    } 
    /**
     * xml解析后字符截取
     * @param type $data
     * @param type $leng
     * @return type
     */
    private function strlen($data,$leng){
        foreach ($data as $key=>$val){
             if($key < 4){
                 $res[] = mb_substr($val,0,$leng,'utf-8');
             }                       
        }
        return $res;
    }
    
    /**
     * 名片格式生成
     * @param type $xml
     * @return boolean
     */
    public function vcard($xml){
        $res = $this->xml_parser($xml);
        if(empty($res)){
            return false;
        }
        $res = $this->xml_to_json($xml);
        $res = json_decode($res, true);
        $data = array();
        if(array_key_exists('data',$res)){
            foreach($res['data'] as $key=>$val){
                if(array_key_exists("v", $val)){
                    $data[$key] = $val['v'];
                } else {
                     $data[$key] = '';
                }
            }
        } else {
            return false;
        }
//        print_r($data);
//        die;
        //
        $vcardService =  $this->container->get('vcard_json_service');
        
        $vcardData['FN'] = count($data['name']) > 1 ? $this->vcardparam($data['name'][0]) : $this->vcardparam($data['name']);
        $vcardData['ENAME'] = count($data['name']) > 1 ? $this->vcardparam($data['name'][1]) : '';
        $vcardData['ORG'] = $this->vcardparam($data['company']);
        $vcardData['DEPAR'] = $this->vcardparam($data['department']);
        $vcardData['TITLE'] = $this->vcardparam($data['jobtitle']);
        $vcardData['URL'] = $this->vcardparam($data['web']);
        $vcardData['ADR'] = $this->vcardparam($data['address']);
        $vcardData['MOBILES'] = $this->vcardparam($data['tel_mobile']);
        $vcardData['EMAIL'] = $this->vcardparam($data['email']);
        $vcardData['TELS'] = $this->vcardparam($data['tel_main']);
        $vcardData['FAXS'] = $this->vcardparam($data['fax']);
        $vcard = $vcardService->setVcardParam(array('front' => $vcardData));
        return $vcard;
    }
     private function vcardparam($data){
        if(count($data) > 1){
            foreach($data as $val){
                $res[] = $val;
            }
        } else {
            $res = $data;
        }
        return $res;
    }
    private function xml_to_json($source) {
        if(is_file($source)){ //传的是文件，还是xml的string的判断
            $xml_array = simplexml_load_file($source);
        }else{
            $xml_array = simplexml_load_string($source);
        }
        $json = json_encode($xml_array); //php5，以及以上，如果是更早版本，请查看JSON.php
        return $json;
    }
    /**
     * 第二种兼容新的
     * @param type $picture
     */
    public function ocrXmlJson($picture){
        set_include_path(dirname(dirname(__DIR__)).'/Utils/');
        require_once ('Zend/Http/Client.php');
        $xml = $this->ocr($picture);
        $data['vcard'] = $this->vcard($xml);
        $data['wechat_card_xml'] = $xml;
        return $data;
        
    }
    /**
     * 
     * @param type $pic
     * @return \Oradt\ServiceBundle\Services\UploadedFile
     */
    public function run($pic) {
        $data = array('status' => 0);
        set_include_path(dirname(dirname(__DIR__)).'/Utils/');
        require_once ('Zend/Http/Client.php');
        $xml = $this->ocr($pic);
        $data['vcard'] = $this->vcard($xml);
        if(!empty($data['vcard'])) {
            $data['status'] = 10000;
        }
        $data['upobject'] = $pic;
        return $data;
    }
}
