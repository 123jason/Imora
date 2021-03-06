<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ScanCardPicture
 */
class ScanCardPicture
{
    /**
     * @var string
     */
    private $uuid;

    /**
     * @var string
     */
    private $accountId;

    /**
     * @var string
     */
    private $handleState;

    /**
     * @var string
     */
    private $adminId;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var \DateTime
     */
    private $handledTime;

    /**
     * @var \DateTime
     */
    private $exchangeTime;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $fromAccount;

    /**
     * @var string
     */
    private $tempId;

    /**
     * @var integer
     */
    private $accuracy;

    /**
     * @var string
     */
    private $ifupdate;

    /**
     * @var integer
     */
    private $typeid;

    /**
     * @var integer
     */
    private $source;

    /**
     * @var integer
     */
    private $dpi;

    /**
     * @var string
     */
    private $class;

    /**
     * @var integer
     */
    private $rectify;

    /**
     * @var string
     */
    private $language;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set uuid
     *
     * @param string $uuid
     * @return ScanCardPicture
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
     * Set accountId
     *
     * @param string $accountId
     * @return ScanCardPicture
     */
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;
    
        return $this;
    }

    /**
     * Get accountId
     *
     * @return string 
     */
    public function getAccountId()
    {
        return $this->accountId;
    }

    /**
     * Set handleState
     *
     * @param string $handleState
     * @return ScanCardPicture
     */
    public function setHandleState($handleState)
    {
        $this->handleState = $handleState;
    
        return $this;
    }

    /**
     * Get handleState
     *
     * @return string 
     */
    public function getHandleState()
    {
        return $this->handleState;
    }

    /**
     * Set adminId
     *
     * @param string $adminId
     * @return ScanCardPicture
     */
    public function setAdminId($adminId)
    {
        $this->adminId = $adminId;
    
        return $this;
    }

    /**
     * Get adminId
     *
     * @return string 
     */
    public function getAdminId()
    {
        return $this->adminId;
    }

    /**
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return ScanCardPicture
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
     * Set handledTime
     *
     * @param \DateTime $handledTime
     * @return ScanCardPicture
     */
    public function setHandledTime($handledTime)
    {
        $this->handledTime = $handledTime;
    
        return $this;
    }

    /**
     * Get handledTime
     *
     * @return \DateTime 
     */
    public function getHandledTime()
    {
        return $this->handledTime;
    }

    /**
     * Set exchangeTime
     *
     * @param \DateTime $exchangeTime
     * @return ScanCardPicture
     */
    public function setExchangeTime($exchangeTime)
    {
        $this->exchangeTime = $exchangeTime;
    
        return $this;
    }

    /**
     * Get exchangeTime
     *
     * @return \DateTime 
     */
    public function getExchangeTime()
    {
        return $this->exchangeTime;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return ScanCardPicture
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set fromAccount
     *
     * @param string $fromAccount
     * @return ScanCardPicture
     */
    public function setFromAccount($fromAccount)
    {
        $this->fromAccount = $fromAccount;
    
        return $this;
    }

    /**
     * Get fromAccount
     *
     * @return string 
     */
    public function getFromAccount()
    {
        return $this->fromAccount;
    }

    /**
     * Set tempId
     *
     * @param string $tempId
     * @return ScanCardPicture
     */
    public function setTempId($tempId)
    {
        $this->tempId = $tempId;
    
        return $this;
    }

    /**
     * Get tempId
     *
     * @return string 
     */
    public function getTempId()
    {
        return $this->tempId;
    }

    /**
     * Set accuracy
     *
     * @param integer $accuracy
     * @return ScanCardPicture
     */
    public function setAccuracy($accuracy)
    {
        $this->accuracy = $accuracy;
    
        return $this;
    }

    /**
     * Get accuracy
     *
     * @return integer 
     */
    public function getAccuracy()
    {
        return $this->accuracy;
    }

    /**
     * Set ifupdate
     *
     * @param string $ifupdate
     * @return ScanCardPicture
     */
    public function setIfupdate($ifupdate)
    {
        $this->ifupdate = $ifupdate;
    
        return $this;
    }

    /**
     * Get ifupdate
     *
     * @return string 
     */
    public function getIfupdate()
    {
        return $this->ifupdate;
    }

    /**
     * Set typeid
     *
     * @param integer $typeid
     * @return ScanCardPicture
     */
    public function setTypeid($typeid)
    {
        $this->typeid = $typeid;
    
        return $this;
    }

    /**
     * Get typeid
     *
     * @return integer 
     */
    public function getTypeid()
    {
        return $this->typeid;
    }

    /**
     * Set source
     *
     * @param integer $source
     * @return ScanCardPicture
     */
    public function setSource($source)
    {
        $this->source = $source;
    
        return $this;
    }

    /**
     * Get source
     *
     * @return integer 
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set dpi
     *
     * @param integer $dpi
     * @return ScanCardPicture
     */
    public function setDpi($dpi)
    {
        $this->dpi = $dpi;
    
        return $this;
    }

    /**
     * Get dpi
     *
     * @return integer 
     */
    public function getDpi()
    {
        return $this->dpi;
    }

    /**
     * Set class
     *
     * @param string $class
     * @return ScanCardPicture
     */
    public function setClass($class)
    {
        $this->class = $class;
    
        return $this;
    }

    /**
     * Get class
     *
     * @return string 
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Set rectify
     *
     * @param integer $rectify
     * @return ScanCardPicture
     */
    public function setRectify($rectify)
    {
        $this->rectify = $rectify;
    
        return $this;
    }

    /**
     * Get rectify
     *
     * @return integer 
     */
    public function getRectify()
    {
        return $this->rectify;
    }

    /**
     * Set language
     *
     * @param string $language
     * @return ScanCardPicture
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    
        return $this;
    }

    /**
     * Get language
     *
     * @return string 
     */
    public function getLanguage()
    {
        return $this->language;
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
    private $origin;


    /**
     * Set origin
     *
     * @param string $origin
     * @return ScanCardPicture
     */
    public function setOrigin($origin)
    {
        $this->origin = $origin;

        return $this;
    }

    /**
     * Get origin
     *
     * @return string 
     */
    public function getOrigin()
    {
        return $this->origin;
    }
}
