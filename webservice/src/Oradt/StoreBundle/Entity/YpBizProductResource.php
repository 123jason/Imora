<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * YpBizProductResource
 */
class YpBizProductResource
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
     * @var string
     */
    private $productId;

    /**
     * @var integer
     */
    private $sorting;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var string
     */
    private $resType;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set resId
     *
     * @param string $resId
     * @return YpBizProductResource
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
     * @return YpBizProductResource
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
     * Set productId
     *
     * @param string $productId
     * @return YpBizProductResource
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;

        return $this;
    }

    /**
     * Get productId
     *
     * @return string 
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * Set sorting
     *
     * @param integer $sorting
     * @return YpBizProductResource
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
     * @param \DateTime $createdTime
     * @return YpBizProductResource
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
     * Set resType
     *
     * @param string $resType
     * @return YpBizProductResource
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
