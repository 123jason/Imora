<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BizNewsResource
 */
class BizNewsResource
{
    /**
     * @var string
     */
    private $bizId;

    /**
     * @var string
     */
    private $bizNewsId;

    /**
     * @var string
     */
    private $resPath;

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
     * Set bizId
     *
     * @param string $bizId
     * @return BizNewsResource
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
     * Set bizNewsId
     *
     * @param string $bizNewsId
     * @return BizNewsResource
     */
    public function setBizNewsId($bizNewsId)
    {
        $this->bizNewsId = $bizNewsId;

        return $this;
    }

    /**
     * Get bizNewsId
     *
     * @return string 
     */
    public function getBizNewsId()
    {
        return $this->bizNewsId;
    }

    /**
     * Set resPath
     *
     * @param string $resPath
     * @return BizNewsResource
     */
    public function setResPath($resPath)
    {
        $this->resPath = $resPath;

        return $this;
    }

    /**
     * Get resPath
     *
     * @return string 
     */
    public function getResPath()
    {
        return $this->resPath;
    }

    /**
     * Set sorting
     *
     * @param integer $sorting
     * @return BizNewsResource
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
     * @return BizNewsResource
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
    /**
     * @var string
     */
    private $resId;


    /**
     * Set resId
     *
     * @param string $resId
     * @return BizNewsResource
     */
    public function setResId($resId)
    {
        $this->resId = $resId;

        return $this;
    }

    /**
     * Get resId
     *
     * @return string 
     */
    public function getResId()
    {
        return $this->resId;
    }
}
