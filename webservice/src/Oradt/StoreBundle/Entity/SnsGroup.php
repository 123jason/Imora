<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SnsGroup
 */
class SnsGroup
{    
    /**
     * @var integer
     */
    private $groupId;

    /**
     * @var integer
     */
    private $groupNum;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $tags;

    /**
     * @var string
     */
    private $categoryId;

    /**
     * @var string
     */
    private $logoPath;

    /**
     * @var string
     */
    private $summary;

    /**
     * @var string
     */
    private $superAdmin;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var string
     */
    private $cityCode;

    /**
     * @var string
     */
    private $namepre;
    
    /**
     * @var integer
     */
    private $id;


    /**
     * Set groupId
     *
     * @param integer $groupId
     * @return SnsGroup
     */
    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;
    
        return $this;
    }

    /**
     * Get groupId
     *
     * @return integer 
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * Set groupNum
     *
     * @param integer $groupNum
     * @return SnsGroup
     */
    public function setGroupNum($groupNum)
    {
        $this->groupNum = $groupNum;
    
        return $this;
    }

    /**
     * Get groupNum
     *
     * @return integer 
     */
    public function getGroupNum()
    {
        return $this->groupNum;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return SnsGroup
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
     * Set tags
     *
     * @param string $tags
     * @return SnsGroup
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
     * Set categoryId
     *
     * @param string $categoryId
     * @return SnsGroup
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
     * Set logoPath
     *
     * @param string $logoPath
     * @return SnsGroup
     */
    public function setLogoPath($logoPath)
    {
        $this->logoPath = $logoPath;
    
        return $this;
    }

    /**
     * Get logoPath
     *
     * @return string 
     */
    public function getLogoPath()
    {
        return $this->logoPath;
    }

    /**
     * Set summary
     *
     * @param string $summary
     * @return SnsGroup
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;
    
        return $this;
    }

    /**
     * Get summary
     *
     * @return string 
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Set superAdmin
     *
     * @param string $superAdmin
     * @return SnsGroup
     */
    public function setSuperAdmin($superAdmin)
    {
        $this->superAdmin = $superAdmin;
    
        return $this;
    }

    /**
     * Get superAdmin
     *
     * @return string 
     */
    public function getSuperAdmin()
    {
        return $this->superAdmin;
    }

    /**
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return SnsGroup
     */
    public function setCreatedTime($createdTime)
    {
        $this->createdTime = $createdTime;
    
        return $this;
    }

    /**
     * Get createdTime
     *
     * @return \DateTime 
     */
    public function getCreatedTime()
    {
        return $this->createdTime;
    }

    /**
     * Set namepre
     *
     * @param string $namepre
     * @return SnsGroup
     */
    public function setNamepre($namepre)
    {
        $this->namepre = $namepre;
    
        return $this;
    }

    /**
     * Get namepre
     *
     * @return string 
     */
    public function getNamepre()
    {
        return $this->namepre;
    }

    /**
     * Set cityCode
     *
     * @param string $cityCode
     * @return SnsGroup
     */
    public function setCityCode($cityCode)
    {
        $this->cityCode = $cityCode;
    
        return $this;
    }

    /**
     * Get cityCode
     *
     * @return string 
     */
    public function getCityCode()
    {
        return $this->cityCode;
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
