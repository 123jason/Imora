<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SnsAccount
 */
class SnsAccount
{
    /**
     * @var string
     */
    private $accountId;

    /**
     * @var integer
     */
    private $snsNum;

    /**
     * @var string
     */
    private $status;

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
     * @return SnsAccount
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
     * Set snsNum
     *
     * @param integer $snsNum
     * @return SnsAccount
     */
    public function setSnsNum($snsNum)
    {
        $this->snsNum = $snsNum;
    
        return $this;
    }

    /**
     * Get snsNum
     *
     * @return integer 
     */
    public function getSnsNum()
    {
        return $this->snsNum;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return SnsAccount
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
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return SnsAccount
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
