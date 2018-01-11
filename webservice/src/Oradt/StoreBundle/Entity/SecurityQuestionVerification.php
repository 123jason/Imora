<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SecurityQuestionVerification
 */
class SecurityQuestionVerification
{
    /**
     * @var string
     */
    private $questionId;

    /**
     * @var string
     */
    private $verifytooken;

    /**
     * @var \DateTime
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set questionId
     *
     * @param string $questionId
     * @return SecurityQuestionVerification
     */
    public function setQuestionId($questionId)
    {
        $this->questionId = $questionId;

        return $this;
    }

    /**
     * Get questionId
     *
     * @return string 
     */
    public function getQuestionId()
    {
        return $this->questionId;
    }

    /**
     * Set verifytooken
     *
     * @param string $verifytooken
     * @return SecurityQuestionVerification
     */
    public function setVerifytooken($verifytooken)
    {
        $this->verifytooken = $verifytooken;

        return $this;
    }

    /**
     * Get verifytooken
     *
     * @return string 
     */
    public function getVerifytooken()
    {
        return $this->verifytooken;
    }

    /**
     * Set createdTime
     *
     * @param \DateTime $createdTime
     * @return SecurityQuestionVerification
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
