<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BizOperator
 */
class BizOperator
{
    /**
     * @var string
     */
    private $bizId;

    /**
     * @var string
     */
    private $realName;

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
    private $personalId;

    /**
     * @var string
     */
    private $legalPerson;

    /**
     * @var string
     */
    private $authName;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set bizId
     *
     * @param string $bizId
     * @return BizOperator
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
     * Set realName
     *
     * @param string $realName
     * @return BizOperator
     */
    public function setRealName($realName)
    {
        $this->realName = $realName;
    
        return $this;
    }

    /**
     * Get realName
     *
     * @return string 
     */
    public function getRealName()
    {
        return $this->realName;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return BizOperator
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
     * @return BizOperator
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
     * @return BizOperator
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
     * @return BizOperator
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
     * Set personalId
     *
     * @param string $personalId
     * @return BizOperator
     */
    public function setPersonalId($personalId)
    {
        $this->personalId = $personalId;
    
        return $this;
    }

    /**
     * Get personalId
     *
     * @return string 
     */
    public function getPersonalId()
    {
        return $this->personalId;
    }

    /**
     * Set legalPerson
     *
     * @param string $legalPerson
     * @return BizOperator
     */
    public function setLegalPerson($legalPerson)
    {
        $this->legalPerson = $legalPerson;
    
        return $this;
    }

    /**
     * Get legalPerson
     *
     * @return string 
     */
    public function getLegalPerson()
    {
        return $this->legalPerson;
    }

    /**
     * Set authName
     *
     * @param string $authName
     * @return BizOperator
     */
    public function setAuthName($authName)
    {
        $this->authName = $authName;
    
        return $this;
    }

    /**
     * Get authName
     *
     * @return string 
     */
    public function getAuthName()
    {
        return $this->authName;
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
