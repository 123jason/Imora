<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountBasicCategory
 */
class AccountBasicCategory
{


    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $oriName;

    /**
     * @var integer
     */
    private $createTime;

    /**
     * @var integer
     */
    private $modifyTime;

    /**
 * @var integer
 */
    private $status;

    /**
     * @var integer
     */
    private $type;

    /**
     * @var integer
     */
    private $id;

    /**
     * Set name
     *
     * @param string $name
     * @return AccountBasicCategory
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
     * Set oriName
     *
     * @param string $oriName
     * @return AccountBasicCategory
     */
    public function setOriName($oriName)
    {
        $this->oriName = $oriName;
    
        return $this;
    }

    /**
     * Get oriName
     *
     * @return string 
     */
    public function getOriName()
    {
        return $this->oriName;
    }

    /**
     * Set createTime
     *
     * @param integer $createTime
     * @return AccountBasicCategory
     */
    public function setCreateTime($createTime)
    {
        $this->createTime = $createTime;
    
        return $this;
    }

    /**
     * Get createTime
     *
     * @return integer 
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * Set modifyTime
     *
     * @param integer $modifyTime
     * @return AccountBasicCategory
     */
    public function setModifyTime($modifyTime)
    {
        $this->modifyTime = $modifyTime;
    
        return $this;
    }

    /**
     * Get modifyTime
     *
     * @return integer 
     */
    public function getModifyTime()
    {
        return $this->modifyTime;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return AccountBasicCategory
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
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
     * @var integer
     */
    private $sorting;

    /**
     * @var string
     */
    private $key;


    /**
     * Set sorting
     *
     * @param integer $sorting
     * @return AccountBasicCategory
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
     * Set type
     *
     * @param integer $type
     * @return AccountBasicCategory
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set key
     *
     * @param string $key
     * @return AccountBasicCategory
     */
    public function setKey($key)
    {
        $this->key = $key;
    
        return $this;
    }

    /**
     * Get key
     *
     * @return string 
     */
    public function getKey()
    {
        return $this->key;
    }
    /**
     * @var string
     */
    private $adminId;


    /**
     * Set adminId
     *
     * @param string $adminId
     * @return AccountBasicCategory
     */
    public function setAdminId($adminId)
    {
        $this->adminId = $adminId;
    
        return $this;
    }

    /**
     * Get adminId
     *
     * @return string 
     */
    public function getAdminId()
    {
        return $this->adminId;
    }
    /**
     * @var string
     */
    private $keyworld;


    /**
     * Set keyworld
     *
     * @param string $keyworld
     * @return AccountBasicCategory
     */
    public function setKeyworld($keyworld)
    {
        $this->keyworld = $keyworld;
    
        return $this;
    }

    /**
     * Get keyworld
     *
     * @return string 
     */
    public function getKeyworld()
    {
        return $this->keyworld;
    }
    /**
     * @var string
     */
    private $categoryId;

    /**
     * @var string
     */
    private $parentId;

    /**
     * @var string
     */
    private $keyword;


    /**
     * Set categoryId
     *
     * @param string $categoryId
     * @return AccountBasicCategory
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
    
        return $this;
    }

    /**
     * Get categoryId
     *
     * @return string 
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * Set parentId
     *
     * @param string $parentId
     * @return AccountBasicCategory
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
    
        return $this;
    }

    /**
     * Get parentId
     *
     * @return string 
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Set keyword
     *
     * @param string $keyword
     * @return AccountBasicCategory
     */
    public function setKeyword($keyword)
    {
        $this->keyword = $keyword;
    
        return $this;
    }

    /**
     * Get keyword
     *
     * @return string 
     */
    public function getKeyword()
    {
        return $this->keyword;
    }
}
