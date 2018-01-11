<?php
namespace Oradt\ServiceBundle\Services\File;
use Oradt\ServiceBundle\Services\File\BuildVcardService;
use Oradt\ServiceBundle\Services\File\FileImcService;
class VcardDataService
{
    /*
     * 转换数组key成Vcard格式
     * @const int
     */
    CONST CONVERT_KEY_INTO_VCARD = 1;
    /*
     * 转换数组key成常规格式
     * @const int
     */
    CONST CONVERT_KEY_INTO_ARRAY = 2;

    /*
     * 名片信息数组中， vcard数据格式和常规数据格式的键值映射表
     * @var array
     */
    protected $vcardKeysMap = array (
        'name'          => 'FN',
        'nickname'		=> 'NICKNAME',
        'allname'		=> 'NAME',
        'englishname'   => 'X-ENGLISHNAME',
        'company'       => 'ORG',
        'title'         => 'TITLE',
        'mobilephone'   => 'TEL',
        'mobilephone1'  => 'TEL',
        'mobilephone2'  => 'TEL',
        'mobilephone3'  => 'TEL',
        'officephone'   => 'TEL',
        'officephone1'  => 'TEL',
        'officephone2'  => 'TEL',
        'officephone3'  => 'TEL',
        'officephone4'  => 'TEL',
        'mailer'		=> 'MAILER',
        'email1'        => 'EMAIL',
        'email2'        => 'EMAIL',
        'email3'        => 'EMAIL',
        'email4'        => 'EMAIL',
        'email5'        => 'EMAIL',
        'fax1'          => 'TEL',
        'fax2'          => 'TEL',
        'fax3'          => 'TEL',
        'fax4'          => 'TEL',
        'fax5'          => 'TEL',
        'fax6'          => 'TEL',
        'address'       => 'ADR',
        'address1'       => 'ADR',
        'address2'       => 'ADR',
        'address3'       => 'ADR',
        'label' 		=> 'LABEL',
        'department'    => 'X-DEPARTMENT',
        'industry'      => 'X-INDUSTRY',
        'web'          => 'URL',
        'web1'          => 'URL',
        'web2'          => 'URL',
        'web3'          => 'URL',
        'qq'            => 'X-QQ',
        'wechat'        => 'X-WECHAT',
        'blog'          => 'X-BLOG',
        'skype'         => 'X-SKYPE',
        'msn'           => 'X-MSN',
        'profile'           => 'PROFILE',
        'clientid'      => 'clientIdKey',
        'carduuid'      => 'cardUuidKey',
        'vcardid'       => 'vcardIdKey',
        'cardtype'      => 'cardTypeKey',
        'class'			=> 'CLASS',
        'cardversion'   => 'X-CARDVERSION',
        'cardstamp'     => 'X-CARDSTAMP',
        'layoutpath'    => 'layoutPathKey',
        'version'       => 'VERSION',
    );

    /*
     * 名片信息数组中， 模板布局数据格式和常规数据格式的键值映射表
    * @var array
    */
    protected $tempKeysMap = array (
        'name'          => 'Name',
        'nickname'		=> 'NickName',
        'allname'		=> 'AllName',
        'englishname'   => 'EnglishName',
        'company'       => 'Company',
        'title'         => 'Title',
        'mobilephone1'  => 'MobilePhone1',
        'mobilephone2'  => 'MobilePhone2',
        'mobilephone3'  => 'MobilePhone3',
        'officephone1'  => 'OfficePhone1',
        'officephone2'  => 'OfficePhone2',
        'officephone3'  => 'OfficePhone3',
        'officephone4'  => 'OfficePhone4',
        'mailer'        => 'Mailer',
        'email1'        => 'Email1',
        'email2'        => 'Email2',
        'email3'        => 'Email3',
        'email4'        => 'Email4',
        'email5'        => 'Email5',
        'fax1'          => 'Fax1',
        'fax2'          => 'Fax2',
        'fax3'          => 'Fax3',
        'fax4'          => 'Fax4',
        'fax5'          => 'Fax5',
        'fax6'          => 'Fax6',
        'address'       => 'Address',
        'address1'       => 'Address1',
        'address2'       => 'Address2',
        'address3'       => 'Address3',
        'label'     	=> 'Label',
        'department'    => 'Department',
        'industry'      => 'Industry',
        'web'          => 'Web',
        'web1'          => 'Web1',
        'web2'          => 'Web2',
        'web3'          => 'Web3',
        'qq'            => 'QQ',
        'wechat'        => 'WeChat',
        'blog'          => 'Blog',
        'skype'         => 'SKYPE',
        'msn'           => 'Msn',
        'profile'           => 'PROFILE',
        'cardversion'   => 'CardVersion',
        'cardstamp'     => 'CardStamp',
    );

    protected $uneditableKeys = array ('clientid',
        'carduuid',
        'vcardid',
        'cardtype',
        'class',
        'cardversion',
        'layoutpath',
        'cardstamp',
        'version',
        'fullname',
        'profile',
        'uid',
        'rev',
        'userid',
        'x-carduuid',
        'x-clientid',
        'x-ms-ol-default-postal-address',
        'prodid',
        'sort-string',
        'x-phonetic-last-name',
        'x-phonetic-first-name',
        'x-cardback'
    );
    protected $getOffice = array(
        'officephone',
        'officephone1',
        'officephone2',
        'officephone3',
        'officephone4',
        'officephone5'
        );
    protected $getMobile = array(
        'mobilephone',
        'mobilephone1',
        'mobilephone2',
        'mobilephone3',
        'mobilephone4',
        'mobilephone5',
        );
    protected $getFax = array(
        'fax1',
        'fax2',
        'fax3',
        'fax4',
        'fax5',
        'fax6',
        );
    protected $getTelType = array(
        'CELL',
        'WORK',
        'HOME',
        );
    protected $_selfDefinedLabelMaps = array();

    static protected $_mailIndex = 1;
    static protected $_companyIndex = 1;
    static protected $_addressIndex = 1;
    static protected $_mobileIndex = 1;
    static protected $_officephoneIndex = 1;
    static protected $_faxIndex = 1;
    static protected $_urlIndex = 1;

