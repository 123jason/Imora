<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Background
 */
class Background
{
    /**
     * @var string
     */
    private $module;

    /**
     * @var string
     */
    private $picId;

    /**
     * @var string
     */
    private $account;

    /**
     * @var string
     */
    private $picPath;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set module
     *
     * @param string $module
     * @return Background
     */
    public function setModule($module)
    {
        $this->module = $module;
    
        return $this;
    }

    /**
     * Get module
     *
     * @return string 
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * Set picId
     *
     * @param string $picId
     * @return Background
     */
    public function setPicId($picId)
    {
        $this->picId = $picId;
    
        return $this;
    }

    /**
     * Get picId
     *
     * @return string 
     */
    public function getPicId()
    {
        return $this->picId;
    }

    /**
     * Set account
     *
     * @param string $account
     * @return Background
     */
    public function setAccount($account)
    {
        $this->account = $account;
    
        return $this;
    }

    /**
     * Get account
     *
     * @return string 
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set picPath
     *
     * @param string $picPath
     * @return Background
     */
    public function setPicPath($picPath)
    {
        $this->picPath = $picPath;
    
        return $this;
    }

    /**
     * Get picPath
     *
     * @return string 
     */
    public function getPicPath()
    {
        return $this->picPath;
    }

    /**
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return Background
     */
    public function setCreatedTime($createdTime)
    {
        $this->createdTime = $createdTime;
    
        return $this;
    }

    /**
     * Get createdTime
     *
     * @return \DateTime 
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
