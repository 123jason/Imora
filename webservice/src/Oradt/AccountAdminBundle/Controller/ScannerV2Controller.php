<?php
namespace Oradt\AccountAdminBundle\Controller;


use Oradt\OauthBundle\Controller\BaseController;
use Oradt\StoreBundle\Entity\ScannerV2;
use Oradt\StoreBundle\Entity\ScannerV2BalanceRemindUsers;
use Oradt\Utils\Errors;


class ScannerV2Controller  extends BaseController{
    
    public function postAction($act){
        switch ($act) {
            case 'add':
                return $this->_postAddScannerV2();          //新增扫描仪
                break;
            case 'edit':
                return $this->_postEditScannerV2();         //编辑扫描仪
                break;
            case 'statistics':
                return $this->_ScannerV2StatistisList();         //扫描仪使用统计
                break;
            case 'restart':
                return $this->_ScannerV2Restart();         //扫描仪重启
                break;
            case 'del':
                return $this->_ScannerV2Delete();               //扫描仪删除
                break;
            case 'setremindprice':
                return $this->_ScannerV2SetRemindPrice();       //设置提醒金额
                break;
            case 'addreminduser':
                return $this->_ScannerV2AddRemindUser();        //添加余额提醒接收人
                break;
            case 'delreminduser':
                return $this->_ScannerV2DelRemindUser();        //删除余额提醒接收人
                break;
            default:
                return $this->renderJsonFailed( Errors::$ERROR_PARAMETER_NOT_ENOUGH );
                break;
        }
    }
    
