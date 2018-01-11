<?php

namespace Oradt\Utils;

class RandomString
{
    
    public static function encodingToUtf8($str) {
        return mb_convert_encoding($str,'UTF-8', 'UTF-8,GBK,GB2312,BIG5,EUC-CN');
    }

    /**
     * @param int $len
     * @return string
     * @throws \Exception
     */
    static public function make($len = 40, $type = '')
    {
        if (!empty($type))
            $len -= strlen($type);

        $bytes = openssl_random_pseudo_bytes($len * 2, $strong);

        if ($bytes === false || $strong === false) {
            throw new \Exception('Error Generating String');
        }

        return $type . substr(str_replace(array('/', '+', '='), '', base64_encode($bytes)), 0, $len);
    }

    /**
     * 生成密码
     * @param type $pwd
     * @return type
     */
    static public function encodePassword($pwd = '')
    {
        $salt1 = $salt2 = 'oradt';
        $pwd = md5(hash('sha256', $pwd . $salt1) . $salt2);
        return $pwd;
    }

    /**
     * 获得随机数字验证码
     * @param type $len
     * @return type
     */
    static public function randomNum($len = 4)
    {
        return substr(str_shuffle('1234567890'), 0, $len);
    }

}

