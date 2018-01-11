<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DesignProductStyle
 */
class DesignProductStyle
{
    /**
     * @var string
     */
    private $styleId;

    /**
     * @var string
     */
    private $styleName;

    /**
     * @var integer
     */
    private $type;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set styleId
     *
     * @param string $styleId
     * @return DesignProductStyle
     */
    public function setStyleId($styleId)
    {
        $this->styleId = $styleId;
    
        return $this;
    }

    /**
     * Get styleId
     *
     * @return string 
     */
    public function getStyleId()
    {
        return $this->styleId;
    }

    /**
     * Set styleName
     *
     * @param string $styleName
     * @return DesignProductStyle
     */
    public function setStyleName($styleName)
    {
        $this->styleName = $styleName;
    
        return $this;
    }

    /**
     * Get styleName
     *
     * @return string 
     */
    public function getStyleName()
    {
        return $this->styleName;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return DesignProductStyle
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
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
