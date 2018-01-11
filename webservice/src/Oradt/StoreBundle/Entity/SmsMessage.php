<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SmsMessage
 */
class SmsMessage
{
    /**
     * @var string
     */
    private $smsId;

    /**
     * @var string
     */
    private $mobile;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $content;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var string
     */
    private $module;

    /**
     * @var string
     */
    private $status;

    /**
     * @var integer
     */
    private $useStatus;

    /**
     * @var integer
     */
    private $fseqId;

    /**
     * @var string
     */
    private $fsubmitTime;

    /**
     * @var string
     */
    private $freceiveTime;

    /**
     * @var integer
     */
    private $freportStatus;

    /**
     * @var string
     */
    private $ferrorCode;

    /**
     * @var string
     */
    private $fmemo;

    /**
     * @var string
     */
    private $ip;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set smsId
     *
     * @param string $smsId
     * @return SmsMessage
     */
    public function setSmsId($smsId)
    {
        $this->smsId = $smsId;
    
        return $this;
    }

    /**
     * Get smsId
     *
     * @return string 
     */
    public function getSmsId()
    {
        return $this->smsId;
    }

    /**
     * Set mobile
     *
     * @param string $mobile
     * @return SmsMessage
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    
        return $this;
    }

    /**
     * Get mobile
     *
     * @return string 
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return SmsMessage
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
     * Set content
     *
     * @param string $content
     * @return SmsMessage
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
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return SmsMessage
     */
    public function setCreatedTime($createdTime)
    {
        $this->createdTime = $createdTime;
    
        return $this;
    }

    /**
     * Get createdTime
     *
     * @return \DateTime 
     */
    public function getCreatedTime()
    {
        return $this->createdTime;
    }

    /**
     * Set module
     *
     * @param string $module
     * @return SmsMessage
     */
    public function setModule($module)
    {
        $this->module = $module;
    
        return $this;
    }

    /**
     * Get module
     *
     * @return string 
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return SmsMessage
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set useStatus
     *
     * @param integer $useStatus
     * @return SmsMessage
     */
    public function setUseStatus($useStatus)
    {
        $this->useStatus = $useStatus;
    
        return $this;
    }

    /**
     * Get useStatus
     *
     * @return integer 
     */
    public function getUseStatus()
    {
        return $this->useStatus;
    }

    /**
     * Set fseqId
     *
     * @param integer $fseqId
     * @return SmsMessage
     */
    public function setFseqId($fseqId)
    {
        $this->fseqId = $fseqId;
    
        return $this;
    }

    /**
     * Get fseqId
     *
     * @return integer 
     */
    public function getFseqId()
    {
        return $this->fseqId;
    }

    /**
     * Set fsubmitTime
     *
     * @param string $fsubmitTime
     * @return SmsMessage
     */
    public function setFsubmitTime($fsubmitTime)
    {
        $this->fsubmitTime = $fsubmitTime;
    
        return $this;
    }

    /**
     * Get fsubmitTime
     *
     * @return string 
     */
    public function getFsubmitTime()
    {
        return $this->fsubmitTime;
    }

    /**
     * Set freceiveTime
     *
     * @param string $freceiveTime
     * @return SmsMessage
     */
    public function setFreceiveTime($freceiveTime)
    {
        $this->freceiveTime = $freceiveTime;
    
        return $this;
    }

    /**
     * Get freceiveTime
     *
     * @return string 
     */
    public function getFreceiveTime()
    {
        return $this->freceiveTime;
    }

    /**
     * Set freportStatus
     *
     * @param integer $freportStatus
     * @return SmsMessage
     */
    public function setFreportStatus($freportStatus)
    {
        $this->freportStatus = $freportStatus;
    
        return $this;
    }

    /**
     * Get freportStatus
     *
     * @return integer 
     */
    public function getFreportStatus()
    {
        return $this->freportStatus;
    }

    /**
     * Set ferrorCode
     *
     * @param string $ferrorCode
     * @return SmsMessage
     */
    public function setFerrorCode($ferrorCode)
    {
        $this->ferrorCode = $ferrorCode;
    
        return $this;
    }
    
    /**
     * Get ferrorCode
     *
     * @return string 
     */
    public function getFerrorCode()
    {
        return $this->ferrorCode;
    }

    /**
     * Set fmemo
     *
     * @param string $fmemo
     * @return SmsMessage
     */
    public function setFmemo($fmemo)
    {
        $this->fmemo = $fmemo;
    
        return $this;
    }

    /**
     * Get fmemo
     *
     * @return string 
     */
    public function getFmemo()
    {
        return $this->fmemo;
    }

    /**
     * Set ip
     *
     * @param string $ip
     * @return SmsMessage
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    
        return $this;
    }

    /**
     * Get ip
     *
     * @return string 
     */
    public function getIp()
    {
        return $this->ip;
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
