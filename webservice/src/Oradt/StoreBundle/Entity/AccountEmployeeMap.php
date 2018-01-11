<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountEmployeeMap
 */
class AccountEmployeeMap
{
    /**
     * @var string
     */
    private $empid;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $passwd;

    /**
     * @var string
     */
    private $status;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set empid
     *
     * @param string $empid
     * @return AccountEmployeeMap
     */
    public function setEmpid($empid)
    {
        $this->empid = $empid;
    
        return $this;
    }

    /**
     * Get empid
     *
     * @return string 
     */
    public function getEmpid()
    {
        return $this->empid;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return AccountEmployeeMap
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set passwd
     *
     * @param string $passwd
     * @return AccountEmployeeMap
     */
    public function setPasswd($passwd)
    {
        $this->passwd = $passwd;
    
        return $this;
    }

    /**
     * Get passwd
     *
     * @return string 
     */
    public function getPasswd()
    {
        return $this->passwd;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return AccountEmployeeMap
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
