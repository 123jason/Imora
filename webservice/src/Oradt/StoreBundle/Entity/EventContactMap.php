<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EventContactMap
 */
class EventContactMap
{    
    /**
     * @var string
     */
    private $mapId;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $contactId;

    /**
     * @var string
     */
    private $eventNoteId;

    /**
     * @var string
     */
    private $eventType;

    /**
     * @var string
     */
    private $inviteEnvetId;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set mapId
     *
     * @param string $mapId
     * @return EventContactMap
     */
    public function setMapId($mapId)
    {
        $this->mapId = $mapId;
    
        return $this;
    }

    /**
     * Get mapId
     *
     * @return string 
     */
    public function getMapId()
    {
        return $this->mapId;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return EventContactMap
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
     * Set contactId
     *
     * @param string $contactId
     * @return EventContactMap
     */
    public function setContactId($contactId)
    {
        $this->contactId = $contactId;
    
        return $this;
    }

    /**
     * Get contactId
     *
     * @return string 
     */
    public function getContactId()
    {
        return $this->contactId;
    }

    /**
     * Set eventNoteId
     *
     * @param string $eventNoteId
     * @return EventContactMap
     */
    public function setEventNoteId($eventNoteId)
    {
        $this->eventNoteId = $eventNoteId;
    
        return $this;
    }

    /**
     * Get eventNoteId
     *
     * @return string 
     */
    public function getEventNoteId()
    {
        return $this->eventNoteId;
    }

    /**
     * Set eventType
     *
     * @param string $eventType
     * @return EventContactMap
     */
    public function setEventType($eventType)
    {
        $this->eventType = $eventType;
    
        return $this;
    }

    /**
     * Get eventType
     *
     * @return string 
     */
    public function getEventType()
    {
        return $this->eventType;
    }

    /**
     * Set inviteEnvetId
     *
     * @param string $inviteEnvetId
     * @return EventContactMap
     */
    public function setInviteEnvetId($inviteEnvetId)
    {
        $this->inviteEnvetId = $inviteEnvetId;
    
        return $this;
    }

    /**
     * Get inviteEnvetId
     *
     * @return string 
     */
    public function getInviteEnvetId()
    {
        return $this->inviteEnvetId;
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
