<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BasicOrder
 */
class BasicOrder
{
    /**
     * @var integer
     */
    private $type;

    /**
     * @var string
     */
    private $orderId;

    /**
     * @var string
     */
    private $goodsId;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $appContent;

    /**
     * @var string
     */
    private $buyer;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var integer
     */
    private $paystatus;

    /**
     * @var float
     */
    private $price;

    /**
     * @var string
     */
    private $unit;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $userName;

    /**
     * @var string
     */
    private $userAccount;

    /**
     * @var string
     */
    private $toUserid;

    /**
     * @var string
     */
    private $toUserName;

    /**
     * @var string
     */
    private $toUserAccount;

    /**
     * @var integer
     */
    private $payment;

    /**
     * @var string
     */
    private $bizId;

    /**
     * @var integer
     */
    private $createTime;

    /**
     * @var integer
     */
    private $modifyTime;

    /**
     * @var integer
     */
    private $endTime;

    /**
     * @var string
     */
    private $remark;

    /**
     * @var string
     */
    private $mapVcardId;

    /**
     * @var integer
     */
    private $isAbnormal;

    /**
     * @var string
     */
    private $tradeNo;

    /**
     * @var integer
     */
    private $settlementTime;

    /**
     * @var integer
     */
    private $confirmType;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set type
     *
     * @param integer $type
     * @return BasicOrder
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
     * Set orderId
     *
     * @param string $orderId
     * @return BasicOrder
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
     * Set goodsId
     *
     * @param string $goodsId
     * @return BasicOrder
     */
    public function setGoodsId($goodsId)
    {
        $this->goodsId = $goodsId;
    
        return $this;
    }

    /**
     * Get goodsId
     *
     * @return string 
     */
    public function getGoodsId()
    {
        return $this->goodsId;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return BasicOrder
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
     * Set appContent
     *
     * @param string $appContent
     * @return BasicOrder
     */
    public function setAppContent($appContent)
    {
        $this->appContent = $appContent;
    
        return $this;
    }

    /**
     * Get appContent
     *
     * @return string 
     */
    public function getAppContent()
    {
        return $this->appContent;
    }

    /**
     * Set buyer
     *
     * @param string $buyer
     * @return BasicOrder
     */
    public function setBuyer($buyer)
    {
        $this->buyer = $buyer;
    
        return $this;
    }

    /**
     * Get buyer
     *
     * @return string 
     */
    public function getBuyer()
    {
        return $this->buyer;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return BasicOrder
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
     * Set paystatus
     *
     * @param integer $paystatus
     * @return BasicOrder
     */
    public function setPaystatus($paystatus)
    {
        $this->paystatus = $paystatus;
    
        return $this;
    }

    /**
     * Get paystatus
     *
     * @return integer 
     */
    public function getPaystatus()
    {
        return $this->paystatus;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return BasicOrder
     */
    public function setPrice($price)
    {
        $this->price = $price;
    
        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set unit
     *
     * @param string $unit
     * @return BasicOrder
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;
    
        return $this;
    }

    /**
     * Get unit
     *
     * @return string 
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return BasicOrder
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
     * Set userName
     *
     * @param string $userName
     * @return BasicOrder
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
    
        return $this;
    }

    /**
     * Get userName
     *
     * @return string 
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Set userAccount
     *
     * @param string $userAccount
     * @return BasicOrder
     */
    public function setUserAccount($userAccount)
    {
        $this->userAccount = $userAccount;
    
        return $this;
    }

    /**
     * Get userAccount
     *
     * @return string 
     */
    public function getUserAccount()
    {
        return $this->userAccount;
    }

    /**
     * Set toUserid
     *
     * @param string $toUserid
     * @return BasicOrder
     */
    public function setToUserid($toUserid)
    {
        $this->toUserid = $toUserid;
    
        return $this;
    }

    /**
     * Get toUserid
     *
     * @return string 
     */
    public function getToUserid()
    {
        return $this->toUserid;
    }

    /**
     * Set toUserName
     *
     * @param string $toUserName
     * @return BasicOrder
     */
    public function setToUserName($toUserName)
    {
        $this->toUserName = $toUserName;
    
        return $this;
    }

    /**
     * Get toUserName
     *
     * @return string 
     */
    public function getToUserName()
    {
        return $this->toUserName;
    }

    /**
     * Set toUserAccount
     *
     * @param string $toUserAccount
     * @return BasicOrder
     */
    public function setToUserAccount($toUserAccount)
    {
        $this->toUserAccount = $toUserAccount;
    
        return $this;
    }

    /**
     * Get toUserAccount
     *
     * @return string 
     */
    public function getToUserAccount()
    {
        return $this->toUserAccount;
    }

    /**
     * Set payment
     *
     * @param integer $payment
     * @return BasicOrder
     */
    public function setPayment($payment)
    {
        $this->payment = $payment;
    
        return $this;
    }

    /**
     * Get payment
     *
     * @return integer 
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * Set bizId
     *
     * @param string $bizId
     * @return BasicOrder
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
     * Set createTime
     *
     * @param integer $createTime
     * @return BasicOrder
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
     * Set modifyTime
     *
     * @param integer $modifyTime
     * @return BasicOrder
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
     * Set endTime
     *
     * @param integer $endTime
     * @return BasicOrder
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

    /**
     * Set remark
     *
     * @param string $remark
     * @return BasicOrder
     */
    public function setRemark($remark)
    {
        $this->remark = $remark;
    
        return $this;
    }

    /**
     * Get remark
     *
     * @return string 
     */
    public function getRemark()
    {
        return $this->remark;
    }

    /**
     * Set mapVcardId
     *
     * @param string $mapVcardId
     * @return BasicOrder
     */
    public function setMapVcardId($mapVcardId)
    {
        $this->mapVcardId = $mapVcardId;
    
        return $this;
    }

    /**
     * Get mapVcardId
     *
     * @return string 
     */
    public function getMapVcardId()
    {
        return $this->mapVcardId;
    }

    /**
     * Set isAbnormal
     *
     * @param integer $isAbnormal
     * @return BasicOrder
     */
    public function setIsAbnormal($isAbnormal)
    {
        $this->isAbnormal = $isAbnormal;
    
        return $this;
    }

    /**
     * Get isAbnormal
     *
     * @return integer 
     */
    public function getIsAbnormal()
    {
        return $this->isAbnormal;
    }

    /**
     * Set tradeNo
     *
     * @param string $tradeNo
     * @return BasicOrder
     */
    public function setTradeNo($tradeNo)
    {
        $this->tradeNo = $tradeNo;
    
        return $this;
    }

    /**
     * Get tradeNo
     *
     * @return string 
     */
    public function getTradeNo()
    {
        return $this->tradeNo;
    }

    /**
     * Set settlementTime
     *
     * @param integer $settlementTime
     * @return BasicOrder
     */
    public function setSettlementTime($settlementTime)
    {
        $this->settlementTime = $settlementTime;
    
        return $this;
    }

    /**
     * Get settlementTime
     *
     * @return integer 
     */
    public function getSettlementTime()
    {
        return $this->settlementTime;
    }

    /**
     * Set confirmType
     *
     * @param integer $confirmType
     * @return BasicOrder
     */
    public function setConfirmType($confirmType)
    {
        $this->confirmType = $confirmType;
    
        return $this;
    }

    /**
     * Get confirmType
     *
     * @return integer 
     */
    public function getConfirmType()
    {
        return $this->confirmType;
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
