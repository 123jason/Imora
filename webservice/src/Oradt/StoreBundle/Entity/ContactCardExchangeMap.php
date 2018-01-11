<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContactCardExchangeMap
 */
class ContactCardExchangeMap
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $vcardid;

    /**
     * @var string
     */
    private $latitude;

    /**
     * @var string
     */
    private $longitude;

    /**
     * @var integer
     */
    private $onlinetime;
    
    /**
     * @var integer
     */
    private $ifclose;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return ContactCardExchangeMap
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
     * Set vcardid
     *
     * @param string $vcardid
     * @return ContactCardExchangeMap
     */
    public function setVcardid($vcardid)
    {
        $this->vcardid = $vcardid;

        return $this;
    }

    /**
     * Get vcardid
     *
     * @return string 
     */
    public function getVcardid()
    {
        return $this->vcardid;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     * @return ContactCardExchangeMap
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
     * @return ContactCardExchangeMap
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
     * Set onlinetime
     *
     * @param integer $onlinetime
     * @return ContactCardExchangeMap
     */
    public function setOnlinetime($onlinetime)
    {
        $this->onlinetime = $onlinetime;

        return $this;
    }

    /**
     * Get onlinetime
     *
     * @return integer 
     */
    public function getOnlinetime()
    {
        return $this->onlinetime;
    }
    
    /**
     * Set ifclose
     *
     * @param integer $ifclose
     * @return ContactCardExchangeMap
     */
    public function setIfclose($ifclose)
    {
        $this->ifclose = $ifclose;

        return $this;
    }

    /**
     * Get ifclose
     *
     * @return integer 
     */
    public function getIfclose()
    {
        return $this->ifclose;
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
