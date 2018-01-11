<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrangeMerchantInfo
 */
class OrangeMerchantInfo
{
    /**
     * @var integer
     */
    private $cardTempId;

    /**
     * @var integer
     */
    private $cardUnitsId;

    /**
     * @var integer
     */
    private $cardTypeId;

    /**
     * @var string
     */
    private $imoraRights;

    /**
     * @var string
     */
    private $serviceGallery;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $introduce;

    /**
     * @var string
     */
    private $phones;

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $openHours;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $modifyTime;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set cardTempId
     *
     * @param integer $cardTempId
     * @return OrangeMerchantInfo
     */
    public function setCardTempId($cardTempId)
    {
        $this->cardTempId = $cardTempId;
    
        return $this;
    }

    /**
     * Get cardTempId
     *
     * @return integer 
     */
    public function getCardTempId()
    {
        return $this->cardTempId;
    }

    /**
     * Set cardUnitsId
     *
     * @param integer $cardUnitsId
     * @return OrangeMerchantInfo
     */
    public function setCardUnitsId($cardUnitsId)
    {
        $this->cardUnitsId = $cardUnitsId;
    
        return $this;
    }

    /**
     * Get cardUnitsId
     *
     * @return integer 
     */
    public function getCardUnitsId()
    {
        return $this->cardUnitsId;
    }

    /**
     * Set cardTypeId
     *
     * @param integer $cardTypeId
     * @return OrangeMerchantInfo
     */
    public function setCardTypeId($cardTypeId)
    {
        $this->cardTypeId = $cardTypeId;
    
        return $this;
    }

    /**
     * Get cardTypeId
     *
     * @return integer 
     */
    public function getCardTypeId()
    {
        return $this->cardTypeId;
    }

    /**
     * Set imoraRights
     *
     * @param string $imoraRights
     * @return OrangeMerchantInfo
     */
    public function setImoraRights($imoraRights)
    {
        $this->imoraRights = $imoraRights;
    
        return $this;
    }

    /**
     * Get imoraRights
     *
     * @return string 
     */
    public function getImoraRights()
    {
        return $this->imoraRights;
    }

    /**
     * Set serviceGallery
     *
     * @param string $serviceGallery
     * @return OrangeMerchantInfo
     */
    public function setServiceGallery($serviceGallery)
    {
        $this->serviceGallery = $serviceGallery;
    
        return $this;
    }

    /**
     * Get serviceGallery
     *
     * @return string 
     */
    public function getServiceGallery()
    {
        return $this->serviceGallery;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return OrangeMerchantInfo
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set introduce
     *
     * @param string $introduce
     * @return OrangeMerchantInfo
     */
    public function setIntroduce($introduce)
    {
        $this->introduce = $introduce;
    
        return $this;
    }

    /**
     * Get introduce
     *
     * @return string 
     */
    public function getIntroduce()
    {
        return $this->introduce;
    }

    /**
     * Set phones
     *
     * @param string $phones
     * @return OrangeMerchantInfo
     */
    public function setPhones($phones)
    {
        $this->phones = $phones;
    
        return $this;
    }

    /**
     * Get phones
     *
     * @return string 
     */
    public function getPhones()
    {
        return $this->phones;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return OrangeMerchantInfo
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
     * Set openHours
     *
     * @param string $openHours
     * @return OrangeMerchantInfo
     */
    public function setOpenHours($openHours)
    {
        $this->openHours = $openHours;
    
        return $this;
    }

    /**
     * Get openHours
     *
     * @return string 
     */
    public function getOpenHours()
    {
        return $this->openHours;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return OrangeMerchantInfo
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
     * Set modifyTime
     *
     * @param integer $modifyTime
     * @return OrangeMerchantInfo
     */
    public function setModifyTime($modifyTime)
    {
        $this->modifyTime = $modifyTime;
    
        return $this;
    }

    /**
     * Get modifyTime
     *
     * @return integer 
     */
    public function getModifyTime()
    {
        return $this->modifyTime;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return OrangeMerchantInfo
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @var boolean
     */
    private $ifHold;


    /**
     * Set ifHold
     *
     * @param boolean $ifHold
     * @return OrangeMerchantInfo
     */
    public function setIfHold($ifHold)
    {
        $this->ifHold = $ifHold;
    
        return $this;
    }

    /**
     * Get ifHold
     *
     * @return boolean 
     */
    public function getIfHold()
    {
        return $this->ifHold;
    }
    /**
     * @var string
     */
    private $url;


    /**
     * Set url
     *
     * @param string $url
     * @return OrangeMerchantInfo
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }
    /**
     * @var integer
     */
    private $ifKey;


    /**
     * Set ifKey
     *
     * @param integer $ifKey
     * @return OrangeMerchantInfo
     */
    public function setIfKey($ifKey)
    {
        $this->ifKey = $ifKey;
    
        return $this;
    }

    /**
     * Get ifKey
     *
     * @return integer 
     */
    public function getIfKey()
    {
        return $this->ifKey;
    }
}
