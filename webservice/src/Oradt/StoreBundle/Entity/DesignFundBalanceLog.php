<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DesignFundBalanceLog
 */
class DesignFundBalanceLog
{
    /**
     * @var string
     */
    private $accountId;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $number0;

    /**
     * @var string
     */
    private $money;

    /**
     * @var string
     */
    private $number1;

    /**
     * @var integer
     */
    private $unitId;

    /**
     * @var \DateTime
     */
    private $insertTime;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $itemId;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set accountId
     *
     * @param string $accountId
     * @return DesignFundBalanceLog
     */
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;
    
        return $this;
    }

    /**
     * Get accountId
     *
     * @return string 
     */
    public function getAccountId()
    {
        return $this->accountId;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return DesignFundBalanceLog
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
     * Set number0
     *
     * @param string $number0
     * @return DesignFundBalanceLog
     */
    public function setNumber0($number0)
    {
        $this->number0 = $number0;
    
        return $this;
    }

    /**
     * Get number0
     *
     * @return string 
     */
    public function getNumber0()
    {
        return $this->number0;
    }

    /**
     * Set money
     *
     * @param string $money
     * @return DesignFundBalanceLog
     */
    public function setMoney($money)
    {
        $this->money = $money;
    
        return $this;
    }

    /**
     * Get money
     *
     * @return string 
     */
    public function getMoney()
    {
        return $this->money;
    }

    /**
     * Set number1
     *
     * @param string $number1
     * @return DesignFundBalanceLog
     */
    public function setNumber1($number1)
    {
        $this->number1 = $number1;
    
        return $this;
    }

    /**
     * Get number1
     *
     * @return string 
     */
    public function getNumber1()
    {
        return $this->number1;
    }

    /**
     * Set unitId
     *
     * @param integer $unitId
     * @return DesignFundBalanceLog
     */
    public function setUnitId($unitId)
    {
        $this->unitId = $unitId;
    
        return $this;
    }

    /**
     * Get unitId
     *
     * @return integer 
     */
    public function getUnitId()
    {
        return $this->unitId;
    }

    /**
     * Set insertTime
     *
     * @param \DateTime $insertTime
     * @return DesignFundBalanceLog
     */
    public function setInsertTime($insertTime)
    {
        $this->insertTime = $insertTime;
    
        return $this;
    }

    /**
     * Get insertTime
     *
     * @return \DateTime 
     */
    public function getInsertTime()
    {
        return $this->insertTime;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return DesignFundBalanceLog
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return DesignFundBalanceLog
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
     * Set itemId
     *
     * @param string $itemId
     * @return DesignFundBalanceLog
     */
    public function setItemId($itemId)
    {
        $this->itemId = $itemId;
    
        return $this;
    }

    /**
     * Get itemId
     *
     * @return string 
     */
    public function getItemId()
    {
        return $this->itemId;
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
     * @var string
     */
    private $itemName;


    /**
     * Set itemName
     *
     * @param string $itemName
     * @return DesignFundBalanceLog
     */
    public function setItemName($itemName)
    {
        $this->itemName = $itemName;
    
        return $this;
    }

    /**
     * Get itemName
     *
     * @return string 
     */
    public function getItemName()
    {
        return $this->itemName;
    }
    /**
     * @var string
     */
    private $account;


    /**
     * Set account
     *
     * @param string $account
     * @return DesignFundBalanceLog
     */
    public function setAccount($account)
    {
        $this->account = $account;
    
        return $this;
    }

    /**
     * Get account
     *
     * @return string 
     */
    public function getAccount()
    {
        return $this->account;
    }
}
