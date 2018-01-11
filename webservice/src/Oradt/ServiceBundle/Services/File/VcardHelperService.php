<?php
namespace Oradt\ServiceBundle\Services\File;
use Oradt\ServiceBundle\Services\File\BuildVcardService;
use Oradt\ServiceBundle\Services\File\FileImcService;
class VcardHelperService{
    /**
     * 解析名片数据
     *
     * @param string $vcard
     * @return false|array 解析错误返false
     */
    static protected $_mailIndex = 1;
    static protected $_companyIndex = 1;
    static protected $_addressIndex = 1;
    static protected $_mobileIndex = 1;
    static protected $_officephoneIndex = 1;
    static protected $_faxIndex = 1;
    static protected $_urlIndex = 1;
    static protected $_titleIndex = 1;
    static protected $_departmentIndex = 1;
    public function parseVcard($vcard)
    {
        $newCardInfo = array();
        try {
            $fileImcService = new FileImcService();
            $parse = $fileImcService->parse('Vcard');
            $cardinfo = $parse->fromText($vcard);
            foreach ($cardinfo['VCARD'][0] as $key=>$value) {
                switch ($key) {
                    case 'FN': // parse FN data
                        $newCardInfo['name'] = array('value'=>self::getVcardValue($value[0]));
                        break;
                    case 'NICKNAME': // parse NICKNAME data
                        $newCardInfo['nickname'] = array('value'=>self::getVcardValue($value[0]));
                        break;
                    case 'X-ENGLISHNAME': // parse FN data
                        $newCardInfo['englishname'] = array('value'=>self::getVcardValue($value[0]));
                        break;
                    case 'NAME': // parse NICKNAME data
                        $newCardInfo['allname'] = array('value'=>self::getVcardValue($value[0]));
                        break;
                    case 'N': // parse name data
                        $newCardInfo['fullname'] = array('value'=>self::getVcardValue($value[0]));
                        break;
                    case 'ADR': // parse address data
                        //多个地址
                        foreach ($value as $key => $_value) {
                            if(is_array($_value['value']) && !empty($_value['value'][5][0])){
                                $zipcode = $_value['value'][5][0];
                                $_value['value'][5][0]='';
                            }
                            unset($_value['value'][6]);
                            $_adrrTypes = isset($_value['param']['TYPE'])?$_value['param']['TYPE'] : array();
                            // 设置是第几个地址
                            if (isset($_adrrTypes[0]) && is_numeric($_adrrTypes[0])) {
                                $key = 'address' . $_adrrTypes[0];
                            } else {
                                $key = 'address' . self::$_addressIndex++;
                            }
                            $newCardInfo[$key] = array('value'=>self::getVcardValue($_value), 'editable'=>1);
                            $newCardInfo[$key]['value'] = $this->_rebuildAddr($newCardInfo[$key]['value']);
                            $newCardInfo[$key]['value'] = is_array($newCardInfo[$key]['value'])
                                ? join('', $newCardInfo[$key]['value']) : $newCardInfo[$key]['value'];
                            if (isset($zipcode)) {
                                $newCardInfo['zipcode'] = array('value'=>$zipcode, 'editable'=>1);
                            }
                        }
                        break;
                    case 'TITLE': // parse tital data
                        //多个title
                        foreach ($value as $key => $_value) {
                            $_titleTypes = isset($_value['param']['TYPE']) ? $_value['param']['TYPE'] : array();
                            // 设置是第几个title
                            if (isset($_titleTypes[0]) && is_numeric($_titleTypes[0])) {
                                $key = 'title' . $_titleTypes[0];
                            } else {
                                $key = 'title' . self::$_titleIndex++;
                            }
                            $title = self::getVcardValue ( $_value );
                            $titleInfo = array($key => array('value'=>$title));
                            $newCardInfo = array_merge($newCardInfo,$titleInfo);
                        }
                        
                        break;
                    case 'ORG': // parse company name and department name
                        /*多个公司时使用*/
                        foreach ($value as $_value) {
                            $_telTypes = isset($_value['param']['TYPE'])?$_value['param']['TYPE']:array();
                            // 设置是第几个公司
                            if (isset($_telTypes[0]) && is_numeric($_telTypes[0])) {
                                $key = 'company' . $_telTypes[0];
                            } else {
                                $key = 'company' . self::$_companyIndex++;
                            }
                            $company = isset($_value['value'][0]) ? $_value['value'][0] : '';
                            $department = isset($_value['value'][1]) ? $_value['value'][1] : '';
                            $department[0] = isset($department[0]) ? $department[0] : '';
                            $orgInfo = array($key => array('value'=>$company[0]."~".$department[0]));
                            $newCardInfo = array_merge($newCardInfo, $orgInfo);
                        }
                        break;
                    case 'TEL': // parse telephone/fax data
                        foreach ($value as $_value) {
                            $phoneInfo = self::loadInfoFromTEL ($_value);
                            $newCardInfo = array_merge($newCardInfo, $phoneInfo);
                        }
                        //                        return $newCardInfo;
                        //                        print_r($newCardInfo);
                        break;
                    case 'FAX': // parse telephone/fax data
                        foreach ($value as $_value) {
                            $faxInfo = self::loadInfoFromTEL ($_value);
                            $newCardInfo = array_merge($newCardInfo, $faxInfo);
                        }
                        //                        break;
                    case 'EMAIL': // parse email data
                        foreach ($value as $_value) {
                            $_telTypes = isset($_value['param']['TYPE'])?$_value['param']['TYPE']:array();
                            // 设置是第几个邮箱
                            if (isset($_telTypes[0]) && is_numeric($_telTypes[0])) {
                                $key = 'email' . $_telTypes[0];
                            } else {
                                $key = 'email' . self::$_mailIndex++;
                            }
                            $email = self::getVcardValue ( $_value );
                            $emailInfo = array($key => array('value'=>$email));
                            $newCardInfo = array_merge($newCardInfo, $emailInfo);
                        }
                        break;
                    case 'URL': // parse website data
                        foreach ($value as $_value) {
                            $_telTypes = isset($_value['param']['TYPE'])?$_value['param']['TYPE']:array();
                            // 设置是第一个网址
                            if (isset ( $_telTypes [0] ) && is_numeric($_telTypes[0])) {
                                $key = 'web' . $_telTypes[0];
                            } else {
                                $key = 'web' . self::$_urlIndex++;
                            }
                            $url = self::getVcardValue ( $_value );
                            $websiteInfo = array($key => array('value'=>$url));
                            $newCardInfo = array_merge($newCardInfo, $websiteInfo);
                        }
                        break;
                    case 'PROFILE':
                        break;
                    case 'VERSION':
                        $newCardInfo['version'] = array('value'=>$value[0]['value'][0][0]);
                        break;
                    case 'X-CARDBACK': //背面数据标示
                        $newCardInfo['x-cardback'] = array('value'=>1);
                        break;
                    case 'X-SELFDEFINED':
                        $newCardInfo['x-selfdefined'] = array('value'=>$value[0]['value'][0][0]);
                    default:
                        break;
                }
            }
        }catch (Exception $ex){
            echo $ex->getMessage();
            return false;
        }
        return $newCardInfo;
    }
    public function parseArray($cardInfo){
        $selfDefined = array();
        foreach ($cardInfo as $_key => $_value) {
            //$_value = $_value['value'];
            $_value = str_replace(PHP_EOL,' ',$_value['value']);
            //echo $_value;
            switch (strtolower($_key)) {
                case 'x-cardback':
                    $newCardInfo['X-CARDBACK'] = $_value;
                    break;
                case 'name':
                    $newCardInfo['FN'] = $_value;
                    break;
                case 'fullname':
                    if (! is_array($_value)) {
                        $_value = array($_value);
                    }
                    $newCardInfo['N'] = $_value;
                    break;
                case 'nickname':
                    $newCardInfo['NICKNAME'] = $_value;
                    break;
                case 'allname':
                    $newCardInfo['NAME'] = $_value;
                    break;
                 case 'englishname':
                    $newCardInfo['X-ENGLISHNAME'] = $_value;
                    break;
                case 'company1':
                case 'company2':
                case 'company3':
                case 'company4':
                case 'company5':
                    $this->buildCompany($newCardInfo, $_key, $_value);
                    //                        break;
                    /*单个公司时使用*/
                    //                        print_r($_value);die;
                    // $newCardInfo['ORG'] = isset ($newCardInfo['ORG'])
                    // ? $newCardInfo['ORG'] : array( array( 'value'=>array() ) );
                    // $newCardInfo['ORG'][0]['value'][0] = $_value;
                    break;
                case 'title1':
                case 'title2':
                case 'title3':
                case 'title4':
                case 'title5':
                    $this->buildVcardTitle($newCardInfo, $_key, $_value);
                    break;
                case 'mobilephone1':
                case 'mobilephone2':
                case 'mobilephone3':
                case 'mobilephone4':
                case 'mobilephone5':
                case 'mobilephone6':
                case 'mobilephone7':
                case 'mobilephone8':
                case 'officephone1':
                case 'officephone2':
                case 'officephone3':
                case 'officephone4':
                case 'officephone5':
                case 'officephone6':
                case 'officephone7':
                case 'officephone8':
                    $this->buildVcardTel($newCardInfo, $_key, $_value);
                    break;
                case 'address1':
                case 'address2':
                case 'address3':
                case 'address4':
                case 'address5':
                    $this->buildVcardAddress($newCardInfo, $_key, $_value);
                    break;
                    //                    case 'fax':
                case 'fax1':
                case 'fax2':
                case 'fax3':
                case 'fax4':
                case 'fax5':
                    $this->buildVcardTel($newCardInfo, $_key, $_value);
                    //                        $newCardInfo['FAX'] = $_value;
                    break;
                case 'mailer':
                    if (! is_array($_value)) {
                        $_value = array($_value);
                    }
                    $newCardInfo['MAILER'] = $_value;
                    break;
                case 'email1':
                case 'email2':
                case 'email3':
                case 'email4':
                case 'email5':
                    $this->buildVcardMail($newCardInfo, $_key, $_value);
                    break;
                case 'address':
                    if (! is_array($_value)) {
                        $_value = array($_value);
                    }
                    $newCardInfo['ADR'] = $_value;
                    break;
                case 'label':
                    if (! is_array($_value)) {
                        $_value = array($_value);
                    }

                    $newCardInfo['LABEL'] = $_value;
                    break;
                case 'web1':
                case 'web2':
                case 'web3':
                case 'web4':
                case 'web5':
                    //$newCardInfo['URL'] = $_value;
                    $this->buildVcardUrl($newCardInfo, $_key, $_value);
                    break;
                    //                  case 'selfdefined1':
                    //                  case 'selfdefined2':
                    //                  case 'selfdefined3':
                    //                  case 'selfdefined4':
                    //                  case 'selfdefined5':
                    //                      $_key = strtolower($_key);
                    //                      $selfDefined[] = array('value'=>$_value, 'key'=>$this->vcardKeysMap[$_key]);
                    //                      break;
                case 'x-carduuid':
                    $newCardInfo['X-CARDUUID'] = $_value;
                    break;     
                case 'industry':
                case 'qq':
                case 'wechat':
                case 'blog':
                case 'skype':
                case 'msn':
                case 'clientid':
                case 'carduuid':
                case 'vcardid':
                case 'cardtype':
                case 'class':
                case 'cardversion':
                case 'cardstamp':
                case 'layoutpath':
                case 'x-selfdefined':
                    $newCardInfo['X-SELFDEFINED'] = $_value;
                default:
                    break;
            }
            if ($selfDefined) {
                $newCardInfo['X-SELFDEFINED'] = json_encode($selfDefined);
            }
        }
        return $newCardInfo;
    }
    static public function getVcardValue($vcardInfo)
    {
        $value = '';
        // 如果不是数组， 或者不存在指定内容， 返回
        if (!is_array($vcardInfo) || !isset($vcardInfo['value'])) {
            return $value;
        }
        // 从数据信息中， 获取对应的值。
        foreach ($vcardInfo['value'] as $_value) {
            if (!is_array($_value)) {
                $value[] = strval($_value);
                continue;
            }
            $_tmpValue = '';
            foreach ($_value as $__value) {
                $_tmpValue .= strval($__value);
            }
            $value[] = $_tmpValue;
        }
        // 数组只有一个元素， 直接返回该元素。 不以数组形式返回
        if (count($value) == 1) {
            $value = $value[0];
        }
        return $value;
    }
    /**
     * 按照中文地址拼写形式来重新组装中文地址。
     * @param string|array $addr 地址信息
     * @return string|array
     */
    protected function _rebuildAddr ($addr)
    {
        if (is_array($addr)) {
            foreach ($addr as $_addrStr) {
                if(preg_match("/[\x{4e00}-\x{9fa5}]+/u", $_addrStr)) {
                    $addr = array_reverse($addr);
                    break;
                }
            }
        }
        return $addr;
    }
    /**
     * 从Vcard数据中的TEL信息，获取对应的电话号码
     * @param array $vcardTELValue Vcard解析数据中TEL信息
     * @return array
     */
    static public function loadInfoFromTEL ($vcardTELValue)
    {
        //        print_r($vcardTELValue);die;
        $_telTypes = isset($vcardTELValue['param']['TYPE'])?$vcardTELValue['param']['TYPE']:array();

        if (in_array('CELL', $_telTypes)) { // 手机信息
            if (isset ( $_telTypes [1] ) && substr ( $_telTypes [1], 0, 5 ) == 'PREF=' && strlen($_telTypes [1])==6) {
                $key = 'mobilephone' . substr ( $_telTypes [1], 5 );
            } else {
                $key = 'mobilephone' . self::$_mobileIndex ++;
            }
        } else if (in_array('FAX', $_telTypes)) { // 传真
            if (isset ( $_telTypes [1] ) && substr ( $_telTypes [1], 0, 5 ) == 'PREF=' && strlen($_telTypes [1])==6) {
                $key = 'fax' . substr ( $_telTypes [1], 5 );
            } else {
                $key = 'fax' . self::$_faxIndex++;
            }
        } else if (in_array('HOME', $_telTypes)) { // 家庭电话
            if (isset ( $_telTypes [1] ) && substr ( $_telTypes [1], 0, 5 ) == 'PREF=' && strlen($_telTypes [1])==6) {
                $key = 'mobilephone' . substr ( $_telTypes [1], 5 );
            } else {
                $key = 'mobilephone' . self::$_mobileIndex ++;
            }
        } else if (in_array('WORK', $_telTypes)) { // 工作电话
            if (isset ( $_telTypes [1] ) && substr ( $_telTypes [1], 0, 5 ) == 'PREF=' && strlen($_telTypes [1])==6) {
                $key = 'officephone' . substr ( $_telTypes [1], 5 );
            } else {
                $key = 'officephone' . self::$_officephoneIndex++;
            }
        } else { // 默认为mobile
            if (isset ( $_telTypes [1] ) && substr ( $_telTypes [1], 0, 5 ) == 'PREF=' && strlen($_telTypes [1])==6) {
                $key = 'mobilephone' . substr ( $_telTypes [1], 5 );
            } else {
                $key = 'mobilephone' . self::$_mobileIndex ++;
            }
        }
        $phoneNumber = self::getVcardValue ( $vcardTELValue );
        $phoneInfo = array($key => array('value'=>$phoneNumber));
        return $phoneInfo;
    }
    public function buildVcardTel ( & $newCardInfo, $keyName, $value)
    {
        $newCardInfo['TEL'] = isset ($newCardInfo['TEL'])
            ? $newCardInfo['TEL'] : array();
        $countTel = count ($newCardInfo['TEL']);
        $params = array();
        $_pref = 'PREF='. substr($keyName, -1);
        if (false!==strpos($keyName, 'mobile')) {
            $params['TYPE'] = array('CELL', $_pref);
        } else if (false!==strpos($keyName, 'office')) {
            $params['TYPE'] = array('WORK', $_pref);
        } else if (false!==strpos($keyName, 'fax')) {
            $params['TYPE'] = array('FAX', $_pref);
        }
        //$params['PREF'] = $_pref;
        $newCardInfo['TEL'][$countTel] = array(
            'value' => $value,
            'params' => $params
        );
    }
    public function buildVcardMail ( & $newCardInfo, $keyName, $value)
    {
        $newCardInfo['EMAIL'] = isset ($newCardInfo['EMAIL'])
            ? $newCardInfo['EMAIL'] : array();
        $count = count ($newCardInfo['EMAIL']);
        $_pref = substr($keyName, -1);
        $params = array('PREF' => $_pref);
        $newCardInfo['EMAIL'][$count] = array(
            'value' => $value,
            'params' => $params
        );
    }

