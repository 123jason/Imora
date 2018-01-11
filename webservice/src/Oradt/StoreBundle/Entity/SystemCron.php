<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SystemCron
 */
class SystemCron
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $runStamp;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set name
     *
     * @param string $name
     * @return SystemCron
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set runStamp
     *
     * @param integer $runStamp
     * @return SystemCron
     */
    public function setRunStamp($runStamp)
    {
        $this->runStamp = $runStamp;

        return $this;
    }

    /**
     * Get runStamp
     *
     * @return integer 
     */
    public function getRunStamp()
    {
        return $this->runStamp;
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
