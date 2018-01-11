<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TaskRecord
 */
class TaskRecord
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
    private $type;

    /**
     * @var string
     */
    private $content;

    /**
     * @var boolean
     */
    private $isread;

    /**
     * @var boolean
     */
    private $rank;

    /**
     * @var string
     */
    private $module;

    /**
     * @var integer
     */
    private $createTime;

    /**
     * @var integer
     */
    private $lastModified;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var string
     */
    private $resPath;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return TaskRecord
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
     * @return TaskRecord
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
     * Set type
     *
     * @param integer $type
     * @return TaskRecord
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
     * Set content
     *
     * @param string $content
     * @return TaskRecord
     */
    public function setContent($content)
    {
        $this->content = $content;
    
        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set isread
     *
     * @param boolean $isread
     * @return TaskRecord
     */
    public function setIsread($isread)
    {
        $this->isread = $isread;
    
        return $this;
    }

    /**
     * Get isread
     *
     * @return boolean 
     */
    public function getIsread()
    {
        return $this->isread;
    }

    /**
     * Set rank
     *
     * @param integer $rank
     * @return TaskRecord
     */
    public function setRank($rank)
    {
        $this->rank = $rank;
    
        return $this;
    }

    /**
     * Get rank
     *
     * @return integer
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Set module
     *
     * @param string $module
     * @return TaskRecord
     */
    public function setModule($module)
    {
        $this->module = $module;
    
        return $this;
    }

    /**
     * Get module
     *
     * @return string 
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * Set createTime
     *
     * @param integer $createTime
     * @return TaskRecord
     */
    public function setCreateTime($createTime)
    {
        $this->createTime = $createTime;
    
        return $this;
    }

    /**
     * Get createTime
     *
     * @return integer 
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * Set lastModified
     *
     * @param integer $lastModified
     * @return TaskRecord
     */
    public function setLastModified($lastModified)
    {
        $this->lastModified = $lastModified;

        return $this;
    }

    /**
     * Get lastModified
     *
     * @return integer
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return TaskRecord
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
     * Set resPath
     *
     * @param string $resPath
     * @return TaskRecord
     */
    public function setResPath($resPath)
    {
        $this->resPath = $resPath;

        return $this;
    }

    /**
     * Get resPath
     *
     * @return string
     */
    public function getResPath()
    {
        return $this->resPath;
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
