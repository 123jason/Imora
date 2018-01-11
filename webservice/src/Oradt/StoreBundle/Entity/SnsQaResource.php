<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SnsQaResource
 */
class SnsQaResource
{
    /**
     * @var string
     */
    private $showId;

    /**
     * @var string
     */
    private $resId;

    /**
     * @var string
     */
    private $resPath;

    /**
     * @var integer
     */
    private $sorting;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set showId
     *
     * @param string $showId
     * @return SnsQaResource
     */
    public function setShowId($showId)
    {
        $this->showId = $showId;
    
        return $this;
    }

    /**
     * Get showId
     *
     * @return string 
     */
    public function getShowId()
    {
        return $this->showId;
    }

    /**
     * Set resId
     *
     * @param string $resId
     * @return SnsQaResource
     */
    public function setResId($resId)
    {
        $this->resId = $resId;
    
        return $this;
    }

    /**
     * Get resId
     *
     * @return string 
     */
    public function getResId()
    {
        return $this->resId;
    }

    /**
     * Set resPath
     *
     * @param string $resPath
     * @return SnsQaResource
     */
    public function setResPath($resPath)
    {
        $this->resPath = $resPath;
    
        return $this;
    }

    /**
     * Get resPath
     *
     * @return string 
     */
    public function getResPath()
    {
        return $this->resPath;
    }

    /**
     * Set sorting
     *
     * @param integer $sorting
     * @return SnsQaResource
     */
    public function setSorting($sorting)
    {
        $this->sorting = $sorting;
    
        return $this;
    }

    /**
     * Get sorting
     *
     * @return integer 
     */
    public function getSorting()
    {
        return $this->sorting;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return SnsQaResource
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
    /**
     * @var string
     */
    private $resSmall;


    /**
     * Set resSmall
     *
     * @param string $resSmall
     * @return SnsQaResource
     */
    public function setResSmall($resSmall)
    {
        $this->resSmall = $resSmall;
    
        return $this;
    }

    /**
     * Get resSmall
     *
     * @return string 
     */
    public function getResSmall()
    {
        return $this->resSmall;
    }
}
