<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountBasicBingorange
 */
class AccountBasicBingorange
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $orauuid;

    /**
     * @var string
     */
    private $oraname;

    /**
     * @var string
     */
    private $phoneuuid;

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
    private $id;

    /**
     * @var string
     */
    private $pageId;

    /**
     * @var integer
     */
    private $iflag;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var integer
     */
    private $ifmissing;

    /**
     * @var integer
     */
    private $iserror;

    /**
     * Set userId
     *
     * @param string $userId
     * @return AccountBasicBingorange
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
     * Set orauuid
     *
     * @param string $orauuid
     * @return AccountBasicBingorange
     */
    public function setOrauuid($orauuid)
    {
        $this->orauuid = $orauuid;
    
        return $this;
    }

    /**
     * Get orauuid
     *
     * @return string 
     */
    public function getOrauuid()
    {
        return $this->orauuid;
    }

    /**
     * Set oraname
     *
     * @param string $oraname
     * @return AccountBasicBingorange
     */
    public function setOraname($oraname)
    {
        $this->oraname = $oraname;
    
        return $this;
    }

    /**
     * Get oraname
     *
     * @return string 
     */
    public function getOraname()
    {
        return $this->oraname;
    }

    /**
     * Set phoneuuid
     *
     * @param string $phoneuuid
     * @return AccountBasicBingorange
     */
    public function setPhoneuuid($phoneuuid)
    {
        $this->phoneuuid = $phoneuuid;
    
        return $this;
    }

    /**
     * Get phoneuuid
     *
     * @return string 
     */
    public function getPhoneuuid()
    {
        return $this->phoneuuid;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return AccountBasicBingorange
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
     * @return AccountBasicBingorange
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
     * Set iflag
     *
     * @param integer $iflag
     * @return AccountBasicBingorange
     */
    public function setIflag($iflag)
    {
        $this->iflag = $iflag;
    
        return $this;
    }

    /**
     * Get iflag
     *
     * @return integer 
     */
    public function getIflag()
    {
        return $this->iflag;
    }

    /**
     * Set pageId
     *
     * @param string $pageId
     * @return AccountBasicBingorange
     */
    public function setPageId($pageId)
    {
        $this->pageId = $pageId;
    
        return $this;
    }

    /**
     * Get pageId
     *
     * @return string 
     */
    public function getPageId()
    {
        return $this->pageId;
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
    private $snnum;

    /**
     * @var string
     */
    private $qrcode;


    /**
     * Set snnum
     *
     * @param string $snnum
     * @return AccountBasicBingorange
     */
    public function setSnnum($snnum)
    {
        $this->snnum = $snnum;
    
        return $this;
    }

    /**
     * Get snnum
     *
     * @return string 
     */
    public function getSnnum()
    {
        return $this->snnum;
    }

    /**
     * Set qrcode
     *
     * @param string $qrcode
     * @return AccountBasicBingorange
     */
    public function setQrcode($qrcode)
    {
        $this->qrcode = $qrcode;
    
        return $this;
    }

    /**
     * Get qrcode
     *
     * @return string 
     */
    public function getQrcode()
    {
        return $this->qrcode;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return AccountBasicBingorange
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
     * Set ifmissing
     *
     * @param integer $ifmissing
     * @return AccountBasicBingorange
     */
    public function setIfmissing($ifmissing)
    {
        $this->ifmissing = $ifmissing;
    
        return $this;
    }

    /**
     * Get ifmissing
     *
     * @return integer 
     */
    public function getIfmissing()
    {
        return $this->ifmissing;
    }    
    /**
     * @var string
     */
    private $orangeVersion;

    /**
     * @var string
     */
    private $appVersion;

    /**
     * @var string
     */
    private $phoneVersion;

    /**
     * @var string
     */
    private $module;


    /**
     * Set orangeVersion
     *
     * @param string $orangeVersion
     * @return AccountBasicBingorange
     */
    public function setOrangeVersion($orangeVersion)
    {
        $this->orangeVersion = $orangeVersion;
    
        return $this;
    }

    /**
     * Get orangeVersion
     *
     * @return string 
     */
    public function getOrangeVersion()
    {
        return $this->orangeVersion;
    }

    /**
     * Set appVersion
     *
     * @param string $appVersion
     * @return AccountBasicBingorange
     */
    public function setAppVersion($appVersion)
    {
        $this->appVersion = $appVersion;
    
        return $this;
    }

    /**
     * Get appVersion
     *
     * @return string 
     */
    public function getAppVersion()
    {
        return $this->appVersion;
    }

    /**
     * Set phoneVersion
     *
     * @param string $phoneVersion
     * @return AccountBasicBingorange
     */
    public function setPhoneVersion($phoneVersion)
    {
        $this->phoneVersion = $phoneVersion;
    
        return $this;
    }

    /**
     * Get phoneVersion
     *
     * @return string 
     */
    public function getPhoneVersion()
    {
        return $this->phoneVersion;
    }

    /**
     * Set module
     *
     * @param string $module
     * @return AccountBasicBingorange
     */
    public function setModule($module)
    {
        $this->module = $module;
    
        return $this;
    }

    /**
     * Get module
     *
     * @return string 
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * Set iserror
     *
     * @param integer $iserror
     * @return AccountBasicBingorange
     */
    public function setIserror($iserror)
    {
        $this->iserror = $iserror;
    
        return $this;
    }

    /**
     * Get iserror
     *
     * @return integer 
     */
    public function getIserror()
    {
        return $this->iserror;
    }  
}
