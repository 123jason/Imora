<?php
namespace Oradt\ServiceBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
/**
 * 地图服务类
 * @author huangxm
 *
 */
class MapNewService extends BaseService {
    private $baidu_ak;   //百度地图AK
    private $baidu_place_ak;//百度地图服务
    private $getLocalUrl;
    private $getlatlngUrl;
    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
        $this->baidu_ak = $this->container->getParameter('BAIDU_MAP_AK');
        $this->baidu_place_ak = $this->container->getParameter('BAIDU_PLACE_AK');
        $this->mapUrl = $this->container->getParameter('MAP_HOST_URL');
    }
    /**     
     * 根所手机号或地址 获取地址位置
     * @param string $address
     * @return null or array
     * @example
     * mapService = $this->get("map_service");
     * $map = $mapService->getGeocoder ( $request->get ( "m" ) );
     * print_r ( $map  ); // Array ( [lng] => 116.39564503788 [lat] => 39.92998577808 )
     */
    public function getGeocoder($address) {
        $functionService = $this->container->get ( "function_service" );
        // 如果是手机号，先搜索所在城市
        if ($functionService->checkTelephone ( $address )) {
            $city = $this->getCity ( $address );
            if (! empty ( $city )) {
                $address = $city;
            } else {
                return null;
            }
        }
        try{
            $maphtml = @file_get_contents ( $this->mapUrl."/service/map/getlatlng?address=".urlencode ( $address ));
            if (empty ( $maphtml ))    return null;
        }catch (\Exception $ex) {
            $this->errorLogger($ex);
            return null;
        }
        $mapJson = json_decode ( $maphtml, true );
        
        if (! isset ( $mapJson ['result'] ['location'] )){
            $this->baseLogger->info('getlatlng-----request:' . $maphtml);
            return null;
        }
        $location = $mapJson ['result'] ['location'];
        return array (
            'lng' => $location ['lng'],
            'lat' => $location ['lat']
        );
    }   
    
    /** 注：这个还有地方使用
     * 根据经纬度md5值 或 地址的md5值
     * @param sting $md5Id   纬度md5值 或 地址的md5值
     * return array()
     */
    public function getTblGeocoder($md5Id){
        return '';
        $vParam = array(":md5id" => $md5Id);
        $vSql   = "SELECT latitude,longitude,country,province,city,district,address FROM tbl_geocoder WHERE md5_id=:md5id";
        $vCon   = $this->getConnection()->executequery($vSql,$vParam)->fetch();
        if(empty($vCon)){
            return '';
        }
        return $vCon;
    }
    /**     
     * 根据地址 获取地址位置 逆向解析获取 省 市 区县等信息
     * @param string $address
     * @return null or array
     * @example
     * mapService = $this->get("map_service");
     * $map = $mapService->getGeocoderAndAddress ( $request->get ( "m" ) );
     * print_r ( $map  ); 
     * Array([longitude] => 116.39564503788[latitude] => 39.92998577808 [country]=>中国 
     * [province]=>北京市 [city]=>北京 [district]=>海淀区)
     */
    public function getGeocoderAndAddress($address) {
        if(empty($address))     return null;
        $geocoder = $this->getGeocoder($address);
        if(empty($geocoder))    return null;
        $address  = $this->getAddressByGeocoder($geocoder['lat'], $geocoder['lng']);
        if(empty($address))     return null;
        return array_merge(array('longitude'=>$geocoder['lng'],'latitude'=>$geocoder['lat']),$address);
    }
    
    /**
     * 根据经纬度逆向解析获取省市县
     * @param int $lng 经度
     * @param int $lat 纬度
     * return null or array
     * mapService = $this->get("map_service");
     * $map = $mapService->getAddressByGeocoder ( $lat,$lng );
     * print_r ( $map  ); Array ( [country]=>中国 [province]=>北京市 [city]=>北京 [district]=>海淀区)
     * 注：md5($lat.$lng); 作为唯一值
     */
    public function getAddressByGeocoder($lat,$lng){
        if(empty($lat) || empty($lng)) return null;
        try{
            $format_address = $country = $province = $city = $district = "";
            
            //根据经纬度 逆向解析
            $maphtmlAll = @file_get_contents ( $this->mapUrl."/service/map/getLocal?lat=".$lat."&lng=".$lng);
            if(empty($maphtmlAll))  return null;
            $mapallJson = json_decode ( $maphtmlAll, true );
            if (! isset ( $mapallJson ['result'] ['addressComponent'] )){
                $this->baseLogger->info('getLocal-----request:' . $maphtmlAll);
                return null;
            }
            if(isset($mapallJson ['result'] ['addressComponent']['country'])){
                $country    = $mapallJson ['result'] ['addressComponent']['country'];
            }
            if(isset($mapallJson ['result'] ['addressComponent']['province'])){
                $province   = $mapallJson ['result'] ['addressComponent']['province'];
            }
            if(isset($mapallJson ['result'] ['addressComponent']['city'])){
                $city       = $mapallJson ['result'] ['addressComponent']['city'];
            }
            if(isset($mapallJson ['result'] ['addressComponent']['district'])){
                $district   = $mapallJson ['result'] ['addressComponent']['district'];
            }
            if(isset($mapallJson ['result'] ['formatted_address'])){
                $format_address   = $mapallJson ['result'] ['formatted_address'];
            }
            //if(empty($country) && empty($province) && empty($city) && empty($district))    return null; 
            return array (
                'country'   => $country,
                'province'  => $province,
                'city'      => $city,
                'district'  => $district,
                'format_address' => $format_address
            );
        }catch (\Exception $ex) {
            $this->errorLogger($ex);
        }
    }
    
    /**
     * @param string $region    省份 或 国家名 比如：北京市 四川省
     * @param string $name      城市 或 区县下的名字
     */
    public function  getcityGeoLngLat($region,$name){
        try{
            //http://api.map.baidu.com/place/v2/search?ak=您的密钥&output=json&query=%E5%8C%97%E4%BA%AC%E5%B8%82&page_size=10&page_num=0&scope=1&region=%E4%B8%AD%E5%9B%BD
            $maphtmlAll = @file_get_contents ( "http://api.map.baidu.com/place/v2/search?ak=".$this->baidu_ak."&output=json&query=".urlencode($name)."&page_size=10&page_num=0&scope=1&region=".urlencode($region));
            if(empty($maphtmlAll))  return null;
            
            $mapallJson = json_decode ( $maphtmlAll, true );
            
            if (! isset ( $mapallJson ['results'] [0] ))   return null;
            
            $location   = $mapallJson ['results'] [0]['location'];
            $name       = $mapallJson ['results'] [0]['name'];
            return array (
                'lat'   => $location['lat'],
                'lng'   => $location['lng'],
                'name'  => $name
            );
        }catch (\Exception $ex) {
            echo $ex->getMessage();
            $this->errorLogger($ex);
        }
    }
    
    /**
     * 根据md5值查询
     * @param string $md5id   
     * md5(中国) 2:md5(中国河南省) 3:md5(中国河南省郑州市) 4:md5(中国河南省郑州市高新区)
     */
    public function findOradtLocationOneBy($md5id){
        $sql = "SELECT md5_id FROM oradt_location where md5_id = '".$md5id."'";
        $row = $this->getConnection()->executequery($sql,array())->fetch();
        if(!empty($row)){
            return $row['md5_id'];
        }
        return null;
    }

    /**
     * @param string $md5   md5值 
     * @param string $lat   纬度
     * @param string $lng   经度
     * @param string $name  经纬度对应的名称
     * @param string $parent_md5  父级md5值
     * @param string $level       等级 1：国家级 2：省级 3：城市级 4：区县级别
     * level  1:md5(中国) 2:md5(中国河南省) 3:md5(中国河南省郑州市) 4:md5(中国河南省郑州市高新区)
     */
    public function  insertLocation($md5,$lat,$lng,$name,$parent_md5='',$level){
        $locationParams = array(
            ':md5_id'       => $md5 ,   
            ':parent_md5_id'=> $parent_md5, 
            ':level'        => $level, 
            ':latitude'     => $lat, 
            ':longitude'    => $lng, 
            ':name'         => $name
        );
        $locQuery = "INSERT INTO oradt_location (md5_id,parent_md5_id,level,latitude,longitude,name) 
                VALUES(:md5_id,:parent_md5_id,:level,:latitude,:longitude,:name)";
        $this->getConnection()->executeUpdate($locQuery , $locationParams);
        return true;
    }
    
    /**
     * 根据国家 省 市 区县 采集对应地区的经纬度
     * @param string $country   国家
     * @param string $province  省
     * @param string $city      城市
     * @param string $district  区县
     * 调用示例
     * $mapService = $this->container->get("map_service");
     * $mapService->collectLatAndLng("中国","广东省","深圳市","南山区");
     */
    public function collectLatAndLng($country,$province,$city,$district){
        if(empty($country) || empty($province) || empty($city) || empty($district)){
            return null;
        }
        $md5guo     = md5($country);
        $md5sheng   = md5($country.$province);
        $md5city    = md5($country.$province.$city);
        $md5quxian  = md5($country.$province.$city.$district);
        $row1 = $this->findOradtLocationOneBy($md5guo);
        if(empty($row1)){
            $mapArray = $this->getcityGeoLngLat($country,$country);
            if(!empty($mapArray)){
                $this->insertLocation($md5guo,$mapArray['lat'],$mapArray['lng'],$country,'',1);
            }
        }
        $row2 = $this->findOradtLocationOneBy($md5sheng);
        if(empty($row2)){
            $mapArray = $this->getcityGeoLngLat($country,$province);
            if(!empty($mapArray)){
                $this->insertLocation($md5sheng,$mapArray['lat'],$mapArray['lng'],$province,$md5guo,2);
            }
        }
        $row3 = $this->findOradtLocationOneBy($md5city);
        if(empty($row3)){
            $mapArray = $this->getcityGeoLngLat($province,$city);
            if(!empty($mapArray)){
                $this->insertLocation($md5city,$mapArray['lat'],$mapArray['lng'],$city,$md5sheng,3);
            }
        }
        $row4 = $this->findOradtLocationOneBy($md5quxian);
        if(empty($row4)){
            $mapArray = $this->getcityGeoLngLat($city,$district);
            if(!empty($mapArray)){
                $this->insertLocation($md5quxian,$mapArray['lat'],$mapArray['lng'],$district,$md5city,4);
            }
        }
        return array(
            'md5guo'    => $md5guo,
            'md5sheng'  => $md5sheng,
            'md5city'   => $md5city,
            'md5quxian' => $md5quxian
        );
    }
    /**
     * 更新或采集名片 地区经纬度信息
     * @param string $md5Arr      
     * @param string $vcardid     名片ID
     * Array(
     * [md5guo] => c13dceabcb143acd6c9298265d618a9f         //国家md5 (例：md5(中国))
     * [md5sheng] => 0426e78c20c9a2317b42354396681d48       //省md5值
     * [md5city] => 3b1ed9fb579b0891fc9780cb04ea3343        //城市md5值
     * [md5quxian] => 24468b90f2c6d64a2f6c83a1a4b4c0fb      //区县md5值
     */
    public function contactCardPrvateMd5($md5Arr,$vcardid){
        $md5guo = $md5Arr['md5guo'];
        $guoArr     = $this->findContactCardMd5OneBy($md5Arr['md5guo'],1, $vcardid);
        $shengArr   = $this->findContactCardMd5OneBy($md5Arr['md5sheng'],2, $vcardid);
        $cityArr    = $this->findContactCardMd5OneBy($md5Arr['md5city'],3, $vcardid);
        $quxianArr  = $this->findContactCardMd5OneBy($md5Arr['md5quxian'],4, $vcardid);
        return TRUE;
    }
    /**
     * 名片地理位置等级分类（更新 或 采集）
     * @param sting $md5id      省市区的 md5值
     * @param sting $level      等级 1：国家 2：省份 3：城市 4：区县
     * @param sting $vcardid    名片ID
     */
    public function findContactCardMd5OneBy($md5id,$level,$vcardid){
        $locComParams = array(
            ':vcard_id' => $vcardid, 
            ':level'    => $level, 
            ':md5id'    => $md5id
        );
        $sql = "SELECT id FROM contact_private_location_md5 where vcard_id = '".$vcardid."' AND level = '".$level."'";
        $row = $this->getConnection()->executequery($sql,array())->fetch();
        if(!empty($row)){
            $locComParams[':id']    = $row['id'];
            $upLocSql    = "UPDATE `contact_private_location_md5` SET md5id=:md5id WHERE id = :id";
            $this->getConnection()->executeUpdate($upLocSql, $locComParams);
        }else{
            $inLocQuery = "INSERT INTO contact_private_location_md5 (vcard_id,level,md5id) VALUES(:vcard_id,:level,:md5id)";
            $this->getConnection()->executeUpdate($inLocQuery , $locComParams);
        }
        return true;
    }
    
    /**
     * 查询手机号所属手
     * @param string $m
     * @return NULL|Ambigous <NULL, mixed>
     */
    public function getCity($m) {
        if (empty ( $m ))
            return null;
        $mobileurl = 'http://v.showji.com/locating/showji.com1118.aspx?m=' . $m . '&output=json&timestamp=' . time ();
        $html = @file_get_contents ( $mobileurl );
        $json = json_decode ( $html, true );
        return isset ( $json ['City']) ? $json['City'] : null ;
    }
    
    public function getAround($lon, $lat, $raidus) {
        $latitude = $lat;
        $longitude = $lon;
    
        $degree = (24901 * 1609) / 360.0;
        $raidusMile = $raidus;
    
        $dpmLat = 1 / $degree;
        $radiusLat = $dpmLat * $raidusMile;
        $minLat = $latitude - $radiusLat;
        $maxLat = $latitude + $radiusLat;
    
        $mpdLng = abs($degree * cos($latitude * (pi() / 180)));
        $dpmLng = 1 / $mpdLng;
        $radiusLng = $dpmLng * $raidusMile;
        $minLng = $longitude - $radiusLng;
        $maxLng = $longitude + $radiusLng;
    
        return array( $minLng, $minLat, $maxLng, $maxLat );
    }

    public function getPlaceAPI($keyworld,$local,$pagenow = 0,$pagesize = 10,$tag = ''){

        $url ="http://api.map.baidu.com/place/v2/search?query=".$keyworld."&scope=1&tag=".$tag."&page_size=".$pagesize."&page_num=$pagenow&output=json&location=".$local."&radius=500&ak=".$this->baidu_ak;
        try{
            $maphtml = @file_get_contents ( $url );
            if (empty ( $maphtml )) {
                return null;
            }
        }catch (\Exception $ex) {
            $this->errorLogger($ex);
            return null;
        }
        $mapJson = json_decode ( $maphtml, true );
        return $mapJson;

    }
    public function getPlaceApiOne($keyworld,$local,$pagenow = 0,$pagesize = 10,$tag = '',$loopnum){
        $pagenow = 0;
        if($loopnum == 0){
            return false;
        }else{
            $loopnum = $loopnum - 1;
        }
        $arrurl = array();
        while($pagenow <= $loopnum){
            $url ="http://api.map.baidu.com/place/v2/search?query=".$keyworld."&scope=1&tag=".$tag."&page_size=".$pagesize."&page_num=$pagenow&output=json&location=".$local."&radius=500&ak=".$this->baidu_ak;
            $arrurl[] = $url;
            $pagenow++;
        }
        $res = $this->curlMulti($arrurl,array(),'array');
        return $res;
    }
    public static function curlMulti($urls,$params=array(),$rtnFormat='string'){
        $urls = (array)$urls; //对urls进行类型转换，若果不是数组，则强制转换成数组
        $start = microtime(true);

        $header = array("Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
            "Accept-Encoding:gzip, deflate",
            "Accept-Language:zh-CN,zh-HK;q=0.8,zh-TW;q=0.7,en-US;q=0.5,zh;q=0.3,en;q=0.2",
            "Cache-Control:max-age=0",
            "Connection:keep-alive",
            "Host:qt.gtimg.cn",
            "If-None-Match:	1466172382-3262",
            "User-Agent:Mozilla/5.0 (Windows NT 5.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0");
        $result = '';
        $mh = curl_multi_init();
        foreach ($urls as $i => $url) {
            $totalUrl = $url.(isset($params[$i]) ? $params[$i] : '');
            $conn[$i] = curl_init($totalUrl);
            curl_setopt($conn[$i], CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 5.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0");
            //curl_setopt($conn[$i], CURLOPT_HTTPHEADER, $header);  //设置头信息的地方
            //curl_setopt($conn[$i], CURLOPT_BINARYTRANSFER, true) ;
            //curl_setopt($conn[$i], CURLOPT_ENCODING, 'gzip,deflate'); //尝试解决中文乱码，失败了
            //curl_setopt($conn[$i], CURLOPT_ENCODING, "gzip, deflate"); //相当于header里的Accept-Encoding【尝试解决中文乱码，失败】
            curl_setopt($conn[$i], CURLOPT_HEADER ,0);   //是否取得返回头信息
            curl_setopt($conn[$i], CURLOPT_CONNECTTIMEOUT,3);
            curl_setopt($conn[$i],CURLOPT_RETURNTRANSFER,true);  // 设置不将爬取代码写到浏览器，而是转化为字符串
            curl_multi_add_handle ($mh,$conn[$i]);
        }
        do {
            curl_multi_exec($mh,$active);
        } while ($active);

        foreach ($urls as $i => $url) {
            $data = curl_multi_getcontent($conn[$i]); // 获得爬取的代码字符串
            if($rtnFormat == 'string'){
                $result .= $data;
            }else if($rtnFormat == 'array'){
                $data = json_decode($data,true);
                foreach($data['results'] as $v){
                    $result[] = $v;
                }
            }
        } // 获得数据变量，并写入文件

        foreach ($urls as $i => $url) {
            curl_multi_remove_handle($mh,$conn[$i]);
            curl_close($conn[$i]);
        }
        curl_multi_close($mh);
        //echo '<br/>【抓取原始时间】：'.(microtime(true)-$start);
        return $result;
    }

    //1、GCJ-02，国测局02年发布的坐标体系。又称“火星坐标”。谷歌，腾讯，高德都在用这个坐标体系。
    //2、BD-09，百度坐标系
    //GCJ-02转换BD-09
    public function GCJTobaidu($lat, $lng){
        $v = pi() * 3000.0 / 180.0;
        $x = $lng;
        $y = $lat;

        $z = sqrt($x * $x + $y * $y) + 0.00002 * sin($y * $v);
        $t = atan2($y, $x) + 0.000003 * cos($x * $v);

        return array(
            'lat' => $z * sin($t) + 0.006,
            'lng' => $z * cos($t) + 0.0065
        );
    }
    //BD-09转换GCJ-02
    public function baiduToGCJ($lat, $lng){
        $v = pi() * 3000.0 / 180.0;
        $x = $lng - 0.0065;
        $y = $lat - 0.006;

        $z = sqrt($x * $x + $y * $y) - 0.00002 * sin($y * $v);
        $t = atan2($y, $x) - 0.000003 * cos($x * $v);

        return array(
            'lat' => $z * sin($t),
            'lng' => $z * cos($t)
        );
    }

}