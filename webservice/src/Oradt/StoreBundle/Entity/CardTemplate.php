<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CardTemplate
 */
class CardTemplate
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
    private $userId;

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
    private $modifedtime;

    /**
     * @var string
     */
    private $picture;

    /**
     * @var integer
     */
    private $isbuy;

    /**
     * @var string
     */
    private $resMd5;

    /**
     * @var string
     */
    private $vcardId;

    /**
     * @var integer
     */
    private $type;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set cardId
     *
     * @param string $cardId
     * @return CardTemplate
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
     * @return CardTemplate
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
     * @return CardTemplate
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
     * Set userId
     *
     * @param string $userId
     * @return CardTemplate
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    
        return $this;
    }

    /**
     * Get userId
     *
     * @return string 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set vcard
     *
     * @param string $vcard
     * @return CardTemplate
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
     * @return CardTemplate
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
     * @return CardTemplate
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
     * @return CardTemplate
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
     * Set modifedtime
     *
     * @param \DateTime $modifedtime
     * @return CardTemplate
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
     * @return CardTemplate
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
     * Set vcardId
     *
     * @param string $vcardId
     * @return CardTemplate
     */
    public function setVcardId($vcardId)
    {
        $this->vcardId = $vcardId;

        return $this;
    }

    /**
     * Get vcardId
     *
     * @return string
     */
    public function getVcardId()
    {
        return $this->vcardId;
    }

    /**
     * Set isbuy
     *
     * @param integer $isbuy
     * @return CardTemplate
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
     * Set type
     *
     * @param integer $type
     * @return CardTemplate
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set resMd5
     *
     * @param string $resMd5
     * @return CardTemplate
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
