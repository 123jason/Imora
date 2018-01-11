<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountBasicPasswordError
 */
class AccountBasicPasswordError
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var integer
     */
    private $errorNum;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var integer
     */
    private $lastLoginTime;

    /**
     * @var integer
     */
    private $lastErrorTime;

    /**
     * @var integer
     */
    private $lockTime;

    /**
     * @var integer
     */
    private $type;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return AccountBasicPasswordError
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
     * Set errorNum
     *
     * @param integer $errorNum
     * @return AccountBasicPasswordError
     */
    public function setErrorNum($errorNum)
    {
        $this->errorNum = $errorNum;
    
        return $this;
    }

    /**
     * Get errorNum
     *
     * @return integer 
     */
    public function getErrorNum()
    {
        return $this->errorNum;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return AccountBasicPasswordError
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
     * Set lastLoginTime
     *
     * @param integer $lastLoginTime
     * @return AccountBasicPasswordError
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
    public function getLastLogintime()
    {
        return $this->lastLoginTime;
    }

    /**
     * Set lastErrorTime
     *
     * @param integer $lastErrorTime
     * @return AccountBasicPasswordError
     */
    public function setLastErrorTime($lastErrorTime)
    {
        $this->lastErrorTime = $lastErrorTime;
    
        return $this;
    }

    /**
     * Get lastErrorTime
     *
     * @return integer 
     */
    public function getLastErrorTime()
    {
        return $this->lastErrorTime;
    }

    /**
     * Set lockTime
     *
     * @param integer $lockTime
     * @return AccountBasicPasswordError
     */
    public function setLockTime($lockTime)
    {
        $this->lockTime = $lockTime;
    
        return $this;
    }

    /**
     * Get lockTime
     *
     * @return integer 
     */
    public function getLockTime()
    {
        return $this->lockTime;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return AccountBasicPasswordError
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
