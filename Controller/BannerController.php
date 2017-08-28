<?php

namespace BviBannerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BviBannerBundle\Form\BannerForm;
use BviBannerBundle\Entity\Banner;
use DateTime;

/**
 * Class Banner
 */
class BannerController extends Controller
{
    /**
     * 
     * @param Request $request
     * @return Response
     */
    
    public function indexAction(Request $request) {
        
        $lstObj = $this->prepareListObj($request);
        $lstObj->setTemplate('BviBannerBundle:AjaxPagination:ajax_pagination.html.twig');
        
        if ($request->isXmlHttpRequest()) {
            
            $listView          =  $this->renderView('BviBannerBundle:Banner:_list.html.twig',array('lstObj' => $lstObj));
            $output['success'] = true;
            $output['listView']= $listView;
            $response = new Response(json_encode($output));
            return $response;
            
        }else{
            return $this->render('BviBannerBundle:Banner:index.html.twig',array('lstObj' => $lstObj));
        }
        
    }
    
    
    /**
     * 
     * @param Request $request
     * @return type
     */
    public function prepareListObj(Request $request) {
        
        $em        = $this->getDoctrine()->getManager();
        $params    = $this->get('request')->request->all();
        
        $qry       = $em->getRepository('BviBannerBundle:Banner')->getList($params);

        $itmPerPge = 20;
        // Creating pagnination
        $pagination = $this->get('knp_paginator')->paginate(
                $qry, $this->get('request')->query->get('page', 1), $itmPerPge
        );
        
        return $pagination;
    }
    
    //add banner page
    
    public function newAction(Request $request) {
        
        $objBanner = new Banner();
        $form = $this->createForm(new BannerForm(), $objBanner);
        
        if ($request->getMethod() == "POST") {

            $form->handleRequest($request);

            if ($form->isValid()) {
                
                //CALLING UPLOAD FUNCITON FROM ENTITY TO UPLOAD IMAGE
                $objBanner->upload();
                
                $objBanner->setCreatedat(new DateTime());
                $user = $this->get('security.context')->getToken()->getUser();
                if (is_object($user)) {
                    $objBanner->setCreatedby($user->getId());
                }else{
                    $objBanner->setCreatedby(1);
                }
                $em = $this->getDoctrine()->getManager();
                $em->persist($objBanner);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', "New banner uploaded successfully.");
                return $this->redirect($this->generateUrl('bvi_banner_list'));
            }
        }
        
        return $this->render('BviBannerBundle:Banner:new.html.twig', array(
                    'form' => $form->createView()
        ));
    }
    
    //edit banner page
    
    public function editAction(Request $request,$id = '') {
        
        $em = $this->getDoctrine()->getManager();
        $objBanner = $em->getRepository('BviBannerBundle:Banner')->find($id);
        
        if (!$objBanner) {

            $this->get('session')->getFlashBag()->add('failure', "Banner Page does not exist.");
            return $this->redirect($this->generateUrl('bvi_banner_list'));
        }
        $form = $this->createForm(new BannerForm(), $objBanner);

        if ($request->getMethod() == "POST") {

            $form->handleRequest($request);

            if ($form->isValid()) {
                //CALLING UPLOAD FUNCITON FROM ENTITY TO UPLOAD IMAGE
                $objBanner->upload();
                
                $objBanner->setUpdatedat(new DateTime());
                $user = $this->get('security.context')->getToken()->getUser();
                if (is_object($user)) {
                    $objBanner->setUpdatedby($user->getId());
                }
                $em->persist($objBanner);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', "Record has been updated successfully.");
                return $this->redirect($this->generateUrl('bvi_banner_list'));
            }
        }
        return $this->render('BviBannerBundle:Banner:edit.html.twig', array(
                    'form' => $form->createView(),'objBanner' => $objBanner
        ));
    }
    
    //update status of banner page
    
    public function updateStatusAction(Request $request) {
        
        $em     = $this->getDoctrine()->getManager();
        $id     = $request->get('id');
        $objBanner = $em->getRepository('BviBannerBundle:Banner')->find($id);
        $success= false;
        
        if (is_object($objBanner)) {
            
            $status = $objBanner->getStatus() == 'Active' ? 'Inactive' : 'Active';
            $objBanner->setStatus($status);
            $objBanner->setUpdatedat(new DateTime());
            $user = $this->get('security.context')->getToken()->getUser();
            if (is_object($user)) {
                $objBanner->setUpdatedby($user->getId());
            }
            $em->persist($objBanner);
            $em->flush();
            $success = true;
        }
        
        $output['success'] = $success;
        $output['msg']     = 'Record updated successfully';
        $response          = new Response(json_encode($output));
        return $response;
    }    
}
