<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CommonSync
 */
class Errorlist
{
    
    private $id;

    /**
     * @var \DateTime
     */
    private $insertTime;

    /**
     * @var string
     */
    private $module;

    /**
     * @var string
     */
    private $source;

    /**
     * @var string
     */
    private $content;

    /**
     * @var integer
     */
    private $version;





    /**
     * Set insert_time
     *
     * @param \DateTime $modifedtime
     * @return CommonSync
     */
    public function setInsert_time($insert_time)
    {
        $this->insertTime = $insert_time;
    
        return $this;
    }

    /**
     * Get modifedtime
     *
     * @return \DateTime 
     */
    public function getInsert_time()
    {
        return $this->insertTime;
    }

    /**
     * Set moduleid
     *
     * @param string $moduleid
     * @return CommonSync
     */
    public function setSource($source)
    {
        $this->source = $source;
    
        return $this;
    }

    /**
     * Get moduleid
     *
     * @return string 
     */
    public function getSource()
    {
        return $this->source;
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
    public function setContent($content)
    {
        $this->content = $content;
    
        return $this;
    }

    /**
     * Get operation
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
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
    
      public function setVersion($version)
    {
        $this->version = $version;
    
        return $this;
    }

    /**
     * Get moduleid
     *
     * @return string 
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set insertTime
     *
     * @param \DateTime $insertTime
     * @return Errorlist
     */
    public function setInsertTime($insertTime)
    {
        $this->insertTime = $insertTime;
    
        return $this;
    }

    /**
     * Get insertTime
     *
     * @return \DateTime 
     */
    public function getInsertTime()
    {
        return $this->insertTime;
    }
}
