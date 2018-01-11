<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DeviceInstruction
 */
class DeviceInstruction 
{
    /**
     * @var string
     */
    private $deviceId;

    /**
     * @var string
     */
    private $instructionId;

    /**
     * @var string
     */
    private $instruction;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var string
     */
    private $execResult;

    /**
     * @var \DateTime
     */
    private $execTime;

    /**
     * @var string
     */
    private $status;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set deviceId
     *
     * @param string $deviceId
     * @return DeviceInstruction
     */
    public function setDeviceId($deviceId)
    {
        $this->deviceId = $deviceId;
    
        return $this;
    }

    /**
     * Get deviceId
     *
     * @return string 
     */
    public function getDeviceId()
    {
        return $this->deviceId;
    }

    /**
     * Set instructionId
     *
     * @param string $instructionId
     * @return DeviceInstruction
     */
    public function setInstructionId($instructionId)
    {
        $this->instructionId = $instructionId;
    
        return $this;
    }

    /**
     * Get instructionId
     *
     * @return string 
     */
    public function getInstructionId()
    {
        return $this->instructionId;
    }

    /**
     * Set instruction
     *
     * @param string $instruction
     * @return DeviceInstruction
     */
    public function setInstruction($instruction)
    {
        $this->instruction = $instruction;
    
        return $this;
    }

    /**
     * Get instruction
     *
     * @return string 
     */
    public function getInstruction()
    {
        return $this->instruction;
    }

    /**
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return DeviceInstruction
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
     * Set execResult
     *
     * @param string $execResult
     * @return DeviceInstruction
     */
    public function setExecResult($execResult)
    {
        $this->execResult = $execResult;
    
        return $this;
    }

    /**
     * Get execResult
     *
     * @return string 
     */
    public function getExecResult()
    {
        return $this->execResult;
    }

    /**
     * Set execTime
     *
     * @param \DateTime $execTime
     * @return DeviceInstruction
     */
    public function setExecTime($execTime)
    {
        $this->execTime = $execTime;
    
        return $this;
    }

    /**
     * Get execTime
     *
     * @return \DateTime 
     */
    public function getExecTime()
    {
        return $this->execTime;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return DeviceInstruction
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return string 
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
