<?php

namespace Oradt\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrangeFlight
 */
class OrangeFlight
{
    /**
     * @var string
     */
    private $fnum;

    /**
     * @var string
     */
    private $fdate;

    /**
     * @var string
     */
    private $fcontent;

    /**
     * @var integer
     */
    private $createdTime;

    /**
     * @var integer
     */
    private $modifyTime;

    /**
     * @var integer
     */
    private $ifcustom;

    /**
     * @var string
     */
    private $updateContent;

    /**
     * @var string
     */
    private $contrastContent;

    /**
     * @var integer
     */
    private $fcategory;

    /**
     * @var string
     */
    private $orgTimezone;

    /**
     * @var string
     */
    private $dstTimezone;

    /**
     * @var string
     */
    private $flightcompany;

    /**
     * @var string
     */
    private $flightdepcode;

    /**
     * @var string
     */
    private $flightarrcode;

    /**
     * @var string
     */
    private $flightdeptimeplandate;

    /**
     * @var string
     */
    private $flightarrtimeplandate;

    /**
     * @var string
     */
    private $flightdeptimereadydate;

    /**
     * @var string
     */
    private $flightarrtimereadydate;

    /**
     * @var string
     */
    private $flightdeptimedate;

    /**
     * @var string
     */
    private $flightarrtimedate;

    /**
     * @var string
     */
    private $boardgate;

    /**
     * @var string
     */
    private $baggageid;

    /**
     * @var string
     */
    private $flightstate;

    /**
     * @var string
     */
    private $shareflightno;

    /**
     * @var string
     */
    private $flighthterminal;

    /**
     * @var string
     */
    private $flightterminal;

    /**
     * @var integer
     */
    private $stopflag;

    /**
     * @var integer
     */
    private $shareflag;

    /**
     * @var integer
     */
    private $legflag;

    /**
     * @var string
     */
    private $flightdep;

    /**
     * @var string
     */
    private $flightarr;

    /**
     * @var string
     */
    private $flightdepairport;

    /**
     * @var string
     */
    private $flightarrairport;

    /**
     * @var string
     */
    private $fjson;

    /**
     * @var string
     */
    private $distance;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set fnum
     *
     * @param string $fnum
     * @return OrangeFlight
     */
    public function setFnum($fnum)
    {
        $this->fnum = $fnum;
    
        return $this;
    }

    /**
     * Get fnum
     *
     * @return string 
     */
    public function getFnum()
    {
        return $this->fnum;
    }

    /**
     * Set fdate
     *
     * @param string $fdate
     * @return OrangeFlight
     */
    public function setFdate($fdate)
    {
        $this->fdate = $fdate;
    
        return $this;
    }

    /**
     * Get fdate
     *
     * @return string 
     */
    public function getFdate()
    {
        return $this->fdate;
    }

    /**
     * Set fcontent
     *
     * @param string $fcontent
     * @return OrangeFlight
     */
    public function setFcontent($fcontent)
    {
        $this->fcontent = $fcontent;
    
        return $this;
    }

    /**
     * Get fcontent
     *
     * @return string 
     */
    public function getFcontent()
    {
        return $this->fcontent;
    }

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     * @return OrangeFlight
     */
    public function setCreatedTime($createdTime)
    {
        $this->createdTime = $createdTime;
    
        return $this;
    }

    /**
     * Get createdTime
     *
     * @return integer 
     */
    public function getCreatedTime()
    {
        return $this->createdTime;
    }

    /**
     * Set modifyTime
     *
     * @param integer $modifyTime
     * @return OrangeFlight
     */
    public function setModifyTime($modifyTime)
    {
        $this->modifyTime = $modifyTime;
    
        return $this;
    }

    /**
     * Get modifyTime
     *
     * @return integer 
     */
    public function getModifyTime()
    {
        return $this->modifyTime;
    }

