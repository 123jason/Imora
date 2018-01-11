<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ScanCardRectify
 */
class ScanCardRectify
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $cardId;

    /**
     * @var string
     */
    private $orgs;

    /**
     * @var string
     */
    private $titles;

    /**
     * @var string
     */
    private $fn;

    /**
     * @var string
     */
    private $batch;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set cardId
     *
     * @param string $cardId
     * @return ScanCardRectify
     */
    public function setCardId($cardId)
    {
        $this->cardId = $cardId;

        return $this;
    }

    /**
     * Get cardId
     *
     * @return string 
     */
    public function getCardId()
    {
        return $this->cardId;
    }

    /**
     * Set orgs
     *
     * @param string $orgs
     * @return ScanCardRectify
     */
    public function setOrgs($orgs)
    {
        $this->orgs = $orgs;

        return $this;
    }

    /**
     * Get orgs
     *
     * @return string 
     */
    public function getOrgs()
    {
        return $this->orgs;
    }

    /**
     * Set titles
     *
     * @param string $titles
     * @return ScanCardRectify
     */
    public function setTitles($titles)
    {
        $this->titles = $titles;

        return $this;
    }

    /**
     * Get titles
     *
     * @return string 
     */
    public function getTitles()
    {
        return $this->titles;
    }

    /**
     * Set fn
     *
     * @param string $fn
     * @return ScanCardRectify
     */
    public function setFn($fn)
    {
        $this->fn = $fn;

        return $this;
    }

    /**
     * Get fn
     *
     * @return string 
     */
    public function getFn()
    {
        return $this->fn;
    }

    /**
     * Set batch
     *
     * @param string $batch
     * @return ScanCardRectify
     */
    public function setBatch($batch)
    {
        $this->batch = $batch;

        return $this;
    }

    /**
     * Get batch
     *
     * @return string 
     */
    public function getBatch()
    {
        return $this->batch;
    }
}
