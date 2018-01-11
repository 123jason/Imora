<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * YpBizBranchOffice
 */
class YpBizBranchOffice
{
    /**
     * @var string
     */
    private $branchId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $latitude;

    /**
     * @var string
     */
    private $longitude;

    /**
     * @var string
     */
    private $principal;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $website;

    /**
     * @var string
     */
    private $bizId;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set branchId
     *
     * @param string $branchId
     * @return YpBizBranchOffice
     */
    public function setBranchId($branchId)
    {
        $this->branchId = $branchId;

        return $this;
    }

    /**
     * Get branchId
     *
     * @return string 
     */
    public function getBranchId()
    {
        return $this->branchId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return YpBizBranchOffice
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
     * Set address
     *
     * @param string $address
     * @return YpBizBranchOffice
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     * @return YpBizBranchOffice
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     * @return YpBizBranchOffice
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set principal
     *
     * @param string $principal
     * @return YpBizBranchOffice
     */
    public function setPrincipal($principal)
    {
        $this->principal = $principal;

        return $this;
    }

    /**
     * Get principal
     *
     * @return string 
     */
    public function getPrincipal()
    {
        return $this->principal;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return YpBizBranchOffice
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set website
     *
     * @param string $website
     * @return YpBizBranchOffice
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string 
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set bizId
     *
     * @param string $bizId
     * @return YpBizBranchOffice
     */
    public function setBizId($bizId)
    {
        $this->bizId = $bizId;

        return $this;
    }

    /**
     * Get bizId
     *
     * @return string 
     */
    public function getBizId()
    {
        return $this->bizId;
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
