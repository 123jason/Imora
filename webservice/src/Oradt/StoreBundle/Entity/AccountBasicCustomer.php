<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountBasicCustomer
 */
class AccountBasicCustomer
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var integer
     */
    private $bintime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return AccountBasicCustomer
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
     * Set bintime
     *
     * @param integer $bintime
     * @return AccountBasicCustomer
     */
    public function setBintime($bintime)
    {
        $this->bintime = $bintime;
    
        return $this;
    }

    /**
     * Get bintime
     *
     * @return integer 
     */
    public function getBintime()
    {
        return $this->bintime;
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
    private $adminId;


    /**
     * Set adminId
     *
     * @param string $adminId
     * @return AccountBasicCustomer
     */
    public function setAdminId($adminId)
    {
        $this->adminId = $adminId;
    
        return $this;
    }

    /**
     * Get adminId
     *
     * @return string 
     */
    public function getAdminId()
    {
        return $this->adminId;
    }
}
