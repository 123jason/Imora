<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExpoStatistic
 */
class ExpoStatistic
{
    /**
     * @var string
     */
    private $bizId;

    /**
     * @var string
     */
    private $expoId;

    /**
     * @var integer
     */
    private $type;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $bizName;

    /**
     * @var integer
     */
    private $expoCount;

    /**
     * @var integer
     */
    private $exhibitorCount;

    /**
     * @var integer
     */
    private $exhibitorUserCount;

    /**
     * @var integer
     */
    private $count;

    /**
     * @var integer
     */
    private $expoCzsCount;

    /**
     * @var integer
     */
    private $expoGzCount;

    /**
     * @var integer
     */
    private $comeCount;

    /**
     * @var integer
     */
    private $comeCzsCount;

    /**
     * @var integer
     */
    private $comeGzCount;

    /**
     * @var integer
     */
    private $nocomeCzsCount;

    /**
     * @var integer
     */
    private $nocomeGzCount;

    /**
     * @var string
     */
    private $attendanceRate;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set bizId
     *
     * @param string $bizId
     * @return ExpoStatistic
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
     * Set expoId
     *
     * @param string $expoId
     * @return ExpoStatistic
     */
    public function setExpoId($expoId)
    {
        $this->expoId = $expoId;
    
        return $this;
    }

    /**
     * Get expoId
     *
     * @return string 
     */
    public function getExpoId()
    {
        return $this->expoId;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return ExpoStatistic
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
     * Set name
     *
     * @param string $name
     * @return ExpoStatistic
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
     * Set bizName
     *
     * @param string $bizName
     * @return ExpoStatistic
     */
    public function setBizName($bizName)
    {
        $this->bizName = $bizName;
    
        return $this;
    }

    /**
     * Get bizName
     *
     * @return string 
     */
    public function getBizName()
    {
        return $this->bizName;
    }

    /**
     * Set expoCount
     *
     * @param integer $expoCount
     * @return ExpoStatistic
     */
    public function setExpoCount($expoCount)
    {
        $this->expoCount = $expoCount;
    
        return $this;
    }

    /**
     * Get expoCount
     *
     * @return integer 
     */
    public function getExpoCount()
    {
        return $this->expoCount;
    }

    /**
     * Set exhibitorCount
     *
     * @param integer $exhibitorCount
     * @return ExpoStatistic
     */
    public function setExhibitorCount($exhibitorCount)
    {
        $this->exhibitorCount = $exhibitorCount;
    
        return $this;
    }

    /**
     * Get exhibitorCount
     *
     * @return integer 
     */
    public function getExhibitorCount()
    {
        return $this->exhibitorCount;
    }

    /**
     * Set exhibitorUserCount
     *
     * @param integer $exhibitorUserCount
     * @return ExpoStatistic
     */
    public function setExhibitorUserCount($exhibitorUserCount)
    {
        $this->exhibitorUserCount = $exhibitorUserCount;
    
        return $this;
    }

    /**
     * Get exhibitorUserCount
     *
     * @return integer 
     */
    public function getExhibitorUserCount()
    {
        return $this->exhibitorUserCount;
    }

    /**
     * Set count
     *
     * @param integer $count
     * @return ExpoStatistic
     */
    public function setCount($count)
    {
        $this->count = $count;
    
        return $this;
    }

    /**
     * Get count
     *
     * @return integer 
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set expoCzsCount
     *
     * @param integer $expoCzsCount
     * @return ExpoStatistic
     */
    public function setExpoCzsCount($expoCzsCount)
    {
        $this->expoCzsCount = $expoCzsCount;
    
        return $this;
    }

    /**
     * Get expoCzsCount
     *
     * @return integer 
     */
    public function getExpoCzsCount()
    {
        return $this->expoCzsCount;
    }

    /**
     * Set expoGzCount
     *
     * @param integer $expoGzCount
     * @return ExpoStatistic
     */
    public function setExpoGzCount($expoGzCount)
    {
        $this->expoGzCount = $expoGzCount;
    
        return $this;
    }

    /**
     * Get expoGzCount
     *
     * @return integer 
     */
    public function getExpoGzCount()
    {
        return $this->expoGzCount;
    }

    /**
     * Set comeCount
     *
     * @param integer $comeCount
     * @return ExpoStatistic
     */
    public function setComeCount($comeCount)
    {
        $this->comeCount = $comeCount;
    
        return $this;
    }

    /**
     * Get comeCount
     *
     * @return integer 
     */
    public function getComeCount()
    {
        return $this->comeCount;
    }

    /**
     * Set comeCzsCount
     *
     * @param integer $comeCzsCount
     * @return ExpoStatistic
     */
    public function setComeCzsCount($comeCzsCount)
    {
        $this->comeCzsCount = $comeCzsCount;
    
        return $this;
    }

    /**
     * Get comeCzsCount
     *
     * @return integer 
     */
    public function getComeCzsCount()
    {
        return $this->comeCzsCount;
    }

    /**
     * Set comeGzCount
     *
     * @param integer $comeGzCount
     * @return ExpoStatistic
     */
    public function setComeGzCount($comeGzCount)
    {
        $this->comeGzCount = $comeGzCount;
    
        return $this;
    }

    /**
     * Get comeGzCount
     *
     * @return integer 
     */
    public function getComeGzCount()
    {
        return $this->comeGzCount;
    }

    /**
     * Set nocomeCzsCount
     *
     * @param integer $nocomeCzsCount
     * @return ExpoStatistic
     */
    public function setNocomeCzsCount($nocomeCzsCount)
    {
        $this->nocomeCzsCount = $nocomeCzsCount;
    
        return $this;
    }

    /**
     * Get nocomeCzsCount
     *
     * @return integer 
     */
    public function getNocomeCzsCount()
    {
        return $this->nocomeCzsCount;
    }

    /**
     * Set nocomeGzCount
     *
     * @param integer $nocomeGzCount
     * @return ExpoStatistic
     */
    public function setNocomeGzCount($nocomeGzCount)
    {
        $this->nocomeGzCount = $nocomeGzCount;
    
        return $this;
    }

    /**
     * Get nocomeGzCount
     *
     * @return integer 
     */
    public function getNocomeGzCount()
    {
        return $this->nocomeGzCount;
    }

    /**
     * Set attendanceRate
     *
     * @param string $attendanceRate
     * @return ExpoStatistic
     */
    public function setAttendanceRate($attendanceRate)
    {
        $this->attendanceRate = $attendanceRate;
    
        return $this;
    }

    /**
     * Get attendanceRate
     *
     * @return string 
     */
    public function getAttendanceRate()
    {
        return $this->attendanceRate;
    }

    /**
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return ExpoStatistic
     */
    public function setCreatedTime($createdTime)
    {
        $this->createdTime = $createdTime;
    
        return $this;
    }

    /**
     * Get createdTime
     *
     * @return \DateTime 
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
    /**
     * @var float
     */
    private $attendanceRateCzs;


    /**
     * Set attendanceRateCzs
     *
     * @param float $attendanceRateCzs
     * @return ExpoStatistic
     */
    public function setAttendanceRateCzs($attendanceRateCzs)
    {
        $this->attendanceRateCzs = $attendanceRateCzs;
    
        return $this;
    }

    /**
     * Get attendanceRateCzs
     *
     * @return float 
     */
    public function getAttendanceRateCzs()
    {
        return $this->attendanceRateCzs;
    }
}
