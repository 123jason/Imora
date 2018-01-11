<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountBizAuthorizationRole
 */
class AccountBizAuthorizationRole
{
    /**
     * @var string
     */
    private $bizId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $permission;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $rid;

    /**
     * Set bizId
     *
     * @param string $bizId
     * @return AccountBizAuthorizationRole
     */
    public function setBizId($bizId)
    {
        $this->bizId = $bizId;

        return $this;
    }

    /**
     * Get bizId
     *
     * @return string 
     */
    public function getBizId()
    {
        return $this->bizId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return AccountBizAuthorizationRole
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set permission
     *
     * @param string $permission
     * @return AccountBizAuthorizationRole
     */
    public function setPermission($permission)
    {
        $this->permission = $permission;

        return $this;
    }

    /**
     * Get permission
     *
     * @return string 
     */
    public function getPermission()
    {
        return $this->permission;
    }

    /**
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return AccountBizAuthorizationRole
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
    /**
     * @var string
     */
    private $remark;


    /**
     * Set remark
     *
     * @param string $remark
     * @return AccountBizAuthorizationRole
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
     * Set rid
     *
     * @param string $rid
     * @return AccountBizAuthorizationRole
     */
    public function setRid($rid)
    {
        $this->rid = $rid;

        return $this;
    }

    /**
     * Get rid
     *
     * @return string 
     */
    public function getRid()
    {
        return $this->rid;
    }
}
