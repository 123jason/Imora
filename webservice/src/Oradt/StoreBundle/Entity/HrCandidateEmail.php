<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HrCandidateEmail
 */
class HrCandidateEmail
{
    /**
     * @var string
     */
    private $bizid;

    /**
     * @var string
     */
    private $emailid;

    /**
     * @var string
     */
    private $email;

    /**
     * @var \DateTime
     */
    private $createTime;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set bizid
     *
     * @param string $bizid
     * @return HrCandidateEmail
     */
    public function setBizid($bizid)
    {
        $this->bizid = $bizid;
    
        return $this;
    }

    /**
     * Get bizid
     *
     * @return string 
     */
    public function getBizid()
    {
        return $this->bizid;
    }

    /**
     * Set emailid
     *
     * @param string $emailid
     * @return HrCandidateEmail
     */
    public function setEmailid($emailid)
    {
        $this->emailid = $emailid;
    
        return $this;
    }

    /**
     * Get emailid
     *
     * @return string 
     */
    public function getEmailid()
    {
        return $this->emailid;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return HrCandidateEmail
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set createTime
     *
     * @param \DateTime $createTime
     * @return HrCandidateEmail
     */
    public function setCreateTime($createTime)
    {
        $this->createTime = $createTime;
    
        return $this;
    }

    /**
     * Get createTime
     *
     * @return \DateTime 
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return HrCandidateEmail
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
