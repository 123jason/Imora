<?php
namespace Oradt\ServiceBundle\Services;
use Oradt\Utils\RandomString;
use Oradt\Utils\Errors;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Oradt\Utils;
use Oradt\StoreBundle\Entity\BasicOrderAbnormal;

/**
 * 订单相关
 */
class OrderService extends BaseService {
    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
    }
    
    /**
     * 订单操作日志记录表
     * @param string $orderId   订单ID
     * @param string $type      用户类型  1：Basic用户  2：Admin用户  3:系统自动确认
     * @param string $accoutId  用户ID
     * @param int    $action    动作 
     * 1：提交订单      2：支付订单       3：删除订单       4：取消订单
     * 5：卖家已确认    6：卖家拒绝出售   7：买家已确认【待结算】     8：买家申请退款  
     * 9：卖家同意退款  10：卖家拒绝退款  11：客服已受理【冻结】
     * 12：待退款       13：已退款        14：财务已结算   15：买方取消退款
     */
    public function insertOrderLog($orderId,$type=1,$action,$accoutId){
        $params = array( 
            ':order_id' => $orderId, 
            ':type'     => $type, 
            ':action'   => $action, 
            ':account_id'   => $accoutId, 
            ':created_time' => $this->getTimestamp()
        );
        $insertQuery = "INSERT INTO basic_order_log (order_id,type,action,account_id,created_time) 
                VALUES(:order_id,:type,:action,:account_id,:created_time)";
        $this->em->getConnection()->executeUpdate($insertQuery , $params);
        return true;
    }
    
    /**
     * 向gearman 发送消息
     * @param string $orderId 订单id
     * @param string $jobType  GetVcardFaild(卖方3天未确认的任务) | RefusedRefund （卖方拒绝退款5天买方未处理的）| ConfirmOrder（买方5天未确认订单的）
     * @param int    $executeTime 任务执行时间（时间戳）
     */
    public function sendGearMan($orderId,$jobType,$executeTime){
        $gearmanPar = json_encode(array('order_id'=>$orderId));
        $gearOp = array(
            "op"        => "add",
            "time"      => $executeTime,
            "name"      => $orderId,
            "jobType"   => $jobType,
            "params"    => $gearmanPar
        );
        $gearmanService = $this->container->get ( 'gearman_service');
        $gearmanService->push_job("order", $gearOp);
    }

    /**
     * 支付成功 回调 更改订单状态
     * @param string $orderId  订单号
     * @param string $tradeNo  交易流水号【支付宝or微信】
     */
    public function updateOrderStatus($orderId,$tradeNo=''){
        if(empty($orderId)) return '';
        //查看订单是否存在
        $lastSql    = "SELECT * FROM basic_order WHERE order_id =:uuid";
        $orderArr   = $this->getConnection()->executeQuery($lastSql, array(":uuid"=>$orderId))->fetch();
        if(empty($orderArr)){
            return $this->retErr ( Errors::$DESIGN_ERROR_NO_DATA,'basic_order' );
        }
        $setParams  = array();      //修改订单的数组值
        $userId     = $orderArr['user_id'];     //购买人id
        $toUserId   = !empty($orderArr['to_userid']) ? $orderArr['to_userid'] : '';  //收款人id 即：名片持有人id
        $paystatus  = $orderArr['paystatus'];   //支付状态
        $status     = $orderArr['status'];      //订单状态
        $type       = (int)$orderArr['type'];        //订单类型 1：名片 2：会员充值 3：扩容
        $remark     = $orderArr['remark'];      //购买时填写备注信息
        $content    = json_decode($orderArr['content'], TRUE);   
        $vcardId    = $orderArr['goods_id'];    //若购买的是名片 则是名片id，若为充值或扩容则为规则id
        //判断订单状态是否是正常状态
        if($status != 1){
            return $this->retErr ( Errors::$DESIGN_ERROR_TRADE_STATUS_ERROR);
        }
        $this->getConnection()->beginTransaction();
        try {
            $modifyTime = $this->getTimestamp();
            if($paystatus == 1){    //未支付状态
                $setParams[':status']      = 2;  //已支付
                $setParams[':paystatus']   = 2;  //已支付
                $setParams[':modify_time'] = $modifyTime;
                $setParams[':end_time']    = $modifyTime;  
                $setParams[':trade_no']    = $tradeNo;
            }
            $setParams[':orderid'] = $orderId;
            $updateOrderSql    = "UPDATE basic_order SET status = :status,
                paystatus=:paystatus,modify_time=:modify_time,end_time=:end_time,
                trade_no=:trade_no WHERE order_id =:orderid";
            $this->getConnection()->executeUpdate($updateOrderSql, $setParams);

            //如果订单类型为名片类型，则给名片持有人发送【请赐名片的申请】消息
            if($type === 1){
                //获取购买人的信息
                $accountService = $this->container->get ( 'account_basic_service' );
                $fUserInfo   = $accountService->getUserInfo($userId);
                $sendMessage = array(
                    'orderid'   => $orderId,    //订单id
                    'accountid' => $userId,     //购买人id
                    'realname'  => $fUserInfo['real_name'],   //购买人姓名
                    'title'     => $fUserInfo['title'],       //购买人职位
                    'company'   => $fUserInfo['company'],     //购买人公司
                    'remark'    => $remark, 
                    'vcardid'   => $vcardId, 
                    'vcardpic'  => $content['pic'], 
                    'createdtime'=> $this->getTimestamp()
                );
                $this->pushMessage(250, $toUserId, $sendMessage, $userId,"赐予名片申请");
                //发送支付成功3天后为处理的gearman数据
                $threeDays = $modifyTime+3*24*60*60;    //3天后
                $this->sendGearMan($orderId,"GetVcardFaild", $threeDays);
            }else{
                //获取U8支付方式编码
                $u8Zfstyle  = $this->getU8ZfStyle();
                if(!empty($u8Zfstyle)){
                    $zfstyle    = $u8Zfstyle[$orderArr['payment']];     //1企业支付 2支付宝 3微信 4apply pay
                }else{
                    $zfstyle    = $orderArr['payment'];     //1企业支付 2支付宝 3微信 4apply pay
                }
                $zfmoney    = $orderArr['price'];       //价格
                $payTime    = $this->getTimestamp();    //支付日期
                
                //会员充值、容量购买
                //获取账户原有时长 或 容量
                $lastSql    = "SELECT b.mobile,d.real_name,d.created_time,d.expiry_date,d.card_capacity FROM account_basic AS b
                    LEFT JOIN account_basic_detail AS d ON b.user_id = d.user_id
                    WHERE b.user_id =:userid;";
                $basicArr   = $this->getConnection()->executeQuery($lastSql, array(":userid"=>$userId))->fetch();
                if(empty($basicArr)){
                    return $this->retErr ( Errors::$ERROR_ACCOUNT_NOEXISTS);
                }
                $cardDateNum = (int)$content['num'];     //多少张 或 多少个月
                if(2===$type){        //购买会员（以月为单位）
                    $expiry_date    = $basicArr['expiry_date'];     //到期时间
                    //针对之前的老账户 如果过期时间为空，则再注册时间的基础上加一个月用来做 添加会员的基础
                    if(empty($expiry_date)){
                        // 老账户为0，创建时间+30天有可能还会小于当前时间，应该以当前时间为准
                        // $expiry_date = strtotime($basicArr['created_time'])+3600*24*30;
                        $expiry_date  = $modifyTime;
                    }else{
                        //查看当前时间是否大于到期时间 如果大于 则在当天基础上加
                        $nowTime = $this->getTimestamp();
                        if($nowTime > $expiry_date){
                            $expiry_date = $modifyTime;
                        }
                    }
                    $ksdate = $expiry_date;
                    //在原到期基础上加 几个月 1个月以30天为准
                    //【产品定义】月以30天为准，12个月以365天为准 
                    if($cardDateNum % 12 == 0){
                        $expiry_date = $expiry_date + 3600*24*365*($cardDateNum/12);
                    }else{
                        $expiry_date = $expiry_date + 3600*24*30*$cardDateNum;
                    }
                    $jsdate = $expiry_date;
                    //更新
                    $upDateParam    = array(
                        ':expiry_date'  =>$expiry_date,
                        ':user_id'      =>$userId
                    );
                    $upDateSql = "UPDATE account_basic_detail SET expiry_date=:expiry_date WHERE user_id =:user_id";
                    $this->getConnection()->executeUpdate($upDateSql,$upDateParam);
                    $gearOp = array(
                        'ccode'     => $orderId,
                        'ddate'     => $payTime,
                        'zfstyle'   => $zfstyle,
                        'zfmoney'   => $zfmoney,
                        'ksdate'    => $ksdate,
                        'jsdate'    => $jsdate,
                        'zfcode'    => $tradeNo
                    );
                    $this->sendGearManU8("hyjl",$gearOp);
                    //记录会员日志
                    $this->insertMemberLengLog(2, $userId, $ksdate, $jsdate,"购买{$cardDateNum}个月会员:{$orderId}");
                }elseif(3===$type){  //购买容量扩容（以张为单位）
                    $card_capacity  = $basicArr['card_capacity'];   //名片容量
                    $card_capacity  = $card_capacity+$cardDateNum;  //在原基础上加容量
                    //更新
                    $upCardParam    = array(
                        ':card_capacity'    => $card_capacity,
                        ':user_id'          => $userId
                    );
                    $upCardSql = "UPDATE account_basic_detail SET card_capacity=:card_capacity WHERE user_id =:user_id;";
                    $this->getConnection()->executeUpdate($upCardSql,$upCardParam);
                    $gearOp = array(
                        'ccode'     => $orderId,
                        'ddate'     => $payTime,
                        'zfstyle'   => $zfstyle,
                        'zfmoney'   => $zfmoney,
                        'zfcode'    => $tradeNo
                    );
                    $this->sendGearManU8("mrljl",$gearOp);
                }
            }
            //记录订单日志
            $this->insertOrderLog($orderId,1,2,$userId);
            $this->getConnection()->commit();
            return 'success';
        } catch (Exception $ex) {
            $this->getConnection()->rollback();
            return 'database persist failed';
        } 
    }
    /**
     * @param type $type 
     */
    public function sendGearManU8($type,$param){
        $gearmanService = $this->container->get ( 'gearman_service');
        $gearOp = array(
            'type'   => $type,
            'params' => json_encode($param)
        );
        $gearmanService->push_job("OrderU8", $gearOp);
        return true;
    }
    
    /**
     * 获取u8支付方式
     */
    public function getU8ZfStyle(){
        $zfArr  = array();
        $sql = "SELECT * FROM lcwy_zfstyle";
        $zfstyle  = $this->getManager('u8db')->getConnection()->executeQuery($sql)->fetchAll();
        if(!empty($zfstyle)){
            foreach ($zfstyle as $val) {
                $zfArr[$val['id']] = $val['u8code'];
            }
        }
        return $zfArr;
    }
    
    private function retErr($err,$desc=''){
        if(!empty($desc)){
            $err['description'] = sprintf($err['description'],$desc);
        }
    	return $err['errorcode'].':'.$err['description'];
    }
    
    
    /**
     * 更新订单状态 ，只支持某几个参数更改
     * @param string    $orderId       订单id
     * @param string    $status        订单状态
     * @param string    $paystatus     订单支付状态
     * @param string    $map_vcardid   名片id（成功发货后生成的名片id）
     */
    public function putOrderStatusLess($orderId,$status,$map_vcardid='',$paystatus=''){
        //更改订单信息
        $setOrderParams = array(
            ':orderid'      => $orderId,
            ':status'       => $status,   
            ':modify_time'  => $this->getTimestamp()
        );
        $setString = '';
        if(!empty($map_vcardid)){
            $setOrderParams[':map_vcard_id'] = $map_vcardid;
            $setString = ',map_vcard_id=:map_vcard_id';
        }
        if(!empty($paystatus)){
            $setOrderParams[':paystatus'] = $paystatus;
            $setString = ',paystatus=:paystatus';
        }
        $updateOrderSql    = "UPDATE basic_order SET status = :status,
            modify_time=:modify_time{$setString} WHERE order_id =:orderid";
        $this->getConnection()->executeUpdate($updateOrderSql, $setOrderParams);
        return TRUE;
    }
    
    /**
     * 支付宝退款后订单的逻辑处理方法【此方法未记录订单已退款日志】
     * @param string $orderId           橙脉订单id
     * @param float  $refundAmount      退款金额  
     * return 
     */
    public function alipayTradeRefund($orderId,$refundAmount){
        if(empty($orderId) && empty($refundAmount)){
            return false;
        }
        //订单状态 和 订单支付状态都更新为已退款
        $status = $payStatus = 4;  
        //订单支付宝详情表
        $upParam=  array(
            ":is_refund"        => 1,             //1：退款订单
            ":refund_amount"    => 0,             //退款金额
            ":refund_status"    => 0,             //退款状态
            ":gmt_refund"       => 0,             //退款时间
            ":orderid"          => $orderId,      //订单ID
            ":design_fail_reason"    => ''        //退款失败原因
        );
        $aliPayService  = $this->container->get("alipay_sdk_service");
        $tradeResult    = $aliPayService->getAlipayTradeRefund($orderId,$refundAmount);
        if(is_array($tradeResult)){  //此处处理本地订单流程
            $resultStatus = $tradeResult['status'];
            if($resultStatus == 'success'){
                //支付宝退款成功
                $upParam[':refund_amount']  = $tradeResult['refund_fee'];
                $upParam[':refund_status']  = 1;
                $upParam[':design_fail_reason']  = $tradeResult['trade_no'];
                $upParam[':gmt_refund']     = strtotime($tradeResult['gmt_refund_pay']);
            }else{
                //支付宝退款失败
                $upParam[':refund_status']       = 2;           //退款失败
                $upParam[':design_fail_reason']  = $tradeResult['msg'];       //失败原因
            }
        }
        //更新支付宝支付记录状态及退款信息
        $upAlipaySql    = "UPDATE basic_order_alipay_info SET is_refund = :is_refund,
            refund_amount=:refund_amount,refund_status=:refund_status,gmt_refund=:gmt_refund,
            design_fail_reason=:design_fail_reason WHERE order_id =:orderid";
        $this->getConnection()->executeUpdate($upAlipaySql, $upParam);
        //更新订单状态
        $this->putOrderStatusLess($orderId,$status,'',$payStatus);
        return true;
    }
    
    /**
     * 微信退款接口申请,申请成功后 并查询退款【此方法未记录订单已退款日志】
     * @param string $orderId           橙脉订单id
     * @param float  $refundAmount      退款金额 【元】
     * return 
     */
    public function wxpayTradeRefund($orderId,$refundAmount){
        if(empty($orderId) && empty($refundAmount)){
            return false;
        }
        $price = $refundAmount*100;    //到分
        //查询订单 查看是否有 微信订单号
        $wxpayInfo = $this->em->getRepository ( 'OradtStoreBundle:BasicOrderWxpayInfo')
                          ->findOneBy(array('orderId'=>$orderId));
        if (empty($wxpayInfo)) {
            return false;
        }
        $wxpayInfo->setIsRefund(1);     //1表示是退款订单
        $transactionId  = $wxpayInfo->getTransactionId();       //微信订单号
        $WxPayService   = $this->container->get("weixin_pay_service");
        $getRefund      = $WxPayService->getWxPayRefund($orderId,$price,$transactionId);
        if(array_key_exists("return_code", $getRefund) && $getRefund["return_code"] == "SUCCESS"){
            if($getRefund['result_code'] == "SUCCESS"){
                //微信返回参数如下
                $orderRefundId  = $getRefund['out_refund_no'];        //商户退款单号
                $refundId       = $getRefund['refund_id'];             //微信退款单号
                $refund_fee     = $getRefund['refund_fee'];           //申请退款金额
                $refund_status  = '1';         //退款处理中
                //更新数据表
                $wxpayInfo->setOrderRefundId($orderRefundId);
                $wxpayInfo->setRefundId($refundId);
                $wxpayInfo->setRefundFee($refund_fee);
                $wxpayInfo->setRefundStatus($refund_status);
                //查询退款
                $refundQuery = $WxPayService->getWxRefundQuery($orderId,$orderRefundId,$transactionId,$refundId);
                if(array_key_exists("return_code", $refundQuery) && $refundQuery["return_code"] == "SUCCESS" &&
                   array_key_exists("result_code", $refundQuery) && $refundQuery["result_code"] == "SUCCESS" ){
                    $refund_recv_accout = $refundQuery['refund_recv_accout_0'];        //退款入账户
                    $refund_status      = $refundQuery['refund_status_0'];             //退款状态  
                    if(isset($refundQuery['refund_channel_0'])){
                        $refund_channel     = $refundQuery['refund_channel_0'];           //退款渠道
                        $wxpayInfo->setRefundChannel($refund_channel);
                    }
                    //更新数据表
                    $wxpayInfo->setRefundRecvAccount($refund_recv_accout);
                    $wxpayInfo->setRefundStatus($refund_status);
                }
            }
        }
        //更新微信支付表数据
        $this->em->persist($wxpayInfo);        
        $this->em->flush();
        //更新橙脉订单状态 已退款状态
        $status = $payStatus = 4; //已退款状态
        $this->putOrderStatusLess($orderId,$status,'',$payStatus);
        return TRUE;
    }
    
    /**
     * 订单退款总方法【此方法未记录订单已退款日志】
     * @param string $payment           退款类型2：支付宝  3：微信 ...[和订单表支付类型一致]
     * @param string $orderId           橙脉订单id
     * @param float  $refundAmount      退款金额 【元】
     * return 
     */
    public function getImoraOrderRefund($payment,$orderId,$refundAmount){
        if(empty($orderId) || empty($refundAmount)){
            return FALSE;
        }
        switch ($payment){
            case 2:     
                return $this->alipayTradeRefund($orderId,$refundAmount);  //支付宝退款方法
                break;
            case 3:
                return $this->wxpayTradeRefund($orderId,$refundAmount);  //微信退款方法
                break;
        }
        return true;
    }
    
    /**
     * 写入异常流程订单表 （买方申请退款后写入 或 客服冻结时写入）
     * @param string $orderId   订单id
     * @param string $reason    买方申请退款时描述原因
     */
    public function insertAbnormalOrder($orderId,$reason=''){
        $basicOrderAbnormal  = $this->em->getRepository ( 'OradtStoreBundle:BasicOrderAbnormal')
                   ->findOneBy(array('orderId'=>$orderId));
        if(empty($basicOrderAbnormal)){
            $basicOrderAbnormal = new BasicOrderAbnormal();
        }else{
            // bug 17522 :退款理由没有变化
            if (empty($reason)) {
                $reason = $basicOrderAbnormal->getBuyer();   
            }
        }
        $createTime = $this->getTimestamp();
        $basicOrderAbnormal->setOrderId($orderId);
        $basicOrderAbnormal->setBuyer($reason);     //买方描述
        $basicOrderAbnormal->setSaler("");          //卖方描述
        $basicOrderAbnormal->setCustomerId("");     //客服id
        $basicOrderAbnormal->setCustomer("");       //客服描述
        $basicOrderAbnormal->setPersonLiable(1);    //1：未定责
        $basicOrderAbnormal->setStatus(1);          //1：暂存
        $basicOrderAbnormal->setCreatedTime($createTime);
        $this->em->persist($basicOrderAbnormal);        
        $this->em->flush();
        return true;
    }
    
    /**
     * 生成订单id
     */
    public function createOrderId(){
        $seed   = $this->_getSeed();
        $prefix = date("Ymd",time());
        $orderId  = $this->_luhnEncrypt($aa, $prefix);
        return $orderId;
    }
    /**
     * luhn
     */
    private function _luhnEncrypt($seed, $prefix, $bits = 6)
    {
        $format = "%2s%0{$bits}d";
        $origin = sprintf($format, $prefix, $seed);
        
        $len = strlen($origin);
        $sum = 0;
        for ($i = 0; $i < $len; $i++) {
            $sum += ord($origin[$i]) - 48;
        }
        $x = 0;
        for ($i = 9; $i > 0; $i--) {
            if ($sum % $i == 0) {
                $x = $i;
                break;
            }
        }
        $y = (10 - ($sum + $x )% 10) % 10;
//        echo "sum: $sum X: $x Y: $y" . PHP_EOL;
        $res = substr_replace($origin, $x, -1, 0);
        $res = substr_replace($res, $y, strlen($res), 0);
        return $res;
    }
    
    /**
     * 获取种子
     * 自然增长数最大6为数，初始值为012583，自然增长数每到新的一年，初始值回归012583
     */
    public function _getSeed(){
        $start_magic = 12583;
        $query_sql = 'SELECT order_id FROM `basic_order` ORDER BY id DESC LIMIT 1';
        $redeem_code = $this->getConnection()->executeQuery($query_sql)->fetch();
        if (empty($redeem_code)) {
            return $start_magic;
        } else {
            $year = date('Y');
            $code = $redeem_code['order_id'];
            if (substr($code, 0, 4) != $year) {
                return $start_magic;
            }else{
                return intval( substr( $code, 8, 5 ) . substr( $code, 14, 1 ) ) + 1;
            }
        }
    }

    
    /**
     * 赠送会员方法
     * @param strng  $userId    用户id
     * @param int    $type      类型 3:绑定橙子赠送
     * @param int    $day       赠送的天数(以天为单位)
     * @param int    $des       简单描述比如（首次绑定橙子赠送1年）
     * @param int    $bingId        与橙子端的绑定id
     */
    public function giveMemberByUserId($userId,$type,$day,$des,$bingId){
        if(empty($userId) || empty($type) || empty($day) || empty($des)){
            return false;
        }
        //获取账户原有时长
        $lastSql    = "SELECT d.expiry_date FROM account_basic AS b
            LEFT JOIN account_basic_detail AS d ON b.user_id = d.user_id
            WHERE b.user_id =:userid;";
        $basicArr   = $this->getConnection()->executeQuery($lastSql, array(":userid"=>$userId))->fetch();
        if(empty($basicArr)){
            return false;
        }
        $expiry_date    = $basicArr['expiry_date'];     //获取之前到期时间
        $ksdate = $expiry_date;     //添加前日期（有可能已经过期了）
        //查看当前时间是否大于到期时间 如果大于 则在当天基础上加
        $nowTime = $this->getTimestamp();
        if($nowTime > $expiry_date){
            $expiry_date = $nowTime;
        }
        //在原到期基础上加 赠送的天数 为准
        $expiry_date = $expiry_date + 3600*24*$day;
        $jsdate = $expiry_date;     //添加后日期
        //更新
        $upDateParam    = array(
            ':expiry_date'  =>$expiry_date,
            ':user_id'      =>$userId
        );
        $upDateSql = "UPDATE account_basic_detail SET expiry_date=:expiry_date WHERE user_id =:user_id";
        $this->getConnection()->executeUpdate($upDateSql,$upDateParam);
        //记录会员日志
        $this->insertMemberLengLog($type, $userId, $ksdate, $jsdate, $des,$bingId);
        return true;
    }

    /**
     * 记录会员获取时长的日志 充值/赠送/注册免费
     * @param int    $type          类型 1:注册（默认） 2:购买  3:绑定橙子赠送
     * @param strng  $userId        用户id
     * @param string $beforeTime    购买或绑定前到期时间
     * @param int    $afterTime     购买或绑定后到期时间
     * @param int    $desc          记录的简单描述
     * @param int    $bingId        与橙子端的绑定id
     */
    public function  insertMemberLengLog($type,$userId,$beforeTime,$afterTime,$desc,$bingId=0){
        $intoLogArr = array(
            ':type'     => $type,
            ':userid'   => $userId, 
            ':beforetime' => $beforeTime, 
            ':aftertime'  => $afterTime,
            ':desc'       => $desc,
            ':bingid'     => $bingId,
            ':createdtime'=> $this->getTimestamp()
        );
        $intoLogSql = "INSERT INTO account_basic_member_log (type,user_id,before_time,after_time,note,bing_id,created_time)
                                VALUES(:type,:userid,:beforetime,:aftertime,:desc,:bingid,:createdtime)";
        $this->getConnection()->executeUpdate($intoLogSql , $intoLogArr);
        //根据记录，更新会员等级 1：赠送（注册赠送，绑定赠送等等）  2：会员（购买过的都是正式会员）
        if(in_array($type, array('2','3'))){
            //获取会员等级
            $lastSql    = "SELECT d.id,d.member_level FROM account_basic_detail AS d WHERE d.user_id =:userid;";
            $basicArr   = $this->getConnection()->executeQuery($lastSql, array(":userid"=>$userId))->fetch();
            if(!empty($basicArr)){
                $level    = '';
                $oldLevel = $basicArr['member_level'];
                //如果是赠送会员，则判断前提是否是 0 ：非会员
                if($type == '3'){
                    if($oldLevel == '0')    $level = 1;
                }
                //如果是购买会员，则判断前提是否是 0：非会员 1：赠送会员
                if($type == '2'){
                    if($oldLevel == '0' || $oldLevel == '1')    $level = 2;
                }
                //更改会员等级
                if(!empty($level)){
                    $upDateSql = "UPDATE account_basic_detail SET member_level=:level WHERE user_id =:userid";
                    $this->getConnection()->executeUpdate($upDateSql,array(':level'=>$level,":userid"=>$userId));
                }
            }
        }
        return TRUE;
    }
    
}
