<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HrJobProperties
 */
class HrJobProperties
{
    /**
     * @var string
     */
    private $jobId;

    /**
     * @var integer
     */
    private $salary;

    /**
     * @var string
     */
    private $jobArea;

    /**
     * @var string
     */
    private $jobType;

    /**
     * @var integer
     */
    private $experience;

    /**
     * @var string
     */
    private $degree;

    /**
     * @var integer
     */
    private $totaljobs;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set jobId
     *
     * @param string $jobId
     * @return HrJobProperties
     */
    public function setJobId($jobId)
    {
        $this->jobId = $jobId;
    
        return $this;
    }

    /**
     * Get jobId
     *
     * @return string 
     */
    public function getJobId()
    {
        return $this->jobId;
    }

    /**
     * Set salary
     *
     * @param integer $salary
     * @return HrJobProperties
     */
    public function setSalary($salary)
    {
        $this->salary = $salary;
    
        return $this;
    }

    /**
     * Get salary
     *
     * @return integer 
     */
    public function getSalary()
    {
        return $this->salary;
    }

    /**
     * Set jobArea
     *
     * @param string $jobArea
     * @return HrJobProperties
     */
    public function setJobArea($jobArea)
    {
        $this->jobArea = $jobArea;
    
        return $this;
    }

    /**
     * Get jobArea
     *
     * @return string 
     */
    public function getJobArea()
    {
        return $this->jobArea;
    }

    /**
     * Set jobType
     *
     * @param string $jobType
     * @return HrJobProperties
     */
    public function setJobType($jobType)
    {
        $this->jobType = $jobType;
    
        return $this;
    }

    /**
     * Get jobType
     *
     * @return string 
     */
    public function getJobType()
    {
        return $this->jobType;
    }

    /**
     * Set experience
     *
     * @param integer $experience
     * @return HrJobProperties
     */
    public function setExperience($experience)
    {
        $this->experience = $experience;
    
        return $this;
    }

    /**
     * Get experience
     *
     * @return integer 
     */
    public function getExperience()
    {
        return $this->experience;
    }


    /**
     * Set degree
     *
     * @param string $degree
     * @return HrJobProperties
     */
    public function setDegree($degree)
    {
        $this->degree = $degree;
    
        return $this;
    }

    /**
     * Get degree
     *
     * @return string 
     */
    public function getDegree()
    {
        return $this->degree;
    }

    /**
     * Set totaljobs
     *
     * @param integer $totaljobs
     * @return HrJobProperties
     */
    public function setTotaljobs($totaljobs)
    {
        $this->totaljobs = $totaljobs;
    
        return $this;
    }

    /**
     * Get totaljobs
     *
     * @return integer 
     */
    public function getTotaljobs()
    {
        return $this->totaljobs;
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
