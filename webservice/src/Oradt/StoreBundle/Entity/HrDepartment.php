<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HrDepartment
 */
class HrDepartment
{
    /**
     * @var string
     */
    private $depId;

    /**
     * @var string
     */
    private $parentId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $managerId;

    /**
     * @var string
     */
    private $remark;

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
    private $bizId;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set depId
     *
     * @param string $depId
     * @return HrDepartment
     */
    public function setDepId($depId)
    {
        $this->depId = $depId;
    
        return $this;
    }

    /**
     * Get depId
     *
     * @return string 
     */
    public function getDepId()
    {
        return $this->depId;
    }

    /**
     * Set parentId
     *
     * @param string $parentId
     * @return HrDepartment
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
     * Set name
     *
     * @param string $name
     * @return HrDepartment
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
     * Set managerId
     *
     * @param string $managerId
     * @return HrDepartment
     */
    public function setManagerId($managerId)
    {
        $this->managerId = $managerId;
    
        return $this;
    }

    /**
     * Get managerId
     *
     * @return string 
     */
    public function getManagerId()
    {
        return $this->managerId;
    }

    /**
     * Set remark
     *
     * @param string $remark
     * @return HrDepartment
     */
    public function setRemark($remark)
    {
        $this->remark = $remark;
    
        return $this;
    }

    /**
     * Get remark
     *
     * @return string 
     */
    public function getRemark()
    {
        return $this->remark;
    }

    /**
     * Set sorting
     *
     * @param integer $sorting
     * @return HrDepartment
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
     * @return HrDepartment
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
     * Set bizId
     *
     * @param string $bizId
     * @return HrDepartment
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
