<?php
/**
 * Created by PhpStorm.
 * User: qiuzhigang
 * Date: 2017/10/13
 * Time: 15:10
 * 关于套餐有关的处理
 */

namespace Oradt\ServiceBundle\Services;


use DateInterval;
use DateTime;
use Doctrine\ORM\EntityManager;
use Oradt\StoreBundle\Entity\WxBizOrder;
use Oradt\Utils\Errors;
use Symfony\Component\DependencyInjection\ContainerInterface;

class WxBizPaymentService extends BaseService
{

    public function __construct(EntityManager $entityManager, ContainerInterface $container) {
        parent::__construct($container);
        $this->em = $this->getManager();
    }

    /***
     * @TODO 根据企业id查询 套餐数据 一个企业存在一条数据
     * @param $bizId string
     * @return array
     * @version 0.0.1 2017-10-12
     * @author ZhigangQiu <[<qiuzhigang@oradt.com>]>
     */
    public function checkBizTermInfoByBizId($bizId,$field=true){
        $res = [];
        if(empty($bizId)||strlen(trim($bizId))<1){
            return $res;
        }
        $where = "WHERE biz_id = :bizid LIMIT 1 ";
        if($field===true){
            $field = "*";
        }
        $sql = "SELECT ".$field." FROM `wx_biz_suite_term` ".$where;
        $res   = $this->getConnection()->executeQuery($sql,[':bizid'=>$bizId])->fetch();
        return $res;
    }

    /***
     * 检测是否符合规则 flag为1时 参数必须大于0 ；flag 为2时 参数必须不为0 ；其他就是参数只要有值就可以
     * @param $integer integer or string
     * @param int $flag
     * @version 0.0.1 2017-10-12
     * @author ZhigangQiu <[<qiuzhigang@oradt.com>]>
     * @return bool
     */
    public function _validateInteger($integer,$flag=1){
        if(!is_numeric($integer)){
            return false;
        }
        $integer = intval(trim($integer));
        if($flag==1){
            //大于零的整数
            if($integer>0){
                return true;
            }
        }elseif ($flag==2){
            //包括除零以外的其他整数 正负
            if(!empty($integer)){
                return true;
            }
        }else{
            //值不为空就可以了
            if(isset($integer)){
                return true;
            }
        }
        return false;
    }

    /***
     * 根据套餐等级获取数据
     * @param $level
     * @param bool $field
     * @version 0.0.1 2017-10-12
     * @author ZhigangQiu <[<qiuzhigang@oradt.com>]>
     * @return array
     */
    public function getSuiteMetadataByLevel($level,$field=true){
        $res = [];
        if(!$this->_validateInteger($level)){
            return $res;
        }
        $where = "WHERE `level` = :level AND `status`=100 ORDER BY type asc limit 3";
        if($field===true){
            $field = "*";
        }
        $sql = "SELECT ".$field." FROM `wx_biz_suite_metadata` ".$where;
        $res   = $this->getConnection()->executeQuery($sql,[':levle'=>$level])->fetchAll();
        return $res;
    }

    /***
     * TODO 根据用户元数据id获取数据
     * @param $id
     * @param bool $field
     * @return array
     * @version 0.0.1 2017-10-12
     * @author ZhigangQiu <[<qiuzhigang@oradt.com>]>
     */
    public function getSuiteMetadataById($id,$field=true){
        $res = [];
        if(!$this->_validateInteger($id)){
            return $res;
        }
        $where = "WHERE `id` = :id AND `status`=100  limit 1";
        if($field===true){
            $field = "*";
        }
        $sql = "SELECT ".$field." FROM `wx_biz_suite_metadata` ".$where;
        $res   = $this->getConnection()->executeQuery($sql,[':id'=>$id])->fetch();
        return $res;
    }

    /***
     * @TODO 根据id查询订单信息
     * @param $orderId integer
     * @param bool $field
     * @return array
     * @version 0.0.1 2017-10-12
     * @author ZhigangQiu <[<qiuzhigang@oradt.com>]>
     */
    public function getBizOrderInfoByOrderId($orderId,$field=true){
        $res = [];
        if(!$this->_validateInteger($orderId)){
            return $res;
        }
        $where = "WHERE `id` = :id limit 1";
        if($field===true){
            $field = "*";
        }
        $sql = "SELECT ".$field." FROM `wx_biz_order` ".$where;
        $res   = $this->getConnection()->executeQuery($sql,[':id'=>$orderId])->fetch();
        return $res;
    }

    /***
     * 获取订单详情信息
     * @param $orderId
     * @param bool $field
     * @return array|mixed
     */
    public function getBizOrderDetailInfoByOrderId($orderId,$field=true){
        $res = [];
        if(!$this->_validateInteger($orderId)){
            return $res;
        }
        $where = "WHERE `order_id` = :orderid limit 1";
        if($field===true){
            $field = "*";
        }
        $sql = "SELECT ".$field." FROM `wx_biz_order_detail` ".$where;
        $res   = $this->getConnection()->executeQuery($sql,[':orderid'=>$orderId])->fetch();
        return $res;
    }

