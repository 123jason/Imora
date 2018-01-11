<?php
/**
 * 字符串转拼音
 * @author huangxm
 *
 */
namespace Oradt\Utils;
class Str2PY
{
    private $_pinyins = array(
            176161 => 'A',
            176197 => 'B',
            178193 => 'C',
            180238 => 'D',
            182234 => 'E',
            183162 => 'F',
            184193 => 'G',
            185254 => 'H',
            187247 => 'J',
            191166 => 'K',
            192172 => 'L',
            194232 => 'M',
            196195 => 'N',
            197182 => 'O',
            197190 => 'P',
            198218 => 'Q',
            200187 => 'R',
            200246 => 'S',
            203250 => 'T',
            205218 => 'W',
            206244 => 'X',
            209185 => 'Y',
            212209 => 'Z',
    );
    private $_charset = null;
    /**
     * 构造函数, 指定需要的编码 default: utf-8
     * 支持utf-8, gb2312
     *
     * @param unknown_type $charset
     */
    public function __construct( $charset = 'utf-8' )
    {
        $this->_charset    = $charset;
    }
    /**
     * 中文字符串 substr
     *
     * @param string $str
     * @param int    $start
     * @param int    $len
     * @return string
     */
    private function _msubstr ($str, $start, $len)
    {
        $start  = $start * 2;
        $len    = $len * 2;
        $strlen = strlen($str);
        $result = '';
        for ( $i = 0; $i < $strlen; $i++ ) {
            if ( $i >= $start && $i < ($start + $len) ) {
                if ( ord(substr($str, $i, 1)) > 129 ) $result .= substr($str, $i, 2);
                else $result .= substr($str, $i, 1);
            }
            if ( ord(substr($str, $i, 1)) > 129 ) $i++;
        }
        return $result;
    }
    /**
     * 字符串切分为数组 (汉字或者一个字符为单位)
     *
     * @param string $str
     * @return array
     */
    private function _cutWord( $str )
    {
        $words = array();
        while ( $str != "" )
        {
            if ( $this->_isAscii($str) ) {/*非中文*/
                $words[] = $str[0];
                $str = substr( $str, strlen($str[0]) );
            }else{
                $word = $this->_msubstr( $str, 0, 1 );
                $words[] = $word;
                $str = substr( $str, strlen($word) );
            }
        }
        return $words;
    }
    /**
     * 判断字符是否是ascii字符
     *
     * @param string $char
     * @return bool
     */
    private function _isAscii( $char )
    {
        return ( ord( substr($char,0,1) ) < 160 );
    }
    /**
     * 判断字符串前3个字符是否是ascii字符
     *
     * @param string $str
     * @return bool
     */
    private function _isAsciis( $str )
    {
        $len = strlen($str) >= 3 ? 3: 2;
        $chars = array();
        for( $i = 1; $i < $len -1; $i++ ){
            $chars[] = $this->_isAscii( $str[$i] ) ? 'yes':'no';
        }
        $result = array_count_values( $chars );
        if ( empty($result['no']) ){
            return true;
        }
        return false;
    }
    public function getPre( $str ) {
        try{
            $pre = strtoupper( $this->getPre_1($str) );
            if(!in_array($pre, array_values($this->_pinyins)))
            {
                return '#';
            }
            return $pre;
        }catch (\Exception $ex) {
            return '#';
        }
    }
    

    /**
     * 获取首字符
     *
     * @param string $str
     * @return string
     */
    public function getPre_1( $str )
    {
        if ( empty($str) ) return '';
        if ( $this->_isAscii($str[0]) && $this->_isAsciis( $str )){
            return substr($str , 0 ,1);
        }
        $result = array();
        if ( $this->_charset == 'utf-8' ){
            try{
                $str = @iconv( 'utf-8', 'gb2312//IGNORE', $str );
            }catch (\Exception $ex) {
                return '';
            }
        }
        $words = $this->_cutWord( $str );
        foreach ( $words as $word )
        {
            if ( $this->_isAscii($word) ) {/*非中文*/
                return strtoupper($word);
                 
            }
            $code = ord( substr($word,0,1) ) * 1000 + ord( substr($word,1,1) );
            /*获取拼音首字母A--Z*/
            if ( ($i = $this->_search($code)) != -1 ){
                return $this->_pinyins[$i];
            }
        }
        return substr(strtoupper(implode('',$result)) , 0 ,1);
    }


