<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SnsContentSharing
 */
class SnsContentSharing
{
    /**
     * @var string
     */
    private $shareId;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $contentUrl;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $fileId;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $visible;

    /**
     * @var integer
     */
    private $id;


    /**
     * @var \DateTime
     */
    private $createdTime;


    /**
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return SnsContentSharing
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
     * Set shareId
     *
     * @param string $shareId
     * @return SnsContentSharing
     */
    public function setShareId($shareId)
    {
        $this->shareId = $shareId;
    
        return $this;
    }

    /**
     * Get shareId
     *
     * @return string 
     */
    public function getShareId()
    {
        return $this->shareId;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return SnsContentSharing
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
     * Set contentUrl
     *
     * @param string $contentUrl
     * @return SnsContentSharing
     */
    public function setContentUrl($contentUrl)
    {
        $this->contentUrl = $contentUrl;
    
        return $this;
    }

    /**
     * Get contentUrl
     *
     * @return string 
     */
    public function getContentUrl()
    {
        return $this->contentUrl;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return SnsContentSharing
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set fileId
     *
     * @param string $fileId
     * @return SnsContentSharing
     */
    public function setFileId($fileId)
    {
        $this->fileId = $fileId;
    
        return $this;
    }

    /**
     * Get fileId
     *
     * @return string 
     */
    public function getFileId()
    {
        return $this->fileId;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return SnsContentSharing
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
     * Set visible
     *
     * @param string $visible
     * @return SnsContentSharing
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;
    
        return $this;
    }

    /**
     * Get visible
     *
     * @return string 
     */
    public function getVisible()
    {
        return $this->visible;
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
