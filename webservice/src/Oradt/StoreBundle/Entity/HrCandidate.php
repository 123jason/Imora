<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HrCandidate
 */
class HrCandidate
{
    /**
     * @var string
     */
    private $candidateId;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $gender;

    /**
     * @var \DateTime
     */
    private $birthday;

    /**
     * @var string
     */
    private $marriage;

    /**
     * @var \DateTime
     */
    private $workdate;

    /**
     * @var string
     */
    private $overseaExp;

    /**
     * @var string
     */
    private $birthplace;

    /**
     * @var string
     */
    private $residence;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $mobile;

    /**
     * @var string
     */
    private $tel;

    /**
     * @var string
     */
    private $party;

    /**
     * @var string
     */
    private $degree;

    /**
     * @var string
     */
    private $avatarPath;

    /**
     * @var string
     */
    private $website;

    /**
     * @var string
     */
    private $status;

    /**
     * @var integer
     */
    private $visitedTimes;

    /**
     * @var integer
     */
    private $languageid;

    /**
     * @var integer
     */
    private $age;

    /**
     * @var integer
     */
    private $workExp;

    /**
     * @var string
     */
    private $lastCompany;

    /**
     * @var string
     */
    private $allCompany;

    /**
     * @var string
     */
    private $industryCode;

    /**
     * @var string
     */
    private $imName;

    /**
     * @var string
     */
    private $workstate;

    /**
     * @var integer
     */
    private $modifyTime;

    /**
     * @var integer
     */
    private $createTime;

    /**
     * @var string
     */
    private $candidateNo;

    /**
     * @var string
     */
    private $profile;
    
    /**
     * @var integer
     */
    private $isBold;
    
    /**
     * @var integer
     */
    private $fontSize;
    
    /**
     * @var integer
     */
    private $id;


    /**
     * Set candidateId
     *
     * @param string $candidateId
     * @return HrCandidate
     */
    public function setCandidateId($candidateId)
    {
        $this->candidateId = $candidateId;
    
        return $this;
    }

