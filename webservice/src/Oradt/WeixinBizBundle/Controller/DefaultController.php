<?php

namespace Oradt\WeixinBizBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('OradtWeixinBizBundle:Default:index.html.twig', array('name' => $name));
    }
}
