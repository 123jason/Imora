<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BasicOrderEval
 */
class BasicOrderEval
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $orderId;

    /**
     * @var integer
     */
    private $type;

    /**
     * @var integer
     */
    private $score;

    /**
     * @var string
     */
    private $content;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var integer
     */
    private $createTime;

    /**
     * @var integer
     */
    private $modifyTime;

    /**
     * @var integer
     */
    private $isVisit;

    /**
     * @var string
     */
    private $adminId;

    /**
     * @var string
     */
    private $remark;

    /**
     * @var integer
     */
    private $visitTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set userId
     *
     * @param string $userId
     * @return BasicOrderEval
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
     * Set orderId
     *
     * @param string $orderId
     * @return BasicOrderEval
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
    
        return $this;
    }

    /**
     * Get orderId
     *
     * @return string 
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return BasicOrderEval
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set score
     *
     * @param integer $score
     * @return BasicOrderEval
     */
    public function setScore($score)
    {
        $this->score = $score;
    
        return $this;
    }

    /**
     * Get score
     *
     * @return integer 
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return BasicOrderEval
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
     * Set status
     *
     * @param integer $status
     * @return BasicOrderEval
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set createTime
     *
     * @param integer $createTime
     * @return BasicOrderEval
     */
    public function setCreateTime($createTime)
    {
        $this->createTime = $createTime;
    
        return $this;
    }

    /**
     * Get createTime
     *
     * @return integer 
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * Set modifyTime
     *
     * @param integer $modifyTime
     * @return BasicOrderEval
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
     * Set isVisit
     *
     * @param integer $isVisit
     * @return BasicOrderEval
     */
    public function setIsVisit($isVisit)
    {
        $this->isVisit = $isVisit;
    
        return $this;
    }

    /**
     * Get isVisit
     *
     * @return integer 
     */
    public function getIsVisit()
    {
        return $this->isVisit;
    }

    /**
     * Set adminId
     *
     * @param string $adminId
     * @return BasicOrderEval
     */
    public function setAdminId($adminId)
    {
        $this->adminId = $adminId;
    
        return $this;
    }

    /**
     * Get adminId
     *
     * @return string 
     */
    public function getAdminId()
    {
        return $this->adminId;
    }

    /**
     * Set remark
     *
     * @param string $remark
     * @return BasicOrderEval
     */
    public function setRemark($remark)
    {
        $this->remark = $remark;
    
        return $this;
    }

    /**
     * Get remark
     *
     * @return string 
     */
    public function getRemark()
    {
        return $this->remark;
    }

    /**
     * Set visitTime
     *
     * @param integer $visitTime
     * @return BasicOrderEval
     */
    public function setVisitTime($visitTime)
    {
        $this->visitTime = $visitTime;
    
        return $this;
    }

    /**
     * Get visitTime
     *
     * @return integer 
     */
    public function getVisitTime()
    {
        return $this->visitTime;
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
