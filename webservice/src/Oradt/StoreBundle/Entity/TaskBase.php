<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TaskBase
 */
class TaskBase
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $address;

    /**
     * @var integer
     */
    private $startTime;

    /**
     * @var integer
     */
    private $endTime;

    /**
     * @var string
     */
    private $latitude;

    /**
     * @var string
     */
    private $longitude;

    /**
     * @var boolean
     */
    private $isallday;

    /**
     * @var integer
     */
    private $lastModify;

    /**
     * @var integer
     */
    private $createTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return TaskBase
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
     * Set content
     *
     * @param string $content
     * @return TaskBase
     */
    public function setContent($content)
    {
        $this->content = $content;
    
        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return TaskBase
     */
    public function setAddress($address)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set startTime
     *
     * @param integer $startTime
     * @return TaskBase
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
     * @return TaskBase
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
     * Set latitude
     *
     * @param string $latitude
     * @return TaskBase
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    
        return $this;
    }

    /**
     * Get latitude
     *
     * @return string 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     * @return TaskBase
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    
        return $this;
    }

    /**
     * Get longitude
     *
     * @return string 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set isallday
     *
     * @param boolean $isallday
     * @return TaskBase
     */
    public function setIsallday($isallday)
    {
        $this->isallday = $isallday;
    
        return $this;
    }

    /**
     * Get isallday
     *
     * @return boolean 
     */
    public function getIsallday()
    {
        return $this->isallday;
    }

    /**
     * Set lastModify
     *
     * @param integer $lastModify
     * @return TaskBase
     */
    public function setLastModify($lastModify)
    {
        $this->lastModify = $lastModify;
    
        return $this;
    }

    /**
     * Get lastModify
     *
     * @return integer 
     */
    public function getLastModify()
    {
        return $this->lastModify;
    }

    /**
     * Set createTime
     *
     * @param integer $createTime
     * @return TaskBase
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
