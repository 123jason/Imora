<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HrCandidateSpecial
 */
class HrCandidateSpecial
{
    /**
     * @var string
     */
    private $specialId;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $type;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var string
     */
    private $status;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $candidateId;

    /**
     * @var string
     */
    private $userId;


    /**
     * Set userId
     *
     * @param string $userId
     * @return HrCandidateSpecial
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
     * Set specialId
     *
     * @param string $specialId
     * @return HrCandidateSpecial
     */
    public function setSpecialId($specialId)
    {
        $this->specialId = $specialId;
    
        return $this;
    }

    /**
     * Get specialId
     *
     * @return string 
     */
    public function getSpecialId()
    {
        return $this->specialId;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return HrCandidateSpecial
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
     * Set type
     *
     * @param string $type
     * @return HrCandidateSpecial
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return HrCandidateSpecial
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
     * @return HrCandidateSpecial
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

    /**
     * Set candidateId
     *
     * @param string $candidateId
     * @return HrCandidateSpecial
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
}
