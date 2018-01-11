<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MarkPointHandleInfo
 */
class MarkPointHandleInfo
{
    /**
     * @var string
     */
    private $cardId;

    /**
     * @var string
     */
    private $emplId;

    /**
     * @var string
     */
    private $handleState;

    /**
     * @var boolean
     */
    private $isLock;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var \DateTime
     */
    private $handledTime;

    /**
     * @var boolean
     */
    private $ifupdate;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set cardId
     *
     * @param string $cardId
     * @return MarkPointHandleInfo
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
     * Set emplId
     *
     * @param string $emplId
     * @return MarkPointHandleInfo
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
     * Set handleState
     *
     * @param string $handleState
     * @return MarkPointHandleInfo
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
     * Set isLock
     *
     * @param boolean $isLock
     * @return MarkPointHandleInfo
     */
    public function setIsLock($isLock)
    {
        $this->isLock = $isLock;

        return $this;
    }

    /**
     * Get isLock
     *
     * @return boolean 
     */
    public function getIsLock()
    {
        return $this->isLock;
    }

    /**
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return MarkPointHandleInfo
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
     * Set handledTime
     *
     * @param \DateTime $handledTime
     * @return MarkPointHandleInfo
     */
    public function setHandledTime($handledTime)
    {
        $this->handledTime = $handledTime;

        return $this;
    }

    /**
     * Get handledTime
     *
     * @return \DateTime 
     */
    public function getHandledTime()
    {
        return $this->handledTime;
    }

    /**
     * Set ifupdate
     *
     * @param boolean $ifupdate
     * @return MarkPointHandleInfo
     */
    public function setIfupdate($ifupdate)
    {
        $this->ifupdate = $ifupdate;

        return $this;
    }

    /**
     * Get ifupdate
     *
     * @return boolean 
     */
    public function getIfupdate()
    {
        return $this->ifupdate;
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
