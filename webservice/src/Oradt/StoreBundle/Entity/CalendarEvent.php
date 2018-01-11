<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CalendarEvent
 */
class CalendarEvent
{ 
    /**
     * @var string
     */
    private $eventId;

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
    private $title;

    /**
     * @var string
     */
    private $content;

    /**
     * @var \DateTime
     */
    private $startTime;

    /**
     * @var \DateTime
     */
    private $endTime;

    /**
     * @var string
     */
    private $status;

    /**
     * @var integer
     */
    private $repeating;

    /**
     * @var \DateTime
     */
    private $repeatEndtime;

    /**
     * @var string
     */
    private $timezone;

    /**
     * @var string
     */
    private $remindTime;

    /**
     * @var \DateTime
     */
    private $lastModified;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $isinviter;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set eventId
     *
     * @param string $eventId
     * @return CalendarEvent
     */
    public function setEventId($eventId)
    {
        $this->eventId = $eventId;
    
        return $this;
    }

    /**
     * Get eventId
     *
     * @return string 
     */
    public function getEventId()
    {
        return $this->eventId;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return CalendarEvent
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
     * @return CalendarEvent
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
     * Set title
     *
     * @param string $title
     * @return CalendarEvent
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
     * @return CalendarEvent
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
     * Set startTime
     *
     * @param \DateTime $startTime
     * @return CalendarEvent
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
    
        return $this;
    }

    /**
     * Get startTime
     *
     * @return \DateTime 
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set endTime
     *
     * @param \DateTime $endTime
     * @return CalendarEvent
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
    
        return $this;
    }

    /**
     * Get endTime
     *
     * @return \DateTime 
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return CalendarEvent
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
     * Set repeating
     *
     * @param integer $repeating
     * @return CalendarEvent
     */
    public function setRepeating($repeating)
    {
        $this->repeating = $repeating;
    
        return $this;
    }

    /**
     * Get repeating
     *
     * @return integer 
     */
    public function getRepeating()
    {
        return $this->repeating;
    }

    /**
     * Set repeatEndtime
     *
     * @param \DateTime $repeatEndtime
     * @return CalendarEvent
     */
    public function setRepeatEndtime($repeatEndtime)
    {
        $this->repeatEndtime = $repeatEndtime;
    
        return $this;
    }

    /**
     * Get repeatEndtime
     *
     * @return \DateTime 
     */
    public function getRepeatEndtime()
    {
        return $this->repeatEndtime;
    }

    /**
     * Set timezone
     *
     * @param string $timezone
     * @return CalendarEvent
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;
    
        return $this;
    }

    /**
     * Get timezone
     *
     * @return string 
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * Set remindTime
     *
     * @param string $remindTime
     * @return CalendarEvent
     */
    public function setRemindTime($remindTime)
    {
        $this->remindTime = $remindTime;
    
        return $this;
    }

    /**
     * Get remindTime
     *
     * @return string 
     */
    public function getRemindTime()
    {
        return $this->remindTime;
    }

    /**
     * Set lastModified
     *
     * @param \DateTime $lastModified
     * @return CalendarEvent
     */
    public function setLastModified($lastModified)
    {
        $this->lastModified = $lastModified;
    
        return $this;
    }

    /**
     * Get lastModified
     *
     * @return \DateTime 
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return CalendarEvent
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
     * Set isinviter
     *
     * @param integer $isinviter
     * @return CalendarEvent
     */
    public function setIsinviter($isinviter)
    {
        $this->isinviter = $isinviter;
    
        return $this;
    }

    /**
     * Get isinviter
     *
     * @return integer 
     */
    public function getIsinviter()
    {
        return $this->isinviter;
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
    private $style;

    /**
     * @var boolean
     */
    private $isfounder;

    /**
     * @var string
     */
    private $address;


    /**
     * Set style
     *
     * @param string $style
     * @return CalendarEvent
     */
    public function setStyle($style)
    {
        $this->style = $style;

        return $this;
    }

    /**
     * Get style
     *
     * @return string 
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * Set isfounder
     *
     * @param boolean $isfounder
     * @return CalendarEvent
     */
    public function setIsfounder($isfounder)
    {
        $this->isfounder = $isfounder;

        return $this;
    }

    /**
     * Get isfounder
     *
     * @return boolean 
     */
    public function getIsfounder()
    {
        return $this->isfounder;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return CalendarEvent
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
     * @var string
     */
    private $container;


    /**
     * Set container
     *
     * @param string $container
     * @return CalendarEvent
     */
    public function setContainer($container)
    {
        $this->container = $container;

        return $this;
    }

    /**
     * Get container
     *
     * @return string 
     */
    public function getContainer()
    {
        return $this->container;
    }
    /**
     * @var boolean
     */
    private $allday;


    /**
     * Set allday
     *
     * @param boolean $allday
     * @return CalendarEvent
     */
    public function setAllday($allday)
    {
        $this->allday = $allday;
    
        return $this;
    }

    /**
     * Get allday
     *
     * @return boolean 
     */
    public function getAllday()
    {
        return $this->allday;
    }
}
