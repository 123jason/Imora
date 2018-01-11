<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContactCardRemind
 */
class ContactCardRemind
{
    /**
     * @var string
     */
    private $vcardId;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $remark;

    /**
     * @var integer
     */
    private $remarkDate;


    /**
     * @var integer
     */
    private $remindTime;

    /**
     * @var integer
     */
    private $startTime;


    /**
     * @var integer
     */
    private $modifyTime;

    /**
     * @var integer
     */
    private $timeset;

    /**
     * @var integer
     */
    private $cycle;

    /**
     * @var integer
     */
    private $flagTime;

    /**
     * @var integer
     */
    private $endTime;

    /**
     * @var integer
     */
    private $sortid;

    /**
     * @var integer
     */
    private $type;

    /**
     * @var integer
     */
    private $scheduleId;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var integer
     */
    private $classes;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set vcardId
     *
     * @param string $vcardId
     * @return ContactCardRemind
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
     * Set userId
     *
     * @param string $userId
     * @return ContactCardRemind
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
     * Set remark
     *
     * @param string $remark
     * @return ContactCardRemind
     */
    public function setRemark($remark)
    {
        $this->remark = $remark;
    
        return $this;
    }

    /**
     * Get remark
     *
     * @return string 
     */
    public function getRemark()
    {
        return $this->remark;
    }

    /**
     * Set remarkDate
     *
     * @param integer $remarkDate
     * @return ContactCardRemind
     */
    public function setRemarkDate($remarkDate)
    {
        $this->remarkDate = $remarkDate;
    
        return $this;
    }

    /**
     * Get remarkDate
     *
     * @return integer
     */
    public function getRemarkDate()
    {
        return $this->remarkDate;
    }

    /**
     * Set scheduleId
     *
     * @param integer $scheduleId
     * @return ContactCardRemind
     */
    public function setScheduleId($scheduleId)
    {
        $this->scheduleId = $scheduleId;

        return $this;
    }

    /**
     * Get scheduleId
     *
     * @return integer
     */
    public function getScheduleId()
    {
        return $this->scheduleId;
    }


    /**
     * Set remindTime
     *
     * @param integer $remindTime
     * @return ContactCardRemind
     */
    public function setRemindTime($remindTime)
    {
        $this->remindTime = $remindTime;

        return $this;
    }

    /**
     * Get remindTime
     *
     * @return integer
     */
    public function getRemindTime()
    {
        return $this->remindTime;
    }

    /**
     * Set timeset
     *
     * @param integer $timeset
     * @return ContactCardRemind
     */
    public function setTimeset($timeset)
    {
        $this->timeset = $timeset;

        return $this;
    }

    /**
     * Get timeset
     *
     * @return integer
     */
    public function getTimeset()
    {
        return $this->timeset;
    }

    /**
     * Set startTime
     *
     * @param integer $startTime
     * @return ContactCardRemind
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
     * @return ContactCardRemind
     */
    public function setendTime($endTime)
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * Get endTime
     *
     * @return integer
     */
    public function getendTime()
    {
        return $this->endTime;
    }

    /**
     * Set modifyTime
     *
     * @param integer $modifyTime
     * @return ContactCardRemind
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
     * Set cycle
     *
     * @param integer $cycle
     * @return ContactCardRemind
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
     * Set flagTime
     *
     * @param integer $flagTime
     * @return ContactCardRemind
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
     * Set status
     *
     * @param integer $status
     * @return ContactCardRemind
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
     * Set classes
     *
     * @param integer $classes
     * @return ContactCardRemind
     */
    public function setClasses($classes)
    {
        $this->classes = $classes;

        return $this;
    }

    /**
     * Get classes
     *
     * @return integer
     */
    public function getClasses()
    {
        return $this->classes;
    }

    /**
     * Set sortid
     *
     * @param integer $sortid
     * @return ContactCardRemind
     */
    public function setSortid($sortid)
    {
        $this->sortid = $sortid;

        return $this;
    }

    /**
     * Get sortid
     *
     * @return integer
     */
    public function getSortid()
    {
        return $this->sortid;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return ContactCardRemind
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
    private $fromId;


    /**
     * Set fromId
     *
     * @param string $fromId
     * @return ContactCardRemind
     */
    public function setFromId($fromId)
    {
        $this->fromId = $fromId;
    
        return $this;
    }

    /**
     * Get fromId
     *
     * @return string 
     */
    public function getFromId()
    {
        return $this->fromId;
    }
}
