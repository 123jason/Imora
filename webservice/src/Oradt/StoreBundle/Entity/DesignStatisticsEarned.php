<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DesignStatisticsEarned
 */
class DesignStatisticsEarned
{
    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $userid;

    /**
     * @var integer
     */
    private $productSales;

    /**
     * @var string
     */
    private $productEarn;

    /**
     * @var integer
     */
    private $projectNum;

    /**
     * @var string
     */
    private $projectEarn;

    /**
     * @var integer
     */
    private $projectSelfNum;

    /**
     * @var string
     */
    private $projectEarnSelf;

    /**
     * @var string
     */
    private $earnSum;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set date
     *
     * @param \DateTime $date
     * @return DesignStatisticsEarned
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
     * Set userid
     *
     * @param string $userid
     * @return DesignStatisticsEarned
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;
    
        return $this;
    }

    /**
     * Get userid
     *
     * @return string 
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * Set productSales
     *
     * @param integer $productSales
     * @return DesignStatisticsEarned
     */
    public function setProductSales($productSales)
    {
        $this->productSales = $productSales;
    
        return $this;
    }

    /**
     * Get productSales
     *
     * @return integer 
     */
    public function getProductSales()
    {
        return $this->productSales;
    }

    /**
     * Set productEarn
     *
     * @param string $productEarn
     * @return DesignStatisticsEarned
     */
    public function setProductEarn($productEarn)
    {
        $this->productEarn = $productEarn;
    
        return $this;
    }

    /**
     * Get productEarn
     *
     * @return string 
     */
    public function getProductEarn()
    {
        return $this->productEarn;
    }

    /**
     * Set projectNum
     *
     * @param integer $projectNum
     * @return DesignStatisticsEarned
     */
    public function setProjectNum($projectNum)
    {
        $this->projectNum = $projectNum;
    
        return $this;
    }

    /**
     * Get projectNum
     *
     * @return integer 
     */
    public function getProjectNum()
    {
        return $this->projectNum;
    }

    /**
     * Set projectEarn
     *
     * @param string $projectEarn
     * @return DesignStatisticsEarned
     */
    public function setProjectEarn($projectEarn)
    {
        $this->projectEarn = $projectEarn;
    
        return $this;
    }

    /**
     * Get projectEarn
     *
     * @return string 
     */
    public function getProjectEarn()
    {
        return $this->projectEarn;
    }

    /**
     * Set projectSelfNum
     *
     * @param integer $projectSelfNum
     * @return DesignStatisticsEarned
     */
    public function setProjectSelfNum($projectSelfNum)
    {
        $this->projectSelfNum = $projectSelfNum;
    
        return $this;
    }

    /**
     * Get projectSelfNum
     *
     * @return integer 
     */
    public function getProjectSelfNum()
    {
        return $this->projectSelfNum;
    }

    /**
     * Set projectEarnSelf
     *
     * @param string $projectEarnSelf
     * @return DesignStatisticsEarned
     */
    public function setProjectEarnSelf($projectEarnSelf)
    {
        $this->projectEarnSelf = $projectEarnSelf;
    
        return $this;
    }

    /**
     * Get projectEarnSelf
     *
     * @return string 
     */
    public function getProjectEarnSelf()
    {
        return $this->projectEarnSelf;
    }

    /**
     * Set earnSum
     *
     * @param string $earnSum
     * @return DesignStatisticsEarned
     */
    public function setEarnSum($earnSum)
    {
        $this->earnSum = $earnSum;
    
        return $this;
    }

    /**
     * Get earnSum
     *
     * @return string 
     */
    public function getEarnSum()
    {
        return $this->earnSum;
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
     * @return DesignStatisticsEarned
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
