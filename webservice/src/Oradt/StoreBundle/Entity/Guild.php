<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Guild
 */
class Guild
{
    /**
     * @var string
     */
    private $guildId;

    /**
     * @var string
     */
    private $adminId;

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
    private $remark;

    /**
     * @var \DateTime
     */
    private $createdDate;

    /**
     * @var string
     */
    private $logoPath;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set guildId
     *
     * @param string $guildId
     * @return Guild
     */
    public function setGuildId($guildId)
    {
        $this->guildId = $guildId;
    
        return $this;
    }

    /**
     * Get guildId
     *
     * @return string 
     */
    public function getGuildId()
    {
        return $this->guildId;
    }

    /**
     * Set adminId
     *
     * @param string $adminId
     * @return Guild
     */
    public function setAdminId($adminId)
    {
        $this->adminId = $adminId;
    
        return $this;
    }

    /**
     * Get adminId
     *
     * @return string 
     */
    public function getAdminId()
    {
        return $this->adminId;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Guild
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
     * @return Guild
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
     * Set remark
     *
     * @param string $remark
     * @return Guild
     */
    public function setRemark($remark)
    {
        $this->remark = $remark;
    
        return $this;
    }

    /**
     * Get remark
     *
     * @return string 
     */
    public function getRemark()
    {
        return $this->remark;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return Guild
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;
    
        return $this;
    }

    /**
     * Get createdDate
     *
     * @return \DateTime 
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Set logoPath
     *
     * @param string $logoPath
     * @return Guild
     */
    public function setLogoPath($logoPath)
    {
        $this->logoPath = $logoPath;
    
        return $this;
    }

    /**
     * Get logoPath
     *
     * @return string 
     */
    public function getLogoPath()
    {
        return $this->logoPath;
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
