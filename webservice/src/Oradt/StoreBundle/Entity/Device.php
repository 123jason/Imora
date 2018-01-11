<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Device
 */
class Device
{
    /**
     * @var string
     */
    private $deviceId;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $serialNumber;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $mobile;

    /**
     * @var string
     */
    private $status;

    /**
     * @var \DateTime
     */
    private $statusUpdateTime;

    /**
     * @var string
     */
    private $lockPasswd;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set deviceId
     *
     * @param string $deviceId
     * @return Device
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
     * Set userId
     *
     * @param string $userId
     * @return Device
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
     * Set serialNumber
     *
     * @param string $serialNumber
     * @return Device
     */
    public function setSerialNumber($serialNumber)
    {
        $this->serialNumber = $serialNumber;

        return $this;
    }

    /**
     * Get serialNumber
     *
     * @return string 
     */
    public function getSerialNumber()
    {
        return $this->serialNumber;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Device
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
     * Set mobile
     *
     * @param string $mobile
     * @return Device
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Get mobile
     *
     * @return string 
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Device
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
     * Set statusUpdateTime
     *
     * @param \DateTime $statusUpdateTime
     * @return Device
     */
    public function setStatusUpdateTime($statusUpdateTime)
    {
        $this->statusUpdateTime = $statusUpdateTime;

        return $this;
    }

    /**
     * Get statusUpdateTime
     *
     * @return \DateTime 
     */
    public function getStatusUpdateTime()
    {
        return $this->statusUpdateTime;
    }

    /**
     * Set lockPasswd
     *
     * @param string $lockPasswd
     * @return Device
     */
    public function setLockPasswd($lockPasswd)
    {
        $this->lockPasswd = $lockPasswd;

        return $this;
    }

    /**
     * Get lockPasswd
     *
     * @return string 
     */
    public function getLockPasswd()
    {
        return $this->lockPasswd;
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
