<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * I18nCity
 */
class I18nCity
{
    /**
     * @var string
     */
    private $provinceSc;

    /**
     * @var string
     */
    private $parentSc;

    /**
     * @var string
     */
    private $syscode;

    /**
     * @var string
     */
    private $stateId;

    /**
     * @var string
     */
    private $enName;

    /**
     * @var string
     */
    private $nativeName;

    /**
     * @var string
     */
    private $abbreviation;

    /**
     * @var string
     */
    private $countryId;

    /**
     * @var integer
     */
    private $timezone;

    /**
     * @var string
     */
    private $height;

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
    private $sorting;

    /**
     * @var integer
     */
    private $popular;

    /**
     * @var string
     */
    private $bdCityName;

    /**
     * @var integer
     */
    private $nlevel;

    /**
     * @var integer
     */
    private $ifupdate;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set provinceSc
     *
     * @param string $provinceSc
     * @return I18nCity
     */
    public function setProvinceSc($provinceSc)
    {
        $this->provinceSc = $provinceSc;
    
        return $this;
    }

    /**
     * Get provinceSc
     *
     * @return string 
     */
    public function getProvinceSc()
    {
        return $this->provinceSc;
    }

    /**
     * Set parentSc
     *
     * @param string $parentSc
     * @return I18nCity
     */
    public function setParentSc($parentSc)
    {
        $this->parentSc = $parentSc;
    
        return $this;
    }

    /**
     * Get parentSc
     *
     * @return string 
     */
    public function getParentSc()
    {
        return $this->parentSc;
    }

    /**
     * Set syscode
     *
     * @param string $syscode
     * @return I18nCity
     */
    public function setSyscode($syscode)
    {
        $this->syscode = $syscode;
    
        return $this;
    }

    /**
     * Get syscode
     *
     * @return string 
     */
    public function getSyscode()
    {
        return $this->syscode;
    }

    /**
     * Set stateId
     *
     * @param string $stateId
     * @return I18nCity
     */
    public function setStateId($stateId)
    {
        $this->stateId = $stateId;
    
        return $this;
    }

    /**
     * Get stateId
     *
     * @return string 
     */
    public function getStateId()
    {
        return $this->stateId;
    }

    /**
     * Set enName
     *
     * @param string $enName
     * @return I18nCity
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
     * Set nativeName
     *
     * @param string $nativeName
     * @return I18nCity
     */
    public function setNativeName($nativeName)
    {
        $this->nativeName = $nativeName;
    
        return $this;
    }

    /**
     * Get nativeName
     *
     * @return string 
     */
    public function getNativeName()
    {
        return $this->nativeName;
    }

    /**
     * Set abbreviation
     *
     * @param string $abbreviation
     * @return I18nCity
     */
    public function setAbbreviation($abbreviation)
    {
        $this->abbreviation = $abbreviation;
    
        return $this;
    }

    /**
     * Get abbreviation
     *
     * @return string 
     */
    public function getAbbreviation()
    {
        return $this->abbreviation;
    }

    /**
     * Set countryId
     *
     * @param string $countryId
     * @return I18nCity
     */
    public function setCountryId($countryId)
    {
        $this->countryId = $countryId;
    
        return $this;
    }

    /**
     * Get countryId
     *
     * @return string 
     */
    public function getCountryId()
    {
        return $this->countryId;
    }

    /**
     * Set timezone
     *
     * @param integer $timezone
     * @return I18nCity
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;
    
        return $this;
    }

    /**
     * Get timezone
     *
     * @return integer 
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * Set height
     *
     * @param string $height
     * @return I18nCity
     */
    public function setHeight($height)
    {
        $this->height = $height;
    
        return $this;
    }

    /**
     * Get height
     *
     * @return string 
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     * @return I18nCity
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
     * @return I18nCity
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
     * Set sorting
     *
     * @param integer $sorting
     * @return I18nCity
     */
    public function setSorting($sorting)
    {
        $this->sorting = $sorting;
    
        return $this;
    }

    /**
     * Get sorting
     *
     * @return integer 
     */
    public function getSorting()
    {
        return $this->sorting;
    }

    /**
     * Set popular
     *
     * @param integer $popular
     * @return I18nCity
     */
    public function setPopular($popular)
    {
        $this->popular = $popular;
    
        return $this;
    }

    /**
     * Get popular
     *
     * @return integer 
     */
    public function getPopular()
    {
        return $this->popular;
    }

    /**
     * Set bdCityName
     *
     * @param string $bdCityName
     * @return I18nCity
     */
    public function setBdCityName($bdCityName)
    {
        $this->bdCityName = $bdCityName;
    
        return $this;
    }

    /**
     * Get bdCityName
     *
     * @return string 
     */
    public function getBdCityName()
    {
        return $this->bdCityName;
    }

    /**
     * Set nlevel
     *
     * @param integer $nlevel
     * @return I18nCity
     */
    public function setNlevel($nlevel)
    {
        $this->nlevel = $nlevel;
    
        return $this;
    }

    /**
     * Get nlevel
     *
     * @return integer 
     */
    public function getNlevel()
    {
        return $this->nlevel;
    }

    /**
     * Set ifupdate
     *
     * @param integer $ifupdate
     * @return I18nCity
     */
    public function setIfupdate($ifupdate)
    {
        $this->ifupdate = $ifupdate;
    
        return $this;
    }

    /**
     * Get ifupdate
     *
     * @return integer 
     */
    public function getIfupdate()
    {
        return $this->ifupdate;
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
