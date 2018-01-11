<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountBizFollowsGroup
 */
class AccountBizFollowsGroup
{
    /**
     * @var string
     */
    private $bizId;

    /**
     * @var string
     */
    private $expoid;

    /**
     * @var string
     */
    private $parentId;

    /**
     * @var string
     */
    private $groupName;

    /**
     * @var integer
     */
    private $sorting;

    /**
     * @var \DateTime
     */
    private $createTime;

    /**
     * @var integer
     */
    private $type;
    /**
     * @var integer
     */
    private $status;
    /**
     * @var integer
     */
    private $grouptype;
    /**
     * @var integer
     */
    private $id;


    /**
     * Set bizId
     *
     * @param string $bizId
     * @return AccountBizFollowsGroup
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
     * Set expoid
     *
     * @param string $expoid
     * @return AccountBizFollowsGroup
     */
    public function setExpoid($expoid)
    {
        $this->expoid = $expoid;
    
        return $this;
    }

    /**
     * Get expoid
     *
     * @return string 
     */
    public function getExpoid()
    {
        return $this->expoid;
    }

    /**
     * Set parentId
     *
     * @param string $parentId
     * @return AccountBizFollowsGroup
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
     * @return AccountBizFollowsGroup
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
     * Set sorting
     *
     * @param integer $sorting
     * @return AccountBizFollowsGroup
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
     * Set createTime
     *
     * @param \DateTime $createTime
     * @return AccountBizFollowsGroup
     */
    public function setCreateTime($createTime)
    {
        $this->createTime = $createTime;
    
        return $this;
    }

    /**
     * Get createTime
     *
     * @return \DateTime 
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return AccountBizFollowsGroup
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
     * Set grouptype
     *
     * @param integer $grouptype
     * @return AccountBizFollowsGroup
     */
    public function setGrouptype($grouptype)
    {
    	$this->grouptype = $grouptype;
    
    	return $this;
    }
    
    /**
     * Get grouptype
     *
     * @return integer
     */
    public function getGrouptype()
    {
    	return $this->grouptype;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return AccountBizFollowsGroup
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
}
