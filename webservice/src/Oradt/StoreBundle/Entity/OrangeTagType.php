<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrangeTagType
 */
class OrangeTagType
{
    /**
     * @var integer
     */
    private $cardTypeId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set cardTypeId
     *
     * @param integer $cardTypeId
     * @return OrangeTagType
     */
    public function setCardTypeId($cardTypeId)
    {
        $this->cardTypeId = $cardTypeId;
    
        return $this;
    }

    /**
     * Get cardTypeId
     *
     * @return integer 
     */
    public function getCardTypeId()
    {
        return $this->cardTypeId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return OrangeTagType
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return OrangeTagType
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
