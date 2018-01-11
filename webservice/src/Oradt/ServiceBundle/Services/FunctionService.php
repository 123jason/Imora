<?php

/**
 * @Description: 函数
 * @Author: zhiqiang.xie <xiezq@oradt.com>
 * @Date: 2014-08-14
 * @Version:1.0.0.0
 */

namespace Oradt\ServiceBundle\Services;

use Doctrine\ORM\EntityManager;

class FunctionService
{

    private $em;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * 检查用户是否在长度范围
     * @param type $C_cahr
     * @param type $I_len1
     * @param type $I_len2
     * @return boolean
     */
    public function checkLengthBetween($C_cahr, $I_len1, $I_len2 = 100)
    {
        $C_cahr = trim($C_cahr);
        $C_cahr_l = ( strlen($C_cahr) + mb_strlen($C_cahr, 'UTF8') ) / 2;
        if ($C_cahr_l < $I_len1)
            return false;
        if ($C_cahr_l > $I_len2)
            return false;
        return true;
    }

    /**
     * 检验用户名
     * @param type $C_user
     * @return boolean
     */
    public function checkUser($C_user)
    {
        if (!$this->CheckLengthBetween($C_user, 6, 30))
            return false; //宽度检验
        if (!preg_match("/^[\x{4e00}-\x{9fa5}0-9A-Za-z_]+$/u", $C_user))
            return false; //特殊字符检验
        return true;
    }

    /**
     * 检验密码
     * @param type $C_passwd
     * @return boolean
     */
    public function checkPassword($C_passwd)
    {
        if (!$this->CheckLengthBetween($C_passwd, 6, 20))
            return false; //宽度检测
        //if (!preg_match("/^[_a-zA-Z0-9]*$/", $C_passwd))
            //return false; //特殊字符检测
        return true;
    }

    /**
     * 检验手机号码
     * @param type $C_telephone
     * @return boolean
     */
    public function checkTelephone($C_telephone)
    {
        //if (!preg_match("/^0{0,1}(13[0-9]|14[0-9]|15[0-9]|17[0-9]|18[0-9])[0-9]{8}$/", $C_telephone))
        if (!preg_match("/^\+?(86)?\s?[0-9]*$/", $C_telephone))        
            return false;
        return true;
    }
    
    /**
     * 检测各国手机号
     * @param char  $mcode          区号
     * @param char  $C_telephone    手机号
     * @return boolean
     */
    public function checkCountryMobile($mcode,$C_telephone){
        switch ($mcode) {
            case '86':  //中国
                    if (!preg_match("/^0{0,1}(13[0-9]|14[0-9]|15[0-9]|17[0-9]|18[0-9])[0-9]{8}$/", $C_telephone))
                        return false;
                    return true;
                    break;
            case '852':  //香港
                    if (!preg_match("/^(1|5|6|9)[0-9]{7,8}$/", $C_telephone))  return false;
                    return true;
                    break;
            case '853':  //澳门
                    if (!preg_match("/^6[0-9]{7}$/", $C_telephone))  return false;
                    return true;
                    break;
            default:
                    if (!preg_match("/^0{0,1}(13[0-9]|14[0-9]|15[0-9]|17[0-9]|18[0-9])[0-9]{8}$/", $C_telephone))
                        return false;
                    return true;
                    break;
        }
    }

