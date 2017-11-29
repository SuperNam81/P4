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
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


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
			// Après enregistrement en bdd, récapitulatif
			return $this->redirectToRoute('p4_billetterie_recap', array('id' => $booking->getId()));
		}
		// Récupération des dates où le nombre de visiteur > 5
		$em = $this->getDoctrine()->getManager();
		$dateVisitorMax = $em->getRepository('P4BilletterieBundle:Visitor')->getDateVisitorMaxArray();	

		return $this->render('P4BilletterieBundle:Booking:index.html.twig', array(
			'form' => $form->createView(),
			'dateVisitorMax' => $dateVisitorMax,
		));
	}
	
	public function recapAction($id, Booking $booking)
	{
		$em = $this->getDoctrine()->getManager();
		// Récupération de la réservation
		$booking = $em->getRepository('P4BilletterieBundle:Booking')->find($id);
		// Récupération des visiteurs liés à la réservation
		$listVisitors = $em
		->getRepository('P4BilletterieBundle:Visitor')
		->findBy(array('booking' => $booking))
		;
		// Calcul de l'age, du prix par visiteur et du prix total
		foreach ($listVisitors as $visitor) {
			$visitor->age = $this->container->get('p4_billetterie.ageprix_visitor')->ageCalcul($visitor->getDateBirth());
			$visitor->prix = $this->container->get('p4_billetterie.ageprix_visitor')->prixCalcul($visitor->age, $visitor->getDiscount(), $booking->ticket);
			$booking->prixTotal += $visitor->prix;
		}
		return $this->render('P4BilletterieBundle:Booking:recap.html.twig', array(
		  'booking' => $booking,
		  'listVisitors' => $listVisitors,
		));
	}

 	public function testAction(Request $request)
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
		
		/* III */
		$em = $this->getDoctrine()->getManager();
		$dateVisitorMax = $em->getRepository('P4BilletterieBundle:Visitor')->getDateVisitorMaxArray();				


		return $this->render('P4BilletterieBundle:Booking:test.html.twig', array(
			'form' => $form->createView(),
			'dateVisitorMax' => $dateVisitorMax,
		));
	}


    public function stripeAction()
    {
    	return $this->render('P4BilletterieBundle:Booking:stripe.html.twig');
    } 

	public function checkoutAction(Request $request)
	{
		// Set your secret key: remember to change this to your live secret key in production
		// See your keys here: https://dashboard.stripe.com/account/apikeys
		\Stripe\Stripe::setApiKey("sk_test_MX1BiA6JRM66T4WLZob5fFIa");

		// Token is created using Checkout or Elements!
		// Get the payment token ID submitted by the form:
		$token = $_POST['stripeToken'];

		try {
			$customer = \Stripe\Customer::create(array (
				// "email" => "bart@gmail.com",
				"source" => $token,
			));

			// Charge the user's card:
			$charge = \Stripe\Charge::create(array(
			  "amount" => 1000,
			  "currency" => "eur",
			  "description" => "Example charge",
			  "customer" => $customer,
			));
			$this->addFlash("success","Bravo ça marche !");
			return $this->redirectToRoute("p4_billetterie_recap");
    	} catch(\Stripe\Error\Card $e) {

			$this->addFlash("error","Snif ça marche pas :(");
			return $this->redirectToRoute("p4_billetterie_recap");
			// The card has been declined
		}
	}

	 // /**
  //    * @Route(
  //    *     "/checkout",
  //    *     name="p4_billetterie_checkout",
  //    *     methods="POST"
  //    * )
  //    */
  //   public function checkoutAction(Request $request)
  //   {
  //       \Stripe\Stripe::setApiKey("sk_test_MX1BiA6JRM66T4WLZob5fFIa");

  //       // Get the credit card details submitted by the form
  //       $token = $_POST['stripeToken'];

  //       // Create a charge: this will charge the user's card
  //       try {
  //           $charge = \Stripe\Charge::create(array(
  //               "amount" => 1000, // Amount in cents
  //               "currency" => "eur",
  //               "source" => $token,
  //               "description" => "Paiement Stripe - OpenClassrooms Exemple"
  //           ));
  //           $this->addFlash("success","Bravo ça marche !");
  //           return $this->redirectToRoute("order_prepare");
  //       } catch(\Stripe\Error\Card $e) {

  //           $this->addFlash("error","Snif ça marche pas :(");
  //           return $this->redirectToRoute("order_prepare");
  //           // The card has been declined
  //       }
  //   } 
}
