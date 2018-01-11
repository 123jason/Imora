<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OperationActivityUser
 */
class OperationActivityUser
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $activityId;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return OperationActivityUser
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
     * Set activityId
     *
     * @param string $activityId
     * @return OperationActivityUser
     */
    public function setActivityId($activityId)
    {
        $this->activityId = $activityId;
    
        return $this;
    }

    /**
     * Get activityId
     *
     * @return string 
     */
    public function getActivityId()
    {
        return $this->activityId;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return OperationActivityUser
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
