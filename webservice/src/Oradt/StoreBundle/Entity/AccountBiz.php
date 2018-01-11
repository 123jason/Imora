<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountBiz
 */
class AccountBiz
{
    /**
     * @var string
     */
    private $bizId;

    /**
     * @var string
     */
    private $userName;

    /**
     * @var string
     */
    private $password;

    /**
     * @var boolean
     */
    private $secureLevel;

    /**
     * @var string
     */
    private $status;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $unlimited;

    /**
     * Set bizId
     *
     * @param string $bizId
     * @return AccountBiz
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
     * Set userName
     *
     * @param string $userName
     * @return AccountBiz
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
    
        return $this;
    }

    /**
     * Get userName
     *
     * @return string 
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return AccountBiz
     */
    public function setPassword($password)
    {
        $this->password = $password;
    
        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set secureLevel
     *
     * @param boolean $secureLevel
     * @return AccountBiz
     */
    public function setSecureLevel($secureLevel)
    {
        $this->secureLevel = $secureLevel;
    
        return $this;
    }

    /**
     * Get secureLevel
     *
     * @return boolean 
     */
    public function getSecureLevel()
    {
        return $this->secureLevel;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return AccountBiz
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
     * Get unlimited
     *
     * @return string 
     */
    public function getUnlimited()
    {
        return $this->unlimited;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return AccountBiz
     */
    public function setUnlimited($unlimited)
    {
        $this->unlimited = $unlimited;
    
        return $this;
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
