<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WeixinOtherTag
 */
class WeixinOtherTag
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $wechatId;

    /**
     * @var string
     */
    private $tag;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $modifyTime;


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
     * Set wechatId
     *
     * @param string $wechatId
     * @return WeixinOtherTag
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
     * Set tag
     *
     * @param string $tag
     * @return WeixinOtherTag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
    
        return $this;
    }

    /**
     * Get tag
     *
     * @return string 
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return WeixinOtherTag
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
     * Set createdTime
     *
     * @param integer $createdTime
     * @return WeixinOtherTag
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
     * Set modifyTime
     *
     * @param integer $modifyTime
     * @return WeixinOtherTag
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
