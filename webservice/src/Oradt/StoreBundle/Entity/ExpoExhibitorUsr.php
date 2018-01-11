<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExpoExhibitorUsr
 */
class ExpoExhibitorUsr
{
    /**
     * @var string
     */
    private $expoid;

    /**
     * @var string
     */
    private $userid;

    /**
     * @var string
     */
    private $bizid;

    /**
     * @var integer
     */
    private $createtime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set expoid
     *
     * @param string $expoid
     * @return ExpoExhibitorUsr
     */
    public function setExpoid($expoid)
    {
        $this->expoid = $expoid;
    
        return $this;
    }

    /**
     * Get expoid
     *
     * @return string 
     */
    public function getExpoid()
    {
        return $this->expoid;
    }

    /**
     * Set userid
     *
     * @param string $userid
     * @return ExpoExhibitorUsr
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;
    
        return $this;
    }

    /**
     * Get userid
     *
     * @return string 
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * Set bizid
     *
     * @param string $bizid
     * @return ExpoExhibitorUsr
     */
    public function setBizid($bizid)
    {
        $this->bizid = $bizid;
    
        return $this;
    }

    /**
     * Get bizid
     *
     * @return string 
     */
    public function getBizid()
    {
        return $this->bizid;
    }

    /**
     * Set createtime
     *
     * @param integer $createtime
     * @return ExpoExhibitorUsr
     */
    public function setCreatetime($createtime)
    {
        $this->createtime = $createtime;
    
        return $this;
    }

    /**
     * Get createtime
     *
     * @return integer 
     */
    public function getCreatetime()
    {
        return $this->createtime;
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
