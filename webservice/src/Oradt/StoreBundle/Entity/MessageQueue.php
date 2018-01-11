<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MessageQueue
 */
class MessageQueue
{
    /**
     * @var integer
     */
    private $type;

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
     * @var integer
     */
    private $nflag;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $modifiedTime;

    /**
     * @var integer
     */
    private $isread;

    /**
     * @var string
     */
    private $title;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set type
     *
     * @param integer $type
     * @return MessageQueue
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set toUid
     *
     * @param string $toUid
     * @return MessageQueue
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
     * @return MessageQueue
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
     * @return MessageQueue
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
     * Set nflag
     *
     * @param integer $nflag
     * @return MessageQueue
     */
    public function setNflag($nflag)
    {
        $this->nflag = $nflag;
    
        return $this;
    }

    /**
     * Get nflag
     *
     * @return integer 
     */
    public function getNflag()
    {
        return $this->nflag;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return MessageQueue
     */
    public function setCreatedTime($createdTime)
    {
        $this->createdTime = $createdTime;
    
        return $this;
    }

    /**
     * Get createdTime
     *
     * @return integer 
     */
    public function getCreatedTime()
    {
        return $this->createdTime;
    }

    /**
     * Set modifiedTime
     *
     * @param integer $modifiedTime
     * @return MessageQueue
     */
    public function setModifiedTime($modifiedTime)
    {
        $this->modifiedTime = $modifiedTime;
    
        return $this;
    }

    /**
     * Get modifiedTime
     *
     * @return integer 
     */
    public function getModifiedTime()
    {
        return $this->modifiedTime;
    }

    /**
     * Set isread
     *
     * @param integer $isread
     * @return MessageQueue
     */
    public function setIsread($isread)
    {
        $this->isread = $isread;
    
        return $this;
    }

    /**
     * Get isread
     *
     * @return integer 
     */
    public function getIsread()
    {
        return $this->isread;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return MessageQueue
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
