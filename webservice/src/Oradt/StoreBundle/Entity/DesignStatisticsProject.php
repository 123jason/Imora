<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DesignStatisticsProject
 */
class DesignStatisticsProject
{
    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var integer
     */
    private $releasedNum;

    /**
     * @var integer
     */
    private $turnover;

    /**
     * @var integer
     */
    private $turnoverAmount;

    /**
     * @var integer
     */
    private $trading;

    /**
     * @var integer
     */
    private $tradingAmount;

    /**
     * @var integer
     */
    private $turnoverTotal;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set date
     *
     * @param \DateTime $date
     * @return DesignStatisticsProject
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
     * Set releasedNum
     *
     * @param integer $releasedNum
     * @return DesignStatisticsProject
     */
    public function setReleasedNum($releasedNum)
    {
        $this->releasedNum = $releasedNum;
    
        return $this;
    }

    /**
     * Get releasedNum
     *
     * @return integer 
     */
    public function getReleasedNum()
    {
        return $this->releasedNum;
    }

    /**
     * Set turnover
     *
     * @param integer $turnover
     * @return DesignStatisticsProject
     */
    public function setTurnover($turnover)
    {
        $this->turnover = $turnover;
    
        return $this;
    }

    /**
     * Get turnover
     *
     * @return integer 
     */
    public function getTurnover()
    {
        return $this->turnover;
    }

    /**
     * Set turnoverAmount
     *
     * @param integer $turnoverAmount
     * @return DesignStatisticsProject
     */
    public function setTurnoverAmount($turnoverAmount)
    {
        $this->turnoverAmount = $turnoverAmount;
    
        return $this;
    }

    /**
     * Get turnoverAmount
     *
     * @return integer 
     */
    public function getTurnoverAmount()
    {
        return $this->turnoverAmount;
    }

    /**
     * Set trading
     *
     * @param integer $trading
     * @return DesignStatisticsProject
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
     * Set tradingAmount
     *
     * @param integer $tradingAmount
     * @return DesignStatisticsProject
     */
    public function setTradingAmount($tradingAmount)
    {
        $this->tradingAmount = $tradingAmount;
    
        return $this;
    }

    /**
     * Get tradingAmount
     *
     * @return integer 
     */
    public function getTradingAmount()
    {
        return $this->tradingAmount;
    }

    /**
     * Set turnoverTotal
     *
     * @param integer $turnoverTotal
     * @return DesignStatisticsProject
     */
    public function setTurnoverTotal($turnoverTotal)
    {
        $this->turnoverTotal = $turnoverTotal;
    
        return $this;
    }

    /**
     * Get turnoverTotal
     *
     * @return integer 
     */
    public function getTurnoverTotal()
    {
        return $this->turnoverTotal;
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
     * @var boolean
     */
    private $unitid;


    /**
     * Set unitid
     *
     * @param boolean $unitid
     * @return DesignStatisticsProject
     */
    public function setUnitid($unitid)
    {
        $this->unitid = $unitid;
    
        return $this;
    }

    /**
     * Get unitid
     *
     * @return boolean 
     */
    public function getUnitid()
    {
        return $this->unitid;
    }
}
