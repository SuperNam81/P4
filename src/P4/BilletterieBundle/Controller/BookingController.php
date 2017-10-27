<?php

namespace P4\BilletterieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use P4\BilletterieBundle\Entity\Booking;
use P4\BilletterieBundle\Form\BookingType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use P4\BilletterieBundle\Entity\Test;
use P4\BilletterieBundle\Form\TestType;

class BookingController extends Controller
{
	public function indexAction(Request $request)
	{
		$booking = new Booking();
		$form = $this->createForm(BookingType::class, $booking);

		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())  
		{
			$em = $this->getDoctrine()->getManager();
			$em->persist($booking);
			$em->flush();

			$request->getSession()->getFlashBag()->add('notice', 'Réservation bien enregistrée.');

			return $this->redirectToRoute('p4_billetterie_homepage');
		}

		return $this->render('P4BilletterieBundle:Booking:index.html.twig', array(
			'form' => $form->createView(),
		));
	}

	public function testAction(Request $request)
	{
		$test = new Test();
		$form   = $this->createForm(TestType::class, $test);

		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) 
		{
			$em = $this->getDoctrine()->getManager();
			$em->persist($test);
			$em->flush();

			$request->getSession()->getFlashBag()->add('notice', 'Email bien enregistré.');
		}

		return $this->render('P4BilletterieBundle:Booking:test.html.twig', array(
			'form' => $form->createView(),
		));        
	}    
}
