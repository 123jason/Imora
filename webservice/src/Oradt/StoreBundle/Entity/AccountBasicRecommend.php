<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountBasicRecommend
 */
class AccountBasicRecommend
{
    /**
     * @var integer
     */
    private $recommendNumber;

    /**
     * @var integer
     */
    private $recommendedNumber;

    /**
     * @var string
     */
    private $title;

    /**
     * @var \DateTime
     */
    private $recommendTime;

    /**
     * @var integer
     */
    private $isPush;

    /**
     * @var integer
     */
    private $id;

    /**
     * Set recommendNumber
     *
     * @param integer $recommendNumber
     * @return AccountBasicRecommend
     */
    public function setRecommendNumber($recommendNumber)
    {
        $this->recommendNumber = $recommendNumber;

        return $this;
    }

    /**
     * Get recommendNumber
     *
     * @return integer
     */
    public function getRecommendNumber()
    {
        return $this->recommendNumber;
    }

    /**
     * Set recommendedNumber
     *
     * @param integer $recommendedNumber
     * @return AccountBasicRecommend
     */
    public function setRecommendedNumber($recommendedNumber)
    {
        $this->recommendedNumber = $recommendedNumber;

        return $this;
    }

    /**
     * Get recommendedNumber
     *
     * @return integer
     */
    public function getRecommendedNumber()
    {
        return $this->recommendedNumber;
    }

    /**
     * Set isPush
     *
     * @param integer $isPush
     * @return AccountBasicRecommend
     */
    public function setIsPush($isPush)
    {
        $this->isPush = $isPush;

        return $this;
    }

    /**
     * Get isPush
     *
     * @return integer
     */
    public function getIsPush()
    {
        return $this->isPush;
    }

    /**
     * Set title
     *
     * @param integer $title
     * @return AccountBasicRecommend
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return integer
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set recommendTime
     *
     * @param \DateTime $recommendTime
     * @return AccountBasicRecommend
     */
    public function setRecommendTime($recommendTime)
    {
        $this->recommendTime = $recommendTime;

        return $this;
    }

    /**
     * Get recommendTime
     *
     * @return \DateTime
     */
    public function getRecommendTime()
    {
        return $this->recommendTime;
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
