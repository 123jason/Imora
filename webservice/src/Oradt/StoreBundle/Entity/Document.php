<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Document
 */
class Document
{
    /**
     * @var string
     */
    private $fileId;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $fileName;

    /**
     * @var string
     */
    private $filePath;

    /**
     * @var integer
     */
    private $fileSize;

    /**
     * @var string
     */
    private $etag;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $fileType;

    /**
     * @var \DateTime
     */
    private $lastModified;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var string
     */
    private $directoryId;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set fileId
     *
     * @param string $fileId
     * @return Document
     */
    public function setFileId($fileId)
    {
        $this->fileId = $fileId;

        return $this;
    }

    /**
     * Get fileId
     *
     * @return string 
     */
    public function getFileId()
    {
        return $this->fileId;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return Document
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
     * Set fileName
     *
     * @param string $fileName
     * @return Document
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string 
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set filePath
     *
     * @param string $filePath
     * @return Document
     */
    public function setFilePath($filePath)
    {
        $this->filePath = $filePath;

        return $this;
    }

    /**
     * Get filePath
     *
     * @return string 
     */
    public function getFilePath()
    {
        return $this->filePath;
    }

    /**
     * Set fileSize
     *
     * @param integer $fileSize
     * @return Document
     */
    public function setFileSize($fileSize)
    {
        $this->fileSize = $fileSize;

        return $this;
    }

    /**
     * Get fileSize
     *
     * @return integer 
     */
    public function getFileSize()
    {
        return $this->fileSize;
    }

    /**
     * Set etag
     *
     * @param string $etag
     * @return Document
     */
    public function setEtag($etag)
    {
        $this->etag = $etag;

        return $this;
    }

    /**
     * Get etag
     *
     * @return string 
     */
    public function getEtag()
    {
        return $this->etag;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Document
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
     * Set fileType
     *
     * @param string $fileType
     * @return Document
     */
    public function setFileType($fileType)
    {
        $this->fileType = $fileType;

        return $this;
    }

    /**
     * Get fileType
     *
     * @return string 
     */
    public function getFileType()
    {
        return $this->fileType;
    }

    /**
     * Set lastModified
     *
     * @param \DateTime $lastModified
     * @return Document
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
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return Document
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
     * Set directoryId
     *
     * @param string $directoryId
     * @return Document
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