    /**
     * 获取中文字串的拼音首字符
     *
     * @param string $str
     * @return string
     */
    public function getInitials( $str )
    {
        if ( empty($str) ) return '';
        if ( $this->_isAscii($str[0]) && $this->_isAsciis( $str )){
            return $str;
        }
        $result = array();
        if ( $this->_charset == 'utf-8' ){
            $str = iconv( 'utf-8', 'gb2312', $str );
        }
        $words = $this->_cutWord( $str );
        foreach ( $words as $word )
        {
            if ( $this->_isAscii($word) ) {/*非中文*/
                $result[] = $word;
                continue;
            }
            $code = ord( substr($word,0,1) ) * 1000 + ord( substr($word,1,1) );
            /*获取拼音首字母A--Z*/
            if ( ($i = $this->_search($code)) != -1 ){
                $result[] = $this->_pinyins[$i];
            }
        }
        return strtoupper(implode('',$result));
    }
    private function _getChar( $ascii )
    {
        if ( $ascii >= 48 && $ascii <= 57){
            return chr($ascii);  /*数字*/
        }elseif ( $ascii>=65 && $ascii<=90 ){
            return chr($ascii);   /* A--Z*/
        }elseif ($ascii>=97 && $ascii<=122){
            return chr($ascii-32); /* a--z*/
        }else{
            return '-'; /*其他*/
        }
    }
    /**
     * 查找需要的汉字内码(gb2312) 对应的拼音字符( 二分法 )
     *
     * @param int $code
     * @return int
     */
    private function _search( $code )
    {
        $data = array_keys($this->_pinyins);
        $lower = 0;
        $upper = sizeof($data)-1;
        $middle = (int) round(($lower + $upper) / 2);
        if ( $code < $data[0] ) return -1;
        for (;;) {
            if ( $lower > $upper ){
                return $data[$lower-1];
            }
            $tmp = (int) round(($lower + $upper) / 2);
            if ( !isset($data[$tmp]) ){
                return $data[$middle];
            }else{
                $middle = $tmp;
            }
            if ( $data[$middle] < $code ){
                $lower = (int)$middle + 1;
            }else if ( $data[$middle] == $code ) {
                return $data[$middle];
            }else{
                $upper = (int)$middle - 1;
            }
        }
    }
    
