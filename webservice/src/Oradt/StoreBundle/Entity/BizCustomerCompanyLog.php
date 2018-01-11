<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BizCustomerCompanyLog
 */
class BizCustomerCompanyLog
{
   
    /**
     * @var integer
     */
    private $companyId;

    /**
     * @var integer
     */
    private $companyUpdateTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set companyId
     *
     * @param integer $companyId
     * @return BizCustomerCompanyLog
     */
    public function setCompanyId($companyId)
    {
        $this->companyId = $companyId;

        return $this;
    }

    /**
     * Get companyId
     *
     * @return integer 
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * Set companyUpdateTime
     *
     * @param integer $companyUpdateTime
     * @return BizCustomerCompanyLog
     */
    public function setCompanyUpdateTime($companyUpdateTime)
    {
        $this->companyUpdateTime = $companyUpdateTime;

        return $this;
    }

    /**
     * Get companyUpdateTime
     *
     * @return integer 
     */
    public function getCompanyUpdateTime()
    {
        return $this->companyUpdateTime;
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
