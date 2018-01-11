<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HrFavoriteCandidateGroup
 */
class HrFavoriteCandidateGroup
{
    /**
     * @var string
     */
    private $groupId;

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
    private $sortid;

    /**
     * @var integer
     */
    private $createTime;
    
    /**
     * @var integer
     */
    private $id;


    /**
     * Set groupId
     *
     * @param string $groupId
     * @return HrFavoriteCandidateGroup
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
     * Set groupName
     *
     * @param string $groupName
     * @return HrFavoriteCandidateGroup
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
     * Set userId
     *
     * @param string $userId
     * @return HrFavoriteCandidateGroup
     */
    public function setBizId($bizId)
    {
        $this->bizId = $bizId;
    
        return $this;
    }

    /**
     * Get userId
     *
     * @return string 
     */
    public function getBizId()
    {
        return $this->bizId;
    }

    /**
     * Set sortid
     *
     * @param integer $sortid
     * @return HrFavoriteCandidateGroup
     */
    public function setSortid($sortid)
    {
        $this->sortid = $sortid;
    
        return $this;
    }

    /**
     * Get sortid
     *
     * @return integer 
     */
    public function getSortid()
    {
        return $this->sortid;
    }

        /**
     * Set createTime
     *
     * @param integer $createTime
     * @return HrFavoriteCandidateGroup
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
