<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DesignProductStyleDescription
 */
class DesignProductStyleDescription
{
    /**
     * @var string
     */
    private $styleId;

    /**
     * @var integer
     */
    private $languageId;

    /**
     * @var string
     */
    private $styleDescription;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set styleId
     *
     * @param string $styleId
     * @return DesignProductStyleDescription
     */
    public function setStyleId($styleId)
    {
        $this->styleId = $styleId;
    
        return $this;
    }

    /**
     * Get styleId
     *
     * @return string 
     */
    public function getStyleId()
    {
        return $this->styleId;
    }

    /**
     * Set languageId
     *
     * @param integer $languageId
     * @return DesignProductStyleDescription
     */
    public function setLanguageId($languageId)
    {
        $this->languageId = $languageId;
    
        return $this;
    }

    /**
     * Get languageId
     *
     * @return integer 
     */
    public function getLanguageId()
    {
        return $this->languageId;
    }

    /**
     * Set styleDescription
     *
     * @param string $styleDescription
     * @return DesignProductStyleDescription
     */
    public function setStyleDescription($styleDescription)
    {
        $this->styleDescription = $styleDescription;
    
        return $this;
    }

    /**
     * Get styleDescription
     *
     * @return string 
     */
    public function getStyleDescription()
    {
        return $this->styleDescription;
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
