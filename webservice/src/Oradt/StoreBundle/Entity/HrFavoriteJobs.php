<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HrFavoriteJobs
 */
class HrFavoriteJobs
{
    /**
     * @var string
     */
    private $jobId;

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
    private $candidateId;
    /**
     * @var string
     */
    private $userId;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set jobId
     *
     * @param string $jobId
     * @return HrFavoriteJobs
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
     * Set remark
     *
     * @param string $remark
     * @return HrFavoriteJobs
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
     * @return HrFavoriteJobs
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
     * Set candidateId
     *
     * @param string $candidateId
     * @return HrFavoriteJobs
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
     * @return HrFavoriteJobs
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