    /**
     * 构造函数
     * @param unknown $config
     */
    public function __construct($config=array())
    {

    }



    /**
     * 从解析完的vcard数据信息中， 获取单独key对应的值
     * @param array $vcardInfo Vcard解析后的数据对应的单一key的value
     * @return string|array
     */
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
     * 获取格式化后的名字
     * @param array $vcardFNValue Vcard数据中FN对应的value
     * @return string
     */
    static public function getStringFromFN($vcardFNValue)
    {
        return self::getVcardValue($vcardFNValue);
    }

    /**
     * 获取格式化后的UID
     * @param array $vcardFNValue Vcard数据中FN对应的value
     * @return string
     */
    static public function getStringFromUID($vcardFNValue)
    {
        return self::getVcardValue($vcardFNValue);
    }



    /**
     * 获取姓名信息
     * @param array $vcardNValue Vcard数据中 N 对应的value
     * @return string|array
     */
    static public function getStringFromN ($vcardNValue)
    {
        return self::getVcardValue($vcardNValue);
    }

    /**
     * 从Vcard数据中的TEL信息，获取对应的电话号码
     * @param array $vcardTELValue Vcard解析数据中TEL信息
     * @return array
     */
    static public function loadInfoFromTEL ($vcardTELValue)
    {
//        print_r($vcardTELValue);die;
        $_telTypes = array();
        if (isset($vcardTELValue['param']['TYPE'])) {
            $_telTypes = $vcardTELValue['param']['TYPE'];
        }        

        if (in_array('CELL', $_telTypes)) { // 手机信息
            if (isset ( $_telTypes [1] ) && substr ( $_telTypes [1], 0, 5 ) == 'PREF=') {
                $key = 'mobilephone' . substr ( $_telTypes [1], 5 );
            } else {
                $key = 'mobilephone' . self::$_mobileIndex ++;
            }
        } else if (in_array('FAX', $_telTypes)) { // 传真
            if (isset ( $_telTypes [1] ) && substr ( $_telTypes [1], 0, 5 ) == 'PREF=') {
                $key = 'fax' . substr ( $_telTypes [1], 5 );
            } else {
                $key = 'fax' . self::$_faxIndex++;
            }
        } else if (in_array('HOME', $_telTypes)) { // 家庭电话
            if (isset ( $_telTypes [1] ) && substr ( $_telTypes [1], 0, 5 ) == 'PREF=') {
                $key = 'mobilephone' . substr ( $_telTypes [1], 5 );
            } else {
                $key = 'mobilephone' . self::$_mobileIndex ++;
            }
        } else if (in_array('WORK', $_telTypes)) { // 工作电话
            if (isset ( $_telTypes [1] ) && substr ( $_telTypes [1], 0, 5 ) == 'PREF=') {
                $key = 'officephone' . substr ( $_telTypes [1], 5 );
            } else {
                $key = 'officephone' . self::$_officephoneIndex++;
            }
        } else { // 默认为mobile
            if (isset ( $_telTypes [1] ) && substr ( $_telTypes [1], 0, 5 ) == 'PREF=') {
                $key = 'mobilephone' . substr ( $_telTypes [1], 5 );
            } else {
                $key = 'mobilephone' . self::$_mobileIndex ++;
            }
        }

        $phoneNumber = self::getVcardValue ( $vcardTELValue );
        $phoneInfo = array($key => array('value'=>$phoneNumber, 'editable'=>1));

        return $phoneInfo;
    }

    /**
     * 从Vcard数据的EMAIL信息获取邮件数据
     * @param array $vcardEmailValue Vcard数据中email信息
     * @return array
     */
    static public function loadInfoFromEMAIL ($vcardEmailValue)
    {
        if(isset($vcardEmailValue['param']['TYPE']) && !empty($vcardEmailValue['param']['TYPE'])){
            $_telTypes = $vcardEmailValue['param']['TYPE'];
            // 设置是第几个邮箱
            if (isset($_telTypes[0]) && is_numeric($_telTypes[0])) {
                $key = 'email' . $_telTypes[0];
            } else {
                $key = 'email' . self::$_mailIndex++;
            }
            $email = self::getVcardValue ( $vcardEmailValue );
            $emailInfo = array($key => array('value'=>$email, 'editable'=>1));
        }else{
            $email = self::getVcardValue ( $vcardEmailValue );
            $emailInfo = array('email1' => array('value'=>$email, 'editable'=>1));
        }

        return $emailInfo;
    }

    /**
     * 从Vcard数据的ORG信息获取公司和部门数据
     * @param array $vcardOrgValue Vcard数据中的ORG信息
     * @return array
     */
    static public function loadInfoFromORG ($vcardOrgValue)
    {
        $company = isset($vcardOrgValue['value'][0]) ? $vcardOrgValue['value'][0] : '';
        $department = isset($vcardOrgValue['value'][1]) ? $vcardOrgValue['value'][1] : '';
        if($department == ''){
            $orgInfo = array('company' => array('value'=>$company[0], 'editable'=>1),
                'department'  => array('value'=>'', 'editable'=>1)
            );
        }else{
            $orgInfo = array('company' => array('value'=>$company[0], 'editable'=>1),
                'department'  => array('value'=>$department[0], 'editable'=>1)
            );
        }

        return $orgInfo;
        /*以下是设置多个公司时使用*/
        $_telTypes = $vcardOrgValue['param']['TYPE'];

        // 设置是第几个公司
        if (isset($_telTypes[0]) && is_numeric($_telTypes[0])) {
            $key = 'company' . $_telTypes[0];
        } else {
            $key = 'company' . self::$_companyIndex++;
        }

        $company = isset($vcardOrgValue['value'][0]) ? $vcardOrgValue['value'][0] : '';
        $department = isset($vcardOrgValue['value'][1]) ? $vcardOrgValue['value'][1] : '';

        $orgInfo = array($key => array('value'=>$company[0], 'editable'=>1));
        // 部门不为空
        if ($department && ''!=$department[0]) {
            $orgInfo['department'] = array('value'=>$department[0], 'editable'=>1);
        }
        return $orgInfo;
    }


