<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DesignPageView
 */
class DesignPageView
{
    /**
     * @var integer
     */
    private $date;

    /**
     * @var integer
     */
    private $loginDesigner;

    /**
     * @var integer
     */
    private $loginMember;

    /**
     * @var integer
     */
    private $loginAnony;

    /**
     * @var integer
     */
    private $pvDesigner;

    /**
     * @var integer
     */
    private $pvMember;

    /**
     * @var integer
     */
    private $pvAnony;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set date
     *
     * @param integer $date
     * @return DesignPageView
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return integer 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set loginDesigner
     *
     * @param integer $loginDesigner
     * @return DesignPageView
     */
    public function setLoginDesigner($loginDesigner)
    {
        $this->loginDesigner = $loginDesigner;
    
        return $this;
    }

    /**
     * Get loginDesigner
     *
     * @return integer 
     */
    public function getLoginDesigner()
    {
        return $this->loginDesigner;
    }

    /**
     * Set loginMember
     *
     * @param integer $loginMember
     * @return DesignPageView
     */
    public function setLoginMember($loginMember)
    {
        $this->loginMember = $loginMember;
    
        return $this;
    }

    /**
     * Get loginMember
     *
     * @return integer 
     */
    public function getLoginMember()
    {
        return $this->loginMember;
    }

    /**
     * Set loginAnony
     *
     * @param integer $loginAnony
     * @return DesignPageView
     */
    public function setLoginAnony($loginAnony)
    {
        $this->loginAnony = $loginAnony;
    
        return $this;
    }

    /**
     * Get loginAnony
     *
     * @return integer 
     */
    public function getLoginAnony()
    {
        return $this->loginAnony;
    }

    /**
     * Set pvDesigner
     *
     * @param integer $pvDesigner
     * @return DesignPageView
     */
    public function setPvDesigner($pvDesigner)
    {
        $this->pvDesigner = $pvDesigner;
    
        return $this;
    }

    /**
     * Get pvDesigner
     *
     * @return integer 
     */
    public function getPvDesigner()
    {
        return $this->pvDesigner;
    }

    /**
     * Set pvMember
     *
     * @param integer $pvMember
     * @return DesignPageView
     */
    public function setPvMember($pvMember)
    {
        $this->pvMember = $pvMember;
    
        return $this;
    }

    /**
     * Get pvMember
     *
     * @return integer 
     */
    public function getPvMember()
    {
        return $this->pvMember;
    }

    /**
     * Set pvAnony
     *
     * @param integer $pvAnony
     * @return DesignPageView
     */
    public function setPvAnony($pvAnony)
    {
        $this->pvAnony = $pvAnony;
    
        return $this;
    }

    /**
     * Get pvAnony
     *
     * @return integer 
     */
    public function getPvAnony()
    {
        return $this->pvAnony;
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
