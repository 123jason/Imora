<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountBizDetail
 */
class AccountBizDetail
{
    /**
     * @var string
     */
    private $bizId;

    /**
     * @var string
     */
    private $bizName;
    
    /**
     * @var string
     */
    private $prespell;
    
    /**
     * @var string
     */
    private $bizAddress;

    /**
     * @var string
     */
    private $bizEmail;

    /**
     * @var string
     */
    private $bizLicenseCode;

    /**
     * @var string
     */
    private $bizOrgCode;

    /**
     * @var string
     */
    private $bizInfo;

    /**
     * @var string
     */
    private $website;

    /**
     * @var string
     */
    private $logoPath;

    /**
     * @var integer
     */
    private $countryCode;

    /**
     * @var integer
     */
    private $bizSize;

    /**
     * @var string
     */
    private $bizType;

    /**
     * @var string
     */
    private $countryid;

    /**
     * @var string
     */
    private $region;

    /**
     * @var string
     */
    private $latitude;

    /**
     * @var string
     */
    private $longitude;

    /**
     * @var integer
     */
    private $imid;

    /**
     * @var string
     */
    private $categoryId;

    /**
     * @var string
     */
    private $categoryId2;

    /**
     * @var integer
     */
    private $languageid;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $branchAddress;
    
    /**
     * @var string
     */
    private $bizno;

    /**
     * @var integer
     */
    private $identTime;

    /**
     * @var integer
     */
    private $id;
    /**
     * @var string
     */
    private $contact;

    /**
     * @var integer
     */
    private $payfee;

    /**
     * Set bizId
     *
     * @param string $bizId
     * @return AccountBizDetail
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
     * Set bizName
     *
     * @param string $bizName
     * @return AccountBizDetail
     */
    public function setBizName($bizName)
    {
        $this->bizName = $bizName;

        return $this;
    }

    /**
     * Get bizName
     *
     * @return string 
     */
    public function getBizName()
    {
        return $this->bizName;
    }
    /**
     * Set prespell
     *
     * @param string $prespell
     * @return ExpoInfo
     */
    public function setPrespell($prespell)
    {
    	$this->prespell = $prespell;
    
    	return $this;
    }
    
    /**
     * Get prespell
     *
     * @return string
     */
    public function getPrespell()
    {
    	return $this->prespell;
    }
    /**
     * Set bizAddress
     *
     * @param string $bizAddress
     * @return AccountBizDetail
     */
    public function setBizAddress($bizAddress)
    {
        $this->bizAddress = $bizAddress;

        return $this;
    }

    /**
     * Get bizAddress
     *
     * @return string 
     */
    public function getBizAddress()
    {
        return $this->bizAddress;
    }

    /**
     * Set bizEmail
     *
     * @param string $bizEmail
     * @return AccountBizDetail
     */
    public function setBizEmail($bizEmail)
    {
        $this->bizEmail = $bizEmail;

        return $this;
    }

    /**
     * Get bizEmail
     *
     * @return string 
     */
    public function getBizEmail()
    {
        return $this->bizEmail;
    }

    /**
     * Set bizLicenseCode
     *
     * @param string $bizLicenseCode
     * @return AccountBizDetail
     */
    public function setBizLicenseCode($bizLicenseCode)
    {
        $this->bizLicenseCode = $bizLicenseCode;

        return $this;
    }

    /**
     * Get bizLicenseCode
     *
     * @return string 
     */
    public function getBizLicenseCode()
    {
        return $this->bizLicenseCode;
    }

    /**
     * Set bizOrgCode
     *
     * @param string $bizOrgCode
     * @return AccountBizDetail
     */
    public function setBizOrgCode($bizOrgCode)
    {
        $this->bizOrgCode = $bizOrgCode;

        return $this;
    }

    /**
     * Get bizOrgCode
     *
     * @return string 
     */
    public function getBizOrgCode()
    {
        return $this->bizOrgCode;
    }