    /**
     * 从Vcard数据的URL信息，获取网址数据
     * @param array $vcardUrlValue Vcard数据中的URL信息
     * @return array
     */
    static public function loadInfoFromURL ($vcardUrlValue)
    {
        $url = isset($vcardUrlValue['value'][0]) ? $vcardUrlValue['value'][0] : '';
        $webInfo = array('web' => array('value'=>$url[0], 'editable'=>1));
        return $webInfo;
        /*以下是多个网址时使用*/
        $_telTypes = $vcardUrlValue['param']['TYPE'];

        // 设置是第一个网址
        if (isset ( $_telTypes [0] ) && is_numeric($_telTypes[0])) {
            $key = 'web' . $_telTypes[0];
        } else {
            $key = 'web' . self::$_urlIndex++;
        }


        $url = self::getVcardValue ( $vcardUrlValue );
        $websiteInfo = array($key => array('value'=>$url, 'editable'=>1));

        return $websiteInfo;
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
     * 将Vcard数据中的键值与WEB端识别的键值相互转换
     * @param array $cardInfo 原始的数组信息
     * @param int $conversionDirection 数组转换方向： 从Vcard到web，还是从web到Vcard
     * @return array
     */
    public function convertVcardKeys ($cardInfo, $conversionDirection)
    {
//        print_r($cardInfo);die;
//        array_pop($cardInfo);
        $newCardInfo = array();
        if (self::CONVERT_KEY_INTO_ARRAY === $conversionDirection) {
            foreach ($cardInfo as $key=>$value) {
                switch ($key) {
                    case 'FN': // parse FN data
                        $newCardInfo['name'] = array('value'=>self::getStringFromFN($value[0]), 'editable'=>1);
                        break;
                    case 'UID': // parse FN data
                        $newCardInfo['uid'] = array('value'=>self::getStringFromUID($value[0]), 'editable'=>1);
                        break;
                    case 'NICKNAME': // parse NICKNAME data
                        $newCardInfo['nickname'] = array('value'=>self::getVcardValue($value[0]), 'editable'=>1);
                        break;
                    case 'NAME': // parse NICKNAME data
                        $newCardInfo['allname'] = array('value'=>self::getVcardValue($value[0]), 'editable'=>1);
                        break;
                    case 'N': // parse name data
                        $newCardInfo['fullname'] = array('value'=>self::getStringFromN($value[0]), 'editable'=>0);
                        break;
                    case 'ADR': // parse address data
                        if (is_array($value[0]['value']) && !empty($value[0]['value'][5][0])) {
                            $zipcode = $value[0]['value'][5][0];
                            $value[0]['value'][5][0] = '';
                        }
                        $newCardInfo['address'] = array('value'=>self::getVcardValue($value[0]), 'editable'=>1);
                        $newCardInfo['address']['value'] = $this->_rebuildAddr($newCardInfo['address']['value']);
                        $newCardInfo['address']['value'] = is_array($newCardInfo['address']['value'])
                            ? join('', $newCardInfo['address']['value']) : $newCardInfo['address']['value'];
                        if (isset($zipcode)) {
                            $newCardInfo['zipcode'] = array('value'=>$zipcode, 'editable'=>1);
                        }
                        break;
                    case 'LABEL': // parse address data
                        $newCardInfo['label'] = array('value'=>self::getVcardValue($value[0]), 'editable'=>1);
                        $newCardInfo['label']['value'] = is_array($newCardInfo['label']['value'])
                            ? join('', $newCardInfo['label']['value']) : $newCardInfo['label']['value'];
                        break;

                    case 'TITLE': // parse tital data
                        $newCardInfo['title'] = array('value'=>self::getVcardValue($value[0]), 'editable'=>1);
                        break;
                    case 'ORG':

                        $orgInfo = self::loadInfoFromORG ($value[0]);

                        $newCardInfo = array_merge($newCardInfo, $orgInfo);
                        break;

                    case 'MAILER': // parse address data
                        $newCardInfo['mailer'] = array('value'=>self::getVcardValue($value[0]), 'editable'=>1);
                        $newCardInfo['mailer']['value'] = is_array($newCardInfo['mailer']['value'])
                            ? join('', $newCardInfo['mailer']['value']) : $newCardInfo['mailer']['value'];
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
                            $emailInfo = self::loadInfoFromEMAIL($_value);
                            $newCardInfo = array_merge($newCardInfo, $emailInfo);
                        }
                        break;
                    case 'URL':
                        $websiteInfo = self::loadInfoFromURL($value[0]);
                        $newCardInfo = array_merge($newCardInfo, $websiteInfo);
                        break;
                    case 'PROFILE':
                        break;
                    case 'X-CARDBACK': //背面数据标示
                        $newCardInfo['x-cardback'] = array('value'=>1, 'editable'=>0);
                        break;
                    default:
//                        echo $key;
                        $find = false;
                        foreach ($this->vcardKeysMap as $_k=>$_v) {
                            if(strtoupper($_v)==strtoupper($key)) {
                                $key = $_k;
                                $find = true;
                                break;
                            }
                        }
                        if (! $find) {
                            $key = strtolower($key);
                        }
                        $newCardInfo[$key] = array('value'=>self::getVcardValue($value[0]), 'editable'=>0);

                        if (isset($value[0]['label'])) {
                            $newCardInfo[$key]['label'] = $value[0]['label'];
                        }
                        if (! in_array($key, $this->uneditableKeys)) {
                            $newCardInfo[$key]['editable'] = 1;
                        }
                        break;
                }
            }

        } else if (self::CONVERT_KEY_INTO_VCARD === $conversionDirection) {
            //print_r($_REQUEST);die;
            $selfDefined = array();
            foreach ($cardInfo as $_key => $_value) {
                $_value = $_value['value'];
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
                    case 'uid':
                        $newCardInfo['UID'] = $_value;
                        break;
                    case 'englishname':
                        $newCardInfo['X-ENGLISHNAME'] = $_value;
                        break;
                    case 'nickname':
                        $newCardInfo['NICKNAME'] = $_value;
                        break;
                    case 'allname':
                        $newCardInfo['NAME'] = $_value;
                        break;
                    case 'company':
                        $newCardInfo['ORG'] = isset ($newCardInfo['ORG'])
                            ? $newCardInfo['ORG'] : array( array( 'value'=>array() ) );
                        $newCardInfo['ORG'][0]['value'][0] = $_value;
                        break;
                    case 'department':
                        $newCardInfo['ORG'] = isset ($newCardInfo['ORG'])
                            ? $newCardInfo['ORG'] : array( array( 'value'=>array() ) );
                        $newCardInfo['ORG'][0]['value'][1] = $_value;
                        break;
                    case 'title':
                        $newCardInfo['TITLE'] = $_value;
                        break;
                    case 'mobilephone1':
                    case 'mobilephone2':
                    case 'mobilephone3':
                    case 'officephone1':
                    case 'officephone2':
                    case 'officephone3':
                    case 'officephone4':
                        $this->buildVcardTel($newCardInfo, $_key, $_value);
                        break;
                    case 'fax1':
                    case 'fax2':
                    case 'fax3':
                    case 'fax4':
                    case 'fax5':
                    case 'fax6':
                        $this->buildVcardTel($newCardInfo, $_key, $_value);
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
                    case 'web':
                        $newCardInfo['URL'] = $_value;
                        break;
                    case 'industry':
                    case 'qq':
                        $newCardInfo['X-QQ'] = $_value;
                        break;
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
                    default:
                        continue;
                        $_tmpKey = strtolower($_key);
                        if (isset($this->vcardKeysMap[$_tmpKey])) {
                            $_newKey = $this->vcardKeysMap[$_tmpKey];
                            $newCardInfo[$_newKey] = $_value;
                        } else {
                            $_tmpUpperKey = strtoupper($_key);
                            $_selftmpArray = array($_tmpUpperKey=>trim($cardInfo[$_key]['label']));
                            $this->setSelfDefinedLabelMaps($_selftmpArray);
                            $_tmpArray = array('value'=>trim($_value),'key'=>$_tmpUpperKey);
                            if (isset($this->_selfDefinedLabelMaps[$_tmpUpperKey])) {
                                $_tmpArray['label'] = $this->_selfDefinedLabelMaps[$_tmpUpperKey];
                            }
                            $selfDefined[] = $_tmpArray;
                        }
                        break;
                }
                if ($selfDefined) {
                    $newCardInfo['X-SELFDEFINED'] = json_encode($selfDefined);
                }
            } // end foreach
        } else {
            $newCardInfo = $cardInfo;
        }
        return $newCardInfo;
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
        //echo $value;
        $newCardInfo['ORG'] = isset ($newCardInfo['ORG'])
            ? $newCardInfo['ORG'] : array();
        $count = count ($newCardInfo['ORG']);
        $_pref = substr($keyName, -1);
        $params = array('PREF' => $_pref);
        $arr = array('value' => $value, 'params' => $params);
        //print_r($arr);
        array_push($newCardInfo['ORG'],$arr);
        //$newCardInfo['ORG'][$count] = $arr;
//        print_r($newCardInfo);die;
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
        } // end foreach
        $vcardDataInfo = $this->convertVcardKeys($vcardDataInfo, self::CONVERT_KEY_INTO_VCARD);
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
    /**
     * 根据控制器传递过来的名片信息，组装成名片vcard数据和名片模板数据
     * @param array $cardInfo 名片信息内容
     * @return array 包含名片vcard数据和模板数据的数组
     */
    public  function buildCard ($cardInfo)
    {
        $vcardBackInfo = isset($cardInfo['backItem'])?$cardInfo['backItem']:array();
        $vcard = $this->buildVcard($cardInfo['textItem'],$vcardBackInfo); // 构建vcard数据
        $cardData = array('vcard'=>$vcard);
        return $cardData;
    }


    protected function _resetStatic ()
    {
        self::$_mailIndex = 1;
        self::$_companyIndex = 1;
        self::$_addressIndex = 1;
        self::$_mobileIndex = 1;
        self::$_officephoneIndex = 1;
        self::$_faxIndex = 1;
        self::$_urlIndex = 1;
    }

    /**
     *
     * @param array $labelsInfo
     * @return CardOperator
     */
    public function setSelfDefinedLabelMaps (array $labelsInfo)
    {
        settype($labelsInfo, 'array');
        $this->_selfDefinedLabelMaps = $labelsInfo;

        return $this;
    }


    public function parseVcardOneText($vcardData, $toConvertKey,$type = false){
        $result = array();
        // print_r($vcardData);die;
        // 终端合并了自定义字段，以json形式存储
        //$fileImcService = $this->container->get('file_imc_service');
        $fileImcService = new FileImcService();
        $parse = $fileImcService->parse('Vcard');
        $vcardData = $parse->fromText($vcardData);
        if (isset($vcardData['VCARD'])) {
        foreach ($vcardData['VCARD'] as $_k=>$_v) {
            if (! isset($_v['X-SELFDEFINED'], $_v['X-SELFDEFINED'][0]['value'])) {
                continue;
            }
            $_v['X-SELFDEFINED'][0]['value'][0][0] =
                str_replace(array("\r","\n"), '', $_v['X-SELFDEFINED'][0]['value'][0][0]);
            $tmpArray = json_decode($_v['X-SELFDEFINED'][0]['value'][0][0], true);
            unset($vcardData['VCARD'][$_k]['X-SELFDEFINED']); // 释放不用的键值
            if (!empty($tmpArray)) {
                foreach ($tmpArray as $_selfDefinedInfo) {
                    $_key = $_selfDefinedInfo['key'];
                    $_value = $_selfDefinedInfo['value'];
                    //  按照vcard解析后的格式， 进行赋值， 生成新的元素
                    if (!isset($_selfDefinedInfo['label'])) {
                        $_selfDefinedInfo['label'] = '';
                    }
                    $vcardData['VCARD'][$_k][$_key] = array (
                        array (
                            'group' => '',
                            'param' =>  array (),
                            'value' => array ( array($_value)),
                            'label' => $_selfDefinedInfo['label']
                        ),
                    );
                }    
            }
            
        }    
        }
        
        if ($type) {
            return $vcardData['VCARD'];
        }
        // 转换数组key名称
        if (true===$toConvertKey && is_array($vcardData) && isset($vcardData['VCARD'])) {
            // vcard 文件可能包含若干名片数据. 循环修改
            foreach ($vcardData['VCARD'] as $_cardInfo) {
                $result[] = $this->convertVcardKeys($_cardInfo, self::CONVERT_KEY_INTO_ARRAY);
            }
            $vcardData = $result;
        }

        return $vcardData;
    }

    /**
     * @param array()
     * @return array()
     * @access public 
     * An array of meet the requirements.
     * Data from the library.
     */
    public function combinationNewVcard($data)
    {
        $vcardData = $newData = $typeArr = $valueArr = array();
        foreach ($data as $key => $value) {
            /**
             * 组合成数组格式
             */
            if ($value['status']) {
                $valueArr[$value['name']][0] = array(
                    0=>$value['value'],
                    );                
                $type = rtrim($value['type'],',');
                if (!empty($type)) {
                    $types = explode(',', $type); 
                    $typeArr['TYPE'] = $types;
                }else{
                    $typeArr  = array();
                }
                $newData[$value['name']][] = array(
                    'group' =>'',
                    'param' =>$typeArr,
                    'value' =>$valueArr[$value['name']],
                    );
            }else{
                $valueArr[$value['name']][] = array(
                    0=>$value['value'],
                    );                
                $type = rtrim($value['type'],',');
                if (!empty($type)) {
                    $types = explode(',', $type); 
                    $typeArr['TYPE'] = $types;
                }else{
                    $typeArr  = array();
                }
                $newData[$value['name']][0] = array(
                    'group' =>'',
                    'param' =>$typeArr,
                    'value' =>$valueArr[$value['name']],
                    );
            }
        }
        $vcardData[0] = $newData;
        if (isset($vcardData) && !empty($vcardData)) {
            // vcard 文件可能包含若干名片数据. 循环修改
            foreach ($vcardData as $_cardInfo) {
                $result[] = $this->convertVcardKeys($_cardInfo, self::CONVERT_KEY_INTO_ARRAY);
            }
            $result;
        }
        return $result;
    }

    public function judgeVcardNameChange($oldinfo,$newinfo)
    {
        $oldinfo = $this->parseVcardText($oldinfo);
        $newinfo = $this->parseVcardText($newinfo);
        $res = $result = array();
        $vcardKeysMap = $this->vcardKeysMap;
        $vcardKeysMap['fullname'] = 'FN';
        if (isset($oldinfo[0]) && isset($newinfo[0])) {
            foreach ($vcardKeysMap as $key => $value) {
                switch (strtolower($key)) {
                    case 'fullname':
                    case 'name':
                    case 'officephone':
                    case 'officephone1':
                    case 'officephone2':
                    case 'officephone3':
                    case 'officephone4':
                    case 'mobilephone':
                    case 'mobilephone1':
                    case 'mobilephone2':
                    case 'mobilephone3':
                    case 'mobilephone4':
                    case 'mobilephone5':
                    case 'address':
                    case 'email1':
                    case 'email2':
                    case 'email3':
                    case 'email4':
                    case 'email5':
                    case 'fax1':
                    case 'fax2':
                    case 'fax3':
                    case 'fax4':
                    case 'fax5':
                    case 'fax6':
                        $result = $this->judgeVcardNameChangeOne($key,$oldinfo,$newinfo);
                        if (!empty($result)) {
                            $res[$key] = $result;
                        }
                        break;
                    default:
                        # code...
                        break;
                }
            }
        }
        // $lastRes = array();
        // $office  = $this->getOffice;
        // $mobile  = $this->getMobile;
        // $fax     = $this->getFax;
        // foreach ($res as $key => $value) {
        //     if (in_array($key, $office)) {
        //         $lastRes['officephone'][] = $value;
        //     }else if (in_array($key, $mobile)) {
        //         $lastRes['mobilephone'][] = $value;
        //     }else if (in_array($key, $fax)) {
        //         $lastRes['fax'][] = $value;
        //     }
        //     else{
        //         $lastRes[$key] = $value;
        //     }
            
        // }
        // $removeZero = array();
        // foreach ($lastRes as $key => $value) {
        //     if (in_array($key, array('officephone','mobilephone','fax'))) {
        //         if (1 == count($value)) {
        //             $removeZero[$key]['old'] = $value[0]['old'];
        //             $removeZero[$key]['new'] = $value[0]['new'];
        //         }else{
        //             $removeZero[$key] = $value;
        //         }
        //     }else{
        //         $removeZero[$key] = $value;
        //     }
        // }
        // $res = $removeZero;
        return $res;
    }

    public function judgeVcardNameChangeOne($key,$old,$new)
    {
        $res = $result = array();
        if (isset($old[0][$key]) && isset($new[0][$key])) {
            $oldName = $old[0][$key];
            $newName = $new[0][$key];
            if ('fullname' == $key) {
                $oldName = implode(';', $oldName['value']);
                $newName = implode(';', $newName['value']);
                if (trim($oldName) !== trim($newName)) {
                    $result['old'] = $oldName;
                    $result['new'] = $newName;
                } 
            }else{
                if (trim($oldName['value']) !== trim($newName['value'])) {
                    $result['old'] = $oldName['value'];
                    $result['new'] = $newName['value'];
                }    
            }            
        }
        if (isset($old[0][$key]) && !isset($new[0][$key])) {
            $result['old'] = $old[0][$key]['value'];
            $result['new'] = '';
        }
        if (!isset($old[0][$key]) && isset($new[0][$key])) {
            $result['old'] = '';
            $result['new'] = $new[0][$key]['value'];
        }
        return $result;
    }
    /**
     * @param array $oldVcard
     * @param array $newVcard
     * 
     * 
     */
    public function judgeVcardNameChange1($oldVcard,$newVcard)
    {
        $res = array();
        if (empty($newVcard)) {
            return $res;
        }
        $oldData = $this->parseVcardOneText($oldVcard,true,true);
        $newData = $this->parseVcardOneText($newVcard,true,true);
        $oldArr  = $oldData[0];
        $newArr  = $newData[0];
        // print_r($oldArr);
        // print_r($newArr);
        if (empty($newArr)) {
            return $res;
        }
        // $res     = $this->judgeVcardData($oldArr,$newArr);
        $res     = $this->judgeVcardDataOnly($oldArr,$newArr);
        return $res;
    }
    public function judgeVcardData($oldArr,$newArr)
    {
        $res = $result = array();
        foreach ($oldArr as $key => $value) {
            $newVal = !empty($newArr[$key])?$newArr[$key]:'';
        /**
         *  judge $value if Multidimensional array .
         *  then judage $value have [TYPE] and judge [value] Multidimensional array.
         *  ? one doubt need to judge the Multidimensional array ?
         *  Scope of application: structural similarity.
         */
            if (count($value) > 1 || (isset($newArr[$key]) && count($newArr[$key]) > 1)) {
                /**
                 * Multidimensional array have The number of the same
                 */
                if (count($value) == count($newVal)) {
                    foreach ($value as $k => $val) {
                        $j_val[0] = $val;
                        $j_newval[0] = $newVal[$k];
                        $result = $this->judgeVcardChangeType($j_val,$j_newval);
                        if (!empty($result)) {
                            $res[$key][$k]= $result;
                        }
                    }
                }else{
                    $count = count($value) > count($newVal)?count($value):count($newVal);
                    for ($i=0; $i <$count ; $i++) { 
                        if (isset($value[$i]) && isset($newVal[$i])) {
                            $j_val[0] = $value[$i];
                            $j_newval[0] = $newVal[$i];
                            $result = $this->judgeVcardChangeType($j_val,$j_newval);
                            if (!empty($result)) {
                                $res[$key][$i]['old'] = $value[$i];
                                $res[$key][$i]['new'] = $newVal[$i];
                            }
                        }
                        if (!isset($value[$i]) && isset($newVal[$i])) {
                            $res[$key][$i]['old'] = '';
                            $res[$key][$i]['new'] = $newVal[$i];
                        }
                        if (!isset($newVal[$i]) && isset($value[$i])) {
                            $res[$key][$i]['old'] = $value[$i];
                            $res[$key][$i]['new'] = '';
                        }
                    }
                }
            }else{
                /**
                 * if all contain [TYPE]
                 */
                $result = $this->judgeVcardChangeType($value,$newVal);
                if (!empty($result)) {
                    $res[$key] = $result;
                }
            }   
        }
        return $res;
    }
    /**
     * 只是对某几个字段进行分析
     * 手机 电话 名称 地址 邮箱
     */
    public function judgeVcardDataOnly($oldArr,$newArr)
    {
        $res = $result = array();
        $key = array('TEL','ORG','TITLE','ADR');
        foreach ($key as $k => $v) {
            switch ($v) {
                case 'N':
                    $result = $this->judgeVcardIssetN($oldArr,$newArr);
                    if (!empty($result)) {
                        $res['N'] = $result;
                    }
                    break;
                case 'FN':
                    $result = $this->judgeVcardIssetFN($oldArr,$newArr);
                    if (!empty($result)) {
                        $res['FN'] = $result;
                    }
                    break;
                case 'TEL':
                    $result = $this->judgeVcardIssetTEL($oldArr,$newArr);
                    if (!empty($result)) {
                        $res = $result;
                    }
                    break;
                case 'ADR':
                    $result = $this->judgeVcardIssetADR($oldArr,$newArr,$v);
                    if (!empty($result)) {
                        $res['ADR'] = $result;
                    }
                    break;
                case 'ORG':
                case 'TITLE':
                    $result = $this->judgeVcardIssetOrgTitle($oldArr,$newArr,$v);
                    if (!empty($result)) {
                        $res[$v] = $result;
                    }
                    break;
                default:
                    # code...
                    break;
            }
        }
        return $res;
    }
    // public function judgeVcardIssetN($oldArr,$newArr)
    // {
    //     $res = $result = array();
    //     if (isset($oldArr['N']) && isset($newArr['N']) ) {
    //         $oldName = $this->arrayRearrange($oldArr['N'][0]['value']);
    //         if (trim($oldName) !== trim($newName)) {
    //             $result['old'] = $oldName;
    //             $result['new'] = $newName;
    //         }
    //     }
    //     if (isset($oldArr['N']) && !isset($newArr['N'])) {
    //         $oldName = $this->arrayRearrange($oldArr['N'][0]['value']);
    //         $res[0]['old'] = $oldName;
    //         $res[0]['new'] = '';
    //     }
    //     if (!isset($oldArr['N']) && isset($newArr['N'])) {
    //         $newName = $this->arrayRearrange($newArr['N'][0]['value']);
    //         $res[0]['old'] = '';
    //         $res[0]['new'] = $newName;
    //     }
    //     return $res;
    // }
    // public function arrayRearrange($arr)
    // {
    //     $result = array();
    //     foreach ($arr as $key => $value) {
    //         $result[$key] = $value[0];
    //     }
    //     $res = implode(';', $result);
    //     return $res;
    // }
    // public function judgeVcardIssetFN($oldArr,$newArr)
    // {
    //     $res = $result = array();
    //     if (isset($oldArr['FN']) && isset($newArr['FN']) ) {
    //         $result = $this->judgeVcardChangeType($oldArr['FN'],$newArr['FN']);
    //         if (!empty($result)) {
    //             $res = $result;
    //         }
    //     }
    //     if (isset($oldArr['FN']) && !isset($newArr['FN'])) {
    //         $res[0]['old'] = $oldArr['FN'][0]['value'][0][0];
    //         $res[0]['new'] = '';
    //     }
    //     if (!isset($oldArr['FN']) && isset($newArr['FN'])) {
    //         $res[0]['old'] = '';
    //         $res[0]['new'] = $newArr['FN'][0]['value'][0][0];
    //     }
    //     return $res;
    // }
    public function judgeVcardIssetADR($oldArr,$newArr,$v = 'ADR')
    {
        $res = $result = array();
        if (isset($oldArr[$v]) && isset($newArr[$v]) ) {
            $result = $this->judgeVcardChangeType($oldArr[$v],$newArr[$v]);
            if (!empty($result)) {
                $res = $result;
            }
        }
        if (isset($oldArr[$v]) && !isset($newArr[$v])) {
            $res[0]['old'] = $oldArr[$v][0]['value'][0][0];
            $res[0]['new'] = '';
        }
        if (!isset($oldArr[$v]) && isset($newArr[$v])) {
            $res[0]['old'] = '';
            $res[0]['new'] = $newArr[$v][0]['value'][0][0];
        }
        return $res;
    }
    public function judgeVcardIssetOrgTitle($oldArr,$newArr,$v)
    {
//        print_r(1)
        $res = $result = $oldRes = $newRes = array();
        if (isset($oldArr[$v]) && isset($newArr[$v]) ) {
            $oldRes = $this->numberStatistics($oldArr[$v]);
            $newRes = $this->numberStatistics($newArr[$v]);
            $result = array_diff($oldRes, $newRes);
            $result1 = array_diff($newRes, $oldRes);
            $result  = empty($result)?array():$result;
            $result1 = empty($result1)?array():$result1;
            if (!empty($result) || !empty($result)) {
                $count = count($result) > count($result1)?count($result):count($result1);
                for ($i=0; $i < $count; $i++) { 
                    $resultVal = $result1Val = '';
                    $result = array_values($result);
                    $result1 = array_values($result1);
                    if (isset($result1[$i])) $result1Val = $result1[$i];
                    if (isset($result[$i])) $resultVal = $result[$i];
                    $res[$i]['old'] = $resultVal;
                    $res[$i]['new'] = $result1Val;
                }
            }            
        }
        if (isset($oldArr[$v]) && !isset($newArr[$v])) {
            $oldRes = $this->numberStatistics($oldArr[$v]);
            foreach ($oldRes as $key => $value) {
                $res[$key]['old'] = $value;
                $res[$key]['new'] = '';   
            }
            
        }
        if (!isset($oldArr[$v]) && isset($newArr[$v])) {
            $newRes = $this->numberStatistics($newArr[$v]);
            foreach ($newRes as $key => $value) {
                $res[$key]['old'] = '';
                $res[$key]['new'] = $value;
            }            
        }
        return $res;
    }
    public function numberStatistics($values)
    {
        $result = array();
        foreach ($values as $key => $value) {
            if (isset($value['value'][0][0])) {
                $result[$key] = $value['value'][0][0];
            }
        }
        return $result;
    }
    public function judgeVcardIssetTEL($oldArr,$newArr)
    {
        $res = $result = $odlResult = $newResult = array();
        if (isset($oldArr['TEL'])) {
            foreach ($oldArr['TEL'] as $key => $value) {
                if (isset($value['param']['TYPE'][0]) && !empty($value['param']['TYPE'][0])) {
                    $type = $value['param']['TYPE'][0];
                    $odlResult[$type][] = $value;
                }
            }
        }
        if (isset($newArr['TEL'])) {
            foreach ($newArr['TEL'] as $key => $value) {
                if (isset($value['param']['TYPE'][0]) && !empty($value['param']['TYPE'][0])) {
                    $type = $value['param']['TYPE'][0];
                    $newResult[$type][] =$value;
                }
            } 
        }
        $telType = $this->getTelType;
        foreach ($telType as $key => $value) {
            $result = $this->judgeVcardChangeTelType($value,$odlResult,$newResult);
            if (!empty($result)) {
                $res[$value] = $result;
            }               
        }
        return $res;
    }
    public function judgeVcardChangeType($value,$newVal)
    {
        $res = array();
        if (!empty($value[0]['param']['TYPE']) && !empty($newVal[0]['param']['TYPE'])) {
            $result = array_diff($newVal[0]['param']['TYPE'],$value[0]['param']['TYPE']);
            if (!empty($result)) {
                $res['old'] = $value[0]['value'];
                $res['new'] = $newVal[0]['value'];
            }else{
                /**
                 * judge [value] 
                 */
                $res = $this->judgeVcardChangeValue($value,$newVal);
            }
        }else{
            $res = $this->judgeVcardChangeValue($value,$newVal);
        }
        return $res;
    }
    public function judgeVcardChangeValue($value,$newVal)
    {
        $res = $value1 = $newVal1 = array();
        if (isset($newVal[0]['value']) && isset($value[0]['value'])) {
            $value1 = $value[0]['value'];
            $newVal1= $newVal[0]['value'];
        }
        /**
         * A one-dimensional array
         */
        $valCount = count($value1);
        $newCount = count($newVal1);
        if ($valCount == $newCount && 1 == $valCount) {
            $result = array_diff($newVal1[0], $value1[0]);
            if (!empty($result)) {
                $res[0]['old'] = $value1[0][0];
                $res[0]['new'] = $result[0];
            }
        }else{
            $count = $valCount > $newCount ? $valCount : $newCount;
            for ($i=0; $i <$count ; $i++) {
                if (isset($value1[$i]) && isset($newVal1[$i])) {
                    $result = array_diff($newVal1[$i], $value1[$i]);
                    if (!empty($result)) {
                        $res[$i]['old'] = $value1[$i][0];
                        $res[$i]['new'] = $newVal1[$i];
                    }
                }
                if (!empty($value1[$i]) && empty($newVal1[$i])) {
                    $res[$i]['old'] = $value1[$i][0];
                    $res[$i]['new'] = '';
                }
                if (empty($value1[$i]) && !empty($newVal1[$i])) {
                    $res[$i]['old'] = '';
//                    $res[$i]['new'] = $newVal1[$i]['value'][0][0];
                    $res[$i]['new'] = $newVal1[$i]['value'][0][0];
                }
            }
        }
        return $res;
    }
    /**
     * 判断TEl格式
     */
    public function judgeVcardChangeTelType($key,$oldArr,$newArr)
    {
        $res = $result = $result1 = array();
        if (isset($oldArr[$key]) && isset($newArr[$key]) ) {
            $value = $oldArr[$key];
            $newVal = $newArr[$key];
            foreach ($value as $k => $val) {
                if (isset($val['value'][0][0])) 
                    $result[$k] = $val['value'][0][0];
            }
            foreach ($newVal as $k => $val) {
                if (isset($val['value'][0][0])) 
                    $result1[$k] = $val['value'][0][0];
            }
            $result2 = array_diff($result, $result1);
            $result3 = array_diff($result1,$result);
            if (!empty($result2) || !empty($result3)) {
                $count = count($result2) > count($result3)?count($result2):count($result3);
                for ($i=0; $i < $count; $i++) { 
                    $result2Val = $result3Val = '';
                    $result2 = array_values($result2);
                    $result3 = array_values($result3);
                    if (isset($result3[$i])) $result3Val = $result3[$i];
                    if (isset($result2[$i])) $result2Val = $result2[$i];
                    $res[$i]['old'] = $result2Val;
                    $res[$i]['new'] = $result3Val;
                }
            }
        }
        if (isset($oldArr[$key]) && !isset($newArr[$key])) {
            foreach ($oldArr[$key] as $k => $val) {
                $res[$k]['old'] = $oldArr[$key][$k]['value'][0][0];
                $res[$k]['new'] = '';
            }
        }
        if (!isset($oldArr[$key]) && isset($newArr[$key])) {
            foreach ($newArr[$key] as $k => $val) {
                $res[$k]['old'] = '';
                $res[$k]['new'] = $newArr[$key][$k]['value'][0][0];
            }
        }
        return $res;
    }
    /**
     * 将名片接口返回数据处理为页面需要数据格式
     * @param string $vcard
     * @param string $temlpateZipFilePath 资源包文件路径
     * @param string $cardtype 展示名片类型
     * @return array
     */
    public function loadTemplateInfo($vcard = '', $temlpateZipFilePath = '', $cardtype = 'EDIT_CARD_SIZE')
    {
        $info = array(); //整个数据
        $leftdata = array(); //左侧名片中的内容
        $iteminfo = array(); //右侧个人资料字段内容数据
        /*名片解析数据  名片编辑器左侧数据*/
        $cardOperator = new CardOperator(array('cardStoredInPath' => $this->cardFolder));

        $vcard = $vcard ? $vcard : ($this->cardFolder . 'sampleVcard.vcf');
        $temlpateZipFilePath = is_file($temlpateZipFilePath) ? $temlpateZipFilePath : ($this->cardFolder . 'cardUuid.zip');
        $data_info = $cardOperator->parseCard($vcard, $temlpateZipFilePath, $cardtype);
//        print_r($data_info);die;
        if ($data_info['templateInfo']['TEMPORI'] == 1) { //判断是不是竖版
            $this->isvertical = 1;
            $cardtype = 'EDIT_VERTICAL_CARD_SIZE';
            $data_info = $cardOperator->parseCard($vcard, $temlpateZipFilePath, $cardtype);
        }
        // 解析名片
        $stylelength = count($data_info['textGroupStyle']);
        for ($i = 0; $i < $stylelength; $i++) {
            foreach ($data_info['textGroupStyle'][$i]['style'] as $key => $val) {
                $leftdata[$i]['style'] .= strtolower($key) . ':' . strtolower($val) . ';';
            }
            $t = 0;
            foreach ($data_info['textGroupStyle'][$i]['items'] as $key => $val) {
                $leftdata[$i]['items'][$t][] = $val;
                if ($data_info['textItem'][$val]['value'] == '') {
                    $data_info['textItem'][$val]['value'] = $this->translator->STR_CARD_DEFAULT_VALUE;
                }
                $leftdata[$i]['items'][$t][] = $data_info['textItem'][$val]['value'];
                $leftdata[$i]['items'][$t][] = $data_info['textItem'][$val]['label'];
                $leftdata[$i]['items'][$t][] = $data_info['textItem'][$val]['visible']; //是否可视
                $t++;
            }

        }

        /*名片编辑器右侧选项部分*/
        foreach ($data_info['textItem'] as $key => $val) {
            if (empty($data_info['textItem'][$key]['editable'])) {
                continue;
            }
            $label = $this->getLabel($key);
            if($label){
                $data_info['textItem'][$key]['label'] = $label;
            }else{
                if (!isset($data_info['textItem'][$key]['label'])) {//如果既没有翻译文件又没有label的情况 就默认翻译成自定义
                    $data_info['textItem'][$key]['label'] = $this->translator->STR_SELFDEFINED;
                }
            }
        }
        $data_info['leftdata'] = $leftdata; //名片左侧内容
        return $data_info;
    }

    /**
     * 解析vcard内容
     * @param string $vcardData Vcard数据内容
     * @param bool $toConvertKey 是否转换索引key
     * @return array
     */
    public function parseVcardText($vcardData, $toConvertKey=true)
    {
        if(strpos($vcardData, 'X-CARDBACK') !== false){ // 如果有反面数据
            $vcard = explode('END:VCARD',$vcardData);
            foreach ($vcard as $v){
                if(trim($v) == '') continue;
                if(strpos($v,'X-CARDBACK') !== false){
                    $back = $this->parseVcardOneText("{$v}END:VCARD", $toConvertKey);
                }else{
                    $vcardData = $this->parseVcardOneText("{$v}END:VCARD", $toConvertKey);
                }
            }
            $vcardData['back'] = $back[0];
        }else{
            $vcardData = $this->parseVcardOneText($vcardData, $toConvertKey);
            $vcardData['back'] = array();
        }
        return $vcardData;
    }



}


