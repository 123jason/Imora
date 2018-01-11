<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrangeRecommendedStrategy
 */
class OrangeRecommendedStrategy
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $createtime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set name
     *
     * @param string $name
     * @return OrangeRecommendedStrategy
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
     * Set createtime
     *
     * @param integer $createtime
     * @return OrangeRecommendedStrategy
     */
    public function setCreatetime($createtime)
    {
        $this->createtime = $createtime;
    
        return $this;
    }

    /**
     * Get createtime
     *
     * @return integer 
     */
    public function getCreatetime()
    {
        return $this->createtime;
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
