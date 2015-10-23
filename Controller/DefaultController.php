<?php

namespace Rth\MotorbikeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('RthMotorbikeBundle:Default:index.html.twig', array('name' => $name));
    }
}
