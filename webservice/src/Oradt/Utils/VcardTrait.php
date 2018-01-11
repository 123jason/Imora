<?php
/**
 * 名片数据操作相关
 * 
 * @author huangxm
 *
 */
namespace Oradt\Utils;

trait VcardTrait {
    
    /**
     *
     * @var 键 => array()
     *
     * [fax] => Array
     (
     [0] => Array
     (
     [input] => 0
     [is_changed] => 0
     [title] => 传真
     [title_self_def] => 0
     [value] => fax_front1
     )
    
     [1] => Array
     (
     [input] => 0
     [is_changed] => 0
     [title] => 传真
     [title_self_def] => 0
     [value] => fax_back1
     )
    
     )
     */
    private $vcard_map = array();
    /**
     *
     * @var 键 =>
     * Array
     (
     [name] => Array
     (
     [0] => name_front1
     [1] => name_back1
     )
    
     [mobile] => Array
     (
     [0] => mobile_front1
     [1] => mobile_back1
     )
     *
    */
    private $vcard_map_value = array();
    
    /**
     *
     * @var 键 =>
     * Array
     (
     [0] => address_back1
     [1] => address_front1
     [2] => company_name_back1
     *
    */
    private $vcard_values = array();
    
    /**
     *
     * @var 第一层key
    */
    public $keys = array('name', 'mobile','email','IM');
    /**
     *
     * @var 公司层key
    */
    
    public $company_keys = array('department', 'job','company_name','address','telephone','fax','email','web');
     
    /**
     *
     * 获取指定键值数组
     *
     * @param mixed $key String or array('name','mobile')
    */
    public function getItems($key) {
    	$values = array();
    	if(is_string($key)) {
    		if(array_key_exists($key, $this->vcard_map_value)) {
    			$values = $this->vcard_map_value[$key];
    		}
    
    	}else if(is_array($key)){
    		foreach ($key as $k) {
    			if(array_key_exists($k, $this->vcard_map_value)) {
    				$values = array_merge($values,$this->vcard_map_value[$k]);
    			}
    		}
    	}
    
    	return $values;
    }

    public function getMap()
    {
        return array_map(array($this, 'mult_unique'), $this->vcard_map);
    }
    private function mult_unique($array)
    {
        $return = array();
        foreach($array as $key=>$v)
        {
            if(!in_array($v, $return))
            {
                $return[]=$v;
            }
        }
        return $return;
    }
    public function getEnSum() {
        $sum = 0;
        if(!isset($this->vcard_map['name']))
            return $sum;
        $names = $this->vcard_map['name'];
        //print_r($names);
        foreach($names as $item) {
            if(isset($item['title']) && 
                $item['title']=='英文名') {
                return 1;
            }
        }

        return $sum;
    }
    
    /**
     * 返回所有字段值数组
     *
     * @return array(0=>'姓名'，0=>'电话');
     */
    public function getAllFields() {
    	return $this->vcard_values;
    }
    
    /**
     * 载入vcard 数据  ，后面可用getAllFields\ getItems 等方法获取数据
     * 
     * @param mixed $vcard String or array(）
     */
    public function load($vcard) {
        $this->vcard_map = array();
        $this->vcard_map_value = array();
        $this->vcard_values = array();
    	if(empty($vcard))
    		return;
    	if(!is_array($vcard)) {
    	    $vcard = json_decode($vcard , true);
    	}
    	
    	if(isset($vcard['front']))
    		$this->load1($vcard['front']);
    	if(isset($vcard['back']))
    		$this->load1($vcard['back']);
    }
    /**
     * 合并正反面数据 ，全部合并到正面
     * @param array $vcard $json1['front'] or $json1['back']
     */
    private function load1($vcard) {
    	if(empty($vcard) || !is_array($vcard))
    		return;
    	//解析第一层
    	foreach ($this->keys as $key) {
    		if(!isset($vcard[$key])) {
    			continue;
    		}
    		foreach($vcard[$key] as $item) {
    			$this->vcard_map[$key][]  = $item;
    			if(isset($item['value']) && !empty($item['value'])) {
    				$this->vcard_values[] = $item['value'];
    				$this->vcard_map_value[$key][] = $item['value'];
    			}
    		}
    	}
    
    	//扫描名片出来的，只会有下标1
    	if (! isset ( $vcard ['company'] ) || count ( $vcard ['company'] ) < 1) {
    		return;
    	}
    	foreach ( $vcard ['company'] as $l_key => $l_value ) {
    		// 全部合并到下标1
    		foreach ( $this->company_keys as $key ) {
    			if (! isset ( $vcard ['company'] [$l_key] [$key] )) {
    				continue;
    			}
    			foreach ( $vcard ['company'] [$l_key] [$key] as $item ) {
    				$this->vcard_map [$key] [] = $item;
    				if (isset ( $item ['value'] ) && ! empty ( $item ['value'] )) {
    					$this->vcard_values [] = $item ['value'];
    					$this->vcard_map_value[$key][] = $item['value'];
    				}
    			}
    		}
    	}
    	sort($this->vcard_values);
    
    }  
}