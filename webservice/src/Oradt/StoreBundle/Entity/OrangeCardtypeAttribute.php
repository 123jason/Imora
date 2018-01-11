<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrangeCardtypeAttribute
 */
class OrangeCardtypeAttribute
{
    /**
     * @var integer
     */
    private $cardtypeid;

    /**
     * @var string
     */
    private $attr;

    /**
     * @var string
     */
    private $val;

    /**
     * @var string
     */
    private $alert;

    /**
     * @var boolean
     */
    private $encrypted;

    /**
     * @var boolean
     */
    private $status;

    /**
     * @var integer
     */
    private $createtime;

    /**
     * @var integer
     */
    private $propertyType;

    /**
     * @var integer
     */
    private $isEdit;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set cardtypeid
     *
     * @param integer $cardtypeid
     * @return OrangeCardtypeAttribute
     */
    public function setCardtypeid($cardtypeid)
    {
        $this->cardtypeid = $cardtypeid;
    
        return $this;
    }

    /**
     * Get cardtypeid
     *
     * @return integer 
     */
    public function getCardtypeid()
    {
        return $this->cardtypeid;
    }

    /**
     * Set attr
     *
     * @param string $attr
     * @return OrangeCardtypeAttribute
     */
    public function setAttr($attr)
    {
        $this->attr = $attr;
    
        return $this;
    }

    /**
     * Get attr
     *
     * @return string 
     */
    public function getAttr()
    {
        return $this->attr;
    }

    /**
     * Set val
     *
     * @param string $val
     * @return OrangeCardtypeAttribute
     */
    public function setVal($val)
    {
        $this->val = $val;
    
        return $this;
    }

    /**
     * Get val
     *
     * @return string 
     */
    public function getVal()
    {
        return $this->val;
    }

    /**
     * Set alert
     *
     * @param string $alert
     * @return OrangeCardtypeAttribute
     */
    public function setAlert($alert)
    {
        $this->alert = $alert;
    
        return $this;
    }

    /**
     * Get alert
     *
     * @return string 
     */
    public function getAlert()
    {
        return $this->alert;
    }

    /**
     * Set encrypted
     *
     * @param boolean $encrypted
     * @return OrangeCardtypeAttribute
     */
    public function setEncrypted($encrypted)
    {
        $this->encrypted = $encrypted;
    
        return $this;
    }

    /**
     * Get encrypted
     *
     * @return boolean 
     */
    public function getEncrypted()
    {
        return $this->encrypted;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return OrangeCardtypeAttribute
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return boolean 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set createtime
     *
     * @param integer $createtime
     * @return OrangeCardtypeAttribute
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
     * Set propertyType
     *
     * @param integer $propertyType
     * @return OrangeCardtypeAttribute
     */
    public function setPropertyType($propertyType)
    {
        $this->propertyType = $propertyType;
    
        return $this;
    }

    /**
     * Get propertyType
     *
     * @return integer 
     */
    public function getPropertyType()
    {
        return $this->propertyType;
    }

    /**
     * Set isEdit
     *
     * @param integer $isEdit
     * @return OrangeCardtypeAttribute
     */
    public function setIsEdit($isEdit)
    {
        $this->isEdit = $isEdit;
    
        return $this;
    }

    /**
     * Get isEdit
     *
     * @return integer 
     */
    public function getIsEdit()
    {
        return $this->isEdit;
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
    /**
     * @var boolean
     */
    private $ifdefault;


    /**
     * Set ifdefault
     *
     * @param boolean $ifdefault
     * @return OrangeCardtypeAttribute
     */
    public function setIfdefault($ifdefault)
    {
        $this->ifdefault = $ifdefault;
    
        return $this;
    }

    /**
     * @var boolean
     */
    private $contact;

    /**
     * Get ifdefault
     *
     * @return boolean 
     */
    public function getIfdefault()
    {
        return $this->ifdefault;
    }

    /**
     * Set contact
     *
     * @param boolean $contact
     * @return OrangeCardtypeAttribute
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
    
        return $this;
    }

    /**
     * Get contact
     *
     * @return boolean 
     */
    public function getContact()
    {
        return $this->contact;
    }
}
