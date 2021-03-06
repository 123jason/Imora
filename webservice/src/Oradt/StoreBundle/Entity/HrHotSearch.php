<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HrHotSearch
 */
class HrHotSearch
{
    /**
     * @var string
     */
    private $word;

    /**
     * @var integer
     */
    private $count;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set word
     *
     * @param string $word
     * @return HrHotSearch
     */
    public function setWord($word)
    {
        $this->word = $word;
    
        return $this;
    }

    /**
     * Get word
     *
     * @return string 
     */
    public function getWord()
    {
        return $this->word;
    }

    /**
     * Set count
     *
     * @param integer $count
     * @return HrHotSearch
     */
    public function setCount($count)
    {
        $this->count = $count;
    
        return $this;
    }

    /**
     * Get count
     *
     * @return integer 
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return HrHotSearch
     */
    public function setCreatedTime($createdTime)
    {
        $this->createdTime = $createdTime;
    
        return $this;
    }

    /**
     * Get createdTime
     *
     * @return \DateTime 
     */
    public function getCreatedTime()
    {
        return $this->createdTime;
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