    /**
     * Set ifcustom
     *
     * @param integer $ifcustom
     * @return OrangeFlight
     */
    public function setIfcustom($ifcustom)
    {
        $this->ifcustom = $ifcustom;
    
        return $this;
    }

    /**
     * Get ifcustom
     *
     * @return integer 
     */
    public function getIfcustom()
    {
        return $this->ifcustom;
    }

    /**
     * Set updateContent
     *
     * @param string $updateContent
     * @return OrangeFlight
     */
    public function setUpdateContent($updateContent)
    {
        $this->updateContent = $updateContent;
    
        return $this;
    }

    /**
     * Get updateContent
     *
     * @return string 
     */
    public function getUpdateContent()
    {
        return $this->updateContent;
    }

    /**
     * Set contrastContent
     *
     * @param string $contrastContent
     * @return OrangeFlight
     */
    public function setContrastContent($contrastContent)
    {
        $this->contrastContent = $contrastContent;
    
        return $this;
    }

    /**
     * Get contrastContent
     *
     * @return string 
     */
    public function getContrastContent()
    {
        return $this->contrastContent;
    }

    /**
     * Set fcategory
     *
     * @param integer $fcategory
     * @return OrangeFlight
     */
    public function setFcategory($fcategory)
    {
        $this->fcategory = $fcategory;
    
        return $this;
    }

    /**
     * Get fcategory
     *
     * @return integer 
     */
    public function getFcategory()
    {
        return $this->fcategory;
    }

    /**
     * Set orgTimezone
     *
     * @param string $orgTimezone
     * @return OrangeFlight
     */
    public function setOrgTimezone($orgTimezone)
    {
        $this->orgTimezone = $orgTimezone;
    
        return $this;
    }

    /**
     * Get orgTimezone
     *
     * @return string 
     */
    public function getOrgTimezone()
    {
        return $this->orgTimezone;
    }

    /**
     * Set dstTimezone
     *
     * @param string $dstTimezone
     * @return OrangeFlight
     */
    public function setDstTimezone($dstTimezone)
    {
        $this->dstTimezone = $dstTimezone;
    
        return $this;
    }

    /**
     * Get dstTimezone
     *
     * @return string 
     */
    public function getDstTimezone()
    {
        return $this->dstTimezone;
    }

    /**
     * Set flightcompany
     *
     * @param string $flightcompany
     * @return OrangeFlight
     */
    public function setFlightcompany($flightcompany)
    {
        $this->flightcompany = $flightcompany;
    
        return $this;
    }

    /**
     * Get flightcompany
     *
     * @return string 
     */
    public function getFlightcompany()
    {
        return $this->flightcompany;
    }

    /**
     * Set flightdepcode
     *
     * @param string $flightdepcode
     * @return OrangeFlight
     */
    public function setFlightdepcode($flightdepcode)
    {
        $this->flightdepcode = $flightdepcode;
    
        return $this;
    }

    /**
     * Get flightdepcode
     *
     * @return string 
     */
    public function getFlightdepcode()
    {
        return $this->flightdepcode;
    }

    /**
     * Set flightarrcode
     *
     * @param string $flightarrcode
     * @return OrangeFlight
     */
    public function setFlightarrcode($flightarrcode)
    {
        $this->flightarrcode = $flightarrcode;
    
        return $this;
    }

    /**
     * Get flightarrcode
     *
     * @return string 
     */
    public function getFlightarrcode()
    {
        return $this->flightarrcode;
    }

    /**
     * Set flightdeptimeplandate
     *
     * @param string $flightdeptimeplandate
     * @return OrangeFlight
     */
    public function setFlightdeptimeplandate($flightdeptimeplandate)
    {
        $this->flightdeptimeplandate = $flightdeptimeplandate;
    
        return $this;
    }

    /**
     * Get flightdeptimeplandate
     *
     * @return string 
     */
    public function getFlightdeptimeplandate()
    {
        return $this->flightdeptimeplandate;
    }