    /***
     * @TODO 根据企业id获取订单信息
     * @param $bizId string
     * @param bool $field
     * @return array
     * @version 0.0.1 2017-10-19
     * @author ZhigangQiu <[<qiuzhigang@oradt.com>]>
     */
    public function getSuiteOrderList($bizId,$field=true,$limit="30"){
        $res = [];
        if(empty($bizId)||strlen(trim($bizId))<1){
            return $res;
        }
        $where = "WHERE biz_id = :bizid";
        if($field===true){
            $field = "*";
        }
        $sql = "SELECT ".$field." FROM `wx_biz_order` ".$where."ORDER BY id desc limit ".$limit;
        $res   = $this->getConnection()->executeQuery($sql,[':bizid'=>$bizId])->fetchAll();
        return $res;
    }

    /***
     * @TODO 根据订单号返回订单数据
     * @param $orderSn
     * @param bool $field
     * @return array
     * @version 0.0.1 2017-10-19
     * @author ZhigangQiu <[<qiuzhigang@oradt.com>]>
     */
    public function getOrderInfoByOrderSn($orderSn,$field=true){
        $res = [];
        if(empty($orderSn)||strlen(trim($orderSn))<1){
            return $res;
        }
        $where = "WHERE order_sn = :ordersn ";
        if($field===true){
            $field = "*";
        }
        $sql = "SELECT ".$field." FROM `wx_biz_order` ".$where."ORDER BY id desc limit 1";
        $res   = $this->getConnection()->executeQuery($sql,[':ordersn'=>$orderSn])->fetch();
        return $res;
    }
    
    /***
     * @TODO 读取配置表
     * @author zg <[<zhanggan@oradt.com>]>
     */
    public function getSystemConfig($option_name){
        $res = '';
        if(empty($option_name)||strlen(trim($option_name))<1){
            return $res;
        }
        $where = "WHERE option_name = :option_name ";
         
        $sql = "SELECT `option_value` FROM `wx_system_config` ".$where." ORDER BY id desc limit 1";
        $res   = $this->getConnection()->executeQuery($sql,[':option_name'=>$option_name])->fetch();
        return $res;
    }


    /****
     * 获取时间 最近的前后一个月
     * @param $time
     * @param int $type 0 获取下一个月 1上一个月
     * @param int $dateType 返回的时间类型 0 日期 1 时间戳
     * @return false|string
     */
    private function getLastMonthFirstDayTime($time,$type=0,$dateType=0){
        //得到系统的年月
        $tmp_date=date("Ym",$time);
        //切割出年份
        $tmp_year=substr($tmp_date,0,4);
        //切割出月份
        $tmp_mon =substr($tmp_date,4,2);

        if($type==0){
            //得到当前月的下一个月
            $timestamp=mktime(0,0,0,$tmp_mon+1,1,$tmp_year);
            //return $fm_next_month=date("Y-m-d",$tmp_nextmonth);
        }else{
            //得到当前月的上一个月
            $timestamp=mktime(0,0,0,$tmp_mon-1,1,$tmp_year);
            //return $fm_forward_month=date("Y-m-d",$tmp_forwardmonth);
        }
        if($dateType==0){
            return date("Y-m-d",$timestamp);
        }
        return $timestamp;
    }

    /***
     * @param $bizid
     * @param bool $field
     * @return array|mixed
     */
    private function getLastOrderInfoByBizId($bizid,$field=true){
        $res = [];
        if(empty($bizid)||strlen(trim($bizid))<1){
            return $res;
        }
        $where = " WHERE biz_id = :bizid AND pay_status=2 ";
        if($field===true){
            $field = "*";
        }
        $sql = "SELECT ".$field." FROM `wx_biz_order` ".$where." ORDER BY id desc limit 1";
        $res   = $this->getConnection()->executeQuery($sql,[':bizid'=>$bizid])->fetch();
        return $res;
    }


