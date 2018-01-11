<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WeixinOrder
 */
class WeixinOrder
{
    /**
     * @var string
     */
    private $orderId;

    /**
     * @var string
     */
    private $batchId;

    /**
     * @var string
     */
    private $openId;

    /**
     * @var integer
     */
    private $paystatus;

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
    private $endTime;

    /**
     * @var string
     */
    private $tradeNo;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $type;


    /**
     * Set orderId
     *
     * @param string $orderId
     * @return WeixinOrder
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
     * Set batchId
     *
     * @param string $batchId
     * @return WeixinOrder
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
     * Set openId
     *
     * @param string $openId
     * @return WeixinOrder
     */
    public function setOpenId($openId)
    {
        $this->openId = $openId;
    
        return $this;
    }

    /**
     * Get openId
     *
     * @return string 
     */
    public function getOpenId()
    {
        return $this->openId;
    }

    /**
     * Set paystatus
     *
     * @param integer $paystatus
     * @return WeixinOrder
     */
    public function setPaystatus($paystatus)
    {
        $this->paystatus = $paystatus;
    
        return $this;
    }

    /**
     * Get paystatus
     *
     * @return integer 
     */
    public function getPaystatus()
    {
        return $this->paystatus;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return WeixinOrder
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
     * @return WeixinOrder
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
     * Set endTime
     *
     * @param integer $endTime
     * @return WeixinOrder
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
     * @return WeixinOrder
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return WeixinOrder
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

}