    /**
     * Set bizInfo
     *
     * @param string $bizInfo
     * @return AccountBizDetail
     */
    public function setBizInfo($bizInfo)
    {
        $this->bizInfo = $bizInfo;

        return $this;
    }

    /**
     * Get bizInfo
     *
     * @return string 
     */
    public function getBizInfo()
    {
        return $this->bizInfo;
    }

    /**
     * Set website
     *
     * @param string $website
     * @return AccountBizDetail
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string 
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set logoPath
     *
     * @param string $logoPath
     * @return AccountBizDetail
     */
    public function setLogoPath($logoPath)
    {
        $this->logoPath = $logoPath;

        return $this;
    }

    /**
     * Get logoPath
     *
     * @return string 
     */
    public function getLogoPath()
    {
        return $this->logoPath;
    }

    /**
     * Set countryCode
     *
     * @param integer $countryCode
     * @return AccountBizDetail
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    /**
     * Get countryCode
     *
     * @return integer 
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * Set bizSize
     *
     * @param integer $bizSize
     * @return AccountBizDetail
     */
    public function setBizSize($bizSize)
    {
        $this->bizSize = $bizSize;

        return $this;
    }

    /**
     * Get bizSize
     *
     * @return integer 
     */
    public function getBizSize()
    {
        return $this->bizSize;
    }

    /**
     * Set bizType
     *
     * @param string $bizType
     * @return AccountBizDetail
     */
    public function setBizType($bizType)
    {
        $this->bizType = $bizType;

        return $this;
    }

    /**
     * Get bizType
     *
     * @return string 
     */
    public function getBizType()
    {
        return $this->bizType;
    }

    /**
     * Set countryid
     *
     * @param string $countryid
     * @return AccountBizDetail
     */
    public function setCountryid($countryid)
    {
        $this->countryid = $countryid;

        return $this;
    }

    /**
     * Get countryid
     *
     * @return string 
     */
    public function getCountryid()
    {
        return $this->countryid;
    }

    /**
     * Set region
     *
     * @param string $region
     * @return AccountBizDetail
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return string 
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     * @return AccountBizDetail
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     * @return AccountBizDetail
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set imid
     *
     * @param integer $imid
     * @return AccountBizDetail
     */
    public function setImid($imid)
    {
        $this->imid = $imid;

        return $this;
    }

    /**
     * Get imid
     *
     * @return integer 
     */
    public function getImid()
    {
        return $this->imid;
    }

    /**
     * Set categoryId
     *
     * @param string $categoryId
     * @return AccountBizDetail
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    /**
     * Get categoryId
     *
     * @return string 
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * Set categoryId2
     *
     * @param string $categoryId2
     * @return AccountBizDetail
     */
    public function setCategoryId2($categoryId2)
    {
        $this->categoryId2 = $categoryId2;

        return $this;
    }

    /**
     * Get categoryId2
     *
     * @return string 
     */
    public function getCategoryId2()
    {
        return $this->categoryId2;
    }

    /**
     * Set languageid
     *
     * @param integer $languageid
     * @return AccountBizDetail
     */
    public function setLanguageid($languageid)
    {
        $this->languageid = $languageid;

        return $this;
    }

