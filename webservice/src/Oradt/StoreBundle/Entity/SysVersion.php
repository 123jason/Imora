<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SysVersion
 */
class SysVersion
{
    /**
     * @var string
     */
    private $version;

    /**
     * @var string
     */
    private $deviceType;

    /**
     * @var string
     */
    private $versionUrl;

    /**
     * @var integer
     */
    private $isIos;

    /**
     * @var string
     */
    private $unionpayNum;

    /**
     * @var integer
     */
    private $isUpdate;

    /**
     * @var string
     */
    private $updatePrompt;

    /**
     * @var string
     */
    private $upbutton;

    /**
     * @var string
     */
    private $noupbutton;

    /**
     * @var integer
     */
    private $updateTime;

    /**
     * @var string
     */
    private $updateLog;

    /**
     * @var integer
     */
    private $isdelete;

    /**
     * @var integer
     */
    private $createTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set version
     *
     * @param string $version
     * @return SysVersion
     */
    public function setVersion($version)
    {
        $this->version = $version;
    
        return $this;
    }

    /**
     * Get version
     *
     * @return string 
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set deviceType
     *
     * @param string $deviceType
     * @return SysVersion
     */
    public function setDeviceType($deviceType)
    {
        $this->deviceType = $deviceType;
    
        return $this;
    }

    /**
     * Get deviceType
     *
     * @return string 
     */
    public function getDeviceType()
    {
        return $this->deviceType;
    }

    /**
     * Set versionUrl
     *
     * @param string $versionUrl
     * @return SysVersion
     */
    public function setVersionUrl($versionUrl)
    {
        $this->versionUrl = $versionUrl;
    
        return $this;
    }

    /**
     * Get versionUrl
     *
     * @return string 
     */
    public function getVersionUrl()
    {
        return $this->versionUrl;
    }

    /**
     * Set isIos
     *
     * @param integer $isIos
     * @return SysVersion
     */
    public function setIsIos($isIos)
    {
        $this->isIos = $isIos;
    
        return $this;
    }

    /**
     * Get isIos
     *
     * @return integer 
     */
    public function getIsIos()
    {
        return $this->isIos;
    }

    /**
     * Set unionpayNum
     *
     * @param string $unionpayNum
     * @return SysVersion
     */
    public function setUnionpayNum($unionpayNum)
    {
        $this->unionpayNum = $unionpayNum;
    
        return $this;
    }

    /**
     * Get unionpayNum
     *
     * @return string 
     */
    public function getUnionpayNum()
    {
        return $this->unionpayNum;
    }

    /**
     * Set isUpdate
     *
     * @param integer $isUpdate
     * @return SysVersion
     */
    public function setIsUpdate($isUpdate)
    {
        $this->isUpdate = $isUpdate;
    
        return $this;
    }

    /**
     * Get isUpdate
     *
     * @return integer 
     */
    public function getIsUpdate()
    {
        return $this->isUpdate;
    }

    /**
     * Set updatePrompt
     *
     * @param string $updatePrompt
     * @return SysVersion
     */
    public function setUpdatePrompt($updatePrompt)
    {
        $this->updatePrompt = $updatePrompt;
    
        return $this;
    }

    /**
     * Get updatePrompt
     *
     * @return string 
     */
    public function getUpdatePrompt()
    {
        return $this->updatePrompt;
    }

    /**
     * Set upbutton
     *
     * @param string $upbutton
     * @return SysVersion
     */
    public function setUpbutton($upbutton)
    {
        $this->upbutton = $upbutton;
    
        return $this;
    }

    /**
     * Get upbutton
     *
     * @return string 
     */
    public function getUpbutton()
    {
        return $this->upbutton;
    }

    /**
     * Set noupbutton
     *
     * @param string $noupbutton
     * @return SysVersion
     */
    public function setNoupbutton($noupbutton)
    {
        $this->noupbutton = $noupbutton;
    
        return $this;
    }

    /**
     * Get noupbutton
     *
     * @return string 
     */
    public function getNoupbutton()
    {
        return $this->noupbutton;
    }

    /**
     * Set updateTime
     *
     * @param integer $updateTime
     * @return SysVersion
     */
    public function setUpdateTime($updateTime)
    {
        $this->updateTime = $updateTime;
    
        return $this;
    }

    /**
     * Get updateTime
     *
     * @return integer 
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }

    /**
     * Set updateLog
     *
     * @param string $updateLog
     * @return SysVersion
     */
    public function setUpdateLog($updateLog)
    {
        $this->updateLog = $updateLog;
    
        return $this;
    }

    /**
     * Get updateLog
     *
     * @return string 
     */
    public function getUpdateLog()
    {
        return $this->updateLog;
    }

    /**
     * Set isdelete
     *
     * @param integer $isdelete
     * @return SysVersion
     */
    public function setIsdelete($isdelete)
    {
        $this->isdelete = $isdelete;
    
        return $this;
    }

    /**
     * Get isdelete
     *
     * @return integer 
     */
    public function getIsdelete()
    {
        return $this->isdelete;
    }

    /**
     * Set createTime
     *
     * @param integer $createTime
     * @return SysVersion
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
