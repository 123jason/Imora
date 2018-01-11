<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrangeMemershipTagRelation
 */
class OrangeMemershipTagRelation
{
    /**
     * @var integer
     */
    private $membershipId;

    /**
     * @var integer
     */
    private $tagId;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set membershipId
     *
     * @param integer $membershipId
     * @return OrangeMemershipTagRelation
     */
    public function setMembershipId($membershipId)
    {
        $this->membershipId = $membershipId;
    
        return $this;
    }

    /**
     * Get membershipId
     *
     * @return integer 
     */
    public function getMembershipId()
    {
        return $this->membershipId;
    }

    /**
     * Set tagId
     *
     * @param integer $tagId
     * @return OrangeMemershipTagRelation
     */
    public function setTagId($tagId)
    {
        $this->tagId = $tagId;
    
        return $this;
    }

    /**
     * Get tagId
     *
     * @return integer 
     */
    public function getTagId()
    {
        return $this->tagId;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return OrangeMemershipTagRelation
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
