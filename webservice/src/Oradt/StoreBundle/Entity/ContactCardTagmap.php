<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContactCardTagmap
 */
class ContactCardTagmap
{
    /**
     * @var string
     */
    private $cardid;

    /**
     * @var integer
     */
    private $tagid;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set cardid
     *
     * @param string $cardid
     * @return ContactCardTagmap
     */
    public function setCardid($cardid)
    {
        $this->cardid = $cardid;

        return $this;
    }

    /**
     * Get cardid
     *
     * @return string 
     */
    public function getCardid()
    {
        return $this->cardid;
    }

    /**
     * Set tagid
     *
     * @param integer $tagid
     * @return ContactCardTagmap
     */
    public function setTagid($tagid)
    {
        $this->tagid = $tagid;

        return $this;
    }

    /**
     * Get tagid
     *
     * @return integer 
     */
    public function getTagid()
    {
        return $this->tagid;
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
