<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DesignStatisticsProduct
 */
class DesignStatisticsProduct
{
    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var integer
     */
    private $total;

    /**
     * @var integer
     */
    private $news;

    /**
     * @var integer
     */
    private $trading;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set date
     *
     * @param \DateTime $date
     * @return DesignStatisticsProduct
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set total
     *
     * @param integer $total
     * @return DesignStatisticsProduct
     */
    public function setTotal($total)
    {
        $this->total = $total;
    
        return $this;
    }

    /**
     * Get total
     *
     * @return integer 
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set news
     *
     * @param integer $news
     * @return DesignStatisticsProduct
     */
    public function setNews($news)
    {
        $this->news = $news;
    
        return $this;
    }

    /**
     * Get news
     *
     * @return integer 
     */
    public function getNews()
    {
        return $this->news;
    }

    /**
     * Set trading
     *
     * @param integer $trading
     * @return DesignStatisticsProduct
     */
    public function setTrading($trading)
    {
        $this->trading = $trading;
    
        return $this;
    }

    /**
     * Get trading
     *
     * @return integer 
     */
    public function getTrading()
    {
        return $this->trading;
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
