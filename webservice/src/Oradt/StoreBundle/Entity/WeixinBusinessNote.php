<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WeixinBusinessNote
 */
class WeixinBusinessNote
{
    /**
     * @var integer
     */
    private $id;
    
    /**
     * @var string
     */
    private $cardId;

    /**
     * @var integer
     */
    private $noteType;

    /**
     * @var string
     */
    private $note;
    
    /**
     * @var string
     */
    private $picture;

    /**
     * @var string
     */
    private $address;

    /**
     * @var integer
     */
    private $createTime;
    
    /**
     * @var integer
     */
    private $beginTime;
    
    /**
     * @var integer
     */
    private $endTime;
    
    /**
     * @var integer
     */
    private $modifyTime;

    /**
     * @var integer
     */
    private $addId;
 

    /**
     * @var string
     */
    private $bizId;

    /**
     * @var integer
     */
    private $isDel;
    
    
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
     * Set cardId
     *
     * @param string $cardId
     * @return WeixinBusinessNote
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
     * Set noteType
     *
     * @param integer $noteType
     * @return WeixinBusinessNote
     */
    public function setNoteType($noteType)
    {
        $this->noteType = $noteType;

        return $this;
    }

    /**
     * Get noteType
     *
     * @return integer 
     */
    public function getNoteType()
    {
        return $this->noteType;
    }

    /**
     * Set note
     *
     * @param string $note
     * @return WeixinBusinessNote
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string 
     */
    public function getNote()
    {
        return $this->note;
    }
    
    /**
     * Set picture
     *
     * @param string $picture
     * @return WeixinBusinessNote
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
     * Set address
     *
     * @param string $address
     * @return WeixinBusinessNote
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set createTime
     *
     * @param integer $createTime
     * @return WeixinBusinessNote
     */
    public function setCreateTime($createTime)
    {
        $this->createTime = $createTime;

        return $this;
    }
    /**
     * Get createTime
     *
     * @return integer
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * Get createTime
     *
     * @return integer 
     */
    public function getModifyTime()
    {
        return $this->modifyTime;
    }
    
    /**
     * Set createTime
     *
     * @param integer $createTime
     * @return WeixinBusinessNote
     */
    public function setModifyTime($modifyTime)
    {
        $this->modifyTime = $modifyTime;
    
        return $this;
    }
    
  

    /**
     * Set addId
     *
     * @param integer $addId
     * @return WeixinBusinessNote
     */
    public function setAddId($addId)
    {
        $this->addId = $addId;

        return $this;
    }

    /**
     * Get addId
     *
     * @return integer 
     */
    public function getAddId()
    {
        return $this->addId;
    }
 

    /**
     * Set bizId
     *
     * @param string $bizId
     * @return WeixinBusinessNote
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
     * Set IsDel
     *
     * @param integer IsDel
     * @return WeixinBusinessNote
     */
    public function setIsDel($isDel)
    {
        $this->isDel = $isDel;
    
        return $this;
    }
    
    /**
     * Get IsDel
     *
     * @return integer
     */
    public function getIsDel()
    {
        return $this->isDel;
    }
    
    /**
     * Set  beginTime 
     *
     * @param integer $beginTime
     * @return WeixinBusinessNote
     */
    public function setBeginTime($beginTime)
    {
        $this->beginTime = $beginTime;
    
        return $this;
    }
    /**
     * Get createTime
     *
     * @return integer
     */
    public function getBeginTime()
    {
        return $this->beginTime;
    }
    
    /**
     * Set  endTime
     *
     * @param integer $endTime
     * @return WeixinBusinessNote
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
    
        return $this;
    }
    /**
     * Get endTime
     *
     * @return integer
     */
    public function getEndTime()
    {
        return $this->endTime;
    }
}
