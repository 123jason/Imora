<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DesignCash
 */
class DesignCash
{
    /**
     * @var string
     */
    private $cashId;

    /**
     * @var string
     */
    private $tradeNo;

    /**
     * @var string
     */
    private $payMethod;

    /**
     * @var string
     */
    private $payId;

    /**
     * @var string
     */
    private $batchId;

    /**
     * @var string
     */
    private $money;

    /**
     * @var string
     */
    private $unitId;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $payAccount;

    /**
     * @var string
     */
    private $recvAccount;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $errCode;

    /**
     * @var string
     */
    private $errInfo;

    /**
     * @var integer
     */
    private $createTime;

    /**
     * @var string
     */
    private $payTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set cashId
     *
     * @param string $cashId
     * @return DesignCash
     */
    public function setCashId($cashId)
    {
        $this->cashId = $cashId;
    
        return $this;
    }

    /**
     * Get cashId
     *
     * @return string 
     */
    public function getCashId()
    {
        return $this->cashId;
    }

    /**
     * Set tradeNo
     *
     * @param string $tradeNo
     * @return DesignCash
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
     * Set payMethod
     *
     * @param string $payMethod
     * @return DesignCash
     */
    public function setPayMethod($payMethod)
    {
        $this->payMethod = $payMethod;
    
        return $this;
    }

    /**
     * Get payMethod
     *
     * @return string 
     */
    public function getPayMethod()
    {
        return $this->payMethod;
    }

    /**
     * Set payId
     *
     * @param string $payId
     * @return DesignCash
     */
    public function setPayId($payId)
    {
        $this->payId = $payId;
    
        return $this;
    }

    /**
     * Get payId
     *
     * @return string 
     */
    public function getPayId()
    {
        return $this->payId;
    }

    /**
     * Set batchId
     *
     * @param string $batchId
     * @return DesignCash
     */
    public function setBatchId($batchId)
    {
        $this->batchId = $batchId;
    
        return $this;
    }

    /**
     * Get batchId
     *
     * @return string 
     */
    public function getBatchId()
    {
        return $this->batchId;
    }

    /**
     * Set money
     *
     * @param string $money
     * @return DesignCash
     */
    public function setMoney($money)
    {
        $this->money = $money;
    
        return $this;
    }

    /**
     * Get money
     *
     * @return string 
     */
    public function getMoney()
    {
        return $this->money;
    }

    /**
     * Set unitId
     *
     * @param string $unitId
     * @return DesignCash
     */
    public function setUnitId($unitId)
    {
        $this->unitId = $unitId;
    
        return $this;
    }

    /**
     * Get unitId
     *
     * @return string 
     */
    public function getUnitId()
    {
        return $this->unitId;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return DesignCash
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set payAccount
     *
     * @param string $payAccount
     * @return DesignCash
     */
    public function setPayAccount($payAccount)
    {
        $this->payAccount = $payAccount;
    
        return $this;
    }

    /**
     * Get payAccount
     *
     * @return string 
     */
    public function getPayAccount()
    {
        return $this->payAccount;
    }

    /**
     * Set recvAccount
     *
     * @param string $recvAccount
     * @return DesignCash
     */
    public function setRecvAccount($recvAccount)
    {
        $this->recvAccount = $recvAccount;
    
        return $this;
    }

    /**
     * Get recvAccount
     *
     * @return string 
     */
    public function getRecvAccount()
    {
        return $this->recvAccount;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return DesignCash
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set errCode
     *
     * @param string $errCode
     * @return DesignCash
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
     * Set errInfo
     *
     * @param string $errInfo
     * @return DesignCash
     */
    public function setErrInfo($errInfo)
    {
        $this->errInfo = $errInfo;
    
        return $this;
    }

    /**
     * Get errInfo
     *
     * @return string 
     */
    public function getErrInfo()
    {
        return $this->errInfo;
    }

    /**
     * Set createTime
     *
     * @param integer $createTime
     * @return DesignCash
     */
    public function setCreateTime($createTime)
    {
        $this->createTime = $createTime;
    
        return $this;
    }

    /**
     * Get createTime
     *
     * @return integer 
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * Set payTime
     *
     * @param string $payTime
     * @return DesignCash
     */
    public function setPayTime($payTime)
    {
        $this->payTime = $payTime;
    
        return $this;
    }

    /**
     * Get payTime
     *
     * @return string 
     */
    public function getPayTime()
    {
        return $this->payTime;
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
    private $fees;


    /**
     * Set fees
     *
     * @param string $fees
     * @return DesignCash
     */
    public function setFees($fees)
    {
        $this->fees = $fees;
    
        return $this;
    }

    /**
     * Get fees
     *
     * @return string 
     */
    public function getFees()
    {
        return $this->fees;
    }
    /**
     * @var string
     */
    private $payStatus;


    /**
     * Set payStatus
     *
     * @param string $payStatus
     * @return DesignCash
     */
    public function setPayStatus($payStatus)
    {
        $this->payStatus = $payStatus;
    
        return $this;
    }

    /**
     * Get payStatus
     *
     * @return string 
     */
    public function getPayStatus()
    {
        return $this->payStatus;
    }
}
