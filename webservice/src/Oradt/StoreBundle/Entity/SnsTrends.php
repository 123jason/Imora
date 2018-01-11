<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SnsTrends
 */
class SnsTrends
{
    /**
     * @var string
     */
    private $trendsId;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $shareType;

    /**
     * @var string
     */
    private $shareTitle;

    /**
     * @var string
     */
    private $shareIcon;

    /**
     * @var string
     */
    private $shareUrl;

    /**
     * @var string
     */
    private $latitude;

    /**
     * @var string
     */
    private $longitude;

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $ifprivate;

    /**
     * @var string
     */
    private $permission;

    /**
     * @var string
     */
    private $reminduserids;

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
    private $commentCount;

    /**
     * @var integer
     */
    private $praiseCount;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set trendsId
     *
     * @param string $trendsId
     * @return SnsTrends
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
     * Set userId
     *
     * @param string $userId
     * @return SnsTrends
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
     * Set type
     *
     * @param string $type
     * @return SnsTrends
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
     * Set content
     *
     * @param string $content
     * @return SnsTrends
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
     * Set shareType
     *
     * @param string $shareType
     * @return SnsTrends
     */
    public function setShareType($shareType)
    {
        $this->shareType = $shareType;
    
        return $this;
    }

    /**
     * Get shareType
     *
     * @return string 
     */
    public function getShareType()
    {
        return $this->shareType;
    }

    /**
     * Set shareTitle
     *
     * @param string $shareTitle
     * @return SnsTrends
     */
    public function setShareTitle($shareTitle)
    {
        $this->shareTitle = $shareTitle;
    
        return $this;
    }

    /**
     * Get shareTitle
     *
     * @return string 
     */
    public function getShareTitle()
    {
        return $this->shareTitle;
    }

    /**
     * Set shareIcon
     *
     * @param string $shareIcon
     * @return SnsTrends
     */
    public function setShareIcon($shareIcon)
    {
        $this->shareIcon = $shareIcon;
    
        return $this;
    }

    /**
     * Get shareIcon
     *
     * @return string 
     */
    public function getShareIcon()
    {
        return $this->shareIcon;
    }

    /**
     * Set shareUrl
     *
     * @param string $shareUrl
     * @return SnsTrends
     */
    public function setShareUrl($shareUrl)
    {
        $this->shareUrl = $shareUrl;
    
        return $this;
    }

    /**
     * Get shareUrl
     *
     * @return string 
     */
    public function getShareUrl()
    {
        return $this->shareUrl;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     * @return SnsTrends
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    
        return $this;
    }

    /**
     * Get latitude
     *
     * @return string 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     * @return SnsTrends
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    
        return $this;
    }

    /**
     * Get longitude
     *
     * @return string 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return SnsTrends
     */
    public function setAddress($address)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set ifprivate
     *
     * @param string $ifprivate
     * @return SnsTrends
     */
    public function setIfprivate($ifprivate)
    {
        $this->ifprivate = $ifprivate;
    
        return $this;
    }

    /**
     * Get ifprivate
     *
     * @return string 
     */
    public function getIfprivate()
    {
        return $this->ifprivate;
    }

    /**
     * Set permission
     *
     * @param string $permission
     * @return SnsTrends
     */
    public function setPermission($permission)
    {
        $this->permission = $permission;
    
        return $this;
    }

    /**
     * Get permission
     *
     * @return string 
     */
    public function getPermission()
    {
        return $this->permission;
    }

    /**
     * Set reminduserids
     *
     * @param string $reminduserids
     * @return SnsTrends
     */
    public function setReminduserids($reminduserids)
    {
        $this->reminduserids = $reminduserids;
    
        return $this;
    }

    /**
     * Get reminduserids
     *
     * @return string 
     */
    public function getReminduserids()
    {
        return $this->reminduserids;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return SnsTrends
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
     * @return SnsTrends
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
     * Set commentCount
     *
     * @param integer $commentCount
     * @return SnsTrends
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
     * Set praiseCount
     *
     * @param integer $praiseCount
     * @return SnsTrends
     */
    public function setPraiseCount($praiseCount)
    {
        $this->praiseCount = $praiseCount;
    
        return $this;
    }

    /**
     * Get praiseCount
     *
     * @return integer 
     */
    public function getPraiseCount()
    {
        return $this->praiseCount;
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
