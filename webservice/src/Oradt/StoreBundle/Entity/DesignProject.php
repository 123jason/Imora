<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DesignProject
 */
class DesignProject
{
    /**
     * @var string
     */
    private $projectId;

    /**
     * @var string
     */
    private $userId;
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
    private $contact;

    /**
     * @var string
     */
    private $styleId;

    /**
     * @var string
     */
    private $color;

    /**
     * @var string
     */
    private $tplContent;

    /**
     * @var string
     */
    private $location;

    /**
     * @var \DateTime
     */
    private $deadlineTime;

    /**
     * @var string
     */
    private $price;
    /**
     * @var string
     */
    private $unitId;

    /**
     * @var \integer
     */
    private $createTime;

    /**
     * @var \integer
     */
    private $updateTime;

    /**
     * @var boolean
     */
    private $status;

     /**
     * @var \integer
     */
    private $endTime;
 
    /**
     * @var boolean
     */
    private $type;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set projectId
     *
     * @param string $projectId
     * @return DesignProject
     */
    public function setProjectId($projectId)
    {
        $this->projectId = $projectId;

        return $this;
    }

    /**
     * Set unitId
     *
     * @param string $unitId
     * @return DesignProject
     */
    public function setUnitId($unitId)
    {
        $this->unitId = $unitId;

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
     * Get unitId
     *
     * @return string
     */
    public function getUnitId()
    {
        return $this->unitId;
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
     * Set $userId
     *
     * @param string $userId
     * @return DesignProject
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return DesignProject
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
     * @return DesignProject
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
     * Set contact
     *
     * @param string $contact
     * @return DesignProject
     */
    public function setContact($contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return string 
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set styleId
     *
     * @param string $styleId
     * @return DesignProject
     */
    public function setStyleId($styleId)
    {
        $this->styleId = $styleId;

        return $this;
    }

    /**
     * Get styleId
     *
     * @return string 
     */
    public function getStyleId()
    {
        return $this->styleId;
    }

    /**
     * Set color
     *
     * @param string $color
     * @return DesignProject
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string 
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set tplContent
     *
     * @param string $tplContent
     * @return DesignProject
     */
    public function setTplContent($tplContent)
    {
        $this->tplContent = $tplContent;

        return $this;
    }

    /**
     * Get tplContent
     *
     * @return string 
     */
    public function getTplContent()
    {
        return $this->tplContent;
    }

    /**
     * Set location
     *
     * @param string $location
     * @return DesignProject
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set deadlineTime
     *
     * @param \DateTime $deadlineTime
     * @return DesignProject
     */
    public function setDeadlineTime($deadlineTime)
    {
        $this->deadlineTime = $deadlineTime;

        return $this;
    }

    /**
     * Get deadlineTime
     *
     * @return \DateTime 
     */
    public function getDeadlineTime()
    {
        return $this->deadlineTime;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return DesignProject
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set createTime
     *
     * @param \DateTime $createTime
     * @return DesignProject
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
     * Set updateTime
     *
     * @param \DateTime $updateTime
     * @return DesignProject
     */
    public function setUpdateTime($updateTime)
    {
        $this->updateTime = $updateTime;

        return $this;
    }

    /**
     * Get updateTime
     *
     * @return \DateTime 
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return DesignProject
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean 
     */
    public function getType()
    {
        return $this->type;
    }
    /**
     * Set status
     *
     * @param boolean $status
     * @return DesignProject
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
     * Set endTime
     *
     * @param integer $endTime
     * @return DesignProject
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }



}
