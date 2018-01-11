<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExpoExhibitorInfo
 */
class ExpoExhibitorInfo
{
    /**
     * @var string
     */
    private $bizId;

    /**
     * @var string
     */
    private $expoId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $linkman;

    /**
     * @var string
     */
    private $mobile;

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
    private $isgrant;

    /**
     * @var integer
     */
    private $exhibitorId;


    /**
     * Set bizId
     *
     * @param string $bizId
     * @return ExpoExhibitorInfo
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
     * Set expoId
     *
     * @param string $expoId
     * @return ExpoExhibitorInfo
     */
    public function setExpoId($expoId)
    {
        $this->expoId = $expoId;
    
        return $this;
    }

    /**
     * Get expoId
     *
     * @return string 
     */
    public function getExpoId()
    {
        return $this->expoId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return ExpoExhibitorInfo
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
     * Set email
     *
     * @param string $email
     * @return ExpoExhibitorInfo
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
     * Set linkman
     *
     * @param string $linkman
     * @return ExpoExhibitorInfo
     */
    public function setLinkman($linkman)
    {
        $this->linkman = $linkman;
    
        return $this;
    }

    /**
     * Get linkman
     *
     * @return string 
     */
    public function getLinkman()
    {
        return $this->linkman;
    }

    /**
     * Set mobile
     *
     * @param string $mobile
     * @return ExpoExhibitorInfo
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
     * Set status
     *
     * @param string $status
     * @return ExpoExhibitorInfo
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
     * @return ExpoExhibitorInfo
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
     * Set isgrant
     *
     * @param integer $isgrant
     * @return ExpoExhibitorInfo
     */
    public function setIsgrant($isgrant)
    {
        $this->isgrant = $isgrant;
    
        return $this;
    }

    /**
     * Get isgrant
     *
     * @return integer 
     */
    public function getIsgrant()
    {
        return $this->isgrant;
    }

    /**
     * Get exhibitorId
     *
     * @return integer 
     */
    public function getExhibitorId()
    {
        return $this->exhibitorId;
    }
    /**
     * @var string
     */
    private $representative;

    /**
     * @var string
     */
    private $businessnum;

    /**
     * @var string
     */
    private $organizecode;


    /**
     * Set representative
     *
     * @param string $representative
     * @return ExpoExhibitorInfo
     */
    public function setRepresentative($representative)
    {
        $this->representative = $representative;
    
        return $this;
    }

    /**
     * Get representative
     *
     * @return string 
     */
    public function getRepresentative()
    {
        return $this->representative;
    }

    /**
     * Set businessnum
     *
     * @param string $businessnum
     * @return ExpoExhibitorInfo
     */
    public function setBusinessnum($businessnum)
    {
        $this->businessnum = $businessnum;
    
        return $this;
    }

    /**
     * Get businessnum
     *
     * @return string 
     */
    public function getBusinessnum()
    {
        return $this->businessnum;
    }

    /**
     * Set organizecode
     *
     * @param string $organizecode
     * @return ExpoExhibitorInfo
     */
    public function setOrganizecode($organizecode)
    {
        $this->organizecode = $organizecode;
    
        return $this;
    }

    /**
     * Get organizecode
     *
     * @return string 
     */
    public function getOrganizecode()
    {
        return $this->organizecode;
    }
}
