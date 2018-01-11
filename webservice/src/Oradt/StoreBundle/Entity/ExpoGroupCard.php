<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExpoGroupCard
 */
class ExpoGroupCard
{
    /**
     * @var integer
     */
    private $createtime;

    /**
     * @var integer
     */
    private $groupId;

    /**
     * @var string
     */
    private $vcardId;


    /**
     * Set createtime
     *
     * @param integer $createtime
     * @return ExpoGroupCard
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
     * Set groupId
     *
     * @param integer $groupId
     * @return ExpoGroupCard
     */
    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;
    
        return $this;
    }

    /**
     * Get groupId
     *
     * @return integer 
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * Set vcardId
     *
     * @param string $vcardId
     * @return ExpoGroupCard
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
}
