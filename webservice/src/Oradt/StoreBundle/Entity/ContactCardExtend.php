<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContactCardExtend
 */
class ContactCardExtend
{
    /**
     * @var string
     */
    private $uuid;

    /**
     * @var string
     */
    private $vcard;

    /**
     * @var string
     */
    private $resPath;

    /**
     * @var string
     */
    private $markPoint;
    
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
    private $userId;
    
    /**
     * @var string
     */
    private $reOrder;

    /**
     * @var string
     */
    private $latLng;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set uuid
     *
     * @param string $uuid
     * @return ContactCardExtend
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * Get uuid
     *
     * @return string 
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set vcard
     *
     * @param string $vcard
     * @return ContactCardExtend
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
     * Set resPath
     *
     * @param string $resPath
     * @return ContactCardExtend
     */
    public function setResPath($resPath)
    {
        $this->resPath = $resPath;

        return $this;
    }

    /**
     * Get resPath
     *
     * @return string 
     */
    public function getResPath()
    {
        return $this->resPath;
    }

    /**
     * Set markPoint
     *
     * @param string $markPoint
     * @return ContactCardExtend
     */
    public function setMarkPoint($markPoint)
    {
        $this->markPoint = $markPoint;

        return $this;
    }

    /**
     * Get markPoint
     *
     * @return string 
     */
    public function getMarkPoint()
    {
        return $this->markPoint;
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
    /**
     * @var string
     */
    private $resMd5;


    /**
     * Set resMd5
     *
     * @param string $resMd5
     * @return ContactCardExtend
     */
    public function setResMd5($resMd5)
    {
        $this->resMd5 = $resMd5;

        return $this;
    }

    /**
     * Get resMd5
     *
     * @return string 
     */
    public function getResMd5()
    {
        return $this->resMd5;
    }
    /**
     * @var string
     */
    private $layout;


    /**
     * Set layout
     *
     * @param string $layout
     * @return ContactCardExtend
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
    
        return $this;
    }

    /**
     * Get layout
     *
     * @return string 
     */
    public function getLayout()
    {
        return $this->layout;
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
     * Set userId
     *
     * @param string $userId
     * @return ContactCardExtend
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
     * Set reOrder
     *
     * @param string $reOrder
     * @return ContactCardExtend
     */
    public function setReOrder($reOrder)
    {
        $this->reOrder = $reOrder;
    
        return $this;
    }

    /**
     * Get reOrder
     *
     * @return string 
     */
    public function getReOrder()
    {
        return $this->reOrder;
    }

    /**
     * Set latLng
     *
     * @param string $latLng
     * @return ContactCardExtend
     */
    public function setLatLng($latLng)
    {
        $this->latLng = $latLng;

        return $this;
    }

    /**
     * Get latLng
     *
     * @return string
     */
    public function getLatLng()
    {
        return $this->latLng;
    }
}
