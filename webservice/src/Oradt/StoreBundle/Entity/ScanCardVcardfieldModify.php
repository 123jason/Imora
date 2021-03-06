<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ScanCardVcardfieldModify
 */
class ScanCardVcardfieldModify
{
    /**
     * @var string
     */
    private $vcardid;

    /**
     * @var string
     */
    private $fromvcard;

    /**
     * @var string
     */
    private $tovcard;

    /**
     * @var string
     */
    private $checkAccount;

    /**
     * @var string
     */
    private $fullcheckAccount;

    /**
     * @var integer
     */
    private $name;

    /**
     * @var integer
     */
    private $mobile;

    /**
     * @var integer
     */
    private $company;

    /**
     * @var integer
     */
    private $department;

    /**
     * @var integer
     */
    private $job;

    /**
     * @var integer
     */
    private $address;

    /**
     * @var integer
     */
    private $telphone;

    /**
     * @var integer
     */
    private $fax;

    /**
     * @var integer
     */
    private $email;

    /**
     * @var integer
     */
    private $web;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set vcardid
     *
     * @param string $vcardid
     * @return ScanCardVcardfieldModify
     */
    public function setVcardid($vcardid)
    {
        $this->vcardid = $vcardid;
    
        return $this;
    }

    /**
     * Get vcardid
     *
     * @return string 
     */
    public function getVcardid()
    {
        return $this->vcardid;
    }

    /**
     * Set fromvcard
     *
     * @param string $fromvcard
     * @return ScanCardVcardfieldModify
     */
    public function setFromvcard($fromvcard)
    {
        $this->fromvcard = $fromvcard;
    
        return $this;
    }

    /**
     * Get fromvcard
     *
     * @return string 
     */
    public function getFromvcard()
    {
        return $this->fromvcard;
    }

    /**
     * Set tovcard
     *
     * @param string $tovcard
     * @return ScanCardVcardfieldModify
     */
    public function setTovcard($tovcard)
    {
        $this->tovcard = $tovcard;
    
        return $this;
    }

    /**
     * Get tovcard
     *
     * @return string 
     */
    public function getTovcard()
    {
        return $this->tovcard;
    }

    /**
     * Set checkAccount
     *
     * @param string $checkAccount
     * @return ScanCardVcardfieldModify
     */
    public function setCheckAccount($checkAccount)
    {
        $this->checkAccount = $checkAccount;
    
        return $this;
    }

    /**
     * Get checkAccount
     *
     * @return string 
     */
    public function getCheckAccount()
    {
        return $this->checkAccount;
    }

    /**
     * Set fullcheckAccount
     *
     * @param string $fullcheckAccount
     * @return ScanCardVcardfieldModify
     */
    public function setFullcheckAccount($fullcheckAccount)
    {
        $this->fullcheckAccount = $fullcheckAccount;
    
        return $this;
    }

    /**
     * Get fullcheckAccount
     *
     * @return string 
     */
    public function getFullcheckAccount()
    {
        return $this->fullcheckAccount;
    }

    /**
     * Set name
     *
     * @param integer $name
     * @return ScanCardVcardfieldModify
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return integer 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set mobile
     *
     * @param integer $mobile
     * @return ScanCardVcardfieldModify
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    
        return $this;
    }

    /**
     * Get mobile
     *
     * @return integer 
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set company
     *
     * @param integer $company
     * @return ScanCardVcardfieldModify
     */
    public function setCompany($company)
    {
        $this->company = $company;
    
        return $this;
    }

    /**
     * Get company
     *
     * @return integer 
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set department
     *
     * @param integer $department
     * @return ScanCardVcardfieldModify
     */
    public function setDepartment($department)
    {
        $this->department = $department;
    
        return $this;
    }

    /**
     * Get department
     *
     * @return integer 
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Set job
     *
     * @param integer $job
     * @return ScanCardVcardfieldModify
     */
    public function setJob($job)
    {
        $this->job = $job;
    
        return $this;
    }

    /**
     * Get job
     *
     * @return integer 
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Set address
     *
     * @param integer $address
     * @return ScanCardVcardfieldModify
     */
    public function setAddress($address)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return integer 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set telphone
     *
     * @param integer $telphone
     * @return ScanCardVcardfieldModify
     */
    public function setTelphone($telphone)
    {
        $this->telphone = $telphone;
    
        return $this;
    }

    /**
     * Get telphone
     *
     * @return integer 
     */
    public function getTelphone()
    {
        return $this->telphone;
    }

    /**
     * Set fax
     *
     * @param integer $fax
     * @return ScanCardVcardfieldModify
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
    
        return $this;
    }

    /**
     * Get fax
     *
     * @return integer 
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set email
     *
     * @param integer $email
     * @return ScanCardVcardfieldModify
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return integer 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set web
     *
     * @param integer $web
     * @return ScanCardVcardfieldModify
     */
    public function setWeb($web)
    {
        $this->web = $web;
    
        return $this;
    }

    /**
     * Get web
     *
     * @return integer 
     */
    public function getWeb()
    {
        return $this->web;
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
     * @var string
     */
    private $modifyTime;


    /**
     * Set modifyTime
     *
     * @param string $modifyTime
     * @return ScanCardVcardfieldModify
     */
    public function setModifyTime($modifyTime)
    {
        $this->modifyTime = $modifyTime;
    
        return $this;
    }

    /**
     * Get modifyTime
     *
     * @return string 
     */
    public function getModifyTime()
    {
        return $this->modifyTime;
    }
}
