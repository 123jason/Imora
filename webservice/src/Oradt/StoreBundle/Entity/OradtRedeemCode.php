<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OradtRedeemCode
 */
class OradtRedeemCode
{
    /**
     * @var integer
     */
    private $groupId;

    /**
     * @var string
     */
    private $redeemCode;

    /**
     * @var integer
     */
    private $startTime;

    /**
     * @var integer
     */
    private $endTime;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var string
     */
    private $accountId;

    /**
     * @var integer
     */
    private $releaseTime;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var string
     */
    private $useAccountId;

    /**
     * @var string
     */
    private $useAccount;

    /**
     * @var string
     */
    private $useName;

    /**
     * @var integer
     */
    private $useTime;

    /**
     * @var string
     */
    private $orderId;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set groupId
     *
     * @param integer $groupId
     * @return OradtRedeemCode
     */
    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;
    
        return $this;
    }

    /**
     * Get groupId
     *
     * @return integer 
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * Set redeemCode
     *
     * @param string $redeemCode
     * @return OradtRedeemCode
     */
    public function setRedeemCode($redeemCode)
    {
        $this->redeemCode = $redeemCode;
    
        return $this;
    }

    /**
     * Get redeemCode
     *
     * @return string 
     */
    public function getRedeemCode()
    {
        return $this->redeemCode;
    }

    /**
     * Set startTime
     *
     * @param integer $startTime
     * @return OradtRedeemCode
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
    
        return $this;
    }

    /**
     * Get startTime
     *
     * @return integer 
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set endTime
     *
     * @param integer $endTime
     * @return OradtRedeemCode
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
    
        return $this;
    }

    /**
     * Get endTime
     *
     * @return integer 
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return OradtRedeemCode
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
     * Set accountId
     *
     * @param string $accountId
     * @return OradtRedeemCode
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
     * Set releaseTime
     *
     * @param integer $releaseTime
     * @return OradtRedeemCode
     */
    public function setReleaseTime($releaseTime)
    {
        $this->releaseTime = $releaseTime;
    
        return $this;
    }

    /**
     * Get releaseTime
     *
     * @return integer 
     */
    public function getReleaseTime()
    {
        return $this->releaseTime;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return OradtRedeemCode
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
     * Set useAccountId
     *
     * @param string $useAccountId
     * @return OradtRedeemCode
     */
    public function setUseAccountId($useAccountId)
    {
        $this->useAccountId = $useAccountId;
    
        return $this;
    }

    /**
     * Get useAccountId
     *
     * @return string 
     */
    public function getUseAccountId()
    {
        return $this->useAccountId;
    }

    /**
     * Set useAccount
     *
     * @param string $useAccount
     * @return OradtRedeemCode
     */
    public function setUseAccount($useAccount)
    {
        $this->useAccount = $useAccount;
    
        return $this;
    }

    /**
     * Get useAccount
     *
     * @return string 
     */
    public function getUseAccount()
    {
        return $this->useAccount;
    }

    /**
     * Set useName
     *
     * @param string $useName
     * @return OradtRedeemCode
     */
    public function setUseName($useName)
    {
        $this->useName = $useName;
    
        return $this;
    }

    /**
     * Get useName
     *
     * @return string 
     */
    public function getUseName()
    {
        return $this->useName;
    }

    /**
     * Set useTime
     *
     * @param integer $useTime
     * @return OradtRedeemCode
     */
    public function setUseTime($useTime)
    {
        $this->useTime = $useTime;
    
        return $this;
    }

    /**
     * Get useTime
     *
     * @return integer 
     */
    public function getUseTime()
    {
        return $this->useTime;
    }

    /**
     * Set orderId
     *
     * @param string $orderId
     * @return OradtRedeemCode
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
    
        return $this;
    }

    /**
     * Get orderId
     *
     * @return string 
     */
    public function getOrderId()
    {
        return $this->orderId;
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
