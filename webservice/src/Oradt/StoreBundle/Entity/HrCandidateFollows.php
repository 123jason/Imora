<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HrCandidateFollows
 */
class HrCandidateFollows
{
    /**
     * @var \DateTime
     */
    private $createdTime;

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
     * @var integer
     */
    private $id;


    /**
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return HrCandidateFollows
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
     * Set candidateId
     *
     * @param string $candidateId
     * @return HrCandidateFollows
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
     * @return HrFavoriteJobs
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
     * @return HrCandidateFollows
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
