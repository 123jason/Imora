<?php
    /**
     * Created by PhpStorm.
     * User: qiuzhigang
     * Date: 2017-10-24
     * Time: 13:48
     */

namespace Oradt\StoreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;


/**
 * ScannerWechatQrcode
 */
class ScannerWechatQrcode {

    /***
     * @var integer
     */
    private $id;
    /***
     * @var string
     */
    private $batchid;
    /**
     * @var string
     */
    private $scannerid;
    /**
     * @var string
     */
    private $wechatTicket;
    /**
     * @var string
     */
    private $wechatQrcode;
    /**
     * @var string
     */
    private $wechatUuid;
    /**
     * @var string
     */
    private $wechatUrl;
    /**
     * @var integer
     */
    private $createTime;
    /**
     * @var integer
     */
    private $modifyTime;

    /**
     * @return int
     */
    public function getId(): int{
        return $this->id;
    }

    /**
     * @return string
     */
    public function getBatchid(){
        return $this->batchid;
    }

    /**
     * @param string $batchid
     * @return ScannerWechatQrcode
     */
    public function setBatchid( $batchid){
        $this->batchid = $batchid;
        return $this;
    }

    /**
     * @return string
     */
    public function getScannerid(){
        return $this->scannerid;
    }

    /**
     * @param string $scannerid
     * @return ScannerWechatQrcode
     */
    public function setScannerid($scannerid){
        $this->scannerid = $scannerid;
        return $this;
    }

    /**
     * @return string
     */
    public function getWechatTicket(){
        return $this->wechatTicket;
    }

    /**
     * @param string $wechatTicket
     * @return ScannerWechatQrcode
     */
    public function setWechatTicket( $wechatTicket){
        $this->wechatTicket = $wechatTicket;
        return $this;
    }

    /**
     * @return string
     */
    public function getWechatQrcode(){
        return $this->wechatQrcode;
    }

    /**
     * @param string $wechatQrcode
     * @return ScannerWechatQrcode
     */
    public function setWechatQrcode($wechatQrcode){
        $this->wechatQrcode = $wechatQrcode;
        return $this;
    }

    /**
     * @return string
     */
    public function getWechatUuid(){
        return $this->wechatUuid;
    }

    /**
     * @param string $wechatUuid
     * @return ScannerWechatQrcode
     */
    public function setWechatUuid( $wechatUuid){
        $this->wechatUuid = $wechatUuid;
        return $this;
    }

    /**
     * @return string
     */
    public function getWechatUrl(){
        return $this->wechatUrl;
    }

    /**
     * @param string $wechatUrl
     * @return ScannerWechatQrcode
     */
    public function setWechatUrl($wechatUrl){
        $this->wechatUrl = $wechatUrl;
        return $this;
    }

    /**
     * @return int
     */
    public function getCreateTime(){
        return $this->createTime;
    }

    /**
     * @param int $createTime
     * @return ScannerWechatQrcode
     */
    public function setCreateTime($createTime){
        $this->createTime = $createTime;
        return $this;
    }

    /**
     * @return int
     */
    public function getModifyTime(){
        return $this->modifyTime;
    }

    /**
     * @param int $modifyTime
     * @return ScannerWechatQrcode
     */
    public function setModifyTime($modifyTime){
        $this->modifyTime = $modifyTime;
        return $this;
    }

}