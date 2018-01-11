<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountBizAuthorization
 */
class AccountBizAuthorization
{
    /**
     * @var string
     */
    private $bizId;

    /**
     * @var string
     */
    private $accountid;

    /**
     * @var string
     */
    private $account;

    /**
     * @var integer
     */
    private $roleid;

    /**
     * @var string
     */
    private $remark;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var string
     */
    private $realname;

    /**
     * @var string
     */
    private $prespell;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $mobile;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $joindate;

    /**
     * @var integer
     */
    private $issend;

    /**
     * @var integer
     */
    private $tempid;
    
    /**
     * @var integer
     */
    private $id;


    /**
     * Set bizId
     *
     * @param string $bizId
     * @return AccountBizAuthorization
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
     * Set accountid
     *
     * @param string $accountid
     * @return AccountBizAuthorization
     */
    public function setAccountid($accountid)
    {
        $this->accountid = $accountid;
    
        return $this;
    }

    /**
     * Get accountid
     *
     * @return string 
     */
    public function getAccountid()
    {
        return $this->accountid;
    }

    /**
     * Set account
     *
     * @param string $account
     * @return AccountBizAuthorization
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
     * Set roleid
     *
     * @param integer $roleid
     * @return AccountBizAuthorization
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
     * Set remark
     *
     * @param string $remark
     * @return AccountBizAuthorization
     */
    public function setRemark($remark)
    {
        $this->remark = $remark;
    
        return $this;
    }

    /**
     * Get remark
     *
     * @return string 
     */
    public function getRemark()
    {
        return $this->remark;
    }

    /**
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return AccountBizAuthorization
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
     * Set realname
     *
     * @param string $realname
     * @return AccountBizAuthorization
     */
    public function setRealname($realname)
    {
        $this->realname = $realname;
    
        return $this;
    }

    /**
     * Get realname
     *
     * @return string 
     */
    public function getRealname()
    {
        return $this->realname;
    }

    /**
     * Set prespell
     *
     * @param string $prespell
     * @return AccountBizAuthorization
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
     * Set title
     *
     * @param string $title
     * @return AccountBizAuthorization
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
     * Set mobile
     *
     * @param string $mobile
     * @return AccountBizAuthorization
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
     * Set status
     *
     * @param integer $status
     * @return AccountBizAuthorization
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
     * Set email
     *
     * @param string $email
     * @return AccountBizAuthorization
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
     * Set joindate
     *
     * @param string $joindate
     * @return AccountBizAuthorization
     */
    public function setJoindate($joindate)
    {
        $this->joindate = $joindate;
    
        return $this;
    }

    /**
     * Get joindate
     *
     * @return string 
     */
    public function getJoindate()
    {
        return $this->joindate;
    }

    /**
     * Set issend
     *
     * @param integer $issend
     * @return AccountBizAuthorization
     */
    public function setIssend($issend)
    {
        $this->issend = $issend;
    
        return $this;
    }

    /**
     * Get issend
     *
     * @return integer 
     */
    public function getIssend()
    {
        return $this->issend;
    }

    /**
     * Set tempid
     *
     * @param integer $tempid
     * @return AccountBizAuthorization
     */
    public function setTempid($tempid)
    {
        $this->tempid = $tempid;
    
        return $this;
    }

    /**
     * Get tempid
     *
     * @return integer 
     */
    public function getTempid()
    {
        return $this->tempid;
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
