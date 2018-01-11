<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HrCandidateExperience
 */
class HrCandidateExperience
{
    /**
     * @var string
     */
    private $experienceId;

    /**
     * @var string
     */
    private $company;

    /**
     * @var string
     */
    private $position;

    /**
     * @var string
     */
    private $workarea;

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
    private $responsibility;

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
     * @var string
     */
    private $candidateId;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $userId;


    /**
     * Set userId
     *
     * @param string $userId
     * @return HrCandidateExperience
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
     * Set experienceId
     *
     * @param string $experienceId
     * @return HrCandidateExperience
     */
    public function setExperienceId($experienceId)
    {
        $this->experienceId = $experienceId;
    
        return $this;
    }

    /**
     * Get experienceId
     *
     * @return string 
     */
    public function getExperienceId()
    {
        return $this->experienceId;
    }

    /**
     * Set company
     *
     * @param string $company
     * @return HrCandidateExperience
     */
    public function setCompany($company)
    {
        $this->company = $company;
    
        return $this;
    }

    /**
     * Get company
     *
     * @return string 
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set position
     *
     * @param string $position
     * @return HrCandidateExperience
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
     * Set workarea
     *
     * @param string $workarea
     * @return HrCandidateExperience
     */
    public function setWorkarea($workarea)
    {
        $this->workarea = $workarea;
    
        return $this;
    }

    /**
     * Get workarea
     *
     * @return string 
     */
    public function getWorkarea()
    {
        return $this->workarea;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return HrCandidateExperience
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
     * @return HrCandidateExperience
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
     * Set responsibility
     *
     * @param string $responsibility
     * @return HrCandidateExperience
     */
    public function setResponsibility($responsibility)
    {
        $this->responsibility = $responsibility;
    
        return $this;
    }

    /**
     * Get responsibility
     *
     * @return string 
     */
    public function getResponsibility()
    {
        return $this->responsibility;
    }

    /**
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return HrCandidateExperience
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
     * @return HrCandidateExperience
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
     * @return HrCandidateExperience
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
     * Set candidateId
     *
     * @param string $candidateId
     * @return HrCandidateExperience
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
}
