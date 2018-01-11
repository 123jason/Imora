<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContactCardRemark
 */
class ContactCardRemark
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
     * @var \DateTime
     */
    private $remarkDate;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set vcardId
     *
     * @param string $vcardId
     * @return ContactCardRemark
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
     * @return ContactCardRemark
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
     * @return ContactCardRemark
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
     * @param \DateTime $remarkDate
     * @return ContactCardRemark
     */
    public function setRemarkDate($remarkDate)
    {
        $this->remarkDate = $remarkDate;
    
        return $this;
    }

    /**
     * Get remarkDate
     *
     * @return \DateTime 
     */
    public function getRemarkDate()
    {
        return $this->remarkDate;
    }

    /**
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return ContactCardRemark
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
     * Set status
     *
     * @param integer $status
     * @return ContactCardRemark
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
    /**
     * @var string
     */
    private $fromId;


    /**
     * Set fromId
     *
     * @param string $fromId
     * @return ContactCardRemark
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
