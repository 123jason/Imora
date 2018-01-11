<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MessageTalk
 */
class MessageTalk
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
    private $status;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var \DateTime
     */
    private $readTime;

    /**
     * @var string
     */
    private $fromStatus;

    /**
     * @var string
     */
    private $toStatus;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set msgId
     *
     * @param string $msgId
     * @return MessageTalk
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
     * @return MessageTalk
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
     * @return MessageTalk
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
     * @return MessageTalk
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
     * @return MessageTalk
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
     * Set status
     *
     * @param string $status
     * @return MessageTalk
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
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return MessageTalk
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
     * Set readTime
     *
     * @param \DateTime $readTime
     * @return MessageTalk
     */
    public function setReadTime($readTime)
    {
        $this->readTime = $readTime;

        return $this;
    }

    /**
     * Get readTime
     *
     * @return \DateTime 
     */
    public function getReadTime()
    {
        return $this->readTime;
    }

    /**
     * Set fromStatus
     *
     * @param string $fromStatus
     * @return MessageTalk
     */
    public function setFromStatus($fromStatus)
    {
        $this->fromStatus = $fromStatus;

        return $this;
    }

    /**
     * Get fromStatus
     *
     * @return string 
     */
    public function getFromStatus()
    {
        return $this->fromStatus;
    }

    /**
     * Set toStatus
     *
     * @param string $toStatus
     * @return MessageTalk
     */
    public function setToStatus($toStatus)
    {
        $this->toStatus = $toStatus;

        return $this;
    }

    /**
     * Get toStatus
     *
     * @return string 
     */
    public function getToStatus()
    {
        return $this->toStatus;
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
