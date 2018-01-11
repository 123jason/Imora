<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OradtRechargeAppPrice
 */
class OradtRechargeAppPrice
{
    /**
     * @var integer
     */
    private $type;

    /**
     * @var string
     */
    private $title;

    /**
     * @var integer
     */
    private $equityTime;

    /**
     * @var integer
     */
    private $equityCapacity;

    /**
     * @var float
     */
    private $price;

    /**
     * @var string
     */
    private $appid;

    /**
     * @var string
     */
    private $info;

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
    private $modifiedTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set type
     *
     * @param integer $type
     * @return OradtRechargeAppPrice
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
     * Set title
     *
     * @param string $title
     * @return OradtRechargeAppPrice
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set equityTime
     *
     * @param integer $equityTime
     * @return OradtRechargeAppPrice
     */
    public function setEquityTime($equityTime)
    {
        $this->equityTime = $equityTime;
    
        return $this;
    }

    /**
     * Get equityTime
     *
     * @return integer 
     */
    public function getEquityTime()
    {
        return $this->equityTime;
    }

    /**
     * Set equityCapacity
     *
     * @param integer $equityCapacity
     * @return OradtRechargeAppPrice
     */
    public function setEquityCapacity($equityCapacity)
    {
        $this->equityCapacity = $equityCapacity;
    
        return $this;
    }

    /**
     * Get equityCapacity
     *
     * @return integer 
     */
    public function getEquityCapacity()
    {
        return $this->equityCapacity;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return OradtRechargeAppPrice
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
     * Set appid
     *
     * @param string $appid
     * @return OradtRechargeAppPrice
     */
    public function setAppid($appid)
    {
        $this->appid = $appid;
    
        return $this;
    }

    /**
     * Get appid
     *
     * @return string 
     */
    public function getAppid()
    {
        return $this->appid;
    }

    /**
     * Set info
     *
     * @param string $info
     * @return OradtRechargeAppPrice
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
     * Set status
     *
     * @param integer $status
     * @return OradtRechargeAppPrice
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
     * @return OradtRechargeAppPrice
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
     * Set modifiedTime
     *
     * @param integer $modifiedTime
     * @return OradtRechargeAppPrice
     */
    public function setModifiedTime($modifiedTime)
    {
        $this->modifiedTime = $modifiedTime;
    
        return $this;
    }

    /**
     * Get modifiedTime
     *
     * @return integer 
     */
    public function getModifiedTime()
    {
        return $this->modifiedTime;
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
