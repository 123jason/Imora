<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SnsTrendsResource
 */
class SnsTrendsResource
{    
    /**
     * @var string
     */
    private $trendsId;

    /**
     * @var string
     */
    private $resId;

    /**
     * @var string
     */
    private $resPath;

    /**
     * @var string
     */
    private $smallPath;

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
     * Set trendsId
     *
     * @param string $trendsId
     * @return SnsTrendsResource
     */
    public function setTrendsId($trendsId)
    {
        $this->trendsId = $trendsId;
    
        return $this;
    }

    /**
     * Get trendsId
     *
     * @return string 
     */
    public function getTrendsId()
    {
        return $this->trendsId;
    }

    /**
     * Set resId
     *
     * @param string $resId
     * @return SnsTrendsResource
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
     * @return SnsTrendsResource
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
     * Set smallPath
     *
     * @param string $smallPath
     * @return SnsTrendsResource
     */
    public function setSmallPath($smallPath)
    {
        $this->smallPath = $smallPath;
    
        return $this;
    }

    /**
     * Get smallPath
     *
     * @return string 
     */
    public function getSmallPath()
    {
        return $this->smallPath;
    }

    /**
     * Set sorting
     *
     * @param integer $sorting
     * @return SnsTrendsResource
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
     * @return SnsTrendsResource
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
