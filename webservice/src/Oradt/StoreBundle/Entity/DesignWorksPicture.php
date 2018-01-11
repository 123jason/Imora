<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DesignWorksPicture
 */
class DesignWorksPicture
{

    /**
     * @var string
     */
    private $picId;

    /**
     * @var integer
     */
    private $worksId;

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
     * @var integer
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
     * @return DesignWorksPicture
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
     * Set worksId
     *
     * @param integer $worksId
     * @return DesignWorksPicture
     */
    public function setWorksId($worksId)
    {
        $this->worksId = $worksId;
    
        return $this;
    }

    /**
     * Get worksId
     *
     * @return integer 
     */
    public function getWorksId()
    {
        return $this->worksId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return DesignWorksPicture
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
     * @return DesignWorksPicture
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
     * @return DesignWorksPicture
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
     * @param integer $createTime
     * @return DesignWorksPicture
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
