<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountBasic
 */
class AccountBasic
{
    /**
     * @var string
     */
    private $userId;
            
    /**
     * @var string
     */
    private $mcode;        

    /**
     * @var string
     */
    private $mobile;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @var boolean
     */
    private $secureLevel;

    /**
     * @var string
     */
    private $status;

    /**
     * @var integer
     */
    private $ifmissing;
    
    /**
     * @var integer
     */
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return AccountBasic
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
     * Set mcode
     *
     * @param string $mcode
     * @return AccountBasic
     */
    public function setMcode($mcode)
    {
        $this->mcode = $mcode;

        return $this;
    }

    /**
     * Get mcode
     *
     * @return string 
     */
    public function getMcode()
    {
        return $this->mcode;
    }    
    
    /**
     * Set mobile
     *
     * @param string $mobile
     * @return AccountBasic
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
     * Set email
     *
     * @param string $email
     * @return AccountBasic
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
     * Set password
     *
     * @param string $password
     * @return AccountBasic
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set secureLevel
     *
     * @param boolean $secureLevel
     * @return AccountBasic
     */
    public function setSecureLevel($secureLevel)
    {
        $this->secureLevel = $secureLevel;

        return $this;
    }

    /**
     * Get secureLevel
     *
     * @return boolean 
     */
    public function getSecureLevel()
    {
        return $this->secureLevel;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return AccountBasic
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
     * Set ifmissing
     *
     * @param integer $imid
     * @return AccountBasicDetail
     */
    public function setIfmissing($ifmissing)
    {
        $this->ifmissing = $ifmissing;

        return $this;
    }

    /**
     * Get ifmissing
     *
     * @return integer 
     */
    public function getIfmissing()
    {
        return $this->ifmissing;
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
