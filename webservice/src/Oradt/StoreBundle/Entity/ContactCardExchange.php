<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContactCardExchange
 */
class ContactCardExchange
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $groupid;

    /**
     * @var string
     */
    private $vcardid;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return ContactCardExchange
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
     * Set groupid
     *
     * @param string $groupid
     * @return ContactCardExchange
     */
    public function setGroupid($groupid)
    {
        $this->groupid = $groupid;

        return $this;
    }

    /**
     * Get groupid
     *
     * @return string 
     */
    public function getGroupid()
    {
        return $this->groupid;
    }

    /**
     * Set vcardid
     *
     * @param string $vcardid
     * @return ContactCardExchange
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
