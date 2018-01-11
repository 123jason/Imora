<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SnsGroupNotice
 */
class SnsGroupNotice
{
    /**
     * @var string
     */
    private $noticeId;

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
    private $memberId;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set noticeId
     *
     * @param string $noticeId
     * @return SnsGroupNotice
     */
    public function setNoticeId($noticeId)
    {
        $this->noticeId = $noticeId;
    
        return $this;
    }

    /**
     * Get noticeId
     *
     * @return string 
     */
    public function getNoticeId()
    {
        return $this->noticeId;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return SnsGroupNotice
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
     * @return SnsGroupNotice
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
     * Set memberId
     *
     * @param string $memberId
     * @return SnsGroupNotice
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
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return SnsGroupNotice
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
