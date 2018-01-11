<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WxBizTags
 */
class WxBizTags
{
    /**
     * @var string
     */
    private $tagId;

    /**
     * @var string
     */
    private $bizId;

    /**
     * @var string
     */
    private $tags;

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
    private $addId;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set tagId
     *
     * @param string $tagId
     * @return WxBizTags
     */
    public function setTagId($tagId)
    {
        $this->tagId = $tagId;
    
        return $this;
    }

    /**
     * Get tagId
     *
     * @return string 
     */
    public function getTagId()
    {
        return $this->tagId;
    }

    /**
     * Set bizId
     *
     * @param string $bizId
     * @return WxBizTags
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
     * Set tags
     *
     * @param string $tags
     * @return WxBizTags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    
        return $this;
    }

    /**
     * Get tags
     *
     * @return string 
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set createTime
     *
     * @param integer $createTime
     * @return WxBizTags
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
     * @return WxBizTags
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

    /**
     * Set addId
     *
     * @param string $addId
     * @return WxBizTags
     */
    public function setAddId($addId)
    {
        $this->addId = $addId;
    
        return $this;
    }

    /**
     * Get addId
     *
     * @return string 
     */
    public function getAddId()
    {
        return $this->addId;
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
