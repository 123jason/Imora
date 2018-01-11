<?php
/**
 * Created by PhpStorm.
 * User: qiuzhigang
 * Date: 2017-10-23
 * Time: 15:27
 * FileName: 扫描设备与二维码关系
 */

namespace Oradt\CommonBundle\Controller;

use Oradt\OauthBundle\Controller\BaseController;
use Oradt\Utils\Errors;
use Symfony\Component\HttpFoundation\Request;

class ScannerController extends BaseController {

    private $request;

    public function getAction($act) {
        $this->accesstime = $this->getTimestamp1();
        $this->request = Request::createFromGlobals();
        $wechatid = $this->request->get('wechatid');
        if (isset($wechatid)) {
            $this->accountId = $wechatid;
        }
        switch ($act) {
            case 'list'://获取所有没有绑定二维码的扫描仪的scannerid的信息
                return $this->_getScannerList();
                break;
            case 'batchidlist'://获取所有已经绑定二维码的批次号
                return $this->_getScannerBatchIdList();
                break;
            case 'tickets'://根据批次号获取设备id列和tickets列
                return $this->_getScannerWechatList();
                break;
            default:
                return $this->renderJsonFailed(Errors::$HTTP_STATUS_CODE_404);
                break;
        }
    }

    //获取所有没有绑定二维码的扫描仪的scannerid的信息
    private function _getScannerList(){
        $sqldata = array(
            'fields' => array(),
            'default_dataparam' => array(),
            'sql' => "SELECT %s FROM `scanner_wechat_qrcode` as a %s%s",
            'where' => " a.`wechat_uuid` ='' ",
            'order' => '',
            'provide_max_fields' => 'id,scannerid,batchid',);

        $check = $this->parseSql($sqldata);
        if(true !== $check){
            return $this->renderJsonFailed($check);
        }
        if(null==$this->request){
            $this->request = Request::createFromGlobals();
        }
        $rows = $this->strip_tags(intval(trim($this->request->get("rows",0))));
        if($rows<=0){
            $sqldata['pagesize'] = 500;
        }
        $data = $this->getData($sqldata,'list');
        return $this->renderJsonSuccess($data);
    }

    //获取所有已经绑定二维码的批次号
    private function _getScannerBatchIdList(){
        $querySql = "select `batchid` from `scanner_wechat_qrcode` WHERE `wechat_uuid` !='' GROUP BY `batchid`";
        $res = $this->getConnection()->executeQuery($querySql)->fetchAll();
        if(empty($res)||!isset($res)||count($res)<1){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
        }
        return $this->renderJsonSuccess($this->i_array_column($res,'batchid'));
    }


    //根据批次号获取设备id列和tickets列
    private function _getScannerWechatList(){
        $batchid = $this->strip_tags($this->request->get('batchid'));
        $scannerid = $this->strip_tags(trim($this->request->get('scannerid','')));
        if(empty($batchid)&&!isset($batchid)&&empty($scannerid)&&!isset($scannerid)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $where = '';
        if(!empty($batchid)&&isset($batchid)){
            $where = " a.`wechat_uuid`!='' ";
        }
        $sqldata = array(
            'fields' => array(
                'batchid' => array('mapdb' => "a.batchid", 'w' => ' AND a.batchid = :batchid'),
                'scannerid' => array('mapdb' => "a.scannerid", 'w' => ' AND a.scannerid = :scannerid'),
            ),
            'default_dataparam' => array(),
            'sql' => "SELECT %s FROM `scanner_wechat_qrcode` as a %s%s",
            'where' => $where,
            'order' => '',
            'provide_max_fields' => 'scannerid,wechat_ticket,wechat_qrcode,wechat_uuid,wechat_url,batchid',);

        $check = $this->parseSql($sqldata);
        if(true !== $check){
            return $this->renderJsonFailed($check);
        }
        if(null==$this->request){
            $this->request = Request::createFromGlobals();
        }
        $rows = $this->strip_tags(intval(trim($this->request->get("rows",0))));
        if($rows<1){
            $sqldata['pagesize'] = 500;
        }
        $data = $this->getData($sqldata,'list');
        return $this->renderJsonSuccess($data);
    }


    public function postAction($act) {
        $this->accesstime = $this->getTimestamp1();
        $this->em = $this->getManager();
        $this->baseInit();
        $this->request = Request::createFromGlobals();
        $wechatid = $this->request->get('wechatid');
        if (isset($wechatid)) {
            $this->accountId = $wechatid;
        }
        switch ($act) {
            case 'bindtickets'://微信ticket绑定操作
                return $this->_bindticket();
                break;
            default:
                return $this->renderJsonFailed(Errors::$HTTP_STATUS_CODE_404);
                break;
        }
    }

    /***
     * 微信ticket绑定操作
     */
    private function _bindticket(){
        if(null==$this->request){
            $this->request = Request::createFromGlobals();
        }
        $params = $this->strip_tags($this->request->get("params"));
        if(empty($params)||!isset($params)||strlen($params)<1){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $params = json_decode($params,true);
        $createTime = $this->getTimestamp();
        $this->em = $this->getDoctrine()->getManager(); //添加事物
        $this->em->getConnection()->beginTransaction();
        $logger = $this->get("logger");
        try{
            foreach($params as $param){
                $logger->info("_bindticket param:".json_encode($param));
                $wechat_ticket = $this->strip_tags($param['wechat_ticket']);
                $wechat_url     = urldecode($this->strip_tags($param['wechat_url']));
                $scannerid     = $this->strip_tags($param['scannerid']);
                $id            = intval(trim($param['id']));
                if(empty($id) || !isset($id) || $id < 1 || empty($wechat_url) || !isset($wechat_url) || empty($wechat_ticket) || !isset($wechat_ticket) || empty($scannerid) || !isset($scannerid)){
                    continue;
                }
                $wechat_qrcode = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . $wechat_ticket;
                $wechat_uuid  = str_replace("http://weixin.qq.com/q/", "", $param['wechat_url']);
                $updateSql = "UPDATE `scanner_wechat_qrcode` set `wechat_ticket`= :wechat_ticket ,`wechat_qrcode`= :wechat_qrcode ,`wechat_uuid`= :wechat_uuid ,`wechat_url`= :wechat_url ,`modify_time`= :modify_time WHERE id={$id}";
                $params = [':wechat_ticket'=>$wechat_ticket,':wechat_qrcode'=>$wechat_qrcode,':wechat_uuid'=>$wechat_uuid,':wechat_url'=>$wechat_url,':modify_time'=>$createTime,':id'=>$id];
                $this->em->getConnection()->executeUpdate($updateSql,$params);
            }
            $this->em->getConnection()->commit();
            return $this->renderJsonSuccess();
        }catch(\Exception $ex){
            $this->em->getConnection()->rollback();
            throw $ex;
        }
    }
}