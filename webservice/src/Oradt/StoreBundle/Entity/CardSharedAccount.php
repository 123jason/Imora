<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CardSharedAccount
 */
class CardSharedAccount
{
    /**
     * @var integer
     */
    private $shareid;

    /**
     * @var string
     */
    private $accountid;

    /**
     * @var string
     */
    private $account;

    /**
     * @var string
     */
    private $realname;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $company;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set shareid
     *
     * @param integer $shareid
     * @return CardSharedAccount
     */
    public function setShareid($shareid)
    {
        $this->shareid = $shareid;
    
        return $this;
    }

    /**
     * Get shareid
     *
     * @return integer 
     */
    public function getShareid()
    {
        return $this->shareid;
    }

    /**
     * Set accountid
     *
     * @param string $accountid
     * @return CardSharedAccount
     */
    public function setAccountid($accountid)
    {
        $this->accountid = $accountid;
    
        return $this;
    }

    /**
     * Get accountid
     *
     * @return string 
     */
    public function getAccountid()
    {
        return $this->accountid;
    }

    /**
     * Set account
     *
     * @param string $account
     * @return CardSharedAccount
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
     * Set realname
     *
     * @param string $realname
     * @return CardSharedAccount
     */
    public function setRealname($realname)
    {
        $this->realname = $realname;
    
        return $this;
    }

    /**
     * Get realname
     *
     * @return string 
     */
    public function getRealname()
    {
        return $this->realname;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return CardSharedAccount
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set company
     *
     * @param string $company
     * @return CardSharedAccount
     */
    public function setCompany($company)
    {
        $this->company = $company;
    
        return $this;
    }

    /**
     * Get company
     *
     * @return string 
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return CardSharedAccount
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
