<?php
/**
 * Created by PhpStorm.
 * User: qiuzhigang
 * Date: 2017/10/10
 * Time: 18:26
 */

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WeixinCardShare
 */
class WeixinCardShare
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $cardId;

    /**
     * @var integer
     */
    private $createTime;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getCardId()
    {
        return $this->cardId;
    }

    /**
     * @param int $cardId
     * @return WeixinCardShare
     */
    public function setCardId( $cardId)
    {
        $this->cardId = $cardId;

        return $this;
    }

    /**
     * @return int
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * @param int $createTime
     * @return WeixinCardShare
     */
    public function setCreateTime( $createTime)
    {
        $this->createTime = $createTime;

        return $this;
    }
}