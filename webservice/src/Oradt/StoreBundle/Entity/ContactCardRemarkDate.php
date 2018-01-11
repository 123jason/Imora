<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContactCardRemarkDate
 */
class ContactCardRemarkDate
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
     * @var integer
     */
    private $startTime;

    /**
     * @var integer
     */
    private $endTime;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set vcardId
     *
     * @param string $vcardId
     * @return ContactCardRemarkDate
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
     * @return ContactCardRemarkDate
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
     * Set startTime
     *
     * @param integer $startTime
     * @return ContactCardRemarkDate
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
     * @return ContactCardRemarkDate
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
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return ContactCardRemarkDate
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
