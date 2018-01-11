<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountBizLoginRecord
 */
class AccountBizLoginRecord
{
    /**
     * @var string
     */
    private $bizId;

    /**
     * @var \DateTime
     */
    private $lastLoginTime;

    /**
     * @var string
     */
    private $lastLoginIp;

    /**
     * @var \DateTime
     */
    private $loginTime;

    /**
     * @var string
     */
    private $loginIp;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set bizId
     *
     * @param string $bizId
     * @return AccountBizLoginRecord
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
     * Set lastLoginTime
     *
     * @param \DateTime $lastLoginTime
     * @return AccountBizLoginRecord
     */
    public function setLastLoginTime($lastLoginTime)
    {
        $this->lastLoginTime = $lastLoginTime;
    
        return $this;
    }

    /**
     * Get lastLoginTime
     *
     * @return \DateTime 
     */
    public function getLastLoginTime()
    {
        return $this->lastLoginTime;
    }

    /**
     * Set lastLoginIp
     *
     * @param string $lastLoginIp
     * @return AccountBizLoginRecord
     */
    public function setLastLoginIp($lastLoginIp)
    {
        $this->lastLoginIp = $lastLoginIp;
    
        return $this;
    }

    /**
     * Get lastLoginIp
     *
     * @return string 
     */
    public function getLastLoginIp()
    {
        return $this->lastLoginIp;
    }

    /**
     * Set loginTime
     *
     * @param \DateTime $loginTime
     * @return AccountBizLoginRecord
     */
    public function setLoginTime($loginTime)
    {
        $this->loginTime = $loginTime;
    
        return $this;
    }

    /**
     * Get loginTime
     *
     * @return \DateTime 
     */
    public function getLoginTime()
    {
        return $this->loginTime;
    }

    /**
     * Set loginIp
     *
     * @param string $loginIp
     * @return AccountBizLoginRecord
     */
    public function setLoginIp($loginIp)
    {
        $this->loginIp = $loginIp;
    
        return $this;
    }

    /**
     * Get loginIp
     *
     * @return string 
     */
    public function getLoginIp()
    {
        return $this->loginIp;
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
