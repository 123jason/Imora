<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountBasicLost
 */
class AccountBasicLost
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $mobile;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $reason;

    /**
     * @var string
     */
    private $waring;

    /**
     * @var integer
     */
    private $createdTime;


    /**
     * @var integer
     */
    private $id;


    /**
     * Set name
     *
     * @param string $name
     * @return AccountBasicLost
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
     * Set mobile
     *
     * @param string $mobile
     * @return AccountBasicLost
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    
        return $this;
    }

    /**
     * Get mobile
     *
     * @return string 
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return AccountBasicLost
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set reason
     *
     * @param string $reason
     * @return AccountBasicLost
     */
    public function setReason($reason)
    {
        $this->reason = $reason;
    
        return $this;
    }

    /**
     * Get reason
     *
     * @return string 
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * Set waring
     *
     * @param string $waring
     * @return AccountBasicLost
     */
    public function setWaring($waring)
    {
        $this->waring = $waring;
    
        return $this;
    }

    /**
     * Get waring
     *
     * @return string 
     */
    public function getWaring()
    {
        return $this->waring;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return AccountBasicLost
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
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $deviceId;

    /**
     * @var integer
     */
    private $status;


    /**
     * Set userId
     *
     * @param string $userId
     * @return AccountBasicLost
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
     * Set deviceId
     *
     * @param string $deviceId
     * @return AccountBasicLost
     */
    public function setDeviceId($deviceId)
    {
        $this->deviceId = $deviceId;
    
        return $this;
    }

    /**
     * Get deviceid
     *
     * @return string 
     */
    public function getDeviceId()
    {
        return $this->deviceId;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return AccountBasicLost
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
}
