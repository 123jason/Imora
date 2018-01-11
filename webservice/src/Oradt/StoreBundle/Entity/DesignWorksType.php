<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DesignWorksType
 */
class DesignWorksType
{
    /**
     * @var string
     */
    private $title;
	/**
     * @var string
     */
    private $typeId;

    /**
     * @var boolean
     */
    private $sort;

    /**
     * @var integer
     */
    private $createTime;

    /**
     * @var integer
     */
    private $id;

	/**
     * Set typeId
     *
     * @param string $title
     * @return DesignWorksType
     */
    public function setTypeId($type_id)
    {
        $this->typeId = $type_id;
    
        return $this;
    }
	/**
     * Get typeId
     *
     * @return string 
     */
    public function getTypeId()
    {
        return $this->typeId;
    }
    /**
     * Set title
     *
     * @param string $title
     * @return DesignWorksType
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
     * Set sort
     *
     * @param boolean $sort
     * @return DesignWorksType
     */
    public function setSort($sort)
    {
        $this->sort = $sort;
    
        return $this;
    }

    /**
     * Get sort
     *
     * @return boolean 
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Set createTime
     *
     * @param integer $createTime
     * @return DesignWorksType
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
