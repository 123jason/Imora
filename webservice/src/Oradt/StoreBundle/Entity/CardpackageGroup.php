<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CardpackageGroup
 */
class CardpackageGroup
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $groupid;

    /**
     * @var string
     */
    private $groupname;

    /**
     * @var string
     */
    private $color;

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
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return CardpackageGroup
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
     * Set groupid
     *
     * @param string $groupid
     * @return CardpackageGroup
     */
    public function setGroupid($groupid)
    {
        $this->groupid = $groupid;
    
        return $this;
    }

    /**
     * Get groupid
     *
     * @return string 
     */
    public function getGroupid()
    {
        return $this->groupid;
    }

    /**
     * Set groupname
     *
     * @param string $groupname
     * @return CardpackageGroup
     */
    public function setGroupname($groupname)
    {
        $this->groupname = $groupname;
    
        return $this;
    }

    /**
     * Get groupname
     *
     * @return string 
     */
    public function getGroupname()
    {
        return $this->groupname;
    }

    /**
     * Set color
     *
     * @param string $color
     * @return CardpackageGroup
     */
    public function setColor($color)
    {
        $this->color = $color;
    
        return $this;
    }

    /**
     * Get color
     *
     * @return string 
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set sorting
     *
     * @param integer $sorting
     * @return CardpackageGroup
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
     * @return CardpackageGroup
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
