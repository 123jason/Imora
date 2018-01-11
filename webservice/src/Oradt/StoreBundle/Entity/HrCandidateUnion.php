<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HrCandidateUnion
 */
class HrCandidateUnion
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
    private $unionId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $position;

    /**
     * @var string
     */
    private $identity;

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
     * @return HrCandidateUnion
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
     * @return HrCandidateUnion
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
     * Set unionId
     *
     * @param string $unionId
     * @return HrCandidateUnion
     */
    public function setUnionId($unionId)
    {
        $this->unionId = $unionId;
    
        return $this;
    }

    /**
     * Get unionId
     *
     * @return string 
     */
    public function getUnionId()
    {
        return $this->unionId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return HrCandidateUnion
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
     * Set position
     *
     * @param string $position
     * @return HrCandidateUnion
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
     * Set identity
     *
     * @param string $identity
     * @return HrCandidateUnion
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
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return HrCandidateUnion
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
     * @return HrCandidateUnion
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
     * Set description
     *
     * @param string $description
     * @return HrCandidateUnion
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
     * @return HrCandidateUnion
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
     * @return HrCandidateUnion
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
     * @return HrCandidateUnion
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
     * @return HrCandidateUnion
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
