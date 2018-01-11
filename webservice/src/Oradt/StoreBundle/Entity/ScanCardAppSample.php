<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ScanCardAppSample
 */
class ScanCardAppSample
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
    private $emplId;

    /**
     * @var string
     */
    private $sampleSign;

    /**
     * @var \DateTime
     */
    private $handleTime;

    private $origin;

    /**
     * Set origin
     *
     * @param string $origin
     * @return ScanCardAppSample
     */
    public function setOrigin($origin)
    {
        $this->origin = $origin;
    
        return $this;
    }

    /**
     * Get origin
     *
     * @return string 
     */
    public function getOrigin()
    {
        return $this->origin;
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
     * Set cardId
     *
     * @param string $cardId
     * @return ScanCardAppSample
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
     * @return ScanCardAppSample
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
     * Set sampleSign
     *
     * @param string $sampleSign
     * @return ScanCardAppSample
     */
    public function setSampleSign($sampleSign)
    {
        $this->sampleSign = $sampleSign;
    
        return $this;
    }

    /**
     * Get sampleSign
     *
     * @return string 
     */
    public function getSampleSign()
    {
        return $this->sampleSign;
    }

    /**
     * Set handleTime
     *
     * @param \DateTime $handleTime
     * @return ScanCardAppSample
     */
    public function setHandleTime($handleTime)
    {
        $this->handleTime = $handleTime;
    
        return $this;
    }

    /**
     * Get handleTime
     *
     * @return \DateTime 
     */
    public function getHandleTime()
    {
        return $this->handleTime;
    }
}
