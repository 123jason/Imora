<?php
/**
 * Created by PhpStorm.
 * User: qiuzhigang
 * Date: 2017/10/13
 * Time: 17:50
 * 关于企业套餐处理
 */

namespace Oradt\WeixinBizBundle\Controller;


use DateTime;
use Oradt\OauthBundle\Controller\BaseController;
use Oradt\Utils\Errors;
use Symfony\Component\HttpFoundation\Request;

class BizPaymentController extends BaseController {
    private $request;
    private $wxBizService;
    private $accessAction = ['alipay', 'wxpay', 'unionpay'];
    private $price = 30;



    /***
     * 进行权限判断 用户为超级管理员 执行下一步操作 否则NO
     *
     * @param $act string
     */
    private function _oauthAccessToken($act){
        if(!in_array($act, $this->accessAction)){
            $this->checkAccountV2();//权限判断
        }
    }
    public function getAction($act){
        $this->_oauthAccessToken($act);
        switch($act){
            case 'suitemeta'://获取企业套餐当前数据
                return $this->_getBizSuiteMetaData();
                break;
            case 'getsuiteorder'://获取企业套餐订单数据
                return $this->_getsuiteorder();
                break;
            case 'getorderlist'://套餐订单列表
                return $this->_getorderlist();
                break;
            //下面为新增的第二套方案处理方法
            case 'metadata'://套餐元数据列表
                return $this->_getMetadataList();
                break;
            case 'suite'://获取企业套餐当前数据 //企业套餐的基础信息
                return $this->_getBizSuiteMeta();
                break;
            case 'suiteorder'://获取企业套餐订单数据 第二次支付
                return $this->_geteOrderInfo();
                break;
            default:
                return $this->renderJsonFailed(Errors::$HTTP_STATUS_CODE_404);
                break;
        }
    }

    /***
     * 获取企业套餐信息
     * @version 0.0.1 2017-11-08
     * @author qiuzhigang
     */
    private function _getBizSuiteMeta(){
        //根据企业id获取企业套餐的有效期等信息
        $this->wxBizService = $this->get("wx_biz_payment_service");
        $termInfo           = $this->wxBizService->checkBizTermInfoByBizId($this->bizId);

        $result['suite']    = array('day' => 0, 'mouth' => 0, 'days' => 0, 'endtime' => 0, 'num' => 0,'level'=>$termInfo['level']);
        $ishave             = false;
        if(!empty($termInfo) && isset($termInfo)){
            $d1              = new DateTime(date('Y-m-d'));
            $d2              = new DateTime(date('Y-m-d', $termInfo['end_time']));
            $diff            = $d2->diff($d1);
            $result['suite'] = [
                'day' => $diff->d,
                'mouth' => $diff->m,
                'days' => $diff->days,
                'endtime' => $termInfo['end_time'],
                'num' => $termInfo['num'],
                'level'=>$termInfo['level']
            ];
            $ishave          = true;
        }
        $result['platform'] = array(
            array('id' => 1, 'name' => '支付宝支付'),
            array('id' => 2, 'name' => '微信支付'),
            array('id' => 3, 'name' => '银联支付')
        );

        $result['ishave']   = $ishave;

        return $this->renderJsonSuccess($result);
    }

    /***
     * 获取企业套餐信息
     * @version 0.0.1 2017-10-18
     * @author qiuzhigang
     */
    private function _getBizSuiteMetaData(){
        //根据企业id获取企业套餐的有效期等信息
        $this->wxBizService = $this->get("wx_biz_payment_service");
        $termInfo           = $this->wxBizService->checkBizTermInfoByBizId($this->bizId);

        if($this->container->hasParameter('suite_meta_id')){
            $metaId = $this->container->getParameter('suite_meta_id');
        }
        $result['suite']    = array('day' => 0, 'mouth' => 0, 'days' => 0, 'endtime' => 0, 'num' => 0,'metaid'=>$metaId);
        $ishave             = false;
        $metaInfo           = $this->wxBizService->getSuiteMetadataById($metaId);
        $price = $this->price;
        if(!empty($metaInfo)){
            $price = $metaInfo['price'];
        }
        if(!empty($termInfo) && isset($termInfo)){
            $d1              = new DateTime(date('Y-m-d'));
            $d2              = new DateTime(date('Y-m-d', $termInfo['end_time']));
            $diff            = $d2->diff($d1);
            $result['suite'] = [
                'day' => $diff->d,
                'mouth' => $diff->m,
                'days' => $diff->days,
                'endtime' => $termInfo['end_time'],
                'num' => $termInfo['num'],
                'metaid'=>$metaId];
            $ishave          = true;
        }
        $result['platform'] = array(
            array('id' => 1, 'name' => '支付宝支付'),
            array('id' => 2, 'name' => '微信支付'),
            array('id' => 3, 'name' => '银联支付')
        );

        $result['suite']['price'] = $price;
        $result['ishave']   = $ishave;

        return $this->renderJsonSuccess($result);
    }


