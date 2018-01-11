<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WeixinUnsubscribe
 */
class WeixinUnsubscribe
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $appId;

    /**
     * @var string
     */
    private $openId;

    /**
     * @var integer
     */
    private $createTime;


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
     * Set appId
     *
     * @param string $appId
     * @return WeixinUnsubscribe
     */
    public function setAppId($appId)
    {
        $this->appId = $appId;

        return $this;
    }

    /**
     * Get appId
     *
     * @return string 
     */
    public function getAppId()
    {
        return $this->appId;
    }

    /**
     * Set openId
     *
     * @param string $openId
     * @return WeixinUnsubscribe
     */
    public function setOpenId($openId)
    {
        $this->openId = $openId;

        return $this;
    }

    /**
     * Get openId
     *
     * @return string 
     */
    public function getOpenId()
    {
        return $this->openId;
    }

    /**
     * Set createTime
     *
     * @param integer $createTime
     * @return WeixinUnsubscribe
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
}
