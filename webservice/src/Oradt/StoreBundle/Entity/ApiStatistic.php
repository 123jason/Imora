<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ApiStatistic
 */
class ApiStatistic
{
    /**
     * @var string
     */
    private $uuid;

    /**
     * @var \DateTime
     */
    private $dateTime;

    /**
     * @var string
     */
    private $apiName;

    /**
     * @var string
     */
    private $method;

    /**
     * @var integer
     */
    private $callTimes;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set uuid
     *
     * @param string $uuid
     * @return ApiStatistic
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
     * Set dateTime
     *
     * @param \DateTime $dateTime
     * @return ApiStatistic
     */
    public function setDateTime($dateTime)
    {
        $this->dateTime = $dateTime;

        return $this;
    }

    /**
     * Get dateTime
     *
     * @return \DateTime 
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }

    /**
     * Set apiName
     *
     * @param string $apiName
     * @return ApiStatistic
     */
    public function setApiName($apiName)
    {
        $this->apiName = $apiName;

        return $this;
    }

    /**
     * Get apiName
     *
     * @return string 
     */
    public function getApiName()
    {
        return $this->apiName;
    }

    /**
     * Set method
     *
     * @param string $method
     * @return ApiStatistic
     */
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Get method
     *
     * @return string 
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Set callTimes
     *
     * @param integer $callTimes
     * @return ApiStatistic
     */
    public function setCallTimes($callTimes)
    {
        $this->callTimes = $callTimes;

        return $this;
    }

    /**
     * Get callTimes
     *
     * @return integer 
     */
    public function getCallTimes()
    {
        return $this->callTimes;
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
