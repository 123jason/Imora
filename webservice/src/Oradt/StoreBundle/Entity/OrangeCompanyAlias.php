<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrangeCompanyAlias
 */
class OrangeCompanyAlias
{
    /**
     * @var string
     */
    private $companyName;

    /**
     * @var string
     */
    private $companyAlias;

    /**
     * @var string
     */
    private $keywordsCn;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var integer
     */
    private $modifyTime;

    /**
     * @var integer
     */
    private $commitTime;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set companyName
     *
     * @param string $companyName
     * @return OrangeCompanyAlias
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;
    
        return $this;
    }

    /**
     * Get companyName
     *
     * @return string 
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * Set companyAlias
     *
     * @param string $companyAlias
     * @return OrangeCompanyAlias
     */
    public function setCompanyAlias($companyAlias)
    {
        $this->companyAlias = $companyAlias;
    
        return $this;
    }

    /**
     * Get companyAlias
     *
     * @return string 
     */
    public function getCompanyAlias()
    {
        return $this->companyAlias;
    }

    /**
     * Set keywordsCn
     *
     * @param string $keywordsCn
     * @return OrangeCompanyAlias
     */
    public function setKeywordsCn($keywordsCn)
    {
        $this->keywordsCn = $keywordsCn;
    
        return $this;
    }

    /**
     * Get keywordsCn
     *
     * @return string 
     */
    public function getKeywordsCn()
    {
        return $this->keywordsCn;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return OrangeCompanyAlias
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
     * Set modifyTime
     *
     * @param integer $modifyTime
     * @return OrangeCompanyAlias
     */
    public function setModifyTime($modifyTime)
    {
        $this->modifyTime = $modifyTime;
    
        return $this;
    }

    /**
     * Get modifyTime
     *
     * @return integer 
     */
    public function getModifyTime()
    {
        return $this->modifyTime;
    }

    /**
     * Set commitTime
     *
     * @param integer $commitTime
     * @return OrangeCompanyAlias
     */
    public function setCommitTime($commitTime)
    {
        $this->commitTime = $commitTime;
    
        return $this;
    }

    /**
     * Get commitTime
     *
     * @return integer 
     */
    public function getCommitTime()
    {
        return $this->commitTime;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return OrangeCompanyAlias
     */
    public function setCreatedTime($createdTime)
    {
        $this->createdTime = $createdTime;
    
        return $this;
    }

    /**
     * Get createdTime
     *
     * @return integer 
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
}
