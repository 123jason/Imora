<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CardpackageConsumelog
 */
class CardpackageConsumelog
{
    /**
     * @var string
     */
    private $logid;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $uuid;

    /**
     * @var string
     */
    private $price;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $balance;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set logid
     *
     * @param string $logid
     * @return CardpackageConsumelog
     */
    public function setLogid($logid)
    {
        $this->logid = $logid;
    
        return $this;
    }

    /**
     * Get logid
     *
     * @return string 
     */
    public function getLogid()
    {
        return $this->logid;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return CardpackageConsumelog
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
     * Set uuid
     *
     * @param string $uuid
     * @return CardpackageConsumelog
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    
        return $this;
    }

    /**
     * Get uuid
     *
     * @return string 
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return CardpackageConsumelog
     */
    public function setPrice($price)
    {
        $this->price = $price;
    
        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return CardpackageConsumelog
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set balance
     *
     * @param string $balance
     * @return CardpackageConsumelog
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;
    
        return $this;
    }

    /**
     * Get balance
     *
     * @return string 
     */
    public function getBalance()
    {
        return $this->balance;
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
