<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CardShareList
 */
class CardShareList
{
    /**
     * @var integer
     */
    private $shareid;

    /**
     * @var string
     */
    private $vcardid;

    /**
     * @var string
     */
    private $accountid;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set shareid
     *
     * @param integer $shareid
     * @return CardShareList
     */
    public function setShareid($shareid)
    {
        $this->shareid = $shareid;
    
        return $this;
    }

    /**
     * Get shareid
     *
     * @return integer 
     */
    public function getShareid()
    {
        return $this->shareid;
    }

    /**
     * Set vcardid
     *
     * @param string $vcardid
     * @return CardShareList
     */
    public function setVcardid($vcardid)
    {
        $this->vcardid = $vcardid;
    
        return $this;
    }

    /**
     * Get vcardid
     *
     * @return string 
     */
    public function getVcardid()
    {
        return $this->vcardid;
    }

    /**
     * Set accountid
     *
     * @param string $accountid
     * @return CardShareList
     */
    public function setAccountid($accountid)
    {
        $this->accountid = $accountid;
    
        return $this;
    }

    /**
     * Get accountid
     *
     * @return string 
     */
    public function getAccountid()
    {
        return $this->accountid;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return CardShareList
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
