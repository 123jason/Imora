<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SnsGroupMembers
 */
class SnsGroupMembers
{    
    /**
     * @var integer
     */
    private $groupId;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $nickName;

    /**
     * @var string
     */
    private $role;
    
    /**
     * @var string
     */
    private $sorting;
    
    /**
     * @var string
     */
    private $remark;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var integer
     */
    private $issave;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set groupId
     *
     * @param integer $groupId
     * @return SnsGroupMembers
     */
    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;
    
        return $this;
    }

    /**
     * Get groupId
     *
     * @return integer 
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return SnsGroupMembers
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
     * Set nickName
     *
     * @param string $nickName
     * @return SnsGroupMembers
     */
    public function setNickName($nickName)
    {
        $this->nickName = $nickName;
    
        return $this;
    }

    /**
     * Get nickName
     *
     * @return string 
     */
    public function getNickName()
    {
        return $this->nickName;
    }

    /**
     * Set role
     *
     * @param string $role
     * @return SnsGroupMembers
     */
    public function setRole($role)
    {
        $this->role = $role;
    
        return $this;
    }

    /**
     * Get role
     *
     * @return string 
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set sorting
     *
     * @param string $sorting
     * @return SnsGroupMembers
     */
    public function setSorting($sorting)
    {
        $this->sorting = $sorting;
    
        return $this;
    }

    /**
     * Get sorting
     *
     * @return string 
     */
    public function getSorting()
    {
        return $this->sorting;
    }
    
    /**
     * Set remark
     *
     * @param string $remark
     * @return SnsGroupMembers
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
     * Set createdTime
     *
     * @param integer $createdTime
     * @return SnsGroupMembers
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
     * Set status
     *
     * @param integer $status
     * @return SnsGroupMembers
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
     * Set issave
     *
     * @param integer $issave
     * @return SnsGroupMembers
     */
    public function setIssave($issave)
    {
        $this->issave = $issave;
    
        return $this;
    }

    /**
     * Get issave
     *
     * @return integer 
     */
    public function getIssave()
    {
        return $this->issave;
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
