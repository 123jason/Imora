<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Faq
 */
class Faq
{
    /**
     * @var string
     */
    private $questionid;

    /**
     * @var integer
     */
    private $languageid;

    /**
     * @var string
     */
    private $question;

    /**
     * @var string
     */
    private $answer;

    /**
     * @var integer
     */
    private $sort;

    /**
     * @var integer
     */
    private $zan;

    /**
     * @var integer
     */
    private $cai;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set questionid
     *
     * @param string $questionid
     * @return Faq
     */
    public function setQuestionid($questionid)
    {
        $this->questionid = $questionid;
    
        return $this;
    }

    /**
     * Get questionid
     *
     * @return string 
     */
    public function getQuestionid()
    {
        return $this->questionid;
    }

    /**
     * Set languageid
     *
     * @param integer $languageid
     * @return Faq
     */
    public function setLanguageid($languageid)
    {
        $this->languageid = $languageid;
    
        return $this;
    }

    /**
     * Get languageid
     *
     * @return integer 
     */
    public function getLanguageid()
    {
        return $this->languageid;
    }

    /**
     * Set question
     *
     * @param string $question
     * @return Faq
     */
    public function setQuestion($question)
    {
        $this->question = $question;
    
        return $this;
    }

    /**
     * Get question
     *
     * @return string 
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set answer
     *
     * @param string $answer
     * @return Faq
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;
    
        return $this;
    }

    /**
     * Get answer
     *
     * @return string 
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set sort
     *
     * @param integer $sort
     * @return Faq
     */
    public function setSort($sort)
    {
        $this->sort = $sort;
    
        return $this;
    }

    /**
     * Get sort
     *
     * @return integer 
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Set zan
     *
     * @param integer $zan
     * @return Faq
     */
    public function setZan($zan)
    {
        $this->zan = $zan;
    
        return $this;
    }

    /**
     * Get zan
     *
     * @return integer 
     */
    public function getZan()
    {
        return $this->zan;
    }

    /**
     * Set cai
     *
     * @param integer $cai
     * @return Faq
     */
    public function setCai($cai)
    {
        $this->cai = $cai;
    
        return $this;
    }

    /**
     * Get cai
     *
     * @return integer 
     */
    public function getCai()
    {
        return $this->cai;
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
     * @var integer
     */
    private $statue;


    /**
     * Set statue
     *
     * @param integer $statue
     * @return Faq
     */
    public function setStatue($statue)
    {
        $this->statue = $statue;
    
        return $this;
    }

    /**
     * Get statue
     *
     * @return integer 
     */
    public function getStatue()
    {
        return $this->statue;
    }
    /**
     * @var integer
     */
    private $typeid;


    /**
     * Set typeid
     *
     * @param integer $typeid
     * @return Faq
     */
    public function setTypeid($typeid)
    {
        $this->typeid = $typeid;
    
        return $this;
    }

    /**
     * Get typeid
     *
     * @return integer 
     */
    public function getTypeid()
    {
        return $this->typeid;
    }
}
