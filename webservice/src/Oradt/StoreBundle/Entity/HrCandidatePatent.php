<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HrCandidatePatent
 */
class HrCandidatePatent
{
    /**
     * @var string
     */
    private $patentId;

    /**
     * @var string
     */
    private $candidateId;

    /**
     * @var string
     */
    private $patentName;

    /**
     * @var string
     */
    private $patentCode;

    /**
     * @var string
     */
    private $position;

    /**
     * @var \DateTime
     */
    private $applyDate;

    /**
     * @var \DateTime
     */
    private $awardDate;

    /**
     * @var string
     */
    private $patentUrl;

    /**
     * @var string
     */
    private $remark;

    /**
     * @var \DateTime
     */
    private $createTime;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $status;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set patentId
     *
     * @param string $patentId
     * @return HrCandidatePatent
     */
    public function setPatentId($patentId)
    {
        $this->patentId = $patentId;
    
        return $this;
    }

    /**
     * Get patentId
     *
     * @return string 
     */
    public function getPatentId()
    {
        return $this->patentId;
    }

    /**
     * Set candidateId
     *
     * @param string $candidateId
     * @return HrCandidatePatent
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
     * Set patentName
     *
     * @param string $patentName
     * @return HrCandidatePatent
     */
    public function setPatentName($patentName)
    {
        $this->patentName = $patentName;
    
        return $this;
    }

    /**
     * Get patentName
     *
     * @return string 
     */
    public function getPatentName()
    {
        return $this->patentName;
    }

    /**
     * Set patentCode
     *
     * @param string $patentCode
     * @return HrCandidatePatent
     */
    public function setPatentCode($patentCode)
    {
        $this->patentCode = $patentCode;
    
        return $this;
    }

    /**
     * Get patentCode
     *
     * @return string 
     */
    public function getPatentCode()
    {
        return $this->patentCode;
    }

    /**
     * Set position
     *
     * @param string $position
     * @return HrCandidatePatent
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
     * Set applyDate
     *
     * @param \DateTime $applyDate
     * @return HrCandidatePatent
     */
    public function setApplyDate($applyDate)
    {
        $this->applyDate = $applyDate;
    
        return $this;
    }

    /**
     * Get applyDate
     *
     * @return \DateTime 
     */
    public function getApplyDate()
    {
        return $this->applyDate;
    }

    /**
     * Set awardDate
     *
     * @param \DateTime $awardDate
     * @return HrCandidatePatent
     */
    public function setAwardDate($awardDate)
    {
        $this->awardDate = $awardDate;
    
        return $this;
    }

    /**
     * Get awardDate
     *
     * @return \DateTime 
     */
    public function getAwardDate()
    {
        return $this->awardDate;
    }

    /**
     * Set patentUrl
     *
     * @param string $patentUrl
     * @return HrCandidatePatent
     */
    public function setPatentUrl($patentUrl)
    {
        $this->patentUrl = $patentUrl;
    
        return $this;
    }

    /**
     * Get patentUrl
     *
     * @return string 
     */
    public function getPatentUrl()
    {
        return $this->patentUrl;
    }

    /**
     * Set remark
     *
     * @param string $remark
     * @return HrCandidatePatent
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
     * Set createTime
     *
     * @param \DateTime $createTime
     * @return HrCandidatePatent
     */
    public function setCreateTime($createTime)
    {
        $this->createTime = $createTime;
    
        return $this;
    }

    /**
     * Get createTime
     *
     * @return \DateTime 
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return HrCandidatePatent
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
     * Set status
     *
     * @param string $status
     * @return HrCandidatePatent
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
