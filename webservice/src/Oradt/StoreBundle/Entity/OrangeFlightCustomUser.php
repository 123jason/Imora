<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrangeFlightCustomUser
 */
class OrangeFlightCustomUser
{
    /**
     * @var integer
     */
    private $fid;

    /**
     * @var string
     */
    private $accountId;

    /**
     * @var integer
     */
    private $modifyTime;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var string
     */
    private $sendstate;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set fid
     *
     * @param integer $fid
     * @return OrangeFlightCustomUser
     */
    public function setFid($fid)
    {
        $this->fid = $fid;
    
        return $this;
    }

    /**
     * Get fid
     *
     * @return integer 
     */
    public function getFid()
    {
        return $this->fid;
    }

    /**
     * Set accountId
     *
     * @param string $accountId
     * @return OrangeFlightCustomUser
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
     * Set modifyTime
     *
     * @param integer $modifyTime
     * @return OrangeFlightCustomUser
     */
    public function setModifyTime($modifyTime)
    {
        $this->modifyTime = $modifyTime;
    
        return $this;
    }

    /**
     * Get modifyTime
     *
     * @return integer 
     */
    public function getModifyTime()
    {
        return $this->modifyTime;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return OrangeFlightCustomUser
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
     * Set sendstate
     *
     * @param string $sendstate
     * @return OrangeFlightCustomUser
     */
    public function setSendstate($sendstate)
    {
        $this->sendstate = $sendstate;
    
        return $this;
    }

    /**
     * Get sendstate
     *
     * @return string 
     */
    public function getSendstate()
    {
        return $this->sendstate;
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
