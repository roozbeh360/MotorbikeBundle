<?php

namespace Rth\MotorbikeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Rth\MotorbikeBundle\Entity\Motorbike;
use Rth\MotorbikeBundle\Form\MotorbikeType;

class AdminController extends Controller
{

    
    /**
     * @Route("/admin/motorbike/new", name="rth_motorbike_motorbike_new")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction(Request $request)
    {
        $motorbike = new Motorbike();
        $form = $this->createForm(new MotorbikeType(), $motorbike);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $file = $motorbike->getImage();
            $imagesPath = $this->uploader($file);
            $motorbike->setImage($imagesPath);
            $motorbike->setCreated(new \DateTime('now'));
            $this->saveEntity($motorbike);
            $this->flashMessage('message.motorbike_successfuly_added');
            return $this->redirect($this->generateUrl('rth_motorbike_motorbike_list'));
        }

        return $this->render('RthMotorbikeBundle:Admin:Motorbike/new.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/admin/motorbike", name="rth_motorbike_motorbike_list")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function listAction()
    {
        $motorBikes = $this->getDoctrine()->getRepository('RthMotorbikeBundle:Motorbike')->findAll();
        return $this->render('RthMotorbikeBundle:Admin:Motorbike/list.html.twig', array(
                    'motorBikes' => $motorBikes,
        ));
    }
    
    /**
     * @Route("/admin/motorbike/remove/{id}", name="rth_motorbike_motorbike_remove")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function removeAction($id)
    {
        $motorBike = $this->getDoctrine()->getRepository('RthMotorbikeBundle:Motorbike')->find($id);
        
        if($motorBike)
        {
            $imagePack = $motorBike->getImage();
            $this->removeDirectory($imagePack['dir']);
            $this->removeEntity($motorBike);
            $this->flashMessage('message.motorbike_removed_successfuly');
        }
        
        
        return $this->redirect($this->generateUrl('rth_motorbike_motorbike_list'));
    }

    private function uploader($file)
    {
        $imageUploader = $this->get('rth_motorbike.image.uploader');
        return $imageUploader->uploadImage($file);
    }
    
    private function removeDirectory($dir)
    {
        $imageUploader = $this->get('rth_motorbike.image.uploader');
        $imageUploader->removeDirectory($dir);
    }

    private function flashMessage($message)
    {
        $this->get('session')->getFlashBag()->add('rth_motorbike_admin', $message);
    }

    private function saveEntity($entity)
    {
        $this->getDoctrine()->getManager()->persist($entity);
        $this->getDoctrine()->getManager()->flush();        
    }

    private function removeEntity($entity)
    {
        $this->getDoctrine()->getManager()->remove($entity);
        $this->getDoctrine()->getManager()->flush();  
    }
}