    /***
     * 订单支付
     * @param $mode 1 为购买套餐 2 新增员工 3 续费套餐 4升级套餐
     * @param $platform 1支付宝 2微信 3银联 4余额
     * @param $num 员工数量
     * @param $source 订单来源 1 用户在线购买 2平台赠送订单
     * @param $metaId 套餐id
     * @param $bizId 企业id
     * @param $source 订单来源 1用户下单 2运营（系统）赠送
     * @param $accountId 用户id
     * @param $adminid 管理员id
     * @param $adminname 管理员名称
     */
    public function newpurchase($mode, $platform, $metaId,$bizId,$accountId,$source=1,$adminid=0,$adminname=''){
        if($mode > 4|| $metaId<0){
            return Errors::$ERROR_UNKNOWN;
        }
        //获取原来套餐汇总信息
        $termInfo = $this->checkBizTermInfoByBizId($bizId);

        //获取元数据 以及套餐是否存在
        $metaInfo = $this->getSuiteMetadataById($metaId);
        if(empty($metaInfo) || !isset($metaInfo)){
            if($mode==3){
                return Errors::$ACCOUNT_TERM_OFF;
            }
            return Errors::$ACCOUNT_TERM_NOT_EXISTS;
        }
        //不符合条件 直接返回错误
        $time = $this->getTimestamp();
        //还没有结束 先有套餐 不能新购执行续费
        if($mode == 1){
            //数据已存在 请选择续费
            if($termInfo['end_time']>$time){
                if(!empty($termInfo) && isset($termInfo)){
                    return Errors::$ACCOUNT_BIZ_TERM_EXISTS;
                }
            }
        }else{
            //当支付为续费或新增时  需要判断套餐是否存在
            if(empty($termInfo) || !isset($termInfo)){
                return Errors::$ACCOUNT_BIZ_TERM_NOT_EXISTS;
            }
            //参数错误
            if($metaInfo['level']<$termInfo['level']){
                return Errors::$ERROR_PARAMETER_FORMAT;
            }
        }
        $month = $metaInfo['buy_month'];

        $discountSource='';
        $datetime = $this->getLastMonthFirstDayTime($time,0,0);
        if($mode == 1){
            $dateObject = new DateTime($datetime);
            $dateObject->add(new DateInterval("P" . $month . "M"));
            $title          = '企业套餐购买';
        }elseif($mode == 3){//续费
            //判断是否 大于当前时间是未过期
            $timestamp = $this->getLastMonthFirstDayTime($time,0,1);
            if($termInfo['end_time'] >= $timestamp){
                //开始时间为上次的有效期时间的结束时间
                $dateObject = new DateTime(date('Y-m-d', ($termInfo['end_time']+1)));
            }else{
                //已过期 初始时间为当前时间戳
                $dateObject           = new DateTime($datetime);
            }
            $dateObject->add(new DateInterval("P" . $month . "M"));
            $title          = "企业套餐续费";
        }elseif($mode == 4){//升级
            $dateObject = new DateTime($datetime);
            $dateObject->add(new DateInterval("P" . $month . "M"));//有效期截止日期
            $title          = "企业套餐升级";
        }else{
            return Errors::$ERROR_PARAMETER_NOT_DATA;
        }
        $ordersn    = $this->makeOrderSn();//订单
        $termDate   = $dateObject->format('Y-m-d');//有效期日期

        $payAmount = $amount= $metaInfo['price'];

        if($mode == 4){
            //获取升级套餐生效开始时间
            $timestamp = $this->getLastMonthFirstDayTime($time,0,1);
            //如果原有套餐的有效期大于升级套餐生效的开始时间 进行金额抵扣处理
            if($timestamp<$termInfo['end_time']){
                //结束时间
                $dateObjecOriginal  = new DateTime(date('Y-m-d', ($termInfo['end_time']+1)));
                //升级套餐开始生效时间与原套餐有效期截止时间  比较 获取剩余的月份时间
                $dateObjectTerm = new DateTime($datetime);//开始日期
                $diffObjectOriginal = $dateObjectTerm->diff($dateObjecOriginal);
                //套餐信息
                $metaInfoOriginal   = json_decode($termInfo['suite_json'], true);
                //计算可以抵扣金额 抵扣金额 支付金额
                $discountAmount = ($metaInfoOriginal['price'] / $metaInfoOriginal['buy_month']) * ($diffObjectOriginal->y*12+$diffObjectOriginal->m);
                //计算实际支付的金额
                $payAmount      = $amount - $discountAmount;
                if($payAmount<0){
                    //套餐选择错误 小于剩下的金额 或许有效较短
                    return Errors::$ERROR_PARAMETER_FORMAT;
                }
                //获取可以抵扣的订单信息
                $orderInfo      = $this->getLastOrderInfoByBizId($bizId, '`order_sn`');
                //设置订单号为抵扣金额来源 或许 优惠来源
                $discountSource = $orderInfo['order_sn'];
            }
        }
        if($source==2){
            $payAmount = 0;
            if($mode!=4){
                $discountSource = $accountId;
            }
        }

        $this->getConnection()->beginTransaction();
        $payStatus = 1;
        try{
            //写入订单
            $wxBizOrder = $this->_insertWxBizOrder( $platform, $time, $ordersn, $amount, $termDate, $mode,$metaInfo,$bizId,$accountId,$payAmount,$source,$discountSource);
            $this->em->persist($wxBizOrder);
            $this->em->flush();
            //准备订单详情
            $orderid      = $wxBizOrder->getId();
            //写入订单详情
            $this->_insertOrderDetailInfo($orderid,$metaId,$time);
            //准备返回信息
            $result = ['orderid' => $orderid, 'ordersn' => $ordersn, 'time' => $time, 'amount' => $payAmount, 'title' => $title, 'notify' => $this->getNotifyUrl($platform),'platform'=>$platform];
            //判断是否为余额支付 进行订单支付成功处理
            if($payAmount==0){
                $platform = 4;
            }
            if($platform == 4){
                $trade_no      = $this->makeOrderSn();
                $payTime       = $this->getTimestamp();
                $payStatus     = 2;
                //更新订单 信息
                $this->_updateOrderInfo($orderid,$platform,$trade_no,$payStatus,$payTime);
                $suiteJson = json_encode($metaInfo);
                if($mode == 1){//新购
                    $endTime      = strtotime($termDate)-1;
                    $this->_insertSuiteInfo($bizId,$metaInfo,$time,$endTime,$suiteJson);//写入套餐信息
                }
                //写入更新记录
                if(in_array($mode,[3,4])){
                    //写入日志
                    $this->_insertSuiteLog($adminid,$adminname,$termInfo,$payTime);

                    $termInfo['end_time'] = strtotime($termDate)-1;//有效期
                    $termInfo['sheet'] = $metaInfo['sheet'];//名片张数
                    $termInfo['num'] = $metaInfo['num'];//人员数量
                    $termInfo['metaid'] = $metaId;
                    //更新人员数量 名片张数 总的月份,总的金额，有效期，修改时间
                    if($mode == 4){//升级套餐
                        $termInfo['amount'] = $termInfo['amount']+$payAmount;
                        //减去剩余的 加上现在买的时间
                        $termInfo['term'] = $termInfo['term'] - $diffObjectOriginal->m +$month;
                        $termInfo['level'] = $metaInfo['level'];
                    }else{//续费
                        $termInfo['term'] = $termInfo['term'] + $month;
                        $termInfo['amount'] = $termInfo['amount']+$amount;
                    }
                    $this->_updateSuiteInfo($termInfo,$payTime,$suiteJson);
                }

                //订单详情 更新
                $this->_updateOrderDetail($orderid,$trade_no,$payTime);
            }
            $this->getConnection()->commit();
            $result['paystatus'] = $payStatus;
            $result['platform']  = $platform;
            return array('errorcode' => Errors::$SUCCESS_OK, 'description' => 'SUCCESS_OK','data'=>$result);
        }catch(\Exception $ex){
            $this->getConnection()->rollback();
            $logger = $this->container->get("logger");
            $logger->error("_notifyRenewSuite error info :", ['message' => $ex->getMessage(), 'code' => $ex->getCode(), 'file' => $ex->getFile(), 'line' => $ex->getLine(), 'trace' => $ex->getTrace()]);
            return array('errorcode' => Errors::$FAILED, 'description' => 'FAILED');
        }
    }

