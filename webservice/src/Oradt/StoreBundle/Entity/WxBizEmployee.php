<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WxBizEmployee
 */
class WxBizEmployee
{
    /**
     * @var string
     */
    private $bizId;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $mobile;

    /**
     * @var string
     */
    private $passwd;

    /**
     * @var string
     */
    private $email;

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
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $modifyTime;

    /**
     * @var integer
     */
    private $enable;

    /**
     * @var string
     */
    private $openId;

    /**
     * @var string
     */
    private $unionId;

    /**
     * @var integer
     */
    private $roleId;

    /**
     * @var integer
     */
    private $importStatus;

    /**
     * @var integer
     */
    private $reFrom;

    /**
     * @var integer
     */
    private $identStatus;

    /**
     * @var integer
     */
    private $identTime;

    /**
     * @var integer
     */
    private $id;
    
    /**
     * @var integer
     */
    private $isDel;

    /**
     * @var string
     */
    private $bak;
    
    /**
     * @var string
     */
    private $accountNo;

    /**
     * Set bizId
     *
     * @param string $bizId
     * @return WxBizEmployee
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
     * Set code
     *
     * @param string $code
     * @return WxBizEmployee
     */
    public function setCode($code)
    {
        $this->code = $code;
    
        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set mobile
     *
     * @param string $mobile
     * @return WxBizEmployee
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
     * Set passwd
     *
     * @param string $passwd
     * @return WxBizEmployee
     */
    public function setPasswd($passwd)
    {
        $this->passwd = $passwd;
    
        return $this;
    }

    /**
     * Get passwd
     *
     * @return string 
     */
    public function getPasswd()
    {
        return $this->passwd;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return WxBizEmployee
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
     * Set name
     *
     * @param string $name
     * @return WxBizEmployee
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
     * @return WxBizEmployee
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
     * @return WxBizEmployee
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
     * Set createdTime
     *
     * @param integer $createdTime
     * @return WxBizEmployee
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
     * Set modifyTime
     *
     * @param integer $modifyTime
     * @return WxBizEmployee
     */
    public function setModifyTime($modifyTime)
    {
        $this->modifyTime = $modifyTime;
    
        return $this;
    }

    /**
     * Get modifyTime
     *
     * @return integer 
     */
    public function getModifyTime()
    {
        return $this->modifyTime;
    }

    /**
     * Set enable
     *
     * @param integer $enable
     * @return WxBizEmployee
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

    /**
     * Set openId
     *
     * @param string $openId
     * @return WxBizEmployee
     */
    public function setOpenId($openId)
    {
        $this->openId = $openId;
    
        return $this;
    }

    /**
     * Get openId
     *
     * @return string 
     */
    public function getOpenId()
    {
        return $this->openId;
    }

    /**
     * Set unionId
     *
     * @param string $unionId
     * @return WxBizEmployee
     */
    public function setUnionId($unionId)
    {
        $this->unionId = $unionId;
    
        return $this;
    }

    /**
     * Get unionId
     *
     * @return string 
     */
    public function getUnionId()
    {
        return $this->unionId;
    }

    /**
     * Set roleId
     *
     * @param integer $roleId
     * @return WxBizEmployee
     */
    public function setRoleId($roleId)
    {
        $this->roleId = $roleId;
    
        return $this;
    }

    /**
     * Get roleId
     *
     * @return integer 
     */
    public function getRoleId()
    {
        return $this->roleId;
    }

    /**
     * Set importStatus
     *
     * @param integer $importStatus
     * @return WxBizEmployee
     */
    public function setImportStatus($importStatus)
    {
        $this->importStatus = $importStatus;
    
        return $this;
    }

    /**
     * Get importStatus
     *
     * @return integer 
     */
    public function getImportStatus()
    {
        return $this->importStatus;
    }

    /**
     * Set reFrom
     *
     * @param integer $reFrom
     * @return WxBizEmployee
     */
    public function setReFrom($reFrom)
    {
        $this->reFrom = $reFrom;
    
        return $this;
    }

    /**
     * Get reFrom
     *
     * @return integer 
     */
    public function getReFrom()
    {
        return $this->reFrom;
    }

    /**
     * Set identStatus
     *
     * @param integer $identStatus
     * @return WxBizEmployee
     */
    public function setIdentStatus($identStatus)
    {
        $this->identStatus = $identStatus;
    
        return $this;
    }

    /**
     * Get identStatus
     *
     * @return integer 
     */
    public function getIdentStatus()
    {
        return $this->identStatus;
    }

    /**
     * Set identTime
     *
     * @param integer $identTime
     * @return WxBizEmployee
     */
    public function setIdentTime($identTime)
    {
        $this->identTime = $identTime;
    
        return $this;
    }

    /**
     * Get identTime
     *
     * @return integer 
     */
    public function getIdentTime()
    {
        return $this->identTime;
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
     * Set IsDel
     *
     * @param string $bizId
     * @return WxBizEmployee
     */
    public function setIsDel($isDel)
    {
        $this->isDel = $isDel;
    
        return $this;
    }
    
    /**
     * Get IsDel
     *
     * @return string
     */
    public function getIsDel()
    {
        return $this->isDel;
    }
    
    /**
     * Set bak
     *
     * @param string $bak
     * @return WxBizEmployee
     */
    public function setBak($bak)
    {
        $this->bak = $bak;
    
        return $this;
    }
    
    /**
     * Get bak
     *
     * @return string
     */
    public function getBak()
    {
        return $this->bak;
    }
      /**
     * Set bak
     *
     * @param string $bak
     * @return WxBizEmployee
     */
    public function setAccountNo($accountNo)
    {
        $this->accountNo = $accountNo;
    
        return $this;
    }
    
    /**
     * Get bak
     *
     * @return string
     */
    public function getAccountNo()
    {
        return $this->accountNo;
    }
}
