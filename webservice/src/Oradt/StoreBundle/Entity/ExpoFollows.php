<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExpoFollows
 */
class ExpoFollows
{
    /**
     * @var string
     */
    private $expoId;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var integer
     */
    private $groupId;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $receive;

    /**
     * @var integer
     */
    private $type;

    /**
     * @var integer
     */
    private $iscome;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set expoId
     *
     * @param string $expoId
     * @return ExpoFollows
     */
    public function setExpoId($expoId)
    {
        $this->expoId = $expoId;
    
        return $this;
    }

    /**
     * Get expoId
     *
     * @return string 
     */
    public function getExpoId()
    {
        return $this->expoId;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return ExpoFollows
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
     * Set groupId
     *
     * @param integer $groupId
     * @return ExpoFollows
     */
    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;
    
        return $this;
    }

    /**
     * Get groupId
     *
     * @return integer 
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return ExpoFollows
     */
    public function setCreatedTime($createdTime)
    {
        $this->createdTime = $createdTime;
    
        return $this;
    }

    /**
     * Get createdTime
     *
     * @return integer 
     */
    public function getCreatedTime()
    {
        return $this->createdTime;
    }

    /**
     * Set receive
     *
     * @param integer $receive
     * @return ExpoFollows
     */
    public function setReceive($receive)
    {
        $this->receive = $receive;
    
        return $this;
    }

    /**
     * Get receive
     *
     * @return integer 
     */
    public function getReceive()
    {
        return $this->receive;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return ExpoFollows
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
     * Set iscome
     *
     * @param integer $iscome
     * @return ExpoFollows
     */
    public function setIscome($iscome)
    {
        $this->iscome = $iscome;
    
        return $this;
    }

    /**
     * Get iscome
     *
     * @return integer 
     */
    public function getIscome()
    {
        return $this->iscome;
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
