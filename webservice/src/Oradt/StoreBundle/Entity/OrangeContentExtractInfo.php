<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrangeContentExtractInfo
 */
class OrangeContentExtractInfo
{
    /**
     * @var integer
     */
    private $contentTypeId;

    /**
     * @var string
     */
    private $infoName;

    /**
     * @var integer
     */
    private $modifytime;

    /**
     * @var integer
     */
    private $createdtime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set contentTypeId
     *
     * @param integer $contentTypeId
     * @return OrangeContentExtractInfo
     */
    public function setContentTypeId($contentTypeId)
    {
        $this->contentTypeId = $contentTypeId;
    
        return $this;
    }

    /**
     * Get contentTypeId
     *
     * @return integer 
     */
    public function getContentTypeId()
    {
        return $this->contentTypeId;
    }

    /**
     * Set infoName
     *
     * @param string $infoName
     * @return OrangeContentExtractInfo
     */
    public function setInfoName($infoName)
    {
        $this->infoName = $infoName;
    
        return $this;
    }

    /**
     * Get infoName
     *
     * @return string 
     */
    public function getInfoName()
    {
        return $this->infoName;
    }

    /**
     * Set modifytime
     *
     * @param integer $modifytime
     * @return OrangeContentExtractInfo
     */
    public function setModifytime($modifytime)
    {
        $this->modifytime = $modifytime;
    
        return $this;
    }

    /**
     * Get modifytime
     *
     * @return integer 
     */
    public function getModifytime()
    {
        return $this->modifytime;
    }

    /**
     * Set createdtime
     *
     * @param integer $createdtime
     * @return OrangeContentExtractInfo
     */
    public function setCreatedtime($createdtime)
    {
        $this->createdtime = $createdtime;
    
        return $this;
    }

    /**
     * Get createdtime
     *
     * @return integer 
     */
    public function getCreatedtime()
    {
        return $this->createdtime;
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
