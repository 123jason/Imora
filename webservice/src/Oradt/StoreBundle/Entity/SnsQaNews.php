<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SnsQaNews
 */
class SnsQaNews
{
    /**
     * @var string
     */
    private $showId;
    /**
     * @var string
     */
    private $crawlerId;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $content;

    /**
     * @var integer
     */
    private $categoryid;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $tags;

    /**
     * @var integer
     */
    private $commentCount;

    /**
     * @var integer
     */
    private $state;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $modifyTime;

    /**
     * @var integer
     */
    private $sorting;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set showId
     *
     * @param string $showId
     * @return SnsQaNews
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
     * Set crawlerId
     *
     * @param string $crawlerId
     * @return SnsQaNews
     */
    public function setCrawlerId($crawlerId)
    {
        $this->crawlerId = $crawlerId;
    
        return $this;
    }

    /**
     * Get crawlerId
     *
     * @return string 
     */
    public function getCrawlerId()
    {
        return $this->crawlerId;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return SnsQaNews
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
     * Set title
     *
     * @param string $title
     * @return SnsQaNews
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
     * @return SnsQaNews
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
     * Set categoryid
     *
     * @param integer $categoryid
     * @return SnsQaNews
     */
    public function setCategoryid($categoryid)
    {
        $this->categoryid = $categoryid;
    
        return $this;
    }

    /**
     * Get categoryid
     *
     * @return integer 
     */
    public function getCategoryid()
    {
        return $this->categoryid;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return SnsQaNews
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
     * Set name
     *
     * @param string $name
     * @return SnsQaNews
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set tags
     *
     * @param string $tags
     * @return SnsQaNews
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Get tags
     *
     * @return string
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set commentCount
     *
     * @param integer $commentCount
     * @return SnsQaNews
     */
    public function setCommentCount($commentCount)
    {
        $this->commentCount = $commentCount;
    
        return $this;
    }

    /**
     * Get commentCount
     *
     * @return integer 
     */
    public function getCommentCount()
    {
        return $this->commentCount;
    }

    /**
     * Set state
     *
     * @param integer $state
     * @return SnsQaNews
     */
    public function setState($state)
    {
        $this->state = $state;
    
        return $this;
    }

    /**
     * Get state
     *
     * @return integer 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return SnsQaNews
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
     * Set modifyTime
     *
     * @param integer $modifyTime
     * @return SnsQaNews
     */
    public function setModifyTime($modifyTime)
    {
        $this->modifyTime = $modifyTime;
    
        return $this;
    }

    /**
     * Get modifyTime
     *
     * @return integer 
     */
    public function getModifyTime()
    {
        return $this->modifyTime;
    }

    /**
     * Set sorting
     *
     * @param integer $sorting
     * @return SnsQaNews
     */
    public function setSorting($sorting)
    {
        $this->sorting = $sorting;
    
        return $this;
    }

    /**
     * Get sorting
     *
     * @return integer 
     */
    public function getSorting()
    {
        return $this->sorting;
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
     * @var string
     */
    private $keyword;


    /**
     * Set keyword
     *
     * @param string $keyword
     * @return SnsQaNews
     */
    public function setKeyword($keyword)
    {
        $this->keyword = $keyword;
    
        return $this;
    }

    /**
     * Get keyword
     *
     * @return string 
     */
    public function getKeyword()
    {
        return $this->keyword;
    }
    /**
     * @var string
     */
    private $webFrom;

    /**
     * @var integer
     */
    private $clickCount;

    /**
     * @var integer
     */
    private $shareCount;

    /**
     * @var integer
     */
    private $pushTime;

    /**
     * Set pushTime
     *
     * @param string $pushTime
     * @return SnsQaNews
     */

    public function setPushTime($pushTime)
    {
        $this->pushTime = $pushTime;

        return $this;
    }

    /**
     * Get pushTime
     *
     * @return string
     */
    public function getPushTime()
    {
        return $this->pushTime;
    }


    /**
     * Set webFrom
     *
     * @param string $webFrom
     * @return SnsQaNews
     */
    public function setWebFrom($webFrom)
    {
        $this->webFrom = $webFrom;
    
        return $this;
    }

    /**
     * Get webFrom
     *
     * @return string 
     */
    public function getWebFrom()
    {
        return $this->webFrom;
    }

    /**
     * Set clickCount
     *
     * @param integer $clickCount
     * @return SnsQaNews
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
     * Set shareCount
     *
     * @param integer $shareCount
     * @return SnsQaNews
     */
    public function setShareCount($shareCount)
    {
        $this->shareCount = $shareCount;
    
        return $this;
    }

    /**
     * Get shareCount
     *
     * @return integer 
     */
    public function getShareCount()
    {
        return $this->shareCount;
    }
    /**
     * @var integer
     */
    private $collectCount;


    /**
     * Set collectCount
     *
     * @param integer $collectCount
     * @return SnsQaNews
     */
    public function setCollectCount($collectCount)
    {
        $this->collectCount = $collectCount;
    
        return $this;
    }

    /**
     * Get collectCount
     *
     * @return integer 
     */
    public function getCollectCount()
    {
        return $this->collectCount;
    }
    /**
     * @var string
     */
    private $image;


    /**
     * Set image
     *
     * @param string $image
     * @return SnsQaNews
     */
    public function setImage($image)
    {
        $this->image = $image;
    
        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }
}
