<?php
namespace Oradt\ServiceBundle\Services;
use Oradt\Utils\Str2PY;
use Oradt\Utils\VcardTrait;
class VcardJsonService {

    use VcardTrait;
    private $LAN = array(//定义title字段
        'FN' => '姓名',
        'ENAME' => '英文名',
        'MOBILES' => '手机',
        'DEPAR' => '部门',
        'TITLE' => '职位',
        'ORG' => '公司',
        'ADR' => '地址',
        'TELS' => '电话',
        'FAXS' => '传真',
        'EMAIL' => '邮件',
        'URL' => '网址' 
    );
    private $property = array('title', 'title_self_def', 'value'); //定义属性
    private $mapping = array(
        'FN' => 'name',
        'ENAME' => 'name',
        'MOBILES' => 'mobile',
        'DEPAR' => 'department',
        'TITLE' => 'job',
        'ORG' => 'company_name',
        'ADR' => 'address',
        'TELS' => 'telephone',
        'FAXS' => 'fax',
        'EMAIL' => 'email',
        'URL' => 'web'
    );
    private $insertArray = array();
    private $outArray = array();
    private $sides = '';
    public function __construct($container) {

    }

    /**
     * 解析 vcard
     * @param json $vcard
     */
    public function setVcard($vcard) {
        $vcardArr = json_decode($vcard, true);
        if (is_null($vcardArr))
            return false;
        $outArray = array();
        if (!empty($vcardArr)) {
            /*
            if(array_key_exists("front", $vcardArr) && array_key_exists("name",$vcardArr['front'])){
                $front = $vcardArr['front']['name'][0]['value'];
                if (array_key_exists("back", $vcardArr) && array_key_exists("name",$vcardArr['back']) && !empty($vcardArr['back']['name'])) {
                    $back = $vcardArr['back']['name'][0]['value'];
                    if (empty($front)) {
                        $this->sides = $back;
                    } else {
                        $this->sides = $front;
                    }
                } else {
                    $this->sides = $front;
                }
            }*/
            
            $name = '';
            if(isset($vcardArr['front']) && isset($vcardArr['front']['name']) && count($vcardArr['front']['name'])>0 && 
                isset($vcardArr['front']['name'][0]['value'])) {
                $name = $vcardArr['front']['name'][0]['value'];
            }
            if(empty($name)) {
                if(isset($vcardArr['back']) && isset($vcardArr['back']['name']) && count($vcardArr['back']['name'])>0 &&
                isset($vcardArr['back']['name'][0]['value'])) {
                	$name = $vcardArr['back']['name'][0]['value'];
                }
            }
            $this->sides = $name;
            
            foreach ($vcardArr as $key => $v) {
                $this->loopVcardList($v);
            }
            $outArray = $this->insertArray;
            //unset($this->insertArray);
            $this->insertArray = array();
        }

        $outArray = $this->arrayToString($outArray);
        return $outArray;
    }

    private function loopVcardList($vcardArr) {
        if (is_array($vcardArr)) {
            foreach ($vcardArr as $key => $v) {//echo $key."--------";var_dump($v);continue;
                switch ($key) {
                    case 'company':
                        $this->loopVcardList2($v);
                        break;
                    default:
                        $this->getArrayValue($key, $v);
                }
            }
        }
    }

    private function loopVcardList2($vcardArr) {
        if (is_array($vcardArr)) {
            foreach ($vcardArr as $key => $v) {
                if( is_numeric($key) ){
                    $this->loopVcardList2($v);
                }
                $this->getArrayValue($key, $v);
            }
        }
    }
    private function getArrayValue($key, $v) {
        if (is_array($v)) {
            foreach ($v as $v2) {
                if (isset($v2['value'])) {
                    switch ($key) {
                        case 'name':
                            $key2k = "NAMES";
                            if (empty($this->insertArray['FN'])) {
                                $this->insertArray['FN'] = $this->sides;
                            }
                            if (empty($this->insertArray['ENAME']) && (isset($v2['is_chinese']) && intval($v2['is_chinese']) === 0)) {
                                $this->insertArray['ENAME'] = $v2['value'];
                                // 再次判断是否有名字没有则上英文名字
                                if (empty($this->insertArray['FN'])) {
                                    $this->insertArray['FN'] = $v2['value'];
                                }
                            }
                            break;
                        case 'mobile': $key2k = "CELL";
                            break;
                        case 'department': $key2k = "DEPAR";
                            break;
                        case 'job': $key2k = "TITLE";
                            break;
                        case 'company_name': $key2k = "ORG";
                            break;
                        case 'address': $key2k = "ADR";
                            break;
                        case 'telephone': $key2k = "WORK";
                            break;
                        case 'fax': $key2k = "FAX";
                            break;
                        case 'email': $key2k = "EMAIL";
                            break;
                        case 'web': $key2k = "URL";
                            break;
                        default:
                            $key2k = $key;
                    }
                    if (in_array($key2k, array('CELL', 'WORK', 'FAX'))) {
                        if ('CELL' === $key2k) {
                            $this->insertArray['MOBILES'][] = $v2['value'];
                        }
                        if ('WORK' === $key2k) {
                            $this->insertArray['TELS'][] = $v2['value'];
                        }
                        $this->insertArray['TEL'][] = $key2k . ':' . $v2['value'];
                    } else {
                        $this->insertArray[$key2k][] = $v2['value'];
                    }
                }
            }
        }
    }

