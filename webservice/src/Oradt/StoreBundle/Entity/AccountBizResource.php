<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountBizResource
 */
class AccountBizResource
{
    /**
     * @var string
     */
    private $bizId;

    /**
     * @var string
     */
    private $resPath;

    /**
     * @var string
     */
    private $title;

    /**
     * @var integer
     */
    private $sorting;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set bizId
     *
     * @param string $bizId
     * @return AccountBizResource
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
     * Set resPath
     *
     * @param string $resPath
     * @return AccountBizResource
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
     * Set title
     *
     * @param string $title
     * @return AccountBizResource
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
     * Set sorting
     *
     * @param integer $sorting
     * @return AccountBizResource
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
     * @return AccountBizResource
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
