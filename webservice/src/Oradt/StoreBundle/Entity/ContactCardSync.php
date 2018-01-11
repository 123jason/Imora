<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContactCardSync
 */
class ContactCardSync
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $cardUuid;

    /**
     * @var integer
     */
    private $lastModified;

    /**
     * @var string
     */
    private $operation;

    /**
     * @var string
     */
    private $cardType;

    /**
     * @var integer
     */
    private $id;
    
        /**
     * @var integer
     */
    private $iflag;


    /**
     * Set userId
     *
     * @param string $userId
     * @return ContactCardSync
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return string 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set cardUuid
     *
     * @param string $cardUuid
     * @return ContactCardSync
     */
    public function setCardUuid($cardUuid)
    {
        $this->cardUuid = $cardUuid;

        return $this;
    }

    /**
     * Get cardUuid
     *
     * @return string 
     */
    public function getCardUuid()
    {
        return $this->cardUuid;
    }

    /**
     * Set lastModified
     *
     * @param integer $lastModified
     * @return ContactCardSync
     */
    public function setLastModified($lastModified)
    {
        $this->lastModified = $lastModified;

        return $this;
    }

    /**
     * Get lastModified
     *
     * @return integer
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     * Set operation
     *
     * @param string $operation
     * @return ContactCardSync
     */
    public function setOperation($operation)
    {
        $this->operation = $operation;

        return $this;
    }

    /**
     * Get operation
     *
     * @return string 
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * Set cardType
     *
     * @param string $cardType
     * @return ContactCardSync
     */
    public function setCardType($cardType)
    {
        $this->cardType = $cardType;

        return $this;
    }

    /**
     * Get cardType
     *
     * @return string 
     */
    public function getCardType()
    {
        return $this->cardType;
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

    /**
     * Get iflag
     *
     * @return integer 
     */
    public function getIflag()
    {
        return $this->iflag;
    }

    /**
     * Set cardType
     *
     * @param integer $iflag
     * @return ContactCardSync
     */
    public function setIflag($iflag)
    {
        $this->iflag = $iflag;

        return $this;
    }
}
