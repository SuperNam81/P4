<?php
// src/P4/BilletterieBundle/EventListener/dateBirthListener.php

namespace P4\BilletterieBundle\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpFoundation\Request;

class dateBirthListener
{
  // Notre processeur
  protected $ageVisitor;


  public function __construct(AgeVisitor $ageVisitor)
  {
    $this->ageVisitor = $ageVisitor;
  }

  /*/ L'argument de la méthode est un FilterResponseEvent
  public function processBeta(FilterResponseEvent $event)
  {
    // On teste si la requête est bien la requête principale (et non une sous-requête)
    if (!$event->isMasterRequest()) {
      return;
    }

    $remainingDays = $this->endDate->diff(new \Datetime())->days;

    // Si la date est dépassée, on ne fait rien
    if ($remainingDays <= 0) {
      return;
    }

    // On utilise notre BetaHRML
    $response = $this->betaHTML->addBeta($event->getResponse(), $remainingDays);
    
    // On met à jour la réponse avec la nouvelle valeur
    $event->setResponse($response);
  }*/
}