    /***
     * 写入订单详情记录
     * @param $orderid
     * @param $metaid
     * @param $time
     * @version 0.0.1 2017-11-10
     * @Author qiuzhigang
     */
    private function _insertOrderDetailInfo($orderid,$metaid,$time){
        $values       = [':orderid'=>$orderid,":metaid"=>$metaid,':createtime'=>$time];
        $insertDetail = "INSERT INTO `wx_biz_order_detail` (`order_id`,`meta_id`,`create_time`) VALUES (:orderid , :metaid , :createtime)";
        $this->getConnection()->executeQuery($insertDetail,$values);
    }

    /***
     * 更新订单状态
     * @param $orderid
     * @param $platform
     * @param $trade_no
     * @param $paystatus
     * @param $time
     * @version 0.0.1 2017-11-10
     * @Author qiuzhigang
     */
    private function _updateOrderInfo($orderid,$platform,$trade_no,$paystatus,$time){
        $orderParam = [':platform'=>$platform,':tradeno'=>$trade_no,":paytime"=>$time,':paystatus'=>$paystatus,':id'=>$orderid];
        $wxBizOrderSql = "UPDATE `wx_biz_order` set platform = :platform ,`trade_no`= :tradeno,`pay_time`= :paytime ,`pay_status`= :paystatus WHERE id= :id ";
        $this->getConnection()->executeQuery($wxBizOrderSql,$orderParam);
    }

    /***
     * 更新企业套餐资料信息
     * @param $mode
     * @param $termInfo
     * @param $time
     * @version 0.0.1 2017-11-10
     * @Author qiuzhigang
     */
    private function _updateSuiteInfo($termInfo,$time,$suiteJson=''){
        if(empty($suiteJson)){
            $suiteJson = $termInfo['suite_json'];
        }
        $stParams = [':term'=>$termInfo['term'],'amount'=>$termInfo['amount'],':endtime'=>$termInfo['end_time'],':modifytime'=>$time,':id'=>$termInfo['id'],':sheet'=>$termInfo['sheet'],':num'=>$termInfo['num'],':level'=>$termInfo['level'],':suitejson'=>$suiteJson,':metaid'=>$termInfo['metaid']];
        //更新人员数量 名片张数 总的月份,总的金额，有效期，修改时间
        $suiteTermSql = "UPDATE `wx_biz_suite_term` set `num`= :num ,`sheet`= :sheet ,`term`= :term ,`amount`= :amount ,`end_time`= :endtime,`modify_time`= :modifytime,`level`=:level,`suite_json`= :suitejson,`metaid`= :metaid WHERE id= :id";
        $this->getConnection()->executeQuery($suiteTermSql,$stParams);
    }



    /***
     * 更新订单详细信息
     * @param $orderid
     * @param $trade_no
     * @param $payTime
     * @param string $order_detail
     * @version 0.0.1 2017-11-10
     * @Author qiuzhigang
     */
    private function _updateOrderDetail($orderid,$trade_no,$payTime,$order_detail=''){
        if(empty($order_detail)){
            $order_detail = json_encode(['trade_no' => $trade_no, 'modify_time' => $payTime]);
        }
        $detailParam = [':trade_no'=>$trade_no,':order_detail'=>$order_detail,':order_id'=>$orderid,':modifytime'=>$payTime];
        $detailSql    = "UPDATE `wx_biz_order_detail` set `trade_no`= :trade_no,`result_code`=200,`order_detail`= :order_detail,`modify_time`= :modifytime WHERE order_id= :order_id ";
        $this->getConnection()->executeQuery($detailSql,$detailParam);
    }

