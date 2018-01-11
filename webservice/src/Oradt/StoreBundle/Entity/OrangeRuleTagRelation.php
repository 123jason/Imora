<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrangeRuleTagRelation
 */
class OrangeRuleTagRelation
{
    /**
     * @var integer
     */
    private $recommRuleId;

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
     * Set recommRuleId
     *
     * @param integer $recommRuleId
     * @return OrangeRuleTagRelation
     */
    public function setRecommRuleId($recommRuleId)
    {
        $this->recommRuleId = $recommRuleId;
    
        return $this;
    }

    /**
     * Get recommRuleId
     *
     * @return integer 
     */
    public function getRecommRuleId()
    {
        return $this->recommRuleId;
    }

    /**
     * Set tagId
     *
     * @param integer $tagId
     * @return OrangeRuleTagRelation
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
     * @return OrangeRuleTagRelation
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
