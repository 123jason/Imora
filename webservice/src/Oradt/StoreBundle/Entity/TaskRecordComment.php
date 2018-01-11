<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TaskRecordComment
 */
class TaskRecordComment
{
    /**
     * @var string
     */
    private $fromId;

    /**
     * @var integer
     */
    private $recordId;

    /**
     * @var integer
     */
    private $parentId;

    /**
     * @var string
     */
    private $toUid;

    /**
     * @var string
     */
    private $content;

    /**
     * @var integer
     */
    private $createTime;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var integer
     */
    private $lastModified;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set fromId
     *
     * @param string $fromId
     * @return TaskRecordComment
     */
    public function setFromId($fromId)
    {
        $this->fromId = $fromId;
    
        return $this;
    }

    /**
     * Get fromId
     *
     * @return string 
     */
    public function getFromId()
    {
        return $this->fromId;
    }

    /**
     * Set recordId
     *
     * @param integer $recordId
     * @return TaskRecordComment
     */
    public function setRecordId($recordId)
    {
        $this->recordId = $recordId;
    
        return $this;
    }

    /**
     * Get recordId
     *
     * @return integer 
     */
    public function getRecordId()
    {
        return $this->recordId;
    }

    /**
     * Set parentId
     *
     * @param integer $parentId
     * @return TaskRecordComment
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
    
        return $this;
    }

    /**
     * Get parentId
     *
     * @return integer 
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Set toUid
     *
     * @param string $toUid
     * @return TaskRecordComment
     */
    public function setToUid($toUid)
    {
        $this->toUid = $toUid;
    
        return $this;
    }

    /**
     * Get toUid
     *
     * @return string 
     */
    public function getToUid()
    {
        return $this->toUid;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return TaskRecordComment
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
     * Set createTime
     *
     * @param integer $createTime
     * @return TaskRecordComment
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
     * Set Status
     *
     * @param integer $status
     * @return TaskRecordComment
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get Status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set lastModified
     *
     * @param integer $lastModified
     * @return TaskRecordComment
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
