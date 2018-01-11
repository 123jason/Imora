<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountBizPushlog
 */
class AccountBizPushlog
{
    /**
     * @var integer
     */
    private $type;

    /**
     * @var integer
     */
    private $sendtype;

    /**
     * @var string
     */
    private $bizId;

    /**
     * @var string
     */
    private $numId;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $jsonparam;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set type
     *
     * @param integer $type
     * @return AccountBizPushlog
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
     * @return AccountBizPushlog
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
     * Set bizId
     *
     * @param string $bizId
     * @return AccountBizPushlog
     */
    public function setBizId($bizId)
    {
        $this->bizId = $bizId;
    
        return $this;
    }

    /**
     * Get bizId
     *
     * @return string 
     */
    public function getBizId()
    {
        return $this->bizId;
    }

    /**
     * Set numId
     *
     * @param string $numId
     * @return AccountBizPushlog
     */
    public function setNumId($numId)
    {
        $this->numId = $numId;
    
        return $this;
    }

    /**
     * Get numId
     *
     * @return string 
     */
    public function getNumId()
    {
        return $this->numId;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return AccountBizPushlog
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
     * Set jsonparam
     *
     * @param string $jsonparam
     * @return AccountBizPushlog
     */
    public function setJsonparam($jsonparam)
    {
        $this->jsonparam = $jsonparam;
    
        return $this;
    }

    /**
     * Get jsonparam
     *
     * @return string 
     */
    public function getJsonparam()
    {
        return $this->jsonparam;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return AccountBizPushlog
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
     * Set createdTime
     *
     * @param integer $createdTime
     * @return AccountBizPushlog
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
