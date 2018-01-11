<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DesignWorks
 */
class DesignWorks
{
    /**
     * @var string
     */
    private $userId;
	/**
     * @var string
     */
    private $worksId;
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $author;

    /**
     * @var string
     */
    private $explains;

    /**
     * @var integer
     */
    private $typeId;

    /**
     * @var boolean
     */
    private $authorize;

    /**
     * @var integer
     */
    private $createTime;

    /**
     * @var integer
     */
    private $updateTime;
	
	/**
     * @var integer
     */
    private $status;
	/**
     * @var integer
     */
    private $hits;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return DesignWorks
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
     * Get userId
     *
     * @return string 
     */
    public function setWorksId($works_id)
    {
         $this->worksId =$works_id;
    }
	/**
     * Get userId
     *
     * @return string 
     */
    public function getWorksId()
    {
        return $this->worksId;
    }
    /**
     * Set name
     *
     * @param string $name
     * @return DesignWorks
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
     * Set author
     *
     * @param string $author
     * @return DesignWorks
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    
        return $this;
    }

    /**
     * Get author
     *
     * @return string 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set explain
     *
     * @param string $explain
     * @return DesignWorks
     */
    public function setExplains($explains)
    {
        $this->explains = $explains;
    
        return $this;
    }

    /**
     * Get explain
     *
     * @return string 
     */
    public function getExplains()
    {
        return $this->explains;
    }

    /**
     * Set typeId
     *
     * @param integer $typeId
     * @return DesignWorks
     */
    public function setTypeId($typeId)
    {
        $this->typeId = $typeId;
    
        return $this;
    }

    /**
     * Get typeId
     *
     * @return integer 
     */
    public function getTypeId()
    {
        return $this->typeId;
    }

    /**
     * Set authorize
     *
     * @param boolean $authorize
     * @return DesignWorks
     */
    public function setAuthorize($authorize)
    {
        $this->authorize = $authorize;
    
        return $this;
    }

    /**
     * Get authorize
     *
     * @return boolean 
     */
    public function getAuthorize()
    {
        return $this->authorize;
    }

    /**
     * Set createTime
     *
     * @param integer $createTime
     * @return DesignWorks
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
     * Set updateTime
     *
     * @param integer $updateTime
     * @return DesignWorks
     */
    public function setUpdateTime($updateTime)
    {
        $this->updateTime = $updateTime;
    
        return $this;
    }

    /**
     * Get updateTime
     *
     * @return integer 
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }
    /**
     * Set status
     *
     * @param integer $status
     * @return DesignWorks
     */
    public function setHits($hits)
    {
        $this->hits = $hits;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getHits()
    {
        return $this->hits;
    }
    /**
     * Set status
     *
     * @param integer $status
     * @return DesignWorks
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
