<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IntroducationState
 */
class IntroducationState
{
    /**
     * @var string
     */
    private $introducationMapId;

    /**
     * @var string
     */
    private $fromAction;

    /**
     * @var string
     */
    private $toAction;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set introducationMapId
     *
     * @param string $introducationMapId
     * @return IntroducationState
     */
    public function setIntroducationMapId($introducationMapId)
    {
        $this->introducationMapId = $introducationMapId;

        return $this;
    }

    /**
     * Get introducationMapId
     *
     * @return string 
     */
    public function getIntroducationMapId()
    {
        return $this->introducationMapId;
    }

    /**
     * Set fromAction
     *
     * @param string $fromAction
     * @return IntroducationState
     */
    public function setFromAction($fromAction)
    {
        $this->fromAction = $fromAction;

        return $this;
    }

    /**
     * Get fromAction
     *
     * @return string 
     */
    public function getFromAction()
    {
        return $this->fromAction;
    }

    /**
     * Set toAction
     *
     * @param string $toAction
     * @return IntroducationState
     */
    public function setToAction($toAction)
    {
        $this->toAction = $toAction;

        return $this;
    }

    /**
     * Get toAction
     *
     * @return string 
     */
    public function getToAction()
    {
        return $this->toAction;
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
