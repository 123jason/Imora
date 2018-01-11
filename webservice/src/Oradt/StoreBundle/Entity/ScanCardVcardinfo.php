<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ScanCardVcardinfo
 */
class ScanCardVcardinfo
{
    /**
     * @var string
     */
    private $cardId;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $fn;

    /**
     * @var string
     */
    private $org;

    /**
     * @var string
     */
    private $depar;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $tel;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $adr;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set cardId
     *
     * @param string $cardId
     * @return ScanCardVcardinfo
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
     * Set userId
     *
     * @param string $userId
     * @return ScanCardVcardinfo
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
     * Set fn
     *
     * @param string $fn
     * @return ScanCardVcardinfo
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
     * Set org
     *
     * @param string $org
     * @return ScanCardVcardinfo
     */
    public function setOrg($org)
    {
        $this->org = $org;
    
        return $this;
    }

    /**
     * Get org
     *
     * @return string 
     */
    public function getOrg()
    {
        return $this->org;
    }

    /**
     * Set depar
     *
     * @param string $depar
     * @return ScanCardVcardinfo
     */
    public function setDepar($depar)
    {
        $this->depar = $depar;
    
        return $this;
    }

    /**
     * Get depar
     *
     * @return string 
     */
    public function getDepar()
    {
        return $this->depar;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return ScanCardVcardinfo
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
     * Set url
     *
     * @param string $url
     * @return ScanCardVcardinfo
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set tel
     *
     * @param string $tel
     * @return ScanCardVcardinfo
     */
    public function setTel($tel)
    {
        $this->tel = $tel;
    
        return $this;
    }

    /**
     * Get tel
     *
     * @return string 
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return ScanCardVcardinfo
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set adr
     *
     * @param string $adr
     * @return ScanCardVcardinfo
     */
    public function setAdr($adr)
    {
        $this->adr = $adr;
    
        return $this;
    }

    /**
     * Get adr
     *
     * @return string 
     */
    public function getAdr()
    {
        return $this->adr;
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
    /**
     * @var string
     */
    private $sn;

    /**
     * @var string
     */
    private $gn;


    /**
     * Set sn
     *
     * @param string $sn
     * @return ScanCardVcardinfo
     */
    public function setSn($sn)
    {
        $this->sn = $sn;

        return $this;
    }

    /**
     * Get sn
     *
     * @return string 
     */
    public function getSn()
    {
        return $this->sn;
    }

    /**
     * Set gn
     *
     * @param string $gn
     * @return ScanCardVcardinfo
     */
    public function setGn($gn)
    {
        $this->gn = $gn;

        return $this;
    }

    /**
     * Get gn
     *
     * @return string 
     */
    public function getGn()
    {
        return $this->gn;
    }
    /**
     * @var string
     */
    private $cell;

    /**
     * @var string
     */
    private $industry;


    /**
     * Set cell
     *
     * @param string $cell
     * @return ScanCardVcardinfo
     */
    public function setCell($cell)
    {
        $this->cell = $cell;

        return $this;
    }

    /**
     * Get cell
     *
     * @return string 
     */
    public function getCell()
    {
        return $this->cell;
    }

    /**
     * Set industry
     *
     * @param string $industry
     * @return ScanCardVcardinfo
     */
    public function setIndustry($industry)
    {
        $this->industry = $industry;

        return $this;
    }

    /**
     * Get industry
     *
     * @return string 
     */
    public function getIndustry()
    {
        return $this->industry;
    }
}
