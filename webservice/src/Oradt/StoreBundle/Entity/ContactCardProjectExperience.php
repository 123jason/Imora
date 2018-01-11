<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContactCardProjectExperience
 */
class ContactCardProjectExperience
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $vcardId;

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
    private $status;

    /**
     * @var string
     */
    private $company;

    /**
     * @var string
     */
    private $title;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return ContactCardProjectExperience
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
     * Set vcardId
     *
     * @param string $vcardId
     * @return ContactCardProjectExperience
     */
    public function setVcardId($vcardId)
    {
        $this->vcardId = $vcardId;
    
        return $this;
    }

    /**
     * Get vcardId
     *
     * @return string 
     */
    public function getVcardId()
    {
        return $this->vcardId;
    }

    /**
     * Set projectName
     *
     * @param string $projectName
     * @return ContactCardProjectExperience
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
     * @return ContactCardProjectExperience
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
     * @return ContactCardProjectExperience
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
     * @return ContactCardProjectExperience
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
     * @return ContactCardProjectExperience
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
     * @return ContactCardProjectExperience
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
     * Set status
     *
     * @param integer $status
     * @return ContactCardProjectExperience
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
     * Set company
     *
     * @param string $company
     * @return ContactCardProjectExperience
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return ContactCardProjectExperience
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
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
