<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BasicOrderAbnormal
 */
class BasicOrderAbnormal
{
    /**
     * @var string
     */
    private $orderId;

    /**
     * @var string
     */
    private $buyer;

    /**
     * @var string
     */
    private $saler;

    /**
     * @var string
     */
    private $customerId;

    /**
     * @var string
     */
    private $customer;

    /**
     * @var integer
     */
    private $personLiable;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set orderId
     *
     * @param string $orderId
     * @return BasicOrderAbnormal
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
     * Set buyer
     *
     * @param string $buyer
     * @return BasicOrderAbnormal
     */
    public function setBuyer($buyer)
    {
        $this->buyer = $buyer;
    
        return $this;
    }

    /**
     * Get buyer
     *
     * @return string 
     */
    public function getBuyer()
    {
        return $this->buyer;
    }

    /**
     * Set saler
     *
     * @param string $saler
     * @return BasicOrderAbnormal
     */
    public function setSaler($saler)
    {
        $this->saler = $saler;
    
        return $this;
    }

    /**
     * Get saler
     *
     * @return string 
     */
    public function getSaler()
    {
        return $this->saler;
    }

    /**
     * Set customerId
     *
     * @param string $customerId
     * @return BasicOrderAbnormal
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;
    
        return $this;
    }

    /**
     * Get customerId
     *
     * @return string 
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * Set customer
     *
     * @param string $customer
     * @return BasicOrderAbnormal
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
    
        return $this;
    }

    /**
     * Get customer
     *
     * @return string 
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set personLiable
     *
     * @param integer $personLiable
     * @return BasicOrderAbnormal
     */
    public function setPersonLiable($personLiable)
    {
        $this->personLiable = $personLiable;
    
        return $this;
    }

    /**
     * Get personLiable
     *
     * @return integer 
     */
    public function getPersonLiable()
    {
        return $this->personLiable;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return BasicOrderAbnormal
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
     * Set status
     *
     * @param integer $status
     * @return BasicOrderAbnormal
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
