<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrangeFuncCardExtendData
 */
class OrangeFuncCardExtendData
{
    /**
     * @var string
     */
    private $cardid;


    /**
     * @var float
     */
    private $cardBalance;

    /**
     * @var integer
     */
    private $cardScore;

    /**
     * @var string
     */
    private $cardLevel;

    /**
     * @var integer
     */
    private $modifyTime;

    /**
     * @var string
     */
    private $cardBill;

    /**
     * @var integer
     */
    private $isCheckIn;

    /**
     * @var string
     */
    private $mileage;

    /**
     * @var string
     */
    private $leg;

    /**
     * @var string
     */
    private $upLeg;

    /**
     * @var string
     */
    private $monthExpiredEile;

    /**
     * @var string
     */
    private $yearExpiredMile;

    /**
     * @var string
     */
    private $upMile;

    /**
     * @var string
     */
    private $upTotalMile;

    /**
     * @var string
     */
    private $upTotalLeg;

    /**
     * @var integer
     */
    private $integral;

    /**
     * @var integer
     */
    private $monthExpiredIntegral;

    /**
     * @var integer
     */
    private $thMonExpiredIntegral;

    /**
     * @var integer
     */
    private $yearExpiredIntegral;

    /**
     * @var string
     */
    private $thMonExpiredMile;

    /**
     * @var integer
     */
    private $upIntegral;

    /**
     * @var integer
     */
    private $upTotalIntegral;

    /**
     * @var integer
     */
    private $gatherState;

    /**
     * @var integer
     */
    private $checkInTime;




    /**
     * @var integer
     */
    private $id;


    /**
     * Set checkInTime
     *
     * @param integer $checkInTime
     * @return OrangeFuncCard
     */
    public function setCheckInTime($checkInTime)
    {
        $this->checkInTime = $checkInTime;

        return $this;
    }

    /**
     * Get checkInTime
     *
     * @return integer
     */
    public function getCheckInTime()
    {
        return $this->checkInTime;
    }

    /**
     * Set gatherState
     *
     * @param integer $gatherState
     * @return OrangeFuncCard
     */
    public function setGatherState($gatherState)
    {
        $this->gatherState = $gatherState;

        return $this;
    }

    /**
     * Get gatherState
     *
     * @return integer
     */
    public function getGatherState()
    {
        return $this->gatherState;
    }

    /**
     * Set upTotalIntegral
     *
     * @param integer $upTotalIntegral
     * @return OrangeFuncCard
     */
    public function setUpTotalIntegral($upTotalIntegral)
    {
        $this->upTotalIntegral = $upTotalIntegral;

        return $this;
    }

    /**
     * Get upTotalIntegral
     *
     * @return integer
     */
    public function getUpTotalIntegral()
    {
        return $this->upTotalIntegral;
    }

    /**
     * Set upIntegral
     *
     * @param integer $upIntegral
     * @return OrangeFuncCard
     */
    public function setUpIntegral($upIntegral)
    {
        $this->upIntegral = $upIntegral;

        return $this;
    }

    /**
     * Get upIntegral
     *
     * @return integer
     */
    public function getUpIntegral()
    {
        return $this->upIntegral;
    }

    /**
     * Set thMonExpiredMile
     *
     * @param string $thMonExpiredMile
     * @return OrangeFuncCard
     */
    public function setThMonExpiredMile($thMonExpiredMile)
    {
        $this->thMonExpiredMile = $thMonExpiredMile;

        return $this;
    }

    /**
     * Get thMonExpiredMile
     *
     * @return string
     */
    public function getThMonExpiredMile()
    {
        return $this->thMonExpiredMile;
    }

    /**
     * Set yearExpiredIntegral
     *
     * @param integer $yearExpiredIntegral
     * @return OrangeFuncCard
     */
    public function setYearExpiredIntegral($yearExpiredIntegral)
    {
        $this->yearExpiredIntegral = $yearExpiredIntegral;

        return $this;
    }

    /**
     * Get yearExpiredIntegral
     *
     * @return integer
     */
    public function getYearExpiredIntegral()
    {
        return $this->yearExpiredIntegral;
    }

    /**
     * Set thMonExpiredIntegral
     *
     * @param integer $thMonExpiredIntegral
     * @return OrangeFuncCard
     */
    public function setThMonExpiredIntegral($thMonExpiredIntegral)
    {
        $this->thMonExpiredIntegral = $thMonExpiredIntegral;

        return $this;
    }

    /**
     * Get thMonExpiredIntegral
     *
     * @return integer
     */
    public function getThMonExpiredIntegral()
    {
        return $this->thMonExpiredIntegral;
    }

    /**
     * Set monthExpiredIntegral
     *
     * @param integer $monthExpiredIntegral
     * @return OrangeFuncCard
     */
    public function setMonthExpiredIntegral($monthExpiredIntegral)
    {
        $this->monthExpiredIntegral = $monthExpiredIntegral;

        return $this;
    }

    /**
     * Get monthExpiredIntegral
     *
     * @return integer
     */
    public function getMonthExpiredIntegral()
    {
        return $this->monthExpiredIntegral;
    }

    /**
     * Set integral
     *
     * @param integer $integral
     * @return OrangeFuncCard
     */
    public function setIntegral($integral)
    {
        $this->integral = $integral;

        return $this;
    }

