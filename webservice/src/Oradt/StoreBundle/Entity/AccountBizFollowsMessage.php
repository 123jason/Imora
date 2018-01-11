<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountBizFollowsMessage
 */
class AccountBizFollowsMessage
{

    /**
     * @var string
     */
    private $publicId;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $content;

    /**
     * @var integer
     */
    private $createTime;
    
    /**
     * @var integer
     */
    private $status;

    /**
     * @var integer
     */
    private $id;


   /**
     * Set publicId
     *
     * @param string $publicId
     * @return AccountBizFollowsMessage
     */
    public function setPublicId($publicId)
    {
        $this->publicId = $publicId;
    
        return $this;
    }

    /**
     * Get numId
     *
     * @return string 
     */
    public function getPublicId()
    {
        return $this->publicId;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return AccountBizFollowsMessage
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
     * Set content
     *
     * @param string $content
     * @return AccountBizFollowsMessage
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
     * Set createTime
     *
     * @param integer $createTime
     * @return AccountBizFollowsMessage
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
     * @param integer $status
     * @return AccountBizFollowsMessage
     */
    public function setStatus($status)
    {
    	$this->status = $status;
    
    	return $this;
    }
    
    /**
     * Get status
     *
     * @return integer
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
}
