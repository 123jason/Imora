<?php
namespace Oradt\AccountAdminBundle\Controller;


use Oradt\OauthBundle\Controller\BaseController;
use Oradt\StoreBundle\Entity\Scanner;
use Oradt\StoreBundle\Entity\ScannerUseHistory;
use Oradt\Utils\Errors;


class ScannerController  extends BaseController{
    private $scanner_cache_pre = 'scanner';
    
    public function postAction($act){
        switch ($act) {
            case 'add':
                return $this->_postAddScanner();          //新增扫描仪
                break;
            case 'edit':
                return $this->_postEditScanner();         //编辑扫描仪
                break;
            case 'del':
                return $this->_postDeleteScanner();       //删除扫描仪
                break;
            case 'operate':
                return $this->_postOperateScanner();      //扫描仪的外放 和 回收
                break;
            case 'import':
                return $this->_postimportScanner();       //导入扫描仪
                break;
            default:
                return $this->renderJsonFailed( Errors::$ERROR_PARAMETER_NOT_ENOUGH );
                break;
        }
    }
    /**
     * 扫描仪的外放 和 回收
     */
    public function _postOperateScanner(){
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $adminId    = $this->accountId;
        $ids        = $this->strip_tags($request->get('id'));            //编号ID
        $action     = $this->strip_tags($request->get('action'));        //操作行为  1：外放 2：回收
        if (empty ( $ids ) || empty ( $action ) || !in_array($action, array('1','2'))) {
            return $this->renderJsonFailed( Errors::$ERROR_PARAMETER_NOT_ENOUGH );
        }
        $adminName  = $this->_getRealNameByAccountId($adminId);
        $time       = $this->getTimestamp();
        $idsArr     = explode(',', $ids);
        
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();                               //添加事物
        try{
            //外放
            if($action == '1'){
                $type       = $this->strip_tags($request->get('type'));             //类型 1：企业 2：公共场合
                $bizid      = $this->strip_tags($request->get('bizid'));            //企业id
                $bizname    = $this->strip_tags($request->get('bizname'));          //企业名称
                $address    = $this->strip_tags($request->get('address'));          //地址
                if (empty ( $type ) || empty ( $bizname ) || empty ( $address ) ) {
                    return $this->renderJsonFailed( Errors::$ERROR_PARAMETER_NOT_ENOUGH );
                }
                if(empty($bizid))   $bizid = '';
                foreach ($idsArr as $id){
                    $scanCon = $this->getScannerConById($id);        //查找扫描仪是否存在
                    if(empty($scanCon))                     continue;
                    if($scanCon['status'] != '1')           continue;   //不是空闲的不能外派

                    $useScan = new ScannerUseHistory;
                    $useScan->setScannerId($scanCon['scannerid']);
                    $useScan->setType($type);
                    $useScan->setStartime($time);
                    $useScan->setEndtime(0);
                    $useScan->setBizId($bizid);
                    $useScan->setBizName($bizname);
                    $useScan->setAddress($address);
                    $useScan->setOutAdminId($adminId);      //外放
                    $useScan->setOutAdminName($adminName);
                    $useScan->setInAdminId('');             //回收
                    $useScan->setInAdminName('');
                    //保存外放记录信息
                    $em->persist($useScan);
                    $em->flush();
                    $recordId = $useScan->getId();      //使用记录id
                    //更新扫描仪表 记录外放使用id
                    $updateParams = array(':id'=>$id,':recordid'=>$recordId);
                    $updateSql    = "UPDATE scanner SET status = 2,recordid=:recordid WHERE id =:id";
                    $this->getConnection()->executeUpdate($updateSql, $updateParams);
                    //设置扫描仪外放 缓存 
                    $scanner_cacheKey = $this->getCacheKeyByApi($scanCon['scannerid'],$this->scanner_cache_pre);
                    $cacheArr = array(
                        'id'       => $id,
                        'scannerid'=> $scanCon['scannerid'],
                        'recordid' => $recordId,
                        'status'   => 2,
                        'biz_id'   => $bizid
                    );
                    $this->hmSetCache($scanner_cacheKey,$cacheArr);
                }
            }
            //回收
            if($action == '2'){
                foreach ($idsArr as $id){
                    $scanCon = $this->getScannerConById($id);        //查找扫描仪是否存在
                    if(empty($scanCon))                     continue;
                    if(empty($scanCon['recordid']))         continue;   //不是空闲的不能外派
                    //1--更新扫描仪记录外放表 回收人信息 及回收时间
                    $upUseParams = array(
                        ':id'           =>$scanCon['recordid'],
                        ':endtime'      =>$time,
                        ':in_admin_id'   =>$adminId,
                        ':in_admin_name' =>$adminName,
                    );
                    $upUseSql    = "UPDATE scanner_use_history SET endtime =:endtime,in_admin_id=:in_admin_id,in_admin_name=:in_admin_name WHERE id =:id";
                    $this->getConnection()->executeUpdate($upUseSql, $upUseParams);
                    //2--更新扫描仪表 清空 外放记录id 和 扫描仪状态
                    $upScanParams = array(':id'=>$id,':recordid'=>0,':status'=>1);
                    $upScanSql    = "UPDATE scanner SET status=:status,recordid=:recordid WHERE id =:id";
                    $this->getConnection()->executeUpdate($upScanSql, $upScanParams);
                    //删除扫描仪外放 缓存记录
                    $scanner_cacheKey = $this->getCacheKeyByApi($scanCon['scannerid'],$this->scanner_cache_pre);
                    $this->removeCache($scanner_cacheKey);
                }
            }
            $em->getConnection()->commit();
            return $this->renderJsonSuccess();
        }catch (\Exception $e) {
            throw $e;
            $em->getConnection()->rollback();
            return $this->renderJsonFailed(Errors::$ERROR_UNKNOWN);
        }
    }
    /**
     * @param $id int 编号id
     */
    public function getScannerConById($id){
        if(empty($id))     return '';
        $lastSql = "SELECT id,scannerid,status,recordid FROM scanner WHERE id =:id;";
        $lastRecord = $this->getConnection()->executeQuery($lastSql, array(":id"=>$id))->fetch();
        if(!empty($lastRecord)){
            return $lastRecord;
        }
        return '';
    }

