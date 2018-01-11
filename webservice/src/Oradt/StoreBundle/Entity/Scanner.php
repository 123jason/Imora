<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Scanner
 */
class Scanner
{
    /**
     * @var string
     */
    private $scannerid;

    /**
     * @var string
     */
    private $mac;

    /**
     * @var string
     */
    private $passwd;

    /**
     * @var string
     */
    private $model;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var integer
     */
    private $createtime;

    /**
     * @var integer
     */
    private $recordid;

    /**
     * @var string
     */
    private $adminid;

    /**
     * @var string
     */
    private $realname;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $type;

    /**
     * Set scannerid
     *
     * @param string $scannerid
     * @return Scanner
     */
    public function setScannerid($scannerid)
    {
        $this->scannerid = $scannerid;
    
        return $this;
    }

    /**
     * Get scannerid
     *
     * @return string 
     */
    public function getScannerid()
    {
        return $this->scannerid;
    }

    /**
     * Set mac
     *
     * @param string $mac
     * @return Scanner
     */
    public function setMac($mac)
    {
        $this->mac = $mac;
    
        return $this;
    }

    /**
     * Get mac
     *
     * @return string 
     */
    public function getMac()
    {
        return $this->mac;
    }

    /**
     * Set passwd
     *
     * @param string $passwd
     * @return Scanner
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
     * Set model
     *
     * @param string $model
     * @return Scanner
     */
    public function setModel($model)
    {
        $this->model = $model;
    
        return $this;
    }

    /**
     * Get model
     *
     * @return string 
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Scanner
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set createtime
     *
     * @param integer $createtime
     * @return Scanner
     */
    public function setCreatetime($createtime)
    {
        $this->createtime = $createtime;
    
        return $this;
    }

    /**
     * Get createtime
     *
     * @return integer 
     */
    public function getCreatetime()
    {
        return $this->createtime;
    }

    /**
     * Set recordid
     *
     * @param integer $recordid
     * @return Scanner
     */
    public function setRecordid($recordid)
    {
        $this->recordid = $recordid;
    
        return $this;
    }

    /**
     * Get recordid
     *
     * @return integer 
     */
    public function getRecordid()
    {
        return $this->recordid;
    }

    /**
     * Set adminid
     *
     * @param string $adminid
     * @return Scanner
     */
    public function setAdminid($adminid)
    {
        $this->adminid = $adminid;
    
        return $this;
    }

    /**
     * Get adminid
     *
     * @return string 
     */
    public function getAdminid()
    {
        return $this->adminid;
    }

    /**
     * Set realname
     *
     * @param string $realname
     * @return Scanner
     */
    public function setRealname($realname)
    {
        $this->realname = $realname;
    
        return $this;
    }

    /**
     * Get realname
     *
     * @return string 
     */
    public function getRealname()
    {
        return $this->realname;
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
     * Set type
     *
     * @param int $type
     * @return Scanner
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return int 
     */
    public function getType()
    {
        return $this->type;
    }

}
