<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * YpBizCategory
 */
class YpBizCategory
{
    /**
     * @var string
     */
    private $categoryId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $parentId;

    /**
     * @var integer
     */
    private $totalbiz;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set categoryId
     *
     * @param string $categoryId
     * @return YpBizCategory
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    /**
     * Get categoryId
     *
     * @return string 
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return YpBizCategory
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return YpBizCategory
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set parentId
     *
     * @param string $parentId
     * @return YpBizCategory
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * Get parentId
     *
     * @return string 
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Set totalbiz
     *
     * @param integer $totalbiz
     * @return YpBizCategory
     */
    public function setTotalbiz($totalbiz)
    {
        $this->totalbiz = $totalbiz;

        return $this;
    }

    /**
     * Get totalbiz
     *
     * @return integer 
     */
    public function getTotalbiz()
    {
        return $this->totalbiz;
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
