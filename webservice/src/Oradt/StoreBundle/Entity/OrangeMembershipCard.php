<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrangeMembershipCard
 */
class OrangeMembershipCard
{
    /**
     * @var integer
     */
    private $cardType;

    /**
     * @var integer
     */
    private $cardTypeTwo;

    /**
     * @var integer
     */
    private $cardUnits;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $keyword;

    /**
     * @var string
     */
    private $agreement;

    /**
     * @var string
     */
    private $rule;

    /**
     * @var string
     */
    private $picPathA;

    /**
     * @var string
     */
    private $picPathB;

    /**
     * @var string
     */
    private $snapshot;

    /**
     * @var string
     */
    private $vcard;

    /**
     * @var string
     */
    private $persondata;

    /**
     * @var string
     */
    private $searchedkwd;

    /**
     * @var string
     */
    private $searchingkwd;

    /**
     * @var boolean
     */
    private $isSynch;

    /**
     * @var string
     */
    private $tempNumber;

    /**
     * @var integer
     */
    private $cardTypeUnitsNumber;

    /**
     * @var boolean
     */
    private $isShow;

    /**
     * @var integer
     */
    private $tagModifyTime;

    /**
     * @var integer
     */
    private $modifyTime;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set cardType
     *
     * @param integer $cardType
     * @return OrangeMembershipCard
     */
    public function setCardType($cardType)
    {
        $this->cardType = $cardType;
    
        return $this;
    }

    /**
     * Get cardType
     *
     * @return integer 
     */
    public function getCardType()
    {
        return $this->cardType;
    }

    /**
     * Set cardTypeTwo
     *
     * @param integer $cardTypeTwo
     * @return OrangeMembershipCard
     */
    public function setCardTypeTwo($cardTypeTwo)
    {
        $this->cardTypeTwo = $cardTypeTwo;
    
        return $this;
    }

    /**
     * Get cardTypeTwo
     *
     * @return integer 
     */
    public function getCardTypeTwo()
    {
        return $this->cardTypeTwo;
    }

    /**
     * Set cardUnits
     *
     * @param integer $cardUnits
     * @return OrangeMembershipCard
     */
    public function setCardUnits($cardUnits)
    {
        $this->cardUnits = $cardUnits;
    
        return $this;
    }

