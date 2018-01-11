<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AuthorityPermission
 */
class AuthorityPermission
{
    /**
     * @var integer
     */
    private $actionId;

    /**
     * @var integer
     */
    private $roleId;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set actionId
     *
     * @param integer $actionId
     * @return AuthorityPermission
     */
    public function setActionId($actionId)
    {
        $this->actionId = $actionId;

        return $this;
    }

    /**
     * Get actionId
     *
     * @return integer 
     */
    public function getActionId()
    {
        return $this->actionId;
    }

    /**
     * Set roleId
     *
     * @param integer $roleId
     * @return AuthorityPermission
     */
    public function setRoleId($roleId)
    {
        $this->roleId = $roleId;

        return $this;
    }

    /**
     * Get roleId
     *
     * @return integer 
     */
    public function getRoleId()
    {
        return $this->roleId;
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
