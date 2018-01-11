<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountBizDepartment
 */
class AccountBizDepartment
{
    /**
     * @var string
     */
    private $departId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $type;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set departId
     *
     * @param string $departId
     * @return AccountBizDepartment
     */
    public function setDepartId($departId)
    {
        $this->departId = $departId;
    
        return $this;
    }

    /**
     * Get departId
     *
     * @return string 
     */
    public function getDepartId()
    {
        return $this->departId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return AccountBizDepartment
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return AccountBizDepartment
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
     * Set createdTime
     *
     * @param integer $createdTime
     * @return AccountBizDepartment
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
    /**
     * @var string
     */
    private $ename;

    /**
     * @var string
     */
    private $bizId;


    /**
     * Set ename
     *
     * @param string $ename
     * @return AccountBizDepartment
     */
    public function setEname($ename)
    {
        $this->ename = $ename;
    
        return $this;
    }

    /**
     * Get ename
     *
     * @return string 
     */
    public function getEname()
    {
        return $this->ename;
    }

    /**
     * Set bizId
     *
     * @param string $bizId
     * @return AccountBizDepartment
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
     * @var integer
     */
    private $status;


    /**
     * Set status
     *
     * @param integer $status
     * @return AccountBizDepartment
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
     * @var integer
     */
    private $language;


    /**
     * Set status
     *
     * @param integer $status
     * @return AccountBizDepartment
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getLanguage()
    {
        return $this->language;
    }
}
