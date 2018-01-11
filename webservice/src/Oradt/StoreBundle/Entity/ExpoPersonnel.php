<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExpoPersonnel
 */
class ExpoPersonnel
{
    /**
     * @var string
     */
    private $bizid;

    /**
     * @var string
     */
    private $personnelid;

    /**
     * @var string
     */
    private $jsonparam;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $querysql;

    /**
     * @var \DateTime
     */
    private $createdtime;

    /**
     * @var string
     */
    private $prespell;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set bizid
     *
     * @param string $bizid
     * @return ExpoPersonnel
     */
    public function setBizid($bizid)
    {
        $this->bizid = $bizid;
    
        return $this;
    }

    /**
     * Get bizid
     *
     * @return string 
     */
    public function getBizid()
    {
        return $this->bizid;
    }

    /**
     * Set personnelid
     *
     * @param string $personnelid
     * @return ExpoPersonnel
     */
    public function setPersonnelid($personnelid)
    {
        $this->personnelid = $personnelid;
    
        return $this;
    }

    /**
     * Get personnelid
     *
     * @return string 
     */
    public function getPersonnelid()
    {
        return $this->personnelid;
    }

    /**
     * Set jsonparam
     *
     * @param string $jsonparam
     * @return ExpoPersonnel
     */
    public function setJsonparam($jsonparam)
    {
        $this->jsonparam = $jsonparam;
    
        return $this;
    }

    /**
     * Get jsonparam
     *
     * @return string 
     */
    public function getJsonparam()
    {
        return $this->jsonparam;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return ExpoPersonnel
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
     * Set querysql
     *
     * @param string $querysql
     * @return ExpoPersonnel
     */
    public function setQuerysql($querysql)
    {
        $this->querysql = $querysql;
    
        return $this;
    }

    /**
     * Get querysql
     *
     * @return string 
     */
    public function getQuerysql()
    {
        return $this->querysql;
    }

    /**
     * Set createdtime
     *
     * @param \DateTime $createdtime
     * @return ExpoPersonnel
     */
    public function setCreatedtime($createdtime)
    {
        $this->createdtime = $createdtime;
    
        return $this;
    }

    /**
     * Get createdtime
     *
     * @return \DateTime 
     */
    public function getCreatedtime()
    {
        return $this->createdtime;
    }

    /**
     * Set prespell
     *
     * @param string $prespell
     * @return ExpoPersonnel
     */
    public function setPrespell($prespell)
    {
        $this->prespell = $prespell;
    
        return $this;
    }

    /**
     * Get prespell
     *
     * @return string 
     */
    public function getPrespell()
    {
        return $this->prespell;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return ExpoPersonnel
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
