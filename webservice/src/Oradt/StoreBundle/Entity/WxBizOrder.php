<?php
/**
 * Created by PhpStorm.
 * User: qiuzhigang
 * Date: 2017-10-16
 * Time: 17:39
 */

namespace Oradt\StoreBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * WxBizOrder
 */
class WxBizOrder
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $price;

    /**
     * @var string
     */
    private $totalAmount;

    /***
     * @var string
     */
    private $discountSource;

    /***
     * @var string
     */
    private $discountAmount;

    /***
     * @var string
     */
    private $payAmount;

    /***
     * @var integer
     */
    private $orderSn;

    /***
     * @var integer
     */
    private $accountId;

    /***
     * @var string
     */
    private $bizId;

    /**8
     * @var integer
     */
    private $payStatus;

    /**8
     * @var integer
     */
    private $num;

    /**
     * @var string
     */
    private $termDate;

    /***
     * @var integer
     */
    private $termTime;

    /**
     * @var integer
     */
    private $platform;

    /***
     * @var string
     */
    private $tradeNo;

    /***
     * @var integer
     */
    private $payTime;

    /***
     * @var integer
     */

    private $createTime;

    /***
     * @var integer
     */
    private $orderType;

    /***
     * @var string
     */
    private $metadata;

    /***
     * @var integer
     */
    private $orderSource;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param string $price
     * @return WxBizOrder
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return string
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * @param string $totalAmount
     */
    public function settotalAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;
        return $this;
    }



    /**
     * @return integer
     */
    public function getOrderSn()
    {
        return $this->orderSn;
    }

    /**
     * @param integer $orderSn
     * @return WxBizOrder
     */
    public function setOrderSn($orderSn)
    {
        $this->orderSn = $orderSn;
        return $this;
    }

    /**
     * @return integer
     */
    public function getAccountId()
    {
        return $this->accountId;
    }

    /**
     * @param integer $accountId
     * @return WxBizOrder
     */
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;
        return $this;
    }

    /**
     * @return string
     */
    public function getBizId()
    {
        return $this->bizId;
    }

    /**
     * @param string $bizId
     * @return WxBizOrder
     */
    public function setBizId($bizId)
    {
        $this->bizId = $bizId;
        return $this;
    }

    /**
     * @return integer
     */
    public function getPayStatus()
    {
        return $this->payStatus;
    }

    /**
     * @param integer $payStatus
     * @return WxBizOrder
     */
    public function setPayStatus($payStatus)
    {
        $this->payStatus = $payStatus;
        return $this;
    }

    /**
     * @return integer
     */
    public function getNum()
    {
        return $this->num;
    }

    /**
     * @param integer $num
     * @return WxBizOrder
     */
    public function setNum($num)
    {
        $this->num = $num;
        return $this;
    }

    /**
     * @return string
     */
    public function getTermDate()
    {
        return $this->termDate;
    }

    /**
     * @param string $termDate
     * @return WxBizOrder
     */
    public function setTermDate($termDate)
    {
        $this->termDate = $termDate;
        return $this;
    }

    /**
     * @return integer
     */
    public function getTermTime()
    {
        return $this->termTime;
    }

    /**
     * @param integer $termTime
     * @return WxBizOrder
     */
    public function setTermTime($termTime)
    {
        $this->termTime = $termTime;
        return $this;
    }

    /**
     * @return integer
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * @param integer $platform
     * @return WxBizOrder
     */
    public function setPlatform( $platform)
    {
        $this->platform = $platform;
        return $this;
    }

    /**
     * @return string
     */
    public function getTradeNo()
    {
        return $this->tradeNo;
    }

    /**
     * @param string $tradeNo
     * @return WxBizOrder
     */
    public function setTradeNo($tradeNo)
    {
        $this->tradeNo = $tradeNo;
        return $this;
    }

    /**
     * @return integer
     */
    public function getPayTime()
    {
        return $this->payTime;
    }

    /**
     * @param integer $payTime
     * @return WxBizOrder
     */
    public function setPayTime( $payTime)
    {
        $this->payTime = $payTime;
        return $this;
    }

    /**
     * @return integer
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * @param integer $createTime
     * @return WxBizOrder
     */
    public function setCreateTime($createTime)
    {
        $this->createTime = $createTime;
        return $this;
    }

    /**
     * @return int
     */
    public function getOrderType()
    {
        return $this->orderType;
    }

    /**
     * @param int $orderType
     * @return WxBizOrder
     */
    public function setOrderType($orderType)
    {
        $this->orderType = $orderType;
        return $this;
    }

    /**
     * @return string
     */
    public function getMetadata(){
        return $this->metadata;
    }

    /**
     * @param string $metadata
     * @return WxBizOrder
     */
    public function setMetadata($metadata){
        $this->metadata = $metadata;
        return $this;
    }

    /**
     * @return string
     */
    public function getDiscountSource(){
        return $this->discountSource;
    }

    /**
     * @param string $discountSource
     * @return WxBizOrder
     */
    public function setDiscountSource( $discountSource){
        $this->discountSource = $discountSource;
        return $this;
    }

    /**
     * @return string
     */
    public function getDiscountAmount(){
        return $this->discountAmount;
    }

    /**
     * @param string $discountAmount
     * @return WxBizOrder
     */
    public function setDiscountAmount( $discountAmount){
        $this->discountAmount = $discountAmount;
        return $this;
    }

    /**
     * @return string
     */
    public function getPayAmount(){
        return $this->payAmount;
    }

    /**
     * @param string $payAmount
     * @return WxBizOrder
     */
    public function setPayAmount($payAmount){
        $this->payAmount = $payAmount;
        return $this;
    }

    /**
     * @return int
     */
    public function getOrderSource(){
        return $this->orderSource;
    }

    /**
     * @param int $orderSource
     * @return WxBizOrder
     */
    public function setOrderSource( $orderSource){
        $this->orderSource = $orderSource;
        return $this;
    }


}