<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OperationActivity
 */
class OperationActivity
{
    /**
     * @var string
     */
    private $activityId;

    /**
     * @var integer
     */
    private $type;

    /**
     * @var integer
     */
    private $isnotify;

    /**
     * @var integer
     */
    private $pushState;

    /**
     * @var string
     */
    private $region;

    /**
     * @var string
     */
    private $industry;

    /**
     * @var string
     */
    private $func;

    /**
     * @var string
     */
    private $showId;

    /**
     * @var string
     */
    private $image;

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
    private $onlinetime;

    /**
     * @var integer
     */
    private $offlinetime;

    /**
     * @var string
     */
    private $userId;

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
    private $state;

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
    private $shareUserCount;

    /**
     * @var integer
     */
    private $pushCount;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $url;

    /**
     * @var integer
     */
    private $jsonData;

    /**
     * @var string
     */
    private $weburl;

    /**
     * @var string
     */
    private $admin;

    /**
     * Set activityId
     *
     * @param string $activityId
     * @return OperationActivity
     */
    public function setActivityId($activityId)
    {
        $this->activityId = $activityId;
    
        return $this;
    }

    /**
     * Get activityId
     *
     * @return string 
     */
    public function getActivityId()
    {
        return $this->activityId;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return OperationActivity
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set isnotify
     *
     * @param integer $isnotify
     * @return OperationActivity
     */
    public function setIsnotify($isnotify)
    {
        $this->isnotify = $isnotify;
    
        return $this;
    }

    /**
     * Get isnotify
     *
     * @return integer 
     */
    public function getIsnotify()
    {
        return $this->isnotify;
    }

    /**
     * Set pushState
     *
     * @param integer $pushState
     * @return OperationActivity
     */
    public function setPushState($pushState)
    {
        $this->pushState = $pushState;
    
        return $this;
    }

    /**
     * Get pushState
     *
     * @return integer 
     */
    public function getPushState()
    {
        return $this->pushState;
    }

    /**
     * Set region
     *
     * @param string $region
     * @return OperationActivity
     */
    public function setRegion($region)
    {
        $this->region = $region;
    
        return $this;
    }

    /**
     * Get region
     *
     * @return string 
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set industry
     *
     * @param string $industry
     * @return OperationActivity
     */
    public function setIndustry($industry)
    {
        $this->industry = $industry;
    
        return $this;
    }

    /**
     * Get industry
     *
     * @return string 
     */
    public function getIndustry()
    {
        return $this->industry;
    }

    /**
     * Set func
     *
     * @param string $func
     * @return OperationActivity
     */
    public function setFunc($func)
    {
        $this->func = $func;
    
        return $this;
    }

    /**
     * Get func
     *
     * @return string 
     */
    public function getFunc()
    {
        return $this->func;
    }

    /**
     * Set showId
     *
     * @param string $showId
     * @return OperationActivity
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
     * Set image
     *
     * @param string $image
     * @return OperationActivity
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
     * Set title
     *
     * @param string $title
     * @return OperationActivity
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
     * @return OperationActivity
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
     * Set onlinetime
     *
     * @param integer $onlinetime
     * @return OperationActivity
     */
    public function setOnlinetime($onlinetime)
    {
        $this->onlinetime = $onlinetime;
    
        return $this;
    }

    /**
     * Get onlinetime
     *
     * @return integer 
     */
    public function getOnlinetime()
    {
        return $this->onlinetime;
    }

    /**
     * Set offlinetime
     *
     * @param integer $offlinetime
     * @return OperationActivity
     */
    public function setOfflinetime($offlinetime)
    {
        $this->offlinetime = $offlinetime;
    
        return $this;
    }

    /**
     * Get offlinetime
     *
     * @return integer 
     */
    public function getOfflinetime()
    {
        return $this->offlinetime;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return OperationActivity
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
     * Set createdTime
     *
     * @param integer $createdTime
     * @return OperationActivity
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
     * @return OperationActivity
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
     * Set state
     *
     * @param integer $state
     * @return OperationActivity
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
     * Set clickCount
     *
     * @param integer $clickCount
     * @return OperationActivity
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
     * @return OperationActivity
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
     * Set shareUserCount
     *
     * @param integer $shareUserCount
     * @return OperationActivity
     */
    public function setShareUserCount($shareUserCount)
    {
        $this->shareUserCount = $shareUserCount;
    
        return $this;
    }

    /**
     * Get shareUserCount
     *
     * @return integer 
     */
    public function getShareUserCount()
    {
        return $this->shareUserCount;
    }

    /**
     * Set pushCount
     *
     * @param integer $pushCount
     * @return OperationActivity
     */
    public function setPushCount($pushCount)
    {
        $this->pushCount = $pushCount;
    
        return $this;
    }

    /**
     * Get pushCount
     *
     * @return integer 
     */
    public function getPushCount()
    {
        return $this->pushCount;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return OperationActivity
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
     * Set jsonData
     *
     * @param string $jsonData
     * @return OperationActivity
     */
    public function setJsonData($jsonData)
    {
        $this->jsonData = $jsonData;

        return $this;
    }

    /**
     * Get jsonData
     *
     * @return string
     */
    public function getJsonData()
    {
        return $this->jsonData;
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
     * @var boolean
     */
    private $pushStatus;

    /**
     * @var integer
     */
    private $startTime;

    /**
     * @var integer
     */
    private $endTime;

    /**
     * @var boolean
     */
    private $status;

    /**
     * @var integer
     */
    private $pushTime;

    /**
     * @var integer
     */
    private $nextPushTime;

    /**
     * @var integer
     */
    private $isback;

    /**
     * @var integer
     */
    private $isloop;

    /**
     * @var integer
     */
    private $isget;

    /**
     * @var integer
     */
    private $groups;


    /**
     * Set pushStatus
     *
     * @param boolean $pushStatus
     * @return OperationActivity
     */
    public function setPushStatus($pushStatus)
    {
        $this->pushStatus = $pushStatus;
    
        return $this;
    }

    /**
     * Get pushStatus
     *
     * @return boolean 
     */
    public function getPushStatus()
    {
        return $this->pushStatus;
    }

    /**
     * Set startTime
     *
     * @param integer $startTime
     * @return OperationActivity
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
    
        return $this;
    }

    /**
     * Get startTime
     *
     * @return integer 
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set endTime
     *
     * @param integer $endTime
     * @return OperationActivity
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
    
        return $this;
    }

    /**
     * Get endTime
     *
     * @return integer 
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return OperationActivity
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
     * Set pushTime
     *
     * @param integer $pushTime
     * @return OperationActivity
     */
    public function setPushTime($pushTime)
    {
        $this->pushTime = $pushTime;
    
        return $this;
    }

    /**
     * Get pushTime
     *
     * @return integer 
     */
    public function getPushTime()
    {
        return $this->pushTime;
    }

    /**
     * Set nextPushTime
     *
     * @param integer $nextPushTime
     * @return OperationActivity
     */
    public function setNextPushTime($nextPushTime)
    {
        $this->nextPushTime = $nextPushTime;
    
        return $this;
    }

    /**
     * Get nextPushTime
     *
     * @return integer 
     */
    public function getNextPushTime()
    {
        return $this->nextPushTime;
    }

    /**
     * Set isback
     *
     * @param boolean $isback
     * @return OperationActivity
     */
    public function setIsback($isback)
    {
        $this->isback = $isback;
    
        return $this;
    }

    /**
     * Get isback
     *
     * @return boolean 
     */
    public function getIsback()
    {
        return $this->isback;
    }

    /**
     * Set isloop
     *
     * @param boolean $isloop
     * @return OperationActivity
     */
    public function setIsloop($isloop)
    {
        $this->isloop = $isloop;
    
        return $this;
    }

    /**
     * Get isloop
     *
     * @return boolean 
     */
    public function getIsloop()
    {
        return $this->isloop;
    }

    /**
     * Set isget
     *
     * @param boolean $isget
     * @return OperationActivity
     */
    public function setIsget($isget)
    {
        $this->isget = $isget;
    
        return $this;
    }

    /**
     * Get isget
     *
     * @return boolean 
     */
    public function getIsget()
    {
        return $this->isget;
    }

    /**
     * Set weburl
     *
     * @param string $weburl
     * @return OperationActivity
     */
    public function setWeburl($weburl)
    {
        $this->weburl = $weburl;
    
        return $this;
    }

    /**
     * Get weburl
     *
     * @return string 
     */
    public function getWeburl()
    {
        return $this->weburl;
    }

    /**
     * Set admin
     *
     * @param string $admin
     * @return OperationActivity
     */
    public function setAdmin($admin)
    {
        $this->admin = $admin;
    
        return $this;
    }

    /**
     * Get admin
     *
     * @return string 
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * Set groups
     *
     * @param int $groups
     * @return OperationActivity
     */
    public function setGroups($groups)
    {
        $this->groups = $groups;
    
        return $this;
    }

    /**
     * Get groups
     *
     * @return int 
     */
    public function getGroups()
    {
        return $this->groups;
    }
}
