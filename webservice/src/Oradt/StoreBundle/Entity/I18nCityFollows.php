<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * I18nCityFollows
 */
class I18nCityFollows
{
    /**
     * @var string
     */
    private $uuid;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $citycode;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set uuid
     *
     * @param string $uuid
     * @return I18nCityFollows
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
     * Set userId
     *
     * @param string $userId
     * @return I18nCityFollows
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
     * Set citycode
     *
     * @param string $citycode
     * @return I18nCityFollows
     */
    public function setCitycode($citycode)
    {
        $this->citycode = $citycode;
    
        return $this;
    }

    /**
     * Get citycode
     *
     * @return string 
     */
    public function getCitycode()
    {
        return $this->citycode;
    }

    /**
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return I18nCityFollows
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
