<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountFileRecord
 */
class AccountFileRecord
{
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
    private $recordId;

    /**
     * @var string
     */
    private $recordType;

    /**
     * @var string
     */
    private $uuid;

    /**
     * @var string
     */
    private $resPath;

    /**
     * @var string
     */
    private $resThumbPath;
    
    /**
     * @var string
     */
    private $resMd5;

    /**
     * @var string
     */
    private $fileType;
    
    /**
     * @var string
     */
    private $fileSize;
    /**
     * @var integer
     */
    private $createTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return AccountFileRecord
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
     * @return AccountFileRecord
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
     * Set recordId
     *
     * @param string $recordId
     * @return AccountFileRecord
     */
    public function setRecordId($recordId)
    {
        $this->recordId = $recordId;
    
        return $this;
    }

    /**
     * Get recordId
     *
     * @return string 
     */
    public function getRecordId()
    {
        return $this->recordId;
    }

    /**
     * Set recordType
     *
     * @param string $recordType
     * @return AccountFileRecord
     */
    public function setRecordType($recordType)
    {
        $this->recordType = $recordType;
    
        return $this;
    }

    /**
     * Get recordType
     *
     * @return string 
     */
    public function getRecordType()
    {
        return $this->recordType;
    }

    /**
     * Set uuid
     *
     * @param string $uuid
     * @return AccountFileRecord
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    
        return $this;
    }

    /**
     * Get uuid
     *
     * @return string 
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set resPath
     *
     * @param string $resPath
     * @return AccountFileRecord
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
     * Set resThumbPath
     *
     * @param string $resThumbPath
     * @return AccountFileRecord
     */
    public function setResThumbPath($resThumbPath)
    {
        $this->resThumbPath = $resThumbPath;
    
        return $this;
    }

    /**
     * Get resPath
     *
     * @return string 
     */
    public function getResThumbPath()
    {
        return $this->resThumbPath;
    }

    /**
     * Set resMd5
     *
     * @param string $resMd5
     * @return AccountFileRecord
     */
    public function setResMd5($resMd5)
    {
        $this->resMd5 = $resMd5;
    
        return $this;
    }

    /**
     * Get resMd5
     *
     * @return string 
     */
    public function getResMd5()
    {
        return $this->resMd5;
    }
    
    /**
     * Set filetype
     *
     * @param string $filetype
     * @return AccountFileRecord
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
     * Set fileSize
     *
     * @param string $fileSize
     * @return AccountFileRecord
     */
    public function setFileSize($fileSize)
    {
        $this->fileSize = $fileSize;
    
        return $this;
    }

    /**
     * Get fileSize
     *
     * @return string 
     */
    public function getFileSize()
    {
        return $this->fileSize;
    }

    /**
     * Set createTime
     *
     * @param integer $createTime
     * @return AccountFileRecord
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
