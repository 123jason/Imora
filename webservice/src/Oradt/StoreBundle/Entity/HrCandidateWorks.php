<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HrCandidateWorks
 */
class HrCandidateWorks
{
    /**
     * @var string
     */
    private $worksId;

    /**
     * @var string
     */
    private $candidateId;

    /**
     * @var string
     */
    private $worksName;

    /**
     * @var string
     */
    private $position;

    /**
     * @var \DateTime
     */
    private $startDate;

    /**
     * @var \DateTime
     */
    private $endDate;

    /**
     * @var string
     */
    private $worksUrl;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $members;

    /**
     * @var string
     */
    private $remark;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set worksId
     *
     * @param string $worksId
     * @return HrCandidateWorks
     */
    public function setWorksId($worksId)
    {
        $this->worksId = $worksId;
    
        return $this;
    }

    /**
     * Get worksId
     *
     * @return string 
     */
    public function getWorksId()
    {
        return $this->worksId;
    }

    /**
     * Set candidateId
     *
     * @param string $candidateId
     * @return HrCandidateWorks
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
     * Set worksName
     *
     * @param string $worksName
     * @return HrCandidateWorks
     */
    public function setWorksName($worksName)
    {
        $this->worksName = $worksName;
    
        return $this;
    }

    /**
     * Get worksName
     *
     * @return string 
     */
    public function getWorksName()
    {
        return $this->worksName;
    }

    /**
     * Set position
     *
     * @param string $position
     * @return HrCandidateWorks
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
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return HrCandidateWorks
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    
        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime 
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     * @return HrCandidateWorks
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    
        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime 
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set worksUrl
     *
     * @param string $worksUrl
     * @return HrCandidateWorks
     */
    public function setWorksUrl($worksUrl)
    {
        $this->worksUrl = $worksUrl;
    
        return $this;
    }

    /**
     * Get worksUrl
     *
     * @return string 
     */
    public function getWorksUrl()
    {
        return $this->worksUrl;
    }

    /**
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return HrCandidateWorks
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
     * Set userId
     *
     * @param string $userId
     * @return HrCandidateWorks
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
     * Set members
     *
     * @param string $members
     * @return HrCandidateWorks
     */
    public function setMembers($members)
    {
        $this->members = $members;
    
        return $this;
    }

    /**
     * Get members
     *
     * @return string 
     */
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * Set remark
     *
     * @param string $remark
     * @return HrCandidateWorks
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
