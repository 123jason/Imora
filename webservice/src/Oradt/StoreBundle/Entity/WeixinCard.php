<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WeixinCard
 */
class WeixinCard
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $wechatId;

    /**
     * @var integer
     */
    private $cardType;

    /**
     * @var string
     */
    private $wechatPicture;

    /**
     * @var string
     */
    private $wechatPictureB;

    /**
     * @var string
     */
    private $smallWechatPicture;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $modifyTime;

    /**
     * @var string
     */
    private $vcard;

    /**
     * @var string
     */
    private $md5PictureName;

    /**
     * @var integer
     */
    private $ocrStatus;

    /**
     * @var integer
     */
    private $isSelf;

    /**
     * @var integer
     */
    private $upway;

    /**
     * @var integer
     */
    private $buystatus;

    /**
     * @var string
     */
    private $batchid;

    /**
     * @var integer
     */
    private $appType;

    /**
     * @var string
     */
    private $ocrResult;

    /**
     * @var string
     */
    private $uuid;

    /**
     * @var string
     */
    private $initial;

    /**
     * @var string
     */
    private $markPoint;

    /**
     * @var string
     */
    private $deviceId;

    /**
     * @var string
     */
    private $longitude;

    /**
     * @var string
     */
    private $latitude;

    /**
     * @var integer
     */
    private $status;


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
     * Set wechatId
     *
     * @param string $wechatId
     * @return WeixinCard
     */
    public function setWechatId($wechatId)
    {
        $this->wechatId = $wechatId;

        return $this;
    }

    /**
     * Get wechatId
     *
     * @return string
     */
    public function getWechatId()
    {
        return $this->wechatId;
    }

    /**
     * Set cardType
     *
     * @param integer $cardType
     * @return WeixinCard
     */
    public function setCardType($cardType)
    {
        $this->cardType = $cardType;

        return $this;
    }

    /**
     * Get cardType
     *
     * @return integer
     */
    public function getCardType()
    {
        return $this->cardType;
    }

    /**
     * Set wechatPicture
     *
     * @param string $wechatPicture
     * @return WeixinCard
     */
    public function setWechatPicture($wechatPicture)
    {
        $this->wechatPicture = $wechatPicture;

        return $this;
    }

    /**
     * Get wechatPicture
     *
     * @return string
     */
    public function getWechatPicture()
    {
        return $this->wechatPicture;
    }

    /**
     * Set wechatPictureB
     *
     * @param string $wechatPictureB
     * @return WeixinCard
     */
    public function setWechatPictureB($wechatPictureB)
    {
        $this->wechatPictureB = $wechatPictureB;

        return $this;
    }

    /**
     * Get wechatPictureB
     *
     * @return string
     */
    public function getWechatPictureB()
    {
        return $this->wechatPictureB;
    }

    /**
     * Set smallWechatPicture
     *
     * @param string $smallWechatPicture
     * @return WeixinCard
     */
    public function setSmallWechatPicture($smallWechatPicture)
    {
        $this->smallWechatPicture = $smallWechatPicture;

        return $this;
    }

    /**
     * Get smallWechatPicture
     *
     * @return string
     */
    public function getSmallWechatPicture()
    {
        return $this->smallWechatPicture;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return WeixinCard
     */
    public function setCreatedTime($createdTime)
    {
        $this->createdTime = $createdTime;

        return $this;
    }

    /**
     * Get createdTime
     *
     * @return integer
     */
    public function getCreatedTime()
    {
        return $this->createdTime;
    }

    /**
     * Set modifyTime
     *
     * @param integer $modifyTime
     * @return WeixinCard
     */
    public function setModifyTime($modifyTime)
    {
        $this->modifyTime = $modifyTime;

        return $this;
    }

    /**
     * Get modifyTime
     *
     * @return integer
     */
    public function getModifyTime()
    {
        return $this->modifyTime;
    }

    /**
     * Set vcard
     *
     * @param string $vcard
     * @return WeixinCard
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
     * Set md5PictureName
     *
     * @param string $md5PictureName
     * @return WeixinCard
     */
    public function setMd5PictureName($md5PictureName)
    {
        $this->md5PictureName = $md5PictureName;

        return $this;
    }

    /**
     * Get md5PictureName
     *
     * @return string
     */
    public function getMd5PictureName()
    {
        return $this->md5PictureName;
    }

    /**
     * Set ocrStatus
     *
     * @param integer $ocrStatus
     * @return WeixinCard
     */
    public function setOcrStatus($ocrStatus)
    {
        $this->ocrStatus = $ocrStatus;

        return $this;
    }

    /**
     * Get ocrStatus
     *
     * @return integer
     */
    public function getOcrStatus()
    {
        return $this->ocrStatus;
    }

    /**
     * Set isSelf
     *
     * @param integer $isSelf
     * @return WeixinCard
     */
    public function setIsSelf($isSelf)
    {
        $this->isSelf = $isSelf;

        return $this;
    }

    /**
     * Get isSelf
     *
     * @return integer
     */
    public function getIsSelf()
    {
        return $this->isSelf;
    }

    /**
     * Set upway
     *
     * @param integer $upway
     * @return WeixinCard
     */
    public function setUpway($upway)
    {
        $this->upway = $upway;

        return $this;
    }

    /**
     * Get upway
     *
     * @return integer
     */
    public function getUpway()
    {
        return $this->upway;
    }

    /**
     * Set buystatus
     *
     * @param integer $buystatus
     * @return WeixinCard
     */
    public function setBuystatus($buystatus)
    {
        $this->buystatus = $buystatus;

        return $this;
    }

    /**
     * Get buystatus
     *
     * @return integer
     */
    public function getBuystatus()
    {
        return $this->buystatus;
    }

    /**
     * Set batchid
     *
     * @param string $batchid
     * @return WeixinCard
     */
    public function setBatchid($batchid)
    {
        $this->batchid = $batchid;

        return $this;
    }

    /**
     * Get batchid
     *
     * @return string
     */
    public function getBatchid()
    {
        return $this->batchid;
    }

    /**
     * Set appType
     *
     * @param integer $appType
     * @return WeixinCard
     */
    public function setAppType($appType)
    {
        $this->appType = $appType;

        return $this;
    }

    /**
     * Get appType
     *
     * @return integer
     */
    public function getAppType()
    {
        return $this->appType;
    }

    /**
     * Set ocrResult
     *
     * @param string $ocrResult
     * @return WeixinCard
     */
    public function setOcrResult($ocrResult)
    {
        $this->ocrResult = $ocrResult;

        return $this;
    }

    /**
     * Get ocrResult
     *
     * @return string
     */
    public function getOcrResult()
    {
        return $this->ocrResult;
    }

    /**
     * Set uuid
     *
     * @param string $uuid
     * @return WeixinCard
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
     * Set initial
     *
     * @param string $initial
     * @return WeixinCard
     */
    public function setInitial($initial)
    {
        $this->initial = $initial;

        return $this;
    }

    /**
     * Get initial
     *
     * @return string
     */
    public function getInitial()
    {
        return $this->initial;
    }

    /**
     * Set markPoint
     *
     * @param string $markPoint
     * @return WeixinCard
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
     * Set deviceId
     *
     * @param string $deviceId
     * @return WeixinCard
     */
    public function setDeviceId($deviceId)
    {
        $this->deviceId = $deviceId;

        return $this;
    }

    /**
     * Get deviceId
     *
     * @return string
     */
    public function getDeviceId()
    {
        return $this->deviceId;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     * @return WeixinCard
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     * @return WeixinCard
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return WeixinCard
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }
}
