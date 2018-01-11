<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountBizEmployee
 */
class AccountBizEmployee
{
    /**
     * @var string
     */
    private $empId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $superior;

    /**
     * @var string
     */
    private $department;

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
    private $mobiles;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $emails;

    /**
     * @var string
     */
    private $phones;

    /**
     * @var string
     */
    private $faxs;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var string
     */
    private $auhorId;

    /**
     * @var string
     */
    private $payId;

    /**
     * @var string
     */
    private $roleId;

    /**
     * @var string
     */
    private $bizId;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var integer
     */
    private $languageType;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set empId
     *
     * @param string $empId
     * @return AccountBizEmployee
     */
    public function setEmpId($empId)
    {
        $this->empId = $empId;
    
        return $this;
    }

    /**
     * Get empId
     *
     * @return string 
     */
    public function getEmpId()
    {
        return $this->empId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return AccountBizEmployee
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
     * Set superior
     *
     * @param string $superior
     * @return AccountBizEmployee
     */
    public function setSuperior($superior)
    {
        $this->superior = $superior;
    
        return $this;
    }

    /**
     * Get superior
     *
     * @return string 
     */
    public function getSuperior()
    {
        return $this->superior;
    }

    /**
     * Set department
     *
     * @param string $department
     * @return AccountBizEmployee
     */
    public function setDepartment($department)
    {
        $this->department = $department;
    
        return $this;
    }

    /**
     * Get department
     *
     * @return string 
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return AccountBizEmployee
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
     * @return AccountBizEmployee
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
     * Set mobiles
     *
     * @param string $mobiles
     * @return AccountBizEmployee
     */
    public function setMobiles($mobiles)
    {
        $this->mobiles = $mobiles;
    
        return $this;
    }

    /**
     * Get mobiles
     *
     * @return string 
     */
    public function getMobiles()
    {
        return $this->mobiles;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return AccountBizEmployee
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
     * Set emails
     *
     * @param string $emails
     * @return AccountBizEmployee
     */
    public function setEmails($emails)
    {
        $this->emails = $emails;
    
        return $this;
    }

    /**
     * Get emails
     *
     * @return string 
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**
     * Set phones
     *
     * @param string $phones
     * @return AccountBizEmployee
     */
    public function setPhones($phones)
    {
        $this->phones = $phones;
    
        return $this;
    }

    /**
     * Get phones
     *
     * @return string 
     */
    public function getPhones()
    {
        return $this->phones;
    }

    /**
     * Set faxs
     *
     * @param string $faxs
     * @return AccountBizEmployee
     */
    public function setFaxs($faxs)
    {
        $this->faxs = $faxs;
    
        return $this;
    }

    /**
     * Get faxs
     *
     * @return string 
     */
    public function getFaxs()
    {
        return $this->faxs;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return AccountBizEmployee
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
     * Set auhorId
     *
     * @param string $auhorId
     * @return AccountBizEmployee
     */
    public function setAuhorId($auhorId)
    {
        $this->auhorId = $auhorId;
    
        return $this;
    }

    /**
     * Get auhorId
     *
     * @return string 
     */
    public function getAuhorId()
    {
        return $this->auhorId;
    }

    /**
     * Set payId
     *
     * @param string $payId
     * @return AccountBizEmployee
     */
    public function setPayId($payId)
    {
        $this->payId = $payId;
    
        return $this;
    }

    /**
     * Get payId
     *
     * @return string 
     */
    public function getPayId()
    {
        return $this->payId;
    }

    /**
     * Set roleId
     *
     * @param string $roleId
     * @return AccountBizEmployee
     */
    public function setRoleId($roleId)
    {
        $this->roleId = $roleId;
    
        return $this;
    }

    /**
     * Get roleId
     *
     * @return string 
     */
    public function getRoleId()
    {
        return $this->roleId;
    }

    /**
     * Set bizId
     *
     * @param string $bizId
     * @return AccountBizEmployee
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
     * Set userId
     *
     * @param string $userId
     * @return AccountBizEmployee
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
     * Set languageType
     *
     * @param integer $languageType
     * @return AccountBizEmployee
     */
    public function setLanguageType($languageType)
    {
        $this->languageType = $languageType;
    
        return $this;
    }

    /**
     * Get languageType
     *
     * @return integer 
     */
    public function getLanguageType()
    {
        return $this->languageType;
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
     * @var \DateTime
     */
    private $createdTime;


    /**
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return AccountBizEmployee
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
     * @var \DateTime
     */
    private $modifyTime;


    /**
     * Set modifyTime
     *
     * @param \DateTime $modifyTime
     * @return AccountBizEmployee
     */
    public function setModifyTime($modifyTime)
    {
        $this->modifyTime = $modifyTime;
    
        return $this;
    }

    /**
     * Get modifyTime
     *
     * @return \DateTime 
     */
    public function getModifyTime()
    {
        return $this->modifyTime;
    }

    /**
     * @var string
     */
    private $ename;

    /**
     * @var string
     */
    private $esuperior;

    /**
     * @var string
     */
    private $edepartment;

    /**
     * @var string
     */
    private $etitle;

    /**
     * @var float
     */
    private $payfee;

    /**
     * @var integer
     */
    private $auhorTime;


    /**
     * Set ename
     *
     * @param string $ename
     * @return AccountBizEmployee
     */
    public function setEname($ename)
    {
        $this->ename = $ename;
    
        return $this;
    }

    /**
     * Get ename
     *
     * @return string 
     */
    public function getEname()
    {
        return $this->ename;
    }

    /**
     * Set esuperior
     *
     * @param string $esuperior
     * @return AccountBizEmployee
     */
    public function setEsuperior($esuperior)
    {
        $this->esuperior = $esuperior;
    
        return $this;
    }

    /**
     * Get esuperior
     *
     * @return string 
     */
    public function getEsuperior()
    {
        return $this->esuperior;
    }

    /**
     * Set edepartment
     *
     * @param string $edepartment
     * @return AccountBizEmployee
     */
    public function setEdepartment($edepartment)
    {
        $this->edepartment = $edepartment;
    
        return $this;
    }

    /**
     * Get edepartment
     *
     * @return string 
     */
    public function getEdepartment()
    {
        return $this->edepartment;
    }

    /**
     * Set etitle
     *
     * @param string $etitle
     * @return AccountBizEmployee
     */
    public function setEtitle($etitle)
    {
        $this->etitle = $etitle;
    
        return $this;
    }

    /**
     * Get etitle
     *
     * @return string 
     */
    public function getEtitle()
    {
        return $this->etitle;
    }

    /**
     * Set payfee
     *
     * @param float $payfee
     * @return AccountBizEmployee
     */
    public function setPayfee($payfee)
    {
        $this->payfee = $payfee;
    
        return $this;
    }

    /**
     * Get payfee
     *
     * @return float 
     */
    public function getPayfee()
    {
        return $this->payfee;
    }

    /**
     * Set auhorTime
     *
     * @param integer $auhorTime
     * @return AccountBizEmployee
     */
    public function setAuhorTime($auhorTime)
    {
        $this->auhorTime = $auhorTime;
    
        return $this;
    }

    /**
     * Get auhorTime
     *
     * @return integer 
     */
    public function getAuhorTime()
    {
        return $this->auhorTime;
    }

    public $enable;

    /**
     * Set enable
     *
     * @param integer $enable
     * @return AccountBizEmployee
     */
    public function setEnable($enable)
    {
        $this->enable = $enable;
    
        return $this;
    }

    /**
     * Get enable
     *
     * @return integer 
     */
    public function getEnable()
    {
        return $this->enable;
    }
}
