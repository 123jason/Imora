<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BizOperatorExtendInfo
 */
class BizOperatorExtendInfo
{
    /**
     * @var string
     */
    private $bizId;

    /**
     * @var string
     */
    private $idcardCopyPath;

    /**
     * @var string
     */
    private $authorityCopyPath;

    /**
     * @var string
     */
    private $licenseCopyPath;

    /**
     * @var string
     */
    private $codeCopyPath;

    /**
     * @var string
     */
    private $legalidcardCopyPath;

    /**
     * @var \DateTime
     */
    private $updateTime;

    /**
     * @var string
     */
    private $adminId;

    /**
     * @var string
     */
    private $status;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set bizId
     *
     * @param string $bizId
     * @return BizOperatorExtendInfo
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
     * Set idcardCopyPath
     *
     * @param string $idcardCopyPath
     * @return BizOperatorExtendInfo
     */
    public function setIdcardCopyPath($idcardCopyPath)
    {
        $this->idcardCopyPath = $idcardCopyPath;
    
        return $this;
    }

    /**
     * Get idcardCopyPath
     *
     * @return string 
     */
    public function getIdcardCopyPath()
    {
        return $this->idcardCopyPath;
    }

    /**
     * Set authorityCopyPath
     *
     * @param string $authorityCopyPath
     * @return BizOperatorExtendInfo
     */
    public function setAuthorityCopyPath($authorityCopyPath)
    {
        $this->authorityCopyPath = $authorityCopyPath;
    
        return $this;
    }

    /**
     * Get authorityCopyPath
     *
     * @return string 
     */
    public function getAuthorityCopyPath()
    {
        return $this->authorityCopyPath;
    }

    /**
     * Set licenseCopyPath
     *
     * @param string $licenseCopyPath
     * @return BizOperatorExtendInfo
     */
    public function setLicenseCopyPath($licenseCopyPath)
    {
        $this->licenseCopyPath = $licenseCopyPath;
    
        return $this;
    }

    /**
     * Get licenseCopyPath
     *
     * @return string 
     */
    public function getLicenseCopyPath()
    {
        return $this->licenseCopyPath;
    }

    /**
     * Set codeCopyPath
     *
     * @param string $codeCopyPath
     * @return BizOperatorExtendInfo
     */
    public function setCodeCopyPath($codeCopyPath)
    {
        $this->codeCopyPath = $codeCopyPath;
    
        return $this;
    }

    /**
     * Get codeCopyPath
     *
     * @return string 
     */
    public function getCodeCopyPath()
    {
        return $this->codeCopyPath;
    }

    /**
     * Set legalidcardCopyPath
     *
     * @param string $legalidcardCopyPath
     * @return BizOperatorExtendInfo
     */
    public function setLegalidcardCopyPath($legalidcardCopyPath)
    {
        $this->legalidcardCopyPath = $legalidcardCopyPath;
    
        return $this;
    }

    /**
     * Get legalidcardCopyPath
     *
     * @return string 
     */
    public function getLegalidcardCopyPath()
    {
        return $this->legalidcardCopyPath;
    }

    /**
     * Set updateTime
     *
     * @param \DateTime $updateTime
     * @return BizOperatorExtendInfo
     */
    public function setUpdateTime($updateTime)
    {
        $this->updateTime = $updateTime;
    
        return $this;
    }

    /**
     * Get updateTime
     *
     * @return \DateTime 
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }

    /**
     * Set adminId
     *
     * @param string $adminId
     * @return BizOperatorExtendInfo
     */
    public function setAdminId($adminId)
    {
        $this->adminId = $adminId;
    
        return $this;
    }

    /**
     * Get adminId
     *
     * @return string 
     */
    public function getAdminId()
    {
        return $this->adminId;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return BizOperatorExtendInfo
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
