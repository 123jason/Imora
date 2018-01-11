<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountBasicPrivacySettings
 */
class AccountBasicPrivacySettings
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $whoCanLookMyhomepage;

    /**
     * @var string
     */
    private $updateCardTellWho;

    /**
     * @var string
     */
    private $whoCanLookMytrends;

    /**
     * @var string
     */
    private $sharedAnonymity;

    /**
     * @var string
     */
    private $pushNotice;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return AccountBasicPrivacySettings
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
     * Set whoCanLookMyhomepage
     *
     * @param string $whoCanLookMyhomepage
     * @return AccountBasicPrivacySettings
     */
    public function setWhoCanLookMyhomepage($whoCanLookMyhomepage)
    {
        $this->whoCanLookMyhomepage = $whoCanLookMyhomepage;
    
        return $this;
    }

    /**
     * Get whoCanLookMyhomepage
     *
     * @return string 
     */
    public function getWhoCanLookMyhomepage()
    {
        return $this->whoCanLookMyhomepage;
    }

    /**
     * Set updateCardTellWho
     *
     * @param string $updateCardTellWho
     * @return AccountBasicPrivacySettings
     */
    public function setUpdateCardTellWho($updateCardTellWho)
    {
        $this->updateCardTellWho = $updateCardTellWho;
    
        return $this;
    }

    /**
     * Get updateCardTellWho
     *
     * @return string 
     */
    public function getUpdateCardTellWho()
    {
        return $this->updateCardTellWho;
    }

    /**
     * Set whoCanLookMytrends
     *
     * @param string $whoCanLookMytrends
     * @return AccountBasicPrivacySettings
     */
    public function setWhoCanLookMytrends($whoCanLookMytrends)
    {
        $this->whoCanLookMytrends = $whoCanLookMytrends;
    
        return $this;
    }

    /**
     * Get whoCanLookMytrends
     *
     * @return string 
     */
    public function getWhoCanLookMytrends()
    {
        return $this->whoCanLookMytrends;
    }

    /**
     * Set sharedAnonymity
     *
     * @param string $sharedAnonymity
     * @return AccountBasicPrivacySettings
     */
    public function setSharedAnonymity($sharedAnonymity)
    {
        $this->sharedAnonymity = $sharedAnonymity;
    
        return $this;
    }

    /**
     * Get sharedAnonymity
     *
     * @return string 
     */
    public function getSharedAnonymity()
    {
        return $this->sharedAnonymity;
    }

    /**
     * Set pushNotice
     *
     * @param string $pushNotice
     * @return AccountBasicPrivacySettings
     */
    public function setPushNotice($pushNotice)
    {
        $this->pushNotice = $pushNotice;
    
        return $this;
    }

    /**
     * Get pushNotice
     *
     * @return string 
     */
    public function getPushNotice()
    {
        return $this->pushNotice;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return AccountBasicPrivacySettings
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
