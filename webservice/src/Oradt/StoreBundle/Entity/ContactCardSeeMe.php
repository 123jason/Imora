<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContactCardSeeMe
 */
class ContactCardSeeMe
{
    /**
     * @var string
     */
    private $cardId;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var \DateTime
     */
    private $createTime;

    /**
     * @var string
     */
    private $fromUid;

    /**
     * @var string
     */
    private $fromCard;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set cardId
     *
     * @param string $cardId
     * @return ContactCardSeeMe
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
     * Set userId
     *
     * @param string $userId
     * @return ContactCardSeeMe
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
     * Set fromCard
     *
     * @param string $fromCard
     * @return ContactCardSeeMe
     */
    public function setFromCard($fromCard)
    {
        $this->fromCard = $fromCard;

        return $this;
    }

    /**
     * Get fromCard
     *
     * @return string
     */
    public function getFromCard()
    {
        return $this->fromCard;
    }


    /**
     * Set createTime
     *
     * @param integer $createTime
     * @return ContactCardSeeMe
     */
    public function setCreateTime($createTime)
    {
        $this->createTime = $createTime;

        return $this;
    }

    /**
     * Get createdTime
     *
     * @return integer
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * Set fromUid
     *
     * @param integer $fromUid
     * @return ContactCardSeeMe
     */
    public function setFromUid($fromUid)
    {
        $this->fromUid = $fromUid;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getFromUid()
    {
        return $this->fromUid;
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
