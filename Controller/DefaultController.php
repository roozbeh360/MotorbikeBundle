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
        $config = $this->getParameter('rth_motorbike.config');
        $dql   = "SELECT a FROM RthMotorbikeBundle:Motorbike a";
        $query = $this->getDoctrine()->getManager()->createQuery($dql);
        $paginator  = $this->get('knp_paginator');
        $motorBikes = $paginator->paginate(
                $query,
                $this->getRequest()->query->getInt('page', 1),
                $config['default']['motorbikes_per_page']
        );
    
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
