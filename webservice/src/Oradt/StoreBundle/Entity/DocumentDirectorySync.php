<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DocumentDirectorySync
 */
class DocumentDirectorySync
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $directoryId;

    /**
     * @var \DateTime
     */
    private $lastModified;

    /**
     * @var string
     */
    private $operation;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return DocumentDirectorySync
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
     * Set directoryId
     *
     * @param string $directoryId
     * @return DocumentDirectorySync
     */
    public function setDirectoryId($directoryId)
    {
        $this->directoryId = $directoryId;

        return $this;
    }

    /**
     * Get directoryId
     *
     * @return string 
     */
    public function getDirectoryId()
    {
        return $this->directoryId;
    }

    /**
     * Set lastModified
     *
     * @param \DateTime $lastModified
     * @return DocumentDirectorySync
     */
    public function setLastModified($lastModified)
    {
        $this->lastModified = $lastModified;

        return $this;
    }

    /**
     * Get lastModified
     *
     * @return \DateTime 
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     * Set operation
     *
     * @param string $operation
     * @return DocumentDirectorySync
     */
    public function setOperation($operation)
    {
        $this->operation = $operation;

        return $this;
    }

    /**
     * Get operation
     *
     * @return string 
     */
    public function getOperation()
    {
        return $this->operation;
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
