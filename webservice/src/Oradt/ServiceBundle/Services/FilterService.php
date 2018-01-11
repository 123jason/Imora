<?php 

namespace Oradt\ServiceBundle\Services;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Oradt\StoreBundle\Entity\Illegalkeywords;
use Doctrine\ORM\EntityManager;
// use Oradt\ServiceBundle\Services\BaseService;
/**
* 验证字符串非法字符
*/
class FilterService extends BaseService{

    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
    }

	public  function getNext( $str ){
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

    public function _strpos( $str, $key, $p = 0 )
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

    public function getSpecialStr()
    {
        $sql = "SELECT key_name FROM `illegalkeywords`";
        $data = $this ->em ->getConnection()->executeQuery($sql)->fetchAll(); 
        foreach ($data as  $val) {
               $keyArr[] = $val['key_name'];     
        }
        return $keyArr;
    }
    //关键字替换
//    public function keywordReplace($str)
//    {   
//        $keyArr = $this ->getSpecialStr();
//        foreach($keyArr as $k => $v){
//            $info = $this ->_strpos($str, $v);          
//            if ($info !== false) {
//                $len  = strlen($v) > 5 ? 5 : strlen($v);
//                $star = $this ->getStar($len);
//                $str  = str_replace($v, $star, $str);
//            }
//        }
//        return $str;
//    }
    //关键字替换
    public function keywordReplace($str)
    {   
        $querysql = "SELECT key_name FROM `illegalkeywords`";
        $list = $this->getConnection()->executeQuery($querysql)->fetchAll();
        $badword = array();
        foreach($list as $v){
            $badword[$v["key_name"]] = $this->getStar(mb_strlen($v["key_name"],"utf-8"));
        }        
        //$badword1 = array_combine($badword,array_fill(0,count($badword),'*'));
        //var_dump($badword);
        $str = strtr($str, $badword);
        return $str;
    }

    /*把关键词替换为  '*' */
    public function getStar($len)
    {
        $star = "";
        //最长五个*
        $len  = $len > 5 ? 5 : $len;
        for ($i = 0; $i < $len; $i++){
            $star .= "*";
        }
        return $star;
    }
}