    /**
     * Set flightarrtimeplandate
     *
     * @param string $flightarrtimeplandate
     * @return OrangeFlight
     */
    public function setFlightarrtimeplandate($flightarrtimeplandate)
    {
        $this->flightarrtimeplandate = $flightarrtimeplandate;
    
        return $this;
    }

    /**
     * Get flightarrtimeplandate
     *
     * @return string 
     */
    public function getFlightarrtimeplandate()
    {
        return $this->flightarrtimeplandate;
    }

    /**
     * Set flightdeptimereadydate
     *
     * @param string $flightdeptimereadydate
     * @return OrangeFlight
     */
    public function setFlightdeptimereadydate($flightdeptimereadydate)
    {
        $this->flightdeptimereadydate = $flightdeptimereadydate;
    
        return $this;
    }

    /**
     * Get flightdeptimereadydate
     *
     * @return string 
     */
    public function getFlightdeptimereadydate()
    {
        return $this->flightdeptimereadydate;
    }

    /**
     * Set flightarrtimereadydate
     *
     * @param string $flightarrtimereadydate
     * @return OrangeFlight
     */
    public function setFlightarrtimereadydate($flightarrtimereadydate)
    {
        $this->flightarrtimereadydate = $flightarrtimereadydate;
    
        return $this;
    }

    /**
     * Get flightarrtimereadydate
     *
     * @return string 
     */
    public function getFlightarrtimereadydate()
    {
        return $this->flightarrtimereadydate;
    }

    /**
     * Set flightdeptimedate
     *
     * @param string $flightdeptimedate
     * @return OrangeFlight
     */
    public function setFlightdeptimedate($flightdeptimedate)
    {
        $this->flightdeptimedate = $flightdeptimedate;
    
        return $this;
    }

    /**
     * Get flightdeptimedate
     *
     * @return string 
     */
    public function getFlightdeptimedate()
    {
        return $this->flightdeptimedate;
    }

    /**
     * Set flightarrtimedate
     *
     * @param string $flightarrtimedate
     * @return OrangeFlight
     */
    public function setFlightarrtimedate($flightarrtimedate)
    {
        $this->flightarrtimedate = $flightarrtimedate;
    
        return $this;
    }

    /**
     * Get flightarrtimedate
     *
     * @return string 
     */
    public function getFlightarrtimedate()
    {
        return $this->flightarrtimedate;
    }

    /**
     * Set boardgate
     *
     * @param string $boardgate
     * @return OrangeFlight
     */
    public function setBoardgate($boardgate)
    {
        $this->boardgate = $boardgate;
    
        return $this;
    }

    /**
     * Get boardgate
     *
     * @return string 
     */
    public function getBoardgate()
    {
        return $this->boardgate;
    }

    /**
     * Set baggageid
     *
     * @param string $baggageid
     * @return OrangeFlight
     */
    public function setBaggageid($baggageid)
    {
        $this->baggageid = $baggageid;
    
        return $this;
    }

    /**
     * Get baggageid
     *
     * @return string 
     */
    public function getBaggageid()
    {
        return $this->baggageid;
    }

    /**
     * Set flightstate
     *
     * @param string $flightstate
     * @return OrangeFlight
     */
    public function setFlightstate($flightstate)
    {
        $this->flightstate = $flightstate;
    
        return $this;
    }

    /**
     * Get flightstate
     *
     * @return string 
     */
    public function getFlightstate()
    {
        return $this->flightstate;
    }

    /**
     * Set shareflightno
     *
     * @param string $shareflightno
     * @return OrangeFlight
     */
    public function setShareflightno($shareflightno)
    {
        $this->shareflightno = $shareflightno;
    
        return $this;
    }

    /**
     * Get shareflightno
     *
     * @return string 
     */
    public function getShareflightno()
    {
        return $this->shareflightno;
    }

