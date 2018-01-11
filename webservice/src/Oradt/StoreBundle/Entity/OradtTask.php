<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OradtTask
 */
class OradtTask
{
    /**
     * @var integer
     */
    private $type;

    /**
     * @var integer
     */
    private $redeemCodeGroupid;

    /**
     * @var integer
     */
    private $uptime;

    /**
     * @var integer
     */
    private $downtime;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $adminId;

    /**
     * @var string
     */
    private $releaseAdminId;

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
     * @return OradtTask
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
     * Set redeemCodeGroupid
     *
     * @param integer $redeemCodeGroupid
     * @return OradtTask
     */
    public function setRedeemCodeGroupid($redeemCodeGroupid)
    {
        $this->redeemCodeGroupid = $redeemCodeGroupid;
    
        return $this;
    }

    /**
     * Get redeemCodeGroupid
     *
     * @return integer 
     */
    public function getRedeemCodeGroupid()
    {
        return $this->redeemCodeGroupid;
    }

    /**
     * Set uptime
     *
     * @param integer $uptime
     * @return OradtTask
     */
    public function setUptime($uptime)
    {
        $this->uptime = $uptime;
    
        return $this;
    }

    /**
     * Get uptime
     *
     * @return integer 
     */
    public function getUptime()
    {
        return $this->uptime;
    }

    /**
     * Set downtime
     *
     * @param integer $downtime
     * @return OradtTask
     */
    public function setDowntime($downtime)
    {
        $this->downtime = $downtime;
    
        return $this;
    }

    /**
     * Get downtime
     *
     * @return integer 
     */
    public function getDowntime()
    {
        return $this->downtime;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return OradtTask
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
     * Set adminId
     *
     * @param string $adminId
     * @return OradtTask
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
     * Set releaseAdminId
     *
     * @param string $releaseAdminId
     * @return OradtTask
     */
    public function setReleaseAdminId($releaseAdminId)
    {
        $this->releaseAdminId = $releaseAdminId;
    
        return $this;
    }

    /**
     * Get releaseAdminId
     *
     * @return string 
     */
    public function getReleaseAdminId()
    {
        return $this->releaseAdminId;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return OradtTask
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
     * @return OradtTask
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
