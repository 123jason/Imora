<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrangeNonTempCard
 */
class OrangeNonTempCard
{
    /**
     * @var integer
     */
    private $cardType;

    /**
     * @var string
     */
    private $cardName;

    /**
     * @var integer
     */
    private $personnum;

    /**
     * @var integer
     */
    private $createtime;

    /**
     * @var integer
     */
    private $tempId;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set cardType
     *
     * @param integer $cardType
     * @return OrangeNonTempCard
     */
    public function setCardType($cardType)
    {
        $this->cardType = $cardType;
    
        return $this;
    }

    /**
     * Get cardType
     *
     * @return integer 
     */
    public function getCardType()
    {
        return $this->cardType;
    }

    /**
     * Set cardName
     *
     * @param string $cardName
     * @return OrangeNonTempCard
     */
    public function setCardName($cardName)
    {
        $this->cardName = $cardName;
    
        return $this;
    }

    /**
     * Get cardName
     *
     * @return string 
     */
    public function getCardName()
    {
        return $this->cardName;
    }

    /**
     * Set personnum
     *
     * @param integer $personnum
     * @return OrangeNonTempCard
     */
    public function setPersonnum($personnum)
    {
        $this->personnum = $personnum;
    
        return $this;
    }

    /**
     * Get personnum
     *
     * @return integer 
     */
    public function getPersonnum()
    {
        return $this->personnum;
    }

    /**
     * Set createtime
     *
     * @param integer $createtime
     * @return OrangeNonTempCard
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
     * Set tempId
     *
     * @param integer $tempId
     * @return OrangeNonTempCard
     */
    public function setTempId($tempId)
    {
        $this->tempId = $tempId;
    
        return $this;
    }

    /**
     * Get tempId
     *
     * @return integer 
     */
    public function getTempId()
    {
        return $this->tempId;
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
