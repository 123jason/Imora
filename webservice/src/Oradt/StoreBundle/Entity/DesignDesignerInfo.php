<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DesignDesignerInfo
 */
class DesignDesignerInfo
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var integer
     */
    private $identityCardType;
	

    /**
     * @var string
     */
    private $identityCardNumber;

    /**
     * @var string
     */
    private $identityPic1Url;

    /**
     * @var string
     */
    private $identityPic2Url;

    /**
     * @var string
     */
    private $email;

    /**
     * @var integer
     */
    private $qq;

    /**
     * @var string
     */
    private $skype;

    /**
     * @var string
     */
    private $address;

    /**
     * @var integer
     */
    private $paymentMethod;

    /**
     * @var integer
     */
    private $mobile;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var string
     */
    private $comment;

    /**
     * @var integer
     */
    private $createTime;

    /**
     * @var integer
     */
    private $updateTime;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $professionalFieldId;

    /**
     * @var string
     */
    private $realName;
	/**
     * @var string
     */
    private $nickName;
    /**
     * Set userId
     *
     * @param string $userId
     * @return DesignDesignerInfo
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
     * Set NickName
     *
     * @param string $NickName
     * @return DesignDesignerInfo
     */
    public function setRealName($realName)
    {
        $this->realName = $realName;
    
        return $this;
    }

    /**
     * Get NickName
     *
     * @return string 
     */
    public function getRealName()
    {
        return $this->realName;
    }
    /**
     * Set NickName
     *
     * @param string $NickName
     * @return DesignDesignerInfo
     */
    public function setNickName($nickName)
    {
        $this->nickName = $nickName;
    
        return $this;
    }

    /**
     * Get NickName
     *
     * @return string 
     */
    public function getNickName()
    {
        return $this->nickName;
    }
    /**
     * Set identityCardType
     *
     * @param integer $identityCardType
     * @return DesignDesignerInfo
     */
    public function setIdentityCardType($identityCardType)
    {
        $this->identityCardType = $identityCardType;
    
        return $this;
    }

    /**
     * Get identityCardType
     *
     * @return integer 
     */
    public function getIdentityCardType()
    {
        return $this->identityCardType;
    }

    /**
     * Set identityCardNumber
     *
     * @param string $identityCardNumber
     * @return DesignDesignerInfo
     */
    public function setIdentityCardNumber($identityCardNumber)
    {
        $this->identityCardNumber = $identityCardNumber;
    
        return $this;
    }

    /**
     * Get identityCardNumber
     *
     * @return string 
     */
    public function getIdentityCardNumber()
    {
        return $this->identityCardNumber;
    }

    /**
     * Set identityPic1Url
     *
     * @param string $identityPic1Url
     * @return DesignDesignerInfo
     */
    public function setIdentityPic1Url($identityPic1Url)
    {
        $this->identityPic1Url = $identityPic1Url;
    
        return $this;
    }

    /**
     * Get identityPic1Url
     *
     * @return string 
     */
    public function getIdentityPic1Url()
    {
        return $this->identityPic1Url;
    }

    /**
     * Set identityPic2Url
     *
     * @param string $identityPic2Url
     * @return DesignDesignerInfo
     */
    public function setIdentityPic2Url($identityPic2Url)
    {
        $this->identityPic2Url = $identityPic2Url;
    
        return $this;
    }

    /**
     * Get identityPic2Url
     *
     * @return string 
     */
    public function getIdentityPic2Url()
    {
        return $this->identityPic2Url;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return DesignDesignerInfo
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
     * Set qq
     *
     * @param integer $qq
     * @return DesignDesignerInfo
     */
    public function setQq($qq)
    {
        $this->qq = $qq;
    
        return $this;
    }

    /**
     * Get qq
     *
     * @return integer 
     */
    public function getQq()
    {
        return $this->qq;
    }

    /**
     * Set skype
     *
     * @param string $skype
     * @return DesignDesignerInfo
     */
    public function setSkype($skype)
    {
        $this->skype = $skype;
    
        return $this;
    }

    /**
     * Get skype
     *
     * @return string 
     */
    public function getSkype()
    {
        return $this->skype;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return DesignDesignerInfo
     */
    public function setAddress($address)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set paymentMethod
     *
     * @param integer $paymentMethod
     * @return DesignDesignerInfo
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    
        return $this;
    }

    /**
     * Get paymentMethod
     *
     * @return integer 
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * Set mobile
     *
     * @param integer $mobile
     * @return DesignDesignerInfo
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    
        return $this;
    }

    /**
     * Get mobile
     *
     * @return integer 
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return DesignDesignerInfo
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
     * Set comment
     *
     * @param string $comment
     * @return DesignDesignerInfo
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    
        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set createTime
     *
     * @param integer $createTime
     * @return DesignDesignerInfo
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
     * Set updateTime
     *
     * @param integer $updateTime
     * @return DesignDesignerInfo
     */
    public function setUpdateTime($updateTime)
    {
        $this->updateTime = $updateTime;
    
        return $this;
    }

    /**
     * Get updateTime
     *
     * @return integer 
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
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
     * Set professionalFieldId
     *
     * @param integer $professionalFieldId
     * @return DesignDesignerInfo
     */
    public function setProfessionalFieldId($professionalFieldId)
    {
        $this->professionalFieldId = $professionalFieldId;
    
        return $this;
    }

    /**
     * Get professionalFieldId
     *
     * @return integer 
     */
    public function getProfessionalFieldId()
    {
        return $this->professionalFieldId;
    }
}