    /**
     * Set flighthterminal
     *
     * @param string $flighthterminal
     * @return OrangeFlight
     */
    public function setFlighthterminal($flighthterminal)
    {
        $this->flighthterminal = $flighthterminal;
    
        return $this;
    }

    /**
     * Get flighthterminal
     *
     * @return string 
     */
    public function getFlighthterminal()
    {
        return $this->flighthterminal;
    }

    /**
     * Set flightterminal
     *
     * @param string $flightterminal
     * @return OrangeFlight
     */
    public function setFlightterminal($flightterminal)
    {
        $this->flightterminal = $flightterminal;
    
        return $this;
    }

    /**
     * Get flightterminal
     *
     * @return string 
     */
    public function getFlightterminal()
    {
        return $this->flightterminal;
    }

    /**
     * Set stopflag
     *
     * @param integer $stopflag
     * @return OrangeFlight
     */
    public function setStopflag($stopflag)
    {
        $this->stopflag = $stopflag;
    
        return $this;
    }

    /**
     * Get stopflag
     *
     * @return integer 
     */
    public function getStopflag()
    {
        return $this->stopflag;
    }

    /**
     * Set shareflag
     *
     * @param integer $shareflag
     * @return OrangeFlight
     */
    public function setShareflag($shareflag)
    {
        $this->shareflag = $shareflag;
    
        return $this;
    }

    /**
     * Get shareflag
     *
     * @return integer 
     */
    public function getShareflag()
    {
        return $this->shareflag;
    }

    /**
     * Set legflag
     *
     * @param integer $legflag
     * @return OrangeFlight
     */
    public function setLegflag($legflag)
    {
        $this->legflag = $legflag;
    
        return $this;
    }

    /**
     * Get legflag
     *
     * @return integer 
     */
    public function getLegflag()
    {
        return $this->legflag;
    }

    /**
     * Set flightdep
     *
     * @param string $flightdep
     * @return OrangeFlight
     */
    public function setFlightdep($flightdep)
    {
        $this->flightdep = $flightdep;
    
        return $this;
    }

    /**
     * Get flightdep
     *
     * @return string 
     */
    public function getFlightdep()
    {
        return $this->flightdep;
    }

    /**
     * Set flightarr
     *
     * @param string $flightarr
     * @return OrangeFlight
     */
    public function setFlightarr($flightarr)
    {
        $this->flightarr = $flightarr;
    
        return $this;
    }

    /**
     * Get flightarr
     *
     * @return string 
     */
    public function getFlightarr()
    {
        return $this->flightarr;
    }

    /**
     * Set flightdepairport
     *
     * @param string $flightdepairport
     * @return OrangeFlight
     */
    public function setFlightdepairport($flightdepairport)
    {
        $this->flightdepairport = $flightdepairport;
    
        return $this;
    }

    /**
     * Get flightdepairport
     *
     * @return string 
     */
    public function getFlightdepairport()
    {
        return $this->flightdepairport;
    }

    /**
     * Set flightarrairport
     *
     * @param string $flightarrairport
     * @return OrangeFlight
     */
    public function setFlightarrairport($flightarrairport)
    {
        $this->flightarrairport = $flightarrairport;
    
        return $this;
    }

    /**
     * Get flightarrairport
     *
     * @return string 
     */
    public function getFlightarrairport()
    {
        return $this->flightarrairport;
    }

    /**
     * Set fjson
     *
     * @param string $fjson
     * @return OrangeFlight
     */
    public function setFjson($fjson)
    {
        $this->fjson = $fjson;
    
        return $this;
    }

    /**
     * Get fjson
     *
     * @return string 
     */
    public function getFjson()
    {
        return $this->fjson;
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
     * Set distance
     *
     * @param int $distance
     * @return OrangeFlight
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;
    
        return $this;
    }

    /**
     * Get distance
     *
     * @return int 
     */
    public function getDistance()
    {
        return $this->distance;
    }
}
