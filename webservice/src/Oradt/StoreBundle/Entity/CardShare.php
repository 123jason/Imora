<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CardShare
 */
class CardShare
{
    /**
     * @var integer
     */
    private $type;

    /**
     * @var string
     */
    private $accountid;

    /**
     * @var string
     */
    private $shareAccount;

    /**
     * @var string
     */
    private $content;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var integer
     */
    private $cardNum;

    /**
     * @var integer
     */
    private $accountNum;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $modifyTime;

    /**
     * @var string
     */
    private $adminId;

    /**
     * @var string
     */
    private $cancelAdminId;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set type
     *
     * @param integer $type
     * @return CardShare
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
     * Set accountid
     *
     * @param string $accountid
     * @return CardShare
     */
    public function setAccountid($accountid)
    {
        $this->accountid = $accountid;
    
        return $this;
    }

    /**
     * Get accountid
     *
     * @return string 
     */
    public function getAccountid()
    {
        return $this->accountid;
    }

    /**
     * Set shareAccount
     *
     * @param string $shareAccount
     * @return CardShare
     */
    public function setShareAccount($shareAccount)
    {
        $this->shareAccount = $shareAccount;
    
        return $this;
    }

    /**
     * Get shareAccount
     *
     * @return string 
     */
    public function getShareAccount()
    {
        return $this->shareAccount;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return CardShare
     */
    public function setContent($content)
    {
        $this->content = $content;
    
        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return CardShare
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set cardNum
     *
     * @param integer $cardNum
     * @return CardShare
     */
    public function setCardNum($cardNum)
    {
        $this->cardNum = $cardNum;
    
        return $this;
    }

    /**
     * Get cardNum
     *
     * @return integer 
     */
    public function getCardNum()
    {
        return $this->cardNum;
    }

    /**
     * Set accountNum
     *
     * @param integer $accountNum
     * @return CardShare
     */
    public function setAccountNum($accountNum)
    {
        $this->accountNum = $accountNum;
    
        return $this;
    }

    /**
     * Get accountNum
     *
     * @return integer 
     */
    public function getAccountNum()
    {
        return $this->accountNum;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return CardShare
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
     * Set modifyTime
     *
     * @param integer $modifyTime
     * @return CardShare
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
     * Set adminId
     *
     * @param string $adminId
     * @return CardShare
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
     * Set cancelAdminId
     *
     * @param string $cancelAdminId
     * @return CardShare
     */
    public function setCancelAdminId($cancelAdminId)
    {
        $this->cancelAdminId = $cancelAdminId;
    
        return $this;
    }

    /**
     * Get cancelAdminId
     *
     * @return string 
     */
    public function getCancelAdminId()
    {
        return $this->cancelAdminId;
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