    /**
     * 汉字转拼音
     * @param type $_String
     * @param type $_Code
     * @return type
     */
    public function Pinyin($_String, $_Code='gb2312'){
         
        $_DataKey = "a|ai|an|ang|ao|ba|bai|ban|bang|bao|bei|ben|beng|bi|bian|biao|bie|bin|bing|bo|bu|ca|cai|can|cang|cao|ce|ceng|cha".
                    "|chai|chan|chang|chao|che|chen|cheng|chi|chong|chou|chu|chuai|chuan|chuang|chui|chun|chuo|ci|cong|cou|cu|".
                    "cuan|cui|cun|cuo|da|dai|dan|dang|dao|de|deng|di|dian|diao|die|ding|diu|dong|dou|du|duan|dui|dun|duo|e|en|er".
                    "|fa|fan|fang|fei|fen|feng|fo|fou|fu|ga|gai|gan|gang|gao|ge|gei|gen|geng|gong|gou|gu|gua|guai|guan|guang|gui".
                    "|gun|guo|ha|hai|han|hang|hao|he|hei|hen|heng|hong|hou|hu|hua|huai|huan|huang|hui|hun|huo|ji|jia|jian|jiang".
                    "|jiao|jie|jin|jing|jiong|jiu|ju|juan|jue|jun|ka|kai|kan|kang|kao|ke|ken|keng|kong|kou|ku|kua|kuai|kuan|kuang".
                    "|kui|kun|kuo|la|lai|lan|lang|lao|le|lei|leng|li|lia|lian|liang|liao|lie|lin|ling|liu|long|lou|lu|lv|luan|lue".
                    "|lun|luo|ma|mai|man|mang|mao|me|mei|men|meng|mi|mian|miao|mie|min|ming|miu|mo|mou|mu|na|nai|nan|nang|nao|ne".
                    "|nei|nen|neng|ni|nian|niang|niao|nie|nin|ning|niu|nong|nu|nv|nuan|nue|nuo|o|ou|pa|pai|pan|pang|pao|pei|pen".
                    "|peng|pi|pian|piao|pie|pin|ping|po|pu|qi|qia|qian|qiang|qiao|qie|qin|qing|qiong|qiu|qu|quan|que|qun|ran|rang".
                    "|rao|re|ren|reng|ri|rong|rou|ru|ruan|rui|run|ruo|sa|sai|san|sang|sao|se|sen|seng|sha|shai|shan|shang|shao|".
                    "she|shen|sheng|shi|shou|shu|shua|shuai|shuan|shuang|shui|shun|shuo|si|song|sou|su|suan|sui|sun|suo|ta|tai|".
                    "tan|tang|tao|te|teng|ti|tian|tiao|tie|ting|tong|tou|tu|tuan|tui|tun|tuo|wa|wai|wan|wang|wei|wen|weng|wo|wu".
                    "|xi|xia|xian|xiang|xiao|xie|xin|xing|xiong|xiu|xu|xuan|xue|xun|ya|yan|yang|yao|ye|yi|yin|ying|yo|yong|you".
                    "|yu|yuan|yue|yun|za|zai|zan|zang|zao|ze|zei|zen|zeng|zha|zhai|zhan|zhang|zhao|zhe|zhen|zheng|zhi|zhong|".
                    "zhou|zhu|zhua|zhuai|zhuan|zhuang|zhui|zhun|zhuo|zi|zong|zou|zu|zuan|zui|zun|zuo";
                     
        $_DataValue = "-20319|-20317|-20304|-20295|-20292|-20283|-20265|-20257|-20242|-20230|-20051|-20036|-20032|-20026|-20002|-19990".
                    "|-19986|-19982|-19976|-19805|-19784|-19775|-19774|-19763|-19756|-19751|-19746|-19741|-19739|-19728|-19725".
                    "|-19715|-19540|-19531|-19525|-19515|-19500|-19484|-19479|-19467|-19289|-19288|-19281|-19275|-19270|-19263".
                    "|-19261|-19249|-19243|-19242|-19238|-19235|-19227|-19224|-19218|-19212|-19038|-19023|-19018|-19006|-19003".
                    "|-18996|-18977|-18961|-18952|-18783|-18774|-18773|-18763|-18756|-18741|-18735|-18731|-18722|-18710|-18697".
                    "|-18696|-18526|-18518|-18501|-18490|-18478|-18463|-18448|-18447|-18446|-18239|-18237|-18231|-18220|-18211".
                    "|-18201|-18184|-18183|-18181|-18012|-17997|-17988|-17970|-17964|-17961|-17950|-17947|-17931|-17928|-17922".
                    "|-17759|-17752|-17733|-17730|-17721|-17703|-17701|-17697|-17692|-17683|-17676|-17496|-17487|-17482|-17468".
                    "|-17454|-17433|-17427|-17417|-17202|-17185|-16983|-16970|-16942|-16915|-16733|-16708|-16706|-16689|-16664".
                    "|-16657|-16647|-16474|-16470|-16465|-16459|-16452|-16448|-16433|-16429|-16427|-16423|-16419|-16412|-16407".
                    "|-16403|-16401|-16393|-16220|-16216|-16212|-16205|-16202|-16187|-16180|-16171|-16169|-16158|-16155|-15959".
                    "|-15958|-15944|-15933|-15920|-15915|-15903|-15889|-15878|-15707|-15701|-15681|-15667|-15661|-15659|-15652".
                    "|-15640|-15631|-15625|-15454|-15448|-15436|-15435|-15419|-15416|-15408|-15394|-15385|-15377|-15375|-15369".
                    "|-15363|-15362|-15183|-15180|-15165|-15158|-15153|-15150|-15149|-15144|-15143|-15141|-15140|-15139|-15128".
                    "|-15121|-15119|-15117|-15110|-15109|-14941|-14937|-14933|-14930|-14929|-14928|-14926|-14922|-14921|-14914".
                    "|-14908|-14902|-14894|-14889|-14882|-14873|-14871|-14857|-14678|-14674|-14670|-14668|-14663|-14654|-14645".
                    "|-14630|-14594|-14429|-14407|-14399|-14384|-14379|-14368|-14355|-14353|-14345|-14170|-14159|-14151|-14149".
                    "|-14145|-14140|-14137|-14135|-14125|-14123|-14122|-14112|-14109|-14099|-14097|-14094|-14092|-14090|-14087".
                    "|-14083|-13917|-13914|-13910|-13907|-13906|-13905|-13896|-13894|-13878|-13870|-13859|-13847|-13831|-13658".
                    "|-13611|-13601|-13406|-13404|-13400|-13398|-13395|-13391|-13387|-13383|-13367|-13359|-13356|-13343|-13340".
                    "|-13329|-13326|-13318|-13147|-13138|-13120|-13107|-13096|-13095|-13091|-13076|-13068|-13063|-13060|-12888".
                    "|-12875|-12871|-12860|-12858|-12852|-12849|-12838|-12831|-12829|-12812|-12802|-12607|-12597|-12594|-12585".
                    "|-12556|-12359|-12346|-12320|-12300|-12120|-12099|-12089|-12074|-12067|-12058|-12039|-11867|-11861|-11847".
                    "|-11831|-11798|-11781|-11604|-11589|-11536|-11358|-11340|-11339|-11324|-11303|-11097|-11077|-11067|-11055".
                    "|-11052|-11045|-11041|-11038|-11024|-11020|-11019|-11018|-11014|-10838|-10832|-10815|-10800|-10790|-10780".
                    "|-10764|-10587|-10544|-10533|-10519|-10331|-10329|-10328|-10322|-10315|-10309|-10307|-10296|-10281|-10274".
                    "|-10270|-10262|-10260|-10256|-10254";
                     
        $_TDataKey = explode('|', $_DataKey);
        $_TDataValue = explode('|', $_DataValue);
        $_Data = (PHP_VERSION>='5.0') ? array_combine($_TDataKey, $_TDataValue) : $this->Arr_Combine($_TDataKey, $_TDataValue);
        arsort($_Data);
        reset($_Data);
        if($_Code != 'gb2312') $_String = $this->U2_Utf8_Gb($_String);
        $_Res = '';
        for($i=0; $i<strlen($_String); $i++){
            $_P = ord(substr($_String, $i, 1));
            if($_P>160) { $_Q = ord(substr($_String, ++$i, 1)); $_P = $_P*256 + $_Q - 65536; }
            if(!preg_match("/^\w$/",$this->Pinyins($_P, $_Data))){
                $_Res .= ' '.$this->Pinyins($_P, $_Data);
            } else {
                $_Res .= $this->Pinyins($_P, $_Data);
            }
        }
        return $_Res;
        //return preg_replace("/[^a-z0-9]*/", '', $_Res);
    }
         
