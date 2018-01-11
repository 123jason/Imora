<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DesignAttachments
 */
class DesignAttachments
{
    /**
     * @var string
     */
    private $attachId;

    /**
     * @var string
     */
    private $projectId;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $name;
    /**
     * @var integer
     */
    private $downloads;

    /**
     * @var integer
     */
    private $sort;

    /**
     * @var integer
     */
    private $createTime;

    /**
     * @var integer
     */
    private $updateTime;
	/**
     * @var integer
     */
    private $type;
    /**
     * @var boolean
     */
    private $status;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set attachId
     *
     * @param string $attachId
     * @return DesignAttachments
     */
    public function setAttachId($attachId)
    {
        $this->attachId = $attachId;
    
        return $this;
    }

    /**
     * Get attachId
     *
     * @return string 
     */
    public function getAttachId()
    {
        return $this->attachId;
    }

    /**
     * Set projectId
     *
     * @param string $projectId
     * @return DesignAttachments
     */
    public function setProjectId($projectId)
    {
        $this->projectId = $projectId;
    
        return $this;
    }

    /**
     * Get projectId
     *
     * @return string 
     */
    public function getProjectId()
    {
        return $this->projectId;
    }

	/**
     * Set name
     *
     * @param string $name
     * @return DesignAttachments
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
     * Set url
     *
     * @param string $url
     * @return DesignAttachments
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
     * Set downloads
     *
     * @param integer $downloads
     * @return DesignAttachments
     */
    public function setDownloads($downloads)
    {
        $this->downloads = $downloads;
    
        return $this;
    }

    /**
     * Get downloads
     *
     * @return integer 
     */
    public function getDownloads()
    {
        return $this->downloads;
    }

    /**
     * Set sort
     *
     * @param integer $sort
     * @return DesignAttachments
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
     * @return DesignAttachments
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
     * Set updateTime
     *
     * @param integer $updateTime
     * @return DesignAttachments
     */
    public function setUpdateTime($updateTime)
    {
        $this->updateTime = $updateTime;
    
        return $this;
    }

    /**
     * Get updateTime
     *
     * @return integer 
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }
    /**
     * Set type
     *
     * @param intval $type
     * @return DesignAttachments
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return intval 
     */
    public function getType()
    {
        return $this->type;
    }
    /**
     * Set status
     *
     * @param boolean $status
     * @return DesignAttachments
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
}
