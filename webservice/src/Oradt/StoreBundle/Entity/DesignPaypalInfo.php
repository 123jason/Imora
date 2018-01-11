<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DesignPaypalInfo
 */
class DesignPaypalInfo
{
    /**
     * @var string
     */
    private $paypalId;

    /**
     * @var string
     */
    private $tradeNo;

    /**
     * @var string
     */
    private $payerId;

    /**
     * @var string
     */
    private $payerEmail;

    /**
     * @var string
     */
    private $receiverId;

    /**
     * @var string
     */
    private $receiverEmail;

    /**
     * @var string
     */
    private $mcGross;

    /**
     * @var string
     */
    private $mcFee;

    /**
     * @var string
     */
    private $exchangeRate;

    /**
     * @var string
     */
    private $mcCurrency;

    /**
     * @var string
     */
    private $mcHanding;

    /**
     * @var string
     */
    private $settleAmount;

    /**
     * @var string
     */
    private $settleCurrency;

    /**
     * @var string
     */
    private $txnId;

    /**
     * @var string
     */
    private $txnType;

    /**
     * @var string
     */
    private $parentTxnId;

    /**
     * @var string
     */
    private $paymentDate;

    /**
     * @var string
     */
    private $paymentStatus;

    /**
     * @var string
     */
    private $paymentType;

    /**
     * @var string
     */
    private $pendingReason;

    /**
     * @var string
     */
    private $reasonCode;

    /**
     * @var string
     */
    private $designFailReason;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set paypalId
     *
     * @param string $paypalId
     * @return DesignPaypalInfo
     */
    public function setPaypalId($paypalId)
    {
        $this->paypalId = $paypalId;
    
        return $this;
    }

    /**
     * Get paypalId
     *
     * @return string 
     */
    public function getPaypalId()
    {
        return $this->paypalId;
    }

    /**
     * Set tradeNo
     *
     * @param string $tradeNo
     * @return DesignPaypalInfo
     */
    public function setTradeNo($tradeNo)
    {
        $this->tradeNo = $tradeNo;
    
        return $this;
    }

    /**
     * Get tradeNo
     *
     * @return string 
     */
    public function getTradeNo()
    {
        return $this->tradeNo;
    }

    /**
     * Set payerId
     *
     * @param string $payerId
     * @return DesignPaypalInfo
     */
    public function setPayerId($payerId)
    {
        $this->payerId = $payerId;
    
        return $this;
    }

    /**
     * Get payerId
     *
     * @return string 
     */
    public function getPayerId()
    {
        return $this->payerId;
    }

    /**
     * Set payerEmail
     *
     * @param string $payerEmail
     * @return DesignPaypalInfo
     */
    public function setPayerEmail($payerEmail)
    {
        $this->payerEmail = $payerEmail;
    
        return $this;
    }

    /**
     * Get payerEmail
     *
     * @return string 
     */
    public function getPayerEmail()
    {
        return $this->payerEmail;
    }

    /**
     * Set receiverId
     *
     * @param string $receiverId
     * @return DesignPaypalInfo
     */
    public function setReceiverId($receiverId)
    {
        $this->receiverId = $receiverId;
    
        return $this;
    }

    /**
     * Get receiverId
     *
     * @return string 
     */
    public function getReceiverId()
    {
        return $this->receiverId;
    }

    /**
     * Set receiverEmail
     *
     * @param string $receiverEmail
     * @return DesignPaypalInfo
     */
    public function setReceiverEmail($receiverEmail)
    {
        $this->receiverEmail = $receiverEmail;
    
        return $this;
    }

    /**
     * Get receiverEmail
     *
     * @return string 
     */
    public function getReceiverEmail()
    {
        return $this->receiverEmail;
    }

    /**
     * Set mcGross
     *
     * @param string $mcGross
     * @return DesignPaypalInfo
     */
    public function setMcGross($mcGross)
    {
        $this->mcGross = $mcGross;
    
        return $this;
    }

    /**
     * Get mcGross
     *
     * @return string 
     */
    public function getMcGross()
    {
        return $this->mcGross;
    }

    /**
     * Set mcFee
     *
     * @param string $mcFee
     * @return DesignPaypalInfo
     */
    public function setMcFee($mcFee)
    {
        $this->mcFee = $mcFee;
    
        return $this;
    }

    /**
     * Get mcFee
     *
     * @return string 
     */
    public function getMcFee()
    {
        return $this->mcFee;
    }

    /**
     * Set exchangeRate
     *
     * @param string $exchangeRate
     * @return DesignPaypalInfo
     */
    public function setExchangeRate($exchangeRate)
    {
        $this->exchangeRate = $exchangeRate;
    
        return $this;
    }

    /**
     * Get exchangeRate
     *
     * @return string 
     */
    public function getExchangeRate()
    {
        return $this->exchangeRate;
    }