    /**
     * Get cardUnits
     *
     * @return integer 
     */
    public function getCardUnits()
    {
        return $this->cardUnits;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return OrangeMembershipCard
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set keyword
     *
     * @param string $keyword
     * @return OrangeMembershipCard
     */
    public function setKeyword($keyword)
    {
        $this->keyword = $keyword;
    
        return $this;
    }

    /**
     * Get keyword
     *
     * @return string 
     */
    public function getKeyword()
    {
        return $this->keyword;
    }

    /**
     * Set agreement
     *
     * @param string $agreement
     * @return OrangeMembershipCard
     */
    public function setAgreement($agreement)
    {
        $this->agreement = $agreement;
    
        return $this;
    }

    /**
     * Get agreement
     *
     * @return string 
     */
    public function getAgreement()
    {
        return $this->agreement;
    }

    /**
     * Set rule
     *
     * @param string $rule
     * @return OrangeMembershipCard
     */
    public function setRule($rule)
    {
        $this->rule = $rule;
    
        return $this;
    }

    /**
     * Get rule
     *
     * @return string 
     */
    public function getRule()
    {
        return $this->rule;
    }

    /**
     * Set picPathA
     *
     * @param string $picPathA
     * @return OrangeMembershipCard
     */
    public function setPicPathA($picPathA)
    {
        $this->picPathA = $picPathA;
    
        return $this;
    }

    /**
     * Get picPathA
     *
     * @return string 
     */
    public function getPicPathA()
    {
        return $this->picPathA;
    }

    /**
     * Set picPathB
     *
     * @param string $picPathB
     * @return OrangeMembershipCard
     */
    public function setPicPathB($picPathB)
    {
        $this->picPathB = $picPathB;
    
        return $this;
    }

    /**
     * Get picPathB
     *
     * @return string 
     */
    public function getPicPathB()
    {
        return $this->picPathB;
    }

    /**
     * Set snapshot
     *
     * @param string $snapshot
     * @return OrangeMembershipCard
     */
    public function setSnapshot($snapshot)
    {
        $this->snapshot = $snapshot;
    
        return $this;
    }

    /**
     * Get snapshot
     *
     * @return string 
     */
    public function getSnapshot()
    {
        return $this->snapshot;
    }

    /**
     * Set vcard
     *
     * @param string $vcard
     * @return OrangeMembershipCard
     */
    public function setVcard($vcard)
    {
        $this->vcard = $vcard;
    
        return $this;
    }

    /**
     * Get vcard
     *
     * @return string 
     */
    public function getVcard()
    {
        return $this->vcard;
    }

    /**
     * Set persondata
     *
     * @param string $persondata
     * @return OrangeMembershipCard
     */
    public function setPersondata($persondata)
    {
        $this->persondata = $persondata;
    
        return $this;
    }

    /**
     * Get persondata
     *
     * @return string 
     */
    public function getPersondata()
    {
        return $this->persondata;
    }

    /**
     * Set searchedkwd
     *
     * @param string $searchedkwd
     * @return OrangeMembershipCard
     */
    public function setSearchedkwd($searchedkwd)
    {
        $this->searchedkwd = $searchedkwd;
    
        return $this;
    }

    /**
     * Get searchedkwd
     *
     * @return string 
     */
    public function getSearchedkwd()
    {
        return $this->searchedkwd;
    }

    /**
     * Set searchingkwd
     *
     * @param string $searchingkwd
     * @return OrangeMembershipCard
     */
    public function setSearchingkwd($searchingkwd)
    {
        $this->searchingkwd = $searchingkwd;
    
        return $this;
    }

    /**
     * Get searchingkwd
     *
     * @return string 
     */
    public function getSearchingkwd()
    {
        return $this->searchingkwd;
    }

    /**
     * Set isSynch
     *
     * @param boolean $isSynch
     * @return OrangeMembershipCard
     */
    public function setIsSynch($isSynch)
    {
        $this->isSynch = $isSynch;
    
        return $this;
    }

    /**
     * Get isSynch
     *
     * @return boolean 
     */
    public function getIsSynch()
    {
        return $this->isSynch;
    }

    /**
     * Set tempNumber
     *
     * @param string $tempNumber
     * @return OrangeMembershipCard
     */
    public function setTempNumber($tempNumber)
    {
        $this->tempNumber = $tempNumber;
    
        return $this;
    }

    /**
     * Get tempNumber
     *
     * @return string 
     */
    public function getTempNumber()
    {
        return $this->tempNumber;
    }

    /**
     * Set cardTypeUnitsNumber
     *
     * @param integer $cardTypeUnitsNumber
     * @return OrangeMembershipCard
     */
    public function setCardTypeUnitsNumber($cardTypeUnitsNumber)
    {
        $this->cardTypeUnitsNumber = $cardTypeUnitsNumber;
    
        return $this;
    }

    /**
     * Get cardTypeUnitsNumber
     *
     * @return integer 
     */
    public function getCardTypeUnitsNumber()
    {
        return $this->cardTypeUnitsNumber;
    }

    /**
     * Set isShow
     *
     * @param boolean $isShow
     * @return OrangeMembershipCard
     */
    public function setIsShow($isShow)
    {
        $this->isShow = $isShow;
    
        return $this;
    }

    /**
     * Get isShow
     *
     * @return boolean 
     */
    public function getIsShow()
    {
        return $this->isShow;
    }

    /**
     * Set tagModifyTime
     *
     * @param integer $tagModifyTime
     * @return OrangeMembershipCard
     */
    public function setTagModifyTime($tagModifyTime)
    {
        $this->tagModifyTime = $tagModifyTime;
    
        return $this;
    }

    /**
     * Get tagModifyTime
     *
     * @return integer 
     */
    public function getTagModifyTime()
    {
        return $this->tagModifyTime;
    }

    /**
     * Set modifyTime
     *
     * @param integer $modifyTime
     * @return OrangeMembershipCard
     */
    public function setModifyTime($modifyTime)
    {
        $this->modifyTime = $modifyTime;
    
        return $this;
    }

    /**
     * Get modifyTime
     *
     * @return integer 
     */
    public function getModifyTime()
    {
        return $this->modifyTime;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return OrangeMembershipCard
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
