<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HrVisitedLog
 */
class HrVisitedLog
{
    /**
     * @var string
     */
    private $bizId;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var string
     */
    private $recruiterId;

    /**
     * @var string
     */
    private $candidateId;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $visitedTimes;

    /**
     * @var string
     */
    private $userId;


    /**
     * Set userId
     *
     * @param string $userId
     * @return HrVisitedLog
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
     * @return HrVisitedLog
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
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return HrVisitedLog
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
     * Set recruiterId
     *
     * @param string $recruiterId
     * @return HrVisitedLog
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
     * @return HrVisitedLog
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
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
}
