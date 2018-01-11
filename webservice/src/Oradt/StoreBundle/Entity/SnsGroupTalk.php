<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SnsGroupTalk
 */
class SnsGroupTalk
{
    /**
     * @var string
     */
    private $msgId;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $groupId;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $filePath;

    /**
     * @var string
     */
    private $memberId;

    /**
     * @var string
     */
    private $nickName;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set msgId
     *
     * @param string $msgId
     * @return SnsGroupTalk
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
     * Set content
     *
     * @param string $content
     * @return SnsGroupTalk
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
     * Set groupId
     *
     * @param string $groupId
     * @return SnsGroupTalk
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
     * Set type
     *
     * @param string $type
     * @return SnsGroupTalk
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
     * @return SnsGroupTalk
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
     * Set memberId
     *
     * @param string $memberId
     * @return SnsGroupTalk
     */
    public function setMemberId($memberId)
    {
        $this->memberId = $memberId;
    
        return $this;
    }

    /**
     * Get memberId
     *
     * @return string 
     */
    public function getMemberId()
    {
        return $this->memberId;
    }

    /**
     * Set nickName
     *
     * @param string $nickName
     * @return SnsGroupTalk
     */
    public function setNickName($nickName)
    {
        $this->nickName = $nickName;
    
        return $this;
    }

    /**
     * Get nickName
     *
     * @return string 
     */
    public function getNickName()
    {
        return $this->nickName;
    }

    /**
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return SnsGroupTalk
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
