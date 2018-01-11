<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExpoInfo
 */
class ExpoInfo
{
    /**
     * @var string
     */
    private $expoId;

    /**
     * @var string
     */
    private $bizId;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $countryId;

    /**
     * @var string
     */
    private $provinceId;

    /**
     * @var string
     */
    private $citycode;

    /**
     * @var string
     */
    private $address;

    /**
     * @var \DateTime
     */
    private $starttime;

    /**
     * @var \DateTime
     */
    private $endtime;

    /**
     * @var integer
     */
    private $plannum;

    /**
     * @var string
     */
    private $majorCorpo;

    /**
     * @var string
     */
    private $provideCorpo;

    /**
     * @var string
     */
    private $messages;

    /**
     * @var string
     */
    private $remarks;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $status;

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
    private $applicationTime;

    /**
     * @var integer
     */
    private $createTime;

    /**
     * @var string
     */
    private $logo;

    /**
     * @var string
     */
    private $prespell;

    /**
     * @var string
     */
    private $avatar;

    /**
     * @var integer
     */
    private $isgrant;

    /**
     * @var string
     */
    private $videopic;

    /**
     * @var string
     */
    private $videoUrl;

    /**
     * @var string
     */
    private $coverPic;

    /**
     * @var integer
     */
    private $hot;

    /**
     * @var integer
     */
    private $recommend;

    /**
     * @var integer
     */
    private $planUsernum;

    /**
     * @var string
     */
    private $categoryId;

    /**
     * @var integer
     */
    private $isExhibitor;

    /**
     * @var integer
     */
    private $exhibitorStatus;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set expoId
     *
     * @param string $expoId
     * @return ExpoInfo
     */
    public function setExpoId($expoId)
    {
        $this->expoId = $expoId;
    
        return $this;
    }

    /**
     * Get expoId
     *
     * @return string 
     */
    public function getExpoId()
    {
        return $this->expoId;
    }

    /**
     * Set bizId
     *
     * @param string $bizId
     * @return ExpoInfo
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
     * Set title
     *
     * @param string $title
     * @return ExpoInfo
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set subject
     *
     * @param string $subject
     * @return ExpoInfo
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    
        return $this;
    }

    /**
     * Get subject
     *
     * @return string 
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set countryId
     *
     * @param string $countryId
     * @return ExpoInfo
     */
    public function setCountryId($countryId)
    {
        $this->countryId = $countryId;
    
        return $this;
    }

    /**
     * Get countryId
     *
     * @return string 
     */
    public function getCountryId()
    {
        return $this->countryId;
    }

    /**
     * Set provinceId
     *
     * @param string $provinceId
     * @return ExpoInfo
     */
    public function setProvinceId($provinceId)
    {
        $this->provinceId = $provinceId;
    
        return $this;
    }

    /**
     * Get provinceId
     *
     * @return string 
     */
    public function getProvinceId()
    {
        return $this->provinceId;
    }

    /**
     * Set citycode
     *
     * @param string $citycode
     * @return ExpoInfo
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
     * Set address
     *
     * @param string $address
     * @return ExpoInfo
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
     * Set starttime
     *
     * @param \DateTime $starttime
     * @return ExpoInfo
     */
    public function setStarttime($starttime)
    {
        $this->starttime = $starttime;
    
        return $this;
    }

    /**
     * Get starttime
     *
     * @return \DateTime 
     */
    public function getStarttime()
    {
        return $this->starttime;
    }

    /**
     * Set endtime
     *
     * @param \DateTime $endtime
     * @return ExpoInfo
     */
    public function setEndtime($endtime)
    {
        $this->endtime = $endtime;
    
        return $this;
    }

    /**
     * Get endtime
     *
     * @return \DateTime 
     */
    public function getEndtime()
    {
        return $this->endtime;
    }

    /**
     * Set plannum
     *
     * @param integer $plannum
     * @return ExpoInfo
     */
    public function setPlannum($plannum)
    {
        $this->plannum = $plannum;
    
        return $this;
    }

    /**
     * Get plannum
     *
     * @return integer 
     */
    public function getPlannum()
    {
        return $this->plannum;
    }

    /**
     * Set majorCorpo
     *
     * @param string $majorCorpo
     * @return ExpoInfo
     */
    public function setMajorCorpo($majorCorpo)
    {
        $this->majorCorpo = $majorCorpo;
    
        return $this;
    }

    /**
     * Get majorCorpo
     *
     * @return string 
     */
    public function getMajorCorpo()
    {
        return $this->majorCorpo;
    }

    /**
     * Set provideCorpo
     *
     * @param string $provideCorpo
     * @return ExpoInfo
     */
    public function setProvideCorpo($provideCorpo)
    {
        $this->provideCorpo = $provideCorpo;
    
        return $this;
    }

    /**
     * Get provideCorpo
     *
     * @return string 
     */
    public function getProvideCorpo()
    {
        return $this->provideCorpo;
    }

    /**
     * Set messages
     *
     * @param string $messages
     * @return ExpoInfo
     */
    public function setMessages($messages)
    {
        $this->messages = $messages;
    
        return $this;
    }

