<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ScanCardRbacOperationLog
 */
class ScanCardRbacOperationLog
{
    /**
     * @var string
     */
    private $operateId;

    /**
     * @var string
     */
    private $targetId;

    /**
     * @var string
     */
    private $targetName;

    /**
     * @var string
     */
    private $statusFrom;

    /**
     * @var string
     */
    private $statusTo;

    /**
     * @var string
     */
    private $operation;

    /**
     * @var \DateTime
     */
    private $opTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set operateId
     *
     * @param string $operateId
     * @return ScanCardRbacOperationLog
     */
    public function setOperateId($operateId)
    {
        $this->operateId = $operateId;
    
        return $this;
    }

    /**
     * Get operateId
     *
     * @return string 
     */
    public function getOperateId()
    {
        return $this->operateId;
    }

    /**
     * Set targetId
     *
     * @param string $targetId
     * @return ScanCardRbacOperationLog
     */
    public function setTargetId($targetId)
    {
        $this->targetId = $targetId;
    
        return $this;
    }

    /**
     * Get targetId
     *
     * @return string 
     */
    public function getTargetId()
    {
        return $this->targetId;
    }

    /**
     * Set targetName
     *
     * @param string $targetName
     * @return ScanCardRbacOperationLog
     */
    public function setTargetName($targetName)
    {
        $this->targetName = $targetName;
    
        return $this;
    }

    /**
     * Get targetName
     *
     * @return string 
     */
    public function getTargetName()
    {
        return $this->targetName;
    }

    /**
     * Set statusFrom
     *
     * @param string $statusFrom
     * @return ScanCardRbacOperationLog
     */
    public function setStatusFrom($statusFrom)
    {
        $this->statusFrom = $statusFrom;
    
        return $this;
    }

    /**
     * Get statusFrom
     *
     * @return string 
     */
    public function getStatusFrom()
    {
        return $this->statusFrom;
    }

    /**
     * Set statusTo
     *
     * @param string $statusTo
     * @return ScanCardRbacOperationLog
     */
    public function setStatusTo($statusTo)
    {
        $this->statusTo = $statusTo;
    
        return $this;
    }

    /**
     * Get statusTo
     *
     * @return string 
     */
    public function getStatusTo()
    {
        return $this->statusTo;
    }

    /**
     * Set operation
     *
     * @param string $operation
     * @return ScanCardRbacOperationLog
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
     * Set opTime
     *
     * @param \DateTime $opTime
     * @return ScanCardRbacOperationLog
     */
    public function setOpTime($opTime)
    {
        $this->opTime = $opTime;
    
        return $this;
    }

    /**
     * Get opTime
     *
     * @return \DateTime 
     */
    public function getOpTime()
    {
        return $this->opTime;
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
