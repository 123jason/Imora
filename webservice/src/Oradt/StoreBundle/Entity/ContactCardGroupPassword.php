<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContactCardGroupPassword
 */
class ContactCardGroupPassword
{
    /**
     * @var string
     */
    private $password;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $groupId;


    /**
     * Set password
     *
     * @param string $password
     * @return ContactCardGroupPassword
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
     * Set id
     *
     * @param integer $id
     * @return ContactCardGroupPassword
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * Set groupId
     *
     * @param string $groupId
     * @return ContactCardGroupPassword
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
}
