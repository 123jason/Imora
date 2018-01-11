<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DesignMessageLangs
 */
class DesignMessageLangs
{
    /**
     * @var string
     */
    private $messageId;

    /**
     * @var integer
     */
    private $languageId;

    /**
     * @var string
     */
    private $titleLan;

    /**
     * @var string
     */
    private $contentLan;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set messageId
     *
     * @param string $messageId
     * @return DesignMessageLangs
     */
    public function setMessageId($messageId)
    {
        $this->messageId = $messageId;
    
        return $this;
    }

    /**
     * Get messageId
     *
     * @return string 
     */
    public function getMessageId()
    {
        return $this->messageId;
    }

    /**
     * Set languageId
     *
     * @param integer $languageId
     * @return DesignMessageLangs
     */
    public function setLanguageId($languageId)
    {
        $this->languageId = $languageId;
    
        return $this;
    }

    /**
     * Get languageId
     *
     * @return integer 
     */
    public function getLanguageId()
    {
        return $this->languageId;
    }

    /**
     * Set titleLan
     *
     * @param string $titleLan
     * @return DesignMessageLangs
     */
    public function setTitleLan($titleLan)
    {
        $this->titleLan = $titleLan;
    
        return $this;
    }

    /**
     * Get titleLan
     *
     * @return string 
     */
    public function getTitleLan()
    {
        return $this->titleLan;
    }

    /**
     * Set contentLan
     *
     * @param string $contentLan
     * @return DesignMessageLangs
     */
    public function setContentLan($contentLan)
    {
        $this->contentLan = $contentLan;
    
        return $this;
    }

    /**
     * Get contentLan
     *
     * @return string 
     */
    public function getContentLan()
    {
        return $this->contentLan;
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
