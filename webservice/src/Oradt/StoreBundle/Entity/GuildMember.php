<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GuildMember
 */
class GuildMember
{
    /**
     * @var string
     */
    private $guildId;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var \DateTime
     */
    private $jionedTime;

    /**
     * @var \DateTime
     */
    private $exitTime;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $remark;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set guildId
     *
     * @param string $guildId
     * @return GuildMember
     */
    public function setGuildId($guildId)
    {
        $this->guildId = $guildId;
    
        return $this;
    }

    /**
     * Get guildId
     *
     * @return string 
     */
    public function getGuildId()
    {
        return $this->guildId;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return GuildMember
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
     * Set jionedTime
     *
     * @param \DateTime $jionedTime
     * @return GuildMember
     */
    public function setJionedTime($jionedTime)
    {
        $this->jionedTime = $jionedTime;
    
        return $this;
    }

    /**
     * Get jionedTime
     *
     * @return \DateTime 
     */
    public function getJionedTime()
    {
        return $this->jionedTime;
    }

    /**
     * Set exitTime
     *
     * @param \DateTime $exitTime
     * @return GuildMember
     */
    public function setExitTime($exitTime)
    {
        $this->exitTime = $exitTime;
    
        return $this;
    }

    /**
     * Get exitTime
     *
     * @return \DateTime 
     */
    public function getExitTime()
    {
        return $this->exitTime;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return GuildMember
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
     * Set name
     *
     * @param string $name
     * @return GuildMember
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
     * Set remark
     *
     * @param string $remark
     * @return GuildMember
     */
    public function setRemark($remark)
    {
        $this->remark = $remark;
    
        return $this;
    }

    /**
     * Get remark
     *
     * @return string 
     */
    public function getRemark()
    {
        return $this->remark;
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
