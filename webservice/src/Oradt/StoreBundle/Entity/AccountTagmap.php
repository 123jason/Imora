<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountTagmap
 */
class AccountTagmap
{
    /**
     * @var string
     */
    private $tagType;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $fuserId;

    /**
     * @var integer
     */
    private $tagid;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set tagType
     *
     * @param string $tagType
     * @return AccountTagmap
     */
    public function setTagType($tagType)
    {
        $this->tagType = $tagType;

        return $this;
    }

    /**
     * Get tagType
     *
     * @return string 
     */
    public function getTagType()
    {
        return $this->tagType;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return AccountTagmap
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
     * Set fuserId
     *
     * @param string $fuserId
     * @return AccountTagmap
     */
    public function setFuserId($fuserId)
    {
        $this->fuserId = $fuserId;

        return $this;
    }

    /**
     * Get fuserId
     *
     * @return string 
     */
    public function getFuserId()
    {
        return $this->fuserId;
    }

    /**
     * Set tagid
     *
     * @param integer $tagid
     * @return AccountTagmap
     */
    public function setTagid($tagid)
    {
        $this->tagid = $tagid;

        return $this;
    }

    /**
     * Get tagid
     *
     * @return integer 
     */
    public function getTagid()
    {
        return $this->tagid;
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
