<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contact
 */
class Contact
{
    /**
     * @var string
     */
    private $contactId;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $contactName;

    /**
     * @var string
     */
    private $groupId;

    /**
     * @var string
     */
    private $remark;

    /**
     * @var string
     */
    private $status;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var string
     */
    private $fromUid;

    /**
     * @var string
     */
    private $introducation;

    /**
     * @var string
     */
    private $namePre;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set contactId
     *
     * @param string $contactId
     * @return Contact
     */
    public function setContactId($contactId)
    {
        $this->contactId = $contactId;

        return $this;
    }

    /**
     * Get contactId
     *
     * @return string 
     */
    public function getContactId()
    {
        return $this->contactId;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return Contact
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
     * Set contactName
     *
     * @param string $contactName
     * @return Contact
     */
    public function setContactName($contactName)
    {
        $this->contactName = $contactName;

        return $this;
    }

    /**
     * Get contactName
     *
     * @return string 
     */
    public function getContactName()
    {
        return $this->contactName;
    }

    /**
     * Set groupId
     *
     * @param string $groupId
     * @return Contact
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
     * Set remark
     *
     * @param string $remark
     * @return Contact
     */
    public function setRemark($remark)
    {
        $this->remark = $remark;

        return $this;
    }

    /**
     * Get remark
     *
     * @return string 
     */
    public function getRemark()
    {
        return $this->remark;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Contact
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return Contact
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
     * Set fromUid
     *
     * @param string $fromUid
     * @return Contact
     */
    public function setFromUid($fromUid)
    {
        $this->fromUid = $fromUid;

        return $this;
    }

    /**
     * Get fromUid
     *
     * @return string 
     */
    public function getFromUid()
    {
        return $this->fromUid;
    }

    /**
     * Set introducation
     *
     * @param string $introducation
     * @return Contact
     */
    public function setIntroducation($introducation)
    {
        $this->introducation = $introducation;

        return $this;
    }

    /**
     * Get introducation
     *
     * @return string 
     */
    public function getIntroducation()
    {
        return $this->introducation;
    }

    /**
     * Set namePre
     *
     * @param string $namePre
     * @return Contact
     */
    public function setNamePre($namePre)
    {
        $this->namePre = $namePre;

        return $this;
    }

    /**
     * Get namePre
     *
     * @return string 
     */
    public function getNamePre()
    {
        return $this->namePre;
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
