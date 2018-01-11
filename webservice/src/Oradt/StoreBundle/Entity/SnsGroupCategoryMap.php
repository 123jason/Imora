<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SnsGroupCategoryMap
 */
class SnsGroupCategoryMap
{
    /**
     * @var string
     */
    private $categoryId;

    /**
     * @var string
     */
    private $groupId;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set categoryId
     *
     * @param string $categoryId
     * @return SnsGroupCategoryMap
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
     * Set groupId
     *
     * @param string $groupId
     * @return SnsGroupCategoryMap
     */
    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;
    
        return $this;
    }

    /**
     * Get groupId
     *
     * @return string 
     */
    public function getGroupId()
    {
        return $this->groupId;
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
