<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrangeMonthlyReport
 */
class OrangeMonthlyReport
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $content;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $modifyTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return OrangeMonthlyReport
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    
        return $this;
    }

    /**
     * Get userId
     *
     * @return string 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return OrangeMonthlyReport
     */
    public function setContent($content)
    {
        $this->content = $content;
    
        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return OrangeMonthlyReport
     */
    public function setCreatedTime($createdTime)
    {
        $this->createdTime = $createdTime;
    
        return $this;
    }

    /**
     * Get createdTime
     *
     * @return integer 
     */
    public function getCreatedTime()
    {
        return $this->createdTime;
    }

    /**
     * Set modifyTime
     *
     * @param integer $modifyTime
     * @return OrangeMonthlyReport
     */
    public function setModifyTime($modifyTime)
    {
        $this->modifyTime = $modifyTime;
    
        return $this;
    }

    /**
     * Get modifyTime
     *
     * @return integer 
     */
    public function getModifyTime()
    {
        return $this->modifyTime;
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

    public $reportMonth;

    /**
     * Set reportMonth
     *
     * @param integer $reportMonth
     * @return OrangeMonthlyReport
     */
    public function setReportMonth($reportMonth)
    {
        $this->reportMonth = $reportMonth;
    
        return $this;
    }

    /**
     * Get reportMonth
     *
     * @return string 
     */
    public function getReportMonth()
    {
        return $this->reportMonth;
    }

}
