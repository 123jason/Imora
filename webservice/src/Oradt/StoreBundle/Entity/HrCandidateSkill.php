<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HrCandidateSkill
 */
class HrCandidateSkill
{
    /**
     * @var string
     */
    private $candidateId;

    /**
     * @var string
     */
    private $skillId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $level;

    /**
     * @var string
     */
    private $state;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $levelValue;


    /**
     * Set candidateId
     *
     * @param string $candidateId
     * @return HrCandidateSkill
     */
    public function setCandidateId($candidateId)
    {
        $this->candidateId = $candidateId;
    
        return $this;
    }

    /**
     * Get candidateId
     *
     * @return string 
     */
    public function getCandidateId()
    {
        return $this->candidateId;
    }

    /**
     * Set skillId
     *
     * @param string $skillId
     * @return HrCandidateSkill
     */
    public function setSkillId($skillId)
    {
        $this->skillId = $skillId;
    
        return $this;
    }

    /**
     * Get skillId
     *
     * @return string 
     */
    public function getSkillId()
    {
        return $this->skillId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return HrCandidateSkill
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
     * Set level
     *
     * @param integer $level
     * @return HrCandidateSkill
     */
    public function setLevel($level)
    {
        $this->level = $level;
    
        return $this;
    }

    /**
     * Get level
     *
     * @return integer 
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return HrCandidateSkill
     */
    public function setState($state)
    {
        $this->state = $state;
    
        return $this;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
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
     * @var integer
     */
    private $createTime;


    /**
     * Set createTime
     *
     * @param integer $createTime
     * @return HrCandidateSkill
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
     * @var string
     */
    private $userId;


    /**
     * Set userId
     *
     * @param string $userId
     * @return HrCandidateSkill
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
     * Set levelValue
     *
     * @param integer $levelValue
     * @return HrCandidateLanguage
     */
    public function setLevelValue($levelValue)
    {
        $this->levelValue = $levelValue;
    
        return $this;
    }

    /**
     * Get levelValue
     *
     * @return integer 
     */
    public function getLevelValue()
    {
        return $this->levelValue;
    }
    
    
}
