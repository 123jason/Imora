<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SnsQaComment
 */
class SnsQaComment
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
    private $showId;

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
    private $state;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $commentNum;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $toname;

    /**
     * Set parentId
     *
     * @param string $parentId
     * @return SnsQaComment
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
     * @return SnsQaComment
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
     * @return SnsQaComment
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
     * Set showId
     *
     * @param string $showId
     * @return SnsQaComment
     */
    public function setShowId($showId)
    {
        $this->showId = $showId;
    
        return $this;
    }

    /**
     * Get showId
     *
     * @return string 
     */
    public function getShowId()
    {
        return $this->showId;
    }

    /**
     * Set toUid
     *
     * @param string $toUid
     * @return SnsQaComment
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
     * @return SnsQaComment
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
     * Set state
     *
     * @param string $state
     * @return SnsQaComment
     */
    public function setState($state)
    {
        $this->state = $state;
    
        return $this;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return SnsQaComment
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
    /**
     * @var integer
     */
    private $clickCount;


    /**
     * Set clickCount
     *
     * @param integer $clickCount
     * @return SnsQaComment
     */
    public function setClickCount($clickCount)
    {
        $this->clickCount = $clickCount;
    
        return $this;
    }

    /**
     * Get clickCount
     *
     * @return integer 
     */
    public function getClickCount()
    {
        return $this->clickCount;
    }
    /**
     * @var integer
     */
    private $status;


    /**
     * Set status
     *
     * @param integer $status
     * @return SnsQaComment
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
     * Set commentNum
     *
     * @param integer $commentNum
     * @return SnsQaComment
     */
    public function setCommentNum($commentNum)
    {
        $this->commentNum = $commentNum;
    
        return $this;
    }

    /**
     * Get commentNum
     *
     * @return integer 
     */
    public function getCommentNum()
    {
        return $this->commentNum;
    }

    /**
     * Set title
     *
     * @param integer $tile
     * @return SnsQaComment
     */
    public function setTitle($tile)
    {
        $this->title = $tile;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return integer 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set toname
     *
     * @param integer $toname
     * @return SnsQaComment
     */
    public function setToname($toname)
    {
        $this->toname = $toname;
    
        return $this;
    }

    /**
     * Get toname
     *
     * @return integer 
     */
    public function getToname()
    {
        return $this->toname;
    }
    /**
     * @var string
     */
    private $topId;


    /**
     * Set topId
     *
     * @param string $topId
     * @return SnsQaComment
     */
    public function setTopId($topId)
    {
        $this->topId = $topId;
    
        return $this;
    }

    /**
     * Get topId
     *
     * @return string 
     */
    public function getTopId()
    {
        return $this->topId;
    }
}
