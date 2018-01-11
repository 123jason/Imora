<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ScanCardPictureExt
 */
class ScanCardPictureExt
{
    /**
     * @var string
     */
    private $cardid;

    /**
     * @var string
     */
    private $picPathA;

    /**
     * @var string
     */
    private $picPathB;

    /**
     * @var string
     */
    private $vcard;

    /**
     * @var string
     */
    private $markpoint;

    /**
     * @var string
     */
    private $thumbnail;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set cardid
     *
     * @param string $cardid
     * @return ScanCardPictureExt
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
     * Set picPathA
     *
     * @param string $picPathA
     * @return ScanCardPictureExt
     */
    public function setPicPathA($picPathA)
    {
        $this->picPathA = $picPathA;
    
        return $this;
    }

    /**
     * Get picPathA
     *
     * @return string 
     */
    public function getPicPathA()
    {
        return $this->picPathA;
    }

    /**
     * Set picPathB
     *
     * @param string $picPathB
     * @return ScanCardPictureExt
     */
    public function setPicPathB($picPathB)
    {
        $this->picPathB = $picPathB;
    
        return $this;
    }

    /**
     * Get picPathB
     *
     * @return string 
     */
    public function getPicPathB()
    {
        return $this->picPathB;
    }

    /**
     * Set vcard
     *
     * @param string $vcard
     * @return ScanCardPictureExt
     */
    public function setVcard($vcard)
    {
        $this->vcard = $vcard;
    
        return $this;
    }

    /**
     * Get vcard
     *
     * @return string 
     */
    public function getVcard()
    {
        return $this->vcard;
    }

    /**
     * Set markpoint
     *
     * @param string $markpoint
     * @return ScanCardPictureExt
     */
    public function setMarkpoint($markpoint)
    {
        $this->markpoint = $markpoint;
    
        return $this;
    }

    /**
     * Get markpoint
     *
     * @return string 
     */
    public function getMarkpoint()
    {
        return $this->markpoint;
    }

    /**
     * Set thumbnail
     *
     * @param string $thumbnail
     * @return ScanCardPictureExt
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
    
        return $this;
    }

    /**
     * Get thumbnail
     *
     * @return string 
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
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
