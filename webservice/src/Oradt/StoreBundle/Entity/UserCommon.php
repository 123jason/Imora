<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserCommon
 */
class UserCommon
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $accountNo;

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
    private $password;

    /**
     * @var string
     */
    private $bizId;

    /**
     * @var string
     */
    private $wechatId;

    /**
     * @var string
     */
    private $unionId;

    /**
     * @var integer
     */
    private $reFrom;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var integer
     */
    private $createTime;

    /**
     * @var integer
     */
    private $modifyTime;
    /**
     * @var string
     */
    private $userName;

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
     * Set userName
     *
     * @param string $userName
     * @return UserCommon
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
    
        return $this;
    }
    
    /**
     * Get accountNo
     *
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Set accountNo
     *
     * @param string $accountNo
     * @return UserCommon
     */
    public function setAccountNo($accountNo)
    {
        $this->accountNo = $accountNo;

        return $this;
    }

    /**
     * Get accountNo
     *
     * @return string 
     */
    public function getAccountNo()
    {
        return $this->accountNo;
    }

    /**
     * Set mobile
     *
     * @param string $mobile
     * @return UserCommon
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
     * @return UserCommon
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
     * Set password
     *
     * @param string $password
     * @return UserCommon
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set bizId
     *
     * @param string $bizId
     * @return UserCommon
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
     * Set wechatId
     *
     * @param string $wechatId
     * @return UserCommon
     */
    public function setWechatId($wechatId)
    {
        $this->wechatId = $wechatId;

        return $this;
    }

    /**
     * Get wechatId
     *
     * @return string 
     */
    public function getWechatId()
    {
        return $this->wechatId;
    }

    /**
     * Set unionId
     *
     * @param string $unionId
     * @return UserCommon
     */
    public function setUnionId($unionId)
    {
        $this->unionId = $unionId;

        return $this;
    }

    /**
     * Get unionId
     *
     * @return string 
     */
    public function getUnionId()
    {
        return $this->unionId;
    }

    /**
     * Set reFrom
     *
     * @param integer $reFrom
     * @return UserCommon
     */
    public function setReFrom($reFrom)
    {
        $this->reFrom = $reFrom;

        return $this;
    }

    /**
     * Get reFrom
     *
     * @return integer 
     */
    public function getReFrom()
    {
        return $this->reFrom;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return UserCommon
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
     * Set createTime
     *
     * @param integer $createTime
     * @return UserCommon
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
     * Set modifyTime
     *
     * @param integer $modifyTime
     * @return UserCommon
     */
    public function setModifyTime($modifyTime)
    {
        $this->modifyTime = $modifyTime;

        return $this;
    }

    /**
     * Get modifyTime
     *
     * @return integer 
     */
    public function getModifyTime()
    {
        return $this->modifyTime;
    }
}