    public function buildVcardAddress ( & $newCardInfo, $keyName, $value)
    {
        $newCardInfo['ADR'] = isset ($newCardInfo['ADR'])
            ? $newCardInfo['ADR'] : array();
        $count = count ($newCardInfo['ADR']);
        $_pref = substr($keyName, -1);
        $params = array('PREF' => $_pref);
        $newCardInfo['ADR'][$count] = array(
            'value' => is_array($value)?$value:array($value),
            'params' => $params
        );
    }

    public function buildCompany ( & $newCardInfo, $keyName, $value)
    {
        $value = explode('~',$value);
        //echo $value;
        $newCardInfo['ORG'] = isset ($newCardInfo['ORG'])
            ? $newCardInfo['ORG'] : array();
        $count = count ($newCardInfo['ORG']);
        $_pref = substr($keyName, -1);
        $params = array('PREF' => $_pref);
        $arr = array('value' =>is_array($value)?$value:array($value), 'params' => $params);
        $newCardInfo['ORG'][$count] = $arr;
    }
    public function buildVcardUrl ( & $newCardInfo, $keyName, $value)
    {
        $newCardInfo['URL'] = isset ($newCardInfo['URL'])
            ? $newCardInfo['URL'] : array();
        $count = count ($newCardInfo['URL']);
        $_pref = substr($keyName, -1);
        $params = array('PREF' => $_pref);
        $newCardInfo['URL'][$count] = array(
            'value' => $value,
            'params' => $params
        );
    }
    public function buildVcardTitle ( & $newCardInfo, $keyName, $value)
    {
        $newCardInfo['TITLE'] = isset ($newCardInfo['TITLE'])
            ? $newCardInfo['TITLE'] : array();
        $count = count ($newCardInfo['TITLE']);
        $_pref = substr($keyName, -1);
        $params = array('PREF' => $_pref);
        $newCardInfo['TITLE'][$count] = array(
            'value' => $value,
            'params' => $params
        );
    }
    /**
     * 组装Vcard数据
     * @param array $vcardDataInfo 名片信息
     * @param array $vcardBackInfo 名片背面信息
     */
    public function buildVcard($vcardDataInfo,$vcardBackInfo = array())
    {
        $vcardInfo = $this->buildOneVcard($vcardDataInfo);
        if(!empty($vcardBackInfo)){
            $vcardback = $this->buildOneVcard($vcardBackInfo);
            $vcardInfo = $vcardInfo."\r\n".$vcardback;
        }
        return $vcardInfo;
    }
    /**
     * 组装单个Vcard数据
     * @param array $vcardDataInfo 名片信息
     */
    protected function buildOneVcard($vcardDataInfo)
    {
        $cardInfo = array();
        foreach ($vcardDataInfo as $_key => $_value) {
            $cardInfo[$_key] = $_value;
        }// end foreach
        $vcardDataInfo = $this->parseArray($vcardDataInfo);
        // instantiate a builder object
        // (defaults to version 3.0)
        $vcard = new BuildVcardService('4.0');
        $_vcardProperties = $vcard->getVcardProperties();
        $defaultPropertyInfo = array('vers' => array('4.0'));
        foreach ($vcardDataInfo as $_vcardKey => $_datas) {
            if ($_vcardKey === 'X-CARDBACK') { //背面标示
                $vcard->set($_vcardKey, $_datas, 'new');
                continue;
            }
            if (!isset($_vcardProperties[$_vcardKey])) {
                $vcard->addVcardProperty($_vcardKey, $defaultPropertyInfo);
            }

            if ((isset($_datas[0]) && is_string($_datas[0])) || (isset($_datas[0]) && !isset($_datas[0]['value']))) {

                //修改ADR 乱码  不确定会不会带来新的问题
                $_datas = array(array('value' => $_datas));
            }
            if (is_array($_datas)) {
                foreach ($_datas as $_data) {
                    $_value = $_data['value'];
                    if ($_value === '') {
                        continue;
                    }
                    $_params = isset($_data['params']) ? $_data['params'] : array();
                    $vcard->set($_vcardKey, $_value, 'new');

                    foreach ($_params as $_paramKey => $_param) {
                        settype($_param, 'array');
                        foreach ($_param as $_tmpParam) {
                            $vcard->addParam($_paramKey, $_tmpParam);
                        }
                    }// end foreach
                }
            }// end foreach
        }
        return $vcard->fetch();
    }
}