    /**
     * Set mcCurrency
     *
     * @param string $mcCurrency
     * @return DesignPaypalInfo
     */
    public function setMcCurrency($mcCurrency)
    {
        $this->mcCurrency = $mcCurrency;
    
        return $this;
    }

    /**
     * Get mcCurrency
     *
     * @return string 
     */
    public function getMcCurrency()
    {
        return $this->mcCurrency;
    }

    /**
     * Set mcHanding
     *
     * @param string $mcHanding
     * @return DesignPaypalInfo
     */
    public function setMcHanding($mcHanding)
    {
        $this->mcHanding = $mcHanding;
    
        return $this;
    }

    /**
     * Get mcHanding
     *
     * @return string 
     */
    public function getMcHanding()
    {
        return $this->mcHanding;
    }

    /**
     * Set settleAmount
     *
     * @param string $settleAmount
     * @return DesignPaypalInfo
     */
    public function setSettleAmount($settleAmount)
    {
        $this->settleAmount = $settleAmount;
    
        return $this;
    }

    /**
     * Get settleAmount
     *
     * @return string 
     */
    public function getSettleAmount()
    {
        return $this->settleAmount;
    }

    /**
     * Set settleCurrency
     *
     * @param string $settleCurrency
     * @return DesignPaypalInfo
     */
    public function setSettleCurrency($settleCurrency)
    {
        $this->settleCurrency = $settleCurrency;
    
        return $this;
    }

    /**
     * Get settleCurrency
     *
     * @return string 
     */
    public function getSettleCurrency()
    {
        return $this->settleCurrency;
    }

    /**
     * Set txnId
     *
     * @param string $txnId
     * @return DesignPaypalInfo
     */
    public function setTxnId($txnId)
    {
        $this->txnId = $txnId;
    
        return $this;
    }

    /**
     * Get txnId
     *
     * @return string 
     */
    public function getTxnId()
    {
        return $this->txnId;
    }

    /**
     * Set txnType
     *
     * @param string $txnType
     * @return DesignPaypalInfo
     */
    public function setTxnType($txnType)
    {
        $this->txnType = $txnType;
    
        return $this;
    }

    /**
     * Get txnType
     *
     * @return string 
     */
    public function getTxnType()
    {
        return $this->txnType;
    }

    /**
     * Set parentTxnId
     *
     * @param string $parentTxnId
     * @return DesignPaypalInfo
     */
    public function setParentTxnId($parentTxnId)
    {
        $this->parentTxnId = $parentTxnId;
    
        return $this;
    }

    /**
     * Get parentTxnId
     *
     * @return string 
     */
    public function getParentTxnId()
    {
        return $this->parentTxnId;
    }

    /**
     * Set paymentDate
     *
     * @param string $paymentDate
     * @return DesignPaypalInfo
     */
    public function setPaymentDate($paymentDate)
    {
        $this->paymentDate = $paymentDate;
    
        return $this;
    }

    /**
     * Get paymentDate
     *
     * @return string 
     */
    public function getPaymentDate()
    {
        return $this->paymentDate;
    }

    /**
     * Set paymentStatus
     *
     * @param string $paymentStatus
     * @return DesignPaypalInfo
     */
    public function setPaymentStatus($paymentStatus)
    {
        $this->paymentStatus = $paymentStatus;
    
        return $this;
    }

    /**
     * Get paymentStatus
     *
     * @return string 
     */
    public function getPaymentStatus()
    {
        return $this->paymentStatus;
    }

    /**
     * Set paymentType
     *
     * @param string $paymentType
     * @return DesignPaypalInfo
     */
    public function setPaymentType($paymentType)
    {
        $this->paymentType = $paymentType;
    
        return $this;
    }

    /**
     * Get paymentType
     *
     * @return string 
     */
    public function getPaymentType()
    {
        return $this->paymentType;
    }

    /**
     * Set pendingReason
     *
     * @param string $pendingReason
     * @return DesignPaypalInfo
     */
    public function setPendingReason($pendingReason)
    {
        $this->pendingReason = $pendingReason;
    
        return $this;
    }

    /**
     * Get pendingReason
     *
     * @return string 
     */
    public function getPendingReason()
    {
        return $this->pendingReason;
    }

    /**
     * Set reasonCode
     *
     * @param string $reasonCode
     * @return DesignPaypalInfo
     */
    public function setReasonCode($reasonCode)
    {
        $this->reasonCode = $reasonCode;
    
        return $this;
    }

    /**
     * Get reasonCode
     *
     * @return string 
     */
    public function getReasonCode()
    {
        return $this->reasonCode;
    }

    /**
     * Set designFailReason
     *
     * @param string $designFailReason
     * @return DesignPaypalInfo
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
