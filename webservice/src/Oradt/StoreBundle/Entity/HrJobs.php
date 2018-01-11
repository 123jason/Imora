<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HrJobs
 */
class HrJobs
{
    /**
     * @var string
     */
    private $jobId;

    /**
     * @var string
     */
    private $bizId;

    /**
     * @var string
     */
    private $recruiterId;

    /**
     * @var string
     */
    private $title;
    
    /**
     * @var string
     */
    private $bizemail;
    
    /**
     * @var string
     */
    private $position;

    /**
     * @var string
     */
    private $jobDuty;

    /**
     * @var string
     */
    private $jobRequirement;
    /**
     * @var string
     */
    private $language;
    /**
     * @var string
     */
    private $treatment;
   
    /**
     * @var string
     */
    private $majorRequirement;
    
    /**
     * @var intger
     */
    private $ageRequirement;
    
    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $categoryId;

    /**
     * @var string
     */
    private $tags;

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $status;

    /**
     * @var \DateTime
     */
    private $expiredDate;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $languageid;

    /**
     * @var \DateTime
     */
    private $flushTime;

    /**
     * @var string
     */
    private $ispause;

    /**
     * @var string
     */
    private $isover;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set jobId
     *
     * @param string $jobId
     * @return HrJobs
     */
    public function setJobId($jobId)
    {
        $this->jobId = $jobId;
    
        return $this;
    }

    /**
     * Get jobId
     *
     * @return string 
     */
    public function getJobId()
    {
        return $this->jobId;
    }

    /**
     * Set bizId
     *
     * @param string $bizId
     * @return HrJobs
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
     * Set recruiterId
     *
     * @param string $recruiterId
     * @return HrJobs
     */
    public function setRecruiterId($recruiterId)
    {
        $this->recruiterId = $recruiterId;
    
        return $this;
    }

    /**
     * Get recruiterId
     *
     * @return string 
     */
    public function getRecruiterId()
    {
        return $this->recruiterId;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return HrJobs
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
     * Set bizemail
     *
     * @param string $bizemail
     * @return HrJobs
     */
    public function setBizemail($bizemail)
    {
        $this->bizemail = $bizemail;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getBizemail()
    {
        return $this->bizemail;
    }
    
    /**
     * Set position
     *
     * @param string $position
     * @return HrJobs
     */
    public function setPosition($position)
    {
        $this->position = $position;
    
        return $this;
    }

    /**
     * Get position
     *
     * @return string 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set jobDuty
     *
     * @param string $jobDuty
     * @return HrJobs
     */
    public function setJobDuty($jobDuty)
    {
        $this->jobDuty = $jobDuty;
    
        return $this;
    }

    /**
     * Get jobDuty
     *
     * @return string 
     */
    public function getJobDuty()
    {
        return $this->jobDuty;
    }

    /**
     * Set jobRequirement
     *
     * @param string $jobRequirement
     * @return HrJobs
     */
    public function setJobRequirement($jobRequirement)
    {
        $this->jobRequirement = $jobRequirement;
    
        return $this;
    }

    /**
     * Get jobRequirement
     *
     * @return string 
     */
    public function getJobRequirement()
    {
        return $this->jobRequirement;
    }

    /**
     * Set ageRequirement
     *
     * @param string $ageRequirement
     * @return HrJobs
     */
    public function setAgeRequirement($ageRequirement)
    {
        $this->ageRequirement = $ageRequirement;
    
        return $this;
    }

    /**
     * Get ageRequirement
     *
     * @return string 
     */
    public function getAgeRequirement()
    {
        return $this->ageRequirement;
    }    
    
    /**
     * Set language
     *
     * @param string $language
     * @return HrJobs
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    
        return $this;
    }

    /**
     * Get jobRequirement
     *
     * @return string 
     */
    public function getLanguage()
    {
        return $this->language;
    }
    
    /**
     * Set treatement
     *
     * @param string $treatement
     * @return HrJobs
     */
    public function setTreatment($treatment)
    {
        $this->treatment = $treatment;
    
        return $this;
    }

    /**
     * Get treatement
     *
     * @return string 
     */
    public function getTreatment()
    {
        return $this->treatment;
    }

    /**
     * Set majorRequirement
     *
     * @param string $majorRequirement
     * @return HrJobs
     */
    public function setMajorRequirement($majorRequirement)
    {
        $this->majorRequirement = $majorRequirement;
    
        return $this;
    }

    /**
     * Get majorRequirement
     *
     * @return string 
     */
    public function getMajorRequirement()
    {
        return $this->majorRequirement;
    }    
    
    /**
     * Set code
     *
     * @param string $code
     * @return HrJobs
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
     * Set categoryId
     *
     * @param string $categoryId
     * @return HrJobs
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
     * Set tags
     *
     * @param string $tags
     * @return HrJobs
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    
        return $this;
    }

    /**
     * Get tags
     *
     * @return string 
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return HrJobs
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
     * Set status
     *
     * @param string $status
     * @return HrJobs
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
     * Set expiredDate
     *
     * @param \DateTime $expiredDate
     * @return HrJobs
     */
    public function setExpiredDate($expiredDate)
    {
        $this->expiredDate = $expiredDate;
    
        return $this;
    }

    /**
     * Get expiredDate
     *
     * @return \DateTime 
     */
    public function getExpiredDate()
    {
        return $this->expiredDate;
    }

    /**
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return HrJobs
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
     * Set languageid
     *
     * @param integer $languageid
     * @return HrJobs
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
     * Set flushTime
     *
     * @param \DateTime $flushTime
     * @return HrJobs
     */
    public function setFlushTime($flushTime)
    {
        $this->flushTime = $flushTime;
    
        return $this;
    }

    /**
     * Get flushTime
     *
     * @return \DateTime 
     */
    public function getFlushTime()
    {
        return $this->flushTime;
    }

    /**
     * Set ispause
     *
     * @param string $ispause
     * @return HrJobs
     */
    public function setIspause($ispause)
    {
        $this->ispause = $ispause;
    
        return $this;
    }

    /**
     * Get ispause
     *
     * @return string 
     */
    public function getIspause()
    {
        return $this->ispause;
    }

    /**
     * Set isover
     *
     * @param string $isover
     * @return HrJobs
     */
    public function setIsover($isover)
    {
        $this->isover = $isover;
    
        return $this;
    }

    /**
     * Get isover
     *
     * @return string 
     */
    public function getIsover()
    {
        return $this->isover;
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
