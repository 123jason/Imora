<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExpoCardPool
 */
class ExpoCardPool
{
    /**
     * @var string
     */
    private $expoId;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $vcardId;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $groupid;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set expoId
     *
     * @param string $expoId
     * @return ExpoCardPool
     */
    public function setExpoId($expoId)
    {
        $this->expoId = $expoId;
    
        return $this;
    }

    /**
     * Get expoId
     *
     * @return string 
     */
    public function getExpoId()
    {
        return $this->expoId;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return ExpoCardPool
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set vcardId
     *
     * @param string $vcardId
     * @return ExpoCardPool
     */
    public function setVcardId($vcardId)
    {
        $this->vcardId = $vcardId;
    
        return $this;
    }

    /**
     * Get vcardId
     *
     * @return string 
     */
    public function getVcardId()
    {
        return $this->vcardId;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return ExpoCardPool
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
     * Set groupid
     *
     * @param integer $groupid
     * @return ExpoCardPool
     */
    public function setGroupid($groupid)
    {
        $this->groupid = $groupid;
    
        return $this;
    }

    /**
     * Get groupid
     *
     * @return integer 
     */
    public function getGroupid()
    {
        return $this->groupid;
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
