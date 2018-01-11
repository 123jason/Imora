<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExpoStatistic
 */
class OrangeFuncCard
{
    
    /**
     * @var string
     */
    private $userId;

    /**
     * @var integer
     */
    private $module;

    /**
     * @var string
     */
    private $cardNumber;

    /**
     * @var string
     */
    private $userName;

    /**
     * @var string
     */
    private $passwd;

    /**
     * @var string
     */
    private $cardName;

    /**
     * @var string
     */
    private $logo;

    /**
     * @var integer
     */
    private $tempId;

    /**
     * @var string
     */
    private $picPathA;

    /**
     * @var string
     */
    private $picPathB;

    /**
     * @var string
     */
    private $validDate;

    /**
     * @var string
     */
    private $safeCode;

    /**
     * @var string
     */
    private $barCodePath;

    /**
     * @var integer
     */
    private $certification;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $emailpwd;

    /**
     * @var integer
     */
    private $commonUsed;

    /**
     * @var integer
     */
    private $lastusetime;

    /**
     * @var string
     */
    private $location;

    /**
     * @var integer
     */
    private $cardType;

    /**
     * @var integer
     */
    private $isdefault;

    /**
     * @var integer
     */
    private $sorting;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var float
     */
    private $consumptionAmount;

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
     * @var string
     */
    private $applyAid;

    /**
     * @var integer
     */
    private $cardCreatedMode;

    /**
     * @var integer
     */
    private $validSwipeCard;

    /**
     * @var string
     */
    private $ruleid;

    /**
     * @var integer
     */
    private $commonUseTime;

    /**
     * @var string
     */
    private $localCardid;

    /**
     * @var string
     */
    private $panId;

    /**
     * @var string
     */
    private $pan;

    /**
     * @var string
     */
    private $issuername;

    /**
     * @var string
     */
    private $panStatus;

    /**
     * @var string
     */
    private $deviceId;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return OrangeFuncCard
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
     * Set module
     *
     * @param integer $module
     * @return OrangeFuncCard
     */
    public function setModule($module)
    {
        $this->module = $module;

        return $this;
    }

