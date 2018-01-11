<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * I18nCountry
 */
class I18nCountry
{
    /**
     * @var string
     */
    private $isoCode2;

    /**
     * @var string
     */
    private $isoCode3;

    /**
     * @var string
     */
    private $isoNumber;

    /**
     * @var string
     */
    private $isoEnName;

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
    private $continent;

    /**
     * @var string
     */
    private $continentCode;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set isoCode2
     *
     * @param string $isoCode2
     * @return I18nCountry
     */
    public function setIsoCode2($isoCode2)
    {
        $this->isoCode2 = $isoCode2;
    
        return $this;
    }

    /**
     * Get isoCode2
     *
     * @return string 
     */
    public function getIsoCode2()
    {
        return $this->isoCode2;
    }

    /**
     * Set isoCode3
     *
     * @param string $isoCode3
     * @return I18nCountry
     */
    public function setIsoCode3($isoCode3)
    {
        $this->isoCode3 = $isoCode3;
    
        return $this;
    }

    /**
     * Get isoCode3
     *
     * @return string 
     */
    public function getIsoCode3()
    {
        return $this->isoCode3;
    }

    /**
     * Set isoNumber
     *
     * @param string $isoNumber
     * @return I18nCountry
     */
    public function setIsoNumber($isoNumber)
    {
        $this->isoNumber = $isoNumber;
    
        return $this;
    }

    /**
     * Get isoNumber
     *
     * @return string 
     */
    public function getIsoNumber()
    {
        return $this->isoNumber;
    }

    /**
     * Set isoEnName
     *
     * @param string $isoEnName
     * @return I18nCountry
     */
    public function setIsoEnName($isoEnName)
    {
        $this->isoEnName = $isoEnName;
    
        return $this;
    }

    /**
     * Get isoEnName
     *
     * @return string 
     */
    public function getIsoEnName()
    {
        return $this->isoEnName;
    }

    /**
     * Set nativeName
     *
     * @param string $nativeName
     * @return I18nCountry
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
     * @return I18nCountry
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
     * Set continent
     *
     * @param string $continent
     * @return I18nCountry
     */
    public function setContinent($continent)
    {
        $this->continent = $continent;
    
        return $this;
    }

    /**
     * Get continent
     *
     * @return string 
     */
    public function getContinent()
    {
        return $this->continent;
    }

    /**
     * Set continentCode
     *
     * @param string $continentCode
     * @return I18nCountry
     */
    public function setContinentCode($continentCode)
    {
        $this->continentCode = $continentCode;
    
        return $this;
    }

    /**
     * Get continentCode
     *
     * @return string 
     */
    public function getContinentCode()
    {
        return $this->continentCode;
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
