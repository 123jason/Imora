<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContactCardGroup
 */
class ContactCardGroup
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
    private $userId;

    /**
     * @var string
     */
    private $groupName;

    /**
     * @var integer
     */
    private $groupColor;

    /**
     * @var string
     */
    private $type;

    /**
     * @var integer
     */
    private $sorting;

    /**
     * @var \DateTime
     */
    private $lastModified;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set groupId
     *
     * @param string $groupId
     * @return ContactCardGroup
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
     * @return ContactCardGroup
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
     * Set userId
     *
     * @param string $userId
     * @return ContactCardGroup
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
     * Set groupName
     *
     * @param string $groupName
     * @return ContactCardGroup
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
     * Set groupColor
     *
     * @param integer $groupColor
     * @return ContactCardGroup
     */
    public function setGroupColor($groupColor)
    {
        $this->groupColor = $groupColor;

        return $this;
    }

    /**
     * Get groupColor
     *
     * @return integer 
     */
    public function getGroupColor()
    {
        return $this->groupColor;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return ContactCardGroup
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set sorting
     *
     * @param integer $sorting
     * @return ContactCardGroup
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
     * Set lastModified
     *
     * @param \DateTime $lastModified
     * @return ContactCardGroup
     */
    public function setLastModified($lastModified)
    {
        $this->lastModified = $lastModified;

        return $this;
    }

    /**
     * Get lastModified
     *
     * @return \DateTime 
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return ContactCardGroup
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
