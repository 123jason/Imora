<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountBizArticle
 */
class AccountBizArticle
{
    /**
     * @var string
     */
    private $articleId;

    /**
     * @var string
     */
    private $accountType;

    /**
     * @var string
     */
    private $accountId;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $picPath;

    /**
     * @var string
     */
    private $source;

    /**
     * @var string
     */
    private $status;

    /**
     * @var integer
     */
    private $createtime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set articleId
     *
     * @param string $articleId
     * @return AccountBizArticle
     */
    public function setArticleId($articleId)
    {
        $this->articleId = $articleId;
    
        return $this;
    }

    /**
     * Get articleId
     *
     * @return string 
     */
    public function getArticleId()
    {
        return $this->articleId;
    }

    /**
     * Set accountType
     *
     * @param string $accountType
     * @return AccountBizArticle
     */
    public function setAccountType($accountType)
    {
        $this->accountType = $accountType;
    
        return $this;
    }

    /**
     * Get accountType
     *
     * @return string 
     */
    public function getAccountType()
    {
        return $this->accountType;
    }

    /**
     * Set accountId
     *
     * @param string $accountId
     * @return AccountBizArticle
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
     * Set title
     *
     * @param string $title
     * @return AccountBizArticle
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
     * Set content
     *
     * @param string $content
     * @return AccountBizArticle
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
     * Set picPath
     *
     * @param string $picPath
     * @return AccountBizArticle
     */
    public function setPicPath($picPath)
    {
        $this->picPath = $picPath;
    
        return $this;
    }

    /**
     * Get picPath
     *
     * @return string 
     */
    public function getPicPath()
    {
        return $this->picPath;
    }

    /**
     * Set source
     *
     * @param string $source
     * @return AccountBizArticle
     */
    public function setSource($source)
    {
        $this->source = $source;
    
        return $this;
    }

    /**
     * Get source
     *
     * @return string 
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return AccountBizArticle
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set createtime
     *
     * @param integer $createtime
     * @return AccountBizArticle
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
