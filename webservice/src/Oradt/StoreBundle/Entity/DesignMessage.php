<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DesignMessage
 */
class DesignMessage
{
    /**
     * @var string
     */
    private $messageId;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $userid;

    /**
     * @var integer
     */
    private $createTime;

    /**
     * @var boolean
     */
    private $status;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set messageId
     *
     * @param string $messageId
     * @return DesignMessage
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
     * Set title
     *
     * @param string $title
     * @return DesignMessage
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return DesignMessage
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
     * Set userid
     *
     * @param string $userid
     * @return DesignMessage
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;

        return $this;
    }

    /**
     * Get userid
     *
     * @return string 
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * Set createTime
     *
     * @param integer $createTime
     * @return DesignMessage
     */
    public function setCreateTime($createTime)
    {
        $this->createTime = $createTime;

        return $this;
    }

    /**
     * Get createTime
     *
     * @return integer 
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return DesignMessage
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean 
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
    /**
     * @var boolean
     */
    private $type;


    /**
     * Set type
     *
     * @param boolean $type
     * @return DesignMessage
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return boolean 
     */
    public function getType()
    {
        return $this->type;
    }
}
