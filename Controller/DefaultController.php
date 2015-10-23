<?php

namespace Rth\MotorbikeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/motorbike", name="rth_motorbike_motorbike_index")
     */
    public function indexAction()
    {
        $motorBikes = $this->getDoctrine()->getRepository('RthMotorbikeBundle:Motorbike')->findAll();
        return $this->render('RthMotorbikeBundle:Default:Motorbike/list.html.twig', array('motorBikes' => $motorBikes));
    }
    
    /**
     * @Route("/motorbike/{id}/{make}/{model}", name="rth_motorbike_motorbike_show")
     */
    public function showAction($id,$make,$model)
    {
        $motorBike = $this->getDoctrine()->getRepository('RthMotorbikeBundle:Motorbike')->find($id);
        
        if(!$motorBike)
        {
            throw new \Symfony\Component\Translation\Exception\NotFoundResourceException();
        }
        return $this->render('RthMotorbikeBundle:Default:Motorbike/show.html.twig', array('motorBike' => $motorBike));
    }
    
}
