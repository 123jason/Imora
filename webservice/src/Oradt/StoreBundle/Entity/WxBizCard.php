<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WxBizCard
 */
class WxBizCard
{
    /**
     * @var string
     */
    private $bizId;

    /**
     * @var string
     */
    private $cardId;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $vcard;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $markPoint;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $picture;

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
    private $remark;

    /**
     * @var string
     */
    private $vcardtxt;

    /**
     * @var integer
     */
    private $modifiedTime;


    /**
     * @var integer
     */
    private $createTime;

    /**
     * @var string
     */
    private $cardFrom;

    /**
     * @var string
     */
    private $cardType;


    /**
     * Set vcardtxt
     *
     * @param string $vcardtxt
     * @return WxBizCard
     */
    public function setVcardtxt($vcardtxt)
    {
        $this->vcardtxt = $vcardtxt;

        return $this;
    }

    /**
     * Get vcardtxt
     *
     * @return string
     */
    public function getVcardtxt()
    {
        return $this->vcardtxt;
    }


    /**
     * Set cardType
     *
     * @param string $cardType
     * @return WxBizCard
     */
    public function setCardType($cardType)
    {
        $this->cardType = $cardType;

        return $this;
    }

    /**
     * Get cardType
     *
     * @return string
     */
    public function getCardType()
    {
        return $this->cardType;
    }

    /**
     * Set cardFrom
     *
     * @param string $cardFrom
     * @return WxBizCard
     */
    public function setCardFrom($cardFrom)
    {
        $this->cardFrom = $cardFrom;

        return $this;
    }

    /**
     * Get cardFrom
     *
     * @return string
     */
    public function getCardFrom()
    {
        return $this->cardFrom;
    }



    /**
     * Set vcard
     *
     * @param string $vcard
     * @return WxBizCard
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
     * Set cardId
     *
     * @param string $cardId
     * @return WxBizCard
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
     * Set userId
     *
     * @param string $userId
     * @return WxBizCard
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
     * Set markPoint
     *
     * @param string $markPoint
     * @return WxBizCard
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
     * Set picture
     *
     * @param string $picture
     * @return WxBizCard
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set picPathA
     *
     * @param string $picPathA
     * @return WxBizCard
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
     * @return WxBizCard
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
     * Set remark
     *
     * @param string $remark
     * @return WxBizCard
     */
    public function setRemark($remark)
    {
        $this->remark = $remark;

        return $this;
    }

    /**
     * Get remark
     *
     * @return string
     */
    public function getRemark()
    {
        return $this->remark;
    }


    /**
     * Set modifiedTime
     *
     * @param string $modifiedTime
     * @return WxBizCard
     */
    public function setModifiedTime($modifiedTime)
    {
        $this->modifiedTime = $modifiedTime;

        return $this;
    }

    /**
     * Get modifiedTime
     *
     * @return string
     */
    public function getModifiedTime()
    {
        return $this->modifiedTime;
    }


    /**
     * Set createTime
     *
     * @param string $createTime
     * @return WxBizCard
     */
    public function setCreateTime($createTime)
    {
        $this->createTime = $createTime;

        return $this;
    }

    /**
     * Get createTime
     *
     * @return string
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }




    /**
     * Set bizId
     *
     * @param string $bizId
     * @return WxBizCard
     */
    public function setBizId($bizId)
    {
        $this->bizId = $bizId;
    
        return $this;
    }

    /**
     * Get bizId
     *
     * @return string 
     */
    public function getBizId()
    {
        return $this->bizId;
    }


    /**
     * Set status
     *
     * @param string $status
     * @return WxBizCard
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
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
