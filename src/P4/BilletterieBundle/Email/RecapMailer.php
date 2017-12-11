<?php
// src/P4/BilletterieBundle/Email/RecapMailer.php

namespace P4\BilletterieBundle\Email;

use Doctrine\ORM\EntityManagerInterface;
use P4\BilletterieBundle\Entity\Booking;
use P4\BilletterieBundle\Entity\Visitor;

class RecapMailer
{
  /**
   * @var \Swift_Mailer
   */
  private $mailer;

  public function __construct(\Swift_Mailer $mailer)
  {
    $this->mailer = $mailer;
  }

  // public function sendRecap($booking, $listVisitors)
  // {  
  //   $message = new \Swift_Message(
  //     'Nouvelle candidature',
  //     'Vous avez reçu une nouvelle candidature.'
  //   );

  //   $message
  //     ->addTo($application->getAdvert()->getAuthor()) // Ici bien sûr il faudrait un attribut "email", j'utilise "author" à la place
  //     ->addFrom('admin@votresite.com')
  //   ;

  //   $this->mailer->send($message);
  // }

  public function sendRecap($mail)
  {  
    $message = (new \Swift_Message('Le Louvre – Confirmation de votre réservation'))
        // ->setFrom('admin@site.com')
        ->setTo('nam7519@gmail.com')
        // ->setBody(
        //     $this->renderView(
        //         // templates/emails/registration.html.twig
        //         'P4BilletterieBundle:Booking:recap.html.twig',
        //         array('booking' => $booking)
        //     ),
        //     'text/html'
        // );

    $mailer->send($message);

    // return $this->render('P4BilletterieBundle:Booking:payment.html.twig');
  }
}
