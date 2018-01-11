<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Upload
 */
class Upload
{
    /**
     * @var string
     */
    private $uploadId;

    /**
     * @var \DateTime
     */
    private $uploadTime;

    /**
     * @var string
     */
    private $path;

    /**
     * @var boolean
     */
    private $type;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set uploadId
     *
     * @param string $uploadId
     * @return Upload
     */
    public function setUploadId($uploadId)
    {
        $this->uploadId = $uploadId;
    
        return $this;
    }

    /**
     * Get uploadId
     *
     * @return string 
     */
    public function getUploadId()
    {
        return $this->uploadId;
    }

    /**
     * Set uploadTime
     *
     * @param \DateTime $uploadTime
     * @return Upload
     */
    public function setUploadTime($uploadTime)
    {
        $this->uploadTime = $uploadTime;
    
        return $this;
    }

    /**
     * Get uploadTime
     *
     * @return \DateTime 
     */
    public function getUploadTime()
    {
        return $this->uploadTime;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Upload
     */
    public function setPath($path)
    {
        $this->path = $path;
    
        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set type
     *
     * @param boolean $type
     * @return Upload
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return boolean 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return Upload
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @var string
     */
    private $thumPath;


    /**
     * Set thumPath
     *
     * @param string $thumPath
     * @return Upload
     */
    public function setThumPath($thumPath)
    {
        $this->thumPath = $thumPath;
    
        return $this;
    }

    /**
     * Get thumPath
     *
     * @return string 
     */
    public function getThumPath()
    {
        return $this->thumPath;
    }
}
