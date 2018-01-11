<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OradtRedeemCodeGroup
 */
class OradtRedeemCodeGroup
{
    /**
     * @var string
     */
    private $adminId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $exchangeLength;

    /**
     * @var integer
     */
    private $exchangeStock;

    /**
     * @var integer
     */
    private $num;

    /**
     * @var integer
     */
    private $leaveNum;

    /**
     * @var integer
     */
    private $startTime;

    /**
     * @var integer
     */
    private $endTime;

    /**
     * @var integer
     */
    private $addNum;

    /**
     * @var integer
     */
    private $createNum;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set adminId
     *
     * @param string $adminId
     * @return OradtRedeemCodeGroup
     */
    public function setAdminId($adminId)
    {
        $this->adminId = $adminId;
    
        return $this;
    }

    /**
     * Get adminId
     *
     * @return string 
     */
    public function getAdminId()
    {
        return $this->adminId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return OradtRedeemCodeGroup
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set exchangeLength
     *
     * @param integer $exchangeLength
     * @return OradtRedeemCodeGroup
     */
    public function setExchangeLength($exchangeLength)
    {
        $this->exchangeLength = $exchangeLength;
    
        return $this;
    }

    /**
     * Get exchangeLength
     *
     * @return integer 
     */
    public function getExchangeLength()
    {
        return $this->exchangeLength;
    }

    /**
     * Set exchangeStock
     *
     * @param integer $exchangeStock
     * @return OradtRedeemCodeGroup
     */
    public function setExchangeStock($exchangeStock)
    {
        $this->exchangeStock = $exchangeStock;
    
        return $this;
    }

    /**
     * Get exchangeStock
     *
     * @return integer 
     */
    public function getExchangeStock()
    {
        return $this->exchangeStock;
    }

    /**
     * Set num
     *
     * @param integer $num
     * @return OradtRedeemCodeGroup
     */
    public function setNum($num)
    {
        $this->num = $num;
    
        return $this;
    }

    /**
     * Get num
     *
     * @return integer 
     */
    public function getNum()
    {
        return $this->num;
    }

    /**
     * Set leaveNum
     *
     * @param integer $leaveNum
     * @return OradtRedeemCodeGroup
     */
    public function setLeaveNum($leaveNum)
    {
        $this->leaveNum = $leaveNum;
    
        return $this;
    }

    /**
     * Get leaveNum
     *
     * @return integer 
     */
    public function getLeaveNum()
    {
        return $this->leaveNum;
    }

    /**
     * Set startTime
     *
     * @param integer $startTime
     * @return OradtRedeemCodeGroup
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
    
        return $this;
    }

    /**
     * Get startTime
     *
     * @return integer 
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set endTime
     *
     * @param integer $endTime
     * @return OradtRedeemCodeGroup
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
     * Set addNum
     *
     * @param integer $addNum
     * @return OradtRedeemCodeGroup
     */
    public function setAddNum($addNum)
    {
        $this->addNum = $addNum;
    
        return $this;
    }

    /**
     * Get addNum
     *
     * @return integer 
     */
    public function getAddNum()
    {
        return $this->addNum;
    }

    /**
     * Set createNum
     *
     * @param integer $createNum
     * @return OradtRedeemCodeGroup
     */
    public function setCreateNum($createNum)
    {
        $this->createNum = $createNum;
    
        return $this;
    }

    /**
     * Get createNum
     *
     * @return integer 
     */
    public function getCreateNum()
    {
        return $this->createNum;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return OradtRedeemCodeGroup
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return OradtRedeemCodeGroup
     */
    public function setCreatedTime($createdTime)
    {
        $this->createdTime = $createdTime;
    
        return $this;
    }

    /**
     * Get createdTime
     *
     * @return integer 
     */
    public function getCreatedTime()
    {
        return $this->createdTime;
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
