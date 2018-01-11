<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DesignProductDetail
 */
class DesignProductDetail
{
    /**
     * @var string
     */
    private $productId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $type;

    /**
     * @var string
     */
    private $price;

    /**
     * @var int
     */
    private $unitId;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $author;

    /**
     * @var integer
     */
    private $size;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $binUrl;

    /**
     * @var string
     */
    private $styleId;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $sales;

    /**
     * @var string
     */
    private $explains;

    /**
     * @var string
     */
    private $designFile;

    /**
     * @var int
     */
    private $isAuth;

    /**
     * @var string
     */
    private $checkUserid;

    /**
     * @var int
     */
    private $status;

    /**
     * @var \DateTime
     */
    private $updateTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set productId
     *
     * @param string $productId
     * @return DesignProductDetail
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
     * Set name
     *
     * @param string $name
     * @return DesignProductDetail
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
     * Set type
     *
     * @param int $type
     * @return DesignProductDetail
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return int 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return DesignProductDetail
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
     * Set unitId
     *
     * @param int $unitId
     * @return DesignProductDetail
     */
    public function setUnitId($unitId)
    {
        $this->unitId = $unitId;
    
        return $this;
    }

    /**
     * Get unitId
     *
     * @return int 
     */
    public function getUnitId()
    {
        return $this->unitId;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return DesignProductDetail
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
     * Set author
     *
     * @param string $author
     * @return DesignProductDetail
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    
        return $this;
    }

    /**
     * Get author
     *
     * @return string 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set size
     *
     * @param integer $size
     * @return DesignProductDetail
     */
    public function setSize($size)
    {
        $this->size = $size;
    
        return $this;
    }

    /**
     * Get size
     *
     * @return integer 
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return DesignProductDetail
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set binUrl
     *
     * @param string $binUrl
     * @return DesignProductDetail
     */
    public function setBinUrl($binUrl)
    {
        $this->binUrl = $binUrl;
    
        return $this;
    }

    /**
     * Get binUrl
     *
     * @return string 
     */
    public function getBinUrl()
    {
        return $this->binUrl;
    }

    /**
     * Set styleId
     *
     * @param string $styleId
     * @return DesignProductDetail
     */
    public function setStyleId($styleId)
    {
        $this->styleId = $styleId;
    
        return $this;
    }

    /**
     * Get styleId
     *
     * @return string 
     */
    public function getStyleId()
    {
        return $this->styleId;
    }

    /**
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return DesignProductDetail
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
     * Set sales
     *
     * @param integer $sales
     * @return DesignProductDetail
     */
    public function setSales($sales)
    {
        $this->sales = $sales;
    
        return $this;
    }

    /**
     * Get sales
     *
     * @return integer 
     */
    public function getSales()
    {
        return $this->sales;
    }

    /**
     * Set explains
     *
     * @param string $explains
     * @return DesignProductDetail
     */
    public function setExplains($explains)
    {
        $this->explains = $explains;
    
        return $this;
    }

    /**
     * Get explains
     *
     * @return string 
     */
    public function getExplains()
    {
        return $this->explains;
    }

    /**
     * Set designFile
     *
     * @param string $designFile
     * @return DesignProductDetail
     */
    public function setDesignFile($designFile)
    {
        $this->designFile = $designFile;
    
        return $this;
    }

    /**
     * Get designFile
     *
     * @return string 
     */
    public function getDesignFile()
    {
        return $this->designFile;
    }

    /**
     * Set isAuth
     *
     * @param int $isAuth
     * @return DesignProductDetail
     */
    public function setIsAuth($isAuth)
    {
        $this->isAuth = $isAuth;
    
        return $this;
    }

    /**
     * Get isAuth
     *
     * @return int 
     */
    public function getIsAuth()
    {
        return $this->isAuth;
    }

    /**
     * Set checkUserid
     *
     * @param string $checkUserid
     * @return DesignProductDetail
     */
    public function setCheckUserid($checkUserid)
    {
        $this->checkUserid = $checkUserid;
    
        return $this;
    }

    /**
     * Get checkUserid
     *
     * @return string 
     */
    public function getCheckUserid()
    {
        return $this->checkUserid;
    }

    /**
     * Set status
     *
     * @param int $status
     * @return DesignProductDetail
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return int 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set updateTime
     *
     * @param \DateTime $updateTime
     * @return DesignProductDetail
     */
    public function setUpdateTime($updateTime)
    {
        $this->updateTime = $updateTime;
    
        return $this;
    }

    /**
     * Get updateTime
     *
     * @return \DateTime 
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
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
