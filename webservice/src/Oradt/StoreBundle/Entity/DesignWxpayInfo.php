<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DesignWxpayInfo
 */
class DesignWxpayInfo
{
    /**
     * @var string
     */
    private $wxpayId;

    /**
     * @var string
     */
    private $tradeId;

    /**
     * @var integer
     */
    private $totalFee;

    /**
     * @var string
     */
    private $feeType;

    /**
     * @var string
     */
    private $prepayId;

    /**
     * @var string
     */
    private $tradeType;

    /**
     * @var string
     */
    private $returnCode;

    /**
     * @var string
     */
    private $returnMsg;

    /**
     * @var string
     */
    private $resultCode;

    /**
     * @var string
     */
    private $deviceInfo;

    /**
     * @var string
     */
    private $errCode;

    /**
     * @var string
     */
    private $errCodeDes;

    /**
     * @var string
     */
    private $startTime;

    /**
     * @var string
     */
    private $tradeState;

    /**
     * @var string
     */
    private $timeEnd;

    /**
     * @var string
     */
    private $tradeStateDesc;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set wxpayId
     *
     * @param string $wxpayId
     * @return DesignWxpayInfo
     */
    public function setWxpayId($wxpayId)
    {
        $this->wxpayId = $wxpayId;
    
        return $this;
    }

    /**
     * Get wxpayId
     *
     * @return string 
     */
    public function getWxpayId()
    {
        return $this->wxpayId;
    }

    /**
     * Set tradeId
     *
     * @param string $tradeId
     * @return DesignWxpayInfo
     */
    public function setTradeId($tradeId)
    {
        $this->tradeId = $tradeId;
    
        return $this;
    }

    /**
     * Get tradeId
     *
     * @return string 
     */
    public function getTradeId()
    {
        return $this->tradeId;
    }

    /**
     * Set totalFee
     *
     * @param integer $totalFee
     * @return DesignWxpayInfo
     */
    public function setTotalFee($totalFee)
    {
        $this->totalFee = $totalFee;
    
        return $this;
    }

    /**
     * Get totalFee
     *
     * @return integer 
     */
    public function getTotalFee()
    {
        return $this->totalFee;
    }

    /**
     * Set feeType
     *
     * @param string $feeType
     * @return DesignWxpayInfo
     */
    public function setFeeType($feeType)
    {
        $this->feeType = $feeType;
    
        return $this;
    }

    /**
     * Get feeType
     *
     * @return string 
     */
    public function getFeeType()
    {
        return $this->feeType;
    }

    /**
     * Set prepayId
     *
     * @param string $prepayId
     * @return DesignWxpayInfo
     */
    public function setPrepayId($prepayId)
    {
        $this->prepayId = $prepayId;
    
        return $this;
    }

    /**
     * Get prepayId
     *
     * @return string 
     */
    public function getPrepayId()
    {
        return $this->prepayId;
    }

    /**
     * Set tradeType
     *
     * @param string $tradeType
     * @return DesignWxpayInfo
     */
    public function setTradeType($tradeType)
    {
        $this->tradeType = $tradeType;
    
        return $this;
    }

    /**
     * Get tradeType
     *
     * @return string 
     */
    public function getTradeType()
    {
        return $this->tradeType;
    }

    /**
     * Set returnCode
     *
     * @param string $returnCode
     * @return DesignWxpayInfo
     */
    public function setReturnCode($returnCode)
    {
        $this->returnCode = $returnCode;
    
        return $this;
    }

    /**
     * Get returnCode
     *
     * @return string 
     */
    public function getReturnCode()
    {
        return $this->returnCode;
    }

    /**
     * Set returnMsg
     *
     * @param string $returnMsg
     * @return DesignWxpayInfo
     */
    public function setReturnMsg($returnMsg)
    {
        $this->returnMsg = $returnMsg;
    
        return $this;
    }

    /**
     * Get returnMsg
     *
     * @return string 
     */
    public function getReturnMsg()
    {
        return $this->returnMsg;
    }

    /**
     * Set resultCode
     *
     * @param string $resultCode
     * @return DesignWxpayInfo
     */
    public function setResultCode($resultCode)
    {
        $this->resultCode = $resultCode;
    
        return $this;
    }

    /**
     * Get resultCode
     *
     * @return string 
     */
    public function getResultCode()
    {
        return $this->resultCode;
    }

    /**
     * Set deviceInfo
     *
     * @param string $deviceInfo
     * @return DesignWxpayInfo
     */
    public function setDeviceInfo($deviceInfo)
    {
        $this->deviceInfo = $deviceInfo;
    
        return $this;
    }

    /**
     * Get deviceInfo
     *
     * @return string 
     */
    public function getDeviceInfo()
    {
        return $this->deviceInfo;
    }

