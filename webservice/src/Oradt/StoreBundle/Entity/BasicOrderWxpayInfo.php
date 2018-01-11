<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BasicOrderWxpayInfo
 */
class BasicOrderWxpayInfo
{
    /**
     * @var string
     */
    private $orderId;

    /**
     * @var integer
     */
    private $totalFee;

    /**
     * @var string
     */
    private $feeType;

    /**
     * @var string
     */
    private $prepayId;

    /**
     * @var string
     */
    private $tradeType;

    /**
     * @var string
     */
    private $returnCode;

    /**
     * @var string
     */
    private $returnMsg;

    /**
     * @var string
     */
    private $resultCode;

    /**
     * @var string
     */
    private $deviceInfo;

    /**
     * @var string
     */
    private $errCode;

    /**
     * @var string
     */
    private $errCodeDes;

    /**
     * @var string
     */
    private $startTime;

    /**
     * @var string
     */
    private $transactionId;

    /**
     * @var string
     */
    private $notifyRetcode;

    /**
     * @var string
     */
    private $notifyRetmsg;

    /**
     * @var string
     */
    private $notifyResult;

    /**
     * @var string
     */
    private $notifyErrcode;

    /**
     * @var string
     */
    private $notifyErrdes;

    /**
     * @var string
     */
    private $tradeState;

    /**
     * @var string
     */
    private $queryReturnCode;

    /**
     * @var string
     */
    private $queryReturnMsg;

    /**
     * @var string
     */
    private $queryResultCode;

    /**
     * @var string
     */
    private $queryErrCode;

    /**
     * @var string
     */
    private $queryErrCodeDes;

    /**
     * @var string
     */
    private $timeEnd;

    /**
     * @var string
     */
    private $tradeStateDesc;

    /**
     * @var string
     */
    private $orderRefundId;

    /**
     * @var integer
     */
    private $isRefund;

    /**
     * @var string
     */
    private $refundId;

    /**
     * @var string
     */
    private $refundStatus;

    /**
     * @var string
     */
    private $refundChannel;

    /**
     * @var integer
     */
    private $refundFee;

    /**
     * @var integer
     */
    private $settlementRefundFee;

    /**
     * @var string
     */
    private $refundRecvAccount;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set orderId
     *
     * @param string $orderId
     * @return BasicOrderWxpayInfo
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
    
