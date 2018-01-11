<?php
namespace Oradt\OauthBundle\EventListener;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class ControllerListener
{
    
    public function __construct($entityManager)
    {
        echo __FILE__;
    }

    public function onKernelController(FilterResponseEvent $event)
    {
        echo "\r\n" . __FUNCTION__ . "\r\n";
        //print_r($event->getRequest());
        //if (HttpKernelInterface::MASTER_REQUEST === $event->getRequestType()) {
           
           // $this->extension->setController($event->getController());
       // }
    }
}
