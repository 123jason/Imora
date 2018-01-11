<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notification
 */
class Notification
{
    /**
     * @var string
     */
    private $msgId;

    /**
     * @var string
     */
    private $toUid;

    /**
     * @var string
     */
    private $fromUid;

    /**
     * @var string
     */
    private $senderName;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $type;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var string
     */
    private $status;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set msgId
     *
     * @param string $msgId
     * @return Notification
     */
    public function setMsgId($msgId)
    {
        $this->msgId = $msgId;

        return $this;
    }

    /**
     * Get msgId
     *
     * @return string 
     */
    public function getMsgId()
    {
        return $this->msgId;
    }

    /**
     * Set toUid
     *
     * @param string $toUid
     * @return Notification
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
     * Set fromUid
     *
     * @param string $fromUid
     * @return Notification
     */
    public function setFromUid($fromUid)
    {
        $this->fromUid = $fromUid;

        return $this;
    }

    /**
     * Get fromUid
     *
     * @return string 
     */
    public function getFromUid()
    {
        return $this->fromUid;
    }

    /**
     * Set senderName
     *
     * @param string $senderName
     * @return Notification
     */
    public function setSenderName($senderName)
    {
        $this->senderName = $senderName;

        return $this;
    }

    /**
     * Get senderName
     *
     * @return string 
     */
    public function getSenderName()
    {
        return $this->senderName;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Notification
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Notification
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
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return Notification
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
     * @return Notification
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
