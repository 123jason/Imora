<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LoginSession
 */
class LoginSession
{
    /**
     * @var string
     */
    private $sessionId;

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
    private $realName;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;

    /**
     * Set sessionId
     *
     * @param string $sessionId
     * @return LoginSession
     */
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;
    
        return $this;
    }

    /**
     * Get sessionId
     *
     * @return string 
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * Set accountId
     *
     * @param string $accountId
     * @return LoginSession
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
     * @return LoginSession
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
     * Set realName
     *
     * @param string $realName
     * @return LoginSession
     */
    public function setRealName($realName)
    {
        $this->realName = $realName;
    
        return $this;
    }

    /**
     * Get realName
     *
     * @return string 
     */
    public function getRealName()
    {
        return $this->realName;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return LoginSession
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
}
