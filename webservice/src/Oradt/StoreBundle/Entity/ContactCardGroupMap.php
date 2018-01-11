<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContactCardGroupMap
 */
class ContactCardGroupMap
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $cardId;

    /**
     * @var string
     */
    private $groupId;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return ContactCardGroupMap
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
     * Set cardId
     *
     * @param string $cardId
     * @return ContactCardGroupMap
     */
    public function setCardId($cardId)
    {
        $this->cardId = $cardId;

        return $this;
    }

    /**
     * Get cardId
     *
     * @return string 
     */
    public function getCardId()
    {
        return $this->cardId;
    }

    /**
     * Set groupId
     *
     * @param string $groupId
     * @return ContactCardGroupMap
     */
    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;

        return $this;
    }

    /**
     * Get groupId
     *
     * @return string 
     */
    public function getGroupId()
    {
        return $this->groupId;
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
