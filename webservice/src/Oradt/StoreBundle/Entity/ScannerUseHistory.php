<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ScannerUseHistory
 */
class ScannerUseHistory
{
    /**
     * @var string
     */
    private $scannerId;

    /**
     * @var integer
     */
    private $type;

    /**
     * @var integer
     */
    private $startime;

    /**
     * @var integer
     */
    private $endtime;

    /**
     * @var string
     */
    private $bizId;

    /**
     * @var string
     */
    private $bizName;

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $outAdminId;

    /**
     * @var string
     */
    private $outAdminName;

    /**
     * @var string
     */
    private $inAdminId;

    /**
     * @var string
     */
    private $inAdminName;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set scannerId
     *
     * @param string $scannerId
     * @return ScannerUseHistory
     */
    public function setScannerId($scannerId)
    {
        $this->scannerId = $scannerId;
    
        return $this;
    }

    /**
     * Get scannerId
     *
     * @return string 
     */
    public function getScannerId()
    {
        return $this->scannerId;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return ScannerUseHistory
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set startime
     *
     * @param integer $startime
     * @return ScannerUseHistory
     */
    public function setStartime($startime)
    {
        $this->startime = $startime;
    
        return $this;
    }

    /**
     * Get startime
     *
     * @return integer 
     */
    public function getStartime()
    {
        return $this->startime;
    }

    /**
     * Set endtime
     *
     * @param integer $endtime
     * @return ScannerUseHistory
     */
    public function setEndtime($endtime)
    {
        $this->endtime = $endtime;
    
        return $this;
    }

    /**
     * Get endtime
     *
     * @return integer 
     */
    public function getEndtime()
    {
        return $this->endtime;
    }

    /**
     * Set bizId
     *
     * @param string $bizId
     * @return ScannerUseHistory
     */
    public function setBizId($bizId)
    {
        $this->bizId = $bizId;
    
        return $this;
    }

    /**
     * Get bizId
     *
     * @return string 
     */
    public function getBizId()
    {
        return $this->bizId;
    }

    /**
     * Set bizName
     *
     * @param string $bizName
     * @return ScannerUseHistory
     */
    public function setBizName($bizName)
    {
        $this->bizName = $bizName;
    
        return $this;
    }

    /**
     * Get bizName
     *
     * @return string 
     */
    public function getBizName()
    {
        return $this->bizName;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return ScannerUseHistory
     */
    public function setAddress($address)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set outAdminId
     *
     * @param string $outAdminId
     * @return ScannerUseHistory
     */
    public function setOutAdminId($outAdminId)
    {
        $this->outAdminId = $outAdminId;
    
        return $this;
    }

    /**
     * Get outAdminId
     *
     * @return string 
     */
    public function getOutAdminId()
    {
        return $this->outAdminId;
    }

    /**
     * Set outAdminName
     *
     * @param string $outAdminName
     * @return ScannerUseHistory
     */
    public function setOutAdminName($outAdminName)
    {
        $this->outAdminName = $outAdminName;
    
        return $this;
    }

    /**
     * Get outAdminName
     *
     * @return string 
     */
    public function getOutAdminName()
    {
        return $this->outAdminName;
    }

    /**
     * Set inAdminId
     *
     * @param string $inAdminId
     * @return ScannerUseHistory
     */
    public function setInAdminId($inAdminId)
    {
        $this->inAdminId = $inAdminId;
    
        return $this;
    }

    /**
     * Get inAdminId
     *
     * @return string 
     */
    public function getInAdminId()
    {
        return $this->inAdminId;
    }

    /**
     * Set inAdminName
     *
     * @param string $inAdminName
     * @return ScannerUseHistory
     */
    public function setInAdminName($inAdminName)
    {
        $this->inAdminName = $inAdminName;
    
        return $this;
    }

    /**
     * Get inAdminName
     *
     * @return string 
     */
    public function getInAdminName()
    {
        return $this->inAdminName;
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
