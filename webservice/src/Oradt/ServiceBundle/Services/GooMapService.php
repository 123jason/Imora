<?php
namespace Oradt\ServiceBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
/**
 * 谷歌地图服务类
 * User: tianjianlin
 * Date: 2017/6/26
 * Time: 10:28
 */
class GooMapService extends BaseService {
    private $goo_key = 'AIzaSyDB6ZD22R4YNPZRrjxVRSsqwhi5ikW7sOY';
    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
    }
    public function proxy($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:1080');
        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));

        $result = curl_exec($ch);

        curl_close($ch);
        //echo $result;exit();
        return $result;


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
        $address = trim($address);
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

        //写入调用记录
        $type = md5($address);
        $env  = $this->container->getParameterBag()->get("kernel.environment");
        $this->insertApiStatistic('google_zs_'.$env,$type);

        try{
            $maphtml = $this->proxy( "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode ( $address )
                . "&key=" . $this->goo_key ."&language=zh-CN");
            if (empty ( $maphtml )) {
                return null;
            }
        }catch (\Exception $ex) {
            $this->errorLogger($ex);
            return null;
        }
        $mapJson = json_decode ( $maphtml, true );
        if ( "ZERO_RESULTS" === $mapJson['status'] || ! isset ( $mapJson['results'][0]['geometry']['location'] )){
            $this->baseLogger->info('GOOGLE---request:' . $maphtml . ';;ADDRESS:'. $address);
            return null;
        }
        return $mapJson;
    }

    /**
     * 写入调用记录
     */
    public function insertApiStatistic($userid,$type){
        $sql = "INSERT INTO api_statistic (user_id, api_name, method, date_time, call_times)
                VALUES (:userId, :type, :method, :times, :call_times)";
        $params = array(
            ':userId' => $userid,
            ':type'   => $type,
            ':method' => 'get',
            ':times'      => $this->getTimestamp1(),
            ':call_times' => $this->getTimestamp1()
        );
        $this->getManager('default')->getConnection()->executeQuery($sql,$params);
    }
    /**
     * 根据经纬度md5值 或 地址的md5值
     * @param sting $md5Id   纬度md5值 或 地址的md5值
     * return array()
     */
    public function getTblGeocoder($md5Id){
        $vParam = array(":md5id" => $md5Id);
        $vSql   = "SELECT latitude,longitude,country,province,city,district,address FROM tbl_geocoder WHERE md5_id=:md5id";
        $vCon   = $this->getConnection()->executequery($vSql,$vParam)->fetch();
        if(empty($vCon)){
            return '';
        }
        return $vCon;
    }
    /**
     * 记录百度获取数据
     * @param string $md5   纬经度md5值 或 地址的md5值
     * @param string $lat   纬度
     * @param string $lng   经度
     * @param string $address    地址
     * @param string $country    国家
     * @param string $province   省份
     * @param string $city       城市
     * @param string $district   区县
     * return
     */
    public function  insertTblGeocoder($md5,$lat,$lng,$address='',$country='',$province='',$city='',$district=''){
        $geoParams = array(
            ':md5_id'   => $md5 ,
            ':lat'      => $lat,
            ':lng'      => $lng,
            ':country'  => $country,
            ':province' => $province,
            ':city'     => $city,
            ':district' => $district,
            ':address'  => $address
        );
        $geoQuery = "INSERT INTO tbl_geocoder (md5_id,latitude,longitude,country,province,city,district,address)
                VALUES(:md5_id,:lat,:lng,:country,:province,:city,:district,:address)";
        $this->getConnection()->executeUpdate($geoQuery , $geoParams);
        return true;
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
        $address = trim($address);
        if(empty($address))     return null;
        $geocoder = $this->getGeocoder($address);
        if(empty($geocoder))    return null;
        $address  = $this->getAddressByGeocoder($geocoder);
        if(empty($address))     return null;

        return $address;
        //return array_merge(array('longitude'=>$geocoder['lng'],'latitude'=>$geocoder['lat']),$address);
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
    public function getAddressByGeocoder( $geocoder ){
        if( empty( $geocoder ) ){
            return null;
        }
        $location = $geocoder['results'][0]['geometry']['location'];
        $latlng = $this->GCJTobaidu($location['lat'] , $location['lng']);
        $lat = $latlng['lat'];
        $lng = $latlng['lng'];
        //写入记录
        $type = $lng.'_'.$lat;
        $env  = $this->container->getParameterBag()->get("kernel.environment");
        try{
            $country = $province = $city = $district = "";

            $md5Id   = md5($lat.$lng);    //经纬度的md5值

                $mapallJson = array_reverse($geocoder['results'][0]['address_components']);

                $allArr = $this->getPlace($mapallJson);
                if( !empty($allArr[0]) ){
                    $country = $allArr[0];
                }
                if( !empty($allArr[1]) ) {
                    $province = $allArr[1];
                }
                if( !empty($allArr[2]) ) {
                    $city = $allArr[2];
                }
                if( !empty($allArr[3]) ){
                    $district = $allArr[3];
                }
                if( empty($district) && !empty($province) && !empty($city) ){
                    $district = $city;
                    $city = $province;
                }
                //获取成功的 写入数据表
                //$this->insertTblGeocoder($md5Id, $lat, $lng,'',$country,$province,$city,$district);

            if(empty($country) && empty($province) && empty($city) && empty($district))    return null;

            return array (
                'longitude' => $lng,
                'latitude' => $lat,
                'country'   => $country,
                'province'  => $province,
                'city'      => $city,
                'district'  => $district,
            );
        }catch (\Exception $ex) {
            $this->errorLogger($ex);
        }
    }
    public function getPlace( $placeArr = array() ){
        if( empty($placeArr) ){
            return null;
        }
        $allArr = array();
        foreach($placeArr as $v){
            if( !empty($v) && in_array( "political", $v['types'])){
                $allArr[] = $v['long_name'];
            }
        }
        return $allArr;
    }
    /**
     * @param string $region    省份 或 国家名 比如：北京市 四川省
     * @param string $name      城市 或 区县下的名字
     */
    public function  getcityGeoLngLat($region,$name){
        try{
            //http://api.map.baidu.com/place/v2/search?ak=您的密钥&output=json&query=%E5%8C%97%E4%BA%AC%E5%B8%82&page_size=10&page_num=0&scope=1&region=%E4%B8%AD%E5%9B%BD
            //$maphtmlAll = @file_get_contents ( "http://api.map.baidu.com/place/v2/search?ak=".$this->baidu_ak."&output=json&query=".urlencode($name)."&page_size=10&page_num=0&scope=1&region=".urlencode($region));
            $maphtmlAll = $this->proxy( "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode ( $name )
                . "&key=" . $this->goo_key ."&region=".$region);
            if(empty($maphtmlAll))  return null;

            $mapallJson = json_decode ( $maphtmlAll, true );

            if (! isset ( $mapallJson ['results'] [0] ))   return null;
            $location   = $mapallJson['results'][0]['geometry']['location'];
            $latlng = $this->GCJTobaidu($location['lat'] , $location['lng']);

            //$name       = $mapallJson ['results'] [0]['name'];
            return array (
                'lat'   => $latlng['lat'],
                'lng'   => $latlng['lng'],
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

        $url ="http://api.map.baidu.com/place/v2/search?query=".$keyworld."&scope=1&tag=".$tag."&page_size=".$pagesize."&page_num=$pagenow&output=json&location=".$local."&radius=2000&ak=".$this->baidu_ak;
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

    private $PI = 3.14159265358979324;
    //1、GCJ-02，国测局02年发布的坐标体系。又称“火星坐标”。谷歌，腾讯，高德都在用这个坐标体系。
    //2、BD-09，百度坐标系
    //GCJ-02转换BD-09
    public function GCJTobaidu($lat, $lng){
        $v = pi() * 3000.0 / 180.0;
        $latlng  = $this->gcj_encrypt( $lat, $lng );
        $x = $latlng['lng'];
        $y = $latlng['lat'];

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
    //WGS-84 to GCJ-02
    public function gcj_encrypt($wgsLat, $wgsLon) {
        if (!$this->isInChina($wgsLat, $wgsLon))
            return array('lat' => $wgsLat, 'lng' => $wgsLon);

        $d = $this->delta($wgsLat, $wgsLon);
        return array('lat' => $wgsLat + $d['lat'],'lng' => $wgsLon + $d['lon']);
    }

    private function delta($lat, $lon)
    {
        $a = 6378245.0;//  a: 卫星椭球坐标投影到平面地图坐标系的投影因子。
        $ee = 0.00669342162296594323;//  ee: 椭球的偏心率。
        $dLat = $this->transformLat($lon - 105.0, $lat - 35.0);
        $dLon = $this->transformLon($lon - 105.0, $lat - 35.0);
        $radLat = $lat / 180.0 * $this->PI;
        $magic = sin($radLat);
        $magic = 1 - $ee * $magic * $magic;
        $sqrtMagic = sqrt($magic);
        $dLat = ($dLat * 180.0) / (($a * (1 - $ee)) / ($magic * $sqrtMagic) * $this->PI);
        $dLon = ($dLon * 180.0) / ($a / $sqrtMagic * cos($radLat) * $this->PI);
        return array('lat' => $dLat, 'lon' => $dLon);
    }

    private function rectangle($lng1, $lat1, $lng2, $lat2) {
        return array(
            'west' => min($lng1, $lng2),
            'north' => max($lat1, $lat2),
            'east' => max($lng1, $lng2),
            'south' => min($lat1, $lat2),
        );
    }

    private function isInRect($rect, $lon, $lat) {
        return $rect['west'] <= $lon && $rect['east'] >= $lon && $rect['north'] >= $lat && $rect['south'] <= $lat;
    }

    private function isInChina($lat, $lon) {
        //China region - raw data
        //http://www.cnblogs.com/Aimeast/archive/2012/08/09/2629614.html
        $region = array(
            $this->rectangle(79.446200, 49.220400, 96.330000,42.889900),
            $this->rectangle(109.687200, 54.141500, 135.000200, 39.374200),
            $this->rectangle(73.124600, 42.889900, 124.143255, 29.529700),
            $this->rectangle(82.968400, 29.529700, 97.035200, 26.718600),
            $this->rectangle(97.025300, 29.529700, 124.367395, 20.414096),
            $this->rectangle(107.975793, 20.414096, 111.744104, 17.871542),
        );

        //China excluded region - raw data
        $exclude = array(
            $this->rectangle(119.921265, 25.398623, 122.497559, 21.785006),
            $this->rectangle(101.865200, 22.284000, 106.665000, 20.098800),
            $this->rectangle(106.452500, 21.542200, 108.051000, 20.487800),
            $this->rectangle(109.032300, 55.817500, 119.127000, 50.325700),
            $this->rectangle(127.456800, 55.817500, 137.022700, 49.557400),
            $this->rectangle(131.266200, 44.892200, 137.022700, 42.569200),
        );
        for ($i = 0; $i < count($region); $i++)
            if ($this->isInRect($region[$i], $lon, $lat))
            {
                for ($j = 0; $j < count($exclude); $j++)
                    if ($this->isInRect($exclude[$j], $lon, $lat))
                        return false;
                return true;
            }
        return false;
    }

    private function transformLat($x, $y) {
        $ret = -100.0 + 2.0 * $x + 3.0 * $y + 0.2 * $y * $y + 0.1 * $x * $y + 0.2 * sqrt(abs($x));
        $ret += (20.0 * sin(6.0 * $x * $this->PI) + 20.0 * sin(2.0 * $x * $this->PI)) * 2.0 / 3.0;
        $ret += (20.0 * sin($y * $this->PI) + 40.0 * sin($y / 3.0 * $this->PI)) * 2.0 / 3.0;
        $ret += (160.0 * sin($y / 12.0 * $this->PI) + 320 * sin($y * $this->PI / 30.0)) * 2.0 / 3.0;
        return $ret;
    }

    private function transformLon($x, $y) {
        $ret = 300.0 + $x + 2.0 * $y + 0.1 * $x * $x + 0.1 * $x * $y + 0.1 * sqrt(abs($x));
        $ret += (20.0 * sin(6.0 * $x * $this->PI) + 20.0 * sin(2.0 * $x * $this->PI)) * 2.0 / 3.0;
        $ret += (20.0 * sin($x * $this->PI) + 40.0 * sin($x / 3.0 * $this->PI)) * 2.0 / 3.0;
        $ret += (150.0 * sin($x / 12.0 * $this->PI) + 300.0 * sin($x / 30.0 * $this->PI)) * 2.0 / 3.0;
        return $ret;
    }
}