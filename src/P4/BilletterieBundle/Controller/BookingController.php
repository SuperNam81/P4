<?php

namespace P4\BilletterieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use P4\BilletterieBundle\Entity\Booking;
use P4\BilletterieBundle\Form\BookingType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BookingController extends Controller
{
    public function indexAction(Request $request)
    {
	    /*$booking = new Booking();
	    $form   = $this->createForm(BookingType::class, $booking);

	    if ($request->isMethod('POST')) 
	    {
	      $em = $this->getDoctrine()->getManager();
	      $em->persist($booking);
	      $em->flush();

	      $request->getSession()->getFlashBag()->add('notice', 'Réservation bien enregistrée.');
	    }*/

	    /*return $this->render('P4BilletterieBundle:Booking:index.html.twig', array(
	      'form' => $form->createView(),
	    ));  */
	    return $this->render('P4BilletterieBundle:Booking:index.html.twig');      
    }
}
