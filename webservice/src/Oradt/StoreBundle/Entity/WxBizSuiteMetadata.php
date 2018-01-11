<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WxBizSuiteMetadata
 */
class WxBizSuiteMetadata
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $suiteDesc;

    /**
     * @var integer
     */
    private $level;

    /**
     * @var integer
     */
    private $type;

    /**
     * @var string
     */
    private $price;

    /**
     * @var integer
     */
    private $num;

    /**
     * @var integer
     */
    private $sheet;

    /**
     * @var integer
     */
    private $buyMonth;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var integer
     */
    private $createTime;

    /**
     * @var integer
     */
    private $modifyTime;


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
     * Set name
     *
     * @param string $name
     * @return WxBizSuiteMetadata
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set suiteDesc
     *
     * @param string $suiteDesc
     * @return WxBizSuiteMetadata
     */
    public function setSuiteDesc($suiteDesc)
    {
        $this->suiteDesc = $suiteDesc;

        return $this;
    }

    /**
     * Get suiteDesc
     *
     * @return string 
     */
    public function getSuiteDesc()
    {
        return $this->suiteDesc;
    }

    /**
     * Set level
     *
     * @param integer $level
     * @return WxBizSuiteMetadata
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer 
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return WxBizSuiteMetadata
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
     * Set price
     *
     * @param string $price
     * @return WxBizSuiteMetadata
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set num
     *
     * @param integer $num
     * @return WxBizSuiteMetadata
     */
    public function setNum($num)
    {
        $this->num = $num;

        return $this;
    }

    /**
     * Get num
     *
     * @return integer 
     */
    public function getNum()
    {
        return $this->num;
    }

    /**
     * Set sheet
     *
     * @param integer $sheet
     * @return WxBizSuiteMetadata
     */
    public function setSheet($sheet)
    {
        $this->sheet = $sheet;

        return $this;
    }

    /**
     * Get sheet
     *
     * @return integer 
     */
    public function getSheet()
    {
        return $this->sheet;
    }

    /**
     * Set buyMonth
     *
     * @param integer $buyMonth
     * @return WxBizSuiteMetadata
     */
    public function setBuyMonth($buyMonth)
    {
        $this->buyMonth = $buyMonth;

        return $this;
    }

    /**
     * Get buyMonth
     *
     * @return integer 
     */
    public function getBuyMonth()
    {
        return $this->buyMonth;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return WxBizSuiteMetadata
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
     * Set createTime
     *
     * @param integer $createTime
     * @return WxBizSuiteMetadata
     */
    public function setCreateTime($createTime)
    {
        $this->createTime = $createTime;

        return $this;
    }

    /**
     * Get createTime
     *
     * @return integer 
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * Set modifyTime
     *
     * @param integer $modifyTime
     * @return WxBizSuiteMetadata
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
}
