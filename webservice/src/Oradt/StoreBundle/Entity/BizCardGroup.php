<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BizCardGroup
 */
class BizCardGroup
{
    /**
     * @var string
     */
    private $groupId;

    /**
     * @var string
     */
    private $parentId;

    /**
     * @var string
     */
    private $groupName;

    /**
     * @var string
     */
    private $bizId;

    /**
     * @var integer
     */
    private $sorting;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set groupId
     *
     * @param string $groupId
     * @return BizCardGroup
     */
    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;
    
        return $this;
    }

    /**
     * Get groupId
     *
     * @return string 
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * Set parentId
     *
     * @param string $parentId
     * @return BizCardGroup
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
     * Set groupName
     *
     * @param string $groupName
     * @return BizCardGroup
     */
    public function setGroupName($groupName)
    {
        $this->groupName = $groupName;
    
        return $this;
    }

    /**
     * Get groupName
     *
     * @return string 
     */
    public function getGroupName()
    {
        return $this->groupName;
    }

    /**
     * Set bizId
     *
     * @param string $bizId
     * @return BizCardGroup
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
     * Set sorting
     *
     * @param integer $sorting
     * @return BizCardGroup
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
