<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DesignComment
 */
class DesignComment
{
    /**
     * @var string
     */
    private $commentId;

    /**
     * @var integer
     */
    private $projectId;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $createdUserid;

    /**
     * @var string
     */
    private $createdUsername;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set commentId
     *
     * @param string $commentId
     * @return DesignComment
     */
    public function setCommentId($commentId)
    {
        $this->commentId = $commentId;
    
        return $this;
    }

    /**
     * Get commentId
     *
     * @return string 
     */
    public function getCommentId()
    {
        return $this->commentId;
    }

    /**
     * Set projectId
     *
     * @param integer $projectId
     * @return DesignComment
     */
    public function setProjectId($projectId)
    {
        $this->projectId = $projectId;
    
        return $this;
    }

    /**
     * Get projectId
     *
     * @return integer 
     */
    public function getProjectId()
    {
        return $this->projectId;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return DesignComment
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
     * Set createdUserid
     *
     * @param string $createdUserid
     * @return DesignComment
     */
    public function setCreatedUserid($createdUserid)
    {
        $this->createdUserid = $createdUserid;
    
        return $this;
    }

    /**
     * Get createdUserid
     *
     * @return string 
     */
    public function getCreatedUserid()
    {
        return $this->createdUserid;
    }

    /**
     * Set createdUsername
     *
     * @param string $createdUsername
     * @return DesignComment
     */
    public function setCreatedUsername($createdUsername)
    {
        $this->createdUsername = $createdUsername;
    
        return $this;
    }

    /**
     * Get createdUsername
     *
     * @return string 
     */
    public function getCreatedUsername()
    {
        return $this->createdUsername;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return DesignComment
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
