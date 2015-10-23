<?php

namespace Rth\MotorbikeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Rth\MotorbikeBundle\Form\MotorbikeFilterType;
use Rth\MotorbikeBundle\Model\FilterModel;

class DefaultController extends Controller
{

    /**
     * @Route("/motorbike", name="rth_motorbike_motorbike_index")
     */
    public function indexAction()
    {
        
        $config = $this->getParameter('rth_motorbike.config');
        $filterModel = new FilterModel($this->getDoctrine()->getManager(), $this->getRequest(), $config['default']['filters']);
        $filterFields = $filterModel->filterFields();
        $dql = "SELECT a FROM RthMotorbikeBundle:Motorbike a".$filterModel->filterQueryBuilder();
        $query = $this->getDoctrine()->getManager()->createQuery($dql);
        $paginator = $this->get('knp_paginator');
        $motorBikes = $paginator->paginate(
                $query, $this->getRequest()->query->getInt('page', 1), $config['default']['motorbikes_per_page']
        );

        return $this->render('RthMotorbikeBundle:Default:Motorbike/list.html.twig', array('motorBikes' => $motorBikes,'filterFields'=>$filterFields));
    }

    /**
     * @Route("/motorbike/{id}/{make}/{model}", name="rth_motorbike_motorbike_show")
     */
    public function showAction($id, $make, $model)
    {
        $motorBike = $this->getDoctrine()->getRepository('RthMotorbikeBundle:Motorbike')->find($id);

        if (!$motorBike) {
            throw new \Symfony\Component\Translation\Exception\NotFoundResourceException();
        }
        return $this->render('RthMotorbikeBundle:Default:Motorbike/show.html.twig', array('motorBike' => $motorBike));
    }

}
