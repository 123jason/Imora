<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SnsActivityResource
 */
class SnsActivityResource
{
    /**
     * @var string
     */
    private $resId;

    /**
     * @var string
     */
    private $resPath;

    /**
     * @var integer
     */
    private $sorting;

    /**
     * @var string
     */
    private $activityId;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set resId
     *
     * @param string $resId
     * @return SnsActivityResource
     */
    public function setResId($resId)
    {
        $this->resId = $resId;
    
        return $this;
    }

    /**
     * Get resId
     *
     * @return string 
     */
    public function getResId()
    {
        return $this->resId;
    }

    /**
     * Set resPath
     *
     * @param string $resPath
     * @return SnsActivityResource
     */
    public function setResPath($resPath)
    {
        $this->resPath = $resPath;
    
        return $this;
    }

    /**
     * Get resPath
     *
     * @return string 
     */
    public function getResPath()
    {
        return $this->resPath;
    }

    /**
     * Set sorting
     *
     * @param integer $sorting
     * @return SnsActivityResource
     */
    public function setSorting($sorting)
    {
        $this->sorting = $sorting;
    
        return $this;
    }

    /**
     * Get sorting
     *
     * @return integer 
     */
    public function getSorting()
    {
        return $this->sorting;
    }

    /**
     * Set activityId
     *
     * @param string $activityId
     * @return SnsActivityResource
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
     * @param \DateTime $createdTime
     * @return SnsActivityResource
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
