<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContactRelationPermission
 */
class ContactRelationPermission
{
    /**
     * @var string
     */
    private $fromUid;

    /**
     * @var string
     */
    private $toUid;

    /**
     * @var boolean
     */
    private $status;

    /**
     * @var integer
     */
    private $lastModified;

    /**
     * @var integer
     */
    private $lastPush;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set fromUid
     *
     * @param string $fromUid
     * @return ContactRelationPermission
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
     * @return ContactRelationPermission
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
     * Set status
     *
     * @param boolean $status
     * @return ContactRelationPermission
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
     * Set lastModified
     *
     * @param integer $lastModified
     * @return ContactRelationPermission
     */
    public function setLastModified($lastModified)
    {
        $this->lastModified = $lastModified;
    
        return $this;
    }

    /**
     * Get lastModified
     *
     * @return integer 
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     * Set lastPush
     *
     * @param integer $lastPush
     * @return ContactRelationPermission
     */
    public function setLastPush($lastPush)
    {
        $this->lastPush = $lastPush;
    
        return $this;
    }

    /**
     * Get lastPush
     *
     * @return integer 
     */
    public function getLastPush()
    {
        return $this->lastPush;
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
