<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExpoRecommend
 */
class ExpoRecommend
{
    /**
     * @var string
     */
    private $expoId;

    /**
     * @var string
     */
    private $accountId;

    /**
     * @var float
     */
    private $score;

    /**
     * @var string
     */
    private $reason;

    /**
     * @var integer
     */
    private $createtime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set expoId
     *
     * @param string $expoId
     * @return ExpoRecommend
     */
    public function setExpoId($expoId)
    {
        $this->expoId = $expoId;
    
        return $this;
    }

    /**
     * Get expoId
     *
     * @return string 
     */
    public function getExpoId()
    {
        return $this->expoId;
    }

    /**
     * Set accountId
     *
     * @param string $accountId
     * @return ExpoRecommend
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
     * Set score
     *
     * @param float $score
     * @return ExpoRecommend
     */
    public function setScore($score)
    {
        $this->score = $score;
    
        return $this;
    }

    /**
     * Get score
     *
     * @return float 
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set reason
     *
     * @param string $reason
     * @return ExpoRecommend
     */
    public function setReason($reason)
    {
        $this->reason = $reason;
    
        return $this;
    }

    /**
     * Get reason
     *
     * @return string 
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * Set createtime
     *
     * @param integer $createtime
     * @return ExpoRecommend
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