    /**
     * 检测部分国家手机号
     * @param string $mcode 区号
     * @param string $phone 手机号码
     * @return int 0|1
     */
    public function checkPhonePreg($mcode,$phone)
    {
        switch ($mcode) {
            case '86':
                $preg = "/^(13|14|15|17|18)[0-9]{9}$/";
                break;
            case '852': //香港、8、6
            case '853': //澳门、8、6
                $preg = "/^6[0-9]{7}$/i";
                break;
            case '886'://台湾、9、9
                $preg = "/^9[0-9]{8}$/i";
                break;
            case '61': //澳大利亚、9、4
                $preg = "/^4[0-9]{8}$/i";
                break;
            case '55': //巴西、10/789
                $preg = "/^[789][0-9]{9}$/i";
                break;
            case '49': //德国、11、1
                $preg = "/^1[0-9]{10}$/i";
                break;
            case '7': //俄罗斯、 10 、 13489
                $preg = "/^[13489][0-9]{9}$/i";
                break;
            case '33'://法国、 10、 1678
                $preg = "/^[1678][0-9]{9}$/i";
                break;
            case '82'://韩国、 10 、17
                $preg = "/^[17][0-9]{9}$/i";
                break;
            case '1': //美国加拿大、1 、10
                $preg = "/^[2-9][0-9]{2}[2-9][0-9]{2}[0-9]{4}$/i";
                break;
            case '60'://马来西亚、 9、 1
                $preg = "/^1[0-9]{8}$/i";
                break;
            case '81': //日本、 10 、89         
            case '66': //泰国、 10、 89
                $preg = "/^[89][0-9]{9}$/i";
                break;
            case '65': //新加坡、 8 、89
                $preg = "/^[89][0-9]{7}$/i";
                break;
            case '91': //印度、10 、 9
                $preg = "/^9[0-9]{9}$/i";
                break;
            case '44': //英国、 10 、7
                $preg = "/^[7][0-9]{9}$/i";
                break;
            default:
                $preg = "/^(13|14|15|17|18)[0-9]{9}$/";
                break;
        }
        $res = preg_match($preg, $phone);
        return $res;
    }
        /**
     * 精准检测email格式
     */
    public function validateEmail($email)
    {
        //2015-04-01
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            return false;
        }
        return true;
        $isValid = true;
        $atIndex = strrpos($email, "@");
        if (is_bool($atIndex) && !$atIndex) {
            // echo 'false';
            $isValid = false;
        } else {
            $domain = substr($email, $atIndex + 1);
            $local = substr($email, 0, $atIndex);
            $localLen = strlen($local);
            $domainLen = strlen($domain);
            if ($localLen < 1 || $localLen > 64) {
                //   echo 'local part length exceeded';
                $isValid = false;
            } else if ($domainLen < 1 || $domainLen > 255) {
                //   echo ' domain part length exceeded';
                $isValid = false;
            } else if ($local[0] == '.' || $local[$localLen - 1] == '.') {
                //   echo ' local part starts or ends with ';
                $isValid = false;
            } else if (preg_match('/\\.\\./', $local)) {
                // echo ' local part has two consecutive dots';
                $isValid = false;
            } else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)) {
                // echo ' character not valid in domain part';
                $isValid = false;
            } else if (preg_match('/\\.\\./', $domain)) {
                //   echo ' domain part has two consecutive dots';
                $isValid = false;
            } else if (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\", "", $local))) {
                //  echo ' character not valid in local part unless';
                // local part is quoted
                if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\", "", $local))) {
                    $isValid = false;
                }
            }
            // echo $isValid;
            if ($isValid && !(checkdnsrr($domain, "MX") || checkdnsrr($domain, "A"))) {
                //  echo ' domain not found in DNS';
                $isValid = false;
            }
        }
        return $isValid;
    }

    /**
     * 验证邮箱
     * @param type $C_mailaddr
     * @return boolean
     */
    public function checkEmailAddr($C_mailaddr)
    {
        if (!preg_match("/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*$/i", $C_mailaddr))
            return false;
        return true;
    }

    /**
     * 获取用户的IP
     * @return string
     */
    public function getip()
    {
        if (@$_SERVER["HTTP_X_FORWARDED_FOR"])
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        else if (@$_SERVER["HTTP_CLIENT_IP"])
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        else if (@$_SERVER["REMOTE_ADDR"])
            $ip = $_SERVER["REMOTE_ADDR"];
        else if (@getenv("HTTP_X_FORWARDED_FOR"))
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        else if (@getenv("HTTP_CLIENT_IP"))
            $ip = getenv("HTTP_CLIENT_IP");
        else if (@getenv("REMOTE_ADDR"))
            $ip = getenv("REMOTE_ADDR");
        else
            $ip = "Unknown";

        return $ip;
    }

    /**
     * 检验来源
     * @return boolean
     */
    public function stop_outside_post()
    {
        $ServerName = @$_SERVER['SERVER_NAME'];
        $Sub_from = @$_SERVER["HTTP_REFERER"];
        $Sub_len = strlen($ServerName);
        $Checkfrom = substr($Sub_from, 7, $Sub_len);
        if ($Checkfrom != $ServerName) {
            return false; //警告！你正在从外部提交数据或直接访问文件！请立即终止！！
        }
        return true;
    }
    
    
    function validateDate( $date, $format='YYYY-MM-DD')
    {
        switch( $format )
        {
            case 'YYYY/MM/DD':
            case 'YYYY-MM-DD':
                $date = str_replace('/', '-', $date);
                //echo substr_count($date,'-');
                if(substr_count($date,'-')!==2)
                {
                    return false;
                }
                list( $y, $m, $d ) = explode( '-', $date );
                break;           
            default:
                throw new Exception( "Invalid Date Format" );
        }
        return checkdate( $m, $d, $y );
    }
    
    /**
     * 验证时间，只支持 2014-04-01 /  2014-04-01 10:10:10
     *
     * @param string $str
     * @return boolean
     */
    public function isDateTime($date){
        $format = 'Y-m-d';
        if(strlen($date) > 10)
            $format = 'Y-m-d H:i:s';
        $unixTime=strtotime($date);
        $checkDate= date($format,$unixTime);
        if($checkDate==$date){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 截取字符串
     * @param $string 字符串
     * @param $length 截取长度
     * @param $dot  结尾...或者‘’
     */
    public function cutstr_dis($string, $length, $dot = '') {
        //如果含有表情 全部转换成空
        /*$pattern = '/\[f\d{3}\]/';
        $string = preg_replace($pattern, '', $string);*/
        if (strlen ( $string ) <= $length) {
            return $string;
        }

        $pre = chr ( 1 );
        $end = chr ( 1 );
        $string = str_replace ( array (
                '&amp;',
                '&quot;',
                '&lt;',
                '&gt;'
        ), array (
                $pre . '&' . $end,
                $pre . '"' . $end,
                $pre . '<' . $end,
                $pre . '>' . $end
        ), $string );

        $strcut = '';
        if (strtolower ( 'utf-8' ) == 'utf-8') {

            $n = $tn = $noc = 0;
            while ( $n < strlen ( $string ) ) {

                $t = ord ( $string [$n] );
                if ($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
                    $tn = 1;
                    $n ++;
                    $noc ++;
                } elseif (194 <= $t && $t <= 223) {
                    $tn = 2;
                    $n += 2;
                    $noc += 2;
                } elseif (224 <= $t && $t <= 239) {
                    $tn = 3;
                    $n += 3;
                    $noc += 2;
                } elseif (240 <= $t && $t <= 247) {
                    $tn = 4;
                    $n += 4;
                    $noc += 2;
                } elseif (248 <= $t && $t <= 251) {
                    $tn = 5;
                    $n += 5;
                    $noc += 2;
                } elseif ($t == 252 || $t == 253) {
                    $tn = 6;
                    $n += 6;
                    $noc += 2;
                } else {
                    $n ++;
                }

                if ($noc >= $length) {
                    break;
                }
            }
            if ($noc > $length) {
                $n -= $tn;
            }

            $strcut = substr ( $string, 0, $n );
        } else {
            for($i = 0; $i < $length; $i ++) {
                $strcut .= ord ( $string [$i] ) > 127 ? $string [$i] . $string [++ $i] : $string [$i];
            }
        }

        $strcut = str_replace ( array (
                $pre . '&' . $end,
                $pre . '"' . $end,
                $pre . '<' . $end,
                $pre . '>' . $end
        ), array (
                '&amp;',
                '&quot;',
                '&lt;',
                '&gt;'
        ), $strcut );

        $pos = strrpos ( $strcut, chr ( 1 ) );
        if ($pos !== false) {
            $strcut = substr ( $strcut, 0, $pos );
        }
        return $strcut . $dot;
    }
}

