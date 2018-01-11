<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DesignAttachments
 */
class DesignBiddingAttachments
{
    /**
     * @var string
     */
    private $attachId;

    /**
     * @var string
     */
    private $biddingId;

    /**
     * @var string
     */
    private $pathUrl;

    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $size;

    /**
     * @var integer
     */
    private $createTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set attachId
     *
     * @param string $attachId
     * @return DesignAttachments
     */
    public function setAttachId($attachId)
    {
        $this->attachId = $attachId;
    
        return $this;
    }

    /**
     * Get attachId
     *
     * @return string 
     */
    public function getAttachId()
    {
        return $this->attachId;
    }

    /**
     * Set biddingId
     *
     * @param string $biddingId
     * @return DesignAttachments
     */
    public function setBiddingId($biddingId)
    {
        $this->biddingId = $biddingId;
    
        return $this;
    }

    /**
     * Get biddingId
     *
     * @return string 
     */
    public function getBiddingId()
    {
        return $this->biddingId;
    }

    /**
     * Set Pathurl
     *
     * @param string $url
     * @return DesignAttachments
     */
    public function setPathUrl($pathUrl)
    {
        $this->pathUrl = $pathUrl;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getPathUrl()
    {
        return $this->pathUrl;
    }

    /**
     * Set downloads
     *
     * @param integer $downloads
     * @return DesignAttachments
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set sort
     *
     * @param integer $sort
     * @return DesignAttachments
     */
    public function setSize($size)
    {
        $this->size = $size;
    
        return $this;
    }

    /**
     * Get sort
     *
     * @return integer 
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set createTime
     *
     * @param integer $createTime
     * @return DesignAttachments
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
