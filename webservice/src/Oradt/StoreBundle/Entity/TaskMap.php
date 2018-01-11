<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TaskMap
 */
class TaskMap
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var integer
     */
    private $taskId;

    /**
     * @var boolean
     */
    private $status;

    /**
     * @var boolean
     */
    private $isdelete;
    
    /**
     * @var integer
     */
    private $finishedTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return TaskMap
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
     * Set taskId
     *
     * @param integer $taskId
     * @return TaskMap
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
     * Set status
     *
     * @param boolean $status
     * @return TaskMap
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return boolean 
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * Set isdelete
     *
     * @param boolean $isdelete
     * @return TaskMap
     */
    public function setIsdelete($isdelete)
    {
        $this->isdelete = $isdelete;
    
        return $this;
    }

    /**
     * Get isdelete
     *
     * @return boolean 
     */
    public function getIsdelete()
    {
        return $this->isdelete;
    }

    /**
     * Set finishedTime
     *
     * @param integer $finishedTime
     * @return TaskMap
     */
    public function setFinishedTime($finishedTime)
    {
        $this->finishedTime = $finishedTime;
    
        return $this;
    }

    /**
     * Get finishedTime
     *
     * @return integer 
     */
    public function getFinishedTime()
    {
        return $this->finishedTime;
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
