<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HrCandidateSetting
 */
class HrCandidateSetting
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $candidateId;

    /**
     * @var string
     */
    private $settingId;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $userId;


    /**
     * Set userId
     *
     * @param string $userId
     * @return HrCandidateSetting
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
     * Set type
     *
     * @param string $type
     * @return HrCandidateSetting
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return HrCandidateSetting
     */
    public function setContent($content)
    {
        $this->content = $content;
    
        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set candidateId
     *
     * @param string $candidateId
     * @return HrCandidateSetting
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

    //$settingId
    /**
     * Set settingId
     *
     * @param string $settingId
     * @return HrCandidateSetting
     */
    public function setSettingId($settingId)
    {
        $this->settingId = $settingId;

        return $this;
    }

    /**
     * Get settingId
     *
     * @return string
     */
    public function getSettingId()
    {
        return $this->settingId;
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
