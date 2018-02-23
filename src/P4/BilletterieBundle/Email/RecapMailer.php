<?php
// src/P4/BilletterieBundle/Email/RecapMailer.php

namespace P4\BilletterieBundle\Email;

use Doctrine\ORM\EntityManagerInterface;
use P4\BilletterieBundle\Entity\Booking;
use P4\BilletterieBundle\Entity\Visitor;
use Symfony\Component\HttpFoundation\Request;

class RecapMailer
{
  /**
   * @var \Swift_Mailer
   */
  private $mailer;
  private $templating;

  public function __construct(\Swift_Mailer $mailer, $templating)
  {
    $this->mailer = $mailer;
    $this->templating = $templating;
  }

  public function sendRecap($id, $bookingDate, $listVisitors, $email, $ticket, $prixTotal, $currentLocale)
  {  
    // Si FR
    if ($currentLocale == 'fr') {    
      $message = (new \Swift_Message('Musée du Louvre – Confirmation de votre réservation'))
        ->setFrom('louvre.ocp4@gmail.com')
        ->setTo($email)
        ->setBody(
          $this->templating->render(
            'P4BilletterieBundle:Booking:recapMail.html.twig', array(
              'id' => $id,
              'bookingDate' => $bookingDate,
              'listVisitors' => $listVisitors,
              'email' => $email,
              'ticket' => $ticket,
              'prixTotal' => $prixTotal,
            )
          ),
          'text/html'
        );
      $this->mailer->send($message);
    }
    // Si EN
    elseif ($currentLocale == 'en') {
      $message = (new \Swift_Message('Louvre Museum – Confirmation of your reservation'))
        ->setFrom('louvre.ocp4@gmail.com')
        ->setTo($email)
        ->setBody(
          $this->templating->render(
            'P4BilletterieBundle:Booking:recapMail.html.twig', array(
              'id' => $id,
              'bookingDate' => $bookingDate,
              'listVisitors' => $listVisitors,
              'email' => $email,
              'ticket' => $ticket,
              'prixTotal' => $prixTotal,
            )
          ),
          'text/html'
        );
      $this->mailer->send($message);
    }
  }
}

