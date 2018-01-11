<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SnsNewsInterest
 */
class SnsNewsInterest
{
    /**
     * @var string
     */
    private $uuid;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $newsId;

    /**
     * @var string
     */
    private $accountId;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set uuid
     *
     * @param string $uuid
     * @return SnsNewsInterest
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    
        return $this;
    }

    /**
     * Get uuid
     *
     * @return string 
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return SnsNewsInterest
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set newsId
     *
     * @param string $newsId
     * @return SnsNewsInterest
     */
    public function setNewsId($newsId)
    {
        $this->newsId = $newsId;
    
        return $this;
    }

    /**
     * Get newsId
     *
     * @return string 
     */
    public function getNewsId()
    {
        return $this->newsId;
    }

    /**
     * Set accountId
     *
     * @param string $accountId
     * @return SnsNewsInterest
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

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return SnsNewsInterest
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
