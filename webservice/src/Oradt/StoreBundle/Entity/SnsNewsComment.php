<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SnsNewsComment
 */
class SnsNewsComment
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
    private $newsId;

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
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set parentId
     *
     * @param string $parentId
     * @return SnsNewsComment
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
     * @return SnsNewsComment
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
     * @return SnsNewsComment
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
     * Set newsId
     *
     * @param string $newsId
     * @return SnsNewsComment
     */
    public function setNewsId($newsId)
    {
        $this->newsId = $newsId;
    
        return $this;
    }

    /**
     * Get newsId
     *
     * @return string 
     */
    public function getNewsId()
    {
        return $this->newsId;
    }

    /**
     * Set toUid
     *
     * @param string $toUid
     * @return SnsNewsComment
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
     * @return SnsNewsComment
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
     * @return SnsNewsComment
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
     * @param integer $createdTime
     * @return SnsNewsComment
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
