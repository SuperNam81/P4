<?php

namespace P4\BilletterieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use P4\BilletterieBundle\Entity\Booking;
use P4\BilletterieBundle\Form\BookingType;
use P4\BilletterieBundle\Entity\Visitor;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use P4\BilletterieBundle\Entity\Test;
use P4\BilletterieBundle\Form\TestType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

			return $this->redirectToRoute('p4_billetterie_recap', array('id' => $booking->getId()));
		}

		return $this->render('P4BilletterieBundle:Booking:index.html.twig', array(
			'form' => $form->createView(),
		));
	}
	
	public function recapAction($id, Booking $booking)
	{
		$em = $this->getDoctrine()->getManager();

		$booking = $em->getRepository('P4BilletterieBundle:Booking')->find($id);

		$listVisitors = $em
		->getRepository('P4BilletterieBundle:Visitor')
		->findBy(array('booking' => $booking))
		;
		
		foreach ($listVisitors as $visitor) {
			$visitor->age = $this->container->get('p4_billetterie.age_visitor')->age($visitor->getDateBirth());
			$visitor->prix = $this->container->get('p4_billetterie.age_visitor')->prixCalcul($visitor->age, $visitor->getDiscount(), $booking->ticket);
			$booking->prixTotal += $visitor->prix;
		}

		return $this->render('P4BilletterieBundle:Booking:recap.html.twig', array(
		  'booking' => $booking,
		  'listVisitors' => $listVisitors,
		));
	}

	/* Avec un tableau de DateBirth */
 	public function testAction($id, Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$booking = $em->getRepository('P4BilletterieBundle:Booking')->find($id);
		$listVisitors = $em
		->getRepository('P4BilletterieBundle:Visitor')
		->findBy(array('booking' => $booking))
		;	

		foreach ($listVisitors as $visitor) {
			$visitor->age = $this->container->get('p4_billetterie.age_visitor')->age($visitor->getDateBirth());
		}

		return $this->render('P4BilletterieBundle:Booking:test.html.twig', array(
		  'booking' => $booking,
		  'listVisitors' => $listVisitors,
		));
	} 
}
