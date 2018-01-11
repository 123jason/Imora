<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Feedback
 */
class Feedback
{
    /**
     * @var string
     */
    private $feedid;

    /**
     * @var string
     */
    private $module;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $accountId;

    /**
     * @var \DateTime
     */
    private $dateTime;

    /**
     * @var string
     */
    private $type;

    /**
     * @var integer
     */
    private $id;

    /**
     * Set type
     *
     * @param string $type
     * @return EmailMessage
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
     * Set feedid
     *
     * @param string $feedid
     * @return Feedback
     */
    public function setFeedid($feedid)
    {
        $this->feedid = $feedid;
    
        return $this;
    }

    /**
     * Get feedid
     *
     * @return string 
     */
    public function getFeedid()
    {
        return $this->feedid;
    }

    /**
     * Set module
     *
     * @param string $module
     * @return Feedback
     */
    public function setModule($module)
    {
        $this->module = $module;
    
        return $this;
    }

    /**
     * Get module
     *
     * @return string 
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Feedback
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
     * Set accountId
     *
     * @param string $accountId
     * @return Feedback
     */
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;
    
        return $this;
    }

    /**
     * Get accountId
     *
     * @return string 
     */
    public function getAccountId()
    {
        return $this->accountId;
    }

    /**
     * Set dateTime
     *
     * @param \DateTime $dateTime
     * @return Feedback
     */
    public function setDateTime($dateTime)
    {
        $this->dateTime = $dateTime;
    
        return $this;
    }

    /**
     * Get dateTime
     *
     * @return \DateTime 
     */
    public function getDateTime()
    {
        return $this->dateTime;
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
