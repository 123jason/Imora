<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrangeCardStrategyRelation
 */
class OrangeCardStrategyRelation
{
    /**
     * @var string
     */
    private $froms;

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
    private $tagtypeid;

    /**
     * @var integer
     */
    private $fromid;

    /**
     * @var integer
     */
    private $sort;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set froms
     *
     * @param string $froms
     * @return OrangeCardStrategyRelation
     */
    public function setFroms($froms)
    {
        $this->froms = $froms;
    
        return $this;
    }

    /**
     * Get froms
     *
     * @return string 
     */
    public function getFroms()
    {
        return $this->froms;
    }

    /**
     * Set cardTypeId
     *
     * @param integer $cardTypeId
     * @return OrangeCardStrategyRelation
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
     * @return OrangeCardStrategyRelation
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
     * Set tagtypeid
     *
     * @param integer $tagtypeid
     * @return OrangeCardStrategyRelation
     */
    public function setTagtypeid($tagtypeid)
    {
        $this->tagtypeid = $tagtypeid;
    
        return $this;
    }

    /**
     * Get tagtypeid
     *
     * @return integer 
     */
    public function getTagtypeid()
    {
        return $this->tagtypeid;
    }

    /**
     * Set fromid
     *
     * @param integer $fromid
     * @return OrangeCardStrategyRelation
     */
    public function setFromid($fromid)
    {
        $this->fromid = $fromid;
    
        return $this;
    }

    /**
     * Get fromid
     *
     * @return integer 
     */
    public function getFromid()
    {
        return $this->fromid;
    }

    /**
     * Set sort
     *
     * @param integer $sort
     * @return OrangeCardStrategyRelation
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
