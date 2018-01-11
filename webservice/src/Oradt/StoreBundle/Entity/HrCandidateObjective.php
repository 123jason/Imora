<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HrCandidateObjective
 */
class HrCandidateObjective
{
    /**
     * @var string
     */
    private $objectiveId;

    /**
     * @var string
     */
    private $candidateId;

    /**
     * @var string
     */
    private $position;

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $industryCode;

    /**
     * @var string
     */
    private $salary;

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
    private $otherExpect;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set objectiveId
     *
     * @param string $objectiveId
     * @return HrCandidateObjective
     */
    public function setObjectiveId($objectiveId)
    {
        $this->objectiveId = $objectiveId;
    
        return $this;
    }

    /**
     * Get objectiveId
     *
     * @return string 
     */
    public function getObjectiveId()
    {
        return $this->objectiveId;
    }

    /**
     * Set candidateId
     *
     * @param string $candidateId
     * @return HrCandidateObjective
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
     * Set position
     *
     * @param string $position
     * @return HrCandidateObjective
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
     * Set address
     *
     * @param string $address
     * @return HrCandidateObjective
     */
    public function setAddress($address)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set industryCode
     *
     * @param string $industryCode
     * @return HrCandidateObjective
     */
    public function setIndustryCode($industryCode)
    {
        $this->industryCode = $industryCode;
    
        return $this;
    }

    /**
     * Get industryCode
     *
     * @return string 
     */
    public function getIndustryCode()
    {
        return $this->industryCode;
    }

    /**
     * Set salary
     *
     * @param string $salary
     * @return HrCandidateObjective
     */
    public function setSalary($salary)
    {
        $this->salary = $salary;
    
        return $this;
    }

    /**
     * Get salary
     *
     * @return string 
     */
    public function getSalary()
    {
        return $this->salary;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return HrCandidateObjective
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
     * @return HrCandidateObjective
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
     * Set otherExpect
     *
     * @param string $otherExpect
     * @return HrCandidateObjective
     */
    public function setOtherExpect($otherExpect)
    {
        $this->otherExpect = $otherExpect;
    
        return $this;
    }

    /**
     * Get otherExpect
     *
     * @return string 
     */
    public function getOtherExpect()
    {
        return $this->otherExpect;
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
