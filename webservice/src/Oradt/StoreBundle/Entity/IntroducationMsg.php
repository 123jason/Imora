<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IntroducationMsg
 */
class IntroducationMsg
{
    /**
     * @var string
     */
    private $msgId;

    /**
     * @var string
     */
    private $mapId;

    /**
     * @var string
     */
    private $fromUid;

    /**
     * @var string
     */
    private $toUid;

    /**
     * @var string
     */
    private $content;

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
     * @var string
     */
    private $handleResult;

    /**
     * Set msgId
     *
     * @param string $msgId
     * @return IntroducationMsg
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
     * Set mapId
     *
     * @param string $mapId
     * @return IntroducationMsg
     */
    public function setMapId($mapId)
    {
        $this->mapId = $mapId;

        return $this;
    }

    /**
     * Get mapId
     *
     * @return string 
     */
    public function getMapId()
    {
        return $this->mapId;
    }

    /**
     * Set fromUid
     *
     * @param string $fromUid
     * @return IntroducationMsg
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
     * Set toUid
     *
     * @param string $toUid
     * @return IntroducationMsg
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
     * Set content
     *
     * @param string $content
     * @return IntroducationMsg
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
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return IntroducationMsg
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
     * @return IntroducationMsg
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
