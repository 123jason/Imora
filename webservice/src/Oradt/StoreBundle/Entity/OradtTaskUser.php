<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OradtTaskUser
 */
class OradtTaskUser
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
     * @return OradtTaskUser
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
     * @return OradtTaskUser
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
     * @return OradtTaskUser
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
     * Set createdTime
     *
     * @param integer $createdTime
     * @return OradtTaskUser
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
