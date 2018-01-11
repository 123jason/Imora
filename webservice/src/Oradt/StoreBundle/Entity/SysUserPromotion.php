<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SysUserPromotion
 */
class SysUserPromotion
{
    /**
     * @var integer
     */
    private $isalluser;

    /**
     * @var integer
     */
    private $pushTime;

    /**
     * @var string
     */
    private $region;

    /**
     * @var string
     */
    private $proId;

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
    private $content;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var string
     */
    private $adminId;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var integer
     */
    private $type;

    /**
     * @var integer
     */
    private $isntice;

    /**
     * @var string
     */
    private $title;

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
     * Set title
     *
     * @param string $title
     * @return SysUserPromotion
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
     * Set type
     *
     * @param integer $type
     * @return SysUserPromotion
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
     * Set isalluser
     *
     * @param integer $isalluser
     * @return SysUserPromotion
     */
    public function setIsalluser($isalluser)
    {
        $this->isalluser = $isalluser;
    
        return $this;
    }

    /**
     * Get isalluser
     *
     * @return integer 
     */
    public function getIsalluser()
    {
        return $this->isalluser;
    }

    /**
     * Set pushTime
     *
     * @param integer $pushTime
     * @return SysUserPromotion
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
     * Set region
     *
     * @param string $region
     * @return SysUserPromotion
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
     * @return SysUserPromotion
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
     * @return SysUserPromotion
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
     * Set content
     *
     * @param string $content
     * @return SysUserPromotion
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
     * Set createdTime
     *
     * @param integer $createdTime
     * @return SysUserPromotion
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
     * Set adminId
     *
     * @param string $adminId
     * @return SysUserPromotion
     */
    public function setAdminId($adminId)
    {
        $this->adminId = $adminId;
    
        return $this;
    }

    /**
     * Get adminId
     *
     * @return string 
     */
    public function getAdminId()
    {
        return $this->adminId;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return SysUserPromotion
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
     * Set isntice
     *
     * @param integer $isntice
     * @return SysUserPromotion
     */
    public function setIsntice($isntice)
    {
        $this->isntice = $isntice;

        return $this;
    }

    /**
     * Get isntice
     *
     * @return integer
     */
    public function getIsntice()
    {
        return $this->isntice;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return SysUserPromotion
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
     * @return SysUserPromotion
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
     * Set proId
     *
     * @param string $proId
     * @return SysUserPromotion
     */
    public function setProId($proId)
    {
        $this->proId = $proId;

        return $this;
    }

    /**
     * Get proId
     *
     * @return string
     */
    public function getProId()
    {
        return $this->proId;
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
    private $nextPushTime;

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
    private $isloop;

    /**
     * @var integer
     */
    private $pushCount;

    /**
     * @var boolean
     */
    private $isget;


    /**
     * Set nextPushTime
     *
     * @param integer $nextPushTime
     * @return SysUserPromotion
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
     * Set startTime
     *
     * @param integer $startTime
     * @return SysUserPromotion
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
     * @return SysUserPromotion
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
     * Set isloop
     *
     * @param boolean $isloop
     * @return SysUserPromotion
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
     * Set pushCount
     *
     * @param integer $pushCount
     * @return SysUserPromotion
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
     * Set isget
     *
     * @param boolean $isget
     * @return SysUserPromotion
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
     * @var integer
     */
    private $pushStatus;


    /**
     * Set pushStatus
     *
     * @param integer $pushStatus
     * @return SysUserPromotion
     */
    public function setPushStatus($pushStatus)
    {
        $this->pushStatus = $pushStatus;
    
        return $this;
    }

    /**
     * Get pushStatus
     *
     * @return integer 
     */
    public function getPushStatus()
    {
        return $this->pushStatus;
    }
}
