<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DesignBanner
 */
class DesignBanner
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $linkUrl;

    /**
     * @var integer
     */
    private $sort;

    /**
     * @var integer
     */
    private $createTime;

    /**
     * @var boolean
     */
    private $status;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set title
     *
     * @param string $title
     * @return DesignBanner
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
     * Set url
     *
     * @param string $url
     * @return DesignBanner
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
     * Set linkUrl
     *
     * @param string $linkUrl
     * @return DesignBanner
     */
    public function setLinkUrl($linkUrl)
    {
        $this->linkUrl = $linkUrl;
    
        return $this;
    }

    /**
     * Get linkUrl
     *
     * @return string 
     */
    public function getLinkUrl()
    {
        return $this->linkUrl;
    }

    /**
     * Set sort
     *
     * @param integer $sort
     * @return DesignBanner
     */
    public function setSort($sort)
    {
        $this->sort = $sort;
    
        return $this;
    }

    /**
     * Get sort
     *
     * @return integer 
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Set createTime
     *
     * @param integer $createTime
     * @return DesignBanner
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
     * Set status
     *
     * @param boolean $status
     * @return DesignBanner
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return boolean 
     */
    public function getStatus()
    {
        return $this->status;
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
    private $bannerId;


    /**
     * Set bannerId
     *
     * @param string $bannerId
     * @return DesignBanner
     */
    public function setBannerId($bannerId)
    {
        $this->bannerId = $bannerId;
    
        return $this;
    }

    /**
     * Get bannerId
     *
     * @return string 
     */
    public function getBannerId()
    {
        return $this->bannerId;
    }
}
