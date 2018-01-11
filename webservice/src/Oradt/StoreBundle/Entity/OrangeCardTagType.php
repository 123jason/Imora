<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrangeCardTagType
 */
class OrangeCardTagType
{
    /**
     * @var integer
     */
    private $cardTypeId;

    /**
     * @var integer
     */
    private $chooseCardTypeId;

    /**
     * @var integer
     */
    private $tagTypeId;

    /**
     * @var integer
     */
    private $sort;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set cardTypeId
     *
     * @param integer $cardTypeId
     * @return OrangeCardTagType
     */
    public function setCardTypeId($cardTypeId)
    {
        $this->cardTypeId = $cardTypeId;
    
        return $this;
    }

    /**
     * Get cardTypeId
     *
     * @return integer 
     */
    public function getCardTypeId()
    {
        return $this->cardTypeId;
    }

    /**
     * Set chooseCardTypeId
     *
     * @param integer $chooseCardTypeId
     * @return OrangeCardTagType
     */
    public function setChooseCardTypeId($chooseCardTypeId)
    {
        $this->chooseCardTypeId = $chooseCardTypeId;
    
        return $this;
    }

    /**
     * Get chooseCardTypeId
     *
     * @return integer 
     */
    public function getChooseCardTypeId()
    {
        return $this->chooseCardTypeId;
    }

    /**
     * Set tagTypeId
     *
     * @param integer $tagTypeId
     * @return OrangeCardTagType
     */
    public function setTagTypeId($tagTypeId)
    {
        $this->tagTypeId = $tagTypeId;
    
        return $this;
    }

    /**
     * Get tagTypeId
     *
     * @return integer 
     */
    public function getTagTypeId()
    {
        return $this->tagTypeId;
    }

    /**
     * Set sort
     *
     * @param integer $sort
     * @return OrangeCardTagType
     */
    public function setSort($sort)
    {
        $this->sort = $sort;
    
        return $this;
    }

    /**
     * Get sort
     *
     * @return integer 
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return OrangeCardTagType
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
