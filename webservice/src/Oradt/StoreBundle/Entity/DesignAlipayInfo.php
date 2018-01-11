<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DesignAlipayInfo
 */
class DesignAlipayInfo
{
    /**
     * @var string
     */
    private $alipayId;

    /**
     * @var string
     */
    private $tradeId;

    /**
     * @var string
     */
    private $totalFee;

    /**
     * @var string
     */
    private $feeType;

    /**
     * @var \DateTime
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
     * @var \DateTime
     */
    private $gmtCreate;

    /**
     * @var \DateTime
     */
    private $gmtPayment;

    /**
     * @var \DateTime
     */
    private $gmtClose;

    /**
     * @var string
     */
    private $refundStatus;

    /**
     * @var \DateTime
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
     * @var integer
     */
    private $id;


    /**
     * Set alipayId
     *
     * @param string $alipayId
     * @return DesignAlipayInfo
     */
    public function setAlipayId($alipayId)
    {
        $this->alipayId = $alipayId;
    
        return $this;
    }

    /**
     * Get alipayId
     *
     * @return string 
     */
    public function getAlipayId()
    {
        return $this->alipayId;
    }

    /**
     * Set tradeId
     *
     * @param string $tradeId
     * @return DesignAlipayInfo
     */
    public function setTradeId($tradeId)
    {
        $this->tradeId = $tradeId;
    
        return $this;
    }

    /**
     * Get tradeId
     *
     * @return string 
     */
    public function getTradeId()
    {
        return $this->tradeId;
    }

    /**
     * Set totalFee
     *
     * @param string $totalFee
     * @return DesignAlipayInfo
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
     * @return DesignAlipayInfo
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
     * @param \DateTime $notifyTime
     * @return DesignAlipayInfo
     */
    public function setNotifyTime($notifyTime)
    {
        $this->notifyTime = $notifyTime;
    
        return $this;
    }

    /**
     * Get notifyTime
     *
     * @return \DateTime 
     */
    public function getNotifyTime()
    {
        return $this->notifyTime;
    }

    /**
     * Set notifyType
     *
     * @param string $notifyType
     * @return DesignAlipayInfo
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
     * @return DesignAlipayInfo
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
     * @return DesignAlipayInfo
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
     * @return DesignAlipayInfo
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
     * @return DesignAlipayInfo
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
     * @param \DateTime $gmtCreate
     * @return DesignAlipayInfo
     */
    public function setGmtCreate($gmtCreate)
    {
        $this->gmtCreate = $gmtCreate;
    
        return $this;
    }

    /**
     * Get gmtCreate
     *
     * @return \DateTime 
     */
    public function getGmtCreate()
    {
        return $this->gmtCreate;
    }

    /**
     * Set gmtPayment
     *
     * @param \DateTime $gmtPayment
     * @return DesignAlipayInfo
     */
    public function setGmtPayment($gmtPayment)
    {
        $this->gmtPayment = $gmtPayment;
    
        return $this;
    }

    /**
     * Get gmtPayment
     *
     * @return \DateTime 
     */
    public function getGmtPayment()
    {
        return $this->gmtPayment;
    }

    /**
     * Set gmtClose
     *
     * @param \DateTime $gmtClose
     * @return DesignAlipayInfo
     */
    public function setGmtClose($gmtClose)
    {
        $this->gmtClose = $gmtClose;
    
        return $this;
    }

    /**
     * Get gmtClose
     *
     * @return \DateTime 
     */
    public function getGmtClose()
    {
        return $this->gmtClose;
    }

    /**
     * Set refundStatus
     *
     * @param string $refundStatus
     * @return DesignAlipayInfo
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
     * Set gmtRefund
     *
     * @param \DateTime $gmtRefund
     * @return DesignAlipayInfo
     */
    public function setGmtRefund($gmtRefund)
    {
        $this->gmtRefund = $gmtRefund;
    
        return $this;
    }

    /**
     * Get gmtRefund
     *
     * @return \DateTime 
     */
    public function getGmtRefund()
    {
        return $this->gmtRefund;
    }

    /**
     * Set sellerEmail
     *
     * @param string $sellerEmail
     * @return DesignAlipayInfo
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
     * @return DesignAlipayInfo
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
     * @return DesignAlipayInfo
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
     * @return DesignAlipayInfo
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @var string
     */
    private $designFailReason;


    /**
     * Set designFailReason
     *
     * @param string $designFailReason
     * @return DesignAlipayInfo
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
}
