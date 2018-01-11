<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountBizImport
 */
class AccountBizImport
{
    /**
     * @var string
     */
    private $bizId;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $name;
    
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $mobile;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $title;

    /**
     * @var integer
     */
    private $roleid;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var string
     */
    private $reason;

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
     * @return AccountBizImport
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
     * Set userId
     *
     * @param string $userId
     * @return AccountBizImport
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
     * Set name
     *
     * @param string $name
     * @return AccountBizImport
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
     * Set username
     *
     * @param string $username
     * @return AccountBizImport
     */
    public function setUsername($username)
    {
    	$this->username = $username;
    
    	return $this;
    }
    
    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
    	return $this->username;
    }
    /**
     * Set mobile
     *
     * @param string $mobile
     * @return AccountBizImport
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    
        return $this;
    }

    /**
     * Get mobile
     *
     * @return string 
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return AccountBizImport
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
     * Set title
     *
     * @param string $title
     * @return AccountBizImport
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
     * Set roleid
     *
     * @param integer $roleid
     * @return AccountBizImport
     */
    public function setRoleid($roleid)
    {
        $this->roleid = $roleid;
    
        return $this;
    }

    /**
     * Get roleid
     *
     * @return integer 
     */
    public function getRoleid()
    {
        return $this->roleid;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return AccountBizImport
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
     * Set reason
     *
     * @param string $reason
     * @return AccountBizImport
     */
    public function setReason($reason)
    {
        $this->reason = $reason;
    
        return $this;
    }

    /**
     * Get reason
     *
     * @return string 
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return AccountBizImport
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
