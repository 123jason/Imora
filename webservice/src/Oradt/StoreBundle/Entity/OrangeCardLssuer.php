<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrangeCardLssuer
 */
class OrangeCardLssuer
{
    /**
     * @var integer
     */
    private $cardtypeid;

    /**
     * @var string
     */
    private $lssuerName;

    /**
     * @var string
     */
    private $simplename;

    /**
     * @var string
     */
    private $lssuerNumber;

    /**
     * @var integer
     */
    private $iscoop;

    /**
     * @var string
     */
    private $attribute;

    /**
     * @var integer
     */
    private $createtime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set cardtypeid
     *
     * @param integer $cardtypeid
     * @return OrangeCardLssuer
     */
    public function setCardtypeid($cardtypeid)
    {
        $this->cardtypeid = $cardtypeid;
    
        return $this;
    }

    /**
     * Get cardtypeid
     *
     * @return integer 
     */
    public function getCardtypeid()
    {
        return $this->cardtypeid;
    }

    /**
     * Set lssuerName
     *
     * @param string $lssuerName
     * @return OrangeCardLssuer
     */
    public function setLssuerName($lssuerName)
    {
        $this->lssuerName = $lssuerName;
    
        return $this;
    }

    /**
     * Get lssuerName
     *
     * @return string 
     */
    public function getLssuerName()
    {
        return $this->lssuerName;
    }

    /**
     * Set simplename
     *
     * @param string $simplename
     * @return OrangeCardLssuer
     */
    public function setSimplename($simplename)
    {
        $this->simplename = $simplename;
    
        return $this;
    }

    /**
     * Get simplename
     *
     * @return string 
     */
    public function getSimplename()
    {
        return $this->simplename;
    }

    /**
     * Set lssuerNumber
     *
     * @param string $lssuerNumber
     * @return OrangeCardLssuer
     */
    public function setLssuerNumber($lssuerNumber)
    {
        $this->lssuerNumber = $lssuerNumber;
    
        return $this;
    }

    /**
     * Get lssuerNumber
     *
     * @return string 
     */
    public function getLssuerNumber()
    {
        return $this->lssuerNumber;
    }

    /**
     * Set iscoop
     *
     * @param integer $iscoop
     * @return OrangeCardLssuer
     */
    public function setIscoop($iscoop)
    {
        $this->iscoop = $iscoop;
    
        return $this;
    }

    /**
     * Get iscoop
     *
     * @return integer 
     */
    public function getIscoop()
    {
        return $this->iscoop;
    }

    /**
     * Set attribute
     *
     * @param string $attribute
     * @return OrangeCardLssuer
     */
    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;
    
        return $this;
    }

    /**
     * Get attribute
     *
     * @return string 
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * Set createtime
     *
     * @param integer $createtime
     * @return OrangeCardLssuer
     */
    public function setCreatetime($createtime)
    {
        $this->createtime = $createtime;
    
        return $this;
    }

    /**
     * Get createtime
     *
     * @return integer 
     */
    public function getCreatetime()
    {
        return $this->createtime;
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
