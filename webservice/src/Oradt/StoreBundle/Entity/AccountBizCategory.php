<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountBizCategory
 */
class AccountBizCategory
{
    /**
     * @var string
     */
    private $bizId;

    /**
     * @var string
     */
    private $categoryId;

    /**
     * @var integer
     */
    private $createTime;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set bizId
     *
     * @param string $bizId
     * @return AccountBizCategory
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
     * Set categoryId
     *
     * @param string $categoryId
     * @return AccountBizCategory
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
     * Set createTime
     *
     * @param integer $createTime
     * @return AccountBizCategory
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
     * Set status
     *
     * @param integer $status
     * @return AccountBizCategory
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
