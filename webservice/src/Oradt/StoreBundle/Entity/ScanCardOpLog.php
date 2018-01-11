<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ScanCardOpLog
 */
class ScanCardOpLog
{
    /**
     * @var string
     */
    private $cardid;

    /**
     * @var integer
     */
    private $opid;

    /**
     * @var string
     */
    private $operator;

    /**
     * @var \DateTime
     */
    private $opTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set cardid
     *
     * @param string $cardid
     * @return ScanCardOpLog
     */
    public function setCardid($cardid)
    {
        $this->cardid = $cardid;

        return $this;
    }

    /**
     * Get cardid
     *
     * @return string 
     */
    public function getCardid()
    {
        return $this->cardid;
    }

    /**
     * Set opid
     *
     * @param integer $opid
     * @return ScanCardOpLog
     */
    public function setOpid($opid)
    {
        $this->opid = $opid;

        return $this;
    }

    /**
     * Get opid
     *
     * @return integer 
     */
    public function getOpid()
    {
        return $this->opid;
    }

    /**
     * Set operator
     *
     * @param string $operator
     * @return ScanCardOpLog
     */
    public function setOperator($operator)
    {
        $this->operator = $operator;

        return $this;
    }

    /**
     * Get operator
     *
     * @return string 
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * Set opTime
     *
     * @param \DateTime $opTime
     * @return ScanCardOpLog
     */
    public function setOpTime($opTime)
    {
        $this->opTime = $opTime;

        return $this;
    }

    /**
     * Get opTime
     *
     * @return \DateTime 
     */
    public function getOpTime()
    {
        return $this->opTime;
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
