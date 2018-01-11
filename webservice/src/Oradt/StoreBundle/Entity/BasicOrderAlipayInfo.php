<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BasicOrderAlipayInfo
 */
class BasicOrderAlipayInfo
{
    /**
     * @var string
     */
    private $orderId;

    /**
     * @var string
     */
    private $totalFee;

    /**
     * @var string
     */
    private $feeType;

    /**
     * @var integer
     */
    private $notifyTime;

    /**
     * @var string
     */
    private $notifyType;

    /**
     * @var string
     */
    private $notifyId;

    /**
     * @var string
     */
    private $signType;

    /**
     * @var string
     */
    private $aliTradeNo;

    /**
     * @var string
     */
    private $tradeStatus;

    /**
     * @var integer
     */
    private $gmtCreate;

    /**
     * @var integer
     */
    private $gmtPayment;

    /**
     * @var integer
     */
    private $gmtClose;

    /**
     * @var integer
     */
    private $isRefund;

    /**
     * @var float
     */
    private $refundAmount;

    /**
     * @var integer
     */
    private $refundStatus;

    /**
     * @var integer
     */
    private $gmtRefund;

    /**
     * @var string
     */
    private $sellerEmail;

    /**
     * @var string
     */
    private $buyerEmail;

    /**
     * @var string
     */
    private $sellerId;

    /**
     * @var string
     */
    private $buyerId;

    /**
     * @var string
     */
    private $designFailReason;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set orderId
     *
     * @param string $orderId
     * @return BasicOrderAlipayInfo
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
     * @param string $totalFee
     * @return BasicOrderAlipayInfo
     */
    public function setTotalFee($totalFee)
    {
        $this->totalFee = $totalFee;
    
        return $this;
    }

    /**
     * Get totalFee
     *
     * @return string 
     */
    public function getTotalFee()
    {
        return $this->totalFee;
    }

    /**
     * Set feeType
     *
     * @param string $feeType
     * @return BasicOrderAlipayInfo
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
     * Set notifyTime
     *
     * @param integer $notifyTime
     * @return BasicOrderAlipayInfo
     */
    public function setNotifyTime($notifyTime)
    {
        $this->notifyTime = $notifyTime;
    
        return $this;
    }

    /**
     * Get notifyTime
     *
     * @return integer 
     */
    public function getNotifyTime()
    {
        return $this->notifyTime;
    }

    /**
     * Set notifyType
     *
     * @param string $notifyType
     * @return BasicOrderAlipayInfo
     */
    public function setNotifyType($notifyType)
    {
        $this->notifyType = $notifyType;
    
        return $this;
    }

    /**
     * Get notifyType
     *
     * @return string 
     */
    public function getNotifyType()
    {
        return $this->notifyType;
    }

    /**
     * Set notifyId
     *
     * @param string $notifyId
     * @return BasicOrderAlipayInfo
     */
    public function setNotifyId($notifyId)
    {
        $this->notifyId = $notifyId;
    
        return $this;
    }

    /**
     * Get notifyId
     *
     * @return string 
     */
    public function getNotifyId()
    {
        return $this->notifyId;
    }

    /**
     * Set signType
     *
     * @param string $signType
     * @return BasicOrderAlipayInfo
     */
    public function setSignType($signType)
    {
        $this->signType = $signType;
    
        return $this;
    }

    /**
     * Get signType
     *
     * @return string 
     */
    public function getSignType()
    {
        return $this->signType;
    }

    /**
     * Set aliTradeNo
     *
     * @param string $aliTradeNo
     * @return BasicOrderAlipayInfo
     */
    public function setAliTradeNo($aliTradeNo)
    {
        $this->aliTradeNo = $aliTradeNo;
    
        return $this;
    }

    /**
     * Get aliTradeNo
     *
     * @return string 
     */
    public function getAliTradeNo()
    {
        return $this->aliTradeNo;
    }

    /**
     * Set tradeStatus
     *
     * @param string $tradeStatus
     * @return BasicOrderAlipayInfo
     */
    public function setTradeStatus($tradeStatus)
    {
        $this->tradeStatus = $tradeStatus;
    
        return $this;
    }

    /**
     * Get tradeStatus
     *
     * @return string 
     */
    public function getTradeStatus()
    {
        return $this->tradeStatus;
    }

