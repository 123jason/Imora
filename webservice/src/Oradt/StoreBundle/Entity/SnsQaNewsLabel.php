<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SnsQaNewsLabel
 */
class SnsQaNewsLabel
{
    /**
     * @var string
     */
    private $showid;

    /**
     * @var integer
     */
    private $lid;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set showid
     *
     * @param string $showid
     * @return SnsQaNewsLabel
     */
    public function setShowid($showid)
    {
        $this->showid = $showid;
    
        return $this;
    }

    /**
     * Get showid
     *
     * @return string 
     */
    public function getShowid()
    {
        return $this->showid;
    }

    /**
     * Set lid
     *
     * @param integer $lid
     * @return SnsQaNewsLabel
     */
    public function setLid($lid)
    {
        $this->lid = $lid;
    
        return $this;
    }

    /**
     * Get lid
     *
     * @return integer 
     */
    public function getLid()
    {
        return $this->lid;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return SnsQaNewsLabel
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
