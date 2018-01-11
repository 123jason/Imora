<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * I18nStateProvince
 */
class I18nStateProvince
{
    /**
     * @var string
     */
    private $countryId;

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
    private $syscode;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set countryId
     *
     * @param string $countryId
     * @return I18nStateProvince
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
     * Set enName
     *
     * @param string $enName
     * @return I18nStateProvince
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
     * @return I18nStateProvince
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
     * @return I18nStateProvince
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
     * Set syscode
     *
     * @param string $syscode
     * @return I18nStateProvince
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
