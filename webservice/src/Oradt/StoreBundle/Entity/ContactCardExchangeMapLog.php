<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContactCardExchangeMapLog
 */
class ContactCardExchangeMapLog
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $userId1;

    /**
     * @var string
     */
    private $vcardid;

    /**
     * @var integer
     */
    private $createTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return ContactCardExchangeMapLog
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
     * Set userId1
     *
     * @param string $userId1
     * @return ContactCardExchangeMapLog
     */
    public function setUserId1($userId1)
    {
        $this->userId1 = $userId1;
    
        return $this;
    }

    /**
     * Get userId1
     *
     * @return string 
     */
    public function getUserId1()
    {
        return $this->userId1;
    }

    /**
     * Set vcardid
     *
     * @param string $vcardid
     * @return ContactCardExchangeMapLog
     */
    public function setVcardid($vcardid)
    {
        $this->vcardid = $vcardid;
    
        return $this;
    }

    /**
     * Get vcardid
     *
     * @return string 
     */
    public function getVcardid()
    {
        return $this->vcardid;
    }

    /**
     * Set createTime
     *
     * @param integer $createTime
     * @return ContactCardExchangeMapLog
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
