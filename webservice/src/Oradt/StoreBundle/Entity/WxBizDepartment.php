<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WxBizDepartment
 */
class WxBizDepartment
{
    /**
     * @var integer
     */
    private $parentId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $modifyTime;


    /**
     * @var string
     */
    private $ename;

    /**
     * @var string
     */
    private $bizId;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var string
     */
    private $addId;

    /**
     * @var integer
     */
    private $id;
    
    /**
     * @var integer
     */
    private $isDel;

    /**
     * Set parentId
     *
     * @param integer $parentId
     * @return WxBizDepartment
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
    
        return $this;
    }

    /**
     * Get parentId
     *
     * @return integer 
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return WxBizDepartment
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
     * Set createdTime
     *
     * @param integer $createdTime
     * @return WxBizDepartment
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
     * Set modifyTime
     *
     * @param integer $modifyTime
     * @return WxBizDepartment
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
     * Set ename
     *
     * @param string $ename
     * @return WxBizDepartment
     */
    public function setEname($ename)
    {
        $this->ename = $ename;
    
        return $this;
    }

    /**
     * Get ename
     *
     * @return string 
     */
    public function getEname()
    {
        return $this->ename;
    }

    /**
     * Set bizId
     *
     * @param string $bizId
     * @return WxBizDepartment
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
     * Set status
     *
     * @param integer $status
     * @return WxBizDepartment
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
     * Set addId
     *
     * @param string $addId
     * @return WxBizDepartment
     */
    public function setAddId($addId)
    {
        $this->addId = $addId;
    
        return $this;
    }

    /**
     * Get addId
     *
     * @return string 
     */
    public function getAddId()
    {
        return $this->addId;
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
     * Set IsDel
     *  
     */
    public function setIsDel($isDel)
    {
        $this->isDel = $isDel;
    
        return $this;
    }
    
    /**
     * Get IsDel
     *
     * @return string
     */
    public function getIsDel()
    {
        return $this->isDel;
    }
}
