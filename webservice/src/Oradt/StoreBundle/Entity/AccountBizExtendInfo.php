<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountBizExtendInfo
 */
class AccountBizExtendInfo
{
    /**
     * @var string
     */
    private $bizId;

    /**
     * @var string
     */
    private $adminId;

    /**
     * @var string
     */
    private $registerIp;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set bizId
     *
     * @param string $bizId
     * @return AccountBizExtendInfo
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
     * Set adminId
     *
     * @param string $adminId
     * @return AccountBizExtendInfo
     */
    public function setAdminId($adminId)
    {
        $this->adminId = $adminId;
    
        return $this;
    }

    /**
     * Get adminId
     *
     * @return string 
     */
    public function getAdminId()
    {
        return $this->adminId;
    }

    /**
     * Set registerIp
     *
     * @param string $registerIp
     * @return AccountBizExtendInfo
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
     * @param \DateTime $createdTime
     * @return AccountBizExtendInfo
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