    /***
     * 写入suite更新前的日志信息
     * @param $adminid
     * @param $adminname
     * @param $terminfo
     * @param $time
     * @version 0.0.1 2017-11-10
     * @Author qiuzhigang
     */
    private function _insertSuiteLog($adminid,$adminname,$terminfo,$time){
        $logParam = [':bizid'=>$terminfo['biz_id'],':adminid'=>$adminid,':adminname'=>$adminname,':suitejson'=>json_encode($terminfo),':createtime'=>$time];
        $logSql = "INSERT INTO `wx_biz_suite_log` (`biz_id`,`admin_id`,`admin_name`,`suite_json`,`create_time`) VALUES (:bizid,:adminid,:adminname,:suitejson,:createtime)";
        $this->getConnection()->executeQuery($logSql,$logParam);
    }


    /***
     * 新购写入套餐信息
     * @param $bizid
     * @param $metaInfo
     * @param $time
     * @param $endtime
     * @version 0.0.1 2017-11-10
     * @Author qiuzhigang
     */
    private function _insertSuiteInfo($bizid,$metaInfo,$time,$endtime,$suitejson=''){
        if(empty($suitejson)){
            $suitejson = json_encode($metaInfo);
        }
        $stParams     = [':bizid'=>$bizid, ":term"=>$metaInfo['buy_month'], ':sheet'=>$metaInfo['sheet'], ':num'=>$metaInfo['num'], ':amount'=>$metaInfo['price'], ':starttime'=>$time, ':endtime'=>$endtime, ':createtime'=>$time,':suitejson'=>$suitejson,':level'=>$metaInfo['level'],':metaid'=>$metaInfo['id']];
        $suiteTermSql = "INSERT INTO `wx_biz_suite_term` (`biz_id`,`term`,`sheet`,`num`,`amount`,`start_time`,`end_time`,`create_time`,`suite_json`,`level`,`metaid`) VALUES (:bizid , :term , :sheet , :num , :amount , :starttime , :endtime ,:createtime, :suitejson, :level, :metaid)";
        $this->getConnection()->executeQuery($suiteTermSql,$stParams);
    }

