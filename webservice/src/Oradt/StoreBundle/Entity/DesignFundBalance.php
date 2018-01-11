<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DesignFundBalance
 */
class DesignFundBalance
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var integer
     */
    private $number;

    /**
     * @var boolean
     */
    private $unitId;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return DesignFundBalance
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
     * Set number
     *
     * @param integer $number
     * @return DesignFundBalance
     */
    public function setNumber($number)
    {
        $this->number = $number;
    
        return $this;
    }

    /**
     * Get number
     *
     * @return integer 
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set unitId
     *
     * @param boolean $unitId
     * @return DesignFundBalance
     */
    public function setUnitId($unitId)
    {
        $this->unitId = $unitId;
    
        return $this;
    }

    /**
     * Get unitId
     *
     * @return boolean 
     */
    public function getUnitId()
    {
        return $this->unitId;
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
