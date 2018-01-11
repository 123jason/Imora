<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContactGroupPassword
 */
class ContactGroupPassword
{
    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $groupId;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set password
     *
     * @param string $password
     * @return ContactGroupPassword
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set groupId
     *
     * @param string $groupId
     * @return ContactGroupPassword
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
