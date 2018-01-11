<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TaskRecordResource
 */
class TaskRecordResource
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var integer
     */
    private $recordId;

    /**
     * @var string
     */
    private $smallPath;

    /**
     * @var string
     */
    private $resPath;

    /**
     * @var boolean
     */
    private $sorting;

    /**
     * @var integer
     */
    private $createTime;

    /**
     * @var integer
     */
    private $reshigh;

    /**
     * @var integer
     */
    private $reswide;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return TaskRecordResource
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    
        return $this;
    }

    /**
     * Get userId
     *
     * @return string 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set recordId
     *
     * @param integer $recordId
     * @return TaskRecordResource
     */
    public function setRecordId($recordId)
    {
        $this->recordId = $recordId;
    
        return $this;
    }

    /**
     * Get recordId
     *
     * @return integer 
     */
    public function getRecordId()
    {
        return $this->recordId;
    }

    /**
     * Set smallPath
     *
     * @param string $smallPath
     * @return TaskRecordResource
     */
    public function setSmallPath($smallPath)
    {
        $this->smallPath = $smallPath;
    
        return $this;
    }

    /**
     * Get smallPath
     *
     * @return string 
     */
    public function getSmallPath()
    {
        return $this->smallPath;
    }

    /**
     * Set resPath
     *
     * @param string $resPath
     * @return TaskRecordResource
     */
    public function setResPath($resPath)
    {
        $this->resPath = $resPath;
    
        return $this;
    }

    /**
     * Get resPath
     *
     * @return string 
     */
    public function getResPath()
    {
        return $this->resPath;
    }

    /**
     * Set sorting
     *
     * @param boolean $sorting
     * @return TaskRecordResource
     */
    public function setSorting($sorting)
    {
        $this->sorting = $sorting;
    
        return $this;
    }

    /**
     * Get sorting
     *
     * @return boolean 
     */
    public function getSorting()
    {
        return $this->sorting;
    }

    /**
     * Set createTime
     *
     * @param integer $createTime
     * @return TaskRecordResource
     */
    public function setCreateTime($createTime)
    {
        $this->createTime = $createTime;
    
        return $this;
    }

    /**
     * Get createTime
     *
     * @return integer 
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * Set reshigh
     *
     * @param integer $reshigh
     * @return TaskRecordResource
     */
    public function setReshigh($reshigh)
    {
        $this->reshigh = $reshigh;

        return $this;
    }

    /**
     * Get reshigh
     *
     * @return integer
     */
    public function getReshigh()
    {
        return $this->reshigh;
    }

    /**
     * Set reswide
     *
     * @param integer $reswide
     * @return TaskRecordResource
     */
    public function setReswide($reswide)
    {
        $this->reswide = $reswide;

        return $this;
    }

    /**
     * Get reswide
     *
     * @return integer
     */
    public function getReswide()
    {
        return $this->reswide;
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
