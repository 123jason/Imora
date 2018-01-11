<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BizRechargeConsumeLog
 */
class BizRechargeConsumeLog
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
     * @var float
     */
    private $price;

    /**
     * @var integer
     */
    private $createTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set type
     *
     * @param integer $type
     * @return BizRechargeConsumeLog
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
     * @return BizRechargeConsumeLog
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
     * @return BizRechargeConsumeLog
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
     * @return BizRechargeConsumeLog
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
     * Set price
     *
     * @param float $price
     * @return BizRechargeConsumeLog
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
     * Set createTime
     *
     * @param integer $createTime
     * @return BizRechargeConsumeLog
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
