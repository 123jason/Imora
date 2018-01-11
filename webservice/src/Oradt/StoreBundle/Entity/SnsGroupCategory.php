<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SnsGroupCategory
 */
class SnsGroupCategory
{
    /**
     * @var string
     */
    private $categoryId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set categoryId
     *
     * @param string $categoryId
     * @return SnsGroupCategory
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
    
        return $this;
    }

    /**
     * Get categoryId
     *
     * @return string 
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return SnsGroupCategory
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
     * Set createdTime
     *
     * @param string $createdTime
     * @return SnsGroupCategory
     */
    public function setCreatedTime($createdTime)
    {
        $this->createdTime = $createdTime;
    
        return $this;
    }

    /**
     * Get createdTime
     *
     * @return string 
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
