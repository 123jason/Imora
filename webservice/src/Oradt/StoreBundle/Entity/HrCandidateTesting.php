<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HrCandidateTesting
 */
class HrCandidateTesting
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
    private $testingId;

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
    private $score;

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
     * @return HrCandidateTesting
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
     * @return HrCandidateTesting
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
     * Set testingId
     *
     * @param string $testingId
     * @return HrCandidateTesting
     */
    public function setTestingId($testingId)
    {
        $this->testingId = $testingId;
    
        return $this;
    }

    /**
     * Get testingId
     *
     * @return string 
     */
    public function getTestingId()
    {
        return $this->testingId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return HrCandidateTesting
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
     * @return HrCandidateTesting
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
     * Set score
     *
     * @param string $score
     * @return HrCandidateTesting
     */
    public function setScore($score)
    {
        $this->score = $score;
    
        return $this;
    }

    /**
     * Get score
     *
     * @return string 
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return HrCandidateTesting
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
     * @return HrCandidateTesting
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
     * @return HrCandidateTesting
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
     * @return HrCandidateTesting
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
     * @return HrCandidateTesting
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
     * @return HrCandidateTesting
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
