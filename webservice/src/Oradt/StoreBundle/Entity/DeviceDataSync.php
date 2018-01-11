<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DeviceData
 */
class DeviceDataSync
{
    
    
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $deviceId;

    /**
     * @var string
     */
    private $moduleId;

    /**
     * @var \DateTime
     */
    private $lastModified;

    /**
     * @var string
     */
    private $operation;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return DeviceDataSync
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
     * Set deviceId
     *
     * @param string $deviceId
     * @return DeviceDataSync
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
     * Set moduleId
     *
     * @param string $moduleId
     * @return DeviceDataSync
     */
    public function setModuleId($moduleId)
    {
        $this->moduleId = $moduleId;
    
        return $this;
    }

    /**
     * Get moduleId
     *
     * @return string 
     */
    public function getModuleId()
    {
        return $this->moduleId;
    }

    /**
     * Set lastModified
     *
     * @param \DateTime $lastModified
     * @return DeviceDataSync
     */
    public function setLastModified($lastModified)
    {
        $this->lastModified = $lastModified;
    
        return $this;
    }

    /**
     * Get lastModified
     *
     * @return \DateTime 
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     * Set operation
     *
     * @param string $operation
     * @return DeviceDataSync
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
