<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DesignBidding
 */
class DesignBidding
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $projectId;

    /**
     * @var string
     */
    private $price;

    /**
     * @var boolean
     */
    private $unitId;

    /**
     * @var integer
     */
    private $deadlineTime;

    /**
     * @var integer
     */
    private $createTime;

    /**
     * @var boolean
     */
    private $status;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return DesignBidding
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
     * Set projectId
     *
     * @param string $projectId
     * @return DesignBidding
     */
    public function setProjectId($projectId)
    {
        $this->projectId = $projectId;
    
        return $this;
    }

    /**
     * Get projectId
     *
     * @return string 
     */
    public function getProjectId()
    {
        return $this->projectId;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return DesignBidding
     */
    public function setPrice($price)
    {
        $this->price = $price;
    
        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set unitId
     *
     * @param boolean $unitId
     * @return DesignBidding
     */
    public function setUnitId($unitId)
    {
        $this->unitId = $unitId;
    
        return $this;
    }

    /**
     * Get unitId
     *
     * @return boolean 
     */
    public function getUnitId()
    {
        return $this->unitId;
    }

    /**
     * Set deadlineTime
     *
     * @param integer $deadlineTime
     * @return DesignBidding
     */
    public function setDeadlineTime($deadlineTime)
    {
        $this->deadlineTime = $deadlineTime;
    
        return $this;
    }

    /**
     * Get deadlineTime
     *
     * @return integer 
     */
    public function getDeadlineTime()
    {
        return $this->deadlineTime;
    }

    /**
     * Set createTime
     *
     * @param integer $createTime
     * @return DesignBidding
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
     * Set status
     *
     * @param boolean $status
     * @return DesignBidding
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
    private $areas;

    /**
     * @var string
     */
    private $explains;


    /**
     * Set areas
     *
     * @param string $areas
     * @return DesignBidding
     */
    public function setAreas($areas)
    {
        $this->areas = $areas;
    
        return $this;
    }

    /**
     * Get areas
     *
     * @return string 
     */
    public function getAreas()
    {
        return $this->areas;
    }

    /**
     * Set explains
     *
     * @param string $explains
     * @return DesignBidding
     */
    public function setExplains($explains)
    {
        $this->explains = $explains;
    
        return $this;
    }

    /**
     * Get explains
     *
     * @return string 
     */
    public function getExplains()
    {
        return $this->explains;
    }
    /**
     * @var string
     */
    private $biddingId;


    /**
     * Set biddingId
     *
     * @param string $biddingId
     * @return DesignBidding
     */
    public function setBiddingId($biddingId)
    {
        $this->biddingId = $biddingId;
    
        return $this;
    }

    /**
     * Get biddingId
     *
     * @return string 
     */
    public function getBiddingId()
    {
        return $this->biddingId;
    }
}
