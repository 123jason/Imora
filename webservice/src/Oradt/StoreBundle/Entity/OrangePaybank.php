<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrangePaybank
 */
class OrangePaybank
{
    /**
     * @var string
     */
    private $adminId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $debitCard;

    /**
     * @var string
     */
    private $debitCardCity;

    /**
     * @var integer
     */
    private $creditCard;

    /**
     * @var string
     */
    private $creditCardCity;

    /**
     * @var string
     */
    private $logo;

    /**
     * @var integer
     */
    private $sorting;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set adminId
     *
     * @param string $adminId
     * @return OrangePaybank
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
     * Set name
     *
     * @param string $name
     * @return OrangePaybank
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
     * Set debitCard
     *
     * @param integer $debitCard
     * @return OrangePaybank
     */
    public function setDebitCard($debitCard)
    {
        $this->debitCard = $debitCard;
    
        return $this;
    }

    /**
     * Get debitCard
     *
     * @return integer 
     */
    public function getDebitCard()
    {
        return $this->debitCard;
    }

    /**
     * Set debitCardCity
     *
     * @param string $debitCardCity
     * @return OrangePaybank
     */
    public function setDebitCardCity($debitCardCity)
    {
        $this->debitCardCity = $debitCardCity;
    
        return $this;
    }

    /**
     * Get debitCardCity
     *
     * @return string 
     */
    public function getDebitCardCity()
    {
        return $this->debitCardCity;
    }

    /**
     * Set creditCard
     *
     * @param integer $creditCard
     * @return OrangePaybank
     */
    public function setCreditCard($creditCard)
    {
        $this->creditCard = $creditCard;
    
        return $this;
    }

    /**
     * Get creditCard
     *
     * @return integer 
     */
    public function getCreditCard()
    {
        return $this->creditCard;
    }

    /**
     * Set creditCardCity
     *
     * @param string $creditCardCity
     * @return OrangePaybank
     */
    public function setCreditCardCity($creditCardCity)
    {
        $this->creditCardCity = $creditCardCity;
    
        return $this;
    }

    /**
     * Get creditCardCity
     *
     * @return string 
     */
    public function getCreditCardCity()
    {
        return $this->creditCardCity;
    }

    /**
     * Set logo
     *
     * @param string $logo
     * @return OrangePaybank
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    
        return $this;
    }

    /**
     * Get logo
     *
     * @return string 
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set sorting
     *
     * @param integer $sorting
     * @return OrangePaybank
     */
    public function setSorting($sorting)
    {
        $this->sorting = $sorting;
    
        return $this;
    }

    /**
     * Get sorting
     *
     * @return integer 
     */
    public function getSorting()
    {
        return $this->sorting;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return OrangePaybank
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
    private $customer;

    /**
     * Set customer
     *
     * @param string $customer
     * @return OrangePaybank
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
    
        return $this;
    }

    /**
     * Get customer
     *
     * @return string 
     */
    public function getCustomer()
    {
        return $this->customer;
    }
}
