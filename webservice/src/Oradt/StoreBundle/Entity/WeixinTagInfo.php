<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WeixinTagInfo
 */
class WeixinTagInfo
{
    /**
     * @var string
     */
    private $wechatId;

    /**
     * @var boolean
     */
    private $tag;

    /**
     * @var string
     */
    private $tagJson;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set wechatId
     *
     * @param string $wechatId
     * @return WeixinTagInfo
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
     * @param boolean $tag
     * @return WeixinTagInfo
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
    
        return $this;
    }

    /**
     * Get tag
     *
     * @return boolean 
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set tagJson
     *
     * @param string $tagJson
     * @return WeixinTagInfo
     */
    public function setTagJson($tagJson)
    {
        $this->tagJson = $tagJson;
    
        return $this;
    }

    /**
     * Get tagJson
     *
     * @return string 
     */
    public function getTagJson()
    {
        return $this->tagJson;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return WeixinTagInfo
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
