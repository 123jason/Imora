<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountBasicExtendInfo
 */
class AccountBasicExtendInfo
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $registerIp;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $state;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return AccountBasicExtendInfo
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
     * Set registerIp
     *
     * @param string $registerIp
     * @return AccountBasicExtendInfo
     */
    public function setRegisterIp($registerIp)
    {
        $this->registerIp = $registerIp;
    
        return $this;
    }

    /**
     * Get registerIp
     *
     * @return string 
     */
    public function getRegisterIp()
    {
        return $this->registerIp;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return AccountBasicExtendInfo
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
     * Set state
     *
     * @param integer $state
     * @return AccountBasicExtendInfo
     */
    public function setState($state)
    {
        $this->state = $state;
    
        return $this;
    }

    /**
     * Get state
     *
     * @return integer 
     */
    public function getState()
    {
        return $this->state;
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
