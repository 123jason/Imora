<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SnsTags
 */
class SnsTags
{
    /**
     * @var string
     */
    private $tagId;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $fromUid;

    /**
     * @var string
     */
    private $toUid;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set tagId
     *
     * @param string $tagId
     * @return SnsTags
     */
    public function setTagId($tagId)
    {
        $this->tagId = $tagId;
    
        return $this;
    }

    /**
     * Get tagId
     *
     * @return string 
     */
    public function getTagId()
    {
        return $this->tagId;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return SnsTags
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
     * Set fromUid
     *
     * @param string $fromUid
     * @return SnsTags
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
     * @return SnsTags
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
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return SnsTags
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
