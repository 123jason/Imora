<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ScannerV2
 */
class ScannerV2
{
    /**
     * @var string
     */
    private $scannerId;

    /**
     * @var integer
     */
    private $type;

    /**
     * @var string
     */
    private $province;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $address;

    /**
     * @var integer
     */
    private $loctype;

    /**
     * @var string
     */
    private $ownername;

    /**
     * @var string
     */
    private $contactName;

    /**
     * @var string
     */
    private $contactInfo;

    /**
     * @var integer
     */
    private $state;

    /**
     * @var integer
     */
    private $lastModiy;

    /**
     * @var integer
     */
    private $createTime;

    /**
     * @var integer
     */
    private $firstUseTime;

    /**
     * @var integer
     */
    private $lastUseTime;

    /**
     * @var integer
     */
    private $reportType;

    /**
     * @var integer
     */
    private $reportTime;

    /**
     * @var integer
     */
    private $isdelete;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set scannerId
     *
     * @param string $scannerId
     * @return ScannerV2
     */
    public function setScannerId($scannerId)
    {
        $this->scannerId = $scannerId;
    
        return $this;
    }

    /**
     * Get scannerId
     *
     * @return string 
     */
    public function getScannerId()
    {
        return $this->scannerId;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return ScannerV2
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set province
     *
     * @param string $province
     * @return ScannerV2
     */
    public function setProvince($province)
    {
        $this->province = $province;
    
        return $this;
    }

    /**
     * Get province
     *
     * @return string 
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return ScannerV2
     */
    public function setCity($city)
    {
        $this->city = $city;
    
        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return ScannerV2
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
     * Set loctype
     *
     * @param integer $loctype
     * @return ScannerV2
     */
    public function setLoctype($loctype)
    {
        $this->loctype = $loctype;
    
        return $this;
    }

    /**
     * Get loctype
     *
     * @return integer 
     */
    public function getLoctype()
    {
        return $this->loctype;
    }

    /**
     * Set ownername
     *
     * @param string $ownername
     * @return ScannerV2
     */
    public function setOwnername($ownername)
    {
        $this->ownername = $ownername;
    
        return $this;
    }

    /**
     * Get ownername
     *
     * @return string 
     */
    public function getOwnername()
    {
        return $this->ownername;
    }

    /**
     * Set contactName
     *
     * @param string $contactName
     * @return ScannerV2
     */
    public function setContactName($contactName)
    {
        $this->contactName = $contactName;
    
        return $this;
    }

    /**
     * Get contactName
     *
     * @return string 
     */
    public function getContactName()
    {
        return $this->contactName;
    }

    /**
     * Set contactInfo
     *
     * @param string $contactInfo
     * @return ScannerV2
     */
    public function setContactInfo($contactInfo)
    {
        $this->contactInfo = $contactInfo;
    
        return $this;
    }

    /**
     * Get contactInfo
     *
     * @return string 
     */
    public function getContactInfo()
    {
        return $this->contactInfo;
    }

    /**
     * Set state
     *
     * @param integer $state
     * @return ScannerV2
     */
    public function setState($state)
    {
        $this->state = $state;
    
        return $this;
    }

    /**
     * Get state
     *
     * @return integer 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set lastModiy
     *
     * @param integer $lastModiy
     * @return ScannerV2
     */
    public function setLastModiy($lastModiy)
    {
        $this->lastModiy = $lastModiy;
    
        return $this;
    }

    /**
     * Get lastModiy
     *
     * @return integer 
     */
    public function getLastModiy()
    {
        return $this->lastModiy;
    }

    /**
     * Set createTime
     *
     * @param integer $createTime
     * @return ScannerV2
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
     * Set firstUseTime
     *
     * @param integer $firstUseTime
     * @return ScannerV2
     */
    public function setFirstUseTime($firstUseTime)
    {
        $this->firstUseTime = $firstUseTime;
    
        return $this;
    }

    /**
     * Get firstUseTime
     *
     * @return integer 
     */
    public function getFirstUseTime()
    {
        return $this->firstUseTime;
    }

    /**
     * Set lastUseTime
     *
     * @param integer $lastUseTime
     * @return ScannerV2
     */
    public function setLastUseTime($lastUseTime)
    {
        $this->lastUseTime = $lastUseTime;
    
        return $this;
    }

    /**
     * Get lastUseTime
     *
     * @return integer 
     */
    public function getLastUseTime()
    {
        return $this->lastUseTime;
    }

    /**
     * Set reportType
     *
     * @param integer $reportType
     * @return ScannerV2
     */
    public function setReportType($reportType)
    {
        $this->reportType = $reportType;
    
        return $this;
    }

    /**
     * Get reportType
     *
     * @return integer 
     */
    public function getReportType()
    {
        return $this->reportType;
    }

    /**
     * Set reportTime
     *
     * @param integer $reportTime
     * @return ScannerV2
     */
    public function setReportTime($reportTime)
    {
        $this->reportTime = $reportTime;
    
        return $this;
    }

    /**
     * Get reportTime
     *
     * @return integer 
     */
    public function getReportTime()
    {
        return $this->reportTime;
    }

    /**
     * Set isdelete
     *
     * @param integer $isdelete
     * @return ScannerV2
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
