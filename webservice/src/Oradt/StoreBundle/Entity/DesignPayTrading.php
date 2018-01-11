<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DesignPayTrading
 */
class DesignPayTrading
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $orderNo;

    /**
     * @var string
     */
    private $tradingNumber;

    /**
     * @var string
     */
    private $price;

    /**
     * @var boolean
     */
    private $unitId;
    /**
     * @var string
     */
    private $payAccount;
    /**
     * @var boolean
     */
    private $paymethod;

    /**
     * @var string
     */
    private $paytype;

    /**
     * @var integer
     */
    private $createTime;

    /**
     * @var integer
     */
    private $updateTime;


    /**
     * @var string
     */
    private $memberId;

    /**
     * @var boolean
     */
    private $status;

     /**
     * @var \integer
     */
    private $endTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return DesignPayTrading
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    
        return $this;
    }

    /**
     * Get userId
     *
     * @return string 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set orderNo
     *
     * @param string $orderNo
     * @return DesignPayTrading
     */
    public function setOrderNo($orderNo)
    {
        $this->orderNo = $orderNo;
    
        return $this;
    }

    /**
     * Get orderNo
     *
     * @return string 
     */
    public function getOrderNo()
    {
        return $this->orderNo;
    }

    /**
     * Set tradingNumber
     *
     * @param string $tradingNumber
     * @return DesignPayTrading
     */
    public function setTradingNumber($tradingNumber)
    {
        $this->tradingNumber = $tradingNumber;
    
        return $this;
    }

    /**
     * Get tradingNumber
     *
     * @return string 
     */
    public function getTradingNumber()
    {
        return $this->tradingNumber;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return DesignPayTrading
     */
    public function setPrice($price)
    {
        $this->price = $price;
    
        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set unitId
     *
     * @param boolean $unitId
     * @return DesignPayTrading
     */
    public function setUnitId($unitId)
    {
        $this->unitId = $unitId;
    
        return $this;
    }

    /**
     * Get unitId
     *
     * @return boolean 
     */
    public function getUnitId()
    {
        return $this->unitId;
    }

	/**
     * Set payAccount account
     *
     * @param string $payAccount
     * @return DesignPayTrading
     */
    public function setPayAccount($payAccount)
    {
        $this->payAccount = $payAccount;
    
        return $this;
    }

    /**
     * Get payAccount
     *
     * @return boolean 
     */
    public function getPayAccount()
    {
        return $this->payAccount;
    }
    /**
     * Set paymethod
     *
     * @param boolean $paymethod
     * @return DesignPayTrading
     */
    public function setPaymethod($paymethod)
    {
        $this->paymethod = $paymethod;
    
        return $this;
    }

    /**
     * Get paymethod
     *
     * @return boolean 
     */
    public function getPaymethod()
    {
        return $this->paymethod;
    }

    /**
     * Set paytype
     *
     * @param string $paytype
     * @return DesignPayTrading
     */
    public function setPaytype($paytype)
    {
        $this->paytype = $paytype;
    
        return $this;
    }

    /**
     * Get paytype
     *
     * @return string 
     */
    public function getPaytype()
    {
        return $this->paytype;
    }

    /**
     * Set createTime
     *
     * @param integer $createTime
     * @return DesignPayTrading
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
     * Set updateTime
     *
     * @param integer $updateTime
     * @return DesignPayTrading
     */
    public function setUpdateTime($updateTime)
    {
        $this->updateTime = $updateTime;
    
        return $this;
    }

    /**
     * Get updateTime
     *
     * @return integer 
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }


    /**
     * Set memberId
     *
     * @param string $memberId
     * @return DesignPayTrading
     */
    public function setMemberId($memberId)
    {
        $this->memberId = $memberId;
    
        return $this;
    }

    /**
     * Get memberId
     *
     * @return string 
     */
    public function getMemberId()
    {
        return $this->memberId;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return DesignPayTrading
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return boolean 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set endTime
     *
     * @param integer $endTime
     * @return DesignPayTrading
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
    
        return $this;
    }

    /**
     * Get endTime
     *
     * @return integer 
     */
    public function getEndTime()
    {
        return $this->endTime;
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
