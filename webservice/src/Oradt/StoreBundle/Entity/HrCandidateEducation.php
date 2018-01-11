<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HrCandidateEducation
 */
class HrCandidateEducation
{
    /**
     * @var string
     */
    private $educationId;

    /**
     * @var string
     */
    private $candidateId;

    /**
     * @var string
     */
    private $school;

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
    private $degree;

    /**
     * @var string
     */
    private $major;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $score;

    /**
     * @var string
     */
    private $activity;

    /**
     * @var string
     */
    private $description;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set educationId
     *
     * @param string $educationId
     * @return HrCandidateEducation
     */
    public function setEducationId($educationId)
    {
        $this->educationId = $educationId;
    
        return $this;
    }

    /**
     * Get educationId
     *
     * @return string 
     */
    public function getEducationId()
    {
        return $this->educationId;
    }

    /**
     * Set candidateId
     *
     * @param string $candidateId
     * @return HrCandidateEducation
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
     * Set school
     *
     * @param string $school
     * @return HrCandidateEducation
     */
    public function setSchool($school)
    {
        $this->school = $school;
    
        return $this;
    }

    /**
     * Get school
     *
     * @return string 
     */
    public function getSchool()
    {
        return $this->school;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return HrCandidateEducation
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
     * @return HrCandidateEducation
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
     * Set degree
     *
     * @param string $degree
     * @return HrCandidateEducation
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
     * Set major
     *
     * @param string $major
     * @return HrCandidateEducation
     */
    public function setMajor($major)
    {
        $this->major = $major;
    
        return $this;
    }

    /**
     * Get major
     *
     * @return string 
     */
    public function getMajor()
    {
        return $this->major;
    }

    /**
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return HrCandidateEducation
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
     * Set status
     *
     * @param string $status
     * @return HrCandidateEducation
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
     * Set userId
     *
     * @param string $userId
     * @return HrCandidateEducation
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
     * Set score
     *
     * @param string $score
     * @return HrCandidateEducation
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
     * Set activity
     *
     * @param string $activity
     * @return HrCandidateEducation
     */
    public function setActivity($activity)
    {
        $this->activity = $activity;
    
        return $this;
    }

    /**
     * Get activity
     *
     * @return string 
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return HrCandidateEducation
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
