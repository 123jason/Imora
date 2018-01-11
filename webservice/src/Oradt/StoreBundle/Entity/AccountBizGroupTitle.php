<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountBizGroupTitle
 */
class AccountBizGroupTitle
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $groupId;

    /**
     * @var string
     */
    private $bizId;

    /**
     * @var string
     */
    private $addId;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set title
     *
     * @param string $title
     * @return AccountBizGroupTitle
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set groupId
     *
     * @param string $groupId
     * @return AccountBizGroupTitle
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
     * Set bizId
     *
     * @param string $bizId
     * @return AccountBizGroupTitle
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
     * Set addId
     *
     * @param string $addId
     * @return AccountBizGroupTitle
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
     * Set createdTime
     *
     * @param integer $createdTime
     * @return AccountBizGroupTitle
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