    /**
     * Set gmtCreate
     *
     * @param integer $gmtCreate
     * @return BasicOrderAlipayInfo
     */
    public function setGmtCreate($gmtCreate)
    {
        $this->gmtCreate = $gmtCreate;
    
        return $this;
    }

    /**
     * Get gmtCreate
     *
     * @return integer 
     */
    public function getGmtCreate()
    {
        return $this->gmtCreate;
    }

    /**
     * Set gmtPayment
     *
     * @param integer $gmtPayment
     * @return BasicOrderAlipayInfo
     */
    public function setGmtPayment($gmtPayment)
    {
        $this->gmtPayment = $gmtPayment;
    
        return $this;
    }

    /**
     * Get gmtPayment
     *
     * @return integer 
     */
    public function getGmtPayment()
    {
        return $this->gmtPayment;
    }

    /**
     * Set gmtClose
     *
     * @param integer $gmtClose
     * @return BasicOrderAlipayInfo
     */
    public function setGmtClose($gmtClose)
    {
        $this->gmtClose = $gmtClose;
    
        return $this;
    }

    /**
     * Get gmtClose
     *
     * @return integer 
     */
    public function getGmtClose()
    {
        return $this->gmtClose;
    }

    /**
     * Set isRefund
     *
     * @param integer $isRefund
     * @return BasicOrderAlipayInfo
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
     * Set refundAmount
     *
     * @param float $refundAmount
     * @return BasicOrderAlipayInfo
     */
    public function setRefundAmount($refundAmount)
    {
        $this->refundAmount = $refundAmount;
    
        return $this;
    }

    /**
     * Get refundAmount
     *
     * @return float 
     */
    public function getRefundAmount()
    {
        return $this->refundAmount;
    }

    /**
     * Set refundStatus
     *
     * @param integer $refundStatus
     * @return BasicOrderAlipayInfo
     */
    public function setRefundStatus($refundStatus)
    {
        $this->refundStatus = $refundStatus;
    
        return $this;
    }

    /**
     * Get refundStatus
     *
     * @return integer 
     */
    public function getRefundStatus()
    {
        return $this->refundStatus;
    }

    /**
     * Set gmtRefund
     *
     * @param integer $gmtRefund
     * @return BasicOrderAlipayInfo
     */
    public function setGmtRefund($gmtRefund)
    {
        $this->gmtRefund = $gmtRefund;
    
        return $this;
    }

    /**
     * Get gmtRefund
     *
     * @return integer 
     */
    public function getGmtRefund()
    {
        return $this->gmtRefund;
    }

    /**
     * Set sellerEmail
     *
     * @param string $sellerEmail
     * @return BasicOrderAlipayInfo
     */
    public function setSellerEmail($sellerEmail)
    {
        $this->sellerEmail = $sellerEmail;
    
        return $this;
    }

    /**
     * Get sellerEmail
     *
     * @return string 
     */
    public function getSellerEmail()
    {
        return $this->sellerEmail;
    }

    /**
     * Set buyerEmail
     *
     * @param string $buyerEmail
     * @return BasicOrderAlipayInfo
     */
    public function setBuyerEmail($buyerEmail)
    {
        $this->buyerEmail = $buyerEmail;
    
        return $this;
    }

    /**
     * Get buyerEmail
     *
     * @return string 
     */
    public function getBuyerEmail()
    {
        return $this->buyerEmail;
    }

    /**
     * Set sellerId
     *
     * @param string $sellerId
     * @return BasicOrderAlipayInfo
     */
    public function setSellerId($sellerId)
    {
        $this->sellerId = $sellerId;
    
        return $this;
    }

    /**
     * Get sellerId
     *
     * @return string 
     */
    public function getSellerId()
    {
        return $this->sellerId;
    }

    /**
     * Set buyerId
     *
     * @param string $buyerId
     * @return BasicOrderAlipayInfo
     */
    public function setBuyerId($buyerId)
    {
        $this->buyerId = $buyerId;
    
        return $this;
    }

    /**
     * Get buyerId
     *
     * @return string 
     */
    public function getBuyerId()
    {
        return $this->buyerId;
    }

    /**
     * Set designFailReason
     *
     * @param string $designFailReason
     * @return BasicOrderAlipayInfo
     */
    public function setDesignFailReason($designFailReason)
    {
        $this->designFailReason = $designFailReason;
    
        return $this;
    }

    /**
     * Get designFailReason
     *
     * @return string 
     */
    public function getDesignFailReason()
    {
        return $this->designFailReason;
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
