<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountEmployeeLoginRecord
 */
class AccountEmployeeLoginRecord
{
    /**
     * @var string
     */
    private $emplId;

    /**
     * @var \DateTime
     */
    private $lastLoginTime;

    /**
     * @var string
     */
    private $lastLoginIp;

    /**
     * @var \DateTime
     */
    private $loginTime;

    /**
     * @var string
     */
    private $loginIp;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set emplId
     *
     * @param string $emplId
     * @return AccountEmployeeLoginRecord
     */
    public function setEmplId($emplId)
    {
        $this->emplId = $emplId;

        return $this;
    }

    /**
     * Get emplId
     *
     * @return string 
     */
    public function getEmplId()
    {
        return $this->emplId;
    }

    /**
     * Set lastLoginTime
     *
     * @param \DateTime $lastLoginTime
     * @return AccountEmployeeLoginRecord
     */
    public function setLastLoginTime($lastLoginTime)
    {
        $this->lastLoginTime = $lastLoginTime;

        return $this;
    }

    /**
     * Get lastLoginTime
     *
     * @return \DateTime 
     */
    public function getLastLoginTime()
    {
        return $this->lastLoginTime;
    }

    /**
     * Set lastLoginIp
     *
     * @param string $lastLoginIp
     * @return AccountEmployeeLoginRecord
     */
    public function setLastLoginIp($lastLoginIp)
    {
        $this->lastLoginIp = $lastLoginIp;

        return $this;
    }

    /**
     * Get lastLoginIp
     *
     * @return string 
     */
    public function getLastLoginIp()
    {
        return $this->lastLoginIp;
    }

    /**
     * Set loginTime
     *
     * @param \DateTime $loginTime
     * @return AccountEmployeeLoginRecord
     */
    public function setLoginTime($loginTime)
    {
        $this->loginTime = $loginTime;

        return $this;
    }

    /**
     * Get loginTime
     *
     * @return \DateTime 
     */
    public function getLoginTime()
    {
        return $this->loginTime;
    }

    /**
     * Set loginIp
     *
     * @param string $loginIp
     * @return AccountEmployeeLoginRecord
     */
    public function setLoginIp($loginIp)
    {
        $this->loginIp = $loginIp;

        return $this;
    }

    /**
     * Get loginIp
     *
     * @return string 
     */
    public function getLoginIp()
    {
        return $this->loginIp;
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