    /**
     * Get languageid
     *
     * @return integer 
     */
    public function getLanguageid()
    {
        return $this->languageid;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return AccountBizDetail
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set branchAddress
     *
     * @param string $branchAddress
     * @return AccountBizDetail
     */
    public function setBranchAddress($branchAddress)
    {
        $this->branchAddress = $branchAddress;

        return $this;
    }

    /**
     * Get branchAddress
     *
     * @return string 
     */
    public function getBranchAddress()
    {
        return $this->branchAddress;
    }
    /**
     * Set bizno
     *
     * @param string $bizno
     * @return AccountBizDetail
     */
    public function setBizno($bizno)
    {
    	$this->bizno = $bizno;
    
    	return $this;
    }
    
    /**
     * Get bizno
     *
     * @return string
     */
    public function getBizno()
    {
    	return $this->bizno;
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
     * Set contact
     *
     * @param string $contact
     * @return AccountBizDetail
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
    
        return $this;
    }
    
    /**
     * Get contact
     *
     * @return string
     */
    public function getContact()
    {
        return $this->contact;
    }
    /**
     * @var integer
     */
    private $registType;

    /**
     * @var string
     */
    private $bizsuperId;

    /**
     * Set registType
     *
     * @param integer $registType
     * @return AccountBizDetail
     */
    public function setRegistType($registType)
    {
        $this->registType = $registType;
    
        return $this;
    }

    /**
     * Get registType
     *
     * @return integer 
     */
    public function getRegistType()
    {
        return $this->registType;
    }

    /**
     * Set bizsuperId
     *
     * @param string $bizsuperId
     * @return AccountBizDetail
     */
    public function setBizsuperId($bizsuperId)
    {
        $this->bizsuperId = $bizsuperId;
    
        return $this;
    }

    /**
     * Get bizsuperId
     *
     * @return string 
     */
    public function getBizsuperId()
    {
        return $this->bizsuperId;
    }
    /**
     * @var string
     */
    private $licensePath;

    /**
     * @var string
     */
    private $organizationPath;

    /**
     * @var string
     */
    private $registrationPath;

    /**
     * @var string
     */
    private $licenseType;

    /**
     * @var \Oradt\StoreBundle\Entity\AccountBiz
     */
    private $biz;


    /**
     * Set licensePath
     *
     * @param string $licensePath
     * @return AccountBizDetail
     */
    public function setLicensePath($licensePath)
    {
        $this->licensePath = $licensePath;
    
        return $this;
    }

    /**
     * Get licensePath
     *
     * @return string 
     */
    public function getLicensePath()
    {
        return $this->licensePath;
    }

    /**
     * Set organizationPath
     *
     * @param string $organizationPath
     * @return AccountBizDetail
     */
    public function setOrganizationPath($organizationPath)
    {
        $this->organizationPath = $organizationPath;
    
        return $this;
    }

    /**
     * Get organizationPath
     *
     * @return string 
     */
    public function getOrganizationPath()
    {
        return $this->organizationPath;
    }

    /**
     * Set registrationPath
     *
     * @param string $registrationPath
     * @return AccountBizDetail
     */
    public function setRegistrationPath($registrationPath)
    {
        $this->registrationPath = $registrationPath;
    
        return $this;
    }

    /**
     * Get registrationPath
     *
     * @return string 
     */
    public function getRegistrationPath()
    {
        return $this->registrationPath;
    }

    /**
     * Set licenseType
     *
     * @param string $licenseType
     * @return AccountBizDetail
     */
    public function setLicenseType($licenseType)
    {
        $this->licenseType = $licenseType;
    
        return $this;
    }

    /**
     * Get licenseType
     *
     * @return string 
     */
    public function getLicenseType()
    {
        return $this->licenseType;
    }

    /**
     * @var integer
     */
    private $identType;

    /**
     * Set identType
     *
     * @param integer $identType
     * @return AccountBizDetail
     */
    public function setIdentType($identType)
    {
        $this->identType = $identType;
    
        return $this;
    }

    /**
     * Get identType
     *
     * @return integer 
     */
    public function getIdentType()
    {
        return $this->identType;
    }

    /**
     * Set identTime
     *
     * @param integer $identTime
     * @return AccountBizDetail
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
     * Set payfee
     *
     * @param integer $payfee
     * @return AccountBizDetail
     */
    public function setPayfee($payfee)
    {
        $this->payfee = $payfee;
    
        return $this;
    }

    /**
     * Get payfee
     *
     * @return integer 
     */
    public function getPayfee()
    {
        return $this->payfee;
    }
}
