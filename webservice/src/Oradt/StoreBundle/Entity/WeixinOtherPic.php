<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WeixinOtherPic
 */
class WeixinOtherPic
{
    /**
     * @var string
     */
    private $picturea;

    /**
     * @var string
     */
    private $pictureb;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $wechatId;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $vcard;

    /**
     * @var boolean
     */
    private $status;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $tag;

    /**
     * Set picturea
     *
     * @param string $picturea
     * @return WeixinOtherPic
     */
    public function setPicturea($picturea)
    {
        $this->picturea = $picturea;
    
        return $this;
    }

    /**
     * Get picturea
     *
     * @return string 
     */
    public function getPicturea()
    {
        return $this->picturea;
    }

    /**
     * Set pictureb
     *
     * @param string $pictureb
     * @return WeixinOtherPic
     */
    public function setPictureb($pictureb)
    {
        $this->pictureb = $pictureb;
    
        return $this;
    }

    /**
     * Get pictureb
     *
     * @return string 
     */
    public function getPictureb()
    {
        return $this->pictureb;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return WeixinOtherPic
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
     * Set wechatId
     *
     * @param string $wechatId
     * @return WeixinOtherPic
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
     * Set type
     *
     * @param string $type
     * @return WeixinOtherPic
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set vcard
     *
     * @param string $vcard
     * @return WeixinOtherPic
     */
    public function setVcard($vcard)
    {
        $this->vcard = $vcard;
    
        return $this;
    }

    /**
     * Get vcard
     *
     * @return string 
     */
    public function getVcard()
    {
        return $this->vcard;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return WeixinOtherPic
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
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $modifyTime;

    /**
     * @var string
     */
    private $pictureThum;

    /**
     * @var boolean
     */
    private $upway;

    /**
     * @var string
     */
    private $batchid;

    /**
     * @var integer
     */
    private $buystatus;

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return WeixinOtherPic
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
     * @return WeixinOtherPic
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
     * Set pictureThum
     *
     * @param string $pictureThum
     * @return WeixinOtherPic
     */
    public function setPictureThum($pictureThum)
    {
        $this->pictureThum = $pictureThum;
    
        return $this;
    }

    /**
     * Get pictureThum
     *
     * @return string 
     */
    public function getPictureThum()
    {
        return $this->pictureThum;
    }

    /**
     * Set upway
     *
     * @param boolean $upway
     * @return WeixinOtherPic
     */
    public function setUpway($upway)
    {
        $this->upway = $upway;
    
        return $this;
    }

    /**
     * Get upway
     *
     * @return boolean 
     */
    public function getUpway()
    {
        return $this->upway;
    }

    /**
     * Set tag
     *
     * @param boolean $tag
     * @return WeixinOtherPic
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
    
        return $this;
    }

    /**
     * Get tag
     *
     * @return boolean 
     */
    public function getTag()
    {
        return $this->tag;
    }

     /**
     * Set batchid
     *
     * @param boolean $batchid
     * @return WeixinOtherPic
     */
    public function setBatchid($batchid)
    {
        $this->batchid = $batchid;
    
        return $this;
    }

    /**
     * Get batchid
     *
     * @return boolean 
     */
    public function getBatchid()
    {
        return $this->batchid;
    }

    /**
     * Set buystatus
     *
     * @param boolean $buystatus
     * @return WeixinOtherPic
     */
    public function setBuystatus($buystatus)
    {
        $this->buystatus = $buystatus;
    
        return $this;
    }

    /**
     * Get buystatus
     *
     * @return boolean 
     */
    public function getBuystatus()
    {
        return $this->buystatus;
    }

    /**
     * @var string
     */
    private $deviceId;

    /**
     * @var string
     */
    private $longitude;

    /**
     * @var string
     */
    private $latitude;


    /**
     * Set deviceId
     *
     * @param string $deviceId
     * @return WeixinCard
     */
    public function setDeviceId($deviceId)
    {
        $this->deviceId = $deviceId;
    
        return $this;
    }

    /**
     * Get deviceId
     *
     * @return string 
     */
    public function getDeviceId()
    {
        return $this->deviceId;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     * @return WeixinCard
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
     * Set latitude
     *
     * @param string $latitude
     * @return WeixinCard
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
}
