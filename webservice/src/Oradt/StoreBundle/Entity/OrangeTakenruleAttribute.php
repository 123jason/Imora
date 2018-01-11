<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrangeTakenruleAttribute
 */
class OrangeTakenruleAttribute
{
    /**
     * @var integer
     */
    private $ruleid;

    /**
     * @var integer
     */
    private $infoid;

    /**
     * @var string
     */
    private $val;

    /**
     * @var string
     */
    private $url;

    /**
     * @var boolean
     */
    private $status;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set ruleid
     *
     * @param integer $ruleid
     * @return OrangeTakenruleAttribute
     */
    public function setRuleid($ruleid)
    {
        $this->ruleid = $ruleid;
    
        return $this;
    }

    /**
     * Get ruleid
     *
     * @return integer 
     */
    public function getRuleid()
    {
        return $this->ruleid;
    }

    /**
     * Set infoid
     *
     * @param integer $infoid
     * @return OrangeTakenruleAttribute
     */
    public function setInfoid($infoid)
    {
        $this->infoid = $infoid;
    
        return $this;
    }

    /**
     * Get infoid
     *
     * @return integer 
     */
    public function getInfoid()
    {
        return $this->infoid;
    }

    /**
     * Set val
     *
     * @param string $val
     * @return OrangeTakenruleAttribute
     */
    public function setVal($val)
    {
        $this->val = $val;
    
        return $this;
    }

    /**
     * Get val
     *
     * @return string 
     */
    public function getVal()
    {
        return $this->val;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return OrangeTakenruleAttribute
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return OrangeTakenruleAttribute
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
