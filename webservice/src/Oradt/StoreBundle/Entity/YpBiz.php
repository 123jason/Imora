<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * YpBiz
 */
class YpBiz
{
    /**
     * @var string
     */
    private $bizId;

    /**
     * @var string
     */
    private $principal;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $status;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var string
     */
    private $categoryId;

    /**
     * @var string
     */
    private $categoryId2;

    /**
     * @var string
     */
    private $email;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set bizId
     *
     * @param string $bizId
     * @return YpBiz
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
     * Set principal
     *
     * @param string $principal
     * @return YpBiz
     */
    public function setPrincipal($principal)
    {
        $this->principal = $principal;

        return $this;
    }

    /**
     * Get principal
     *
     * @return string 
     */
    public function getPrincipal()
    {
        return $this->principal;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return YpBiz
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return YpBiz
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return YpBiz
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
     * Set categoryId
     *
     * @param string $categoryId
     * @return YpBiz
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
     * Set categoryId2
     *
     * @param string $categoryId2
     * @return YpBiz
     */
    public function setCategoryId2($categoryId2)
    {
        $this->categoryId2 = $categoryId2;

        return $this;
    }

    /**
     * Get categoryId2
     *
     * @return string 
     */
    public function getCategoryId2()
    {
        return $this->categoryId2;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return YpBiz
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
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
