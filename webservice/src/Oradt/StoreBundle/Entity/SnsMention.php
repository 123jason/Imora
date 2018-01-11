<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SnsMention
 */
class SnsMention
{
    /**
     * @var string
     */
    private $mentionId;

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
    private $userId;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set mentionId
     *
     * @param string $mentionId
     * @return SnsMention
     */
    public function setMentionId($mentionId)
    {
        $this->mentionId = $mentionId;
    
        return $this;
    }

    /**
     * Get mentionId
     *
     * @return string 
     */
    public function getMentionId()
    {
        return $this->mentionId;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return SnsMention
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
     * @return SnsMention
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
     * Set userId
     *
     * @param string $userId
     * @return SnsMention
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
