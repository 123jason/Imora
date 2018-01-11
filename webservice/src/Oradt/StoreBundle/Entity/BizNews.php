<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BizNews
 */
class BizNews
{
    /**
     * @var string
     */
    private $bizId;

    /**
     * @var string
     */
    private $bizNewsId;

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
    private $userId;

    /**
     * @var \DateTime
     */
    private $createTime;

    /**
     * @var \DateTime
     */
    private $releaseTime;

    /**
     * @var string
     */
    private $status;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set bizId
     *
     * @param string $bizId
     * @return BizNews
     */
    public function setBizId($bizId)
    {
        $this->bizId = $bizId;

        return $this;
    }

    /**
     * Get bizId
     *
     * @return string 
     */
    public function getBizId()
    {
        return $this->bizId;
    }

    /**
     * Set bizNewsId
     *
     * @param string $bizNewsId
     * @return BizNews
     */
    public function setBizNewsId($bizNewsId)
    {
        $this->bizNewsId = $bizNewsId;

        return $this;
    }

    /**
     * Get bizNewsId
     *
     * @return string 
     */
    public function getBizNewsId()
    {
        return $this->bizNewsId;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return BizNews
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
     * @return BizNews
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
     * Set userId
     *
     * @param string $userId
     * @return BizNews
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
     * Set createTime
     *
     * @param \DateTime $createTime
     * @return BizNews
     */
    public function setCreateTime($createTime)
    {
        $this->createTime = $createTime;

        return $this;
    }

    /**
     * Get createTime
     *
     * @return \DateTime 
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * Set releaseTime
     *
     * @param \DateTime $releaseTime
     * @return BizNews
     */
    public function setReleaseTime($releaseTime)
    {
        $this->releaseTime = $releaseTime;

        return $this;
    }

    /**
     * Get releaseTime
     *
     * @return \DateTime 
     */
    public function getReleaseTime()
    {
        return $this->releaseTime;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return BizNews
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
    private $type;

    /**
     * @var string
     */
    private $releaser;

    /**
     * @var integer
     */
    private $releaseType;


    /**
     * Set type
     *
     * @param string $type
     * @return BizNews
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
     * Set releaser
     *
     * @param string $releaser
     * @return BizNews
     */
    public function setReleaser($releaser)
    {
        $this->releaser = $releaser;
    
        return $this;
    }

    /**
     * Get releaser
     *
     * @return string 
     */
    public function getReleaser()
    {
        return $this->releaser;
    }

    /**
     * Set releaseType
     *
     * @param integer $releaseType
     * @return BizNews
     */
    public function setReleaseType($releaseType)
    {
        $this->releaseType = $releaseType;
    
        return $this;
    }

    /**
     * Get releaseType
     *
     * @return integer 
     */
    public function getReleaseType()
    {
        return $this->releaseType;
    }
}
