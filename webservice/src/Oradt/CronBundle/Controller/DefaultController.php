<?php

namespace Oradt\CronBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('OradtCronBundle:Default:index.html.twig', array('name' => $name));
    }
}
