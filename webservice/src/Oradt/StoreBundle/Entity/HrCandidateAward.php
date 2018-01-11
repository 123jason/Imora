<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HrCandidateAward
 */
class HrCandidateAward
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $candidateId;

    /**
     * @var string
     */
    private $awardId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $identity;

    /**
     * @var string
     */
    private $institution;

    /**
     * @var \DateTime
     */
    private $startDate;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \DateTime
     */
    private $updatedTime;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $sorting;

    /**
     * @var string
     */
    private $status;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return HrCandidateAward
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
     * Set candidateId
     *
     * @param string $candidateId
     * @return HrCandidateAward
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
     * Set awardId
     *
     * @param string $awardId
     * @return HrCandidateAward
     */
    public function setAwardId($awardId)
    {
        $this->awardId = $awardId;
    
        return $this;
    }

    /**
     * Get awardId
     *
     * @return string 
     */
    public function getAwardId()
    {
        return $this->awardId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return HrCandidateAward
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
     * Set identity
     *
     * @param string $identity
     * @return HrCandidateAward
     */
    public function setIdentity($identity)
    {
        $this->identity = $identity;
    
        return $this;
    }

    /**
     * Get identity
     *
     * @return string 
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * Set institution
     *
     * @param string $institution
     * @return HrCandidateAward
     */
    public function setInstitution($institution)
    {
        $this->institution = $institution;
    
        return $this;
    }

    /**
     * Get institution
     *
     * @return string 
     */
    public function getInstitution()
    {
        return $this->institution;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return HrCandidateAward
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
     * Set description
     *
     * @param string $description
     * @return HrCandidateAward
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set updatedTime
     *
     * @param \DateTime $updatedTime
     * @return HrCandidateAward
     */
    public function setUpdatedTime($updatedTime)
    {
        $this->updatedTime = $updatedTime;
    
        return $this;
    }

    /**
     * Get updatedTime
     *
     * @return \DateTime 
     */
    public function getUpdatedTime()
    {
        return $this->updatedTime;
    }

    /**
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return HrCandidateAward
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
     * Set sorting
     *
     * @param integer $sorting
     * @return HrCandidateAward
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
     * Set status
     *
     * @param string $status
     * @return HrCandidateAward
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
