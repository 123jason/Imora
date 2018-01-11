<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContactCardExchangeFriend
 */
class ContactCardExchangeFriend
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $clientId;

    /**
     * @var integer
     */
    private $modifyTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return ContactCardExchangeFriend
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
     * Set clientId
     *
     * @param string $clientId
     * @return ContactCardExchangeFriend
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    
        return $this;
    }

    /**
     * Get clientId
     *
     * @return string 
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * Set modifyTime
     *
     * @param integer $modifyTime
     * @return ContactCardExchangeFriend
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
