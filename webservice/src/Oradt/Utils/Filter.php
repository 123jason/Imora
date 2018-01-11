<?php 

namespace Oradt\Utils;

/**
* 验证字符串非法字符
*/
class Filter
{	
	/*关键字的长度*/
	public $keylang;

	/*字符串的长度*/
	public $strlang;

	public $str = '';


	private static function getNext( $str ){
	    $ret = array(0=>0); 
	    for( $j =1; $j < strlen($str); $j++ )
	    {
	        $_s  = substr( $str, 0, $j+1 );
	        $_ln = strlen($_s);
	        $ret[$j] = 0;
	        for( $i = 1; $i< $_ln; $i++ )
	        {
	            $start = substr($_s, 0 ,$i);
	            $end = substr($_s, -$i);
	            if($start == $end)
	            {
	                $ret[$j] = $i;
	            }
	        }
	    }
    	return $ret;
	}

	/**
	* $str 条件内容
	* $sstr 关键字符
	*/
	public static function _strpos( $str, $key, $p = 0 )
	{

	    $rt = false;  //返回结果
	    $l1 = strlen($key);
	    $l2 = strlen($str);
	    if($l1 > $l2)
	        return $rt;
	    $i = $p;
	    $j = 0;
	    $next = self::getNext($key);
	    while( $i< $l2 && $j < $l1 )
	    {
	    	//echo $str[$i].'|'.$keyWord[$j]."<br>";
	         if( $j == 0 || $key[$j] == $str[$i] )
	         {
	            ++$i;
	            ++$j;
	         }else{     
	             $j = $next[$j-1];
	         }
	    }

	    if( $j == $l1 ){	       
	        return $i - $l1;
	    }else{
	        return $rt;
	    }
	}

	/*
	* 替换非法字符
	* $strpo 非法字符起始位置，int
	* $key 非法字符，string
	* $str 验证的内容，string
	*/
	public static function replace($strpo, $key, $str)
	{	

		$len  = strlen($key) > 5 ? 5 : strlen($key);
		$star = self::getStar($len);
		$data = str_replace($key, $star, $str);
		return $data;
	}

	/*替换为  '*' */
	private static function getStar($len)
    {
        $star = "";
        $len  = $len > 5 ? 5 : $len;
        for ($i = 0; $i < $len; $i++){
            $star .= "*";
        }
        return $star;
    }
}