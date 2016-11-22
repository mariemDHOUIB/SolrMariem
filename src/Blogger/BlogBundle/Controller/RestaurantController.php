<?php
/**
 * Created by PhpStorm.
 * User: mariem
 * Date: 01/08/16
 * Time: 18:46
 */
namespace Blogger\BlogBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Blogger\BlogBundle\Entity\Restaurant;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
// Import new namespaces
//use Blogger\BlogBundle\Entity\Enquiry;
use Blogger\BlogBundle\Form\EnquiryType;

class RestaurantController extends Controller {

    public function createRestaurantAction(Request $request) {
        $form = $this->createFormBuilder(new Restaurant())
            ->add('nomRestaurant')
            ->add('ville')
            ->add('plats')
            ->add('submit','submit')
             ->getForm();

        $form->handleRequest($request);

        if( $request->isMethod('post') && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData());
            $em->flush();
        }
        return $this->render('BloggerBlogBundle:Page:create.html.twig',array('form'=> $form->createView()));
    }




}
