<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Weather
 */
class Weather
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var integer
     */
    private $feelslike;

    /**
     * @var integer
     */
    private $tempHi;

    /**
     * @var integer
     */
    private $tempLo;

    /**
     * @var integer
     */
    private $pm25;

    /**
     * @var integer
     */
    private $wind;

    /**
     * @var integer
     */
    private $windDegree;

    /**
     * @var integer
     */
    private $humidity;

    /**
     * @var integer
     */
    private $uvIndex;

    /**
     * @var integer
     */
    private $visibility;

    /**
     * @var integer
     */
    private $dewPoint;

    /**
     * @var integer
     */
    private $barometer;

    /**
     * @var \DateTime
     */
    private $dateTime;

    /**
     * @var string
     */
    private $cityCode;

    /**
     * @var string
     */
    private $whichday;

    /**
     * @var string
     */
    private $daynight;

    /**
     * @var string
     */
    private $suntime;

    /**
     * @var string
     */
    private $iscache;

    /**
     * @var integer
     */
    private $sunrise;

    /**
     * @var integer
     */
    private $sunset;

    /**
     * @var integer
     */
    private $pubDate;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set code
     *
     * @param string $code
     * @return Weather
     */
    public function setCode($code)
    {
        $this->code = $code;
    
        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set feelslike
     *
     * @param integer $feelslike
     * @return Weather
     */
    public function setFeelslike($feelslike)
    {
        $this->feelslike = $feelslike;
    
        return $this;
    }

    /**
     * Get feelslike
     *
     * @return integer 
     */
    public function getFeelslike()
    {
        return $this->feelslike;
    }

    /**
     * Set tempHi
     *
     * @param integer $tempHi
     * @return Weather
     */
    public function setTempHi($tempHi)
    {
        $this->tempHi = $tempHi;
    
        return $this;
    }

    /**
     * Get tempHi
     *
     * @return integer 
     */
    public function getTempHi()
    {
        return $this->tempHi;
    }

    /**
     * Set tempLo
     *
     * @param integer $tempLo
     * @return Weather
     */
    public function setTempLo($tempLo)
    {
        $this->tempLo = $tempLo;
    
        return $this;
    }

    /**
     * Get tempLo
     *
     * @return integer 
     */
    public function getTempLo()
    {
        return $this->tempLo;
    }

    /**
     * Set pm25
     *
     * @param integer $pm25
     * @return Weather
     */
    public function setPm25($pm25)
    {
        $this->pm25 = $pm25;
    
        return $this;
    }

    /**
     * Get pm25
     *
     * @return integer 
     */
    public function getPm25()
    {
        return $this->pm25;
    }

    /**
     * Set wind
     *
     * @param integer $wind
     * @return Weather
     */
    public function setWind($wind)
    {
        $this->wind = $wind;
    
        return $this;
    }

    /**
     * Get wind
     *
     * @return integer 
     */
    public function getWind()
    {
        return $this->wind;
    }

    /**
     * Set windDegree
     *
     * @param integer $windDegree
     * @return Weather
     */
    public function setWindDegree($windDegree)
    {
        $this->windDegree = $windDegree;
    
        return $this;
    }

    /**
     * Get windDegree
     *
     * @return integer 
     */
    public function getWindDegree()
    {
        return $this->windDegree;
    }

    /**
     * Set humidity
     *
     * @param integer $humidity
     * @return Weather
     */
    public function setHumidity($humidity)
    {
        $this->humidity = $humidity;
    
        return $this;
    }

    /**
     * Get humidity
     *
     * @return integer 
     */
    public function getHumidity()
    {
        return $this->humidity;
    }

    /**
     * Set uvIndex
     *
     * @param integer $uvIndex
     * @return Weather
     */
    public function setUvIndex($uvIndex)
    {
        $this->uvIndex = $uvIndex;
    
        return $this;
    }

    /**
     * Get uvIndex
     *
     * @return integer 
     */
    public function getUvIndex()
    {
        return $this->uvIndex;
    }

    /**
     * Set visibility
     *
     * @param integer $visibility
     * @return Weather
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;
    
        return $this;
    }

    /**
     * Get visibility
     *
     * @return integer 
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * Set dewPoint
     *
     * @param integer $dewPoint
     * @return Weather
     */
    public function setDewPoint($dewPoint)
    {
        $this->dewPoint = $dewPoint;
    
        return $this;
    }

    /**
     * Get dewPoint
     *
     * @return integer 
     */
    public function getDewPoint()
    {
        return $this->dewPoint;
    }

    /**
     * Set barometer
     *
     * @param integer $barometer
     * @return Weather
     */
    public function setBarometer($barometer)
    {
        $this->barometer = $barometer;
    
        return $this;
    }

    /**
     * Get barometer
     *
     * @return integer 
     */
    public function getBarometer()
    {
        return $this->barometer;
    }

    /**
     * Set dateTime
     *
     * @param \DateTime $dateTime
     * @return Weather
     */
    public function setDateTime($dateTime)
    {
        $this->dateTime = $dateTime;
    
        return $this;
    }

    /**
     * Get dateTime
     *
     * @return \DateTime 
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }

    /**
     * Set cityCode
     *
     * @param string $cityCode
     * @return Weather
     */
    public function setCityCode($cityCode)
    {
        $this->cityCode = $cityCode;
    
        return $this;
    }

    /**
     * Get cityCode
     *
     * @return string 
     */
    public function getCityCode()
    {
        return $this->cityCode;
    }

    /**
     * Set whichday
     *
     * @param string $whichday
     * @return Weather
     */
    public function setWhichday($whichday)
    {
        $this->whichday = $whichday;
    
        return $this;
    }

    /**
     * Get whichday
     *
     * @return string 
     */
    public function getWhichday()
    {
        return $this->whichday;
    }

    /**
     * Set daynight
     *
     * @param string $daynight
     * @return Weather
     */
    public function setDaynight($daynight)
    {
        $this->daynight = $daynight;
    
        return $this;
    }

    /**
     * Get daynight
     *
     * @return string 
     */
    public function getDaynight()
    {
        return $this->daynight;
    }

    /**
     * Set suntime
     *
     * @param string $suntime
     * @return Weather
     */
    public function setSuntime($suntime)
    {
        $this->suntime = $suntime;
    
        return $this;
    }

    /**
     * Get suntime
     *
     * @return string 
     */
    public function getSuntime()
    {
        return $this->suntime;
    }

    /**
     * Set iscache
     *
     * @param string $iscache
     * @return Weather
     */
    public function setIscache($iscache)
    {
        $this->iscache = $iscache;
    
        return $this;
    }

    /**
     * Get iscache
     *
     * @return string 
     */
    public function getIscache()
    {
        return $this->iscache;
    }

    /**
     * Set sunrise
     *
     * @param integer $sunrise
     * @return Weather
     */
    public function setSunrise($sunrise)
    {
        $this->sunrise = $sunrise;
    
        return $this;
    }

    /**
     * Get sunrise
     *
     * @return integer 
     */
    public function getSunrise()
    {
        return $this->sunrise;
    }

    /**
     * Set sunset
     *
     * @param integer $sunset
     * @return Weather
     */
    public function setSunset($sunset)
    {
        $this->sunset = $sunset;
    
        return $this;
    }

    /**
     * Get sunset
     *
     * @return integer 
     */
    public function getSunset()
    {
        return $this->sunset;
    }

    /**
     * Set pubDate
     *
     * @param integer $pubDate
     * @return Weather
     */
    public function setPubDate($pubDate)
    {
        $this->pubDate = $pubDate;
    
        return $this;
    }

    /**
     * Get pubDate
     *
     * @return integer 
     */
    public function getPubDate()
    {
        return $this->pubDate;
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
