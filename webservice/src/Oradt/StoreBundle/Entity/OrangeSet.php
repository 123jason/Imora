<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrangeSet
 */
class OrangeSet
{
    /**
     * @var integer
     */
    private $warningnum;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set warningnum
     *
     * @param integer $warningnum
     * @return OrangeSet
     */
    public function setWarningnum($warningnum)
    {
        $this->warningnum = $warningnum;
    
        return $this;
    }

    /**
     * Get warningnum
     *
     * @return integer 
     */
    public function getWarningnum()
    {
        return $this->warningnum;
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