    /**
     * 删除余额接收人
     */
    public function  _ScannerV2DelRemindUser(){
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $adminId    = $this->accountId;
        $Id         = $this->strip_tags($request->get('id'));            //余额接收人记录id
        //必要条件
        if (empty($Id)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();
        try {
            $userCon = $this->getDoctrine ()->getRepository ( 'OradtStoreBundle:ScannerV2BalanceRemindUsers' )
                                 ->findOneBy ( array ( 'id'=>$Id) );
            if(empty($userCon)){
                return $this->renderJsonFailed( Errors::$ERROR_PARAMETER_NOT_DATA );
            }
            $sql = "delete from `scanner_v2_balance_remind_users` where id =:id";
            $this->getConnection()->executeQuery($sql,array(':id'=>$Id));
            
            $em->getConnection()->commit();
            return $this->renderJsonSuccess();
        } catch (\Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }
    }
    
    /**
     * 添加余额提醒接收人
     */
    public function  _ScannerV2AddRemindUser(){
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $adminId    = $this->accountId;
        $name   = $this->strip_tags($request->get('name'));            //姓名
        $email  = $this->strip_tags($request->get('email'));           //邮箱
        $mobile = $this->strip_tags($request->get('mobile'));          //电话

        //必要条件
        if (empty($name) || empty($email) || empty($mobile)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        
        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();
        try {
            $createTime = $this->getTimestamp();
            $remindUsers = new ScannerV2BalanceRemindUsers();
            $remindUsers->setName($name);
            $remindUsers->setEmail($email);
            $remindUsers->setMobile($mobile);
            $remindUsers->setCreateTime($createTime);
            $em->persist($remindUsers);
            $em->flush();
            $em->getConnection()->commit();
            $data = array( 
                'id'   => $remindUsers->getId()
            );
            return $this->renderJsonSuccess($data);
        } catch (\Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }
    }
    
    /**
     * 设置提醒金额
     */
    public function  _ScannerV2SetRemindPrice(){
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $adminId      = $this->accountId;
        $Id           = $this->strip_tags($request->get('id'));                  //id
        $remindPrice  = $this->strip_tags($request->get('remindprice'));       //设置金额
        //必要条件
        if (empty($Id) || empty($remindPrice)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();
        try {
            $lastSql    = "SELECT a.id FROM scanner_v2_balance AS a WHERE a.id =:id;";
            $priceArr   = $this->getConnection()->executeQuery($lastSql, array(":id"=>$Id))->fetch();
            if(empty($priceArr)){
                return $this->renderJsonFailed( Errors::$ERROR_PARAMETER_NOT_DATA );
            }
            $upParam    = array(
                ':id'     =>$Id,                //id
                ':price'  =>$remindPrice,       
            );
            $upmapSql = "UPDATE scanner_v2_balance SET remind_price=:price WHERE id =:id";
            $this->getConnection()->executeUpdate($upmapSql,$upParam);
            $em->getConnection()->commit();
            return $this->renderJsonSuccess();
        } catch (\Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }
    }
    
    /**
     * 扫描仪删除接口
     */
    public function  _ScannerV2Delete(){
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $adminId    = $this->accountId;
        $scannerId  = $this->strip_tags($request->get('scannerid'));            //扫描仪SN码
        //必要条件
        if (empty($scannerId)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();
        try {
            $scannerCon = $this->getDoctrine ()->getRepository ( 'OradtStoreBundle:ScannerV2' )
                                 ->findOneBy ( array ( 'scannerId'=>$scannerId) );
            if(empty($scannerCon)){
                return $this->renderJsonFailed( Errors::$ERROR_PARAMETER_NOT_DATA );
            }
            $upParam    = array(
                ':scannerid'  =>$scannerId, //扫描仪id
                ':isdelete'  =>1,           //删除
            );
            $upmapSql = "UPDATE scanner_v2 SET isdelete=:isdelete WHERE scanner_id =:scannerid";
            $this->getConnection()->executeUpdate($upmapSql,$upParam);
            $em->getConnection()->commit();
            return $this->renderJsonSuccess();
        } catch (\Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }
    }
    
    /**
     * 扫描仪重启
     */
    public function  _ScannerV2Restart(){
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $adminId    = $this->accountId;
        $scannerId  = $this->strip_tags($request->get('scannerid'));            //扫描仪SN码
        //必要条件
        if (empty($scannerId)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();
        try {
            $scannerCon = $this->getDoctrine ()->getRepository ( 'OradtStoreBundle:ScannerV2' )
                                 ->findOneBy ( array ( 'scannerId'=>$scannerId) );
            if(empty($scannerCon)){
                return $this->renderJsonFailed( Errors::$ERROR_PARAMETER_NOT_DATA );
            }
            $upParam    = array(
                ':scannerid'  =>$scannerId, //扫描仪id
                ':isrestart'  =>1, //重启
            );
            $upmapSql = "UPDATE scanner_v2_user_map SET is_restart=:isrestart WHERE scanner_id =:scannerid";
            $this->getConnection()->executeUpdate($upmapSql,$upParam);
            $em->getConnection()->commit();
            return $this->renderJsonSuccess();
        } catch (\Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }
    }
    
    
    /**
     * 计算2个日期间隔天数
     * @param $day  int 最后使用日期
     */
    public function diffBetweenTwoDays ($day){
        $nowTime = $this->getTimestamp();
        $day1   = date("Y-m-d",$nowTime);       //当前日期
        $day2   = date("Y-m-d",$day);           //到期日期
        $datetime1  = date_create($day1);  
        $datetime2  = date_create($day2);  
        $interval   = date_diff($datetime1,$datetime2);
        return $interval->format('%a');
    }
    /**
     * 扫描仪使用统计
     */
    public function _ScannerV2StatistisList(){
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $id   = $this->strip_tags($request->get('id'));       //扫描仪编号
        if (empty($id)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        //查询编号是否存在
        $lastSql    = "SELECT id,scanner_id,last_use_time,create_time FROM scanner_v2 WHERE id =:id;";
        $scannerCon = $this->getConnection()->executeQuery($lastSql, array(":id"=>$id))->fetch();
        if(empty($scannerCon)){
            return $this->renderJsonFailed( Errors::$ERROR_PARAMETER_NOT_DATA );
        }
        $retArr = array();
        //最新使用时间
        $retArr['lastusetime'] = $scannerCon['last_use_time'];
        //多少天未使用
        $lastUseTime = !empty($scannerCon['last_use_time'])? $scannerCon['last_use_time'] : $scannerCon['create_time'];
        $retArr['unuseddays']  = $this->diffBetweenTwoDays($lastUseTime);
        
        //累计使用人数
        $lastSql    = "SELECT COUNT(DISTINCT user_id) as num FROM scanner_v2_user_map_log where scanner_id =:scannerid;";
        $usersArr   = $this->getConnection()->executeQuery($lastSql, array(":scannerid"=>$scannerCon['scanner_id']))->fetch();
        $retArr['usersnumber'] = isset($usersArr['num']) ? $usersArr['num'] : 0;
        //累计使用次数
        $lastSql    = "SELECT COUNT(id) as num FROM scanner_v2_user_map_log where scanner_id =:scannerid;";
        $useArr     = $this->getConnection()->executeQuery($lastSql, array(":scannerid"=>$scannerCon['scanner_id']))->fetch();
        $retArr['usecount'] = isset($useArr['num']) ? $useArr['num'] : 0;
        //累计扫描张数
        $lastSql    = "SELECT COUNT(id) as num FROM scanner_v2_user_map_card_log where scanner_id =:scannerid;";
        $cardArr    = $this->getConnection()->executeQuery($lastSql, array(":scannerid"=>$scannerCon['scanner_id']))->fetch();
        $retArr['scancount'] = isset($cardArr['num']) ? $cardArr['num'] : 0;
        return $this->renderJsonSuccess ( $retArr );
    }
    
    
    /**
     * 编辑扫描仪设备
     */
    public function  _postEditScannerV2(){
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $adminId    = $this->accountId;
        $Id         = $this->strip_tags($request->get('id'));                   //编号
        $scannerId  = $this->strip_tags($request->get('scannerid'));            //扫描仪SN码
        $type       = (int)$this->strip_tags($request->get('type'));            //设备性质（1、公司发放2售出）
        $province   = $this->strip_tags($request->get('province',''));          //发放省份
        $city       = $this->strip_tags($request->get('city',''));              //发放城市
        $address    = $this->strip_tags($request->get('address',''));           //详细地址
        $loctype    = (int)$this->strip_tags($request->get('loctype',2));       //场所类型:1酒店、2咖啡厅（默认）、3商城、4机场、5其他（默认）
        $ownername  = $this->strip_tags($request->get('ownername',''));         //公司/个人名称
        $contactname = $this->strip_tags($request->get('contactname',''));      //联系人
        $contactinfo = $this->strip_tags($request->get('contactinfo',''));      //联系电话
        $state       = (int)$this->strip_tags($request->get('state',1));        //设备状态:1正常（默认）2 故障 3已收回
        //必要条件
        if (empty($Id) || empty($scannerId)  || empty($type)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        //检测参数loctype
        if(!empty($loctype) && !in_array($loctype, array(1,2,3,4,5))){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMTER_ERROR,"paramter loctype values");
        }
        //检测参数state
        if(!empty($state) && !in_array($state, array(1,2,3))){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMTER_ERROR,"paramter state values");
        }
        
        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();
        try {
            $scannerCon = $this->getDoctrine ()->getRepository ( 'OradtStoreBundle:ScannerV2' )
                                 ->findOneBy ( array ( 'id' => $Id ,'type'=>$type,'scannerId'=>$scannerId) );
            if(empty($scannerCon)){
                return $this->renderJsonFailed( Errors::$ERROR_PARAMETER_NOT_DATA );
            }
            
            if(!empty($province)) $scannerCon->setProvince($province);
            if(!empty($city)) $scannerCon->setCity($city);
            if(!empty($address)) $scannerCon->setAddress($address);
            if(!empty($loctype)) $scannerCon->setLoctype($loctype);
            if(!empty($ownername)) $scannerCon->setOwnername($ownername);
            if(!empty($contactname)) $scannerCon->setContactName($contactname);
            if(!empty($contactinfo)) $scannerCon->setContactInfo($contactinfo);
            if(!empty($state)) $scannerCon->setState($state);
            
            $em->persist($scannerCon);
            $em->flush();
            $em->getConnection()->commit();
            return $this->renderJsonSuccess();
        } catch (\Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }
    }
    
    /**
     * 新增扫描仪
     */
    public function  _postAddScannerV2(){
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $adminId    = $this->accountId;
        $scannerId  = $this->strip_tags($request->get('scannerid'));            //扫描仪SN码
        $type       = (int)$this->strip_tags($request->get('type'));            //设备性质（1、公司发放2售出）
        $province   = $this->strip_tags($request->get('province',''));          //发放省份
        $city       = $this->strip_tags($request->get('city',''));              //发放城市
        $address    = $this->strip_tags($request->get('address',''));           //详细地址
        $loctype    = (int)$this->strip_tags($request->get('loctype',2));       //场所类型:1酒店、2咖啡厅（默认）、3商城、4机场、5其他（默认）
        $ownername  = $this->strip_tags($request->get('ownername',''));         //公司/个人名称
        $contactname = $this->strip_tags($request->get('contactname',''));      //联系人
        $contactinfo = $this->strip_tags($request->get('contactinfo',''));      //联系电话
        $state       = (int)$this->strip_tags($request->get('state',1));        //设备状态:1正常（默认）2 故障 3已收回
        
        //必要条件
        if (empty($scannerId) || empty($type) || !in_array($type, array(1,2))) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        if(empty($loctype))     $loctype = 2;
        if(empty($state))       $state   = 1;
        //如果type=1 公司发放的扫码仪
        if($type == 1){
            if(empty($address))  return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }else {  //售出扫描仪
            if(empty($ownername) || empty($contactname) || empty($contactinfo))  return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        //查询 scannerid 是否唯一
        $lastSql = "SELECT id FROM scanner_v2 WHERE scanner_id =:scannerid;";
        $lastRecord = $this->getConnection()->executeQuery($lastSql, array(":scannerid"=>$scannerId))->fetch();
        if(!empty($lastRecord)){
            return $this->renderJsonFailed(Errors::$ACCOUNT_ADMIN_SCANNER_EXISTS);
        }
        //检测参数loctype
        if(!empty($loctype) && !in_array($loctype, array(1,2,3,4,5))){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMTER_ERROR,"paramter loctype values");
        }
        //检测参数state
        if(!empty($state) && !in_array($state, array(1,2,3))){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMTER_ERROR,"paramter state values");
        }
        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();
        try {
            $createTime = $this->getTimestamp();
            $scannerv2 = new ScannerV2();
            $scannerv2->setScannerid($scannerId);
            $scannerv2->setType($type);
            $scannerv2->setProvince($province);
            $scannerv2->setCity($city);
            $scannerv2->setAddress($address);
            $scannerv2->setLoctype($loctype);
            $scannerv2->setOwnername($ownername);
            $scannerv2->setContactName($contactname);
            $scannerv2->setContactInfo($contactinfo);
            $scannerv2->setState($state);
            $scannerv2->setLastModiy(0);
            $scannerv2->setCreateTime($createTime);
            $scannerv2->setFirstUseTime(0);
            $scannerv2->setLastUseTime(0);
            $scannerv2->setReportType(0);
            $scannerv2->setReportTime(0);
            $scannerv2->setIsdelete(0);
            //保存扫描仪信息
            $em->persist($scannerv2);
            $em->flush();
            $em->getConnection()->commit();
            $data = array( 
                'id'   => $scannerv2->getId()
            );
            return $this->renderJsonSuccess($data);
        } catch (\Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }
    }
    
    
    public function getAction ($act)
    {
        switch ($act){
            case 'list':
                return $this->_getScannerV2List();              //获取扫描仪设备列表
                break;
            case 'uselist':
                return $this->_getScannerV2UseList();            //获取扫描仪设备使用列表
                break;
            case 'location':
                return $this->_getScannerV2Location();           //定位查询
                break;
            case 'buglist':
                return $this->_getScannerV2BugList();            //故障历史记录
                break;
            case 'balance':
                return $this->_getScannerV2Balance();            //获取手机话费 流量信息
                break;
            case 'getreminduser':
                return $this->_getScannerV2RemindUser();         //余额提醒联系人
                break;
            default:
                return $this->renderJsonFailed(Errors::$HTTP_STATUS_CODE_404);
                break;
        }
    }
    
    /**
     * 余额提醒-获取余额提醒联系人
     */
    public function _getScannerV2RemindUser(){
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $sqldata = array(
            'fields' => array(
                'id'        => array('mapdb' =>'s.id'),
                'name'      => array('mapdb' =>'s.name'),
                'email'     => array('mapdb' =>'s.email'),
                'mobile'    => array('mapdb' =>'s.mobile'),
                'createtime' => array('mapdb' =>'s.create_time')
            ),
            'sql'   => 'SELECT %s FROM scanner_v2_balance_remind_users as s %s%s',
            'where' => '',
            'order' => ' ORDER BY s.id DESC',
            'default_dataparam'     => array(),
            'provide_max_fields'    => 'id,name,email,mobile,createtime',
        );
        $check = $this->parseSql ( $sqldata );
        if (true !== $check){
            return $this->renderJsonFailed ( $check );
        }
        $data = $this->getData ( $sqldata, 'list');
        return $this->renderJsonSuccess($data);
    }
    
    /**
     * 余额提醒-获取余额
     */
    public function _getScannerV2Balance(){
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $sqldata = array(
            'fields' => array(
                'id'        => array('mapdb' =>'s.id'),
                'mobile'    => array('mapdb' =>'s.mobile'),
                'flow'      => array('mapdb' =>'s.flow'),
                'price'     => array('mapdb' =>'s.price'),
                'remindprice' => array('mapdb' =>'s.remind_price')
            ),
            'sql'   => 'SELECT %s FROM scanner_v2_balance as s %s%s',
            'where' => '',
            'order' => ' ORDER BY s.id DESC',
            'default_dataparam'     => array(),
            'provide_max_fields'    => 'id,mobile,flow,price,remindprice',
        );
        $check = $this->parseSql ( $sqldata );
        if (true !== $check){
            return $this->renderJsonFailed ( $check );
        }
        $data = $this->getData ( $sqldata, 'list');
        return $this->renderJsonSuccess($data);
    }
    
    /**
     * 故障历史记录
     */
    public function _getScannerV2BugList(){
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $sqldata = array(
            'fields' => array(
                'bugid'     => array('mapdb' =>'s.id',  'w'=>' AND s.id = :bugid'),
                'scannerid' => array('mapdb' =>'s.scanner_id',  'w'=>' AND s.scanner_id = :scannerid'),
                'startime'  => array('mapdb' =>'s.from_time','w'=>'Range'),
                'endtime'   => array('mapdb' =>'s.to_time','w'=>'Range'),
                'type'      => array('mapdb' =>'s.type')
            ),
            'sql'   => 'SELECT %s FROM scanner_v2_report_bug as s %s%s',
            'where' => '',
            'order' => ' ORDER BY s.id DESC',
            'default_dataparam'     => array(),
            'provide_max_fields'    => 'bugid,scannerid,startime,endtime,type',
        );
        $check = $this->parseSql ( $sqldata );
        if (true !== $check){
            return $this->renderJsonFailed ( $check );
        }
        $data = $this->getData ( $sqldata, 'list');
        return $this->renderJsonSuccess($data);
    }
    
    
    /**
     * 定位查询
     */
    public function _getScannerV2Location(){
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $sqldata = array(
            'fields' => array(
                'id'            => array('mapdb' =>'s.id',  'w'=>' AND s.id = :id'),
                'scannerid'     => array('mapdb' =>'s.scanner_id',  'w'=>' AND s.scanner_id = :scannerid'),
                'province'      => array('mapdb' =>'s.province',  'w'=>' AND s.province like :province'),
                'city'          => array('mapdb' =>'s.city',  'w'=>' AND s.city like :city'),
                'address'       => array('mapdb' =>'s.address'),
                'latitude'      => array('mapdb' =>'s.latitude'),
                'longitude'     => array('mapdb' =>'s.longitude')
            ),
            'sql'   => 'SELECT %s FROM scanner_v2_location as s %s%s',
            'where' => '',
            'order' => ' ORDER BY s.id DESC',
            'default_dataparam'     => array(),
            'provide_max_fields'    => 'id,scannerid,province,city,address,latitude,longitude',
        );
        $check = $this->parseSql ( $sqldata );
        if (true !== $check){
            return $this->renderJsonFailed ( $check );
        }
        $data = $this->getData ( $sqldata, 'list');
        return $this->renderJsonSuccess($data);
    }

    /**
     * 获取扫描仪使用列表
     */
    public function _getScannerV2UseList(){
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $sqldata = array(
            'fields' => array(
                'id'            => array('mapdb' =>'l.id',  'w'=>' AND l.id = :id'),
                'scannerid'     => array('mapdb' =>'l.scanner_id',  'w'=>' AND l.scanner_id = :scannerid'),
                'usetime'       => array('mapdb' =>'l.create_time'),
                'scancount'     => array('mapdb' =>'c.num'),
                'name'          => array('mapdb' =>'d.real_name'),
                'mobile'        => array('mapdb' =>'b.mobile')
            ),
            //'sql'   => 'SELECT %s FROM scanner_v2 as s %s%s',
            'sql'   => 'SELECT %s FROM scanner_v2_user_map_log AS l
                    LEFT JOIN account_basic b ON l.user_id = b.user_id
                    LEFT JOIN account_basic_detail as d ON l.user_id = d.user_id
                    LEFT JOIN (SELECT map_id,COUNT(id) as num FROM scanner_v2_user_map_card_log GROUP BY map_id) AS c ON l.id = c.map_id %s%s',
            'where' => '',
            'order' => ' ORDER BY l.id DESC',
            'default_dataparam' => array(),
            'provide_max_fields' => 'id,scannerid,usetime,scancount,name,mobile',
        );
        $check = $this->parseSql ( $sqldata );
        if (true !== $check){
            return $this->renderJsonFailed ( $check );
        }
        $data = $this->getData ( $sqldata, 'list','callable_data_list');
        return $this->renderJsonSuccess($data);
    }
    
    /**
     * 处理回显参数信息
     */
    protected function callable_data_list($item){
        if ($item ['scancount'] == null)      $item ['scancount'] = 0;
        $item ['scancount'] = (int)$item ['scancount'];
        return $item;
    }
    
    /**
     * 获取扫描仪列表
     */
    public function _getScannerV2List(){
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $sqldata = array(
            'fields' => array(
                'id'            => array('mapdb' =>'s.id',  'w'=>' AND s.id = :id'),
                'scannerid'     => array('mapdb' =>'s.scanner_id',  'w'=>' AND s.scanner_id like :scannerid'),
                'type'          => array('mapdb' =>'s.type',  'w'=>' AND s.type = :type'),
                'province'      => array('mapdb' =>'s.province',  'w'=>' AND s.province like :province'),
                'city'          => array('mapdb' =>'s.city',  'w'=>' AND s.city like :city'),
                'address'       => array('mapdb' =>'s.address', 'w'=>' AND s.status = :status'),
                'loctype'       => array('mapdb' =>'s.loctype', 'w'=>' AND s.loctype = :loctype'),
                'ownername'     => array('mapdb' =>'s.ownername',  'w'=>' AND s.ownername like :ownername'),
                'contactname'   => array('mapdb' =>'s.contact_name'),
                'contactinfo'   => array('mapdb' =>'s.contact_info'),
                'state'         => array('mapdb' =>'s.state','w'=>' AND s.state = :state'),
                'firstusetime'  => array('mapdb' =>'s.first_use_time','w'=>'Range'),
                'lastusetime'   => array('mapdb' =>'s.last_use_time','w'=>'Range'),
                'reporttype'    => array('mapdb' =>'s.report_type'),
                'reporttime'    => array('mapdb' =>'s.report_time')
            ),
            'sql'   => 'SELECT %s FROM scanner_v2 as s %s%s',
            'where' => ' s.isdelete != 1',
            'order' => ' ORDER BY s.id DESC',
            'default_dataparam' => array(),
            'provide_max_fields' => 'id,scannerid,type,province,city,address,loctype,ownername,contactname,contactinfo,state,firstusetime,lastusetime,reporttype,reporttime',
        );
        $check = $this->parseSql ( $sqldata );
        if (true !== $check){
            return $this->renderJsonFailed ( $check );
        }
        $data = $this->getData ( $sqldata, 'list');
        return $this->renderJsonSuccess($data);
    }
    
    
}

