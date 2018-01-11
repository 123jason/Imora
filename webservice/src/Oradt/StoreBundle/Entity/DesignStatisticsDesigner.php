<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DesignStatisticsDesigner
 */
class DesignStatisticsDesigner
{
    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var integer
     */
    private $totalDesigner;

    /**
     * @var integer
     */
    private $newDesigner;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set date
     *
     * @param \DateTime $date
     * @return DesignStatisticsDesigner
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set totalDesigner
     *
     * @param integer $totalDesigner
     * @return DesignStatisticsDesigner
     */
    public function setTotalDesigner($totalDesigner)
    {
        $this->totalDesigner = $totalDesigner;
    
        return $this;
    }

    /**
     * Get totalDesigner
     *
     * @return integer 
     */
    public function getTotalDesigner()
    {
        return $this->totalDesigner;
    }

    /**
     * Set newDesigner
     *
     * @param integer $newDesigner
     * @return DesignStatisticsDesigner
     */
    public function setNewDesigner($newDesigner)
    {
        $this->newDesigner = $newDesigner;
    
        return $this;
    }

    /**
     * Get newDesigner
     *
     * @return integer 
     */
    public function getNewDesigner()
    {
        return $this->newDesigner;
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
