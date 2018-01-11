<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PasswdReset
 */
class PasswdReset
{
    /**
     * @var string
     */
    private $uuid;

    /**
     * @var string
     */
    private $account;

    /**
     * @var string
     */
    private $accountId;

    /**
     * @var string
     */
    private $ip;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var string
     */
    private $status;

    /**
     * @var \DateTime
     */
    private $resetTime;

    /**
     * @var string
     */
    private $accountType;

    /**
     * @var string
     */
    private $resetType;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set uuid
     *
     * @param string $uuid
     * @return PasswdReset
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * Get uuid
     *
     * @return string 
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set account
     *
     * @param string $account
     * @return PasswdReset
     */
    public function setAccount($account)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return string 
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set accountId
     *
     * @param string $accountId
     * @return PasswdReset
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
     * Set ip
     *
     * @param string $ip
     * @return PasswdReset
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string 
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return PasswdReset
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
     * Set status
     *
     * @param string $status
     * @return PasswdReset
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
     * Set resetTime
     *
     * @param \DateTime $resetTime
     * @return PasswdReset
     */
    public function setResetTime($resetTime)
    {
        $this->resetTime = $resetTime;

        return $this;
    }

    /**
     * Get resetTime
     *
     * @return \DateTime 
     */
    public function getResetTime()
    {
        return $this->resetTime;
    }

    /**
     * Set accountType
     *
     * @param string $accountType
     * @return PasswdReset
     */
    public function setAccountType($accountType)
    {
        $this->accountType = $accountType;

        return $this;
    }

    /**
     * Get accountType
     *
     * @return string 
     */
    public function getAccountType()
    {
        return $this->accountType;
    }

    /**
     * Set resetType
     *
     * @param string $resetType
     * @return PasswdReset
     */
    public function setResetType($resetType)
    {
        $this->resetType = $resetType;

        return $this;
    }

    /**
     * Get resetType
     *
     * @return string 
     */
    public function getResetType()
    {
        return $this->resetType;
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
