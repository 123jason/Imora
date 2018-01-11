<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountBasicDetail
 */
class AccountBasicDetail
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $realName;

    /**
     * @var string
     */
    private $nickName;

    /**
     * @var string
     */
    private $avatarPath;

    /**
     * @var string
     */
    private $gender;

    /**
     * @var string
     */
    private $birthday;

    /**
     * @var string
     */
    private $countryCode;

    /**
     * @var integer
     */
    private $imid;

    /**
     * @var string
     */
    private $remark;

    /**
     * @var string
     */
    private $latitude;

    /**
     * @var string
     */
    private $misLatitude;

    /**
     * @var string
     */
    private $longitude;

    /**
     * @var string
     */
    private $misLongitude;

    /**
     * @var integer
     */
    private $languageid;

    /**
     * @var string
     */
    private $cardId;

    /**
     * @var string
     */
    private $regFrom;

    /**
     * @var string
     */
    private $md5city;

    /**
     * @var integer
     */
    private $regType;

    /**
     * @var integer
     */
    private $violateCount;

    /**
     * @var integer
     */
    private $popularFlag;

    /**
     * @var integer
     */
    private $lastLoginTime;

    /**
     * @var string
     */
    private $lastLoginIp;

    /**
     * @var integer
     */
    private $loginTime;

    /**
     * @var string
     */
    private $loginIp;

    /**
     * @var string
     */
    private $registerIp;

    /**
     * @var integer
     */
    private $cardCapacity;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $expiryDate;

    /**
     * @var integer
     */
    private $shared;

    /**
     * @var integer
     */
    private $isbinding;

    /**
     * @var string
     */
    private $bindAccount;

    /**
     * @var string
     */
    private $bindName;

    /**
     * @var integer
     */
    private $bindTime;

    /**
     * @var string
     */
    private $cityCode;

    /**
     * @var boolean
     */
    private $ispassed;

    /**
     * @var integer
     */
    private $capacitySwitch;

    /**
     * @var integer
     */
    private $memberLevel;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return AccountBasicDetail
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
     * Set realName
     *
     * @param string $realName
     * @return AccountBasicDetail
     */
    public function setRealName($realName)
    {
        $this->realName = $realName;
    
        return $this;
    }

    /**
     * Get realName
     *
     * @return string 
     */
    public function getRealName()
    {
        return $this->realName;
    }

    /**
     * Set nickName
     *
     * @param string $nickName
     * @return AccountBasicDetail
     */
    public function setNickName($nickName)
    {
        $this->nickName = $nickName;
    
        return $this;
    }

    /**
     * Get nickName
     *
     * @return string 
     */
    public function getNickName()
    {
        return $this->nickName;
    }

    /**
     * Set avatarPath
     *
     * @param string $avatarPath
     * @return AccountBasicDetail
     */
    public function setAvatarPath($avatarPath)
    {
        $this->avatarPath = $avatarPath;
    
        return $this;
    }

    /**
     * Get avatarPath
     *
     * @return string 
     */
    public function getAvatarPath()
    {
        return $this->avatarPath;
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return AccountBasicDetail
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    
        return $this;
    }

    /**
     * Get gender
     *
     * @return string 
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set birthday
     *
     * @param string $birthday
     * @return AccountBasicDetail
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    
        return $this;
    }

    /**
     * Get birthday
     *
     * @return string 
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set countryCode
     *
     * @param string $countryCode
     * @return AccountBasicDetail
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;
    
        return $this;
    }

    /**
     * Get countryCode
     *
     * @return string 
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * Set imid
     *
     * @param integer $imid
     * @return AccountBasicDetail
     */
    public function setImid($imid)
    {
        $this->imid = $imid;
    
        return $this;
    }

    /**
     * Get imid
     *
     * @return integer 
     */
    public function getImid()
    {
        return $this->imid;
    }

    /**
     * Set remark
     *
     * @param string $remark
     * @return AccountBasicDetail
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
     * Set latitude
     *
     * @param string $latitude
     * @return AccountBasicDetail
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
     * Set misLatitude
     *
     * @param string $misLatitude
     * @return AccountBasicDetail
     */
    public function setMisLatitude($misLatitude)
    {
        $this->misLatitude = $misLatitude;
    
        return $this;
    }

    /**
     * Get misLatitude
     *
     * @return string 
     */
    public function getMisLatitude()
    {
        return $this->misLatitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     * @return AccountBasicDetail
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
     * Set misLongitude
     *
     * @param string $misLongitude
     * @return AccountBasicDetail
     */
    public function setMisLongitude($misLongitude)
    {
        $this->misLongitude = $misLongitude;
    
        return $this;
    }

    /**
     * Get misLongitude
     *
     * @return string 
     */
    public function getMisLongitude()
    {
        return $this->misLongitude;
    }

    /**
     * Set languageid
     *
     * @param integer $languageid
     * @return AccountBasicDetail
     */
    public function setLanguageid($languageid)
    {
        $this->languageid = $languageid;
    
        return $this;
    }

    /**
     * Get languageid
     *
     * @return integer 
     */
    public function getLanguageid()
    {
        return $this->languageid;
    }

    /**
     * Set cardId
     *
     * @param string $cardId
     * @return AccountBasicDetail
     */
    public function setCardId($cardId)
    {
        $this->cardId = $cardId;
    
        return $this;
    }

    /**
     * Get cardId
     *
     * @return string 
     */
    public function getCardId()
    {
        return $this->cardId;
    }

    /**
     * Set regFrom
     *
     * @param string $regFrom
     * @return AccountBasicDetail
     */
    public function setRegFrom($regFrom)
    {
        $this->regFrom = $regFrom;
    
        return $this;
    }

    /**
     * Get regFrom
     *
     * @return string 
     */
    public function getRegFrom()
    {
        return $this->regFrom;
    }

    /**
     * Set md5city
     *
     * @param string $md5city
     * @return AccountBasicDetail
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

    /**
     * Set regType
     *
     * @param integer $regType
     * @return AccountBasicDetail
     */
    public function setRegType($regType)
    {
        $this->regType = $regType;
    
        return $this;
    }

    /**
     * Get regType
     *
     * @return integer 
     */
    public function getRegType()
    {
        return $this->regType;
    }

    /**
     * Set violateCount
     *
     * @param integer $violateCount
     * @return AccountBasicDetail
     */
    public function setViolateCount($violateCount)
    {
        $this->violateCount = $violateCount;
    
        return $this;
    }

    /**
     * Get violateCount
     *
     * @return integer 
     */
    public function getViolateCount()
    {
        return $this->violateCount;
    }

    /**
     * Set popularFlag
     *
     * @param integer $popularFlag
     * @return AccountBasicDetail
     */
    public function setPopularFlag($popularFlag)
    {
        $this->popularFlag = $popularFlag;
    
        return $this;
    }

    /**
     * Get popularFlag
     *
     * @return integer 
     */
    public function getPopularFlag()
    {
        return $this->popularFlag;
    }

    /**
     * Set lastLoginTime
     *
     * @param integer $lastLoginTime
     * @return AccountBasicDetail
     */
    public function setLastLoginTime($lastLoginTime)
    {
        $this->lastLoginTime = $lastLoginTime;
    
        return $this;
    }

    /**
     * Get lastLoginTime
     *
     * @return integer 
     */
    public function getLastLoginTime()
    {
        return $this->lastLoginTime;
    }

    /**
     * Set lastLoginIp
     *
     * @param string $lastLoginIp
     * @return AccountBasicDetail
     */
    public function setLastLoginIp($lastLoginIp)
    {
        $this->lastLoginIp = $lastLoginIp;
    
        return $this;
    }

    /**
     * Get lastLoginIp
     *
     * @return string 
     */
    public function getLastLoginIp()
    {
        return $this->lastLoginIp;
    }

    /**
     * Set loginTime
     *
     * @param integer $loginTime
     * @return AccountBasicDetail
     */
    public function setLoginTime($loginTime)
    {
        $this->loginTime = $loginTime;
    
        return $this;
    }

    /**
     * Get loginTime
     *
     * @return integer 
     */
    public function getLoginTime()
    {
        return $this->loginTime;
    }

    /**
     * Set loginIp
     *
     * @param string $loginIp
     * @return AccountBasicDetail
     */
    public function setLoginIp($loginIp)
    {
        $this->loginIp = $loginIp;
    
        return $this;
    }

    /**
     * Get loginIp
     *
     * @return string 
     */
    public function getLoginIp()
    {
        return $this->loginIp;
    }

    /**
     * Set registerIp
     *
     * @param string $registerIp
     * @return AccountBasicDetail
     */
    public function setRegisterIp($registerIp)
    {
        $this->registerIp = $registerIp;
    
        return $this;
    }

    /**
     * Get registerIp
     *
     * @return string 
     */
    public function getRegisterIp()
    {
        return $this->registerIp;
    }

    /**
     * Set cardCapacity
     *
     * @param integer $cardCapacity
     * @return AccountBasicDetail
     */
    public function setCardCapacity($cardCapacity)
    {
        $this->cardCapacity = $cardCapacity;
    
        return $this;
    }

    /**
     * Get cardCapacity
     *
     * @return integer 
     */
    public function getCardCapacity()
    {
        return $this->cardCapacity;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return AccountBasicDetail
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
     * Set expiryDate
     *
     * @param integer $expiryDate
     * @return AccountBasicDetail
     */
    public function setExpiryDate($expiryDate)
    {
        $this->expiryDate = $expiryDate;
    
        return $this;
    }

    /**
     * Get expiryDate
     *
     * @return integer 
     */
    public function getExpiryDate()
    {
        return $this->expiryDate;
    }

    /**
     * Set shared
     *
     * @param integer $shared
     * @return AccountBasicDetail
     */
    public function setShared($shared)
    {
        $this->shared = $shared;
    
        return $this;
    }

    /**
     * Get shared
     *
     * @return integer 
     */
    public function getShared()
    {
        return $this->shared;
    }

    /**
     * Set isbinding
     *
     * @param integer $isbinding
     * @return AccountBasicDetail
     */
    public function setIsbinding($isbinding)
    {
        $this->isbinding = $isbinding;
    
        return $this;
    }

    /**
     * Get isbinding
     *
     * @return integer 
     */
    public function getIsbinding()
    {
        return $this->isbinding;
    }

    /**
     * Set bindAccount
     *
     * @param string $bindAccount
     * @return AccountBasicDetail
     */
    public function setBindAccount($bindAccount)
    {
        $this->bindAccount = $bindAccount;
    
        return $this;
    }

    /**
     * Get bindAccount
     *
     * @return string 
     */
    public function getBindAccount()
    {
        return $this->bindAccount;
    }

    /**
     * Set bindName
     *
     * @param string $bindName
     * @return AccountBasicDetail
     */
    public function setBindName($bindName)
    {
        $this->bindName = $bindName;
    
        return $this;
    }

    /**
     * Get bindName
     *
     * @return string 
     */
    public function getBindName()
    {
        return $this->bindName;
    }

    /**
     * Set bindTime
     *
     * @param integer $bindTime
     * @return AccountBasicDetail
     */
    public function setBindTime($bindTime)
    {
        $this->bindTime = $bindTime;
    
        return $this;
    }

    /**
     * Get bindTime
     *
     * @return integer 
     */
    public function getBindTime()
    {
        return $this->bindTime;
    }

    /**
     * Set cityCode
     *
     * @param string $cityCode
     * @return AccountBasicDetail
     */
    public function setCityCode($cityCode)
    {
        $this->cityCode = $cityCode;
    
        return $this;
    }

    /**
     * Get cityCode
     *
     * @return string 
     */
    public function getCityCode()
    {
        return $this->cityCode;
    }

    /**
     * Set ispassed
     *
     * @param boolean $ispassed
     * @return AccountBasicDetail
     */
    public function setIspassed($ispassed)
    {
        $this->ispassed = $ispassed;
    
        return $this;
    }

    /**
     * Get ispassed
     *
     * @return boolean 
     */
    public function getIspassed()
    {
        return $this->ispassed;
    }

    /**
     * Set capacitySwitch
     *
     * @param integer $capacitySwitch
     * @return AccountBasicDetail
     */
    public function setCapacitySwitch($capacitySwitch)
    {
        $this->capacitySwitch = $capacitySwitch;
    
        return $this;
    }

    /**
     * Get capacitySwitch
     *
     * @return integer 
     */
    public function getCapacitySwitch()
    {
        return $this->capacitySwitch;
    }

    /**
     * Set memberLevel
     *
     * @param integer $memberLevel
     * @return AccountBasicDetail
     */
    public function setMemberLevel($memberLevel)
    {
        $this->memberLevel = $memberLevel;
    
        return $this;
    }

    /**
     * Get memberLevel
     *
     * @return integer 
     */
    public function getMemberLevel()
    {
        return $this->memberLevel;
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
