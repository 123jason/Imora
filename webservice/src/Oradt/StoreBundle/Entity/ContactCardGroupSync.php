<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContactCardGroupSync
 */
class ContactCardGroupSync
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $groupId;

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
     * @return ContactCardGroupSync
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
     * Set groupId
     *
     * @param string $groupId
     * @return ContactCardGroupSync
     */
    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;

        return $this;
    }

    /**
     * Get groupId
     *
     * @return string 
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * Set lastModified
     *
     * @param \DateTime $lastModified
     * @return ContactCardGroupSync
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
     * @return ContactCardGroupSync
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
