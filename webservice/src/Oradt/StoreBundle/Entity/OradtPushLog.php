<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OradtPushLog
 */
class OradtPushLog
{
    /**
     * @var string
     */
    private $publicId;

    /**
     * @var string
     */
    private $accountId;

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
    private $type;

    /**
     * @var integer
     */
    private $sendtype;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set publicId
     *
     * @param string $publicId
     * @return OradtPushLog
     */
    public function setPublicId($publicId)
    {
        $this->publicId = $publicId;
    
        return $this;
    }

    /**
     * Get publicId
     *
     * @return string 
     */
    public function getPublicId()
    {
        return $this->publicId;
    }

    /**
     * Set accountId
     *
     * @param string $accountId
     * @return OradtPushLog
     */
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;
    
        return $this;
    }

    /**
     * Get accountId
     *
     * @return string 
     */
    public function getAccountId()
    {
        return $this->accountId;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return OradtPushLog
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
     * @return OradtPushLog
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
     * @return OradtPushLog
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
     * Set type
     *
     * @param integer $type
     * @return OradtPushLog
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
     * Set sendtype
     *
     * @param integer $sendtype
     * @return OradtPushLog
     */
    public function setSendtype($sendtype)
    {
        $this->sendtype = $sendtype;
    
        return $this;
    }

    /**
     * Get sendtype
     *
     * @return integer 
     */
    public function getSendtype()
    {
        return $this->sendtype;
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
