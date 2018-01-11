<?php
/**
 * depends kernel container
 * @author huangxm
 *
 */
namespace Oradt\Utils;

trait OcrutilTrait {

    private $vcard = array();
    
    /**
     * 扫描名片 合并正反面数据 ，全部合并到正面
     * @param string $front
     * @param string $back
     * @return string
     */
    public function merge_vcard1($front , $back) {
    	if(empty($front) && empty($back))
    		return '';
    	if(!empty($front) && empty($back))
    	    return $front;
    	if(empty($front) && !empty($back))
    	    return $back;
    	
    	$json_front = json_decode($front , true);
    	$json_back = json_decode($back , true);
    	
    	$this->merge_vcard_v1($json_front['front']);
    	$this->merge_vcard_v1($json_back['front']);
    	
    	return json_encode($this->vcard , JSON_UNESCAPED_UNICODE);
    }

    /**
     * 扫描名片 合并正反面数据 ，全部合并到正面
     * @param array $vcard $json1['front'] or $json1['back']
     */
    private function merge_vcard_v1($vcard) {
    	if(empty($vcard) || !is_array($vcard))
    		return;
    	//解析第一层
    	foreach ($this->keys as $key) {
    		if(!isset($vcard[$key])) {
    			continue;
    		}
    		foreach($vcard[$key] as $item) {
    			$this->vcard['front'][$key][]  = $item;
    		}
    	}
    
    	//if(!isset($this->vcard['front']['company']) )
    	//{
    	//    $this->vcard['front']['company'] = array();
    	//}
    	//扫描名片出来的，只会有下标1
    	if (! isset ( $vcard ['company'] ) || count ( $vcard ['company'] ) < 1) {
    		return ;
    	}
    	//全部合并到下标1
    	foreach ($this->company_keys as $key) {
    		if(!isset($vcard['company'][0][$key])) {
    			continue;
    		}
    
    		foreach($vcard['company'][0][$key] as $item) {
    			$this->vcard['front']['company'][0][$key][] = $item;
    		}
    	}
    
    }
    
    /**
     * 合并两张图片ocr结果 ， 简单合并front,back键
     *
     * @param String $front
     * @param String $back
     * @return string
     */
    public function merge_vcard($front , $back) {
    	if(empty($front) && empty($back))
    		return '';
    	$json_front = json_decode($front , true);
    	$json_back = json_decode($back , true);
    
    	$result = array();
    	if(is_array($json_front) && isset($json_front['front']))
    	{
    		$result['front'] = $json_front['front'];
    	}
    
    	if(is_array($json_back) && isset($json_back['front']))
    	{
    		$result['back'] = $json_back['front'];
    	}
    	return json_encode($result , JSON_UNESCAPED_UNICODE);
    }
    
    /**
     * ocr返回结果版本兼容
     *
     * @param String $str
     * @return array('markpoint' => '' , 'vcard' =>'' , 'error' => '');
     */
    public function fomart_result( $str ) {
    	$result = array('markpoint' => '' , 'vcard' =>'' , 'error' => '');
    	$json = json_decode($str , true);
    	if(is_array($json)) {
    		//原来的返回结果
    		if(!isset($json['markpoint']) && !isset($json['vcard'])) {
    			$result['vcard'] = json_encode( $json ,JSON_UNESCAPED_UNICODE);
    		}
    		//增加markpoint后的返回结果
    		if(isset($json['markpoint'])) {
    			$result['markpoint'] = json_encode($json['markpoint'] , JSON_UNESCAPED_UNICODE);
    		}
    
    		if(isset($json['vcard'])) {
    			$result['vcard'] =json_encode( $json['vcard'] ,JSON_UNESCAPED_UNICODE );
    		}
    	}else{
    		$result['error'] = $str;
    	}
    
    	return $result;
    }    
}