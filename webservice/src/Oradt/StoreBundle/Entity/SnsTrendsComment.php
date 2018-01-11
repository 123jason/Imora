<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SnsTrendsComment
 */
class SnsTrendsComment
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
    private $trendsId;

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
     * Set parentId
     *
     * @param string $parentId
     * @return SnsTrendsComment
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
     * @return SnsTrendsComment
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
     * @return SnsTrendsComment
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
     * Set trendsId
     *
     * @param string $trendsId
     * @return SnsTrendsComment
     */
    public function setTrendsId($trendsId)
    {
        $this->trendsId = $trendsId;
    
        return $this;
    }

    /**
     * Get trendsId
     *
     * @return string 
     */
    public function getTrendsId()
    {
        return $this->trendsId;
    }

    /**
     * Set toUid
     *
     * @param string $toUid
     * @return SnsTrendsComment
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
     * @return SnsTrendsComment
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
     * @return SnsTrendsComment
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
     * Set state
     *
     * @param string $state
     * @return SnsTrendsComment
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
     * @return SnsTrendsComment
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
