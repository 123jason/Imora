<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WeixinBusinessNoteCard
 */
class WeixinBusinessNoteCard
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $cardId;

    /**
     * @var integer
     */
    private $noteId;


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
     * Set cardId
     *
     * @param integer $cardId
     * @return WeixinBusinessNoteCard
     */
    public function setCardId($cardId)
    {
        $this->cardId = $cardId;

        return $this;
    }

    /**
     * Get cardId
     *
     * @return integer 
     */
    public function getCardId()
    {
        return $this->cardId;
    }

    /**
     * Set noteId
     *
     * @param integer $noteId
     * @return WeixinBusinessNoteCard
     */
    public function setNoteId($noteId)
    {
        $this->noteId = $noteId;

        return $this;
    }

    /**
     * Get noteId
     *
     * @return integer 
     */
    public function getNoteId()
    {
        return $this->noteId;
    }
}
