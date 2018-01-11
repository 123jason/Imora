<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ScanCardAppItem
 */
class ScanCardAppItem
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $cardId;

    /**
     * @var string
     */
    private $itemType;

    /**
     * @var string
     */
    private $itemValue;

    /**
     * @var string
     */
    private $handleState;

    /**
     * @var string
     */
    private $emplId;


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
     * Set cardId
     *
     * @param string $cardId
     * @return ScanCardAppItem
     */
    public function setCardId($cardId)
    {
        $this->cardId = $cardId;
    
        return $this;
    }

    /**
     * Get cardId
     *
     * @return string 
     */
    public function getCardId()
    {
        return $this->cardId;
    }

    /**
     * Set itemType
     *
     * @param string $itemType
     * @return ScanCardAppItem
     */
    public function setItemType($itemType)
    {
        $this->itemType = $itemType;
    
        return $this;
    }

    /**
     * Get itemType
     *
     * @return string 
     */
    public function getItemType()
    {
        return $this->itemType;
    }

    /**
     * Set itemValue
     *
     * @param string $itemValue
     * @return ScanCardAppItem
     */
    public function setItemValue($itemValue)
    {
        $this->itemValue = $itemValue;
    
        return $this;
    }

    /**
     * Get itemValue
     *
     * @return string 
     */
    public function getItemValue()
    {
        return $this->itemValue;
    }

    /**
     * Set handleState
     *
     * @param string $handleState
     * @return ScanCardAppItem
     */
    public function setHandleState($handleState)
    {
        $this->handleState = $handleState;
    
        return $this;
    }

    /**
     * Get handleState
     *
     * @return string 
     */
    public function getHandleState()
    {
        return $this->handleState;
    }

    /**
     * Set emplId
     *
     * @param string $emplId
     * @return ScanCardAppItem
     */
    public function setEmplId($emplId)
    {
        $this->emplId = $emplId;
    
        return $this;
    }

    /**
     * Get emplId
     *
     * @return string 
     */
    public function getEmplId()
    {
        return $this->emplId;
    }
}
