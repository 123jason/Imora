<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BizCardTemplate
 */
class BizCardTemplate
{
    /**
     * @var string
     */
    private $cardId;

    /**
     * @var integer
     */
    private $cardType;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $bizId;

    /**
     * @var string
     */
    private $vcard;

    /**
     * @var string
     */
    private $resPath;

    /**
     * @var string
     */
    private $status;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var \DateTime
     */
    private $useStart;

    /**
     * @var \DateTime
     */
    private $modifedtime;

    /**
     * @var string
     */
    private $picture;

    /**
     * @var string
     */
    private $picturea;

    /**
     * @var integer
     */
    private $isbuy;

    /**
     * @var integer
     */
    private $isuse;

    /**
     * @var string
     */
    private $resMd5;

    /**
     * @var string
     */
    private $tempinfo;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set cardId
     *
     * @param string $cardId
     * @return BizCardTemplate
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
     * @param integer $cardType
     * @return BizCardTemplate
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
     * Set name
     *
     * @param string $name
     * @return BizCardTemplate
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
     * Set bizId
     *
     * @param string $bizId
     * @return BizCardTemplate
     */
    public function setBizId($bizId)
    {
        $this->bizId = $bizId;
    
        return $this;
    }

    /**
     * Get bizId
     *
     * @return string 
     */
    public function getBizId()
    {
        return $this->bizId;
    }

    /**
     * Set vcard
     *
     * @param string $vcard
     * @return BizCardTemplate
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
     * @return BizCardTemplate
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
     * Set status
     *
     * @param string $status
     * @return BizCardTemplate
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
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return BizCardTemplate
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
     * Set useStart
     *
     * @param \DateTime $useStart
     * @return BizCardTemplate
     */
    public function setUseStart($useStart)
    {
        $this->useStart = $useStart;

        return $this;
    }

    /**
     * Get useStart
     *
     * @return \DateTime
     */
    public function getUseStart()
    {
        return $this->useStart;
    }

    /**
     * Set modifedtime
     *
     * @param \DateTime $modifedtime
     * @return BizCardTemplate
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
     * @return BizCardTemplate
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
     * Set tempinfo
     *
     * @param string $tempinfo
     * @return BizCardTemplate
     */
    public function setTempinfo($tempinfo)
    {
        $this->tempinfo = $tempinfo;

        return $this;
    }

    /**
     * Get tempinfo
     *
     * @return string
     */
    public function getTempinfo()
    {
        return $this->tempinfo;
    }

    /**
     * Set picturea
     *
     * @param string $picturea
     * @return BizCardTemplate
     */
    public function setPicturea($picturea)
    {
        $this->picturea = $picturea;

        return $this;
    }

    /**
     * Get picturea
     *
     * @return string
     */
    public function getPicturea()
    {
        return $this->picturea;
    }

    /**
     * Set isbuy
     *
     * @param integer $isbuy
     * @return BizCardTemplate
     */
    public function setIsbuy($isbuy)
    {
        $this->isbuy = $isbuy;
    
        return $this;
    }

    /**
     * Get isbuy
     *
     * @return integer 
     */
    public function getIsbuy()
    {
        return $this->isbuy;
    }

    /**
     * Set isuse
     *
     * @param integer $isuse
     * @return BizCardTemplate
     */
    public function setIsuse($isuse)
    {
        $this->isuse = $isuse;

        return $this;
    }

    /**
     * Get isuse
     *
     * @return integer
     */
    public function getIsuse()
    {
        return $this->isuse;
    }

    /**
     * Set resMd5
     *
     * @param string $resMd5
     * @return BizCardTemplate
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
