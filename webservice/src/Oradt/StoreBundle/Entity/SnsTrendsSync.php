<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SnsTrendsSync
 */
class SnsTrendsSync
{    
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $toUserid;

    /**
     * @var string
     */
    private $trendsId;

    /**
     * @var string
     */
    private $commentId;

    /**
     * @var integer
     */
    private $lastModified;

    /**
     * @var string
     */
    private $operation;

    /**
     * @var string
     */
    private $parameters;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return SnsTrendsSync
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
     * Set toUserid
     *
     * @param string $toUserid
     * @return SnsTrendsSync
     */
    public function setToUserid($toUserid)
    {
        $this->toUserid = $toUserid;
    
        return $this;
    }

    /**
     * Get toUserid
     *
     * @return string 
     */
    public function getToUserid()
    {
        return $this->toUserid;
    }

    /**
     * Set trendsId
     *
     * @param string $trendsId
     * @return SnsTrendsSync
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
     * Set commentId
     *
     * @param string $commentId
     * @return SnsTrendsSync
     */
    public function setCommentId($commentId)
    {
        $this->commentId = $commentId;
    
        return $this;
    }

    /**
     * Get commentId
     *
     * @return string 
     */
    public function getCommentId()
    {
        return $this->commentId;
    }

    /**
     * Set lastModified
     *
     * @param integer $lastModified
     * @return SnsTrendsSync
     */
    public function setLastModified($lastModified)
    {
        $this->lastModified = $lastModified;
    
        return $this;
    }

    /**
     * Get lastModified
     *
     * @return integer 
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     * Set operation
     *
     * @param string $operation
     * @return SnsTrendsSync
     */
    public function setOperation($operation)
    {
        $this->operation = $operation;
    
        return $this;
    }

    /**
     * Get operation
     *
     * @return string 
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * Set parameters
     *
     * @param string $parameters
     * @return SnsTrendsSync
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
    
        return $this;
    }

    /**
     * Get parameters
     *
     * @return string 
     */
    public function getParameters()
    {
        return $this->parameters;
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
    private $type;


    /**
     * Set type
     *
     * @param string $type
     * @return SnsTrendsSync
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
}
