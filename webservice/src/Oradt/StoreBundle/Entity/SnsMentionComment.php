<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SnsMentionComment
 */
class SnsMentionComment
{
    /**
     * @var string
     */
    private $parentId;

    /**
     * @var string
     */
    private $commentId;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $toUid;

    /**
     * @var string
     */
    private $fromUid;

    /**
     * @var string
     */
    private $type;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var string
     */
    private $mentionId;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set parentId
     *
     * @param string $parentId
     * @return SnsMentionComment
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
    
        return $this;
    }

    /**
     * Get parentId
     *
     * @return string 
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Set commentId
     *
     * @param string $commentId
     * @return SnsMentionComment
     */
    public function setCommentId($commentId)
    {
        $this->commentId = $commentId;
    
        return $this;
    }

    /**
     * Get commentId
     *
     * @return string 
     */
    public function getCommentId()
    {
        return $this->commentId;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return SnsMentionComment
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
     * Set toUid
     *
     * @param string $toUid
     * @return SnsMentionComment
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
     * Set fromUid
     *
     * @param string $fromUid
     * @return SnsMentionComment
     */
    public function setFromUid($fromUid)
    {
        $this->fromUid = $fromUid;
    
        return $this;
    }

    /**
     * Get fromUid
     *
     * @return string 
     */
    public function getFromUid()
    {
        return $this->fromUid;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return SnsMentionComment
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
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return SnsMentionComment
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
     * Set mentionId
     *
     * @param string $mentionId
     * @return SnsMentionComment
     */
    public function setMentionId($mentionId)
    {
        $this->mentionId = $mentionId;
    
        return $this;
    }

    /**
     * Get mentionId
     *
     * @return string 
     */
    public function getMentionId()
    {
        return $this->mentionId;
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
