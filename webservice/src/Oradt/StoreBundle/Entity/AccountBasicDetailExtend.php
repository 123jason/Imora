<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountBasicDetailExtend
 */
class AccountBasicDetailExtend
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $enName;

    /**
     * @var string
     */
    private $company;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $department;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $telephone;

    /**
     * @var string
     */
    private $cellphone;

    /**
     * @var string
     */
    private $email1;

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $qq;

    /**
     * @var string
     */
    private $weixin;

    /**
     * @var string
     */
    private $weibo;

    /**
     * @var string
     */
    private $fax;

    /**
     * @var integer
     */
    private $badNum;

    /**
     * @var integer
     */
    private $praiseNum;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return AccountBasicDetailExtend
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
     * Set enName
     *
     * @param string $enName
     * @return AccountBasicDetailExtend
     */
    public function setEnName($enName)
    {
        $this->enName = $enName;
    
        return $this;
    }

    /**
     * Get enName
     *
     * @return string 
     */
    public function getEnName()
    {
        return $this->enName;
    }

    /**
     * Set company
     *
     * @param string $company
     * @return AccountBasicDetailExtend
     */
    public function setCompany($company)
    {
        $this->company = $company;
    
        return $this;
    }

    /**
     * Get company
     *
     * @return string 
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return AccountBasicDetailExtend
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
     * Set department
     *
     * @param string $department
     * @return AccountBasicDetailExtend
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
     * Set url
     *
     * @param string $url
     * @return AccountBasicDetailExtend
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     * @return AccountBasicDetailExtend
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    
        return $this;
    }

    /**
     * Get telephone
     *
     * @return string 
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set cellphone
     *
     * @param string $cellphone
     * @return AccountBasicDetailExtend
     */
    public function setCellphone($cellphone)
    {
        $this->cellphone = $cellphone;
    
        return $this;
    }

    /**
     * Get cellphone
     *
     * @return string 
     */
    public function getCellphone()
    {
        return $this->cellphone;
    }

    /**
     * Set email1
     *
     * @param string $email1
     * @return AccountBasicDetailExtend
     */
    public function setEmail1($email1)
    {
        $this->email1 = $email1;
    
        return $this;
    }

    /**
     * Get email1
     *
     * @return string 
     */
    public function getEmail1()
    {
        return $this->email1;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return AccountBasicDetailExtend
     */
    public function setAddress($address)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set qq
     *
     * @param string $qq
     * @return AccountBasicDetailExtend
     */
    public function setQq($qq)
    {
        $this->qq = $qq;
    
        return $this;
    }

    /**
     * Get qq
     *
     * @return string 
     */
    public function getQq()
    {
        return $this->qq;
    }

    /**
     * Set weixin
     *
     * @param string $weixin
     * @return AccountBasicDetailExtend
     */
    public function setWeixin($weixin)
    {
        $this->weixin = $weixin;
    
        return $this;
    }

    /**
     * Get weixin
     *
     * @return string 
     */
    public function getWeixin()
    {
        return $this->weixin;
    }

    /**
     * Set weibo
     *
     * @param string $weibo
     * @return AccountBasicDetailExtend
     */
    public function setWeibo($weibo)
    {
        $this->weibo = $weibo;
    
        return $this;
    }

    /**
     * Get weibo
     *
     * @return string 
     */
    public function getWeibo()
    {
        return $this->weibo;
    }

    /**
     * Set fax
     *
     * @param string $fax
     * @return AccountBasicDetailExtend
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
    
        return $this;
    }

    /**
     * Get fax
     *
     * @return string 
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set badNum
     *
     * @param integer $badNum
     * @return AccountBasicDetailExtend
     */
    public function setBadNum($badNum)
    {
        $this->badNum = $badNum;
    
        return $this;
    }

    /**
     * Get badNum
     *
     * @return integer 
     */
    public function getBadNum()
    {
        return $this->badNum;
    }

    /**
     * Set praiseNum
     *
     * @param integer $praiseNum
     * @return AccountBasicDetailExtend
     */
    public function setPraiseNum($praiseNum)
    {
        $this->praiseNum = $praiseNum;
    
        return $this;
    }

    /**
     * Get praiseNum
     *
     * @return integer 
     */
    public function getPraiseNum()
    {
        return $this->praiseNum;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return AccountBasicDetailExtend
     */
    public function setCreatedTime($createdTime)
    {
        $this->createdTime = $createdTime;
    
        return $this;
    }

    /**
     * Get createdTime
     *
     * @return integer 
     */
    public function getCreatedTime()
    {
        return $this->createdTime;
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
