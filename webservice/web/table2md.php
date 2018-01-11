<?php
/**
 * Created by PhpStorm.
 * User: qiuzhigang
 * Date: 2017/9/27
 * Time: 16:03
 */
header("Content-type: text/html; charset=utf-8");
ini_set('memory_limit', '512M');
$string = $_POST['content'];

$str = "";
$arr = explode("\n",$string);
foreach ($arr as $k=>$v){
    $v = str_replace(array("\r\n", "\r", "\n"),"",$v);
    $a = explode("\t",$v);
    $str .= handle($a,$k);
}

function handle(array $arr, $i){
    $len = count($arr);
    if(empty($arr)){
        return;
    }
    $str = "";

    if($len==1){
        if($arr[0]=="备注："){
            $str .="**".$arr[0]."**\n";
        }else{
            $str .="- ".$arr[0]."\n";
        }
    }

    if($i==0){
        foreach ($arr as $k=> $v){
            if($k==0){
                $str .="|".$v."|";
            }else{
                $str .=$v."|";
            }
        }
        $str .="\n";
        for ($ii=0;$ii<$len;$ii++){
            if($ii==0){
                $str .="|:--|";
            }else{
                $str .=":--|";
            }
        }
    }elseif($len>1){
        foreach ($arr as $k=> $v){
            if($k==0){
                $str .="|".$v."|";
            }else{
                $str .=strip_tags($v)."|";
            }
        }
    }
    $str .="\n";
    return $str;
}
echo "<pre>";
echo $str;
echo "</pre>";