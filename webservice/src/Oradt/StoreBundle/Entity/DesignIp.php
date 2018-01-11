<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DesignIp
 */
class DesignIp
{
    /**
     * @var boolean
     */
    private $type;

    /**
     * @var integer
     */
    private $ip;

    /**
     * @var integer
     */
    private $addtime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set type
     *
     * @param boolean $type
     * @return DesignIp
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return boolean 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set ip
     *
     * @param integer $ip
     * @return DesignIp
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    
        return $this;
    }

    /**
     * Get ip
     *
     * @return integer 
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set addtime
     *
     * @param integer $addtime
     * @return DesignIp
     */
    public function setAddtime($addtime)
    {
        $this->addtime = $addtime;
    
        return $this;
    }

    /**
     * Get addtime
     *
     * @return integer 
     */
    public function getAddtime()
    {
        return $this->addtime;
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
