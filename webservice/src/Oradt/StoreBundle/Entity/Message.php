<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 */
class Message
{
    /**
     * @var string
     */
    private $messageId;

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
    private $parameters;

    /**
     * @var string
     */
    private $type;

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
    private $handleResult;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set messageId
     *
     * @param string $messageId
     * @return Message
     */
    public function setMessageId($messageId)
    {
        $this->messageId = $messageId;

        return $this;
    }

    /**
     * Get messageId
     *
     * @return string 
     */
    public function getMessageId()
    {
        return $this->messageId;
    }

    /**
     * Set toUid
     *
     * @param string $toUid
     * @return Message
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
     * @return Message
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
     * @return Message
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
     * @return Message
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
     * Set parameters
     *
     * @param string $parameters
     * @return Message
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Get parameters
     *
     * @return string 
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Message
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
     * Set status
     *
     * @param string $status
     * @return Message
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
     * @return Message
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
     * @return Message
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
     * Set handleResult
     *
     * @param string $handleResult
     * @return Message
     */
    public function setHandleResult($handleResult)
    {
        $this->handleResult = $handleResult;

        return $this;
    }

    /**
     * Get handleResult
     *
     * @return string 
     */
    public function getHandleResult()
    {
        return $this->handleResult;
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
