<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrangeConsumeDetail
 */
class OrangeConsumeDetail
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $cardId;

    /**
     * @var string
     */
    private $bankcardId;

    /**
     * @var string
     */
    private $bankName;

    /**
     * @var boolean
     */
    private $billType;

    /**
     * @var float
     */
    private $bill;

    /**
     * @var float
     */
    private $balance;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $modifyTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return OrangeConsumeDetail
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
     * Set cardId
     *
     * @param string $cardId
     * @return OrangeConsumeDetail
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
     * Set bankcardId
     *
     * @param string $bankcardId
     * @return OrangeConsumeDetail
     */
    public function setBankcardId($bankcardId)
    {
        $this->bankcardId = $bankcardId;
    
        return $this;
    }

    /**
     * Get bankcardId
     *
     * @return string 
     */
    public function getBankcardId()
    {
        return $this->bankcardId;
    }

    /**
     * Set bankName
     *
     * @param string $bankName
     * @return OrangeConsumeDetail
     */
    public function setBankName($bankName)
    {
        $this->bankName = $bankName;
    
        return $this;
    }

    /**
     * Get bankName
     *
     * @return string 
     */
    public function getBankName()
    {
        return $this->bankName;
    }

    /**
     * Set billType
     *
     * @param boolean $billType
     * @return OrangeConsumeDetail
     */
    public function setBillType($billType)
    {
        $this->billType = $billType;
    
        return $this;
    }

    /**
     * Get billType
     *
     * @return boolean 
     */
    public function getBillType()
    {
        return $this->billType;
    }

    /**
     * Set bill
     *
     * @param float $bill
     * @return OrangeConsumeDetail
     */
    public function setBill($bill)
    {
        $this->bill = $bill;
    
        return $this;
    }

    /**
     * Get bill
     *
     * @return float 
     */
    public function getBill()
    {
        return $this->bill;
    }

    /**
     * Set balance
     *
     * @param float $balance
     * @return OrangeConsumeDetail
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;
    
        return $this;
    }

    /**
     * Get balance
     *
     * @return float 
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return OrangeConsumeDetail
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
     * @return OrangeConsumeDetail
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
