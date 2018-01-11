<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SnsQaPushSetting
 */
class SnsQaPushSetting
{
    /**
     * @var integer
     */
    private $isnotice;

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
    private $id;


    /**
     * Set isnotice
     *
     * @param integer $isnotice
     * @return SnsQaPushSetting
     */
    public function setIsnotice($isnotice)
    {
        $this->isnotice = $isnotice;
    
        return $this;
    }

    /**
     * Get isnotice
     *
     * @return integer 
     */
    public function getIsnotice()
    {
        return $this->isnotice;
    }

    /**
     * Set pushTime
     *
     * @param integer $pushTime
     * @return SnsQaPushSetting
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
     * @return SnsQaPushSetting
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
     * @return SnsQaPushSetting
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
     * @return SnsQaPushSetting
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
     * @return SnsQaPushSetting
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
     * @return SnsQaPushSetting
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
     * @return SnsQaPushSetting
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
     * @return SnsQaPushSetting
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
