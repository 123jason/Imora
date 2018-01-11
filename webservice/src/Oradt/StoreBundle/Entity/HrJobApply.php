<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HrJobApply
 */
class HrJobApply
{
    /**
     * @var string
     */
    private $applyId;

    /**
     * @var string
     */
    private $jobId;

    /**
     * @var string
     */
    private $recruiterId;

    /**
     * @var string
     */
    private $candidateId;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $remark;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var string
     */
    private $retract;

    /**
     * @var \DateTime
     */
    private $retractTime;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $bizId;

    /**
     * @var string
     */
    private $userId;


    /**
     * Set userId
     *
     * @param string $userId
     * @return HrJobApply
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
     * Set applyId
     *
     * @param string $applyId
     * @return HrJobApply
     */
    public function setApplyId($applyId)
    {
        $this->applyId = $applyId;
    
        return $this;
    }

    /**
     * Get applyId
     *
     * @return string 
     */
    public function getApplyId()
    {
        return $this->applyId;
    }

    /**
     * Set jobId
     *
     * @param string $jobId
     * @return HrJobApply
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
     * Set recruiterId
     *
     * @param string $recruiterId
     * @return HrJobApply
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
     * Set candidateId
     *
     * @param string $candidateId
     * @return HrJobApply
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
     * Set status
     *
     * @param string $status
     * @return HrJobApply
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
     * Set remark
     *
     * @param string $remark
     * @return HrJobApply
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
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return HrJobApply
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
     * Set retract
     *
     * @param string $retract
     * @return HrJobApply
     */
    public function setRetract($retract)
    {
        $this->retract = $retract;
    
        return $this;
    }

    /**
     * Get retract
     *
     * @return string 
     */
    public function getRetract()
    {
        return $this->retract;
    }

    /**
     * Set retractTime
     *
     * @param \DateTime $retractTime
     * @return HrJobApply
     */
    public function setRetractTime($retractTime)
    {
        $this->retractTime = $retractTime;
    
        return $this;
    }

    /**
     * Get retractTime
     *
     * @return \DateTime 
     */
    public function getRetractTime()
    {
        return $this->retractTime;
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
}
