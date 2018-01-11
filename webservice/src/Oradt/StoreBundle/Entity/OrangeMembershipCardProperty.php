<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrangeMembershipCardProperty
 */
class OrangeMembershipCardProperty
{
    /**
     * @var integer
     */
    private $tempId;

    /**
     * @var integer
     */
    private $cardUnitsId;

    /**
     * @var integer
     */
    private $cardPropertyId;

    /**
     * @var boolean
     */
    private $isShow;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set tempId
     *
     * @param integer $tempId
     * @return OrangeMembershipCardProperty
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
     * Set cardUnitsId
     *
     * @param integer $cardUnitsId
     * @return OrangeMembershipCardProperty
     */
    public function setCardUnitsId($cardUnitsId)
    {
        $this->cardUnitsId = $cardUnitsId;
    
        return $this;
    }

    /**
     * Get cardUnitsId
     *
     * @return integer 
     */
    public function getCardUnitsId()
    {
        return $this->cardUnitsId;
    }

    /**
     * Set cardPropertyId
     *
     * @param integer $cardPropertyId
     * @return OrangeMembershipCardProperty
     */
    public function setCardPropertyId($cardPropertyId)
    {
        $this->cardPropertyId = $cardPropertyId;
    
        return $this;
    }

    /**
     * Get cardPropertyId
     *
     * @return integer 
     */
    public function getCardPropertyId()
    {
        return $this->cardPropertyId;
    }

    /**
     * Set isShow
     *
     * @param boolean $isShow
     * @return OrangeMembershipCardProperty
     */
    public function setIsShow($isShow)
    {
        $this->isShow = $isShow;
    
        return $this;
    }

    /**
     * Get isShow
     *
     * @return boolean 
     */
    public function getIsShow()
    {
        return $this->isShow;
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