    /***
     * 订单列表
     * @version 0.0.1 2017-10-18
     * @author qiuzhigang
     */
    private function _getorderlist(){
        $sqldata = array(
            'fields' => array(),
            'default_dataparam' => array(),
            'sql' => "SELECT %s FROM `wx_biz_order` as a %s%s",
            'where' => "",
            'order' => '',
            'provide_max_fields' => 'id,order_sn,order_type,pay_status,num,price,amount,term_date,platform,trade_no,pay_time,create_time',
            );
        $check   = $this->parseSql($sqldata);
        if(true !== $check){
            return $this->renderJsonFailed($check);
        }
        $data = $this->getData($sqldata);

        return $this->renderJsonSuccess($data);
    }

    /***
     * 根据订单类型获取数据
     * @param $orderType
     * @return string
     * @version 0.0.1 2017-10-18
     * @author qiuzhigang
     */
    private function _getOrderTitle($orderType){
        if($orderType == 1){
            $orderTitle = "企业套餐购买";
        }elseif($orderType == 2){
            $orderTitle = "企业套餐新增人员";
        }elseif($orderType == 3){
            $orderTitle = "企业套餐续费";
        }elseif($orderType == 4){
            $orderTitle = "企业套餐升级";
        }else{
            $orderTitle = "企业套餐";
        }

        return $orderTitle;
    }

