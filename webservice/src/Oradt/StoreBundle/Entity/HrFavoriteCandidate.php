<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HrFavoriteCandidate
 */
class HrFavoriteCandidate
{
    /**
     * @var string
     */
    private $remark;

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
    private $bizId;
    
    /**
     * @var string
     */
    private $groupId;

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
     * @return HrFavoriteCandidate
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
     * Set remark
     *
     * @param string $remark
     * @return HrFavoriteCandidate
     */
    public function setRemark($remark)
    {
        $this->remark = $remark;
    
        return $this;
    }

    /**
     * Get remark
     *
     * @return string 
     */
    public function getRemark()
    {
        return $this->remark;
    }

    /**
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return HrFavoriteCandidate
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
     * @return HrFavoriteCandidate
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
     * Set bizId
     *
     * @param string $bizId
     * @return HrDepartment
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
     * Set groupId
     *
     * @param string $groupId
     * @return 
     */
    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;

        return $this;
    }

    /**
     * Get groupId
     *
     * @return string
     */
    public function getGroupId()
    {
        return $this->groupId;
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
