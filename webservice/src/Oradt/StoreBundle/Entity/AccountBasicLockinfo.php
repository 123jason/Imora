<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountBasicLockinfo
 */
class AccountBasicLockinfo
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var integer
     */
    private $snsLock;

    /**
     * @var integer
     */
    private $snsLockTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return AccountBasicLockinfo
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
     * Set snsLock
     *
     * @param integer $snsLock
     * @return AccountBasicLockinfo
     */
    public function setSnsLock($snsLock)
    {
        $this->snsLock = $snsLock;
    
        return $this;
    }

    /**
     * Get snsLock
     *
     * @return integer 
     */
    public function getSnsLock()
    {
        return $this->snsLock;
    }

    /**
     * Set snsLockTime
     *
     * @param integer $snsLockTime
     * @return AccountBasicLockinfo
     */
    public function setSnsLockTime($snsLockTime)
    {
        $this->snsLockTime = $snsLockTime;
    
        return $this;
    }

    /**
     * Get snsLockTime
     *
     * @return integer 
     */
    public function getSnsLockTime()
    {
        return $this->snsLockTime;
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
     * @var integer
     */
    private $violateCount;


    /**
     * Set violateCount
     *
     * @param integer $violateCount
     * @return AccountBasicLockinfo
     */
    public function setViolateCount($violateCount)
    {
        $this->violateCount = $violateCount;
    
        return $this;
    }

    /**
     * Get violateCount
     *
     * @return integer 
     */
    public function getViolateCount()
    {
        return $this->violateCount;
    }
}
