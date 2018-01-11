<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrangeMembershipBin
 */
class OrangeMembershipBin
{
    /**
     * @var integer
     */
    private $tempId;

    /**
     * @var string
     */
    private $binCode;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set tempId
     *
     * @param integer $tempId
     * @return OrangeMembershipBin
     */
    public function setTempId($tempId)
    {
        $this->tempId = $tempId;
    
        return $this;
    }

    /**
     * Get tempId
     *
     * @return integer 
     */
    public function getTempId()
    {
        return $this->tempId;
    }

    /**
     * Set binCode
     *
     * @param string $binCode
     * @return OrangeMembershipBin
     */
    public function setBinCode($binCode)
    {
        $this->binCode = $binCode;
    
        return $this;
    }

    /**
     * Get binCode
     *
     * @return string 
     */
    public function getBinCode()
    {
        return $this->binCode;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return OrangeMembershipBin
     */
    public function setCreatedTime($createdTime)
    {
        $this->createdTime = $createdTime;
    
        return $this;
    }

    /**
     * Get createdTime
     *
     * @return integer 
     */
    public function getCreatedTime()
    {
        return $this->createdTime;
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
