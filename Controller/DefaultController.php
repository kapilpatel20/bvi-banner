<?php

namespace BviBannerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BviBannerBundle:Default:index.html.twig');
    }
}
