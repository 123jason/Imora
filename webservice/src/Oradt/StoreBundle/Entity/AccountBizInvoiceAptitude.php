<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountBizInvoiceAptitude
 */
class AccountBizInvoiceAptitude
{
    /**
     * @var string
     */
    private $bizId;

    /**
     * @var string
     */
    private $taxpayerCode;

    /**
     * @var string
     */
    private $regAddress;

    /**
     * @var string
     */
    private $regTelephone;

    /**
     * @var string
     */
    private $bank;

    /**
     * @var string
     */
    private $bankAccount;

    /**
     * @var string
     */
    private $payTaxProve;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set bizId
     *
     * @param string $bizId
     * @return AccountBizInvoiceAptitude
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
     * Set taxpayerCode
     *
     * @param string $taxpayerCode
     * @return AccountBizInvoiceAptitude
     */
    public function setTaxpayerCode($taxpayerCode)
    {
        $this->taxpayerCode = $taxpayerCode;
    
        return $this;
    }

    /**
     * Get taxpayerCode
     *
     * @return string 
     */
    public function getTaxpayerCode()
    {
        return $this->taxpayerCode;
    }

    /**
     * Set regAddress
     *
     * @param string $regAddress
     * @return AccountBizInvoiceAptitude
     */
    public function setRegAddress($regAddress)
    {
        $this->regAddress = $regAddress;
    
        return $this;
    }

    /**
     * Get regAddress
     *
     * @return string 
     */
    public function getRegAddress()
    {
        return $this->regAddress;
    }

    /**
     * Set regTelephone
     *
     * @param string $regTelephone
     * @return AccountBizInvoiceAptitude
     */
    public function setRegTelephone($regTelephone)
    {
        $this->regTelephone = $regTelephone;
    
        return $this;
    }

    /**
     * Get regTelephone
     *
     * @return string 
     */
    public function getRegTelephone()
    {
        return $this->regTelephone;
    }

    /**
     * Set bank
     *
     * @param string $bank
     * @return AccountBizInvoiceAptitude
     */
    public function setBank($bank)
    {
        $this->bank = $bank;
    
        return $this;
    }

    /**
     * Get bank
     *
     * @return string 
     */
    public function getBank()
    {
        return $this->bank;
    }

    /**
     * Set bankAccount
     *
     * @param string $bankAccount
     * @return AccountBizInvoiceAptitude
     */
    public function setBankAccount($bankAccount)
    {
        $this->bankAccount = $bankAccount;
    
        return $this;
    }

    /**
     * Get bankAccount
     *
     * @return string 
     */
    public function getBankAccount()
    {
        return $this->bankAccount;
    }

    /**
     * Set payTaxProve
     *
     * @param string $payTaxProve
     * @return AccountBizInvoiceAptitude
     */
    public function setPayTaxProve($payTaxProve)
    {
        $this->payTaxProve = $payTaxProve;
    
        return $this;
    }

    /**
     * Get payTaxProve
     *
     * @return string 
     */
    public function getPayTaxProve()
    {
        return $this->payTaxProve;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return AccountBizInvoiceAptitude
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
}
