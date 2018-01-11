<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountBasicMoveRecord
 */
class AccountBasicMoveRecord
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $latitude;

    /**
     * @var string
     */
    private $longitude;

    /**
     * @var string
     */
    private $country;

    /**
     * @var string
     */
    private $province;

    /**
     * @var string
     */
    private $city;

    /**
     * @var integer
     */
    private $mapstate;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $pushTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return AccountBasicMoveRecord
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
     * Set latitude
     *
     * @param string $latitude
     * @return AccountBasicMoveRecord
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
     * @return AccountBasicMoveRecord
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
     * Set country
     *
     * @param string $country
     * @return AccountBasicMoveRecord
     */
    public function setCountry($country)
    {
        $this->country = $country;
    
        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set province
     *
     * @param string $province
     * @return AccountBasicMoveRecord
     */
    public function setProvince($province)
    {
        $this->province = $province;
    
        return $this;
    }

    /**
     * Get province
     *
     * @return string 
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return AccountBasicMoveRecord
     */
    public function setCity($city)
    {
        $this->city = $city;
    
        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set mapstate
     *
     * @param integer $mapstate
     * @return AccountBasicMoveRecord
     */
    public function setMapstate($mapstate)
    {
        $this->mapstate = $mapstate;
    
        return $this;
    }

    /**
     * Get mapstate
     *
     * @return integer 
     */
    public function getMapstate()
    {
        return $this->mapstate;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return AccountBasicMoveRecord
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return AccountBasicMoveRecord
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
     * Set pushTime
     *
     * @param integer $pushTime
     * @return AccountBasicMoveRecord
     */
    public function setPushTime($pushTime)
    {
        $this->pushTime = $pushTime;
    
        return $this;
    }

    /**
     * Get pushTime
     *
     * @return integer 
     */
    public function getPushTime()
    {
        return $this->pushTime;
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
    private $md5city;


    /**
     * Set md5city
     *
     * @param string $md5city
     * @return AccountBasicMoveRecord
     */
    public function setMd5city($md5city)
    {
        $this->md5city = $md5city;
    
        return $this;
    }

    /**
     * Get md5city
     *
     * @return string 
     */
    public function getMd5city()
    {
        return $this->md5city;
    }
}
