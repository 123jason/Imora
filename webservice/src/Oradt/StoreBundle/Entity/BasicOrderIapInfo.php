<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BasicOrderIapInfo
 */
class BasicOrderIapInfo
{
    /**
     * @var string
     */
    private $orderId;

    /**
     * @var string
     */
    private $receipt;

    /**
     * @var integer
     */
    private $createTime;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $info;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set orderId
     *
     * @param string $orderId
     * @return BasicOrderIapInfo
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
     * Set receipt
     *
     * @param string $receipt
     * @return BasicOrderIapInfo
     */
    public function setReceipt($receipt)
    {
        $this->receipt = $receipt;
    
        return $this;
    }

    /**
     * Get receipt
     *
     * @return string 
     */
    public function getReceipt()
    {
        return $this->receipt;
    }

    /**
     * Set createTime
     *
     * @param integer $createTime
     * @return BasicOrderIapInfo
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
     * Set status
     *
     * @param string $status
     * @return BasicOrderIapInfo
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
     * Set info
     *
     * @param string $info
     * @return BasicOrderIapInfo
     */
    public function setInfo($info)
    {
        $this->info = $info;
    
        return $this;
    }

    /**
     * Get info
     *
     * @return string 
     */
    public function getInfo()
    {
        return $this->info;
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