    /**
     * Get messages
     *
     * @return string 
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Set remarks
     *
     * @param string $remarks
     * @return ExpoInfo
     */
    public function setRemarks($remarks)
    {
        $this->remarks = $remarks;
    
        return $this;
    }

    /**
     * Get remarks
     *
     * @return string 
     */
    public function getRemarks()
    {
        return $this->remarks;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return ExpoInfo
     */
    public function setCode($code)
    {
        $this->code = $code;
    
        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return ExpoInfo
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
     * Set latitude
     *
     * @param string $latitude
     * @return ExpoInfo
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
     * @return ExpoInfo
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
     * Set applicationTime
     *
     * @param integer $applicationTime
     * @return ExpoInfo
     */
    public function setApplicationTime($applicationTime)
    {
        $this->applicationTime = $applicationTime;
    
        return $this;
    }

    /**
     * Get applicationTime
     *
     * @return integer 
     */
    public function getApplicationTime()
    {
        return $this->applicationTime;
    }

    /**
     * Set createTime
     *
     * @param integer $createTime
     * @return ExpoInfo
     */
    public function setCreateTime($createTime)
    {
        $this->createTime = $createTime;
    
        return $this;
    }

    /**
     * Get createTime
     *
     * @return integer 
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * Set logo
     *
     * @param string $logo
     * @return ExpoInfo
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
     * Set prespell
     *
     * @param string $prespell
     * @return ExpoInfo
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
     * Set avatar
     *
     * @param string $avatar
     * @return ExpoInfo
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
     * Set isgrant
     *
     * @param integer $isgrant
     * @return ExpoInfo
     */
    public function setIsgrant($isgrant)
    {
        $this->isgrant = $isgrant;
    
        return $this;
    }

    /**
     * Get isgrant
     *
     * @return integer 
     */
    public function getIsgrant()
    {
        return $this->isgrant;
    }

    /**
     * Set videopic
     *
     * @param string $videopic
     * @return ExpoInfo
     */
    public function setVideopic($videopic)
    {
        $this->videopic = $videopic;
    
        return $this;
    }

    /**
     * Get videopic
     *
     * @return string 
     */
    public function getVideopic()
    {
        return $this->videopic;
    }

    /**
     * Set videoUrl
     *
     * @param string $videoUrl
     * @return ExpoInfo
     */
    public function setVideoUrl($videoUrl)
    {
        $this->videoUrl = $videoUrl;
    
        return $this;
    }

    /**
     * Get videoUrl
     *
     * @return string 
     */
    public function getVideoUrl()
    {
        return $this->videoUrl;
    }

    /**
     * Set coverPic
     *
     * @param string $coverPic
     * @return ExpoInfo
     */
    public function setCoverPic($coverPic)
    {
        $this->coverPic = $coverPic;
    
        return $this;
    }

    /**
     * Get coverPic
     *
     * @return string 
     */
    public function getCoverPic()
    {
        return $this->coverPic;
    }

    /**
     * Set hot
     *
     * @param integer $hot
     * @return ExpoInfo
     */
    public function setHot($hot)
    {
        $this->hot = $hot;
    
        return $this;
    }

    /**
     * Get hot
     *
     * @return integer 
     */
    public function getHot()
    {
        return $this->hot;
    }

    /**
     * Set recommend
     *
     * @param integer $recommend
     * @return ExpoInfo
     */
    public function setRecommend($recommend)
    {
        $this->recommend = $recommend;
    
        return $this;
    }

    /**
     * Get recommend
     *
     * @return integer 
     */
    public function getRecommend()
    {
        return $this->recommend;
    }

    /**
     * Set planUsernum
     *
     * @param integer $planUsernum
     * @return ExpoInfo
     */
    public function setPlanUsernum($planUsernum)
    {
        $this->planUsernum = $planUsernum;
    
        return $this;
    }

    /**
     * Get planUsernum
     *
     * @return integer 
     */
    public function getPlanUsernum()
    {
        return $this->planUsernum;
    }

    /**
     * Set categoryId
     *
     * @param string $categoryId
     * @return ExpoInfo
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
    
        return $this;
    }

    /**
     * Get categoryId
     *
     * @return string 
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * Set isExhibitor
     *
     * @param integer $isExhibitor
     * @return ExpoInfo
     */
    public function setIsExhibitor($isExhibitor)
    {
        $this->isExhibitor = $isExhibitor;
    
        return $this;
    }

    /**
     * Get isExhibitor
     *
     * @return integer 
     */
    public function getIsExhibitor()
    {
        return $this->isExhibitor;
    }

    /**
     * Set exhibitorStatus
     *
     * @param integer $exhibitorStatus
     * @return ExpoInfo
     */
    public function setExhibitorStatus($exhibitorStatus)
    {
        $this->exhibitorStatus = $exhibitorStatus;
    
        return $this;
    }

    /**
     * Get exhibitorStatus
     *
     * @return integer 
     */
    public function getExhibitorStatus()
    {
        return $this->exhibitorStatus;
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
