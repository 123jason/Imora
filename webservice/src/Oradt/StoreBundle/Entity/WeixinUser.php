<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WeixinUser
 */
class WeixinUser
{
  
    /**
     * @var string
     */
    private $wechatId;

    /**
     * @var string
     */
    private $wechatInfo;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $unionId;

    /**
     * Set wechatId
     *
     * @param string $wechatId
     * @return WeixinUser
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
     * Set wechatInfo
     *
     * @param string $wechatInfo
     * @return WeixinUser
     */
    public function setWechatInfo($wechatInfo)
    {
        $this->wechatInfo = $wechatInfo;

        return $this;
    }

    /**
     * Get wechatInfo
     *
     * @return string 
     */
    public function getWechatInfo()
    {
        return $this->wechatInfo;
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
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $modifiedTime;


    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return WeixinUser
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
     * Set modifiedTime
     *
     * @param integer $modifiedTime
     * @return WeixinUser
     */
    public function setModifiedTime($modifiedTime)
    {
        $this->modifiedTime = $modifiedTime;

        return $this;
    }

    /**
     * Get modifiedTime
     *
     * @return integer 
     */
    public function getModifiedTime()
    {
        return $this->modifiedTime;
    }
    /**
     * @var string
     */
    private $scannerInfo;


    /**
     * Set scannerInfo
     *
     * @param string $scannerInfo
     * @return WeixinUser
     */
    public function setScannerInfo($scannerInfo)
    {
        $this->scannerInfo = $scannerInfo;

        return $this;
    }

    /**
     * Get scannerInfo
     *
     * @return string 
     */
    public function getScannerInfo()
    {
        return $this->scannerInfo;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return WeixinUser
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
     * Set unionId
     *
     * @param string $unionId
     * @return WeixinUser
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
     * @var string
     */
    private $avatarPath;

    /**
     * Set avatarPath
     *
     * @param string $avatarPath
     * @return WeixinUser
     */
    public function setAvatarPath($avatarPath)
    {
        $this->avatarPath = $avatarPath;

        return $this;
    }

    /**
     * Get avatarPath
     *
     * @return string 
     */
    public function getAvatarPath()
    {
        return $this->avatarPath;
    }

    /**
     * @var string
     */
    private $bizId = '';

    /**
     * Set avatarPath
     *
     * @param string $avatarPath
     * @return WeixinUser
     */
    public function setBizId($bizId)
    {
        $this->bizId = $bizId;

        return $this;
    }

    /**
     * Get avatarPath
     *
     * @return string 
     */
    public function getBizId()
    {
        return $this->bizId;
    }
}
