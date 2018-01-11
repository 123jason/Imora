<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountBasic
 */
class PushToken
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $accountId;

    /**
     * @var string
     */
    private $deviceToken;

    /**
     * @var string
     */
    private $deviceId;


    /**
     * @var enum('android','ios')
     */
    private $deviceType;

    /**
     * @var string
     */
    private $tags;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var integer
     */
    private $count;
    
    /**
     * @var string
     */
    private $sessionId;

    /**
     * @var integer
     */
    private $id;

    /**
     * Set userId
     *
     * @param string $userId
     * @return AccountBasic
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
     * Set AccountId
     *
     * @param string $accountId
     * @return PushToken
     */
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;

        return $this;
    }

    /**
     * Get AccountId
     *
     * @return string
     */
    public function getAccountId()
    {
        return $this->accountId;
    }

    /**
     * Set deviceToken
     *
     * @param string $deviceToken
     * @return PushToken
     */
    public function setDeviceToken($deviceToken)
    {
        $this->deviceToken = $deviceToken;

        return $this;
    }

    /**
     * Get deviceToken
     *
     * @return string
     */
    public function getDeviceToken()
    {
        return $this->deviceToken;
    }

    /**
     * Set deviceId
     *
     * @param string $deviceId
     * @return PushToken
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
     * Set deviceType
     *
     * @param string $deviceType
     * @return PushToken
     */
    public function setDeviceType($deviceType)
    {
        $this->deviceType = $deviceType;

        return $this;
    }

    /**
     * Get deviceType
     *
     * @return string
     */
    public function getDeviceType()
    {
        return $this->deviceType;
    }


    /**
     * Set tags
     *
     * @param string $deviceType
     * @return PushToken
     */
    public function setTags($tag)
    {
        $this->tags = $tag;

        return $this;
    }

    /**
     * Get tags
     *
     * @return string
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return PushToken
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
     * Set count
     *
     * @param integer $count
     * @return PushToken
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Get count
     *
     * @return integer
     */
    public function getCount()
    {
        return $this->count;
    }
    /**
     * Set sessionId
     *
     * @param string $sessionId
     * @return PushToken
     */
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    /**
     * Get sessionId
     *
     * @return string
     */
    public function getSessionId()
    {
        return $this->sessionId;
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
