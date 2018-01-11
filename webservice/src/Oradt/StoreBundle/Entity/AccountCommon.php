<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountCommon
 */
class AccountCommon
{    
    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $accountId;

    /**
     * @var string
     */
    private $account;

    /**
     * @var integer
     */
    private $createtime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set type
     *
     * @param string $type
     * @return AccountCommon
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set accountId
     *
     * @param string $accountId
     * @return AccountCommon
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
     * Set account
     *
     * @param string $account
     * @return AccountCommon
     */
    public function setAccount($account)
    {
        $this->account = $account;
    
        return $this;
    }

    /**
     * Get account
     *
     * @return string 
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set createtime
     *
     * @param integer $createtime
     * @return AccountCommon
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
