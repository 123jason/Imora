<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrangeCardType
 */
class OrangeCardType
{
    /**
     * @var string
     */
    private $module;

    /**
     * @var integer
     */
    private $firstlevel;

    /**
     * @var string
     */
    private $firstname;

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
    private $searchingkwd;

    /**
     * @var string
     */
    private $swipeType;

    /**
     * @var integer
     */
    private $createtime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set module
     *
     * @param string $module
     * @return OrangeCardType
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
     * Set firstlevel
     *
     * @param integer $firstlevel
     * @return OrangeCardType
     */
    public function setFirstlevel($firstlevel)
    {
        $this->firstlevel = $firstlevel;
    
        return $this;
    }

    /**
     * Get firstlevel
     *
     * @return integer 
     */
    public function getFirstlevel()
    {
        return $this->firstlevel;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return OrangeCardType
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    
        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set picPathA
     *
     * @param string $picPathA
     * @return OrangeCardType
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
     * @return OrangeCardType
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
     * @return OrangeCardType
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
     * @return OrangeCardType
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
     * @return OrangeCardType
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
     * Set searchingkwd
     *
     * @param string $searchingkwd
     * @return OrangeCardType
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
     * Set swipeType
     *
     * @param string $swipeType
     * @return OrangeCardType
     */
    public function setSwipeType($swipeType)
    {
        $this->swipeType = $swipeType;
    
        return $this;
    }

    /**
     * Get swipeType
     *
     * @return string 
     */
    public function getSwipeType()
    {
        return $this->swipeType;
    }

    /**
     * Set createtime
     *
     * @param integer $createtime
     * @return OrangeCardType
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
