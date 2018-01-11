<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OperationActivityQaNews
 */
class OperationActivityQaNews
{
    /**
     * @var string
     */
    private $activityId;

    /**
     * @var string
     */
    private $showId;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set activityId
     *
     * @param string $activityId
     * @return OperationActivityQaNews
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
     * Set showId
     *
     * @param string $showId
     * @return OperationActivityQaNews
     */
    public function setShowId($showId)
    {
        $this->showId = $showId;
    
        return $this;
    }

    /**
     * Get showId
     *
     * @return string 
     */
    public function getShowId()
    {
        return $this->showId;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return OperationActivityQaNews
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
