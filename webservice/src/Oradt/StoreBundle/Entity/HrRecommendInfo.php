<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HrRecommendInfo
 */
class HrRecommendInfo
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
    private $bizId;

    /**
     * @var string
     */
    private $jobId;

    /**
     * @var string
     */
    private $remark;

    /**
     * @var integer
     */
    private $sorting;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $direction;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set candidateId
     *
     * @param string $candidateId
     * @return HrRecommendInfo
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
     * @return HrRecommendInfo
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
     * Set bizId
     *
     * @param string $bizId
     * @return HrRecommendInfo
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
     * Set jobId
     *
     * @param string $jobId
     * @return HrRecommendInfo
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
     * @return HrRecommendInfo
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
     * Set sorting
     *
     * @param integer $sorting
     * @return HrRecommendInfo
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
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return HrRecommendInfo
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
     * Set direction
     *
     * @param integer $direction
     * @return HrRecommendInfo
     */
    public function setDirection($direction)
    {
        $this->direction = $direction;
    
        return $this;
    }

    /**
     * Get direction
     *
     * @return integer 
     */
    public function getDirection()
    {
        return $this->direction;
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
