<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BizCardDeliveryInfo
 */
class BizCardDeliveryInfo
{
    /**
     * @var string
     */
    private $deliveryId;

    /**
     * @var string
     */
    private $bizId;

    /**
     * @var string
     */
    private $account;

    /**
     * @var string
     */
    private $accountId;

    /**
     * @var string
     */
    private $cardId;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set deliveryId
     *
     * @param string $deliveryId
     * @return BizCardDeliveryInfo
     */
    public function setDeliveryId($deliveryId)
    {
        $this->deliveryId = $deliveryId;

        return $this;
    }

    /**
     * Get deliveryId
     *
     * @return string 
     */
    public function getDeliveryId()
    {
        return $this->deliveryId;
    }

    /**
     * Set bizId
     *
     * @param string $bizId
     * @return BizCardDeliveryInfo
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
     * Set account
     *
     * @param string $account
     * @return BizCardDeliveryInfo
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
     * Set accountId
     *
     * @param string $accountId
     * @return BizCardDeliveryInfo
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
     * Set cardId
     *
     * @param string $cardId
     * @return BizCardDeliveryInfo
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
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return BizCardDeliveryInfo
     */
    public function setCreatedTime($createdTime)
    {
        $this->createdTime = $createdTime;

        return $this;
    }

    /**
     * Get createdTime
     *
     * @return \DateTime 
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
