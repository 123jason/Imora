<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ScanCardIntegrateinfo
 */
class ScanCardIntegrateinfo
{
    /**
     * @var string
     */
    private $cardId;

    /**
     * @var string
     */
    private $fieldType;

    /**
     * @var string
     */
    private $fieldValue;

    /**
     * @var string
     */
    private $handleState;

    /**
     * @var string
     */
    private $emplId;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set cardId
     *
     * @param string $cardId
     * @return ScanCardIntegrateinfo
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
     * Set fieldType
     *
     * @param string $fieldType
     * @return ScanCardIntegrateinfo
     */
    public function setFieldType($fieldType)
    {
        $this->fieldType = $fieldType;

        return $this;
    }

    /**
     * Get fieldType
     *
     * @return string 
     */
    public function getFieldType()
    {
        return $this->fieldType;
    }

    /**
     * Set fieldValue
     *
     * @param string $fieldValue
     * @return ScanCardIntegrateinfo
     */
    public function setFieldValue($fieldValue)
    {
        $this->fieldValue = $fieldValue;

        return $this;
    }

    /**
     * Get fieldValue
     *
     * @return string 
     */
    public function getFieldValue()
    {
        return $this->fieldValue;
    }

    /**
     * Set handleState
     *
     * @param string $handleState
     * @return ScanCardIntegrateinfo
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
     * @return ScanCardIntegrateinfo
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
