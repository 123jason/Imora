<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountBasicLoginRecord
 */
class AccountBasicLoginRecord
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var integer
     */
    private $lastLoginTime;

    /**
     * @var string
     */
    private $lastLoginIp;

    /**
     * @var integer
     */
    private $loginTime;

    /**
     * @var string
     */
    private $loginIp;

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
     * @return AccountBasicLoginRecord
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
     * Set lastLoginTime
     *
     * @param integer $lastLoginTime
     * @return AccountBasicLoginRecord
     */
    public function setLastLoginTime($lastLoginTime)
    {
        $this->lastLoginTime = $lastLoginTime;
    
        return $this;
    }

    /**
     * Get lastLoginTime
     *
     * @return integer 
     */
    public function getLastLoginTime()
    {
        return $this->lastLoginTime;
    }

    /**
     * Set lastLoginIp
     *
     * @param string $lastLoginIp
     * @return AccountBasicLoginRecord
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
     * @param integer $loginTime
     * @return AccountBasicLoginRecord
     */
    public function setLoginTime($loginTime)
    {
        $this->loginTime = $loginTime;
    
        return $this;
    }

    /**
     * Get loginTime
     *
     * @return integer 
     */
    public function getLoginTime()
    {
        return $this->loginTime;
    }

    /**
     * Set loginIp
     *
     * @param string $loginIp
     * @return AccountBasicLoginRecord
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
     * Set state
     *
     * @param integer $state
     * @return AccountBasicLoginRecord
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