    /**
     * 删除扫描仪
     */
    public function _postDeleteScanner(){
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $adminId    = $this->accountId;
        $ids        = $this->strip_tags($request->get('id'));            //编号ID
        if (empty ( $ids )) {
            return $this->renderJsonFailed( Errors::$ERROR_PARAMETER_NOT_ENOUGH );
        }
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();                               //添加事物
        try{
            $idsArr = explode(',', $ids);
            foreach ($idsArr as $id){
                $scanCon = $this->getScannerConById($id);        //查找扫描仪是否存在
                if(empty($scanCon))                    continue;
                if($scanCon['status'] == '2')          continue;  //如果扫描仪正在使用中 ，则不能删除
              
                $updateParams = array(':id'=>$id);
                $updateSql    = "UPDATE scanner SET status = 4 WHERE id =:id";
                $this->getConnection()->executeUpdate($updateSql, $updateParams);
            }
            $em->getConnection()->commit();
            return $this->renderJsonSuccess();
        }catch (\Exception $e) {
            $em->getConnection()->rollback();
            return $this->renderJsonFailed(Errors::$ERROR_UNKNOWN);
        }
    }

    /**
     * 新增扫描仪
     */
    public function  _postAddScanner(){
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $adminId    = $this->accountId;
        $scannerId  = $this->strip_tags($request->get('scannerid'));            //扫描仪ID
        $mac        = $this->strip_tags($request->get('mac'));                  //MAC地址
        $passwd     = $this->strip_tags($request->get('passwd'));          //密码
        $model      = $this->strip_tags($request->get('model'));           //型号
        $type       = $this->strip_tags($request->get('type'));
        if (empty($type)) 
            $type = 2;
        //必要条件
        if (empty($scannerId) || empty($passwd)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        //查询 scannerid 是否唯一
        $lastSql = "SELECT id FROM scanner WHERE scannerid =:scannerid AND status != 4;";
        $lastRecord = $this->getConnection()->executeQuery($lastSql, array(":scannerid"=>$scannerId))->fetch();
        if(!empty($lastRecord)){
            return $this->renderJsonFailed(Errors::$ACCOUNT_ADMIN_SCANNER_EXISTS);
        }
        $createTime = $this->getTimestamp();
        $adminName  = $this->_getRealNameByAccountId($adminId);
        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();
        try {
            $scanner = new Scanner();
            $scanner->setScannerid($scannerId);
            $scanner->setMac($mac);
            $scanner->setPasswd($passwd);
            $scanner->setModel($model);
            $scanner->setStatus(1);
            $scanner->setCreatetime($createTime);
            $scanner->setRecordid(0);
            $scanner->setAdminid($adminId);
            $scanner->setRealname($adminName);
            $scanner->setType($type);
            //保存扫描仪信息
            $em->persist($scanner);
            $em->flush();
            $em->getConnection()->commit();
            $data = array( 
                'id'   => $scanner->getId()
            );
            return $this->renderJsonSuccess($data);
        } catch (\Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }
    }
    
    /**
     * 导入扫描仪
     */
    public function _postimportScanner()
    {
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $adminId    = $this->accountId;
        $scannerId  = $this->strip_tags($request->get('scannerid'));            //扫描仪ID
        $mac        = $this->strip_tags($request->get('mac'));                  //MAC地址
        $passwd     = $this->strip_tags($request->get('passwd'));          //密码
        $type       = $this->strip_tags($request->get('type'));
        if (empty($type)) 
            $type = 2;
        //必要条件
        if (empty($scannerId)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $createTime = $this->getTimestamp();
        $adminName  = $this->_getRealNameByAccountId($adminId);
        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();
        try {
            $scannerids = explode(',', $scannerId);
            $fail = array();
            foreach ($scannerids as $sid) {
                if (empty($sid)) 
                    continue;
                //检测是否存在
                $scanService = $this->container->get("account_admin_service");
                $resCheck    = $scanService->checkSid($sid);
                if ($resCheck) {
                    $fail[] = $sid;
                }else{
                    $scanner = new Scanner();
                    $scanner->setScannerid($sid);
                    $scanner->setMac($mac);
                    $scanner->setPasswd($passwd);
                    $scanner->setModel('');
                    $scanner->setStatus(1);
                    $scanner->setCreatetime($createTime);
                    $scanner->setRecordid(0);
                    $scanner->setAdminid($adminId);
                    $scanner->setRealname($adminName);
                    $scanner->setType($type);
                    //保存扫描仪信息
                    $em->persist($scanner);
                    $em->flush();
                }
            }                
            $em->getConnection()->commit();
            $data = array( 
                'fail'   => $fail,
            );
            return $this->renderJsonSuccess($data);
        } catch (\Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }
    }
    /**
     * 编辑扫描仪
     */
    public function  _postEditScanner(){
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $adminId    = $this->accountId;
        $Id         = $this->strip_tags($request->get('id'));                   //编号ID
        $scannerId  = $this->strip_tags($request->get('scannerid'));            //扫描仪ID
        $mac        = $this->strip_tags($request->get('mac'));                  //MAC地址
        $passwd     = $this->strip_tags($request->get('passwd'));               //密码
        $model      = $this->strip_tags($request->get('model'));                //型号
        $status     = (int)$this->strip_tags($request->get('status'));               //状态 1：空闲 2：使用中 3：损坏
        $type       = $this->strip_tags($request->get('type'));
        //必要条件
        if (empty($Id) || empty($scannerId)  || empty($passwd)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        if(!empty($status) && !in_array($status, array(1,2,3))){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_FORMAT);
        }
        if (!empty($type) && !in_array($type, array(1,2))) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_FORMAT);
        }
        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();
        try {
            $scannerCon = $this->getDoctrine ()->getRepository ( 'OradtStoreBundle:Scanner' )
                                 ->findOneBy ( array ( 'id' => $Id ) );
            if(empty($scannerCon)){
                return $this->renderJsonFailed( Errors::$ERROR_PARAMETER_NOT_DATA );
            }
            //判断scannerid 扫描仪ID 是否和提交上来的相同 若不同则修改 若相同 则不修改
            $oldScannerId = $scannerCon->getScannerid();
            if(!empty($scannerId)){
                if($scannerId != $oldScannerId){
                    //查询 scannerid 是否唯一
                    $lastSql = "SELECT id FROM scanner WHERE scannerid =:scannerid AND status != 4;";
                    $lastRecord = $this->getConnection()->executeQuery($lastSql, array(":scannerid"=>$scannerId))->fetch();
                    if(!empty($lastRecord)){
                        return $this->renderJsonFailed(Errors::$ACCOUNT_ADMIN_SCANNER_EXISTS);
                    }
                    $scannerCon->setScannerid($scannerId);
                }
            }
            if(!empty($mac))        $scannerCon->setMac($mac);
            if(!empty($passwd))     $scannerCon->setPasswd($passwd);
            if(!empty($model))      $scannerCon->setModel($model);
            $nowStatus = $scannerCon->getStatus();  //获取当前状态
            if(!empty($status)){
                if($nowStatus == $status){
                    $scannerCon->setStatus($status);
                }else{
                    if($status == '1' && $nowStatus != '2'){  //将非使用中的扫描仪改为空闲状态
                        $scannerCon->setStatus($status);
                    }elseif($status == '3' && $nowStatus != '2'){ //将空闲的扫描仪改为损坏状态
                        $scannerCon->setStatus($status);
                    }
                }
            }
            if (!empty($type)) 
                $scannerCon->setType($type);
            //exit;
            $em->persist($scannerCon);
            $em->flush();
            $em->getConnection()->commit();
            return $this->renderJsonSuccess();
        } catch (\Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }
    }
    private function _getRealNameByAccountId($accountId){
        if(empty($accountId))     return "";
        $sql  = "SELECT `real_name` FROM `account_employee` WHERE `empl_id` = :touserid";
        $param[":touserid"]  = $accountId;
        $row = $this->getConnection()->executequery($sql,$param)->fetch();
        $realName = "";
        if(!empty($row))   $realName = $row['real_name'];
        return $realName;
    }
    
    
    public function getAction ($act)
    {
        switch ($act)
        {
            case 'list':
                return $this->_getScannerList();            //获取扫描仪列表
                break;
            case 'userecord':
                return $this->_getScannerUseRecord();        //获取扫描仪外放使用记录列表
                break;
            case 'getbatch':                                 //获取扫描仪使用批次信息列表
                return $this->_getScannerBatchByBiz();
                break;
            case 'getscan':                                 //获取扫描仪扫描名片
                return $this->_getScanCardList();
                break;
            default:
                return $this->renderJsonFailed(Errors::$HTTP_STATUS_CODE_404);
                break;
        }
    }
    