    /**
     * Get candidateId
     *
     * @return string 
     */
    public function getCandidateId()
    {
        return $this->candidateId;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return HrCandidate
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
     * Set name
     *
     * @param string $name
     * @return HrCandidate
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
     * Set gender
     *
     * @param string $gender
     * @return HrCandidate
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
     * @param \DateTime $birthday
     * @return HrCandidate
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    
        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime 
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set marriage
     *
     * @param string $marriage
     * @return HrCandidate
     */
    public function setMarriage($marriage)
    {
        $this->marriage = $marriage;
    
        return $this;
    }

    /**
     * Get marriage
     *
     * @return string 
     */
    public function getMarriage()
    {
        return $this->marriage;
    }

    /**
     * Set workdate
     *
     * @param \DateTime $workdate
     * @return HrCandidate
     */
    public function setWorkdate($workdate)
    {
        $this->workdate = $workdate;
    
        return $this;
    }

    /**
     * Get workdate
     *
     * @return \DateTime 
     */
    public function getWorkdate()
    {
        return $this->workdate;
    }

    /**
     * Set overseaExp
     *
     * @param string $overseaExp
     * @return HrCandidate
     */
    public function setOverseaExp($overseaExp)
    {
        $this->overseaExp = $overseaExp;
    
        return $this;
    }

    /**
     * Get overseaExp
     *
     * @return string 
     */
    public function getOverseaExp()
    {
        return $this->overseaExp;
    }

    /**
     * Set birthplace
     *
     * @param string $birthplace
     * @return HrCandidate
     */
    public function setBirthplace($birthplace)
    {
        $this->birthplace = $birthplace;
    
        return $this;
    }

    /**
     * Get birthplace
     *
     * @return string 
     */
    public function getBirthplace()
    {
        return $this->birthplace;
    }

    /**
     * Set residence
     *
     * @param string $residence
     * @return HrCandidate
     */
    public function setResidence($residence)
    {
        $this->residence = $residence;
    
        return $this;
    }

    /**
     * Get residence
     *
     * @return string 
     */
    public function getResidence()
    {
        return $this->residence;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return HrCandidate
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
     * Set mobile
     *
     * @param string $mobile
     * @return HrCandidate
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    
        return $this;
    }

    /**
     * Get mobile
     *
     * @return string 
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set tel
     *
     * @param string $tel
     * @return HrCandidate
     */
    public function setTel($tel)
    {
        $this->tel = $tel;
    
        return $this;
    }

    /**
     * Get tel
     *
     * @return string 
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set party
     *
     * @param string $party
     * @return HrCandidate
     */
    public function setParty($party)
    {
        $this->party = $party;
    
        return $this;
    }

    /**
     * Get party
     *
     * @return string 
     */
    public function getParty()
    {
        return $this->party;
    }

    /**
     * Set degree
     *
     * @param string $degree
     * @return HrCandidate
     */
    public function setDegree($degree)
    {
        $this->degree = $degree;
    
        return $this;
    }

    /**
     * Get degree
     *
     * @return string 
     */
    public function getDegree()
    {
        return $this->degree;
    }

    /**
     * Set avatarPath
     *
     * @param string $avatarPath
     * @return HrCandidate
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
     * Set website
     *
     * @param string $website
     * @return HrCandidate
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
     * Set status
     *
     * @param string $status
     * @return HrCandidate
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
     * Set visitedTimes
     *
     * @param integer $visitedTimes
     * @return HrCandidate
     */
    public function setVisitedTimes($visitedTimes)
    {
        $this->visitedTimes = $visitedTimes;
    
        return $this;
    }

    /**
     * Get visitedTimes
     *
     * @return integer 
     */
    public function getVisitedTimes()
    {
        return $this->visitedTimes;
    }

    /**
     * Set languageid
     *
     * @param integer $languageid
     * @return HrCandidate
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
     * Set age
     *
     * @param integer $age
     * @return HrCandidate
     */
    public function setAge($age)
    {
        $this->age = $age;
    
        return $this;
    }

    /**
     * Get age
     *
     * @return integer 
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set workExp
     *
     * @param integer $workExp
     * @return HrCandidate
     */
    public function setWorkExp($workExp)
    {
        $this->workExp = $workExp;
    
        return $this;
    }

    /**
     * Get workExp
     *
     * @return integer 
     */
    public function getWorkExp()
    {
        return $this->workExp;
    }

    /**
     * Set lastCompany
     *
     * @param string $lastCompany
     * @return HrCandidate
     */
    public function setLastCompany($lastCompany)
    {
        $this->lastCompany = $lastCompany;
    
        return $this;
    }

    /**
     * Get lastCompany
     *
     * @return string 
     */
    public function getLastCompany()
    {
        return $this->lastCompany;
    }

    /**
     * Set allCompany
     *
     * @param string $allCompany
     * @return HrCandidate
     */
    public function setAllCompany($allCompany)
    {
        $this->allCompany = $allCompany;
    
        return $this;
    }

    /**
     * Get allCompany
     *
     * @return string 
     */
    public function getAllCompany()
    {
        return $this->allCompany;
    }

    /**
     * Set industryCode
     *
     * @param string $industryCode
     * @return HrCandidate
     */
    public function setIndustryCode($industryCode)
    {
        $this->industryCode = $industryCode;
    
        return $this;
    }

    /**
     * Get industryCode
     *
     * @return string 
     */
    public function getIndustryCode()
    {
        return $this->industryCode;
    }

    /**
     * Set imName
     *
     * @param string $imName
     * @return HrCandidate
     */
    public function setImName($imName)
    {
        $this->imName = $imName;
    
        return $this;
    }

    /**
     * Get imName
     *
     * @return string 
     */
    public function getImName()
    {
        return $this->imName;
    }

    /**
     * Set workstate
     *
     * @param string $workstate
     * @return HrCandidate
     */
    public function setWorkstate($workstate)
    {
        $this->workstate = $workstate;
    
        return $this;
    }

    /**
     * Get workstate
     *
     * @return string 
     */
    public function getWorkstate()
    {
        return $this->workstate;
    }

    /**
     * Set modifyTime
     *
     * @param integer $modifyTime
     * @return HrCandidate
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
     * Set createTime
     *
     * @param integer $createTime
     * @return HrCandidate
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
     * Set candidateNo
     *
     * @param string $candidateNo
     * @return HrCandidate
     */
    public function setCandidateNo($candidateNo)
    {
        $this->candidateNo = $candidateNo;
    
        return $this;
    }

    /**
     * Get candidateNo
     *
     * @return string 
     */
    public function getCandidateNo()
    {
        return $this->candidateNo;
    }

    /**
     * Set profile
     *
     * @param string $profile
     * @return HrCandidate
     */
    public function setProfile($profile)
    {
        $this->profile = $profile;
    
        return $this;
    }

    /**
     * Get profile
     *
     * @return string
     */
    public function getProfile()
    {
        return $this->profile;
    }
    
    /**
     * Set isBold
     *
     * @param integer $isBold
     * @return HrCandidate
     */
    public function setIsBold($isBold)
    {
        $this->isBold = $isBold;
    
        return $this;
    }

    /**
     * Get isBold
     *
     * @return integer
     */
    public function getIsBold()
    {
        return $this->isBold;
    }
    
    /**
     * Set fontSize
     *
     * @param integer $fontSize
     * @return HrCandidate
     */
    public function setFontSize($fontSize)
    {
        $this->fontSize = $fontSize;
    
        return $this;
    }

    /**
     * Get fontSize
     *
     * @return integer
     */
    public function getFontSize()
    {
        return $this->fontSize;
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
