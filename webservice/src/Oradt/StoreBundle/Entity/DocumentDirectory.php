<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DocumentDirectory
 */
class DocumentDirectory
{
    /**
     * @var string
     */
    private $parentId;

    /**
     * @var string
     */
    private $directoryId;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $directoryName;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var string
     */
    private $status;

    /**
     * @var integer
     */
    private $totalFiles;

    /**
     * @var integer
     */
    private $totalItems;

    /**
     * @var \DateTime
     */
    private $lastModified;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set parentId
     *
     * @param string $parentId
     * @return DocumentDirectory
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * Get parentId
     *
     * @return string 
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Set directoryId
     *
     * @param string $directoryId
     * @return DocumentDirectory
     */
    public function setDirectoryId($directoryId)
    {
        $this->directoryId = $directoryId;

        return $this;
    }

    /**
     * Get directoryId
     *
     * @return string 
     */
    public function getDirectoryId()
    {
        return $this->directoryId;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return DocumentDirectory
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
     * Set directoryName
     *
     * @param string $directoryName
     * @return DocumentDirectory
     */
    public function setDirectoryName($directoryName)
    {
        $this->directoryName = $directoryName;

        return $this;
    }

    /**
     * Get directoryName
     *
     * @return string 
     */
    public function getDirectoryName()
    {
        return $this->directoryName;
    }

    /**
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return DocumentDirectory
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
     * Set status
     *
     * @param string $status
     * @return DocumentDirectory
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set totalFiles
     *
     * @param integer $totalFiles
     * @return DocumentDirectory
     */
    public function setTotalFiles($totalFiles)
    {
        $this->totalFiles = $totalFiles;

        return $this;
    }

    /**
     * Get totalFiles
     *
     * @return integer 
     */
    public function getTotalFiles()
    {
        return $this->totalFiles;
    }

    /**
     * Set totalItems
     *
     * @param integer $totalItems
     * @return DocumentDirectory
     */
    public function setTotalItems($totalItems)
    {
        $this->totalItems = $totalItems;

        return $this;
    }

    /**
     * Get totalItems
     *
     * @return integer 
     */
    public function getTotalItems()
    {
        return $this->totalItems;
    }

    /**
     * Set lastModified
     *
     * @param \DateTime $lastModified
     * @return DocumentDirectory
     */
    public function setLastModified($lastModified)
    {
        $this->lastModified = $lastModified;

        return $this;
    }

    /**
     * Get lastModified
     *
     * @return \DateTime 
     */
    public function getLastModified()
    {
        return $this->lastModified;
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
