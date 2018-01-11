<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CommonSync
 */
class CommonSync
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
    private $moduleid;

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
     * @return CommonSync
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
     * @return CommonSync
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
     * Set moduleid
     *
     * @param string $moduleid
     * @return CommonSync
     */
    public function setModuleid($moduleid)
    {
        $this->moduleid = $moduleid;
    
        return $this;
    }

    /**
     * Get moduleid
     *
     * @return string 
     */
    public function getModuleid()
    {
        return $this->moduleid;
    }

    /**
     * Set module
     *
     * @param string $module
     * @return CommonSync
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
     * @return CommonSync
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
