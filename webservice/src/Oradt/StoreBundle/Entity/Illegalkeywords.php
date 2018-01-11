<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Illegalkeywords
 */
class Illegalkeywords
{
    /**
     * @var string
     */
    private $keyName;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set keyName
     *
     * @param string $keyName
     * @return Illegalkeywords
     */
    public function setKeyName($keyName)
    {
        $this->keyName = $keyName;
    
        return $this;
    }

    /**
     * Get keyName
     *
     * @return string 
     */
    public function getKeyName()
    {
        return $this->keyName;
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
