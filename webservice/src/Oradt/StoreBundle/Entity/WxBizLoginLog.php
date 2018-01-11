<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WxBizLoginLog
 */
class WxBizLoginLog
{
    /**
     * @var string
     */
    private $accountId;

    /**
     * @var string
     */
    private $accountType;

    /**
     * @var string
     */
    private $deviceType;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set accountId
     *
     * @param string $accountId
     * @return WxBizLoginLog
     */
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;
    
        return $this;
    }

    /**
     * Get accountId
     *
     * @return string 
     */
    public function getAccountId()
    {
        return $this->accountId;
    }

    /**
     * Set accountType
     *
     * @param string $accountType
     * @return WxBizLoginLog
     */
    public function setAccountType($accountType)
    {
        $this->accountType = $accountType;
    
        return $this;
    }

    /**
     * Get accountType
     *
     * @return string 
     */
    public function getAccountType()
    {
        return $this->accountType;
    }

    /**
     * Set deviceType
     *
     * @param string $deviceType
     * @return WxBizLoginLog
     */
    public function setDeviceType($deviceType)
    {
        $this->deviceType = $deviceType;
    
        return $this;
    }

    /**
     * Get deviceType
     *
     * @return string 
     */
    public function getDeviceType()
    {
        return $this->deviceType;
    }

    /**
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return WxBizLoginLog
     */
    public function setCreatedTime($createdTime)
    {
        $this->createdTime = $createdTime;
    
        return $this;
    }

    /**
     * Get createdTime
     *
     * @return \DateTime 
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
