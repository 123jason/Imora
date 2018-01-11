<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IntroducationMap
 */
class IntroducationMap
{
    /**
     * @var string
     */
    private $mapId;

    /**
     * @var string
     */
    private $introducerUid;

    /**
     * @var string
     */
    private $fromUid;

    /**
     * @var integer
     */
    private $fromCardId;

    /**
     * @var string
     */
    private $toUid;

    /**
     * @var integer
     */
    private $toCardId;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var string
     */
    private $status;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set mapId
     *
     * @param string $mapId
     * @return IntroducationMap
     */
    public function setMapId($mapId)
    {
        $this->mapId = $mapId;

        return $this;
    }

    /**
     * Get mapId
     *
     * @return string 
     */
    public function getMapId()
    {
        return $this->mapId;
    }

    /**
     * Set introducerUid
     *
     * @param string $introducerUid
     * @return IntroducationMap
     */
    public function setIntroducerUid($introducerUid)
    {
        $this->introducerUid = $introducerUid;

        return $this;
    }

    /**
     * Get introducerUid
     *
     * @return string 
     */
    public function getIntroducerUid()
    {
        return $this->introducerUid;
    }

    /**
     * Set fromUid
     *
     * @param string $fromUid
     * @return IntroducationMap
     */
    public function setFromUid($fromUid)
    {
        $this->fromUid = $fromUid;

        return $this;
    }

    /**
     * Get fromUid
     *
     * @return string 
     */
    public function getFromUid()
    {
        return $this->fromUid;
    }

    /**
     * Set fromCardId
     *
     * @param integer $fromCardId
     * @return IntroducationMap
     */
    public function setFromCardId($fromCardId)
    {
        $this->fromCardId = $fromCardId;

        return $this;
    }

    /**
     * Get fromCardId
     *
     * @return integer 
     */
    public function getFromCardId()
    {
        return $this->fromCardId;
    }

    /**
     * Set toUid
     *
     * @param string $toUid
     * @return IntroducationMap
     */
    public function setToUid($toUid)
    {
        $this->toUid = $toUid;

        return $this;
    }

    /**
     * Get toUid
     *
     * @return string 
     */
    public function getToUid()
    {
        return $this->toUid;
    }

    /**
     * Set toCardId
     *
     * @param integer $toCardId
     * @return IntroducationMap
     */
    public function setToCardId($toCardId)
    {
        $this->toCardId = $toCardId;

        return $this;
    }

    /**
     * Get toCardId
     *
     * @return integer 
     */
    public function getToCardId()
    {
        return $this->toCardId;
    }

    /**
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return IntroducationMap
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
     * Set status
     *
     * @param string $status
     * @return IntroducationMap
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
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