    /***
     * 订单支付
     * @param $mode 1 为购买套餐 2 新增员工 3 续费套餐
     * @param $platform 1支付宝 2微信 3银联 4余额
     * @param $num 员工数量‘
     * @param $month 购买的月份时间 单位月（自然月）
     * @param $metaId 套餐id
     * @param $bizId 企业id
     * @param $accountId 用户id
     * @version 0.0.1 2017-11-18
     * @Author qiuzhigang
     */
    public function purchase($mode, $platform, $num, $month,$metaId,$bizId,$accountId){
        //$mode 1 为购买套餐 2 新增员工 3 续费套餐  4升级 大于3直接返回错误
        if($mode > 4|| $metaId<0){
            return Errors::$ERROR_UNKNOWN;
        }

        //获取原来套餐汇总信息
        $termInfo = $this->checkBizTermInfoByBizId($bizId);

        //获取元数据
        $metaInfo = $this->getSuiteMetadataById($metaId);

        if(empty($metaInfo) || !isset($metaInfo)){
            return Errors::$ACCOUNT_TERM_NOT_EXISTS;
        }
        //不符合条件 直接返回错误
        if($mode == 1){
            //数据已存在 请选择续费
            if(!empty($termInfo) && isset($termInfo)){
                return Errors::$ACCOUNT_BIZ_TERM_EXISTS;
            }
        }else{
            //当支付未续费或新增时  需要判断套餐是否存在
            if(empty($termInfo) || !isset($termInfo)){
                return Errors::$ACCOUNT_BIZ_TERM_NOT_EXISTS;
            }
        }

        $time     = $this->getTimestamp();
        $datetime = date('Y-m-d', $time);
        if($mode == 1){
            $dateObject = new DateTime($datetime);
            $dateObject->add(new DateInterval("P" . $month . "M"));
            $dateObjectTerm = new DateTime($datetime);
            $title          = '企业套餐初次购买';
        }elseif($mode == 2){//新增员工
            $dateObject     = new DateTime(date('Y-m-d', $termInfo['end_time']));
            $dateObjectTerm = new DateTime($datetime);
            $title          = "企业套餐新增人员";
        }elseif($mode == 3){//续费
            //判断是否 大于当前时间是未过期
            if($termInfo['end_time'] > $time){
                $dateObject = new DateTime(date('Y-m-d', $termInfo['end_time']));
            }else{
                //已过期 初始时间为当前时间戳
                $dateObject           = new DateTime($datetime);
                $termInfo['end_time'] = $time;
            }
            $dateObject->add(new DateInterval("P" . $month . "M"));
            $dateObjectTerm = new DateTime($datetime);
            $title          = "企业套餐续费";
            $num            = $termInfo['num'];
        }else{
            return Errors::$ERROR_PARAMETER_NOT_DATA;
        }
        $diffObject = $dateObjectTerm->diff($dateObject);
        $ordersn    = $this->makeOrderSn();//订单
        $termDate   = $dateObject->format('Y-m-d');//有效期日期

        $days   = $diffObject->days;
        $amount = 0;
        $price = $metaInfo['price'];
        if(in_array($mode, [1, 3])){
            $amount = $num * $month * round($price, 2);//总金额
        }
        if($mode == 2){
            $amount = $num * $days * round($price / 30, 2);//总金额
        }
        $this->getConnection()->beginTransaction();
        $payStatus = 1;
        try{
            $metadata['buy_month'] = $days;
            //写入订单信息
            $wxBizOrder = $this->_insertWxBizOrder($platform, $time, $ordersn, $amount, $termDate, $mode,$metaInfo,$bizId,$accountId,$amount);
            $this->em->persist($wxBizOrder);
            $this->em->flush();

            $orderId      = $wxBizOrder->getId();
            //写入订单详情
            $this->_insertOrderDetailInfo($orderId,$metaId,$time);

            $result = array('orderid' => $orderId, 'ordersn' => $ordersn, 'time' => $time, 'amount' => $amount, 'title' => $title, 'notify' => $this->getNotifyUrl($platform),'platform'=>$platform);
            if($platform == 4){
                $trade_no      = $this->makeOrderSn();
                $payTime       = $this->getTimestamp();
                $payStatus     = 2;

                $this->_updateOrderInfo($orderId,$platform,$trade_no,$payStatus,$payTime);
                $suiteJson = json_encode($metaInfo);
                if($mode == 1){
                    $endTime = strtotime($termDate) + 86399;
                    $metaInfo['sheet'] = $metaInfo['sheet']*$num;
                    $metaInfo['term'] = $days;
                    $metaInfo['num'] = $num;
                    $metaInfo['amount'] = $amount;
                    $this->_insertSuiteInfo($bizId,$metaInfo,$time,$endTime,$suiteJson);
                }
                if(in_array($mode,[2,3])){
                    $this->_insertSuiteLog(0,'',$termInfo,$payTime);
                    $metaInfo['amount'] = $termInfo['amount']+$amount;
                    $termInfo['metaid'] = $metaId;
                    if($mode == 2){//新增员工
                        $metaInfo['num']          = $termInfo['num'] + $num;
                        $metaInfo['sheet']        = $metaInfo['sheet']*$num;

                    }else{//默认是续费
                        $metaInfo['term']    = $termInfo['term'] + $diffObject->days;
                        $termInfo['end_time'] = strtotime($termDate) + 86399;
                    }
                    $this->_updateSuiteInfo($termInfo,$payTime,$suiteJson);
                }
                $order_detail = json_encode(['trade_no' => $trade_no, 'modify_time' => $payTime]);
                //订单详情 更新
                $this->_updateOrderDetail($orderId,$trade_no,$payTime,$order_detail);
            }
            $this->getConnection()->commit();
            $result['paystatus'] = $payStatus;
            $result['platform']  = $platform;
            return array('errorcode' => Errors::$SUCCESS_OK, 'description' => 'SUCCESS_OK','data'=>$result);
        }catch(\Exception $ex){
            $this->getConnection()->rollback();
            $logger = $this->container->get("logger");
            $logger->error("_notifyRenewSuite error info :", array('message' => $ex->getMessage(), 'code' => $ex->getCode(), 'file' => $ex->getFile(), 'line' => $ex->getLine(), 'trace' => $ex->getTrace()));
            return array('errorcode' => Errors::$FAILED, 'description' => 'FAILED');
        }
    }

    /***
     * 各自回调的URL
     * @param $platform
     * @return string
     * @version 0.0.1 2017-10-10
     * @Author qiuzhigang
     */
    public function getNotifyUrl($platform){
        if($platform == 1){
            $notify = "/wxbiz/payment/alipay";
        }elseif($platform == 2){
            $notify = "/wxbiz/payment/wxpay";
        }elseif($platform == 3){
            $notify = "/wxbiz/payment/unionpay";
        }else{
            $notify = '';
        }
        return $notify;
    }

    /***
     * 生成19位长度的订单号
     *
     * @return string
     * @version 0.0.1 2017-10-10
     * @Author qiuzhigang
     */
    public function makeOrderSn(){
        list($usec, $sec) = explode(" ", microtime());
        $order_id_main = date('ymdHis', $sec) . str_pad(ceil($usec * 100000), 5, 0, STR_PAD_LEFT);//订单号码主体（YYMMDDHHIISSNNNN）
        $order_id_len  = strlen($order_id_main);//订单号码主体长度
        $order_id_sum  = 0;
        for($i = 0; $i < $order_id_len; $i++){
            $order_id_sum += (int)(substr($order_id_main, $i, 1));
        }
        //唯一订单号码（YYMMDDHHIISSNNNNCC）
        return $order_id_main . str_pad((100 - $order_id_sum % 100) % 100, 2, '0', STR_PAD_LEFT);
    }