    /**
     * Get module
     *
     * @return integer 
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * Set cardNumber
     *
     * @param string $cardNumber
     * @return OrangeFuncCard
     */
    public function setCardNumber($cardNumber)
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }

    /**
     * Get cardNumber
     *
     * @return string 
     */
    public function getCardNumber()
    {
        return $this->cardNumber;
    }

    /**
     * Set userName
     *
     * @param string $userName
     * @return OrangeFuncCard
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * Get userName
     *
     * @return string 
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Set passwd
     *
     * @param string $passwd
     * @return OrangeFuncCard
     */
    public function setPasswd($passwd)
    {
        $this->passwd = $passwd;

        return $this;
    }

    /**
     * Get passwd
     *
     * @return string 
     */
    public function getPasswd()
    {
        return $this->passwd;
    }

    /**
     * Set cardName
     *
     * @param string $cardName
     * @return OrangeFuncCard
     */
    public function setCardName($cardName)
    {
        $this->cardName = $cardName;

        return $this;
    }

    /**
     * Get cardName
     *
     * @return string 
     */
    public function getCardName()
    {
        return $this->cardName;
    }

    /**
     * Set logo
     *
     * @param string $logo
     * @return OrangeFuncCard
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string 
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set tempId
     *
     * @param integer $tempId
     * @return OrangeFuncCard
     */
    public function setTempId($tempId)
    {
        $this->tempId = $tempId;

        return $this;
    }

    /**
     * Get tempId
     *
     * @return integer 
     */
    public function getTempId()
    {
        return $this->tempId;
    }

    /**
     * Set picPathA
     *
     * @param string $picPathA
     * @return OrangeFuncCard
     */
    public function setPicPathA($picPathA)
    {
        $this->picPathA = $picPathA;

        return $this;
    }

    /**
     * Get picPathA
     *
     * @return string 
     */
    public function getPicPathA()
    {
        return $this->picPathA;
    }

    /**
     * Set picPathB
     *
     * @param string $picPathB
     * @return OrangeFuncCard
     */
    public function setPicPathB($picPathB)
    {
        $this->picPathB = $picPathB;

        return $this;
    }

    /**
     * Get picPathB
     *
     * @return string 
     */
    public function getPicPathB()
    {
        return $this->picPathB;
    }

    /**
     * Set validDate
     *
     * @param string $validDate
     * @return OrangeFuncCard
     */
    public function setValidDate($validDate)
    {
        $this->validDate = $validDate;

        return $this;
    }

    /**
     * Get validDate
     *
     * @return string 
     */
    public function getValidDate()
    {
        return $this->validDate;
    }

    /**
     * Set safeCode
     *
     * @param string $safeCode
     * @return OrangeFuncCard
     */
    public function setSafeCode($safeCode)
    {
        $this->safeCode = $safeCode;

        return $this;
    }

    /**
     * Get safeCode
     *
     * @return string 
     */
    public function getSafeCode()
    {
        return $this->safeCode;
    }

    /**
     * Set barCodePath
     *
     * @param string $barCodePath
     * @return OrangeFuncCard
     */
    public function setBarCodePath($barCodePath)
    {
        $this->barCodePath = $barCodePath;

        return $this;
    }

    /**
     * Get barCodePath
     *
     * @return string 
     */
    public function getBarCodePath()
    {
        return $this->barCodePath;
    }

    /**
     * Set certification
     *
     * @param integer $certification
     * @return OrangeFuncCard
     */
    public function setCertification($certification)
    {
        $this->certification = $certification;

        return $this;
    }

    /**
     * Get certification
     *
     * @return integer 
     */
    public function getCertification()
    {
        return $this->certification;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return OrangeFuncCard
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set emailpwd
     *
     * @param string $emailpwd
     * @return OrangeFuncCard
     */
    public function setEmailpwd($emailpwd)
    {
        $this->emailpwd = $emailpwd;

        return $this;
    }

    /**
     * Get emailpwd
     *
     * @return string 
     */
    public function getEmailpwd()
    {
        return $this->emailpwd;
    }

    /**
     * Set commonUsed
     *
     * @param integer $commonUsed
     * @return OrangeFuncCard
     */
    public function setCommonUsed($commonUsed)
    {
        $this->commonUsed = $commonUsed;

        return $this;
    }

    /**
     * Get commonUsed
     *
     * @return integer 
     */
    public function getCommonUsed()
    {
        return $this->commonUsed;
    }

    /**
     * Set lastusetime
     *
     * @param integer $lastusetime
     * @return OrangeFuncCard
     */
    public function setLastusetime($lastusetime)
    {
        $this->lastusetime = $lastusetime;

        return $this;
    }

    /**
     * Get lastusetime
     *
     * @return integer 
     */
    public function getLastusetime()
    {
        return $this->lastusetime;
    }

    /**
     * Set location
     *
     * @param string $location
     * @return OrangeFuncCard
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set cardType
     *
     * @param integer $cardType
     * @return OrangeFuncCard
     */
    public function setCardType($cardType)
    {
        $this->cardType = $cardType;

        return $this;
    }

    /**
     * Get cardType
     *
     * @return integer 
     */
    public function getCardType()
    {
        return $this->cardType;
    }

    /**
     * Set isdefault
     *
     * @param integer $isdefault
     * @return OrangeFuncCard
     */
    public function setIsdefault($isdefault)
    {
        $this->isdefault = $isdefault;

        return $this;
    }

    /**
     * Get isdefault
     *
     * @return integer 
     */
    public function getIsdefault()
    {
        return $this->isdefault;
    }

    /**
     * Set sorting
     *
     * @param integer $sorting
     * @return OrangeFuncCard
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
     * Set phone
     *
     * @param string $phone
     * @return OrangeFuncCard
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
 * Set panId
 *
 * @param string $panId
 * @return OrangeFuncCard
 */
    public function setPanId($panId)
    {
        $this->panId = $panId;

        return $this;
    }

    /**
     * Get panId
     *
     * @return string
     */
    public function getPanId()
    {
        return $this->panId;
    }

    /**
     * Set pan
     *
     * @param string $pan
     * @return OrangeFuncCard
     */
    public function setPan($pan)
    {
        $this->pan = $pan;

        return $this;
    }

    /**
     * Get pan
     *
     * @return string
     */
    public function getPan()
    {
        return $this->pan;
    }

    /**
     * Set issuername
     *
     * @param string $issuername
     * @return OrangeFuncCard
     */
    public function setIssuername($issuername)
    {
        $this->issuername = $issuername;

        return $this;
    }

    /**
     * Get issuername
     *
     * @return string
     */
    public function getIssuername()
    {
        return $this->issuername;
    }

    /**
     * Set panStatus
     *
     * @param string $panStatus
     * @return OrangeFuncCard
     */
    public function setPanStatus($panStatus)
    {
        $this->panStatus = $panStatus;

        return $this;
    }

    /**
     * Get panStatus
     *
     * @return string
     */
    public function getPanStatus()
    {
        return $this->panStatus;
    }

    /**
     * Set deviceId
     *
     * @param string $deviceId
     * @return OrangeFuncCard
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
     * Set consumptionAmount
     *
     * @param float $consumptionAmount
     * @return OrangeFuncCard
     */
    public function setConsumptionAmount($consumptionAmount)
    {
        $this->consumptionAmount = $consumptionAmount;

        return $this;
    }

    /**
     * Get consumptionAmount
     *
     * @return float 
     */
    public function getConsumptionAmount()
    {
        return $this->consumptionAmount;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return OrangeFuncCard
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
     * @return OrangeFuncCard
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
     * @return OrangeFuncCard
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
     * Set applyAid
     *
     * @param string $applyAid
     * @return OrangeFuncCard
     */
    public function setApplyAid($applyAid)
    {
        $this->applyAid = $applyAid;

        return $this;
    }

    /**
     * Get applyAid
     *
     * @return string 
     */
    public function getApplyAid()
    {
        return $this->applyAid;
    }

    /**
     * Set cardCreatedMode
     *
     * @param integer $cardCreatedMode
     * @return OrangeFuncCard
     */
    public function setCardCreatedMode($cardCreatedMode)
    {
        $this->cardCreatedMode = $cardCreatedMode;

        return $this;
    }

    /**
     * Get cardCreatedMode
     *
     * @return integer 
     */
    public function getCardCreatedMode()
    {
        return $this->cardCreatedMode;
    }

    /**
     * Set validSwipeCard
     *
     * @param integer $validSwipeCard
     * @return OrangeFuncCard
     */
    public function setValidSwipeCard($validSwipeCard)
    {
        $this->validSwipeCard = $validSwipeCard;

        return $this;
    }

    /**
     * Get validSwipeCard
     *
     * @return integer 
     */
    public function getValidSwipeCard()
    {
        return $this->validSwipeCard;
    }

    /**
     * Set ruleid
     *
     * @param string $ruleid
     * @return OrangeFuncCard
     */
    public function setRuleid($ruleid)
    {
        $this->ruleid = $ruleid;

        return $this;
    }

    /**
     * Get ruleid
     *
     * @return string 
     */
    public function getRuleid()
    {
        return $this->ruleid;
    }

    /**
     * Set commonUseTime
     *
     * @param integer $commonUseTime
     * @return OrangeFuncCard
     */
    public function setCommonUseTime($commonUseTime)
    {
        $this->commonUseTime = $commonUseTime;

        return $this;
    }

    /**
     * Get commonUseTime
     *
     * @return integer 
     */
    public function getCommonUseTime()
    {
        return $this->commonUseTime;
    }

    /**
     * Set localCardid
     *
     * @param string $localCardid
     * @return OrangeFuncCard
     */
    public function setLocalCardid($localCardid)
    {
        $this->localCardid = $localCardid;

        return $this;
    }

    /**
     * Get localCardid
     *
     * @return string 
     */
    public function getLocalCardid()
    {
        return $this->localCardid;
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
    private $tempUpdateHints;


    /**
     * Set tempUpdateHints
     *
     * @param integer $tempUpdateHints
     * @return OrangeFuncCard
     */
    public function setTempUpdateHints($tempUpdateHints)
    {
        $this->tempUpdateHints = $tempUpdateHints;

        return $this;
    }

    /**
     * Get tempUpdateHints
     *
     * @return integer 
     */
    public function getTempUpdateHints()
    {
        return $this->tempUpdateHints;
    }
}
