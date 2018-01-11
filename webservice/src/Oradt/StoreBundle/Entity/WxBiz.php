<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WxBiz
 */
class WxBiz
{
    /**
     * @var string
     */
    private $bizId;

    /**
     * @var string
     */
    private $bizName;

    /**
     * @var string
     */
    private $bizAddress;

    /**
     * @var string
     */
    private $bizEmail;

    /**
     * @var string
     */
    private $bizInfo;

    /**
     * @var string
     */
    private $website;

    /**
     * @var string
     */
    private $logoPath;

    /**
     * @var integer
     */
    private $bizSize;

    /**
     * @var string
     */
    private $bizType;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $contact;

    /**
     * @var string
     */
    private $prespell;

    /**
     * @var string
     */
    private $wechatId;

    /**
     * @var string
     */
    private $wechatPath;

    /**
     * @var boolean
     */
    private $openStatus;

    /**
     * @var string
     */
    private $status;

    /**
     * @var boolean
     */
    private $count;

    /**
     * @var integer
     */
    private $id;

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
    private $qrcodeTime;

    /**
     * @var integer
     */
    private $addId;

    /**
     * Set bizId
     *
     * @param string $bizId
     * @return WxBiz
     */
    public function setBizId($bizId)
    {
        $this->bizId = $bizId;
    
        return $this;
    }

    /**
     * Get bizId
     *
     * @return string 
     */
    public function getBizId()
    {
        return $this->bizId;
    }

    /**
     * Set bizName
     *
     * @param string $bizName
     * @return WxBiz
     */
    public function setBizName($bizName)
    {
        $this->bizName = $bizName;
    
        return $this;
    }

    /**
     * Get bizName
     *
     * @return string 
     */
    public function getBizName()
    {
        return $this->bizName;
    }

    /**
     * Set bizAddress
     *
     * @param string $bizAddress
     * @return WxBiz
     */
    public function setBizAddress($bizAddress)
    {
        $this->bizAddress = $bizAddress;
    
        return $this;
    }

    /**
     * Get bizAddress
     *
     * @return string 
     */
    public function getBizAddress()
    {
        return $this->bizAddress;
    }

    /**
     * Set bizEmail
     *
     * @param string $bizEmail
     * @return WxBiz
     */
    public function setBizEmail($bizEmail)
    {
        $this->bizEmail = $bizEmail;
    
        return $this;
    }

    /**
     * Get bizEmail
     *
     * @return string 
     */
    public function getBizEmail()
    {
        return $this->bizEmail;
    }

    /**
     * Set bizInfo
     *
     * @param string $bizInfo
     * @return WxBiz
     */
    public function setBizInfo($bizInfo)
    {
        $this->bizInfo = $bizInfo;
    
        return $this;
    }

    /**
     * Get bizInfo
     *
     * @return string 
     */
    public function getBizInfo()
    {
        return $this->bizInfo;
    }

    /**
     * Set website
     *
     * @param string $website
     * @return WxBiz
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    
        return $this;
    }

    /**
     * Get website
     *
     * @return string 
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set logoPath
     *
     * @param string $logoPath
     * @return WxBiz
     */
    public function setLogoPath($logoPath)
    {
        $this->logoPath = $logoPath;
    
        return $this;
    }

    /**
     * Get logoPath
     *
     * @return string 
     */
    public function getLogoPath()
    {
        return $this->logoPath;
    }

    /**
     * Set bizSize
     *
     * @param integer $bizSize
     * @return WxBiz
     */
    public function setBizSize($bizSize)
    {
        $this->bizSize = $bizSize;
    
        return $this;
    }

    /**
     * Get bizSize
     *
     * @return integer 
     */
    public function getBizSize()
    {
        return $this->bizSize;
    }

    /**
     * Set bizType
     *
     * @param string $bizType
     * @return WxBiz
     */
    public function setBizType($bizType)
    {
        $this->bizType = $bizType;
    
        return $this;
    }

    /**
     * Get bizType
     *
     * @return string 
     */
    public function getBizType()
    {
        return $this->bizType;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return WxBiz
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    
        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set contact
     *
     * @param string $contact
     * @return WxBiz
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
    
        return $this;
    }

    /**
     * Get contact
     *
     * @return string 
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set prespell
     *
     * @param string $prespell
     * @return WxBiz
     */
    public function setPrespell($prespell)
    {
        $this->prespell = $prespell;
    
        return $this;
    }

    /**
     * Get prespell
     *
     * @return string 
     */
    public function getPrespell()
    {
        return $this->prespell;
    }

    /**
     * Set wechatId
     *
     * @param string $wechatId
     * @return WxBiz
     */
    public function setWechatId($wechatId)
    {
        $this->wechatId = $wechatId;
    
        return $this;
    }

    /**
     * Get wechatId
     *
     * @return string 
     */
    public function getWechatId()
    {
        return $this->wechatId;
    }

    /**
     * Set wechatPath
     *
     * @param string $wechatPath
     * @return WxBiz
     */
    public function setWechatPath($wechatPath)
    {
        $this->wechatPath = $wechatPath;
    
        return $this;
    }

    /**
     * Get wechatPath
     *
     * @return string 
     */
    public function getWechatPath()
    {
        return $this->wechatPath;
    }

    /**
     * Set openStatus
     *
     * @param boolean $openStatus
     * @return WxBiz
     */
    public function setOpenStatus($openStatus)
    {
        $this->openStatus = $openStatus;
    
        return $this;
    }

    /**
     * Get openStatus
     *
     * @return boolean 
     */
    public function getOpenStatus()
    {
        return $this->openStatus;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return WxBiz
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
     * Set count
     *
     * @param boolean $count
     * @return WxBiz
     */
    public function setCount($count)
    {
        $this->count = $count;
    
        return $this;
    }

    /**
     * Get count
     *
     * @return boolean 
     */
    public function getCount()
    {
        return $this->count;
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
     * Set createdTime
     *
     * @param integer $createdTime
     * @return WxBiz
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
     * @return WxBiz
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
     * Set qrcodeTime
     *
     * @param integer $qrcodeTime
     * @return WxBiz
     */
    public function setQrcodeTime($qrcodeTime)
    {
        $this->qrcodeTime = $qrcodeTime;
    
        return $this;
    }

    /**
     * Get qrcodeTime
     *
     * @return integer 
     */
    public function getQrcodeTime()
    {
        return $this->qrcodeTime;
    }

    /**
     * Set addId
     *
     * @param integer $addId
     * @return WxBiz
     */
    public function setAddId($addId)
    {
        $this->addId = $addId;
    
        return $this;
    }

    /**
     * Get addId
     *
     * @return integer 
     */
    public function getAddId()
    {
        return $this->addId;
    }
}
