<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SnsQaNews
 */
class PopularCard
{
    /**
     * @var string
     */
    private $userId;
    /**
     * @var string
     */
    private $uuid;

    /**
     * @var string
     */
    private $mobile;

    /**
     * @var string
     */
    private $compony;

    /**
     * @var integer
     */
    private $popularMsg;

    /**
     * @var integer
     */
    private $popularTime;
    /**
     * @var integer
     */
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return SnsQaNews
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
     * Set uuid
     *
     * @param string $uuid
     * @return SnsQaNews
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    
        return $this;
    }

    /**
     * Get uuid
     *
     * @return string 
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set mobile
     *
     * @param string $mobile
     * @return SnsQaNews
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
     * Set compony
     *
     * @param string $compony
     * @return SnsQaNews
     */
    public function setCompony($compony)
    {
        $this->compony = $compony;
    
        return $this;
    }

    /**
     * Get compony
     *
     * @return string 
     */
    public function getCompony()
    {
        return $this->compony;
    }

    /**
     * Set popularMsg
     *
     * @param integer $popularMsg
     * @return SnsQaNews
     */
    public function setPopularMsg($popularMsg)
    {
        $this->popularMsg = $popularMsg;
    
        return $this;
    }

    /**
     * Get popularMsg
     *
     * @return integer 
     */
    public function getPopularMsg()
    {
        return $this->popularMsg;
    }

    /**
     * Set popularTime
     *
     * @param integer $popularTime
     * @return SnsQaNews
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
