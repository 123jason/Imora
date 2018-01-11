<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountBizImportEmp
 */
class AccountBizImportEmp
{
    /**
     * @var string
     */
    private $jsondata;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var boolean
     */
    private $status;

    /**
     * @var string
     */
    private $bizId;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set jsondata
     *
     * @param string $jsondata
     * @return AccountBizImportEmp
     */
    public function setJsondata($jsondata)
    {
        $this->jsondata = $jsondata;
    
        return $this;
    }

    /**
     * Get jsondata
     *
     * @return string 
     */
    public function getJsondata()
    {
        return $this->jsondata;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return AccountBizImportEmp
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
     * @param boolean $status
     * @return AccountBizImportEmp
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return boolean 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set bizId
     *
     * @param string $bizId
     * @return AccountBizImportEmp
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
