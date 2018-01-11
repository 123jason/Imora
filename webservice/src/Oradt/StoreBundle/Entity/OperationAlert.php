<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OperationAlert
 */
class OperationAlert
{
    /**
     * @var string
     */
    private $alertId;

    /**
     * @var integer
     */
    private $type;

    /**
     * @var integer
     */
    private $isnotify;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $content;

    /**
     * @var integer
     */
    private $alertDate;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $modifyTime;

    /**
     * @var integer
     */
    private $isDelete;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set alertId
     *
     * @param string $alertId
     * @return OperationAlert
     */
    public function setAlertId($alertId)
    {
        $this->alertId = $alertId;
    
        return $this;
    }

    /**
     * Get alertId
     *
     * @return string 
     */
    public function getAlertId()
    {
        return $this->alertId;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return OperationAlert
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
     * Set isnotify
     *
     * @param integer $isnotify
     * @return OperationAlert
     */
    public function setIsnotify($isnotify)
    {
        $this->isnotify = $isnotify;
    
        return $this;
    }

    /**
     * Get isnotify
     *
     * @return integer 
     */
    public function getIsnotify()
    {
        return $this->isnotify;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return OperationAlert
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
     * Set content
     *
     * @param string $content
     * @return OperationAlert
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
     * Set alertDate
     *
     * @param integer $alertDate
     * @return OperationAlert
     */
    public function setAlertDate($alertDate)
    {
        $this->alertDate = $alertDate;
    
        return $this;
    }

    /**
     * Get alertDate
     *
     * @return integer 
     */
    public function getAlertDate()
    {
        return $this->alertDate;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return OperationAlert
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
     * Set createdTime
     *
     * @param integer $createdTime
     * @return OperationAlert
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
     * Set modifyTime
     *
     * @param integer $modifyTime
     * @return OperationAlert
     */
    public function setModifyTime($modifyTime)
    {
        $this->modifyTime = $modifyTime;
    
        return $this;
    }

    /**
     * Get modifyTime
     *
     * @return integer 
     */
    public function getModifyTime()
    {
        return $this->modifyTime;
    }

    /**
     * Set isDelete
     *
     * @param integer $isDelete
     * @return OperationAlert
     */
    public function setIsDelete($isDelete)
    {
        $this->isDelete = $isDelete;
    
        return $this;
    }

    /**
     * Get isDelete
     *
     * @return integer 
     */
    public function getIsDelete()
    {
        return $this->isDelete;
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