    /***
     * 获取订单信息执行支付操作
     * @version 0.0.1 2017-10-18
     * @author qiuzhigang
     */
    private function _getsuiteorder(){
        if(null==$this->request){
            $this->request = Request::createFromGlobals();
        }
        $time          = $this->getTimestamp();
        $orderId       = intval(trim($this->request->get("orderid")));
        $platform      = intval(trim($this->request->get("platform")));
        if(empty($orderId) || !isset($orderId) || empty($platform) || !isset($platform)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        if($this->wxBizService == null){
            $this->wxBizService = $this->get("wx_biz_payment_service");
        }
        $orderInfo          = $this->wxBizService->getBizOrderInfoByOrderId($orderId);

        if(!isset($orderInfo) || empty($orderInfo) || $orderInfo['pay_status'] > 1){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
        }
        $payTime             = $this->getTimestamp();
        $result              = [];
        $result['orderid']   = $orderInfo['id'];
        $result['ordersn']   = $orderInfo['order_sn'];
        $result['amount']    = $orderInfo['pay_amount'];
        $result['title']     = $this->_getOrderTitle($orderInfo['order_type']);
        $result['time']      = $time;
        $result['paystatus'] = $orderInfo['pay_status'];
        $result['platform']  = $platform;

        //直接支付
        if($platform == 4){
            $notifyData['trade_no'] = $this->wxBizService->makeOrderSn();
            $notifyResult           = $this->wxBizService->notifySuite($orderInfo, $notifyData, $payTime, $platform);
            if($notifyResult == 100){
                $result['paystatus'] = 2;
            }
        }
        $result['notify'] = $this->wxBizService->getNotifyUrl($platform);

        return $this->renderJsonSuccess($result);
    }


    /***
     * 获取订单信息用于支付处理
     * @version 0.0.1 2017-11-08
     * @author qiuzhigang
     */
    private function _geteOrderInfo(){
        if(null==$this->request){
            $this->request = Request::createFromGlobals();
        }
        $time          = $this->getTimestamp();
        $orderId       = intval(trim($this->request->get("orderid")));
        $platform      = intval(trim($this->request->get("platform")));
        if(empty($orderId) || !isset($orderId) || empty($platform) || !isset($platform)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        if($this->wxBizService == null){
            $this->wxBizService = $this->get("wx_biz_payment_service");
        }
        $orderInfo          = $this->wxBizService->getBizOrderInfoByOrderId($orderId);

        if(!isset($orderInfo) || empty($orderInfo) || $orderInfo['pay_status'] > 1){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
        }
        $payTime             = $this->getTimestamp();
        $result              = [];
        $result['orderid']   = $orderInfo['id'];
        $result['ordersn']   = $orderInfo['order_sn'];
        $result['amount']    = $orderInfo['pay_amount'];
        $result['title']     = $this->_getOrderTitle($orderInfo['order_type']);
        $result['time']      = $time;
        $result['paystatus'] = $orderInfo['pay_status'];
        $result['platform']  = $platform;

        //直接支付
        if($platform == 4){
            $notifyData['trade_no'] = $this->wxBizService->makeOrderSn();
            $notifyResult           = $this->wxBizService->newnotifysuite($orderInfo, $notifyData, $payTime, $platform);
            if($notifyResult == 100){
                $result['paystatus'] = 2;
            }
        }
        $result['notify'] = $this->wxBizService->getNotifyUrl($platform);

        return $this->renderJsonSuccess($result);
    }

    private function _getMetadataList(){
        if($this->request==null){
            $this->request = Request::createFromGlobals();
        }
        $type = $this->strip_tags(intval(trim($this->request->get("type"))));
        $limit = 10;
        if(in_array($type,[1,2,3])){
            if($type == 1){
                $level = "> 0";
            }elseif($type == 2){
                $this->wxBizService = $this->get("wx_biz_payment_service");
                $termInfo           = $this->wxBizService->checkBizTermInfoByBizId($this->bizId);
                $level              = "=" . $termInfo['level'];
                $limit = 1;
            }else{
                $this->wxBizService = $this->get("wx_biz_payment_service");
                $termInfo           = $this->wxBizService->checkBizTermInfoByBizId($this->bizId);
                $level              = ">=" . $termInfo['level'];
            }
        }else{
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_FORMAT);//参数不符合规则
        }

        $sqldata = array(
            'fields' => array(

            ),
            'default_dataparam' => array(),
            'sql' => "SELECT %s FROM `wx_biz_suite_metadata` as a %s%s",
            'where' => " a.type = 1 AND a.status= 100 AND a.level ".$level,
            'order' => 'ORDER BY a.level asc,a.id desc',
            'provide_max_fields' => 'id,name,desc,num,sheet,price,level',
            'limit'=> $limit,
        );
        $check   = $this->parseSql($sqldata);
        if(true !== $check){
            return $this->renderJsonFailed($check);
        }
        $data = $this->getData($sqldata,'list');
        if(empty($data)&&!isset($data)){
            return $this->renderJsonSuccess(Errors::$ERROR_PARAMETER_NOT_DATA);
        }
        return $this->renderJsonSuccess($data);
    }

    /***
     * 执行post提交处理
     *
     * @param $act
     * @return \Symfony\Component\HttpFoundation\Response|void
     */
    public function postAction($act){
        $this->_oauthAccessToken($act);
        switch($act){
            case 'purchasesuite'://添加企业套餐订单
                return $this->_purchasesuite();
                break;
            case 'addemployeesuite'://新增企业员工订单
                return $this->_addemployeesuite();
                break;
            case 'renewsuite'://续费企业名片
                return $this->_renewsuite();
                break;
            case 'alipay'://支付宝回调处理
                return $this->_notifyAlipay();
                break;
            case 'wxpay'://微信回调处理
                return $this->_notifyWxpay();
                break;
            case 'unionpay'://银联回调处理
                return $this->_notifyUnionpay();
                break;
            case 'purchase'://企业套餐支付
                return $this->_purchase();
                break;

            default:
                return $this->renderJsonFailed(Errors::$HTTP_STATUS_CODE_404);
                break;
        }
    }


    /***
     * 进行订单支付接口
     */
    private function _purchase(){
        if(null==$this->request){
            $this->request = Request::createFromGlobals();
        }
        $type         = $this->strip_tags(intval(trim($this->request->get("type"))));//type 代表的是 1 为购买套餐 2 新增员工 3 续费套餐 4升级套餐
        $platform      = $this->strip_tags(intval(trim($this->request->get("platform")))); //1支付宝 2微信 3银联 4余额
        $metaId        = $this->strip_tags(intval(trim($this->request->get("metaid")))); //套餐id

        //购买数量不足
        if($type < 1 || !in_array($type,[1,4,3]) || !in_array($platform, [1, 2, 3, 4])||empty($metaId)||!isset($metaId)||$metaId<1){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        if($this->wxBizService == null){
            $this->wxBizService = $this->get("wx_biz_payment_service");
        }

        $result = $this->wxBizService->newpurchase($type, $platform,$metaId,$this->bizId,$this->accountId,1);

        if($result['errorcode']!=Errors::$SUCCESS_OK){
            return $this->renderJsonFailed($result);
        }
        return $this->renderJsonSuccess($result['data']);
    }

    /***
     * 进行订单支付接口
     */
    private function _purchasesuite(){
        if(null==$this->request){
            $this->request = Request::createFromGlobals();
        }
        $num           = intval(trim($this->request->get("num")));
        $month         = intval(trim($this->request->get("month")));
        $platform      = intval(trim($this->request->get("platform")));
        $metaId        = intval(trim($this->request->get("metaid")));
        if(empty($metaId)||!isset($metaId)||$metaId<1){
            if($this->container->hasParameter('suite_meta_id')){
                $metaId = $this->container->getParameter('suite_meta_id');
            }
        }
        //购买数量不足
        if($num < 1 || $month < 1 || !in_array($platform, [1, 2, 3, 4])){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        if($this->wxBizService == null){
            $this->wxBizService = $this->get("wx_biz_payment_service");
        }

        $result = $this->wxBizService->purchase(1, $platform, $num, $month,$metaId,$this->bizId,$this->accountId);
        if($result['errorcode']!=Errors::$SUCCESS_OK){
            return $this->renderJsonFailed($result);
        }
        return $this->renderJsonSuccess($result['data']);
    }

    /***
     * 新增员工操作
     */
    private function _addemployeesuite(){
        if(null==$this->request){
            $this->request = Request::createFromGlobals();
        }
        $num           = intval(trim($this->request->get("num")));
        $platform      = intval(trim($this->request->get("platform")));
        $metaId        = intval(trim($this->request->get("metaid")));
        if(empty($metaId)||!isset($metaId)||$metaId<1){
            if($this->container->hasParameter('suite_meta_id')){
                $metaId = $this->container->getParameter('suite_meta_id');
            }
        }

        //购买数量不足
        if($num < 1 || $platform < 1 || empty($num) || empty($platform)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }

        if($this->wxBizService == null){
            $this->wxBizService = $this->get("wx_biz_payment_service");
        }

        $result = $this->wxBizService->purchase(2, $platform, $num, 0,$metaId,$this->bizId,$this->accountId);
        if($result['errorcode']!=Errors::$SUCCESS_OK){
            return $this->renderJsonFailed($result);
        }
        return $this->renderJsonSuccess($result['data']);
    }


    /***
     * 续费
     */
    private function _renewsuite(){
        if(null==$this->request){
            $this->request = Request::createFromGlobals();
        }
        $month         = intval(trim($this->request->get("month")));
        $platform      = intval(trim($this->request->get("platform")));
        $metaId        = intval(trim($this->request->get("metaid")));
        if(empty($metaId)||!isset($metaId)||$metaId<1){
            if($this->container->hasParameter('suite_meta_id')){
                $metaId = $this->container->getParameter('suite_meta_id');
            }
        }
        //购买数量不足
        if($month < 1 || !isset($month) || $platform < 1 || !isset($platform)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        if($this->wxBizService == null){
            $this->wxBizService = $this->get("wx_biz_payment_service");
        }
        //purchase($mode, $platform, $num, $month,$metaId,$bizId,$accountId)
        $result = $this->wxBizService->purchase(3, $platform, 0, $month,$metaId,$this->bizId,$this->accountId);
        if($result['errorcode']!=Errors::$SUCCESS_OK){
            return $this->renderJsonFailed($result);
        }
        return $this->renderJsonSuccess($result['data']);
    }

    /***
     * 支付宝支付回调处理
     */
    private function _notifyAlipay(){

    }

    /**
     * 微信支付回调处理
     */
    private function _notifyWxpay(){
        $ordersn            = $_POST['order_sn'];
        $notifyData         = $_POST;
        $this->wxBizService = $this->get("wx_biz_payment_service");
        $orderInfo          = $this->wxBizService->getOrderInfoByOrderSn($ordersn);
        if(empty($orderInfo)){
            return -1;//
        }
        if($orderInfo['pay_status'] > 1){
            return 100;
        }
        $payTime  = $this->getTimestamp();
        $platform = 2;
        //模拟调用

        $result = $this->wxBizService->notifySuite($orderInfo, $notifyData, $payTime, $platform);
        if($result == 100){
            echo "success";
        }
        echo "fail";
    }

    /***
     * 银联支付回调处理
     */
    private function _notifyUnionpay(){

    }
}