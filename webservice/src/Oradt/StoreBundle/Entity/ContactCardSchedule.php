<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContactCardSchedule
 */
class ContactCardSchedule
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $address;

    /**
     * @var integer
     */
    private $startTime;

    /**
     * @var integer
     */
    private $endTime;

    /**
     * @var string
     */
    private $remindTime;

    /**
     * @var integer
     */
    private $flagTime;

    /**
     * @var integer
     */
    private $cycle;

    /**
     * @var string
     */
    private $vcardId;

    /**
     * @var boolean
     */
    private $isallday;

    /**
     * @var integer
     */
    private $lastModify;

    /**
     * @var integer
     */
    private $isRemind;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var integer
     */
    private $createTime;

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
    private $flightId;

    /**
     * @var integer
     */
    private $scheduleFrom;

    /**
     * @var string
     */
    private $scheduleInfo;

    /**
     * @var string
     */
    private $scheduleMd5;

    /**
     * @var integer
     */
    private $remindType;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return ContactCardSchedule
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
     * Set cycle
     *
     * @param integer $cycle
     * @return ContactCardSchedule
     */
    public function setCycle($cycle)
    {
        $this->cycle = $cycle;

        return $this;
    }

    /**
     * Get cycle
     *
     * @return integer
     */
    public function getCycle()
    {
        return $this->cycle;
    }

    /**
     * Set remindTime
     *
     * @param string $remindTime
     * @return ContactCardSchedule
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
     * Set remindType
     *
     * @param integer $remindType
     * @return ContactCardSchedule
     */
    public function setRemindType($remindType)
    {
        $this->remindType = $remindType;

        return $this;
    }
    /**
     * Get remindType
     *
     * @return integer
     */
    public function getRemindType()
    {
        return $this->remindType;
    }

    /**
     * Set flagTime
     *
     * @param integer $flagTime
     * @return ContactCardSchedule
     */
    public function setFlagTime($flagTime)
    {
        $this->flagTime = $flagTime;

        return $this;
    }
    /**
     * Get flagTime
     *
     * @return integer
     */
    public function getFlagTime()
    {
        return $this->flagTime;
    }

    /**
     * Set vcardId
     *
     * @param string $vcardId
     * @return ContactCardSchedule
     */
    public function setVcardId($vcardId)
    {
        $this->vcardId = $vcardId;

        return $this;
    }

    /**
     * Get vcardId
     *
     * @return string
     */
    public function getVcardId()
    {
        return $this->vcardId;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     * @return ContactCardSchedule
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
     * @return ContactCardSchedule
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
     * Set title
     *
     * @param string $title
     * @return ContactCardSchedule
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
     * @return ContactCardSchedule
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
     * Set address
     *
     * @param string $address
     * @return ContactCardSchedule
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
     * Set scheduleMd5
     *
     * @param string $scheduleMd5
     * @return ContactCardSchedule
     */
    public function setscheduleMd5($scheduleMd5)
    {
        $this->scheduleMd5 = $scheduleMd5;

        return $this;
    }

    /**
     * Get scheduleMd5
     *
     * @return string
     */
    public function getscheduleMd5()
    {
        return $this->scheduleMd5;
    }

    /**
     * Set startTime
     *
     * @param integer $startTime
     * @return ContactCardSchedule
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
     * @return ContactCardSchedule
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
     * Set isallday
     *
     * @param boolean $isallday
     * @return ContactCardSchedule
     */
    public function setIsallday($isallday)
    {
        $this->isallday = $isallday;
    
        return $this;
    }

    /**
     * Get isallday
     *
     * @return boolean 
     */
    public function getIsallday()
    {
        return $this->isallday;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return ContactCardSchedule
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
     * Set lastModify
     *
     * @param integer $lastModify
     * @return ContactCardSchedule
     */
    public function setLastModify($lastModify)
    {
        $this->lastModify = $lastModify;
    
        return $this;
    }

    /**
     * Get lastModify
     *
     * @return integer 
     */
    public function getLastModify()
    {
        return $this->lastModify;
    }

    /**
     * Set isRemind
     *
     * @param integer $isRemind
     * @return ContactCardSchedule
     */
    public function setIsRemind($isRemind)
    {
        $this->isRemind = $isRemind;

        return $this;
    }

    /**
     * Get isRemind
     *
     * @return integer
     */
    public function getIsRemind()
    {
        return $this->isRemind;
    }

    /**
     * Set createTime
     *
     * @param integer $createTime
     * @return ContactCardSchedule
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
     * Set flightId
     *
     * @param string $flightId
     * @return ContactCardSchedule
     */
    public function setFlightId($flightId)
    {
        $this->flightId = $flightId;

        return $this;
    }

    /**
     * Get flightId
     *
     * @return string
     */
    public function getFlightId()
    {
        return $this->flightId;
    }

    /**
     * Set scheduleFrom
     *
     * @param integer $scheduleFrom
     * @return ContactCardSchedule
     */
    public function setScheduleFrom($scheduleFrom)
    {
        $this->scheduleFrom = $scheduleFrom;

        return $this;
    }

    /**
     * Get scheduleFrom
     *
     * @return integer
     */
    public function getScheduleFrom()
    {
        return $this->scheduleFrom;
    }


    /**
     * Set scheduleInfo
     *
     * @param string $scheduleInfo
     * @return ContactCardSchedule
     */
    public function setScheduleInfo($scheduleInfo)
    {
        $this->scheduleInfo = $scheduleInfo;

        return $this;
    }

    /**
     * Get scheduleInfo
     *
     * @return string
     */
    public function getScheduleInfo()
    {
        return $this->scheduleInfo;
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
