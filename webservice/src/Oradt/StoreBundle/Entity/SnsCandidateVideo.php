<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SnsCandidateVideo
 */
class SnsCandidateVideo
{
    /**
     * @var string
     */
    private $videoId;
    
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $thumb;

    /**
     * @var integer
     */
    private $createTime;

    /**
     * @var integer
     */
    private $modifyTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set videoId
     *
     * @param string $videoId
     * @return SnsCandidateVideo
     */
    public function setVideoId($videoId)
    {
        $this->videoId = $videoId;

        return $this;
    }

    /**
     * Get videoId
     *
     * @return string 
     */
    public function getVideoId()
    {
        return $this->videoId;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return SnsCandidateVideo
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
     * Set path
     *
     * @param string $path
     * @return SnsCandidateVideo
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
     * Set thumb
     *
     * @param string $thumb
     * @return SnsCandidateVideo
     */
    public function setThumb($thumb)
    {
        $this->thumb = $thumb;

        return $this;
    }

    /**
     * Get thumb
     *
     * @return string 
     */
    public function getThumb()
    {
        return $this->thumb;
    }

    /**
     * Set createTime
     *
     * @param integer $createTime
     * @return SnsCandidateVideo
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
     * Set modifyTime
     *
     * @param integer $modifyTime
     * @return SnsCandidateVideo
     */
    public function setModifyTime($modifyTime)
    {
        $this->modifyTime = $modifyTime;

        return $this;
    }

    /**
     * Get modifyTime
     *
     * @return integer 
     */
    public function getModifyTime()
    {
        return $this->modifyTime;
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
