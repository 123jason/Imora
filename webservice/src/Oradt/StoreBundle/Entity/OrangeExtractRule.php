<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrangeExtractRule
 */
class OrangeExtractRule
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
    private $pushUnits;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $source;

    /**
     * @var string
     */
    private $keyword;

    /**
     * @var string
     */
    private $sign;

    /**
     * @var string
     */
    private $extractInfo;

    /**
     * @var integer
     */
    private $modifyTime;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set ruleType
     *
     * @param string $ruleType
     * @return OrangeExtractRule
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
     * @return OrangeExtractRule
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
     * @return OrangeExtractRule
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
     * Set pushUnits
     *
     * @param integer $pushUnits
     * @return OrangeExtractRule
     */
    public function setPushUnits($pushUnits)
    {
        $this->pushUnits = $pushUnits;
    
        return $this;
    }

    /**
     * Get pushUnits
     *
     * @return integer 
     */
    public function getPushUnits()
    {
        return $this->pushUnits;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return OrangeExtractRule
     */
    public function setContent($content)
    {
        $this->content = $content;
    
        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set source
     *
     * @param string $source
     * @return OrangeExtractRule
     */
    public function setSource($source)
    {
        $this->source = $source;
    
        return $this;
    }

    /**
     * Get source
     *
     * @return string 
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set keyword
     *
     * @param string $keyword
     * @return OrangeExtractRule
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
     * @return OrangeExtractRule
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
     * Set extractInfo
     *
     * @param string $extractInfo
     * @return OrangeExtractRule
     */
    public function setExtractInfo($extractInfo)
    {
        $this->extractInfo = $extractInfo;
    
        return $this;
    }

    /**
     * Get extractInfo
     *
     * @return string 
     */
    public function getExtractInfo()
    {
        return $this->extractInfo;
    }

    /**
     * Set modifyTime
     *
     * @param integer $modifyTime
     * @return OrangeExtractRule
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
     * Set createdTime
     *
     * @param integer $createdTime
     * @return OrangeExtractRule
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
