<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountBasicProjectExperience
 */
class AccountBasicProjectExperience
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $projectName;

    /**
     * @var string
     */
    private $projectContent;

    /**
     * @var integer
     */
    private $startTime;

    /**
     * @var integer
     */
    private $endTime;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $type;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return AccountBasicProjectExperience
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
     * Set projectName
     *
     * @param string $projectName
     * @return AccountBasicProjectExperience
     */
    public function setProjectName($projectName)
    {
        $this->projectName = $projectName;
    
        return $this;
    }

    /**
     * Get projectName
     *
     * @return string 
     */
    public function getProjectName()
    {
        return $this->projectName;
    }

    /**
     * Set projectContent
     *
     * @param string $projectContent
     * @return AccountBasicProjectExperience
     */
    public function setProjectContent($projectContent)
    {
        $this->projectContent = $projectContent;
    
        return $this;
    }

    /**
     * Get projectContent
     *
     * @return string 
     */
    public function getProjectContent()
    {
        return $this->projectContent;
    }

    /**
     * Set startTime
     *
     * @param integer $startTime
     * @return AccountBasicProjectExperience
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
    
        return $this;
    }

    /**
     * Get startTime
     *
     * @return integer 
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set endTime
     *
     * @param integer $endTime
     * @return AccountBasicProjectExperience
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
    
        return $this;
    }

    /**
     * Get endTime
     *
     * @return integer 
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return AccountBasicProjectExperience
     */
    public function setCreatedTime($createdTime)
    {
        $this->createdTime = $createdTime;
    
        return $this;
    }

    /**
     * Get createdTime
     *
     * @return integer 
     */
    public function getCreatedTime()
    {
        return $this->createdTime;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return AccountBasicProjectExperience
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
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
