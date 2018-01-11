<?php
/**
 * Created by PhpStorm.
 * User: qiuzhigang
 * Date: 2017/9/28
 * Time: 15:05
 */

namespace Oradt\StoreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * WxFiexdQrcode
 */
class WxFiexdQrcode
{
    /***
     * @var string
     */
    private $ticket;

    /***
     * @var string
     */
    private $sceneValue;

    /***
     * @var string
     */
    private $uuid;

    /***
     * @var string
     */
    private $sceneType;

    /***
     * @var string
     */
    private $deviceSn;

    /***
     * @var integer
     */
    private $deviceType;

    /**
     * @var integer
     */
    private $createTime;

    /**
     * @var integer
     */
    private $modifyTime;

    /**
     * @var integer
     */
    private $id;

    /**
     * @return string
     */
    public function getTicket()
    {
        return $this->ticket;
    }

    /**
     * Set ticket
     *
     * @param string $ticket
     * @return WxFiexdQrcode
     */
    public function setTicket( $ticket)
    {
        $this->ticket = $ticket;

        return $this;
    }

    /**
     * @return string
     */
    public function getSceneValue()
    {
        return $this->sceneValue;
    }

    /**
     * Set sceneValue
     *
     * @param string $sceneValue
     * @return WxFiexdQrcode
     */
    public function setSceneValue( $sceneValue)
    {
        $this->sceneValue = $sceneValue;

        return $this;
    }

    /**
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set uuid
     *
     * @param string $uuid
     * @return WxFiexdQrcode
     */
    public function setUuid( $uuid)
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * @return string
     */
    public function getSceneType()
    {
        return $this->sceneType;
    }

    /**
     * Set sceneType
     *
     * @param string $sceneType
     * @return WxFiexdQrcode
     */
    public function setSceneType( $sceneType)
    {
        $this->sceneType = $sceneType;

        return $this;
    }

    /**
     * @return string
     */
    public function getDeviceSn()
    {
        return $this->deviceSn;
    }

    /**
     * Set deviceSn
     *
     * @param string $deviceSn
     * @return WxFiexdQrcode
     */
    public function setDeviceSn( $deviceSn)
    {
        $this->deviceSn = $deviceSn;

        return $this;
    }

    /**
     * @return int
     */
    public function getDeviceType()
    {
        return $this->deviceType;
    }

    /**
     * Set deviceType
     *
     * @param int $deviceType
     * @return WxFiexdQrcode
     */
    public function setDeviceType( $deviceType)
    {
        $this->deviceType = $deviceType;

        return $this;
    }

    /**
     * @return int
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * Set createTime
     *
     * @param int $createTime
     * @return WxFiexdQrcode
     */
    public function setCreateTime( $createTime)
    {
        $this->createTime = $createTime;

        return $this;
    }

    /**
     * @return int
     */
    public function getModifyTime()
    {
        return $this->modifyTime;
    }

    /**
     *  Set modifyTime
     *
     * @param int $modifyTime
     * @return WxFiexdQrcode
     */
    public function setModifyTime( $modifyTime)
    {
        $this->modifyTime = $modifyTime;

        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

}