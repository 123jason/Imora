<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AnnualRing
 */
class AnnualRing
{
    /**
     * @var string
     */
    private $ringId;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $contactId;

    /**
     * @var \DateTime
     */
    private $lastContactTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set ringId
     *
     * @param string $ringId
     * @return AnnualRing
     */
    public function setRingId($ringId)
    {
        $this->ringId = $ringId;

        return $this;
    }

    /**
     * Get ringId
     *
     * @return string 
     */
    public function getRingId()
    {
        return $this->ringId;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return AnnualRing
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
     * Set contactId
     *
     * @param string $contactId
     * @return AnnualRing
     */
    public function setContactId($contactId)
    {
        $this->contactId = $contactId;

        return $this;
    }

    /**
     * Get contactId
     *
     * @return string 
     */
    public function getContactId()
    {
        return $this->contactId;
    }

    /**
     * Set lastContactTime
     *
     * @param \DateTime $lastContactTime
     * @return AnnualRing
     */
    public function setLastContactTime($lastContactTime)
    {
        $this->lastContactTime = $lastContactTime;

        return $this;
    }

    /**
     * Get lastContactTime
     *
     * @return \DateTime 
     */
    public function getLastContactTime()
    {
        return $this->lastContactTime;
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