        return $this;
    }

    /**
     * Get orderId
     *
     * @return string 
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * Set totalFee
     *
     * @param integer $totalFee
     * @return BasicOrderWxpayInfo
     */
    public function setTotalFee($totalFee)
    {
        $this->totalFee = $totalFee;
    
        return $this;
    }

    /**
     * Get totalFee
     *
     * @return integer 
     */
    public function getTotalFee()
    {
        return $this->totalFee;
    }

    /**
     * Set feeType
     *
     * @param string $feeType
     * @return BasicOrderWxpayInfo
     */
    public function setFeeType($feeType)
    {
        $this->feeType = $feeType;
    
        return $this;
    }

    /**
     * Get feeType
     *
     * @return string 
     */
    public function getFeeType()
    {
        return $this->feeType;
    }

    /**
     * Set prepayId
     *
     * @param string $prepayId
     * @return BasicOrderWxpayInfo
     */
    public function setPrepayId($prepayId)
    {
        $this->prepayId = $prepayId;
    
        return $this;
    }

    /**
     * Get prepayId
     *
     * @return string 
     */
    public function getPrepayId()
    {
        return $this->prepayId;
    }

    /**
     * Set tradeType
     *
     * @param string $tradeType
     * @return BasicOrderWxpayInfo
     */
    public function setTradeType($tradeType)
    {
        $this->tradeType = $tradeType;
    
        return $this;
    }

    /**
     * Get tradeType
     *
     * @return string 
     */
    public function getTradeType()
    {
        return $this->tradeType;
    }

    /**
     * Set returnCode
     *
     * @param string $returnCode
     * @return BasicOrderWxpayInfo
     */
    public function setReturnCode($returnCode)
    {
        $this->returnCode = $returnCode;
    
        return $this;
    }

    /**
     * Get returnCode
     *
     * @return string 
     */
    public function getReturnCode()
    {
        return $this->returnCode;
    }

    /**
     * Set returnMsg
     *
     * @param string $returnMsg
     * @return BasicOrderWxpayInfo
     */
    public function setReturnMsg($returnMsg)
    {
        $this->returnMsg = $returnMsg;
    
        return $this;
    }

    /**
     * Get returnMsg
     *
     * @return string 
     */
    public function getReturnMsg()
    {
        return $this->returnMsg;
    }

    /**
     * Set resultCode
     *
     * @param string $resultCode
     * @return BasicOrderWxpayInfo
     */
    public function setResultCode($resultCode)
    {
        $this->resultCode = $resultCode;
    
        return $this;
    }

    /**
     * Get resultCode
     *
     * @return string 
     */
    public function getResultCode()
    {
        return $this->resultCode;
    }

    /**
     * Set deviceInfo
     *
     * @param string $deviceInfo
     * @return BasicOrderWxpayInfo
     */
    public function setDeviceInfo($deviceInfo)
    {
        $this->deviceInfo = $deviceInfo;
    
        return $this;
    }

    /**
     * Get deviceInfo
     *
     * @return string 
     */
    public function getDeviceInfo()
    {
        return $this->deviceInfo;
    }

    /**
     * Set errCode
     *
     * @param string $errCode
     * @return BasicOrderWxpayInfo
     */
    public function setErrCode($errCode)
    {
        $this->errCode = $errCode;
    
        return $this;
    }

    /**
     * Get errCode
     *
     * @return string 
     */
    public function getErrCode()
    {
        return $this->errCode;
    }

    /**
     * Set errCodeDes
     *
     * @param string $errCodeDes
     * @return BasicOrderWxpayInfo
     */
    public function setErrCodeDes($errCodeDes)
    {
        $this->errCodeDes = $errCodeDes;
    
        return $this;
    }

    /**
     * Get errCodeDes
     *
     * @return string 
     */
    public function getErrCodeDes()
    {
        return $this->errCodeDes;
    }

    /**
     * Set startTime
     *
     * @param string $startTime
     * @return BasicOrderWxpayInfo
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
    
        return $this;
    }

    /**
     * Get startTime
     *
     * @return string 
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set transactionId
     *
     * @param string $transactionId
     * @return BasicOrderWxpayInfo
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;
    
        return $this;
    }

    /**
     * Get transactionId
     *
     * @return string 
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * Set notifyRetcode
     *
     * @param string $notifyRetcode
     * @return BasicOrderWxpayInfo
     */
    public function setNotifyRetcode($notifyRetcode)
    {
        $this->notifyRetcode = $notifyRetcode;
    
        return $this;
    }

    /**
     * Get notifyRetcode
     *
     * @return string 
     */
    public function getNotifyRetcode()
    {
        return $this->notifyRetcode;
    }

    /**
     * Set notifyRetmsg
     *
     * @param string $notifyRetmsg
     * @return BasicOrderWxpayInfo
     */
    public function setNotifyRetmsg($notifyRetmsg)
    {
        $this->notifyRetmsg = $notifyRetmsg;
    
        return $this;
    }

    /**
     * Get notifyRetmsg
     *
     * @return string 
     */
    public function getNotifyRetmsg()
    {
        return $this->notifyRetmsg;
    }

    /**
     * Set notifyResult
     *
     * @param string $notifyResult
     * @return BasicOrderWxpayInfo
     */
    public function setNotifyResult($notifyResult)
    {
        $this->notifyResult = $notifyResult;
    
        return $this;
    }

    /**
     * Get notifyResult
     *
     * @return string 
     */
    public function getNotifyResult()
    {
        return $this->notifyResult;
    }

    /**
     * Set notifyErrcode
     *
     * @param string $notifyErrcode
     * @return BasicOrderWxpayInfo
     */
    public function setNotifyErrcode($notifyErrcode)
    {
        $this->notifyErrcode = $notifyErrcode;
    
        return $this;
    }

    /**
     * Get notifyErrcode
     *
     * @return string 
     */
    public function getNotifyErrcode()
    {
        return $this->notifyErrcode;
    }

    /**
     * Set notifyErrdes
     *
     * @param string $notifyErrdes
     * @return BasicOrderWxpayInfo
     */
    public function setNotifyErrdes($notifyErrdes)
    {
        $this->notifyErrdes = $notifyErrdes;
    
        return $this;
    }

    /**
     * Get notifyErrdes
     *
     * @return string 
     */
    public function getNotifyErrdes()
    {
        return $this->notifyErrdes;
    }

    /**
     * Set tradeState
     *
     * @param string $tradeState
     * @return BasicOrderWxpayInfo
     */
    public function setTradeState($tradeState)
    {
        $this->tradeState = $tradeState;
    
        return $this;
    }

    /**
     * Get tradeState
     *
     * @return string 
     */
    public function getTradeState()
    {
        return $this->tradeState;
    }

    /**
     * Set queryReturnCode
     *
     * @param string $queryReturnCode
     * @return BasicOrderWxpayInfo
     */
    public function setQueryReturnCode($queryReturnCode)
    {
        $this->queryReturnCode = $queryReturnCode;
    
        return $this;
    }

    /**
     * Get queryReturnCode
     *
     * @return string 
     */
    public function getQueryReturnCode()
    {
        return $this->queryReturnCode;
    }

    /**
     * Set queryReturnMsg
     *
     * @param string $queryReturnMsg
     * @return BasicOrderWxpayInfo
     */
    public function setQueryReturnMsg($queryReturnMsg)
    {
        $this->queryReturnMsg = $queryReturnMsg;
    
        return $this;
    }

    /**
     * Get queryReturnMsg
     *
     * @return string 
     */
    public function getQueryReturnMsg()
    {
        return $this->queryReturnMsg;
    }

    /**
     * Set queryResultCode
     *
     * @param string $queryResultCode
     * @return BasicOrderWxpayInfo
     */
    public function setQueryResultCode($queryResultCode)
    {
        $this->queryResultCode = $queryResultCode;
    
        return $this;
    }

    /**
     * Get queryResultCode
     *
     * @return string 
     */
    public function getQueryResultCode()
    {
        return $this->queryResultCode;
    }

    /**
     * Set queryErrCode
     *
     * @param string $queryErrCode
     * @return BasicOrderWxpayInfo
     */
    public function setQueryErrCode($queryErrCode)
    {
        $this->queryErrCode = $queryErrCode;
    
        return $this;
    }

    /**
     * Get queryErrCode
     *
     * @return string 
     */
    public function getQueryErrCode()
    {
        return $this->queryErrCode;
    }

    /**
     * Set queryErrCodeDes
     *
     * @param string $queryErrCodeDes
     * @return BasicOrderWxpayInfo
     */
    public function setQueryErrCodeDes($queryErrCodeDes)
    {
        $this->queryErrCodeDes = $queryErrCodeDes;
    
        return $this;
    }

    /**
     * Get queryErrCodeDes
     *
     * @return string 
     */
    public function getQueryErrCodeDes()
    {
        return $this->queryErrCodeDes;
    }

    /**
     * Set timeEnd
     *
     * @param string $timeEnd
     * @return BasicOrderWxpayInfo
     */
    public function setTimeEnd($timeEnd)
    {
        $this->timeEnd = $timeEnd;
    
        return $this;
    }

    /**
     * Get timeEnd
     *
     * @return string 
     */
    public function getTimeEnd()
    {
        return $this->timeEnd;
    }

    /**
     * Set tradeStateDesc
     *
     * @param string $tradeStateDesc
     * @return BasicOrderWxpayInfo
     */
    public function setTradeStateDesc($tradeStateDesc)
    {
        $this->tradeStateDesc = $tradeStateDesc;
    
        return $this;
    }

    /**
     * Get tradeStateDesc
     *
     * @return string 
     */
    public function getTradeStateDesc()
    {
        return $this->tradeStateDesc;
    }

    /**
     * Set orderRefundId
     *
     * @param string $orderRefundId
     * @return BasicOrderWxpayInfo
     */
    public function setOrderRefundId($orderRefundId)
    {
        $this->orderRefundId = $orderRefundId;
    
        return $this;
    }

    /**
     * Get orderRefundId
     *
     * @return string 
     */
    public function getOrderRefundId()
    {
        return $this->orderRefundId;
    }

    /**
     * Set isRefund
     *
     * @param integer $isRefund
     * @return BasicOrderWxpayInfo
     */
    public function setIsRefund($isRefund)
    {
        $this->isRefund = $isRefund;
    
        return $this;
    }

    /**
     * Get isRefund
     *
     * @return integer 
     */
    public function getIsRefund()
    {
        return $this->isRefund;
    }

    /**
     * Set refundId
     *
     * @param string $refundId
     * @return BasicOrderWxpayInfo
     */
    public function setRefundId($refundId)
    {
        $this->refundId = $refundId;
    
        return $this;
    }

    /**
     * Get refundId
     *
     * @return string 
     */
    public function getRefundId()
    {
        return $this->refundId;
    }

    /**
     * Set refundStatus
     *
     * @param string $refundStatus
     * @return BasicOrderWxpayInfo
     */
    public function setRefundStatus($refundStatus)
    {
        $this->refundStatus = $refundStatus;
    
        return $this;
    }

    /**
     * Get refundStatus
     *
     * @return string 
     */
    public function getRefundStatus()
    {
        return $this->refundStatus;
    }

    /**
     * Set refundChannel
     *
     * @param string $refundChannel
     * @return BasicOrderWxpayInfo
     */
    public function setRefundChannel($refundChannel)
    {
        $this->refundChannel = $refundChannel;
    
        return $this;
    }

    /**
     * Get refundChannel
     *
     * @return string 
     */
    public function getRefundChannel()
    {
        return $this->refundChannel;
    }

    /**
     * Set refundFee
     *
     * @param integer $refundFee
     * @return BasicOrderWxpayInfo
     */
    public function setRefundFee($refundFee)
    {
        $this->refundFee = $refundFee;
    
        return $this;
    }

    /**
     * Get refundFee
     *
     * @return integer 
     */
    public function getRefundFee()
    {
        return $this->refundFee;
    }

    /**
     * Set settlementRefundFee
     *
     * @param integer $settlementRefundFee
     * @return BasicOrderWxpayInfo
     */
    public function setSettlementRefundFee($settlementRefundFee)
    {
        $this->settlementRefundFee = $settlementRefundFee;
    
        return $this;
    }

    /**
     * Get settlementRefundFee
     *
     * @return integer 
     */
    public function getSettlementRefundFee()
    {
        return $this->settlementRefundFee;
    }

    /**
     * Set refundRecvAccount
     *
     * @param string $refundRecvAccount
     * @return BasicOrderWxpayInfo
     */
    public function setRefundRecvAccount($refundRecvAccount)
    {
        $this->refundRecvAccount = $refundRecvAccount;
    
        return $this;
    }

    /**
     * Get refundRecvAccount
     *
     * @return string 
     */
    public function getRefundRecvAccount()
    {
        return $this->refundRecvAccount;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
