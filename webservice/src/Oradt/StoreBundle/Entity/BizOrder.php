<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BizOrder
 */
class BizOrder
{
    /**
     * @var integer
     */
    private $type;

    /**
     * @var string
     */
    private $bizId;

    /**
     * @var string
     */
    private $orderId;

    /**
     * @var string
     */
    private $empId;

    /**
     * @var integer
     */
    private $authorizeNum;

    /**
     * @var integer
     */
    private $storageNum;

    /**
     * @var integer
     */
    private $length;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var float
     */
    private $price;

    /**
     * @var string
     */
    private $bank;

    /**
     * @var string
     */
    private $unit;

    /**
     * @var integer
     */
    private $createTime;

    /**
     * @var integer
     */
    private $modifyTime;

    /**
     * @var integer
     */
    private $endTime;

    /**
     * @var string
     */
    private $tradeNo;

    /**
     * @var string
     */
    private $authorId;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set type
     *
     * @param integer $type
     * @return BizOrder
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set bizId
     *
     * @param string $bizId
     * @return BizOrder
     */
    public function setBizId($bizId)
    {
        $this->bizId = $bizId;
    
        return $this;
    }

    /**
     * Get bizId
     *
     * @return string 
     */
    public function getBizId()
    {
        return $this->bizId;
    }

    /**
     * Set orderId
     *
     * @param string $orderId
     * @return BizOrder
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
     * Set empId
     *
     * @param string $empId
     * @return BizOrder
     */
    public function setEmpId($empId)
    {
        $this->empId = $empId;
    
        return $this;
    }

    /**
     * Get empId
     *
     * @return string 
     */
    public function getEmpId()
    {
        return $this->empId;
    }

    /**
     * Set authorizeNum
     *
     * @param integer $authorizeNum
     * @return BizOrder
     */
    public function setAuthorizeNum($authorizeNum)
    {
        $this->authorizeNum = $authorizeNum;
    
        return $this;
    }

    /**
     * Get authorizeNum
     *
     * @return integer 
     */
    public function getAuthorizeNum()
    {
        return $this->authorizeNum;
    }

    /**
     * Set storageNum
     *
     * @param integer $storageNum
     * @return BizOrder
     */
    public function setStorageNum($storageNum)
    {
        $this->storageNum = $storageNum;
    
        return $this;
    }

    /**
     * Get storageNum
     *
     * @return integer 
     */
    public function getStorageNum()
    {
        return $this->storageNum;
    }

    /**
     * Set length
     *
     * @param integer $length
     * @return BizOrder
     */
    public function setLength($length)
    {
        $this->length = $length;
    
        return $this;
    }

    /**
     * Get length
     *
     * @return integer 
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return BizOrder
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
     * Set price
     *
     * @param float $price
     * @return BizOrder
     */
    public function setPrice($price)
    {
        $this->price = $price;
    
        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set bank
     *
     * @param string $bank
     * @return BizOrder
     */
    public function setBank($bank)
    {
        $this->bank = $bank;
    
        return $this;
    }

    /**
     * Get bank
     *
     * @return string 
     */
    public function getBank()
    {
        return $this->bank;
    }

    /**
     * Set unit
     *
     * @param string $unit
     * @return BizOrder
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;
    
        return $this;
    }

    /**
     * Get unit
     *
     * @return string 
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Set createTime
     *
     * @param integer $createTime
     * @return BizOrder
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
     * Set modifyTime
     *
     * @param integer $modifyTime
     * @return BizOrder
     */
    public function setModifyTime($modifyTime)
    {
        $this->modifyTime = $modifyTime;
    
        return $this;
    }

    /**
     * Get modifyTime
     *
     * @return integer 
     */
    public function getModifyTime()
    {
        return $this->modifyTime;
    }

    /**
     * Set endTime
     *
     * @param integer $endTime
     * @return BizOrder
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
     * Set tradeNo
     *
     * @param string $tradeNo
     * @return BizOrder
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
     * Set authorId
     *
     * @param string $authorId
     * @return BizOrder
     */
    public function setAuthorId($authorId)
    {
        $this->authorId = $authorId;
    
        return $this;
    }

    /**
     * Get authorId
     *
     * @return string 
     */
    public function getAuthorId()
    {
        return $this->authorId;
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
