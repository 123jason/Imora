<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserWebConfig
 */
class UserWebConfig
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $moduleId;

    /**
     * @var string
     */
    private $module;

    /**
     * @var string
     */
    private $parameters;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return UserWebConfig
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
     * Set moduleId
     *
     * @param string $moduleId
     * @return UserWebConfig
     */
    public function setModuleId($moduleId)
    {
        $this->moduleId = $moduleId;
    
        return $this;
    }

    /**
     * Get moduleId
     *
     * @return string 
     */
    public function getModuleId()
    {
        return $this->moduleId;
    }

    /**
     * Set module
     *
     * @param string $module
     * @return UserWebConfig
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
     * Set parameters
     *
     * @param string $parameters
     * @return UserWebConfig
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
    
        return $this;
    }

    /**
     * Get parameters
     *
     * @return string 
     */
    public function getParameters()
    {
        return $this->parameters;
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
