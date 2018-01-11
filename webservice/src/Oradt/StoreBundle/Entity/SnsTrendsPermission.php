<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SnsTrendsPermission
 */
class SnsTrendsPermission
{
    /**
     * @var string
     */
    private $trendsId;

    /**
     * @var string
     */
    private $type;

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
     * Set trendsId
     *
     * @param string $trendsId
     * @return SnsTrendsPermission
     */
    public function setTrendsId($trendsId)
    {
        $this->trendsId = $trendsId;
    
        return $this;
    }

    /**
     * Get trendsId
     *
     * @return string 
     */
    public function getTrendsId()
    {
        return $this->trendsId;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return SnsTrendsPermission
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
     * Set accountId
     *
     * @param string $accountId
     * @return SnsTrendsPermission
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
     * @return SnsTrendsPermission
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
