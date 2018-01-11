<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trash
 */
class Trash
{
    /**
     * @var string
     */
    private $trashId;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $documentId;

    /**
     * @var string
     */
    private $type;

    /**
     * @var \DateTime
     */
    private $deletedTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set trashId
     *
     * @param string $trashId
     * @return Trash
     */
    public function setTrashId($trashId)
    {
        $this->trashId = $trashId;

        return $this;
    }

    /**
     * Get trashId
     *
     * @return string 
     */
    public function getTrashId()
    {
        return $this->trashId;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return Trash
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
     * Set documentId
     *
     * @param string $documentId
     * @return Trash
     */
    public function setDocumentId($documentId)
    {
        $this->documentId = $documentId;

        return $this;
    }

    /**
     * Get documentId
     *
     * @return string 
     */
    public function getDocumentId()
    {
        return $this->documentId;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Trash
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
     * Set deletedTime
     *
     * @param \DateTime $deletedTime
     * @return Trash
     */
    public function setDeletedTime($deletedTime)
    {
        $this->deletedTime = $deletedTime;

        return $this;
    }

    /**
     * Get deletedTime
     *
     * @return \DateTime 
     */
    public function getDeletedTime()
    {
        return $this->deletedTime;
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