    /***
     * 拼装订单对象
     *
     * @param $num
     * @param $platform
     * @param $time
     * @param $days
     * @param $orderSn
     * @param $amount
     * @param $termDate
     * @return WxBizOrder
     * @version 0.0.2 2017-11-08
     * @author qiuzhigang
     */
    private function _insertWxBizOrder( $platform, $time, $orderSn, $amount, $termDate, $orderType,$metadata,$bizId,$accountId,$payAmount,$orderSource=2,$discountSource=''){
        $wxBizOrder = new WxBizOrder();
        $wxBizOrder->setOrderSn($orderSn);
        $wxBizOrder->setBizId($bizId);
        $wxBizOrder->setAccountId($accountId);
        $wxBizOrder->setOrderType($orderType);
        $wxBizOrder->setOrderSource($orderSource);
        $wxBizOrder->setPayStatus(1);
        $wxBizOrder->setNum($metadata['num']);
        $wxBizOrder->setPrice($metadata['price']);//总金额
        $wxBizOrder->setTotalAmount($amount);
        $wxBizOrder->setPayAmount($payAmount);
        $wxBizOrder->setDiscountAmount($amount-$payAmount);
        $wxBizOrder->setDiscountSource($discountSource);
        $wxBizOrder->setTermTime($metadata['buy_month']);
        $wxBizOrder->setTermDate($termDate);
        $wxBizOrder->setPlatform($platform);
        $wxBizOrder->setCreateTime($time);
        $wxBizOrder->setMetadata(json_encode($metadata));
        return $wxBizOrder;
    }

    /***
     * 针对再次支付时处理以及回掉处理
     *
     * @param $orderInfo 订单信息
     * @param $notifyData 回调返回的数据
     * @param $payTime 支付时间
     * @param $platform 支付平台
     * @return int
     * @version 0.0.1 2017-10-18
     * @author qiuzhigang
     */
    public function notifySuite($orderInfo, $notifyData, $payTime, $platform){
        $trade_no  = $notifyData['trade_no'];
        $payStatus = 2;
        $orderId   = $orderInfo['id'];

        $termInfo = $this->checkBizTermInfoByBizId($orderInfo['biz_id']);
        //从订单获取数据
        $metaInfo = json_decode($orderInfo['metadata'],true);
        $this->getConnection()->beginTransaction();
        try{
            //执行更新sql语句
            $this->_updateOrderInfo($orderId,$platform,$trade_no,$payStatus,$payTime);
            $orderType = $orderInfo['order_type'];
            $suiteJson = json_encode($metaInfo);
            if(in_array($orderType,[2,3])){
                //写入更新日志
                $this->_insertSuiteLog(0,'',$termInfo,$payTime);
                $termInfo['amount'] = $termInfo['amount']+$orderInfo['amount'];
                $termInfo['metaid'] = $metaInfo['id'];
                if($orderInfo['order_type'] == 3){//续费操作
                    if($termInfo['end_time'] > $orderInfo['create_time']){
                        $datetime = date("Y-m-d", $termInfo['end_time']);
                    }else{
                        $datetime = date("Y-m-d", $orderInfo['create_time']);
                    }
                    $dateObject     = new DateTime($datetime);
                    $dateObjectTerm = new DateTime($orderInfo['term_date']);
                    $diffObject     = $dateObjectTerm->diff($dateObject);
                    $termInfo['term'] = $termInfo['term'] + $diffObject->days;
                    $termInfo['end_time'] =  strtotime($orderInfo['term_date']) + 86399;

                }elseif($orderInfo['order_type'] == 2){//新增员工
                    $termInfo['num']  = $termInfo['num'] + $orderInfo['num'];
                    $termInfo['sheet'] = $termInfo['sheet']+$orderInfo['num']*$metaInfo['sheet'];
                }
                $this->_updateSuiteInfo($termInfo,$payTime,$suiteJson);
            }

            if($orderInfo['order_type'] == 1){//初次购买
                $endTime      = strtotime($orderInfo['term_date']) + 86399;
                $metaInfo['term'] = $orderInfo['term_time'];
                $metaInfo['sheet'] =$metaInfo['sheet']*$orderInfo['num'];
                $metaInfo['num'] = $orderInfo['num'];
                $metaInfo['amount'] = $orderInfo['amount'];

                $this->_insertSuiteInfo($orderInfo['biz_id'],$metaInfo,$payTime,$endTime,$suiteJson);
            }

            //更新订单详情记录
            $notifyData['modify_time'] = $payTime;
            $order_detail = json_encode($notifyData);
            $this->_updateOrderDetail($orderId,$trade_no,$payTime,$order_detail);

            $this->getConnection()->commit();

            return 100;
        }catch(\Exception $ex){
            $this->getConnection()->rollback();
            $logger = $this->container->get("logger");
            $logger->error("_notifyRenewSuite error info :", ['message' => $ex->getMessage(),
                'code' => $ex->getCode(),
                'file' => $ex->getFile(),
                "line" => $ex->getLine(),
                'trace' => $ex->getTrace()]);

            return 99;//错误回滚哦
        }
    }


