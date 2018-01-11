<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CalendarNoteSync
 */
class CalendarNoteSync
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $noteId;

    /**
     * @var \DateTime
     */
    private $lastModified;

    /**
     * @var string
     */
    private $operation;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return CalendarNoteSync
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
     * Set noteId
     *
     * @param string $noteId
     * @return CalendarNoteSync
     */
    public function setNoteId($noteId)
    {
        $this->noteId = $noteId;
    
        return $this;
    }

    /**
     * Get noteId
     *
     * @return string 
     */
    public function getNoteId()
    {
        return $this->noteId;
    }

    /**
     * Set lastModified
     *
     * @param \DateTime $lastModified
     * @return CalendarNoteSync
     */
    public function setLastModified($lastModified)
    {
        $this->lastModified = $lastModified;
    
        return $this;
    }

    /**
     * Get lastModified
     *
     * @return \DateTime 
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     * Set operation
     *
     * @param string $operation
     * @return CalendarNoteSync
     */
    public function setOperation($operation)
    {
        $this->operation = $operation;
    
        return $this;
    }

    /**
     * Get operation
     *
     * @return string 
     */
    public function getOperation()
    {
        return $this->operation;
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