    private function getMd5Value($outArray = array()) {
        $strValue = '';
        if (isset($outArray['NAMES'])) {
            $names = $outArray['NAMES'];
            sort($names);
            $strValue .= implode(',', $names);
        }
        if (isset($outArray['MOBILES'])) {
            $cells = $outArray['MOBILES'];
            sort($cells);
            foreach( $cells as $v ){
                $v = str_replace( array(" ","-"), "", $v);
                $v = preg_replace('/^[+]?86/','', $v);
                $strValue .= ',' . $v;
            }
            //$strValue .= ',' . implode(',', $cells);
        }
        if (!isset($outArray['Md5ValueFm'])) {
            $outArray['Md5ValueFm'] = '';
        }
        if (!empty($strValue)) {
            $outArray['Md5ValueFm'] = md5(trim($strValue, ','));
        }
        if (isset($outArray['TITLE'])) {
            $jobs = $outArray['TITLE'];
            sort($jobs);
            $strValue .= ',' . implode(',', $jobs);
        }
        if (isset($outArray['ORG'])) {
            $companys = $outArray['ORG'];
            sort($companys);
            $strValue .= ',' . implode(',', $companys);
        }
        if (!isset($outArray['Md5Value'])) {
            $outArray['Md5Value'] = '';
        }
        if (!empty($strValue)) {
            $outArray['Md5Value'] = md5(trim($strValue, ','));
        }
        return $outArray;
    }

    private function arrayToString($outArray = array()) {
        if (is_array($outArray) && !empty($outArray)) {

            $outArray = $this->getMd5Value($outArray);

            foreach ($outArray as $k => $avl) {
                if (is_array($avl)) {
                    $uniqArr = array_unique($avl);
                    switch ($k) {
                        case 'ORG':
                        case 'TITLE':
                        case 'URL':
                        case 'ADR':
                            $outArray[$k] = $uniqArr[0];
                            if ('URL' === $k) {
                                $outArray[$k . 'S'] = implode(';', $uniqArr);
                            }
                            break;
                        default:;
                    }
                    if( 'ADR' === $k ){
                        $outArray[$k] = implode(';', $uniqArr);
                    }else{
                        $outArray[$k] = implode(',', $uniqArr);
                    }
                }
            }
        }
        return $outArray;
    }

    /**
     * 比较两个Vcard不同
     * @package $oldvcard Json
     * @package $newvcard Json
     */
    public function judgeVcardChange($oldVcard, $newvcard) {
        $oldVcardArray = $this->setVcard($oldVcard);

        $newVcardArray = $this->setVcard($newvcard);
        //print_r($newVcardArray);die;
        if (false === $oldVcardArray || false === $newVcardArray) {
            return false;
        }
        $oldTEL = isset($oldVcardArray['TEL']) ? $oldVcardArray['TEL'] : "";
        $oldTELArray = explode(',',$oldTEL);
        $newTEL = isset($newVcardArray['TEL']) ? $newVcardArray['TEL'] : "";
        $newTELArray = explode(',',$newTEL);
        unset($oldVcardArray['TEL']);
        unset($newVcardArray['TEL']);
        $arr1 = array_diff($oldVcardArray, $newVcardArray);

        $arr2 = array_diff($newVcardArray, $oldVcardArray);

        $arr3 = array_diff($oldTELArray , $newTELArray);

        $arr4 = array_diff($newTELArray , $oldTELArray);

        return array_merge($arr1, $arr2 , $arr3 , $arr4);
    }

    /**
     * 输出Vcard
     * @package array $vcardData 名片数据
     */
    public function getVcard( $outArray ) {
        $vcardData = '';
        if( is_array( $outArray ) ){
            $vcardData = json_encode($outArray, JSON_UNESCAPED_UNICODE);
        }
        return $vcardData;
    }
    /**
     * 设置参数
     * @param array $param 初始化参数
     */
    public function setParam( $param = array()){
        if( empty($param) ){
            return;
        }
        $vcardData = '';
        foreach( $param as $key => $v ){
            if( empty($v) ) continue;
            if( in_array($key, array( 'front', 'back' )) ){
                foreach( $v as $k => $val ){
                    if( is_array($val) ){
                        foreach( $val as $val2 ){
                            $this->setProperty( $k, $val2 );
                        }
                        continue;
                    }
                    $this->setProperty( $k, $val );
                }
            }
            $outArray[$key] = $this->outArray;
            $this->outArray = array();
        }
        return $this->getVcard( $outArray );
    }
    /**
     * 设置属性
     * @param array $param 初始化参数
     */
    private function setProperty( $key = '', $val = '' ){
        if( empty($key) || empty($val) ){
            return;
        }        
        $outArray = array();
        foreach( $this->property as $item ){
            switch ($item) {
                case 'title':
                    $outArray[$item] = $this->LAN[$key]; break;
                case 'value':
                    $outArray[$item] = $val; break;
                default:
                    $outArray['title_self_def'] = 0;  
            }
        }  
        if( !empty($outArray) ){
            switch ($key){
                case 'FN':
                    $outArray['is_chinese'] = '1';//处理姓名is_chinese字段
                    $this->outArray[$this->mapping[$key]][] = $outArray;
                    break;
                case 'ENAME':
                    $outArray['is_chinese'] = '0';
                    $this->outArray[$this->mapping[$key]][] = $outArray;
                    break;  
                case 'MOBILES':
                    $this->outArray[$this->mapping[$key]][] = $outArray;
                    break; 
                default:
                    $this->outArray['company'][0][$this->mapping[$key]][] = $outArray;
                    break;        
            }
        }         
    }
    