    /***
     * 针对再次支付时处理以及回掉处理 新版
     *
     * @param array $orderInfo 订单信息
     * @param array $notifyData 回调返回的数据
     * @param int $payTime 支付时间
     * @param int $platform 支付平台 1 支付宝 2微信 3银联 4 系统内部支付
     * @return int
     * @version 0.0.1 2017-11-08
     * @author qiuzhigang
     */
    public function newnotifysuite($orderInfo, $notifyData, $payTime, $platform){
        $trade_no  = $notifyData['trade_no'];
        $payStatus = 2;
        $orderId   = $orderInfo['id'];

        $termInfo = $this->checkBizTermInfoByBizId($orderInfo['biz_id']);
        //从订单获取数据
        $metaInfo = json_decode($orderInfo['metadata'],true);
        $this->getConnection()->beginTransaction();
        try{
            //订单更新
            $this->_updateOrderInfo($orderId,$platform,$trade_no,$payStatus,$payTime);
            $orderType = $orderInfo['order_type'];
            $suiteJson = $orderInfo['metadata'];
            if($orderType == 1){//初次购买
                $endTime      = strtotime($orderInfo['term_date'])-1;
                $this->_insertSuiteInfo($orderInfo['biz_id'],$metaInfo,$payTime,$endTime,$suiteJson);
            }

            if(in_array($orderType,[3,4])){
                $this->_insertSuiteLog(0,'',$termInfo,$payTime);
                $termInfo['sheet'] = $metaInfo['sheet'];
                $termInfo['amount'] = $termInfo['amount']+$orderInfo['pay_amount'];

                $termInfo['endTime'] = strtotime($orderInfo['term_date'])-1;
                $termInfo['num'] = $metaInfo['num'];
                $termInfo['term'] = $termInfo['term']+$metaInfo['buy_month'];
                $termInfo['metaid'] = $metaInfo['id'];
                if($orderType == 4){//升级套餐
                    //获取升级套餐生效开始时间
                    $timestamp = $this->getLastMonthFirstDayTime($orderInfo['create_time'],0,1);
                    //如果原有套餐的有效期大于升级套餐生效的开始时间 进行金额抵扣处理
                    if($timestamp<$termInfo['end_time']){
                        //结束时间
                        $dateObjecOriginal  = new DateTime(date('Y-m-d', ($termInfo['end_time']+1)));
                        //升级套餐开始生效时间与原套餐有效期截止时间  比较 获取剩余的月份时间
                        $datetime = $this->getLastMonthFirstDayTime($orderInfo['create_time'],0,0);
                        $dateObjectTerm = new DateTime($datetime);//开始日期
                        $diffObjectOriginal = $dateObjectTerm->diff($dateObjecOriginal);
                        $termInfo['term'] = $termInfo['term'] - $diffObjectOriginal->m +$orderInfo['month'];
                    }
                }
                $this->_updateSuiteInfo($termInfo,$payTime,$suiteJson);
            }

            //更新订单详情记录
            $notifyData['modify_time'] = $payTime;
            $order_detail = json_encode($notifyData);
            $this->_updateOrderDetail($orderId,$trade_no,$payTime,$order_detail);
            $this->getConnection()->commit();
            return 100;
        }catch(\Exception $ex){
            $this->getConnection()->rollback();
            $logger = $this->container->get("logger");
            $logger->error("_notifyRenewSuite error info :", ['message' => $ex->getMessage(),'code' => $ex->getCode(), 'file' => $ex->getFile(), 'line' => $ex->getLine(), 'trace' => $ex->getTrace()]);
            //throw $ex;
            return 99;//错误回滚哦
        }
    }

    /***
     * 运营赠送套餐 升级套餐 延期套餐
     * @param $bizid
     * @param $metaid
     * @param $mode 值 1新增,3续费,4升级
     * @param int $adminid
     * @param string $adminname
     * @return array
     */
    public function givetrialsuite($bizid,$metaid,$mode=1,$adminid=0,$adminname=''){

        if(empty($bizid)||strlen(trim($bizid))<1||empty($metaid)||$metaid<0||$adminid<0||empty($adminid)){
            return Errors::$ERROR_PARAMETER_NOT_ENOUGH;
        }

        if(!in_array($mode,[1,3,4])){
            return Errors::$ERROR_PARAMETER_NOT_ENOUGH;
        }
        $employeeInfo = $this->_getBizInfoAndEmployee($bizid);
        if(empty($employeeInfo)||!isset($employeeInfo)){
            return Errors::$ACCOUNT_BIZ_NOT_EXISTS_EMPLOYEE;
        }
        $accountid = $employeeInfo['id'];
        return $this->newpurchase($mode,4,$metaid,$bizid,$accountid,2,$adminid,$adminname);
    }


    /***
     * 获取企业超级管理信息
     * @param $bizid
     * @param bool $field
     * @return array|mixed
     */
    private function _getBizInfoAndEmployee($bizid,$field=true){
        $res = [];
        if(empty($bizid)||strlen(trim($bizid))<1){
            return $res;
        }
        $where = "WHERE biz_id = :bizid AND role_id = 1 AND enable = 1 AND is_del=0 LIMIT 1 ";
        if($field===true){
            $field = "*";
        }
        $sql = "SELECT ".$field." FROM `wx_biz_employee` ".$where;
        $res   = $this->getConnection()->executeQuery($sql,[':bizid'=>$bizid])->fetch();
        return $res;
    }
}