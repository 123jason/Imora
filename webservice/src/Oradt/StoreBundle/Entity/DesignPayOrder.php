<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DesignPayOrder
 */
class DesignPayOrder
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $productId;

    /**
     * @var string
     */
    private $orderNo;

    /**
     * @var boolean
     */
    private $state;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $updateTime;

    /**
     * @var integer
     */
    private $endTime;

    /**
     * @var string
     */
    private $newCardId;
    /**
     * @var integer
     */
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return DesignPayOrder
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
     * Set productId
     *
     * @param string $productId
     * @return DesignPayOrder
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;
    
        return $this;
    }

    /**
     * Get productId
     *
     * @return string 
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * Set orderNo
     *
     * @param string $orderNo
     * @return DesignPayOrder
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
     * Set state
     *
     * @param boolean $state
     * @return DesignPayOrder
     */
    public function setState($state)
    {
        $this->state = $state;
    
        return $this;
    }

    /**
     * Get state
     *
     * @return boolean 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return DesignPayOrder
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
     * Set updateTime
     *
     * @param integer $updateTime
     * @return DesignPayOrder
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
     * Set endTime
     *
     * @param integer $endTime
     * @return DesignPayOrder
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
     * Set newCardId
     *
     * @param string $newCardId
     * @return DesignPayOrder
     */
    public function setNewCardId($newCardId)
    {
        $this->newCardId = $newCardId;
    
        return $this;
    }

    /**
     * Get newCardId
     *
     * @return string 
     */
    public function getNewCardId()
    {
        return $this->newCardId;
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
