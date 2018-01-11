<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SnsQaCollect
 */
class SnsQaCollect
{
    /**
     * @var string
     */
    private $showId;

    /**
     * @var string
     */
    private $accountId;

    /**
     * @var integer
     */
    private $createtime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set showId
     *
     * @param string $showId
     * @return SnsQaCollect
     */
    public function setShowId($showId)
    {
        $this->showId = $showId;
    
        return $this;
    }

    /**
     * Get showId
     *
     * @return string 
     */
    public function getShowId()
    {
        return $this->showId;
    }

    /**
     * Set accountId
     *
     * @param string $accountId
     * @return SnsQaCollect
     */
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;
    
        return $this;
    }

    /**
     * Get accountId
     *
     * @return string 
     */
    public function getAccountId()
    {
        return $this->accountId;
    }

    /**
     * Set createtime
     *
     * @param integer $createtime
     * @return SnsQaCollect
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
