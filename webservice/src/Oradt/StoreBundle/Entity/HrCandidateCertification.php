<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HrCandidateCertification
 */
class HrCandidateCertification
{
    /**
     * @var string
     */
    private $certificationId;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $certiName;

    /**
     * @var string
     */
    private $certiInsti;

    /**
     * @var string
     */
    private $certiNum;

    /**
     * @var string
     */
    private $certiUrl;

    /**
     * @var string
     */
    private $certiDate;

    /**
     * @var string
     */
    private $validtime;

    /**
     * @var string
     */
    private $status;

    /**
     * @var integer
     */
    private $createTime;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Oradt\StoreBundle\Entity\HrCandidate
     */
    private $candidateId;


    /**
     * Set certificationId
     *
     * @param string $certificationId
     * @return HrCandidateCertification
     */
    public function setCertificationId($certificationId)
    {
        $this->certificationId = $certificationId;
    
        return $this;
    }

    /**
     * Get certificationId
     *
     * @return string 
     */
    public function getCertificationId()
    {
        return $this->certificationId;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return HrCandidateCertification
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
     * Set certiName
     *
     * @param string $certiName
     * @return HrCandidateCertification
     */
    public function setCertiName($certiName)
    {
        $this->certiName = $certiName;
    
        return $this;
    }

    /**
     * Get certiName
     *
     * @return string 
     */
    public function getCertiName()
    {
        return $this->certiName;
    }

    /**
     * Set certiInsti
     *
     * @param string $certiInsti
     * @return HrCandidateCertification
     */
    public function setCertiInsti($certiInsti)
    {
        $this->certiInsti = $certiInsti;
    
        return $this;
    }

    /**
     * Get certiInsti
     *
     * @return string 
     */
    public function getCertiInsti()
    {
        return $this->certiInsti;
    }

    /**
     * Set certiNum
     *
     * @param string $certiNum
     * @return HrCandidateCertification
     */
    public function setCertiNum($certiNum)
    {
        $this->certiNum = $certiNum;
    
        return $this;
    }

    /**
     * Get certiNum
     *
     * @return string 
     */
    public function getCertiNum()
    {
        return $this->certiNum;
    }

    /**
     * Set certiUrl
     *
     * @param string $certiUrl
     * @return HrCandidateCertification
     */
    public function setCertiUrl($certiUrl)
    {
        $this->certiUrl = $certiUrl;
    
        return $this;
    }

    /**
     * Get certiUrl
     *
     * @return string 
     */
    public function getCertiUrl()
    {
        return $this->certiUrl;
    }

    /**
     * Set certiDate
     *
     * @param string $certiDate
     * @return HrCandidateCertification
     */
    public function setCertiDate($certiDate)
    {
        $this->certiDate = $certiDate;
    
        return $this;
    }

    /**
     * Get certiDate
     *
     * @return string 
     */
    public function getCertiDate()
    {
        return $this->certiDate;
    }

    /**
     * Set validtime
     *
     * @param string $validtime
     * @return HrCandidateCertification
     */
    public function setValidtime($validtime)
    {
        $this->validtime = $validtime;
    
        return $this;
    }

    /**
     * Get validtime
     *
     * @return string 
     */
    public function getValidtime()
    {
        return $this->validtime;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return HrCandidateCertification
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
     * Set createTime
     *
     * @param integer $createTime
     * @return HrCandidateCertification
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

    /**
     * Set candidate
     *
     * @param \Oradt\StoreBundle\Entity\HrCandidate $candidate
     * @return HrCandidateCertification
     */
    public function setCandidateId($candidateId)
    {
        $this->candidateId = $candidateId;
    
        return $this;
    }

    /**
     * Get candidate
     *
     * @return \Oradt\StoreBundle\Entity\HrCandidate 
     */
    public function getCandidateId()
    {
        return $this->candidateId;
    }
}
