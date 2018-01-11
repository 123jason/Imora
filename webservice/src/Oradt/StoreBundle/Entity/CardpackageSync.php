<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CardpackageSync
 */
class CardpackageSync
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var \DateTime
     */
    private $modifedtime;

    /**
     * @var string
     */
    private $uuid;

    /**
     * @var string
     */
    private $module;

    /**
     * @var string
     */
    private $operation;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return CardpackageSync
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    
        return $this;
    }

    /**
     * Get userId
     *
     * @return string 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set modifedtime
     *
     * @param \DateTime $modifedtime
     * @return CardpackageSync
     */
    public function setModifedtime($modifedtime)
    {
        $this->modifedtime = $modifedtime;
    
        return $this;
    }

    /**
     * Get modifedtime
     *
     * @return \DateTime 
     */
    public function getModifedtime()
    {
        return $this->modifedtime;
    }

    /**
     * Set uuid
     *
     * @param string $uuid
     * @return CardpackageSync
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    
        return $this;
    }

    /**
     * Get uuid
     *
     * @return string 
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set module
     *
     * @param string $module
     * @return CardpackageSync
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
     * Set operation
     *
     * @param string $operation
     * @return CardpackageSync
     */
    public function setOperation($operation)
    {
        $this->operation = $operation;
    
        return $this;
    }

    /**
     * Get operation
     *
     * @return string 
     */
    public function getOperation()
    {
        return $this->operation;
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
