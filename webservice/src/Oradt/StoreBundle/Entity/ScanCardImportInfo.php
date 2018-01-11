<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ScanCardImportInfo
 */
class ScanCardImportInfo
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $fromAccount;

    /**
     * @var string
     */
    private $zippath;

    /**
     * @var integer
     */
    private $total;

    /**
     * @var integer
     */
    private $total1;

    /**
     * @var \DateTime
     */
    private $createdTime;


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
     * Set fromAccount
     *
     * @param string $fromAccount
     * @return ScanCardImportInfo
     */
    public function setFromAccount($fromAccount)
    {
        $this->fromAccount = $fromAccount;

        return $this;
    }

    /**
     * Get fromAccount
     *
     * @return string 
     */
    public function getFromAccount()
    {
        return $this->fromAccount;
    }

    /**
     * Set zippath
     *
     * @param string $zippath
     * @return ScanCardImportInfo
     */
    public function setZippath($zippath)
    {
        $this->zippath = $zippath;

        return $this;
    }

    /**
     * Get zippath
     *
     * @return string 
     */
    public function getZippath()
    {
        return $this->zippath;
    }

    /**
     * Set total
     *
     * @param integer $total
     * @return ScanCardImportInfo
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return integer 
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set total1
     *
     * @param integer $total1
     * @return ScanCardImportInfo
     */
    public function setTotal1($total1)
    {
        $this->total1 = $total1;

        return $this;
    }

    /**
     * Get total1
     *
     * @return integer 
     */
    public function getTotal1()
    {
        return $this->total1;
    }

    /**
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return ScanCardImportInfo
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
}