    /**
     * 获取扫描仪扫描名片记录
     */
    public function _getScanCardList(){
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        $type = $request->get('type');
        if($this->accountType == self::ACCOUNT_BASIC){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $userId     = $this->accountId;
        $bizid      = '';
        if($this->accountType == self::ACCOUNT_BIZ){
            $where  = "s.bizid = '{$this->accountId}'";      //过滤掉删除
            $bizid  = $userId;
        }else{
            $where  = "";      //过滤掉删除
        }
        if ('elas' == $type) {
            $data = $this->elasBasic($request,$bizid);
        }else{                        
            $this->setManager("scandb");
            $sqldata = array(
                'fields' => array(
                    'scannerid'     => array('mapdb' =>'s.scannerid', 'w'=>' AND s.scannerid =:scannerid'),
                    'recordid'      => array('mapdb' =>'s.recordid', 'w'=>' AND s.recordid =:recordid'),
                    'bizid'         => array('mapdb' =>'s.bizid', 'w'=>' AND s.bizid =:bizid'),
                    'vcardid'       => array('mapdb' =>'s.vcardid', 'w'=>' AND s.vcardid IN (%s)'),
                    'batchid'       => array('mapdb' =>'s.batchid', 'w'=>' AND s.batchid =:batchid'),
                    'picture'       => array('mapdb' =>'se.pic_path_a'),
                    'vcard'         => array('mapdb' =>'se.vcard'),
                    'account'       => array('mapdb' =>'a.mobile', 'w'=>' AND a.mobile =:account'),
                    'accountname'   => array('mapdb' =>'b.real_name'),
                    'FN'            => array('mapdb' =>'sv.FN'),
                    'TEL'           => array('mapdb' =>'sv.TEL'),
                    'ORG'           => array('mapdb' =>'sv.ORG'),
                    'DEPAR'         => array('mapdb' =>'sv.DEPAR'),
                    'TITLE'         => array('mapdb' =>'sv.TITLE'),
                    'URL'           => array('mapdb' =>'sv.URL'),
                    'EMAIL'         => array('mapdb' =>'sv.EMAIL'),
                    'ADR'           => array('mapdb' =>'sv.ADR'),
                    'createtime'    => array('mapdb' =>'s.createtime','w'=>'Range')
                ),
                'sql'   => 'SELECT %s FROM `scan_bmiddle_scanner` as s
                            LEFT JOIN `scan_card_vcardinfo` as sv ON s.vcardid = sv.card_id
                            LEFT JOIN `scan_card_picture_ext` as se ON s.vcardid = se.cardid
                            LEFT JOIN `account_basic` as a ON s.accountid = a.user_id
                            LEFT JOIN `account_basic_detail` as b ON s.accountid = b.user_id %s%s',
                'where' => ''.$where,
                'order' => ' ORDER BY s.id DESC',
                'default_dataparam' => array(),
                'provide_max_fields' => 'scannerid,recordid,bizid,vcardid,batchid,picture,vcard,account,accountname,FN,TEL,ORG,DEPAR,TITLE,URL,EMAIL,ADR,createtime',
            );
            $check = $this->parseSql ( $sqldata );
            if (true !== $check){
                return $this->renderJsonFailed ( $check );
            }
            $data = $this->getData ( $sqldata, 'list','callable_data_cardlist');
        }              
        return $this->renderJsonSuccess($data);
    }
    /**
     * elasticsearch——basic：params
     * 精确：scannerid   扫描仪ID
     *     ：recordid    外放记录ID
     *     ：vcardid     名片ID
     *     ：batchid     批次号ID
     *     ：account     扫描用户(手机号)
     *     ： 
     * 模糊：
     *     ：
     * 范围：
     *     ：createdtime 名片创建时间 
     */
    public function elasBasic($request,$accountId)
    {
        $params    = array();
        //精准
        $accurate = array(
            'scannerid'=>'scannerid',
            'recordid' =>'recordid',            
            'batchid'=>'batchid',
            'bizid'=>'bizid',
            'account'  =>'mobile',
        );
        if (!empty($accountId)) {
            $accurate['bizid'] = 'bizid';
        }
        //模糊
        $fuzzy    = array(
            'vcard'=>'vcard',
            'accountname'=>'real_name',
        );
        //范围
        $range    = array(
            // 'modifiedtime'=>'last_modified',
            'createdtime'=>'createtime'
        );
        //in should
        $should   = array(
            'vcardid'=>'vcardid',
            'id'       =>'id',
            );
        /**
         * 精确查询,mapping的时候不分词
         */
        foreach ($accurate as $key => $value) {
            $newKey =  $request->get($key);
            if (isset($newKey) && !empty($newKey)) {
                $params['must'][]['match'] = array(
                    $value =>array(
                        "query"=>$newKey,
                        "operator"=>'and'
                    )
                );
            }
        }
        /**
         * 模糊查询
         */
        foreach ($fuzzy as $key => $value) {
            $newKey =  $request->get($key);
            if (isset($newKey) && !empty($newKey)) {
                $params['must'][]['match'] = array(
                    $value =>array(
                        "query"=>$newKey,
                        "minimum_should_match"=>"75%",
                    )
                );       
            }
        }
        /**
         * 范围查询
         */
        foreach ($range as $key => $value) {
            $newKey =  $request->get($key);
            if (isset($newKey) && !empty($newKey)) {
                $comd  = $newKey;
                $comds = explode(',', $comd);
                $count = count($comds);
                if (2 == $count) {
                    if (isset($comds[0]) && !empty($comds[1])) {
                            $from = $comds[0];
                            $to   = $comds[1];
                    }else{
                            $to  = $comds[1];                    
                    }
                }else{
                        $from = $comds[0];
                }
                if (isset($from) && !empty($from)) 
                $params['must'][]['range'][$value]['from'] = $from;
                if (isset($to) && !empty($to))
                $params['must'][]['range'][$value]['to']   = $to;
            }
        }
        //in查询
        foreach ($should as $key => $value) {
            $newKey =  $request->get($key);
            if (isset($newKey) && !empty($newKey)) {
                $newKeys = explode(',', $newKey);
                foreach ($newKeys as $k => $val) {
                    $params['must'][]['match'] = array(
                        $value =>array(
                            "query"=>$val,
                            "operator"=>'and'
                        )
                    );         
                }                 
            }
        }
        /**
         * size | start
         */
        $size = $request->get('rows');
        $from = $request->get('start');
        $sort = $request->get('sort');
        if (!empty($size)) 
            $params['size'] = $size;
        if (!empty($from)) 
            $params['from'] = $from;
        if (!empty($sort)) {
            $params['sort'] = $sort;
        }
        $elastic = $this->container->get('elasticsearch_service');
        $index   = $this->container->getParameter('ELAS_SCANER_INDEX');
        $type    = $this->container->getParameter('ELAS_SCANER_TYPE');
        $result  = $elastic->search($index,$type,$params);
        /**
         * 处理result的值
         */
        if (isset($result['error']) && !empty($result['error'])) {
            return array();
        }
        $numfound= $result['hits']['total'];
        if (0 !=$numfound && empty($result['hits']['hits'])) {
            $numfound = 0;
        }
        if (0 == $numfound) {
             $data = array(
                'numfound'=>0
                );
        }else{
            $contactService = $this->container->get('account_contact_service');            
            $hits = $result['hits']['hits'];
            foreach ($hits as $key => $value) {
                $vcards[] = $value['_source'];
            }
            if (!empty($vcards)) {
                foreach ($vcards as $k => &$val) {
                    if (isset($val['userid']) && !empty($val['userid'])) {                        
                        $content = $contactService->getcontent($val['userid'],$val['vcardid']);
                        if (!empty($content) || false != $content) {
                            $vcard = $contactService->getprivacycard($val['vcard'],$content);
                            if (false != $vcard || !empty($vcard)) {
                                $val['vcard'] = $vcard;
                            }
                        }
                    }
                    if (!empty($val['pic_path_a'])) {
                        $val['picture'] = $this->getCommondUrl($val['pic_path_a']);
                    }
                    if (!isset($val['accountname'])) {
                        if (isset($val['real_name'])) {
                            $val['accountname'] = $val['real_name'];
                        }else{
                            $val['accountname'] = '';
                        }
                    }
                    if (!isset($val['account'])) {
                        if (isset($val['mobile'])) {
                            $val['account'] = $val['mobile'];
                        }else{
                            $val['account'] = '';
                        }
                    }
                }
            }
            $data = array(
                'numfound'=>$numfound,
                'start'   =>(int)$from,
                'vcards'  =>$vcards,
                );
        }
         return $data;
    }
    /**
     * 处理回显参数信息
     */
    protected function callable_data_cardlist($item){
        $item['picture'] = $this->getCommondUrl($item['picture']);
        return $item;
    }
    /**
     * 获取扫描仪外放使用记录
     */
    public function _getScannerUseRecord(){
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $scannerId  = $this->strip_tags($request->get('scannerid'));            //扫描仪ID
        //必要条件
        if (empty($scannerId)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $sqldata = array(
            'fields' => array(
                'recordid'      => array('mapdb' =>'s.id',  'w'=>' AND s.id = :recordid'),
                'scannerid'     => array('mapdb' =>'s.scanner_id',  'w'=>' AND s.scanner_id = :scannerid'),
                'startime'      => array('mapdb' =>'s.startime'),
                'endtime'       => array('mapdb' =>'s.endtime'),
                'bizid'         => array('mapdb' =>'s.biz_id','w'=>' AND s.biz_id = :bizid'),
                'bizname'       => array('mapdb' =>'s.biz_name'),
                'address'        => array('mapdb' =>'s.address'),
                //'cardnum'       => array('mapdb' =>'s.startime')
            ),
            'sql'   => 'SELECT  %s FROM `scanner_use_history` AS s %s%s',
            'where' => ' ',
            'order' => ' ORDER BY s.id DESC',
            'default_dataparam' => array(),
            'provide_max_fields' => 'recordid,scannerid,startime,endtime,bizid,bizname,address',
        );
        $check = $this->parseSql ( $sqldata );
        if (true !== $check){
            return $this->renderJsonFailed ( $check );
        }
        $data = $this->getData ( $sqldata, 'list','callable_data_uselist');
        return $this->renderJsonSuccess($data);
    }
    /**
     * 处理回显参数信息
     */
    protected function callable_data_uselist($item){
        $reArr  = array(":recordid"=>$item ['recordid']);
        $sql    = "SELECT count(DISTINCT vcardid) AS num FROM scan_bmiddle_scanner WHERE recordid =:recordid;";
        $row    = $this->getManager('scandb')->getConnection()->executeQuery($sql, $reArr)->fetch();
        $item ['cardnum'] = $row['num'];
        return $item;
    }
    /**
     * 获取扫描仪列表
     */
    public function _getScannerList(){
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        //$userId     = $this->accountId;
        $where  = " s.status !=4";      //过滤掉删除
        $sqldata = array(
            'fields' => array(
                'id'            => array('mapdb' =>'s.id',  'w'=>' AND s.id = :id'),
                'scannerid'     => array('mapdb' =>'s.scannerid',  'w'=>' AND s.scannerid = :scannerid'),
                'mac'           => array('mapdb' =>'s.mac'),
                'passwd'        => array('mapdb' =>'s.passwd'),
                'model'         => array('mapdb' =>'s.model'),
                'status'        => array('mapdb' =>'s.status','w'=>' AND s.status = :status'),
                'bizid'         => array('mapdb' =>'su.biz_id','w'=>' AND su.biz_id = :bizid'),
                'bizname'       => array('mapdb' =>'su.biz_name'),
                'startime'      => array('mapdb' =>'su.startime','w'=>'Range'),
                'address'       => array('mapdb' =>'su.address'),
                'recordid'      => array('mapdb' =>'s.recordid'),
                'type'          => array('mapdb' =>'s.type','w'=>' AND s.type = :type')
            ),
            'sql'   => 'SELECT %s FROM scanner as s 
                        LEFT JOIN scanner_use_history as su ON s.recordid = su.id %s%s',
            'where' => ' '.$where,
            'order' => ' ORDER BY s.id DESC',
            'default_dataparam' => array(),
            'provide_max_fields' => 'id,scannerid,mac,passwd,model,status,bizid,bizname,startime,address,recordid,type',
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
        if ($item ['bizid'] == null)      $item ['bizid'] = '';
        if ($item ['bizname'] == null)    $item ['bizname'] = '';
        if ($item ['startime'] == null)   $item ['startime'] = '';
        if ($item ['address'] == null)     $item ['address'] = '';
        return $item;
    }
    
    /**
     * 获取扫描历史
     */
    public function _getScannerBatchByBiz()
    {
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_BIZ){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $bizId = $this->accountId;
        $where  = " a.bizid ='".$bizId."'";      //过滤掉删除
        $this->setManager("scandb");
        $sqldata = array(
            'fields' => array(
                'batchid'       => array('mapdb' =>'a.batchid',  'w'=>' AND a.batchid = :batchid'),
                'scannerid'     => array('mapdb' =>'a.scannerid',  'w'=>' AND a.scannerid = :scannerid'),
                'accountname'   => array('mapdb' =>'d.real_name'),
                'accountid'     => array('mapdb' =>'a.account_id'),
                'bizid'         => array('mapdb' =>'a.bizid'),
                'num'           => array('mapdb' =>'b.num'),
                'account'       => array('mapdb' =>'c.mobile'),
                'createtime'    => array('mapdb' =>'a.createtime','w'=>'Range'),
            ),
            //'sql'   => 'SELECT  %s FROM `contact_card_remark` AS a %s%s',
            'sql'   => 'SELECT %s FROM  scan_batch_number AS a LEFT JOIN
                        (SELECT sa.batchid,count(*) as num FROM scan_batch_number as sa 
                        LEFT JOIN scan_bmiddle_scanner as sb ON sa.batchid = sb.batchid GROUP BY sa.batchid) AS b ON a.batchid = b.batchid
                        LEFT JOIN account_basic as c on a.account_id = c.user_id
                        LEFT JOIN account_basic_detail as d on a.account_id = d.user_id
                        %s%s',
            'where' => ' '.$where,
            'order' => ' ORDER BY a.id DESC',
            'default_dataparam' => array(),
            'provide_max_fields' => 'batchid,scannerid,accountname,accountid,account,bizid,num,createtime',
        );
        $check = $this->parseSql ( $sqldata );
        if (true !== $check){
            return $this->renderJsonFailed ( $check );
        }
        $data = $this->getData ( $sqldata, 'list');
        return $this->renderJsonSuccess($data);
    }
    
    
    
    
    
}

