<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HrCandidatePublishment
 */
class HrCandidatePublishment
{
    /**
     * @var string
     */
    private $publishmentId;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $press;

    /**
     * @var string
     */
    private $publishDate;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $author;

    /**
     * @var string
     */
    private $intro;

    /**
     * @var string
     */
    private $status;

    /**
     * @var integer
     */
    private $createTime;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Oradt\StoreBundle\Entity\HrCandidate
     */
    private $candidateId;


    /**
     * Set publishmentId
     *
     * @param string $publishmentId
     * @return HrCandidatePublishment
     */
    public function setPublishmentId($publishmentId)
    {
        $this->publishmentId = $publishmentId;
    
        return $this;
    }

    /**
     * Get publishmentId
     *
     * @return string 
     */
    public function getPublishmentId()
    {
        return $this->publishmentId;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return HrCandidatePublishment
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
     * Set name
     *
     * @param string $name
     * @return HrCandidatePublishment
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set press
     *
     * @param string $press
     * @return HrCandidatePublishment
     */
    public function setPress($press)
    {
        $this->press = $press;
    
        return $this;
    }

    /**
     * Get press
     *
     * @return string 
     */
    public function getPress()
    {
        return $this->press;
    }

    /**
     * Set publishDate
     *
     * @param string $publishDate
     * @return HrCandidatePublishment
     */
    public function setPublishDate($publishDate)
    {
        $this->publishDate = $publishDate;
    
        return $this;
    }

    /**
     * Get publishDate
     *
     * @return string 
     */
    public function getPublishDate()
    {
        return $this->publishDate;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return HrCandidatePublishment
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set author
     *
     * @param string $author
     * @return HrCandidatePublishment
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    
        return $this;
    }

    /**
     * Get author
     *
     * @return string 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set intro
     *
     * @param string $intro
     * @return HrCandidatePublishment
     */
    public function setIntro($intro)
    {
        $this->intro = $intro;
    
        return $this;
    }

    /**
     * Get intro
     *
     * @return string 
     */
    public function getIntro()
    {
        return $this->intro;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return HrCandidatePublishment
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
     * Set createTime
     *
     * @param integer $createTime
     * @return HrCandidatePublishment
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

    /**
     * Set candidate
     *
     * @param \Oradt\StoreBundle\Entity\HrCandidate $candidate
     * @return HrCandidatePublishment
     */
    public function setCandidateID($candidateId)
    {
        $this->candidateId = $candidateId;
    
        return $this;
    }

    /**
     * Get candidate
     *
     * @return \Oradt\StoreBundle\Entity\HrCandidate 
     */
    public function getCandidateId()
    {
        return $this->candidateId;
    }
}
