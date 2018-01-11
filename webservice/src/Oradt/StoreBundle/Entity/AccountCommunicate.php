<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountCommunicate
 */
class AccountCommunicate
{    
    
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $mobile;

    /**
     * @var string
     */
    private $mcode;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $status;

    /**
     * @var \DateTime
     */
    private $creatTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set name
     *
     * @param string $name
     * @return AccountCommunicate
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
     * Set mobile
     *
     * @param string $mobile
     * @return AccountCommunicate
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    
        return $this;
    }

    /**
     * Get mobile
     *
     * @return string 
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set mcode
     *
     * @param string $mcode
     * @return AccountCommunicate
     */
    public function setMcode($mcode)
    {
        $this->mcode = $mcode;
    
        return $this;
    }

    /**
     * Get mcode
     *
     * @return string 
     */
    public function getMcode()
    {
        return $this->mcode;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return AccountCommunicate
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
     * Set status
     *
     * @param string $status
     * @return AccountCommunicate
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
     * Set creatTime
     *
     * @param \DateTime $creatTime
     * @return AccountCommunicate
     */
    public function setCreatTime($creatTime)
    {
        $this->creatTime = $creatTime;
    
        return $this;
    }

    /**
     * Get creatTime
     *
     * @return \DateTime 
     */
    public function getCreatTime()
    {
        return $this->creatTime;
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
     * @var boolean
     */
    private $isfriend;

    /**
     * @var \DateTime
     */
    private $sendTime;

    /**
     * @var \DateTime
     */
    private $friendTime;


    /**
     * Set isfriend
     *
     * @param boolean $isfriend
     * @return AccountCommunicate
     */
    public function setIsfriend($isfriend)
    {
        $this->isfriend = $isfriend;
    
        return $this;
    }

    /**
     * Get isfriend
     *
     * @return boolean 
     */
    public function getIsfriend()
    {
        return $this->isfriend;
    }

    /**
     * Set sendTime
     *
     * @param \DateTime $sendTime
     * @return AccountCommunicate
     */
    public function setSendTime($sendTime)
    {
        $this->sendTime = $sendTime;
    
        return $this;
    }

    /**
     * Get sendTime
     *
     * @return \DateTime 
     */
    public function getSendTime()
    {
        return $this->sendTime;
    }

    /**
     * Set friendTime
     *
     * @param \DateTime $friendTime
     * @return AccountCommunicate
     */
    public function setFriendTime($friendTime)
    {
        $this->friendTime = $friendTime;
    
        return $this;
    }

    /**
     * Get friendTime
     *
     * @return \DateTime 
     */
    public function getFriendTime()
    {
        return $this->friendTime;
    }
    /**
     * @var integer
     */
    private $issend;

    /**
     * @var string
     */
    private $fuserId;


    /**
     * Set issend
     *
     * @param integer $issend
     * @return AccountCommunicate
     */
    public function setIssend($issend)
    {
        $this->issend = $issend;
    
        return $this;
    }

    /**
     * Get issend
     *
     * @return integer 
     */
    public function getIssend()
    {
        return $this->issend;
    }

    /**
     * Set fuserId
     *
     * @param string $fuserId
     * @return AccountCommunicate
     */
    public function setFuserId($fuserId)
    {
        $this->fuserId = $fuserId;
    
        return $this;
    }

    /**
     * Get fuserId
     *
     * @return string 
     */
    public function getFuserId()
    {
        return $this->fuserId;
    }
    /**
     * @var integer
     */
    private $popularType;

    /**
     * @var string
     */
    private $cardId;

    /**
     * @var integer
     */
    private $popularTime;


    /**
     * Set popularType
     *
     * @param integer $popularType
     * @return AccountCommunicate
     */
    public function setPopularType($popularType)
    {
        $this->popularType = $popularType;
    
        return $this;
    }

    /**
     * Get popularType
     *
     * @return integer 
     */
    public function getPopularType()
    {
        return $this->popularType;
    }

    /**
     * Set cardId
     *
     * @param string $cardId
     * @return AccountCommunicate
     */
    public function setCardId($cardId)
    {
        $this->cardId = $cardId;
    
        return $this;
    }

    /**
     * Get cardId
     *
     * @return string 
     */
    public function getCardId()
    {
        return $this->cardId;
    }

    /**
     * Set popularTime
     *
     * @param integer $popularTime
     * @return AccountCommunicate
     */
    public function setPopularTime($popularTime)
    {
        $this->popularTime = $popularTime;
    
        return $this;
    }

    /**
     * Get popularTime
     *
     * @return integer 
     */
    public function getPopularTime()
    {
        return $this->popularTime;
    }
}
