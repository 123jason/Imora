<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SysCardTemplate
 */
class SysCardTemplate
{
    /**
     * @var string
     */
    private $cardId;

    /**
     * @var boolean
     */
    private $cardType;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $vcard;

    /**
     * @var string
     */
    private $resPath;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $adminId;

    /**
     * @var \DateTime
     */
    private $modifedtime;

    /**
     * @var string
     */
    private $picture;

    /**
     * @var integer
     */
    private $sort;

    /**
     * @var integer
     */
    private $resSize;

    /**
     * @var string
     */
    private $resMd5;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set cardId
     *
     * @param string $cardId
     * @return SysCardTemplate
     */
    public function setCardId($cardId)
    {
        $this->cardId = $cardId;
    
        return $this;
    }

    /**
     * Get cardId
     *
     * @return string 
     */
    public function getCardId()
    {
        return $this->cardId;
    }

    /**
     * Set cardType
     *
     * @param boolean $cardType
     * @return SysCardTemplate
     */
    public function setCardType($cardType)
    {
        $this->cardType = $cardType;
    
        return $this;
    }

    /**
     * Get cardType
     *
     * @return boolean 
     */
    public function getCardType()
    {
        return $this->cardType;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return SysCardTemplate
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set vcard
     *
     * @param string $vcard
     * @return SysCardTemplate
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
     * Set resPath
     *
     * @param string $resPath
     * @return SysCardTemplate
     */
    public function setResPath($resPath)
    {
        $this->resPath = $resPath;
    
        return $this;
    }

    /**
     * Get resPath
     *
     * @return string 
     */
    public function getResPath()
    {
        return $this->resPath;
    }

    /**
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return SysCardTemplate
     */
    public function setCreatedTime($createdTime)
    {
        $this->createdTime = $createdTime;
    
        return $this;
    }

    /**
     * Get createdTime
     *
     * @return \DateTime 
     */
    public function getCreatedTime()
    {
        return $this->createdTime;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return SysCardTemplate
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set resSize
     *
     * @param integer $resSize
     * @return SysCardTemplate
     */
    public function setResSize($resSize)
    {
        $this->resSize = $resSize;

        return $this;
    }

    /**
     * Get resSize
     *
     * @return integer
     */
    public function getResSize()
    {
        return $this->resSize;
    }

    /**
     * Set adminId
     *
     * @param string $adminId
     * @return SysCardTemplate
     */
    public function setAdminId($adminId)
    {
        $this->adminId = $adminId;
    
        return $this;
    }

    /**
     * Get adminId
     *
     * @return string 
     */
    public function getAdminId()
    {
        return $this->adminId;
    }

    /**
     * Set modifedtime
     *
     * @param \DateTime $modifedtime
     * @return SysCardTemplate
     */
    public function setModifedtime($modifedtime)
    {
        $this->modifedtime = $modifedtime;
    
        return $this;
    }

    /**
     * Get modifedtime
     *
     * @return \DateTime 
     */
    public function getModifedtime()
    {
        return $this->modifedtime;
    }

    /**
     * Set picture
     *
     * @param string $picture
     * @return SysCardTemplate
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    
        return $this;
    }

    /**
     * Get picture
     *
     * @return string 
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set sort
     *
     * @param integer $sort
     * @return SysCardTemplate
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
     * Set resMd5
     *
     * @param string $resMd5
     * @return SysCardTemplate
     */
    public function setResMd5($resMd5)
    {
        $this->resMd5 = $resMd5;
    
        return $this;
    }

    /**
     * Get resMd5
     *
     * @return string 
     */
    public function getResMd5()
    {
        return $this->resMd5;
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
