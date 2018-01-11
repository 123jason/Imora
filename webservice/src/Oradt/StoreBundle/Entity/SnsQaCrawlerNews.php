<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SnsQaCrawlerNews
 */
class SnsQaCrawlerNews
{
    /**
     * @var string
     */
    private $newsId;

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
    private $category;
    /**
     * @var int
     */
    private $categoryId;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var \DateTime
     */
    private $crawlerTime;

    /**
     * @var string
     */
    private $webFrom;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $imageurls;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var integer
     */
    private $sorting;

    /**
     * @var string
     */
    private $keyword;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set newsId
     *
     * @param string $newsId
     * @return SnsQaCrawlerNews
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
     * Set title
     *
     * @param string $title
     * @return SnsQaCrawlerNews
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
     * @return SnsQaCrawlerNews
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
     * Set category
     *
     * @param string $category
     * @return SnsQaCrawlerNews
     */
    public function setCategory($category)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return string 
     */
    public function getCategory()
    {
        return $this->category;
    }


    /**
     * Set categoryId
     *
     * @param string $categoryId
     * @return SnsQaCrawlerNews
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
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return SnsQaCrawlerNews
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
     * Set crawlerTime
     *
     * @param \DateTime $crawlerTime
     * @return SnsQaCrawlerNews
     */
    public function setCrawlerTime($crawlerTime)
    {
        $this->crawlerTime = $crawlerTime;
    
        return $this;
    }

    /**
     * Get crawlerTime
     *
     * @return \DateTime 
     */
    public function getCrawlerTime()
    {
        return $this->crawlerTime;
    }

    /**
     * Set webFrom
     *
     * @param string $webFrom
     * @return SnsQaCrawlerNews
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
     * Set url
     *
     * @param string $url
     * @return SnsQaCrawlerNews
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set imageurls
     *
     * @param string $imageurls
     * @return SnsQaCrawlerNews
     */
    public function setImageurls($imageurls)
    {
        $this->imageurls = $imageurls;
    
        return $this;
    }

    /**
     * Get imageurls
     *
     * @return string 
     */
    public function getImageurls()
    {
        return $this->imageurls;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return SnsQaCrawlerNews
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
     * Set sorting
     *
     * @param integer $sorting
     * @return SnsQaCrawlerNews
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
     * Set keyword
     *
     * @param string $keyword
     * @return SnsQaCrawlerNews
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
    private $image;

    /**
     * @var integer
     */
    private $issue;


    /**
     * Set image
     *
     * @param string $image
     * @return SnsQaCrawlerNews
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

    /**
     * Set issue
     *
     * @param integer $issue
     * @return SnsQaCrawlerNews
     */
    public function setIssue($issue)
    {
        $this->issue = $issue;
    
        return $this;
    }

    /**
     * Get issue
     *
     * @return integer 
     */
    public function getIssue()
    {
        return $this->issue;
    }
    /**
     * @var integer
     */
    private $releaseTime;
    /**
     * Set releaseTime
     *
     * @param integer $releaseTime
     * @return SnsQaCrawlerNews
     */
    public function setReleaseTime($releaseTime)
    {
        $this->releaseTime = $releaseTime;
    
        return $this;
    }

    /**
     * Get releaseTime
     *
     * @return integer 
     */
    public function getReleaseTime()
    {
        return $this->releaseTime;
    }
}
