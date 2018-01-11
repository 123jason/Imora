<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrangeContentType
 */
class OrangeContentType
{
    /**
     * @var string
     */
    private $name;

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
     * Set name
     *
     * @param string $name
     * @return OrangeContentType
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
     * Set modifytime
     *
     * @param integer $modifytime
     * @return OrangeContentType
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
     * @return OrangeContentType
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
