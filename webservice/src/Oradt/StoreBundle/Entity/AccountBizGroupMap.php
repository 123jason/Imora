<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountBizGroupMap
 */
class AccountBizGroupMap
{
    /**
     * @var string
     */
    private $groupId;

    /**
     * @var string
     */
    private $employeeId;

    /**
     * @var string
     */
    private $isclosed;

    /**
     * @var string
     */
    private $isin;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var string
     */
    private $belongsId;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set groupId
     *
     * @param string $groupId
     * @return AccountBizGroupMap
     */
    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;
    
        return $this;
    }

    /**
     * Get groupId
     *
     * @return string 
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * Set employeeId
     *
     * @param string $employeeId
     * @return AccountBizGroupMap
     */
    public function setEmployeeId($employeeId)
    {
        $this->employeeId = $employeeId;
    
        return $this;
    }

    /**
     * Get employeeId
     *
     * @return string 
     */
    public function getEmployeeId()
    {
        return $this->employeeId;
    }

    /**
     * Set isclosed
     *
     * @param string $isclosed
     * @return AccountBizGroupMap
     */
    public function setIsclosed($isclosed)
    {
        $this->isclosed = $isclosed;
    
        return $this;
    }

    /**
     * Get isclosed
     *
     * @return string 
     */
    public function getIsclosed()
    {
        return $this->isclosed;
    }

    /**
     * Set isin
     *
     * @param string $isin
     * @return AccountBizGroupMap
     */
    public function setIsin($isin)
    {
        $this->isin = $isin;
    
        return $this;
    }

    /**
     * Get isin
     *
     * @return string 
     */
    public function getIsin()
    {
        return $this->isin;
    }

    /**
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return AccountBizGroupMap
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
     * Set belongsId
     *
     * @param string $belongsId
     * @return AccountBizGroupMap
     */
    public function setBelongsId($belongsId)
    {
        $this->belongsId = $belongsId;
    
        return $this;
    }

    /**
     * Get belongsId
     *
     * @return string 
     */
    public function getBelongsId()
    {
        return $this->belongsId;
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
