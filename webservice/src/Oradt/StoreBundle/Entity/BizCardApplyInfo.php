<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BizCardApplyInfo
 */
class BizCardApplyInfo
{
    /**
     * @var string
     */
    private $cardUuid;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $realName;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $mobile;

    /**
     * @var string
     */
    private $verifyCode;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set cardUuid
     *
     * @param string $cardUuid
     * @return BizCardApplyInfo
     */
    public function setCardUuid($cardUuid)
    {
        $this->cardUuid = $cardUuid;
    
        return $this;
    }

    /**
     * Get cardUuid
     *
     * @return string 
     */
    public function getCardUuid()
    {
        return $this->cardUuid;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return BizCardApplyInfo
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
     * Set realName
     *
     * @param string $realName
     * @return BizCardApplyInfo
     */
    public function setRealName($realName)
    {
        $this->realName = $realName;
    
        return $this;
    }

    /**
     * Get realName
     *
     * @return string 
     */
    public function getRealName()
    {
        return $this->realName;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return BizCardApplyInfo
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set mobile
     *
     * @param string $mobile
     * @return BizCardApplyInfo
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
     * Set verifyCode
     *
     * @param string $verifyCode
     * @return BizCardApplyInfo
     */
    public function setVerifyCode($verifyCode)
    {
        $this->verifyCode = $verifyCode;
    
        return $this;
    }

    /**
     * Get verifyCode
     *
     * @return string 
     */
    public function getVerifyCode()
    {
        return $this->verifyCode;
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
