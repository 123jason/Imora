<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TopicTop
 */
class TopicTop
{
    /**
     * @var string
     */
    private $topicId;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set topicId
     *
     * @param string $topicId
     * @return TopicTop
     */
    public function setTopicId($topicId)
    {
        $this->topicId = $topicId;
    
        return $this;
    }

    /**
     * Get topicId
     *
     * @return string 
     */
    public function getTopicId()
    {
        return $this->topicId;
    }

    /**
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return TopicTop
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
