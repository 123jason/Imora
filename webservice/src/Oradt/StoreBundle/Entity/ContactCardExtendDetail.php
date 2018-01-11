<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContactCardExtendDetail
 */
class ContactCardExtendDetail
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $uuid;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $smallPath;

    /**
     * @var string
     */
    private $resPath;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $resInfo;

    /**
     * @var boolean
     */
    private $type;

    /**
     * @var integer
     */
    private $sort;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var integer
     */
    private $createTime;

    /**
     * @var integer
     */
    private $isdelete;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return ContactCardExtendDetail
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
     * Set uuid
     *
     * @param string $uuid
     * @return ContactCardExtendDetail
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    
        return $this;
    }

    /**
     * Get uuid
     *
     * @return string 
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return ContactCardExtendDetail
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
     * Set resInfo
     *
     * @param string $resInfo
     * @return ContactCardExtendDetail
     */
    public function setResInfo($resInfo)
    {
        $this->resInfo = $resInfo;

        return $this;
    }

    /**
     * Get resInfo
     *
     * @return string
     */
    public function getResInfo()
    {
        return $this->resInfo;
    }

    /**
     * Set smallPath
     *
     * @param string $smallPath
     * @return ContactCardExtendDetail
     */
    public function setSmallPath($smallPath)
    {
        $this->smallPath = $smallPath;
    
        return $this;
    }

    /**
     * Get smallPath
     *
     * @return string 
     */
    public function getSmallPath()
    {
        return $this->smallPath;
    }

    /**
     * Set resPath
     *
     * @param string $resPath
     * @return ContactCardExtendDetail
     */
    public function setResPath($resPath)
    {
        $this->resPath = $resPath;
    
        return $this;
    }

    /**
     * Get resPath
     *
     * @return string 
     */
    public function getResPath()
    {
        return $this->resPath;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return ContactCardExtendDetail
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
     * Set type
     *
     * @param boolean $type
     * @return ContactCardExtendDetail
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return boolean 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set sort
     *
     * @param integer $sort
     * @return ContactCardExtendDetail
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
     * Set status
     *
     * @param integer $status
     * @return ContactCardExtendDetail
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
     * Set isdelete
     *
     * @param integer $isdelete
     * @return ContactCardExtendDetail
     */
    public function setIsdelete($isdelete)
    {
        $this->isdelete = $isdelete;

        return $this;
    }

    /**
     * Get isdelete
     *
     * @return integer
     */
    public function getIsdelete()
    {
        return $this->isdelete;
    }

    /**
     * Set createTime
     *
     * @param integer $createTime
     * @return ContactCardExtendDetail
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
