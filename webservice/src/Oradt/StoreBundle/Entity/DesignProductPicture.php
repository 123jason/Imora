<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DesignProductPicture
 */
class DesignProductPicture
{
    /**
     * @var string
     */
    private $picId;

    /**
     * @var string
     */
    private $cardTplId;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $size;

    /**
     * @var string
     */
    private $url;

    /**
     * @var datetime
     */
    private $createTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set picId
     *
     * @param string $picId
     * @return DesignProductPicture
     */
    public function setPicId($picId)
    {
        $this->picId = $picId;
    
        return $this;
    }

    /**
     * Get picId
     *
     * @return string 
     */
    public function getPicId()
    {
        return $this->picId;
    }

    /**
     * Set cardTplId
     *
     * @param string $cardTplId
     * @return DesignProductPicture
     */
    public function setCardTplId($cardTplId)
    {
        $this->cardTplId = $cardTplId;
    
        return $this;
    }

    /**
     * Get cardTplId
     *
     * @return string 
     */
    public function getCardTplId()
    {
        return $this->cardTplId;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return DesignProductPicture
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
     * @return DesignProductPicture
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
     * Set size
     *
     * @param integer $size
     * @return DesignProductPicture
     */
    public function setSize($size)
    {
        $this->size = $size;
    
        return $this;
    }

    /**
     * Get size
     *
     * @return integer 
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return DesignProductPicture
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set createTime
     *
     * @param datetime $createTime
     * @return DesignProductPicture
     */
    public function setCreateTime($createTime)
    {
        $this->createTime = $createTime;
    
        return $this;
    }

    /**
     * Get createTime
     *
     * @return datetime 
     */
    public function getCreateTime()
    {
        return $this->createTime;
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