    private function Pinyins($_Num, $_Data){
        if ($_Num>0 && $_Num<160 ) return chr($_Num);
            elseif($_Num<-20319 || $_Num>-10247) return '';
        else {
            foreach($_Data as $k=>$v){ if($v<=$_Num) break; }
            return $k;
        }
    }
    private function U2_Utf8_Gb($_C){
        $_String = '';
        if($_C < 0x80){ 
            $_String .= $_C;
        }elseif($_C < 0x800){
            $_String .= chr(0xC0 | $_C>>6);
            $_String .= chr(0x80 | $_C & 0x3F);
        }elseif($_C < 0x10000){
            $_String .= chr(0xE0 | $_C>>12);
            $_String .= chr(0x80 | $_C>>6 & 0x3F);
            $_String .= chr(0x80 | $_C & 0x3F);
        }elseif($_C < 0x200000) {
            $_String .= chr(0xF0 | $_C>>18);
            $_String .= chr(0x80 | $_C>>12 & 0x3F);
            $_String .= chr(0x80 | $_C>>6 & 0x3F);
            $_String .= chr(0x80 | $_C & 0x3F);
        }
            return iconv('UTF-8', 'gbk//ignore', $_String);
        }
    private function Arr_Combine($_Arr1, $_Arr2){
        for($i=0; $i<count($_Arr1); $i++) $_Res[$_Arr1[$i]] = $_Arr2[$i];
        return $_Res;
    }
     /** 
     * 把全名拆分为姓氏和名字 
     * @param string $fullname 全名 
     * @return array 一维数组,元素一是姓,元素二为名 
     */  
    public function splitName($fullname){  
         $hyphenated = array('欧阳','太史','端木','上官','司马','东方','独孤','南宫','万俟','闻人','夏侯','诸葛','尉迟','公羊','赫连','澹台','皇甫',  
            '宗政','濮阳','公冶','太叔','申屠','公孙','慕容','仲孙','钟离','长孙','宇文','城池','司徒','鲜于','司空','汝嫣','闾丘','子车','亓官',  
            '司寇','巫马','公西','颛孙','壤驷','公良','漆雕','乐正','宰父','谷梁','拓跋','夹谷','轩辕','令狐','段干','百里','呼延','东郭','南门',  
            '羊舌','微生','公户','公玉','公仪','梁丘','公仲','公上','公门','公山','公坚','左丘','公伯','西门','公祖','第五','公乘','贯丘','公皙',  
            '南荣','东里','东宫','仲长','子书','子桑','即墨','达奚','褚师');  
            $vLength = mb_strlen($fullname, 'utf-8');  
            $lastname = '';  
            $firstname = '';//前为姓,后为名  
            if($vLength > 2){  
                $preTwoWords = mb_substr($fullname, 0, 2, 'utf-8');//取命名的前两个字,看是否在复姓库中  
                if(in_array($preTwoWords, $hyphenated)){  
                    $lastname = $preTwoWords;  
                    $firstname = mb_substr($fullname, 2, 10, 'utf-8');  
                }else{  
                    $lastname = mb_substr($fullname, 0, 1, 'utf-8');  
                    $firstname = mb_substr($fullname, 1, 10, 'utf-8');  
                }  
            }else if($vLength == 2){//全名只有两个字时,以前一个为姓,后一下为名  
                $lastname = mb_substr($fullname ,0, 1, 'utf-8');  
                $firstname = mb_substr($fullname, 1, 10, 'utf-8');  
            }else{  
                $lastname = $fullname;  
            }  
            return array($lastname, $firstname);  
    }  

}