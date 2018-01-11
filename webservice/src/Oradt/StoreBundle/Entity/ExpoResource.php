<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExpoResource
 */
class ExpoResource
{
  
	private $bizId;
    /**
     * @var string
     */
    private $expoId;

    /**
     * @var string
     */
    private $resPath;

    /**
     * @var string
     */
    private $title;

    /**
     * @var integer
     */
    private $sorting;

    /**
     * @var string
     */
    private $resType;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


  
    /**
     * Set bizId
     *
     * @param string $bizId
     * @return ExpoResource
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
     * Set expoId
     *
     * @param string $expoId
     * @return ExpoResource
     */
    public function setExpoId($expoId)
    {
        $this->expoId = $expoId;
    
        return $this;
    }

    /**
     * Get expoId
     *
     * @return string 
     */
    public function getExpoId()
    {
        return $this->expoId;
    }

    /**
     * Set resPath
     *
     * @param string $resPath
     * @return ExpoResource
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
     * Set title
     *
     * @param string $title
     * @return ExpoResource
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set sorting
     *
     * @param integer $sorting
     * @return ExpoResource
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
     * Set resType
     *
     * @param string $resType
     * @return ExpoResource
     */
    public function setResType($resType)
    {
        $this->resType = $resType;
    
        return $this;
    }

    /**
     * Get resType
     *
     * @return string 
     */
    public function getResType()
    {
        return $this->resType;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return ExpoResource
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
