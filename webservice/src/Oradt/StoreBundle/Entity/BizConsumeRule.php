<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BizConsumeRule
 */
class BizConsumeRule
{
    /**
     * @var string
     */
    private $cumId;

    /**
     * @var string
     */
    private $title;

    /**
     * @var integer
     */
    private $cycle;

    /**
     * @var integer
     */
    private $num;

    /**
     * @var integer
     */
    private $sum;

    /**
     * @var integer
     */
    private $price;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $modifyTime;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set cumId
     *
     * @param string $cumId
     * @return BizConsumeRule
     */
    public function setCumId($cumId)
    {
        $this->cumId = $cumId;
    
        return $this;
    }

    /**
     * Get cumId
     *
     * @return string 
     */
    public function getCumId()
    {
        return $this->cumId;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return BizConsumeRule
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set cycle
     *
     * @param integer $cycle
     * @return BizConsumeRule
     */
    public function setCycle($cycle)
    {
        $this->cycle = $cycle;
    
        return $this;
    }

    /**
     * Get cycle
     *
     * @return integer 
     */
    public function getCycle()
    {
        return $this->cycle;
    }

    /**
     * Set num
     *
     * @param integer $num
     * @return BizConsumeRule
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
     * Set sum
     *
     * @param integer $sum
     * @return BizConsumeRule
     */
    public function setSum($sum)
    {
        $this->sum = $sum;
    
        return $this;
    }

    /**
     * Get sum
     *
     * @return integer 
     */
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * Set price
     *
     * @param integer $price
     * @return BizConsumeRule
     */
    public function setPrice($price)
    {
        $this->price = $price;
    
        return $this;
    }

    /**
     * Get price
     *
     * @return integer 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return BizConsumeRule
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
     * @return BizConsumeRule
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
     * Set status
     *
     * @param integer $status
     * @return BizConsumeRule
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
    private $bizId;

    /**
     * @var string
     */
    private $addId;


    /**
     * Set bizId
     *
     * @param string $bizId
     * @return BizConsumeRule
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
     * Set addId
     *
     * @param string $addId
     * @return BizConsumeRule
     */
    public function setAddId($addId)
    {
        $this->addId = $addId;
    
        return $this;
    }

    /**
     * Get addId
     *
     * @return string 
     */
    public function getAddId()
    {
        return $this->addId;
    }
}
