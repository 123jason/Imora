<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TopicComment
 */
class TopicComment
{
    /**
     * @var string
     */
    private $commentId;

    /**
     * @var string
     */
    private $parentId;

    /**
     * @var string
     */
    private $topicId;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $comment;

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
     * Set commentId
     *
     * @param string $commentId
     * @return TopicComment
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
     * Set parentId
     *
     * @param string $parentId
     * @return TopicComment
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
     * Set topicId
     *
     * @param string $topicId
     * @return TopicComment
     */
    public function setTopicId($topicId)
    {
        $this->topicId = $topicId;
    
        return $this;
    }

    /**
     * Get topicId
     *
     * @return string 
     */
    public function getTopicId()
    {
        return $this->topicId;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return TopicComment
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
     * Set comment
     *
     * @param string $comment
     * @return TopicComment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    
        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return TopicComment
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
     * @return TopicComment
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
