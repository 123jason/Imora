<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Topic
 */
class Topic
{
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
    private $title;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $status;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var string
     */
    private $categoryId;

    /**
     * @var integer
     */
    private $totalRead;

    /**
     * @var integer
     */
    private $totalFollow;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set topicId
     *
     * @param string $topicId
     * @return Topic
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
     * @return Topic
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
     * Set title
     *
     * @param string $title
     * @return Topic
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Topic
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
     * Set status
     *
     * @param string $status
     * @return Topic
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
     * @return Topic
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
     * Set categoryId
     *
     * @param string $categoryId
     * @return Topic
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
    
        return $this;
    }

    /**
     * Get categoryId
     *
     * @return string 
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * Set totalRead
     *
     * @param integer $totalRead
     * @return Topic
     */
    public function setTotalRead($totalRead)
    {
        $this->totalRead = $totalRead;
    
        return $this;
    }

    /**
     * Get totalRead
     *
     * @return integer 
     */
    public function getTotalRead()
    {
        return $this->totalRead;
    }

    /**
     * Set totalFollow
     *
     * @param integer $totalFollow
     * @return Topic
     */
    public function setTotalFollow($totalFollow)
    {
        $this->totalFollow = $totalFollow;
    
        return $this;
    }

    /**
     * Get totalFollow
     *
     * @return integer 
     */
    public function getTotalFollow()
    {
        return $this->totalFollow;
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
