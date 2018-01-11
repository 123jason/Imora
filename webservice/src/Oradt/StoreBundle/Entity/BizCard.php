<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BizCard
 */
class BizCard
{
    /**
     * @var string
     */
    private $uuid;

    /**
     * @var string
     */
    private $bizId;

    /**
     * @var string
     */
    private $toUid;
    
    /**
     * @var string
     */
    private $vcard;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $tempId;

    /**
     * @var string
     */
    private $groupId;

    /**
     * @var string
     */
    private $deliveryStatus;

    /**
     * @var string
     */
    private $picture;
    
    /**
     * @var string
     */
    private $layout;
    
    /**
     * @var integer
     */
    private $id;


    /**
     * Set uuid
     *
     * @param string $uuid
     * @return BizCard
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
     * Set bizId
     *
     * @param string $bizId
     * @return BizCard
     */
    public function setBizId($bizId)
    {
        $this->bizId = $bizId;

        return $this;
    }

    /**
     * Get bizId
     *
     * @return string 
     */
    public function getBizId()
    {
        return $this->bizId;
    }

    /**
     * Set toUid
     *
     * @param string $toUid
     * @return BizCard
     */
    public function setToUid($toUid)
    {
        $this->toUid = $toUid;

        return $this;
    }

    /**
     * Get toUid
     *
     * @return string 
     */
    public function getToUid()
    {
        return $this->toUid;
    }
    
    /**
     * Set vcard
     *
     * @param string $vcard
     * @return BizCard
     */
    public function setVcard($vcard)
    {
        $this->vcard = $vcard;

        return $this;
    }

    /**
     * Get vcard
     *
     * @return string 
     */
    public function getVcard()
    {
        return $this->vcard;
    }

    /**
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return BizCard
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
     * Set status
     *
     * @param string $status
     * @return BizCard
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
     * Set tempId
     *
     * @param string $tempId
     * @return BizCard
     */
    public function setTempId($tempId)
    {
        $this->tempId = $tempId;

        return $this;
    }

    /**
     * Get tempId
     *
     * @return string 
     */
    public function getTempId()
    {
        return $this->tempId;
    }

    /**
     * Set groupId
     *
     * @param string $groupId
     * @return BizCard
     */
    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;

        return $this;
    }

    /**
     * Get groupId
     *
     * @return string 
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * Set deliveryStatus
     *
     * @param string $deliveryStatus
     * @return BizCard
     */
    public function setDeliveryStatus($deliveryStatus)
    {
        $this->deliveryStatus = $deliveryStatus;

        return $this;
    }

    /**
     * Get deliveryStatus
     *
     * @return string 
     */
    public function getDeliveryStatus()
    {
        return $this->deliveryStatus;
    }

    /**
     * Set picture
     *
     * @param string $picture
     * @return BizCard
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return string 
     */
    public function getPicture()
    {
        return $this->picture;
    }
    
    /**
     * Set layout
     *
     * @param string $layout
     * @return BizCard
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
    
        return $this;
    }

    /**
     * Get layout
     *
     * @return string 
     */
    public function getLayout()
    {
        return $this->layout;
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
