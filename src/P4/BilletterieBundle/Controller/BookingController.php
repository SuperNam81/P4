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
		// Appel du service AgePrixVisitor pour avoir le prix par visiteur
		$prixVisitor = $this->container->get('p4_billetterie.ageprix_visitor')->recupPrixVisitor($booking, $listVisitors);
		// Appel du service AgePrixVisitor pour avoir le prix total
		$prixTotal = $this->container->get('p4_billetterie.ageprix_visitor')->recupPrixTotal($booking, $listVisitors);

		return $this->render('P4BilletterieBundle:Booking:recap.html.twig', array(
		  'booking' => $booking,
		  'listVisitors' => $listVisitors,
		));
	}

	// Ancienne version 
	/*
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
		// Calcul par visiteur de l'age et du prix, et pour finir du prix total
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
	*/

	public function checkoutAction($id, Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		// Récupération de la réservation
		$booking = $em->getRepository('P4BilletterieBundle:Booking')->find($id);
		// Récupération des visiteurs liés à la réservation
		$listVisitors = $em
		->getRepository('P4BilletterieBundle:Visitor')
		->findBy(array('booking' => $booking))
		;
		// Appel du service AgePrixVisitor pour avoir le prix par visiteur
		$prixVisitor = $this->container->get('p4_billetterie.ageprix_visitor')->recupPrixVisitor($booking, $listVisitors);
		// Appel du service AgePrixVisitor pour avoir le prix total
		$prixTotal = $this->container->get('p4_billetterie.ageprix_visitor')->recupPrixTotal($booking, $listVisitors);
		// Set your secret key: remember to change this to your live secret key in production
		// See your keys here: https://dashboard.stripe.com/account/apikeys
		\Stripe\Stripe::setApiKey("sk_test_MX1BiA6JRM66T4WLZob5fFIa");
		// Token is created using Checkout or Elements!
		// Get the payment token ID submitted by the form:
		$token = $_POST['stripeToken'];

		try {
			$customer = \Stripe\Customer::create(array (
				"source" => $token,
			));
			// Charge the user's card:
			$charge = \Stripe\Charge::create(array(
			  "amount" => $booking->prixTotal * 100,
			  "currency" => "eur",
			  "description" => "Example charge",
			  "customer" => $customer,
			));
			// Message de succés pour le paiement
			$session = $request->getSession();   
    		$session->getFlashBag()->add('info', 'Votre paiement a été validé ! Vous allez recevoir un mail de confirmation. Merci et à bientôt.');
    		// Redirection payment
			return $this->redirectToRoute('p4_billetterie_payment', array('id' => $booking->getId()));
    	} catch(\Stripe\Error\Card $e) {
    		// Message en cas d'echec
			$session->getFlashBag()->add('info', 'Paiement refusé');
			return $this->redirectToRoute('p4_billetterie_payment', array('id' => $booking->getId()));
		}
	}

    public function paymentAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
		// Récupération de la réservation
		$booking = $em->getRepository('P4BilletterieBundle:Booking')->find($id);
		$listVisitors = $em
		->getRepository('P4BilletterieBundle:Visitor')
		->findBy(array('booking' => $booking))
		;
		$prixVisitor = $this->container->get('p4_billetterie.ageprix_visitor')->recupPrixVisitor($booking, $listVisitors);
		// Appel du service AgePrixVisitor pour avoir le prix total
		$prixTotal = $this->container->get('p4_billetterie.ageprix_visitor')->recupPrixTotal($booking, $listVisitors);

		
		// $mailer = $booking->email;
	    $message = (new \Swift_Message('Le Louvre – Confirmation de votre réservation'))
	        ->setFrom('spidernam75@gmail.com')
	        ->setTo('nam7519@gmail.com')
	        ->setBody(
	            $this->renderView(
	                'P4BilletterieBundle:Booking:recapMail.html.twig', array(
	            			'booking' => $booking,
	            			'listVisitors' => $listVisitors,
	            		)
	            ),
	            'text/html'
	        );

	    // $mailer->send($message);

	    // or, you can also fetch the mailer service this way
	    $this->get('mailer')->send($message);

	    return $this->render('P4BilletterieBundle:Booking:payment.html.twig');
    } 

	// PAYMENT ACTION II
  //   public function paymentAction($id, Request $request)
  //   {
  //   	$em = $this->getDoctrine()->getManager();
		// // Récupération de la réservation
		// $booking = $em->getRepository('P4BilletterieBundle:Booking')->find($id);

		// $mail = $booking->getEmail();
		// $envoiMail = $this->container->get('p4_billetterie.email.recap_mailer')->sendRecap($mail);

  //   	return $this->render('P4BilletterieBundle:Booking:payment.html.twig');
  //   } 

	/* PAYMENT ACTION I
    public function paymentAction()
    {
    	return $this->render('P4BilletterieBundle:Booking:payment.html.twig');
    } 
	*/

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
}
