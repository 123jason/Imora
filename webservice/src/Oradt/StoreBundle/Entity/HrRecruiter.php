<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HrRecruiter
 */
class HrRecruiter
{
    /**
     * @var string
     */
    private $recruiterId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $mobile;

    /**
     * @var string
     */
    private $email;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $depId;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set recruiterId
     *
     * @param string $recruiterId
     * @return HrRecruiter
     */
    public function setRecruiterId($recruiterId)
    {
        $this->recruiterId = $recruiterId;
    
        return $this;
    }

    /**
     * Get recruiterId
     *
     * @return string 
     */
    public function getRecruiterId()
    {
        return $this->recruiterId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return HrRecruiter
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
     * Set title
     *
     * @param string $title
     * @return HrRecruiter
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set mobile
     *
     * @param string $mobile
     * @return HrRecruiter
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    
        return $this;
    }

    /**
     * Get mobile
     *
     * @return string 
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return HrRecruiter
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
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return HrRecruiter
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
     * Set userId
     *
     * @param string $userId
     * @return HrRecruiter
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
     * Set depId
     *
     * @param string $depId
     * @return HrRecruiter
     */
    public function setDepId($depId)
    {
        $this->depId = $depId;
    
        return $this;
    }

    /**
     * Get depId
     *
     * @return string 
     */
    public function getDepId()
    {
        return $this->depId;
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
