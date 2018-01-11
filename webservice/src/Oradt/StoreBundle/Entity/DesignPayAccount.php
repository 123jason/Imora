<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DesignPayAccount
 */
class DesignPayAccount
{
    /**
     * @var string
     */
    private $accountId;

    /**
     * @var string
     */
    private $userid;

    /**
     * @var boolean
     */
    private $type;

    /**
     * @var string
     */
    private $payName;

    /**
     * @var string
     */
    private $payAccount;

    /**
     * @var integer
     */
    private $createTime;

    /**
     * @var integer
     */
    private $updateTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set accountId
     *
     * @param string $accountId
     * @return DesignPayAccount
     */
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;
    
        return $this;
    }

    /**
     * Get accountId
     *
     * @return string 
     */
    public function getAccountId()
    {
        return $this->accountId;
    }

    /**
     * Set userid
     *
     * @param string $userid
     * @return DesignPayAccount
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;
    
        return $this;
    }

    /**
     * Get userid
     *
     * @return string 
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * Set type
     *
     * @param boolean $type
     * @return DesignPayAccount
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return boolean 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set payName
     *
     * @param string $payName
     * @return DesignPayAccount
     */
    public function setPayName($payName)
    {
        $this->payName = $payName;
    
        return $this;
    }

    /**
     * Get payName
     *
     * @return string 
     */
    public function getPayName()
    {
        return $this->payName;
    }

    /**
     * Set payAccount
     *
     * @param string $payAccount
     * @return DesignPayAccount
     */
    public function setPayAccount($payAccount)
    {
        $this->payAccount = $payAccount;
    
        return $this;
    }

    /**
     * Get payAccount
     *
     * @return string 
     */
    public function getPayAccount()
    {
        return $this->payAccount;
    }

    /**
     * Set createTime
     *
     * @param integer $createTime
     * @return DesignPayAccount
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
     * Set updateTime
     *
     * @param integer $updateTime
     * @return DesignPayAccount
     */
    public function setUpdateTime($updateTime)
    {
        $this->updateTime = $updateTime;
    
        return $this;
    }

    /**
     * Get updateTime
     *
     * @return integer 
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
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
