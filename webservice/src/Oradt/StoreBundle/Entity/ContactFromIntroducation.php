<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContactFromIntroducation
 */
class ContactFromIntroducation
{
    /**
     * @var string
     */
    private $contactId;

    /**
     * @var string
     */
    private $cardId;

    /**
     * @var string
     */
    private $mapId;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set contactId
     *
     * @param string $contactId
     * @return ContactFromIntroducation
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
     * Set cardId
     *
     * @param string $cardId
     * @return ContactFromIntroducation
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
     * Set mapId
     *
     * @param string $mapId
     * @return ContactFromIntroducation
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
