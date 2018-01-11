<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OradtTaskStandardUser
 */
class OradtTaskStandardUser
{
    /**
     * @var integer
     */
    private $taskId;

    /**
     * @var string
     */
    private $accountId;

    /**
     * @var integer
     */
    private $count;

    /**
     * @var string
     */
    private $redeemCode;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set taskId
     *
     * @param integer $taskId
     * @return OradtTaskStandardUser
     */
    public function setTaskId($taskId)
    {
        $this->taskId = $taskId;
    
        return $this;
    }

    /**
     * Get taskId
     *
     * @return integer 
     */
    public function getTaskId()
    {
        return $this->taskId;
    }

    /**
     * Set accountId
     *
     * @param string $accountId
     * @return OradtTaskStandardUser
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
     * Set count
     *
     * @param integer $count
     * @return OradtTaskStandardUser
     */
    public function setCount($count)
    {
        $this->count = $count;
    
        return $this;
    }

    /**
     * Get count
     *
     * @return integer 
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set redeemCode
     *
     * @param string $redeemCode
     * @return OradtTaskStandardUser
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
     * Set createdTime
     *
     * @param integer $createdTime
     * @return OradtTaskStandardUser
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
