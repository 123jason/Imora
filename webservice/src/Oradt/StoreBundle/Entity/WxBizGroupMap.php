<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WxBizGroupMap
 */
class WxBizGroupMap
{
    /**
     * @var integer
     */
    private $departId;

    /**
     * @var integer
     */
    private $employeeId;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set departId
     *
     * @param integer $departId
     * @return WxBizGroupMap
     */
    public function setDepartId($departId)
    {
        $this->departId = $departId;
    
        return $this;
    }

    /**
     * Get departId
     *
     * @return integer 
     */
    public function getDepartId()
    {
        return $this->departId;
    }

    /**
     * Set employeeId
     *
     * @param integer $employeeId
     * @return WxBizGroupMap
     */
    public function setEmployeeId($employeeId)
    {
        $this->employeeId = $employeeId;
    
        return $this;
    }

    /**
     * Get employeeId
     *
     * @return integer 
     */
    public function getEmployeeId()
    {
        return $this->employeeId;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return WxBizGroupMap
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
