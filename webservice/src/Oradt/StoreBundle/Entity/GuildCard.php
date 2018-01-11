<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GuildCard
 */
class GuildCard
{
    /**
     * @var string
     */
    private $cardId;

    /**
     * @var string
     */
    private $cardType;

    /**
     * @var string
     */
    private $guildId;

    /**
     * @var string
     */
    private $message;

    /**
     * @var \DateTime
     */
    private $postDate;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set cardId
     *
     * @param string $cardId
     * @return GuildCard
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
     * Set cardType
     *
     * @param string $cardType
     * @return GuildCard
     */
    public function setCardType($cardType)
    {
        $this->cardType = $cardType;
    
        return $this;
    }

    /**
     * Get cardType
     *
     * @return string 
     */
    public function getCardType()
    {
        return $this->cardType;
    }

    /**
     * Set guildId
     *
     * @param string $guildId
     * @return GuildCard
     */
    public function setGuildId($guildId)
    {
        $this->guildId = $guildId;
    
        return $this;
    }

    /**
     * Get guildId
     *
     * @return string 
     */
    public function getGuildId()
    {
        return $this->guildId;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return GuildCard
     */
    public function setMessage($message)
    {
        $this->message = $message;
    
        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set postDate
     *
     * @param \DateTime $postDate
     * @return GuildCard
     */
    public function setPostDate($postDate)
    {
        $this->postDate = $postDate;
    
        return $this;
    }

    /**
     * Get postDate
     *
     * @return \DateTime 
     */
    public function getPostDate()
    {
        return $this->postDate;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return GuildCard
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