    /**
     * Set errCode
     *
     * @param string $errCode
     * @return DesignWxpayInfo
     */
    public function setErrCode($errCode)
    {
        $this->errCode = $errCode;
    
        return $this;
    }

    /**
     * Get errCode
     *
     * @return string 
     */
    public function getErrCode()
    {
        return $this->errCode;
    }

    /**
     * Set errCodeDes
     *
     * @param string $errCodeDes
     * @return DesignWxpayInfo
     */
    public function setErrCodeDes($errCodeDes)
    {
        $this->errCodeDes = $errCodeDes;
    
        return $this;
    }

    /**
     * Get errCodeDes
     *
     * @return string 
     */
    public function getErrCodeDes()
    {
        return $this->errCodeDes;
    }

    /**
     * Set startTime
     *
     * @param string $startTime
     * @return DesignWxpayInfo
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
    
        return $this;
    }

    /**
     * Get startTime
     *
     * @return string 
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set tradeState
     *
     * @param string $tradeState
     * @return DesignWxpayInfo
     */
    public function setTradeState($tradeState)
    {
        $this->tradeState = $tradeState;
    
        return $this;
    }

    /**
     * Get tradeState
     *
     * @return string 
     */
    public function getTradeState()
    {
        return $this->tradeState;
    }

    /**
     * Set timeEnd
     *
     * @param string $timeEnd
     * @return DesignWxpayInfo
     */
    public function setTimeEnd($timeEnd)
    {
        $this->timeEnd = $timeEnd;
    
        return $this;
    }

    /**
     * Get timeEnd
     *
     * @return string 
     */
    public function getTimeEnd()
    {
        return $this->timeEnd;
    }

    /**
     * Set tradeStateDesc
     *
     * @param string $tradeStateDesc
     * @return DesignWxpayInfo
     */
    public function setTradeStateDesc($tradeStateDesc)
    {
        $this->tradeStateDesc = $tradeStateDesc;
    
        return $this;
    }

    /**
     * Get tradeStateDesc
     *
     * @return string 
     */
    public function getTradeStateDesc()
    {
        return $this->tradeStateDesc;
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
    private $transactionId;

    /**
     * @var string
     */
    private $notifyRetcode;

    /**
     * @var string
     */
    private $notifyRetmsg;

    /**
     * @var string
     */
    private $notifyResult;

    /**
     * @var string
     */
    private $notifyErrcode;

    /**
     * @var string
     */
    private $notifyErrdes;


    /**
     * Set transactionId
     *
     * @param string $transactionId
     * @return DesignWxpayInfo
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;
    
        return $this;
    }

    /**
     * Get transactionId
     *
     * @return string 
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * Set notifyRetcode
     *
     * @param string $notifyRetcode
     * @return DesignWxpayInfo
     */
    public function setNotifyRetcode($notifyRetcode)
    {
        $this->notifyRetcode = $notifyRetcode;
    
        return $this;
    }

    /**
     * Get notifyRetcode
     *
     * @return string 
     */
    public function getNotifyRetcode()
    {
        return $this->notifyRetcode;
    }

    /**
     * Set notifyRetmsg
     *
     * @param string $notifyRetmsg
     * @return DesignWxpayInfo
     */
    public function setNotifyRetmsg($notifyRetmsg)
    {
        $this->notifyRetmsg = $notifyRetmsg;
    
        return $this;
    }

    /**
     * Get notifyRetmsg
     *
     * @return string 
     */
    public function getNotifyRetmsg()
    {
        return $this->notifyRetmsg;
    }

    /**
     * Set notifyResult
     *
     * @param string $notifyResult
     * @return DesignWxpayInfo
     */
    public function setNotifyResult($notifyResult)
    {
        $this->notifyResult = $notifyResult;
    
        return $this;
    }

    /**
     * Get notifyResult
     *
     * @return string 
     */
    public function getNotifyResult()
    {
        return $this->notifyResult;
    }

    /**
     * Set notifyErrcode
     *
     * @param string $notifyErrcode
     * @return DesignWxpayInfo
     */
    public function setNotifyErrcode($notifyErrcode)
    {
        $this->notifyErrcode = $notifyErrcode;
    
        return $this;
    }

    /**
     * Get notifyErrcode
     *
     * @return string 
     */
    public function getNotifyErrcode()
    {
        return $this->notifyErrcode;
    }

    /**
     * Set notifyErrdes
     *
     * @param string $notifyErrdes
     * @return DesignWxpayInfo
     */
    public function setNotifyErrdes($notifyErrdes)
    {
        $this->notifyErrdes = $notifyErrdes;
    
        return $this;
    }

    /**
     * Get notifyErrdes
     *
     * @return string 
     */
    public function getNotifyErrdes()
    {
        return $this->notifyErrdes;
    }
}
