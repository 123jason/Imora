<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BizAuthorPackage
 */
class BizAuthorPackage
{
    /**
     * @var string
     */
    private $authorId;

    /**
     * @var integer
     */
    private $authorizeNum;

    /**
     * @var integer
     */
    private $storageNum;

    /**
     * @var integer
     */
    private $residueNum;

    /**
     * @var integer
     */
    private $length;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $endTime;

    /**
     * @var integer
     */
    private $modifyTime;

    /**
     * @var string
     */
    private $bizId;

    /**
     * @var string
     */
    private $empId;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set authorId
     *
     * @param string $authorId
     * @return BizAuthorPackage
     */
    public function setAuthorId($authorId)
    {
        $this->authorId = $authorId;
    
        return $this;
    }

    /**
     * Get authorId
     *
     * @return string 
     */
    public function getAuthorId()
    {
        return $this->authorId;
    }

    /**
     * Set authorizeNum
     *
     * @param integer $authorizeNum
     * @return BizAuthorPackage
     */
    public function setAuthorizeNum($authorizeNum)
    {
        $this->authorizeNum = $authorizeNum;
    
        return $this;
    }

    /**
     * Get authorizeNum
     *
     * @return integer 
     */
    public function getAuthorizeNum()
    {
        return $this->authorizeNum;
    }

    /**
     * Set storageNum
     *
     * @param integer $storageNum
     * @return BizAuthorPackage
     */
    public function setStorageNum($storageNum)
    {
        $this->storageNum = $storageNum;
    
        return $this;
    }

    /**
     * Get storageNum
     *
     * @return integer 
     */
    public function getStorageNum()
    {
        return $this->storageNum;
    }

    /**
     * Set residueNum
     *
     * @param integer $residueNum
     * @return BizAuthorPackage
     */
    public function setResidueNum($residueNum)
    {
        $this->residueNum = $residueNum;
    
        return $this;
    }

    /**
     * Get residueNum
     *
     * @return integer 
     */
    public function getResidueNum()
    {
        return $this->residueNum;
    }

    /**
     * Set length
     *
     * @param integer $length
     * @return BizAuthorPackage
     */
    public function setLength($length)
    {
        $this->length = $length;
    
        return $this;
    }

    /**
     * Get length
     *
     * @return integer 
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return BizAuthorPackage
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
     * Set endTime
     *
     * @param integer $endTime
     * @return BizAuthorPackage
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
    
        return $this;
    }

    /**
     * Get endTime
     *
     * @return integer 
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Set modifyTime
     *
     * @param integer $modifyTime
     * @return BizAuthorPackage
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
     * Set bizId
     *
     * @param string $bizId
     * @return BizAuthorPackage
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
     * Set empId
     *
     * @param string $empId
     * @return BizAuthorPackage
     */
    public function setEmpId($empId)
    {
        $this->empId = $empId;
    
        return $this;
    }

    /**
     * Get empId
     *
     * @return string 
     */
    public function getEmpId()
    {
        return $this->empId;
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
