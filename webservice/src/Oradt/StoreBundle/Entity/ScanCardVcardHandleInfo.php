<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ScanCardVcardHandleInfo
 */
class ScanCardVcardHandleInfo
{
    /**
     * @var string
     */
    private $vcardid;

    /**
     * @var string
     */
    private $vcard;

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
     * @var \DateTime
     */
    private $modifyTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set vcardid
     *
     * @param string $vcardid
     * @return ScanCardVcardHandleInfo
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
     * Set vcard
     *
     * @param string $vcard
     * @return ScanCardVcardHandleInfo
     */
    public function setVcard($vcard)
    {
        $this->vcard = $vcard;
    
        return $this;
    }

    /**
     * Get vcard
     *
     * @return string 
     */
    public function getVcard()
    {
        return $this->vcard;
    }

    /**
     * Set name
     *
     * @param integer $name
     * @return ScanCardVcardHandleInfo
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
     * @return ScanCardVcardHandleInfo
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
     * @return ScanCardVcardHandleInfo
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
     * @return ScanCardVcardHandleInfo
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
     * @return ScanCardVcardHandleInfo
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
     * @return ScanCardVcardHandleInfo
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
     * @return ScanCardVcardHandleInfo
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
     * @return ScanCardVcardHandleInfo
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
     * @return ScanCardVcardHandleInfo
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
     * @return ScanCardVcardHandleInfo
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
     * Set modifyTime
     *
     * @param \DateTime $modifyTime
     * @return ScanCardVcardHandleInfo
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
