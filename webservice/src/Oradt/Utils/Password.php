<?php

namespace Oradt\Utils;

class Password
{
    static public function encrypt($plaintext)
    {
        if(empty($plaintext)){
            return null;
        }
        return md5($plaintext);
    }

    /**
     * 密码安全等级验证
     * 
     * @param string $password
     * @param number $len 密码最小长底
     * @return number level 0-4  0不符合长度 1 只有一类字符 
     */
    static public function secureLevel($password,$len=6){
        $score = 0;
        if($password=='123456' || strlen($password) < $len)
            return 1;
        //"/[a-z]{3,}/"
        if(preg_match("/^[a-z]+$/",$password) || preg_match("/^[A-Z]+$/",$password) || preg_match("/^[0-9]+$/",$password))
        {
            return 1;
        }
        if(preg_match("/[0-9]+/",$password))
        {
            $score ++;
        }
        if(preg_match("/[a-z]+/",$password))
        {
            $score ++;
        }
        if(preg_match("/[A-Z]+/",$password))
        {
            $score ++;
        }
        if(preg_match("/[_|\-|+|=|*|!|@|#|$|%|^|&|(|)]+/",$password))
        {
            $score ++;
        }
        return $score;
    }
}
