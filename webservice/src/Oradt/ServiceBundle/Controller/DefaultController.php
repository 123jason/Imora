<?php

namespace Oradt\ServiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('OradtServiceBundle:Default:index.html.twig', array('name' => $name));
    }
}
