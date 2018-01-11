<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ScanCardDeltaTime
 */
class ScanCardDeltaTime
{
    /**
     * @var string
     */
    private $cardId;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $deltaTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set cardId
     *
     * @param string $cardId
     * @return ScanCardDeltaTime
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
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return ScanCardDeltaTime
     */
    public function setCreatedTime($createdTime)
    {
        $this->createdTime = $createdTime;

        return $this;
    }

    /**
     * Get createdTime
     *
     * @return \DateTime 
     */
    public function getCreatedTime()
    {
        return $this->createdTime;
    }

    /**
     * Set deltaTime
     *
     * @param integer $deltaTime
     * @return ScanCardDeltaTime
     */
    public function setDeltaTime($deltaTime)
    {
        $this->deltaTime = $deltaTime;

        return $this;
    }

    /**
     * Get deltaTime
     *
     * @return integer 
     */
    public function getDeltaTime()
    {
        return $this->deltaTime;
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
