<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmailMessage
 */
class EmailMessage
{
    /**
     * @var string
     */
    private $messageId;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $content;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var string
     */
    private $module;

    /**
     * @var string
     */
    private $forwardUrl;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set messageId
     *
     * @param string $messageId
     * @return EmailMessage
     */
    public function setMessageId($messageId)
    {
        $this->messageId = $messageId;

        return $this;
    }

    /**
     * Get messageId
     *
     * @return string 
     */
    public function getMessageId()
    {
        return $this->messageId;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return EmailMessage
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

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
     * Set content
     *
     * @param string $content
     * @return EmailMessage
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
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return EmailMessage
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
     * Set module
     *
     * @param string $module
     * @return EmailMessage
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
     * Set forwardUrl
     *
     * @param string $forwardUrl
     * @return EmailMessage
     */
    public function setForwardUrl($forwardUrl)
    {
        $this->forwardUrl = $forwardUrl;

        return $this;
    }

    /**
     * Get forwardUrl
     *
     * @return string 
     */
    public function getForwardUrl()
    {
        return $this->forwardUrl;
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