    /**
     * Get integral
     *
     * @return integer
     */
    public function getIntegral()
    {
        return $this->integral;
    }

    /**
     * Set upTotalLeg
     *
     * @param string $upTotalLeg
     * @return OrangeFuncCard
     */
    public function setUpTotalLeg($upTotalLeg)
    {
        $this->upTotalLeg = $upTotalLeg;

        return $this;
    }

    /**
     * Get upTotalLeg
     *
     * @return string
     */
    public function getUpTotalLeg()
    {
        return $this->upTotalLeg;
    }

    /**
     * Set upLeg
     *
     * @param string $upLeg
     * @return OrangeFuncCard
     */
    public function setUpLeg($upLeg)
    {
        $this->upLeg = $upLeg;

        return $this;
    }

    /**
     * Get upLeg
     *
     * @return string
     */
    public function getUpLeg()
    {
        return $this->upLeg;
    }


    /**
     * Set upTotalMile
     *
     * @param string $upTotalMile
     * @return OrangeFuncCard
     */
    public function setUpTotalMile($upTotalMile)
    {
        $this->upTotalMile = $upTotalMile;

        return $this;
    }

    /**
     * Get upTotalMile
     *
     * @return string
     */
    public function getUpTotalMile()
    {
        return $this->upTotalMile;
    }


    /**
     * Set upMile
     *
     * @param string $upMile
     * @return OrangeFuncCard
     */
    public function setUpMile($upMile)
    {
        $this->upMile = $upMile;

        return $this;
    }

    /**
     * Get upMile
     *
     * @return string
     */
    public function getUpMile()
    {
        return $this->upMile;
    }

    /**
     * Set yearExpiredMile
     *
     * @param string $yearExpiredMile
     * @return OrangeFuncCard
     */
    public function setYearExpiredMile($yearExpiredMile)
    {
        $this->yearExpiredMile = $yearExpiredMile;

        return $this;
    }

    /**
     * Get yearExpiredMile
     *
     * @return string
     */
    public function getYearExpiredMile()
    {
        return $this->yearExpiredMile;
    }


    /**
     * Set monthExpiredEile
     *
     * @param string $monthExpiredEile
     * @return OrangeFuncCard
     */
    public function setMonthExpiredEile($monthExpiredEile)
    {
        $this->monthExpiredEile = $monthExpiredEile;

        return $this;
    }

    /**
     * Get monthExpiredEile
     *
     * @return string
     */
    public function getMonthExpiredEile()
    {
        return $this->monthExpiredEile;
    }

    /**
     * Set leg
     *
     * @param string $leg
     * @return OrangeFuncCard
     */
    public function setLeg($leg)
    {
        $this->leg = $leg;

        return $this;
    }

    /**
     * Get leg
     *
     * @return string
     */
    public function getLeg()
    {
        return $this->leg;
    }


    /**
     * Set mileage
     *
     * @param string $mileage
     * @return OrangeFuncCard
     */
    public function setMileage($mileage)
    {
        $this->mileage = $mileage;

        return $this;
    }

    /**
     * Get mileage
     *
     * @return string
     */
    public function getMileage()
    {
        return $this->mileage;
    }


    /**
     * Set cardid
     *
     * @param string $cardid
     * @return OrangeFuncCard
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
     * Set cardBalance
     *
     * @param float $cardBalance
     * @return OrangeFuncCard
     */
    public function setCardBalance($cardBalance)
    {
        $this->cardBalance = $cardBalance;
    
        return $this;
    }

    /**
     * Get cardBalance
     *
     * @return float 
     */
    public function getCardBalance()
    {
        return $this->cardBalance;
    }

    /**
     * Set cardScore
     *
     * @param integer $cardScore
     * @return OrangeFuncCard
     */
    public function setCardScore($cardScore)
    {
        $this->cardScore = $cardScore;
    
        return $this;
    }

    /**
     * Get cardScore
     *
     * @return integer 
     */
    public function getCardScore()
    {
        return $this->cardScore;
    }

    /**
     * Set cardLevel
     *
     * @param string $cardLevel
     * @return OrangeFuncCard
     */
    public function setCardLevel($cardLevel)
    {
        $this->cardLevel = $cardLevel;
    
        return $this;
    }

    /**
     * Get cardLevel
     *
     * @return string 
     */
    public function getCardLevel()
    {
        return $this->cardLevel;
    }


    /**
     * Set modifyTime
     *
     * @param integer $modifyTime
     * @return OrangeFuncCard
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
     * Set cardBill
     *
     * @param string $cardBill
     * @return OrangeFuncCard
     */
    public function setCardBill($cardBill)
    {
        $this->cardBill = $cardBill;
    
        return $this;
    }

    /**
     * Get cardBill
     *
     * @return string 
     */
    public function getCardBill()
    {
        return $this->cardBill;
    }

    /**
     * Set isCheckIn
     *
     * @param integer $isCheckIn
     * @return OrangeFuncCard
     */
    public function setIsCheckIn($isCheckIn)
    {
        $this->isCheckIn = $isCheckIn;
    
        return $this;
    }

    /**
     * Get isCheckIn
     *
     * @return integer 
     */
    public function getIsCheckIn()
    {
        return $this->isCheckIn;
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
