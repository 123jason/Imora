<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SysUnionpay
 */
class SysUnionpay
{
    /**
     * @var string
     */
    private $unionpayNum;

    /**
     * @var string
     */
    private $iosUnionpay;

    /**
     * @var string
     */
    private $androidUnionpay;

    /**
     * @var integer
     */
    private $createTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set unionpayNum
     *
     * @param string $unionpayNum
     * @return SysUnionpay
     */
    public function setUnionpayNum($unionpayNum)
    {
        $this->unionpayNum = $unionpayNum;
    
        return $this;
    }

    /**
     * Get unionpayNum
     *
     * @return string 
     */
    public function getUnionpayNum()
    {
        return $this->unionpayNum;
    }

    /**
     * Set iosUnionpay
     *
     * @param string $iosUnionpay
     * @return SysUnionpay
     */
    public function setIosUnionpay($iosUnionpay)
    {
        $this->iosUnionpay = $iosUnionpay;
    
        return $this;
    }

    /**
     * Get iosUnionpay
     *
     * @return string 
     */
    public function getIosUnionpay()
    {
        return $this->iosUnionpay;
    }

    /**
     * Set androidUnionpay
     *
     * @param string $androidUnionpay
     * @return SysUnionpay
     */
    public function setAndroidUnionpay($androidUnionpay)
    {
        $this->androidUnionpay = $androidUnionpay;
    
        return $this;
    }

    /**
     * Get androidUnionpay
     *
     * @return string 
     */
    public function getAndroidUnionpay()
    {
        return $this->androidUnionpay;
    }

    /**
     * Set createTime
     *
     * @param integer $createTime
     * @return SysUnionpay
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
