<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SnsGroupJionRequest
 */
class SnsGroupJionRequest
{
    /**
     * @var string
     */
    private $groupId;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $message;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var string
     */
    private $handleResult;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set groupId
     *
     * @param string $groupId
     * @return SnsGroupJionRequest
     */
    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;
    
        return $this;
    }

    /**
     * Get groupId
     *
     * @return string 
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return SnsGroupJionRequest
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
     * Set message
     *
     * @param string $message
     * @return SnsGroupJionRequest
     */
    public function setMessage($message)
    {
        $this->message = $message;
    
        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return SnsGroupJionRequest
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
     * Set handleResult
     *
     * @param string $handleResult
     * @return SnsGroupJionRequest
     */
    public function setHandleResult($handleResult)
    {
        $this->handleResult = $handleResult;
    
        return $this;
    }

    /**
     * Get handleResult
     *
     * @return string 
     */
    public function getHandleResult()
    {
        return $this->handleResult;
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
