<?php

namespace Oradt\StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('OradtStoreBundle:Default:index.html.twig', array('name' => $name));
    }
}
