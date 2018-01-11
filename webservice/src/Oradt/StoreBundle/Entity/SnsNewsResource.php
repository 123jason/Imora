<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SnsNewsResource
 */
class SnsNewsResource
{
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
     * @var string
     */
    private $newsId;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set resId
     *
     * @param string $resId
     * @return SnsNewsResource
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
     * @return SnsNewsResource
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
     * @return SnsNewsResource
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
     * Set newsId
     *
     * @param string $newsId
     * @return SnsNewsResource
     */
    public function setNewsId($newsId)
    {
        $this->newsId = $newsId;
    
        return $this;
    }

    /**
     * Get newsId
     *
     * @return string 
     */
    public function getNewsId()
    {
        return $this->newsId;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return SnsNewsResource
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
