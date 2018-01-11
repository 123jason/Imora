<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContactCard
 */
class ContactCard
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
    private $localUuid;
    
    /**
     * @var string
     */
    private $identityName;
    
    /**
     * @var string
     */
    private $avatar;
    
    /**
     * @var tinyint
     */
    private $isfriend;
    
    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $cardFrom;

    /**
     * @var string
     */
    private $cardType;

    /**
     * @var string
     */
    private $useTemp;

    /**
     * @var string
     */
    private $version;

    /**
     * @var integer
     */
    private $shareReference;

    /**
     * @var integer
     */
    private $private;

    /**
     * @var integer
     */
    private $lastModified;

    /**
     * @var integer
     */
    private $sortTime;

    /**
     * @var integer
     */
    private $isimportant;

    /**
     * @var integer
     */
    private $showBtn;
    /**
     * @var string
     */
    private $background;

    /**
     * @var integer
     */
    private $createdTime;


    /**
     * @var integer
     */
    private $clientTimestamp;

    /**
     * @var string
     */
    private $remark;

    /**
     * @var string
     */
    private $public;
    
        /**
     * @var integer
     */
    private $nindex;

    /**
     * @var string
     */
    private $selfMark;

    /**
     * @var string
     */
    private $md5Value;

    /**
     * @var string
     */
    private $contactName;

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
    private $fromUid;

    /**
     * @var string
     */
    private $namePre;

    /**
     * @var string
     */
    private $sourceType;

    /**
     * @var string
     */
    private $self;

    /**
     * @var integer
     */
    private $sorting;

    /**
     * @var string
     */
    private $picture;

    /**
     * @var boolean
     */
    private $ifupdate;
    
    /**
     * @var decimal
     */
    private $xLatitude;
    
    /**
     * @var decimal
     */
    private $xLongitude;
    
    /**
     * @var string
     */
    private $xyz;
    
    /**
     * @var integer
     */
    private $xyztime;

    /**
     * @var boolean
     */
    private $language;
    
    /**
     * @var boolean
     */
    private $exchId;

    /**
     * @var boolean
     */
    private $tempId;

    /**
     * @var boolean
     */
    private $basicStatus;
    
    /**
     * @var string
     */
    private $handleState;
    
    /**
     * @var tinyint
     */
    private $reasonId;
    
    /**
     * @var tinyint
     */
    private $sourceUuid;
    
    /**
     * @var float
     */
    private $payfee;
    
    /**
     * @var string
     */
    private $bizId;

    /**
     * @var string
     */
    private $signature;

    /**
     * @var string
     */
    private $certifcation;
    
    /**
     * @var string
     */
    private $md5ValueFm;
    
    /**
     * @var integer
     */
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return ContactCard
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
     * @return ContactCard
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
     * Set localuuid
     *
     * @param string $localuuid
     * @return ContactCard
     */
    public function setLocalUuid($localuuid)
    {
        $this->localUuid = $localuuid;

        return $this;
    }

    /**
     * Get localuuid
     *
     * @return string 
     */
    public function getLocalUuid()
    {
        return $this->localUuid;
    }

    /**
     * Set identityName
     *
     * @param string $identityName
     * @return ContactCard
     */
    public function setIdentityName($identityName)
    {
        $this->identityName = $identityName;

        return $this;
    }

    /**
     * Get identityName
     *
     * @return string 
     */
    public function getIdentityName()
    {
        return $this->identityName;
    }
    
    /**
     * Set avatar
     *
     * @param string $avatar
     * @return ContactCard
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string 
     */
    public function getAvatar()
    {
        return $this->avatar;
    }
    
    /**
     * Set isfriend
     *
     * @param string $isfriend
     * @return ContactCard
     */
    public function setIsfriend($isfriend)
    {
        $this->isfriend = $isfriend;

        return $this;
    }

    /**
     * Get isfriend
     *
     * @return string 
     */
    public function getIsfriend()
    {
        return $this->isfriend;
    }

    /**
     * Set isimportant
     *
     * @param integer $isimportant
     * @return ContactCard
     */
    public function setIsimportant($isimportant)
    {
        $this->isimportant = $isimportant;

        return $this;
    }

    /**
     * Get isimportant
     *
     * @return integer
     */
    public function getIsimportant()
    {
        return $this->isimportant;
    }

    /**
     * Set showBtn
     *
     * @param integer $showbtn
     * @return ContactCard
     */
    public function setShowBtn($showbtn)
    {
        $this->showBtn = $showbtn;

        return $this;
    }

    /**
     * Get showBtn
     *
     * @return integer
     */
    public function getShowBtn()
    {
        return $this->showBtn;
    }

    /**
     * Set sourceType

     *
     * @param string $sourceType
     * @return ContactCard
     */
    public function setSourceType($sourceType)
    {
        $this->sourceType = $sourceType;

        return $this;
    }

    /**
     * Get sourceType
     *
     * @return string
     */
    public function getSourceType()
    {
        return $this->sourceType;
    }
    
    /**
     * Set status
     *
     * @param string $status
     * @return ContactCard
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
     * Set private
     *
     * @param string $private
     * @return ContactCard
     */
    public function setPrivate($private)
    {
        $this->private = $private;

        return $this;
    }

    /**
     * Get private
     *
     * @return string
     */
    public function getPrivate()
    {
        return $this->private;
    }

    /**
     * Set cardFrom
     *
     * @param string $cardFrom
     * @return ContactCard
     */
    public function setCardFrom($cardFrom)
    {
        $this->cardFrom = $cardFrom;

        return $this;
    }

    /**
     * Get cardFrom
     *
     * @return string 
     */
    public function getCardFrom()
    {
        return $this->cardFrom;
    }

    /**
     * Set cardType
     *
     * @param string $cardType
     * @return ContactCard
     */
    public function setCardType($cardType)
    {
        $this->cardType = $cardType;

        return $this;
    }

    /**
     * Get cardType
     *
     * @return string 
     */
    public function getCardType()
    {
        return $this->cardType;
    }

    /**
     * Set useTemp
     *
     * @param string $useTemp
     * @return ContactCard
     */
    public function setUseTemp($useTemp)
    {
        $this->useTemp = $useTemp;

        return $this;
    }

    /**
     * Get useTemp
     *
     * @return string 
     */
    public function getUseTemp()
    {
        return $this->useTemp;
    }

    /**
     * Set version
     *
     * @param string $version
     * @return ContactCard
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return string 
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set shareReference
     *
     * @param integer $shareReference
     * @return ContactCard
     */
    public function setShareReference($shareReference)
    {
        $this->shareReference = $shareReference;

        return $this;
    }

    /**
     * Get shareReference
     *
     * @return integer 
     */
    public function getShareReference()
    {
        return $this->shareReference;
    }

    /**
     * Set lastModified
     *
     * @param integer $lastModified
     * @return ContactCard
     */
    public function setLastModified($lastModified)
    {
        $this->lastModified = $lastModified;

        return $this;
    }

    /**
     * Get lastModified
     *
     * @return integer
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }


    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return ContactCard
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
     * Set sortTime
     *
     * @param integer $sortTime
     * @return ContactCard
     */
    public function setSortTime($sortTime)
    {
        $this->sortTime = $sortTime;

        return $this;
    }

    /**
     * Get sortTime
     *
     * @return integer
     */
    public function getSortTime()
    {
        return $this->sortTime;
    }


    /**
     * Set clientTimestamp
     *
     * @param integer $clientTimestamp
     * @return ContactCard
     */
    public function setClientTimestamp($clientTimestamp)
    {
        $this->clientTimestamp = $clientTimestamp;

        return $this;
    }

    /**
     * Get clientTimestamp
     *
     * @return integer 
     */
    public function getClientTimestamp()
    {
        return $this->clientTimestamp;
    }

    /**
     * Set remark
     *
     * @param string $remark
     * @return ContactCard
     */
    public function setRemark($remark)
    {
        $this->remark = $remark;

        return $this;
    }

    /**
     * Get remark
     *
     * @return string 
     */
    public function getRemark()
    {
        return $this->remark;
    }

    /**
     * Set public
     *
     * @param string $public
     * @return ContactCard
     */
    public function setPublic($public)
    {
        $this->public = $public;

        return $this;
    }

    /**
     * Get public
     *
     * @return string 
     */
    public function getPublic()
    {
        return $this->public;
    }
    
        /**
     * Set nindex
     *
     * @param integer $nindex
     * @return ContactCard
     */
    public function setNindex($nindex)
    {
        $this->nindex = $nindex;

        return $this;
    }

    /**
     * Get nindex
     *
     * @return integer 
     */
    public function getNindex()
    {
        return $this->nindex;
    }

    /**
     * Set selfMark
     *
     * @param string $selfMark
     * @return ContactCard
     */
    public function setSelfMark($selfMark)
    {
        $this->selfMark = $selfMark;

        return $this;
    }

    /**
     * Get selfMark
     *
     * @return string 
     */
    public function getSelfMark()
    {
        return $this->selfMark;
    }

    /**
     * Set md5Value
     *
     * @param string $md5Value
     * @return ContactCard
     */
    public function setMd5Value($md5Value)
    {
        $this->md5Value = $md5Value;

        return $this;
    }

    /**
     * Get md5Value
     *
     * @return string 
     */
    public function getMd5Value()
    {
        return $this->md5Value;
    }

    /**
     * Set contactName
     *
     * @param string $contactName
     * @return ContactCard
     */
    public function setContactName($contactName)
    {
        $this->contactName = $contactName;

        return $this;
    }

    /**
     * Get contactName
     *
     * @return string 
     */
    public function getContactName()
    {
        return $this->contactName;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     * @return ContactCard
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
     * @return ContactCard
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
     * Set fromUid
     *
     * @param string $fromUid
     * @return ContactCard
     */
    public function setFromUid($fromUid)
    {
        $this->fromUid = $fromUid;

        return $this;
    }

    /**
     * Get fromUid
     *
     * @return string 
     */
    public function getFromUid()
    {
        return $this->fromUid;
    }

    /**
     * Set namePre
     *
     * @param string $namePre
     * @return ContactCard
     */
    public function setNamePre($namePre)
    {
        $this->namePre = $namePre;

        return $this;
    }

    /**
     * Get namePre
     *
     * @return string 
     */
    public function getNamePre()
    {
        return $this->namePre;
    }

    /**
     * Set self
     *
     * @param string $self
     * @return ContactCard
     */
    public function setSelf($self)
    {
        $this->self = $self;

        return $this;
    }

    /**
     * Get self
     *
     * @return string 
     */
    public function getSelf()
    {
        return $this->self;
    }

    /**
     * Set sorting
     *
     * @param integer $sorting
     * @return ContactCard
     */
    public function setSorting($sorting)
    {
        $this->sorting = $sorting;

        return $this;
    }

    /**
     * Get sorting
     *
     * @return integer 
     */
    public function getSorting()
    {
        return $this->sorting;
    }

    /**
     * Set picture
     *
     * @param string $picture
     * @return ContactCard
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return string 
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set ifupdate
     *
     * @param boolean $ifupdate
     * @return ContactCard
     */
    public function setIfupdate($ifupdate)
    {
        $this->ifupdate = $ifupdate;

        return $this;
    }

    /**
     * Get ifupdate
     *
     * @return boolean 
     */
    public function getIfupdate()
    {
        return $this->ifupdate;
    }

    /**
     * Set xLatitude
     *
     * @param decimal $xlatitude
     * @return ContactCard
     */
    public function setXLatitude($xlatitude)
    {
        $this->xLatitude = $xlatitude;

        return $this;
    }

    /**
     * Get xLatitude
     *
     * @return boolean 
     */
    public function getXLatitude()
    {
        return $this->xLatitude;
    }
    
    /**
     * Set xLongitude
     *
     * @param boolean $xLongitude
     * @return ContactCard
     */
    public function setXLongitude($xlongitude)
    {
        $this->xLongitude = $xlongitude;

        return $this;
    }

    /**
     * Get xLongitude
     *
     * @return boolean 
     */
    public function getXLongitude()
    {
        return $this->xLongitude;
    }
    
    /**
     * Set xyz
     *
     * @param boolean $xyz
     * @return ContactCard
     */
    public function setXyz($xyz)
    {
        $this->xyz = $xyz;

        return $this;
    }

    /**
     * Get xyz
     *
     * @return boolean 
     */
    public function getXyz()
    {
        return $this->xyz;
    }
    
    /**
     * Set xyztime
     *
     * @param integer $xyztime
     * @return ContactCard
     */
    public function setXyztime($xyztime)
    {
        $this->xyztime = $xyztime;

        return $this;
    }

    /**
     * Get xyztime
     *
     * @return integer
     */
    public function getXyztime()
    {
        return $this->xyztime;
    }

    
    /**
     * Set language
     *
     * @param boolean $language
     * @return ContactCard
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return boolean 
     */
    public function getLanguage()
    {
        return $this->language;
    }    
    
    
    /**
     * Set exchId
     *
     * @param boolean $exchId
     * @return ContactCard
     */
    public function setExchId($exchId)
    {
        $this->exchId = $exchId;

        return $this;
    }

    /**
     * Get exchId
     *
     * @return boolean 
     */
    public function getExchId()
    {
        return $this->exchId;
    }

    /**
     * Set tempId
     *
     * @param string $tempId
     * @return ContactCard
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
     * Set basicStatus
     *
     * @param string $basicStatus
     * @return ContactCard
     */
    public function setBasicStatus($basicStatus)
    {
        $this->basicStatus = $basicStatus;

        return $this;
    }

    /**
     * Get basicStatus
     *
     * @return string
     */
    public function getBasicStatus()
    {
        return $this->basicStatus;
    }

    /**
     * Set handleState
     *
     * @param string $handleState
     * @return ContactCard
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
     * Set reasonId
     *
     * @param tinyint $reasonId
     * @return ContactCard
     */
    public function setReasonId($reasonId)
    {
        $this->reasonId = $reasonId;

        return $this;
    }

    /**
     * Get reasonId
     *
     * @return tinyint
     */
    public function getReasonId()
    {
        return $this->reasonId;
    }
    
    /**
     * Set sourceUuid
     *
     * @param string $sourceUuid
     * @return ContactCard
     */
    public function setSourceUuid($sourceUuid)
    {
    	$this->sourceUuid = $sourceUuid;
    
    	return $this;
    }
    
    /**
     * Get payfee
     *
     * @return float
     */
    public function getPayfee()
    {
    	return $this->payfee;
    }
    /**
     * Set payfee
     *
     * @param float $payfee
     * @return ContactCard
     */
    public function setPayfee($payfee)
    {
    	$this->payfee = $payfee;
    
    	return $this;
    }
    
    /**
     * Get sourceUuid
     *
     * @return string
     */
    public function getSourceUuid()
    {
    	return $this->sourceUuid;
    }

    /**
     * Set bizId
     *
     * @param float $payfee
     * @return ContactCard
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
     * Set signature
     *
     * @param string $signature
     * @return ContactCard
     */
    public function setSignature($signature)
    {
        $this->signature = $signature;

        return $this;
    }

    /**
     * Get signature
     *
     * @return string
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * Set background
     *
     * @param string $background
     * @return ContactCard
     */
    public function setBackground($background)
    {
        $this->background = $background;

        return $this;
    }

    /**
     * Get background
     *
     * @return string
     */
    public function getBackground()
    {
        return $this->background;
    }

    /**
     * Set certifcation
     *
     * @param integer $certifcation
     * @return ContactCard
     */
    public function setCertifcation($certifcation)
    {
        $this->certifcation = $certifcation;

        return $this;
    }

    /**
     * Get certifcation
     *
     * @return integer
     */
    public function getCertifcation()
    {
        return $this->certifcation;
    }
    
    /**
     * Set md5ValueFm
     *
     * @param string $md5ValueFm
     * @return ContactCard
     */
    public function setMd5ValueFm($md5ValueFm)
    {
        $this->md5ValueFm = $md5ValueFm;

        return $this;
    }

    /**
     * Get md5ValueFm
     *
     * @return string
     */
    public function getMd5ValueFm()
    {
        return $this->md5ValueFm;
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
