<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountFriend
 */
class AccountFriend
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $fuserId;

    /**
     * @var string
     */
    private $fmobile;

    /**
     * @var string
     */
    private $fusername;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var integer
     */
    private $gid;

    /**
     * @var string
     */
    private $note;

    /**
     * @var integer
     */
    private $num;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var \DateTime
     */
    private $lastContactTime;

    /**
     * @var string
     */
    private $tags;

    /**
     * @var integer
     */
    private $imid;

    /**
     * @var integer
     */
    private $fuserSort;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return AccountFriend
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
     * Set fuserId
     *
     * @param string $fuserId
     * @return AccountFriend
     */
    public function setFuserId($fuserId)
    {
        $this->fuserId = $fuserId;
    
        return $this;
    }

    /**
     * Get fuserId
     *
     * @return string 
     */
    public function getFuserId()
    {
        return $this->fuserId;
    }

    /**
     * Set fmobile
     *
     * @param string $fmobile
     * @return AccountFriend
     */
    public function setFmobile($fmobile)
    {
        $this->fmobile = $fmobile;
    
        return $this;
    }

    /**
     * Get fmobile
     *
     * @return string 
     */
    public function getFmobile()
    {
        return $this->fmobile;
    }

    /**
     * Set fusername
     *
     * @param string $fusername
     * @return AccountFriend
     */
    public function setFusername($fusername)
    {
        $this->fusername = $fusername;
    
        return $this;
    }

    /**
     * Get fusername
     *
     * @return string 
     */
    public function getFusername()
    {
        return $this->fusername;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return AccountFriend
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set gid
     *
     * @param integer $gid
     * @return AccountFriend
     */
    public function setGid($gid)
    {
        $this->gid = $gid;
    
        return $this;
    }

    /**
     * Get gid
     *
     * @return integer 
     */
    public function getGid()
    {
        return $this->gid;
    }

    /**
     * Set note
     *
     * @param string $note
     * @return AccountFriend
     */
    public function setNote($note)
    {
        $this->note = $note;
    
        return $this;
    }

    /**
     * Get note
     *
     * @return string 
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set num
     *
     * @param integer $num
     * @return AccountFriend
     */
    public function setNum($num)
    {
        $this->num = $num;
    
        return $this;
    }

    /**
     * Get num
     *
     * @return integer 
     */
    public function getNum()
    {
        return $this->num;
    }

    /**
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return AccountFriend
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
     * Set lastContactTime
     *
     * @param \DateTime $lastContactTime
     * @return AccountFriend
     */
    public function setLastContactTime($lastContactTime)
    {
        $this->lastContactTime = $lastContactTime;
    
        return $this;
    }

    /**
     * Get lastContactTime
     *
     * @return \DateTime 
     */
    public function getLastContactTime()
    {
        return $this->lastContactTime;
    }

    /**
     * Set tags
     *
     * @param string $tags
     * @return AccountFriend
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    
        return $this;
    }

    /**
     * Get tags
     *
     * @return string 
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set imid
     *
     * @param integer $imid
     * @return AccountFriend
     */
    public function setImid($imid)
    {
        $this->imid = $imid;
    
        return $this;
    }

    /**
     * Get imid
     *
     * @return integer 
     */
    public function getImid()
    {
        return $this->imid;
    }

    /**
     * Set fuserSort
     *
     * @param integer $fuserSort
     * @return AccountFriend
     */
    public function setFuserSort($fuserSort)
    {
        $this->fuserSort = $fuserSort;
    
        return $this;
    }

    /**
     * Get fuserSort
     *
     * @return integer 
     */
    public function getFuserSort()
    {
        return $this->fuserSort;
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