    public $vcard_json = array();
    private function getloop($arr,$k,$key = '',$ke = 0) {
        if($key){
            foreach ($arr as $item) {
            if(!isset($item['value']))
                continue;
                $this->vcard_json[$key][$ke][$k][] = trim($item['value']);
            }
            $this->vcard_json[$key][$ke][$k]= array_unique($this->vcard_json[$key][$ke][$k]);
        }else{
            foreach ($arr as $item) {
                if(!isset($item['value']))
                    continue;
                $this->vcard_json[$k][] = trim($item['value']);
            }
            $this->vcard_json[$k]= array_unique($this->vcard_json[$k]);
        }
        
    }
    /**
     * jsonvcard 格式生辰数组形式
     * @param type $vcard
     * @return type
     */
    public function loadVcard($vcard) {
        $data = json_decode($vcard , true);
        if(!empty($data['front'])){
            foreach ($data['front'] as $k=>$item) {
                if($k=='company')
                    continue;
                $this->getloop($item,$k);
            }
            if(!empty($data['front']['company'])){
                foreach ($data['front']['company'] as $key=>$item) {
                    foreach ($item as $k=>$v) {
                        if(!empty($v)){
                            $this->getloop($v,$k,'company',$key);
                        }
                    }
                }
            }
        }
        
        return $this->vcard_json;
    }
    
    public $vcard_array = array();//修改给定旧的vcard数组值
    /**
     * 主要用于ocr的需求统一
     */
    public function setVcardParam($param = array()){
        if( empty($param) ){
            return;
        }
        foreach( $param as $key => $v ){
            if( empty($v) ) continue;
            if( in_array($key, array( 'front', 'back' )) ){
                foreach( $v as $k => $val ){
                    if( is_array($val) ){
                        foreach( $val as $val2 ){
                            $this->setParamProperty( $k, $val2 );
                        }
                        continue;
                    }
                    $this->setParamProperty( $k, $val );
                }
            }
            $outArray[$key] = $this->outArray;
            $this->outArray = array();
        }
        return $this->getVcard( $outArray );
    }
    
    /**
     * 设置属性
     * @param array $param 初始化参数
     */
    private $paramproperty = array('title', 'title_self_def', 'value','is_changed','input'); //定义属性
    private function setParamProperty( $key = '', $val = '' ){
        if( empty($key) || empty($val) ){
            return;
        }        
        $outArray = array();
        foreach( $this->paramproperty as $item ){
            switch ($item) {
                case 'title':
                    $outArray[$item] = $this->LAN[$key];
                    break;
                case 'value':
                    $outArray[$item] = $val;
                    break;
                case 'is_changed':
                    if(!empty($this->vcard_array[$this->mapping[$key]])){
                        $this->vcard_array[$this->mapping[$key]] ==  $val ? $outArray[$item] = 0 : $outArray[$item] = 1; 
                    } else {
                        $outArray[$item] = 0;
                    }
                    
                    //$outArray[$item] = 0; 
                    break;
                case 'input':
                    $outArray[$item] = 0; 
                    break;
                default:
                    $outArray['title_self_def'] = 0;  
            }
        }  
        if( !empty($outArray) ){
            switch ($key){
                case 'FN':
                    $strpy = new Str2PY();
                    $nameinfo = $strpy->splitName($val);
                    $outArray['is_chinese'] = '1';//处理姓名is_chinese字段
                    $outArray['given_name'] = $nameinfo[1];
                    $outArray['surname'] = $nameinfo[0];
                    $this->outArray[$this->mapping[$key]][] = $outArray;
                    break;
                case 'ENAME':
                    $outArray['is_chinese'] = '0';
                    $this->outArray[$this->mapping[$key]][] = $outArray;
                    break;  
                case 'MOBILES':
                    $this->outArray[$this->mapping[$key]][] = $outArray;
                    break; 
                default:
                    $this->outArray['company'][0][$this->mapping[$key]][] = $outArray;
                    break;        
            }
        }         
    }
}
