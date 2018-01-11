<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * I18nLanguage
 */
class I18nLanguage
{
    /**
     * @var string
     */
    private $syscode;

    /**
     * @var string
     */
    private $isoName;

    /**
     * @var string
     */
    private $status;

    /**
     * @var integer
     */
    private $languageid;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set syscode
     *
     * @param string $syscode
     * @return I18nLanguage
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
     * Set isoName
     *
     * @param string $isoName
     * @return I18nLanguage
     */
    public function setIsoName($isoName)
    {
        $this->isoName = $isoName;
    
        return $this;
    }

    /**
     * Get isoName
     *
     * @return string 
     */
    public function getIsoName()
    {
        return $this->isoName;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return I18nLanguage
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set languageid
     *
     * @param integer $languageid
     * @return I18nLanguage
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
