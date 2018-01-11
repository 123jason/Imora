<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrangeTakenRules
 */
class OrangeTakenRules
{
    /**
     * @var string
     */
    private $ruleType;

    /**
     * @var integer
     */
    private $contentType;

    /**
     * @var integer
     */
    private $cardType;

    /**
     * @var integer
     */
    private $cardLssuer;

    /**
     * @var string
     */
    private $contentExample;

    /**
     * @var string
     */
    private $froms;

    /**
     * @var string
     */
    private $keyword;

    /**
     * @var string
     */
    private $sign;

    /**
     * @var boolean
     */
    private $status;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $verifyType;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set ruleType
     *
     * @param string $ruleType
     * @return OrangeTakenRules
     */
    public function setRuleType($ruleType)
    {
        $this->ruleType = $ruleType;
    
        return $this;
    }

    /**
     * Get ruleType
     *
     * @return string 
     */
    public function getRuleType()
    {
        return $this->ruleType;
    }

    /**
     * Set contentType
     *
     * @param integer $contentType
     * @return OrangeTakenRules
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
    
        return $this;
    }

    /**
     * Get contentType
     *
     * @return integer 
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * Set cardType
     *
     * @param integer $cardType
     * @return OrangeTakenRules
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
     * Set cardLssuer
     *
     * @param integer $cardLssuer
     * @return OrangeTakenRules
     */
    public function setCardLssuer($cardLssuer)
    {
        $this->cardLssuer = $cardLssuer;
    
        return $this;
    }

    /**
     * Get cardLssuer
     *
     * @return integer 
     */
    public function getCardLssuer()
    {
        return $this->cardLssuer;
    }

    /**
     * Set contentExample
     *
     * @param string $contentExample
     * @return OrangeTakenRules
     */
    public function setContentExample($contentExample)
    {
        $this->contentExample = $contentExample;
    
        return $this;
    }

    /**
     * Get contentExample
     *
     * @return string 
     */
    public function getContentExample()
    {
        return $this->contentExample;
    }

    /**
     * Set froms
     *
     * @param string $froms
     * @return OrangeTakenRules
     */
    public function setFroms($froms)
    {
        $this->froms = $froms;
    
        return $this;
    }

    /**
     * Get froms
     *
     * @return string 
     */
    public function getFroms()
    {
        return $this->froms;
    }

    /**
     * Set keyword
     *
     * @param string $keyword
     * @return OrangeTakenRules
     */
    public function setKeyword($keyword)
    {
        $this->keyword = $keyword;
    
        return $this;
    }

    /**
     * Get keyword
     *
     * @return string 
     */
    public function getKeyword()
    {
        return $this->keyword;
    }

    /**
     * Set sign
     *
     * @param string $sign
     * @return OrangeTakenRules
     */
    public function setSign($sign)
    {
        $this->sign = $sign;
    
        return $this;
    }

    /**
     * Get sign
     *
     * @return string 
     */
    public function getSign()
    {
        return $this->sign;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return OrangeTakenRules
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return boolean 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return OrangeTakenRules
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set verifyType
     *
     * @param string $verifyType
     * @return OrangeTakenRules
     */
    public function setVerifyType($verifyType)
    {
        $this->verifyType = $verifyType;
    
        return $this;
    }

    /**
     * Get verifyType
     *
     * @return string 
     */
    public function getVerifyType()
    {
        return $this->verifyType;
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
    private $messageJson;

    /**
     * @var integer
     */
    private $createtime;


    /**
     * Set messageJson
     *
     * @param string $messageJson
     * @return OrangeTakenRules
     */
    public function setMessageJson($messageJson)
    {
        $this->messageJson = $messageJson;
    
        return $this;
    }

    /**
     * Get messageJson
     *
     * @return string 
     */
    public function getMessageJson()
    {
        return $this->messageJson;
    }

    /**
     * Set createtime
     *
     * @param integer $createtime
     * @return OrangeTakenRules
     */
    public function setCreatetime($createtime)
    {
        $this->createtime = $createtime;
    
        return $this;
    }

    /**
     * Get createtime
     *
     * @return integer 
     */
    public function getCreatetime()
    {
        return $this->createtime;
    }
}
