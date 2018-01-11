<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DeviceData
 */
class DeviceData
{
    /**
     * @var string
     */
    private $moduleId;

    /**
     * @var string
     */
    private $deviceId;

    /**
     * @var string
     */
    private $module;

    /**
     * @var string
     */
    private $metadata;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set moduleId
     *
     * @param string $moduleId
     * @return DeviceData
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
     * Set deviceId
     *
     * @param string $deviceId
     * @return DeviceData
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
     * Set module
     *
     * @param string $module
     * @return DeviceData
     */
    public function setModule($module)
    {
        $this->module = $module;

        return $this;
    }

    /**
     * Get module
     *
     * @return string 
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * Set metadata
     *
     * @param string $metadata
     * @return DeviceData
     */
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;

        return $this;
    }

    /**
     * Get metadata
     *
     * @return string 
     */
    public function getMetadata()
    {
        return $this->metadata;
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
     * @var \DateTime
     */
    private $lastModified;

    /**
     * @var \DateTime
     */
    private $createdTime;


    /**
     * Set lastModified
     *
     * @param \DateTime $lastModified
     * @return DeviceData
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
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return DeviceData
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
}
