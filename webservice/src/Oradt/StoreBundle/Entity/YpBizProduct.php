<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * YpBizProduct
 */
class YpBizProduct
{
    /**
     * @var string
     */
    private $productId;

    /**
     * @var string
     */
    private $bizId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $model;

    /**
     * @var integer
     */
    private $categoryId;

    /**
     * @var string
     */
    private $info;

    /**
     * @var string
     */
    private $price;

    /**
     * @var string
     */
    private $priceUnit;

    /**
     * @var integer
     */
    private $sorting;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var boolean
     */
    private $languageid;

    /**
     * @var boolean
     */
    private $ifresource;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set productId
     *
     * @param string $productId
     * @return YpBizProduct
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
     * Set bizId
     *
     * @param string $bizId
     * @return YpBizProduct
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
     * Set name
     *
     * @param string $name
     * @return YpBizProduct
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set model
     *
     * @param string $model
     * @return YpBizProduct
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return string 
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set categoryId
     *
     * @param integer $categoryId
     * @return YpBizProduct
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    /**
     * Get categoryId
     *
     * @return integer 
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * Set info
     *
     * @param string $info
     * @return YpBizProduct
     */
    public function setInfo($info)
    {
        $this->info = $info;

        return $this;
    }

    /**
     * Get info
     *
     * @return string 
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return YpBizProduct
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set priceUnit
     *
     * @param string $priceUnit
     * @return YpBizProduct
     */
    public function setPriceUnit($priceUnit)
    {
        $this->priceUnit = $priceUnit;

        return $this;
    }

    /**
     * Get priceUnit
     *
     * @return string 
     */
    public function getPriceUnit()
    {
        return $this->priceUnit;
    }

    /**
     * Set sorting
     *
     * @param integer $sorting
     * @return YpBizProduct
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
     * @return YpBizProduct
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
     * Set languageid
     *
     * @param boolean $languageid
     * @return YpBizProduct
     */
    public function setLanguageid($languageid)
    {
        $this->languageid = $languageid;

        return $this;
    }

    /**
     * Get languageid
     *
     * @return boolean 
     */
    public function getLanguageid()
    {
        return $this->languageid;
    }

    /**
     * Set ifresource
     *
     * @param boolean $ifresource
     * @return YpBizProduct
     */
    public function setIfresource($ifresource)
    {
        $this->ifresource = $ifresource;

        return $this;
    }

    /**
     * Get ifresource
     *
     * @return boolean 
     */
    public function getIfresource()
    {
        return $this->ifresource;
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
