<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tags
 */
class Tags
{
    /**
     * @var string
     */
    private $tagname;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set tagname
     *
     * @param string $tagname
     * @return Tags
     */
    public function setTagname($tagname)
    {
        $this->tagname = $tagname;

        return $this;
    }

    /**
     * Get tagname
     *
     * @return string 
     */
    public function getTagname()
    {
        return $this->tagname;
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
