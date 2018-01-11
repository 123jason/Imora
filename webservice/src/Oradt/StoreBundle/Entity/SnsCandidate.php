<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SnsCandidate
 */
class SnsCandidate
{
    /**
     * @var string
     */
    private $candidateId;

    /**
     * @var string
     */
    private $candidateProfile;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var integer
     */
    private $languageId;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var integer
     */
    private $modifyTime;

    /**
     * @var integer
     */
    private $createTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set candidateId
     *
     * @param string $candidateId
     * @return SnsCandidate
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
     * Set candidateProfile
     *
     * @param string $candidateProfile
     * @return SnsCandidate
     */
    public function setCandidateProfile($candidateProfile)
    {
        $this->candidateProfile = $candidateProfile;
    
        return $this;
    }

    /**
     * Get candidateProfile
     *
     * @return string 
     */
    public function getCandidateProfile()
    {
        return $this->candidateProfile;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return SnsCandidate
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
     * Set languageId
     *
     * @param integer $languageId
     * @return SnsCandidate
     */
    public function setLanguageId($languageId)
    {
        $this->languageId = $languageId;
    
        return $this;
    }

    /**
     * Get languageId
     *
     * @return integer 
     */
    public function getLanguageId()
    {
        return $this->languageId;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return SnsCandidate
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set modifyTime
     *
     * @param integer $modifyTime
     * @return SnsCandidate
     */
    public function setModifyTime($modifyTime)
    {
        $this->modifyTime = $modifyTime;
    
        return $this;
    }

    /**
     * Get modifyTime
     *
     * @return integer 
     */
    public function getModifyTime()
    {
        return $this->modifyTime;
    }

    /**
     * Set createTime
     *
     * @param integer $createTime
     * @return SnsCandidate
     */
    public function setCreateTime($createTime)
    {
        $this->createTime = $createTime;
    
        return $this;
    }

    /**
     * Get createTime
     *
     * @return integer 
     */
    public function getCreateTime()
    {
        return $this->createTime;
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
