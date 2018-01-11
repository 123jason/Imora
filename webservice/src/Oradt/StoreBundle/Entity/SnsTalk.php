<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SnsTalk
 */
class SnsTalk
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
    private $content;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $filePath;

    /**
     * @var \DateTime
     */
    private $createdTime;

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
     * @var string
     */
    //private $senderName;


    /**
     * Set senderName
     *
     * @param string $senderName
     * @return SnsTalk
     */
   /* public function setSenderName($senderName)
    {
        $this->senderName = $senderName;

        return $this;
    }*/

    /**
     * Get senderName
     *
     * @return string
     */
   /* public function getSenderName()
    {
        return $this->senderName;
    }*/


    /**
     * Set msgId
     *
     * @param string $msgId
     * @return SnsTalk
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
     * @return SnsTalk
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
     * @return SnsTalk
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
     * Set content
     *
     * @param string $content
     * @return SnsTalk
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
     * @return SnsTalk
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
     * Set filePath
     *
     * @param string $filePath
     * @return SnsTalk
     */
    public function setFilePath($filePath)
    {
        $this->filePath = $filePath;
    
        return $this;
    }

    /**
     * Get filePath
     *
     * @return string 
     */
    public function getFilePath()
    {
        return $this->filePath;
    }

    /**
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return SnsTalk
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
     * Set fromStatus
     *
     * @param string $fromStatus
     * @return SnsTalk
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
     * @return SnsTalk
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
