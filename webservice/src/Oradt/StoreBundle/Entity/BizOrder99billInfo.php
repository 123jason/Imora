<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BizOrder99billInfo
 */
class BizOrder99billInfo
{
    /**
     * @var string
     */
    private $orderId;

    /**
     * @var string
     */
    private $acctid;

    /**
     * @var string
     */
    private $version;

    /**
     * @var string
     */
    private $language;

    /**
     * @var string
     */
    private $signtype;

    /**
     * @var string
     */
    private $paytype;

    /**
     * @var string
     */
    private $bankid;

    /**
     * @var float
     */
    private $orderamount;

    /**
     * @var float
     */
    private $price;

    /**
     * @var string
     */
    private $dealid;

    /**
     * @var string
     */
    private $bankdealid;

    /**
     * @var string
     */
    private $dealTime;

    /**
     * @var string
     */
    private $payamount;

    /**
     * @var string
     */
    private $fee;

    /**
     * @var integer
     */
    private $payresult;

    /**
     * @var string
     */
    private $errcode;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set orderId
     *
     * @param string $orderId
     * @return BizOrder99billInfo
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
    
        return $this;
    }

    /**
     * Get orderId
     *
     * @return string 
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * Set acctid
     *
     * @param string $acctid
     * @return BizOrder99billInfo
     */
    public function setAcctid($acctid)
    {
        $this->acctid = $acctid;
    
        return $this;
    }

    /**
     * Get acctid
     *
     * @return string 
     */
    public function getAcctid()
    {
        return $this->acctid;
    }

    /**
     * Set version
     *
     * @param string $version
     * @return BizOrder99billInfo
     */
    public function setVersion($version)
    {
        $this->version = $version;
    
        return $this;
    }

    /**
     * Get version
     *
     * @return string 
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set language
     *
     * @param string $language
     * @return BizOrder99billInfo
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    
        return $this;
    }

    /**
     * Get language
     *
     * @return string 
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set signtype
     *
     * @param string $signtype
     * @return BizOrder99billInfo
     */
    public function setSigntype($signtype)
    {
        $this->signtype = $signtype;
    
        return $this;
    }

    /**
     * Get signtype
     *
     * @return string 
     */
    public function getSigntype()
    {
        return $this->signtype;
    }

    /**
     * Set paytype
     *
     * @param string $paytype
     * @return BizOrder99billInfo
     */
    public function setPaytype($paytype)
    {
        $this->paytype = $paytype;
    
        return $this;
    }

    /**
     * Get paytype
     *
     * @return string 
     */
    public function getPaytype()
    {
        return $this->paytype;
    }

    /**
     * Set bankid
     *
     * @param string $bankid
     * @return BizOrder99billInfo
     */
    public function setBankid($bankid)
    {
        $this->bankid = $bankid;
    
        return $this;
    }

    /**
     * Get bankid
     *
     * @return string 
     */
    public function getBankid()
    {
        return $this->bankid;
    }

    /**
     * Set orderamount
     *
     * @param float $orderamount
     * @return BizOrder99billInfo
     */
    public function setOrderamount($orderamount)
    {
        $this->orderamount = $orderamount;
    
        return $this;
    }

    /**
     * Get orderamount
     *
     * @return float 
     */
    public function getOrderamount()
    {
        return $this->orderamount;
    }

    /**
     * Set dealid
     *
     * @param string $dealid
     * @return BizOrder99billInfo
     */
    public function setDealid($dealid)
    {
        $this->dealid = $dealid;
    
        return $this;
    }

    /**
     * Get dealid
     *
     * @return string 
     */
    public function getDealid()
    {
        return $this->dealid;
    }

    /**
     * Set bankdealid
     *
     * @param string $bankdealid
     * @return BizOrder99billInfo
     */
    public function setBankdealid($bankdealid)
    {
        $this->bankdealid = $bankdealid;
    
        return $this;
    }

    /**
     * Get bankdealid
     *
     * @return string 
     */
    public function getBankdealid()
    {
        return $this->bankdealid;
    }

    /**
     * Set dealTime
     *
     * @param string $dealTime
     * @return BizOrder99billInfo
     */
    public function setDealTime($dealTime)
    {
        $this->dealTime = $dealTime;
    
        return $this;
    }

    /**
     * Get dealTime
     *
     * @return string 
     */
    public function getDealTime()
    {
        return $this->dealTime;
    }

    /**
     * Set payamount
     *
     * @param string $payamount
     * @return BizOrder99billInfo
     */
    public function setPayamount($payamount)
    {
        $this->payamount = $payamount;
    
        return $this;
    }

    /**
     * Get payamount
     *
     * @return string 
     */
    public function getPayamount()
    {
        return $this->payamount;
    }

    /**
     * Set fee
     *
     * @param string $fee
     * @return BizOrder99billInfo
     */
    public function setFee($fee)
    {
        $this->fee = $fee;
    
        return $this;
    }

    /**
     * Get fee
     *
     * @return string 
     */
    public function getFee()
    {
        return $this->fee;
    }

    /**
     * Set payresult
     *
     * @param integer $payresult
     * @return BizOrder99billInfo
     */
    public function setPayresult($payresult)
    {
        $this->payresult = $payresult;
    
        return $this;
    }

    /**
     * Get payresult
     *
     * @return integer 
     */
    public function getPayresult()
    {
        return $this->payresult;
    }

    /**
     * Set errcode
     *
     * @param string $errcode
     * @return BizOrder99billInfo
     */
    public function setErrcode($errcode)
    {
        $this->errcode = $errcode;
    
        return $this;
    }

    /**
     * Get errcode
     *
     * @return string 
     */
    public function getErrcode()
    {
        return $this->errcode;
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
