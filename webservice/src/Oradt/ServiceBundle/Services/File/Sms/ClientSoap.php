<?php
$wsdlUrl    = $this->wsdlUrl;
$location   = $this->location;
$connectTimeOut = $this->connectTimeOut;
$trace      = TRUE;
$this->SoapClient  = new SoapClient($wsdlUrl,
        array('trace'=>$trace,'location'=> $location,'connection_timeout'=>$connectTimeOut));


