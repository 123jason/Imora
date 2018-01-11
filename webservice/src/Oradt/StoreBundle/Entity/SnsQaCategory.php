<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SnsQaCategory
 */
class SnsQaCategory
{
    /**
     * @var string
     */
    private $category;

    /**
     * @var integer
     */
    private $createTime;

    /**
     * @var string
     */
    private $creatUser;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set category
     *
     * @param string $category
     * @return SnsQaCategory
     */
    public function setCategory($category)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return string 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set createTime
     *
     * @param integer $createTime
     * @return SnsQaCategory
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
     * Set creatUser
     *
     * @param string $creatUser
     * @return SnsQaCategory
     */
    public function setCreatUser($creatUser)
    {
        $this->creatUser = $creatUser;
    
        return $this;
    }

    /**
     * Get creatUser
     *
     * @return string 
     */
    public function getCreatUser()
    {
        return $this->creatUser;
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
    /**
     * @var string
     */
    private $accountId;


    /**
     * Set accountId
     *
     * @param string $accountId
     * @return SnsQaCategory
     */
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;
    
        return $this;
    }

    /**
     * Get accountId
     *
     * @return string 
     */
    public function getAccountId()
    {
        return $this->accountId;
    }
}
