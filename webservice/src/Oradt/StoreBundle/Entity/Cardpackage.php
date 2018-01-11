<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cardpackage
 */
class Cardpackage
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $groupid;

    /**
     * @var string
     */
    private $cardname;

    /**
     * @var string
     */
    private $cardid;

    /**
     * @var integer
     */
    private $type;

    /**
     * @var string
     */
    private $remark;

    /**
     * @var string
     */
    private $picturea;

    /**
     * @var string
     */
    private $pictureb;

    /**
     * @var integer
     */
    private $sorting1;

    /**
     * @var integer
     */
    private $sorting2;

    /**
     * @var integer
     */
    private $sorting3;

    /**
     * @var string
     */
    private $uuid;

    /**
     * @var \DateTime
     */
    private $createdtime;

    /**
     * @var string
     */
    private $balance;

    /**
     * @var string
     */
    private $tel;

    /**
     * @var integer
     */
    private $isfavor;

    /**
     * @var integer
     */
    private $isticket;

    /**
     * @var \DateTime
     */
    private $starttime;

    /**
     * @var \DateTime
     */
    private $endtime;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var string
     */
    private $params;

    /**
     * @var string
     */
    private $expoid;

    /**
     * @var string
     */
    private $expotitle;

    /**
     * @var integer
     */
    private $sign;

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $lng;

    /**
     * @var string
     */
    private $lat;

    /**
     * @var string
     */
    private $cardholder;

    /**
     * @var string
     */
    private $linkman;

    /**
     * @var string
     */
    private $tel2;

    /**
     * @var string
     */
    private $tel3;

    /**
     * @var string
     */
    private $validitytime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return Cardpackage
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
     * Set groupid
     *
     * @param string $groupid
     * @return Cardpackage
     */
    public function setGroupid($groupid)
    {
        $this->groupid = $groupid;
    
        return $this;
    }

    /**
     * Get groupid
     *
     * @return string 
     */
    public function getGroupid()
    {
        return $this->groupid;
    }

    /**
     * Set cardname
     *
     * @param string $cardname
     * @return Cardpackage
     */
    public function setCardname($cardname)
    {
        $this->cardname = $cardname;
    
        return $this;
    }

    /**
     * Get cardname
     *
     * @return string 
     */
    public function getCardname()
    {
        return $this->cardname;
    }

    /**
     * Set cardid
     *
     * @param string $cardid
     * @return Cardpackage
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
     * Set type
     *
     * @param integer $type
     * @return Cardpackage
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set remark
     *
     * @param string $remark
     * @return Cardpackage
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
     * Set picturea
     *
     * @param string $picturea
     * @return Cardpackage
     */
    public function setPicturea($picturea)
    {
        $this->picturea = $picturea;
    
        return $this;
    }

    /**
     * Get picturea
     *
     * @return string 
     */
    public function getPicturea()
    {
        return $this->picturea;
    }

    /**
     * Set pictureb
     *
     * @param string $pictureb
     * @return Cardpackage
     */
    public function setPictureb($pictureb)
    {
        $this->pictureb = $pictureb;
    
        return $this;
    }

    /**
     * Get pictureb
     *
     * @return string 
     */
    public function getPictureb()
    {
        return $this->pictureb;
    }

    /**
     * Set sorting1
     *
     * @param integer $sorting1
     * @return Cardpackage
     */
    public function setSorting1($sorting1)
    {
        $this->sorting1 = $sorting1;
    
        return $this;
    }

    /**
     * Get sorting1
     *
     * @return integer 
     */
    public function getSorting1()
    {
        return $this->sorting1;
    }

    /**
     * Set sorting2
     *
     * @param integer $sorting2
     * @return Cardpackage
     */
    public function setSorting2($sorting2)
    {
        $this->sorting2 = $sorting2;
    
        return $this;
    }

    /**
     * Get sorting2
     *
     * @return integer 
     */
    public function getSorting2()
    {
        return $this->sorting2;
    }

    /**
     * Set sorting3
     *
     * @param integer $sorting3
     * @return Cardpackage
     */
    public function setSorting3($sorting3)
    {
        $this->sorting3 = $sorting3;
    
        return $this;
    }

    /**
     * Get sorting3
     *
     * @return integer 
     */
    public function getSorting3()
    {
        return $this->sorting3;
    }

    /**
     * Set uuid
     *
     * @param string $uuid
     * @return Cardpackage
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
     * Set createdtime
     *
     * @param \DateTime $createdtime
     * @return Cardpackage
     */
    public function setCreatedtime($createdtime)
    {
        $this->createdtime = $createdtime;
    
        return $this;
    }

    /**
     * Get createdtime
     *
     * @return \DateTime 
     */
    public function getCreatedtime()
    {
        return $this->createdtime;
    }

    /**
     * Set balance
     *
     * @param string $balance
     * @return Cardpackage
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;
    
        return $this;
    }

    /**
     * Get balance
     *
     * @return string 
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * Set tel
     *
     * @param string $tel
     * @return Cardpackage
     */
    public function setTel($tel)
    {
        $this->tel = $tel;
    
        return $this;
    }

    /**
     * Get tel
     *
     * @return string 
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set isfavor
     *
     * @param integer $isfavor
     * @return Cardpackage
     */
    public function setIsfavor($isfavor)
    {
        $this->isfavor = $isfavor;
    
        return $this;
    }

    /**
     * Get isfavor
     *
     * @return integer 
     */
    public function getIsfavor()
    {
        return $this->isfavor;
    }

    /**
     * Set isticket
     *
     * @param integer $isticket
     * @return Cardpackage
     */
    public function setIsticket($isticket)
    {
        $this->isticket = $isticket;
    
        return $this;
    }

    /**
     * Get isticket
     *
     * @return integer 
     */
    public function getIsticket()
    {
        return $this->isticket;
    }

    /**
     * Set starttime
     *
     * @param \DateTime $starttime
     * @return Cardpackage
     */
    public function setStarttime($starttime)
    {
        $this->starttime = $starttime;
    
        return $this;
    }

    /**
     * Get starttime
     *
     * @return \DateTime 
     */
    public function getStarttime()
    {
        return $this->starttime;
    }

    /**
     * Set endtime
     *
     * @param \DateTime $endtime
     * @return Cardpackage
     */
    public function setEndtime($endtime)
    {
        $this->endtime = $endtime;
    
        return $this;
    }

    /**
     * Get endtime
     *
     * @return \DateTime 
     */
    public function getEndtime()
    {
        return $this->endtime;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Cardpackage
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

    /**
     * Set params
     *
     * @param string $params
     * @return Cardpackage
     */
    public function setParams($params)
    {
        $this->params = $params;
    
        return $this;
    }

    /**
     * Get params
     *
     * @return string 
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Set expoid
     *
     * @param string $expoid
     * @return Cardpackage
     */
    public function setExpoid($expoid)
    {
        $this->expoid = $expoid;
    
        return $this;
    }

    /**
     * Get expoid
     *
     * @return string 
     */
    public function getExpoid()
    {
        return $this->expoid;
    }

    /**
     * Set expotitle
     *
     * @param string $expotitle
     * @return Cardpackage
     */
    public function setExpotitle($expotitle)
    {
        $this->expotitle = $expotitle;
    
        return $this;
    }

    /**
     * Get expotitle
     *
     * @return string 
     */
    public function getExpotitle()
    {
        return $this->expotitle;
    }

    /**
     * Set sign
     *
     * @param integer $sign
     * @return Cardpackage
     */
    public function setSign($sign)
    {
        $this->sign = $sign;
    
        return $this;
    }

    /**
     * Get sign
     *
     * @return integer 
     */
    public function getSign()
    {
        return $this->sign;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Cardpackage
     */
    public function setAddress($address)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set lng
     *
     * @param string $lng
     * @return Cardpackage
     */
    public function setLng($lng)
    {
        $this->lng = $lng;
    
        return $this;
    }

    /**
     * Get lng
     *
     * @return string 
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * Set lat
     *
     * @param string $lat
     * @return Cardpackage
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    
        return $this;
    }

    /**
     * Get lat
     *
     * @return string 
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set cardholder
     *
     * @param string $cardholder
     * @return Cardpackage
     */
    public function setCardholder($cardholder)
    {
        $this->cardholder = $cardholder;
    
        return $this;
    }

    /**
     * Get cardholder
     *
     * @return string 
     */
    public function getCardholder()
    {
        return $this->cardholder;
    }

    /**
     * Set linkman
     *
     * @param string $linkman
     * @return Cardpackage
     */
    public function setLinkman($linkman)
    {
        $this->linkman = $linkman;
    
        return $this;
    }

    /**
     * Get linkman
     *
     * @return string 
     */
    public function getLinkman()
    {
        return $this->linkman;
    }

    /**
     * Set tel2
     *
     * @param string $tel2
     * @return Cardpackage
     */
    public function setTel2($tel2)
    {
        $this->tel2 = $tel2;
    
        return $this;
    }

    /**
     * Get tel2
     *
     * @return string 
     */
    public function getTel2()
    {
        return $this->tel2;
    }

    /**
     * Set tel3
     *
     * @param string $tel3
     * @return Cardpackage
     */
    public function setTel3($tel3)
    {
        $this->tel3 = $tel3;
    
        return $this;
    }

    /**
     * Get tel3
     *
     * @return string 
     */
    public function getTel3()
    {
        return $this->tel3;
    }

    /**
     * Set validitytime
     *
     * @param string $validitytime
     * @return Cardpackage
     */
    public function setValiditytime($validitytime)
    {
        $this->validitytime = $validitytime;
    
        return $this;
    }

    /**
     * Get validitytime
     *
     * @return string 
     */
    public function getValiditytime()
    {
        return $this->validitytime;
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
