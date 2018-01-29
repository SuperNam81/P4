<?php
// src/P4/BilletterieBundle/AgePrix/AgePrixVisitor.php

namespace P4\BilletterieBundle\AgePrix;

use Doctrine\ORM\EntityManagerInterface;
use P4\BilletterieBundle\Entity\Booking;
use P4\BilletterieBundle\Entity\Visitor;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class AgePrixVisitor
{
  private $tarifgratuit;
  private $tarifenfant;
  private $tarifnormal;
  private $tarifsenior;
  private $tarifpreferentiel;

  public function __construct($tarifgratuit, $tarifenfant, $tarifnormal, $tarifsenior, $tarifpreferentiel)
  {
    $this->tarifgratuit = $tarifgratuit;
    $this->tarifenfant = $tarifenfant;
    $this->tarifnormal = $tarifnormal;
    $this->tarifsenior = $tarifsenior;
    $this->tarifpreferentiel = $tarifpreferentiel;
  }

  public function recupPrixVisitor($bookingDate, $ticket, $listVisitors)
  {  
    // Calcul par visiteur de l'age et donc du prix
    foreach ($listVisitors as $visitor) {
      $visitor->age = $this->ageCalcul($visitor->getDateBirth());
      $visitor->prix = $this->prixCalcul($visitor->age, $visitor->getDiscount(), $bookingDate, $ticket);
    }
  }

  public function ageCalcul($dateBirth)
  {  
    $date = new \DateTime();
    $age = $date->diff($dateBirth, true)->y;
    return $age;
  }

  public function prixCalcul($age, $discount, $bookingDate, $ticket)
  { 
    $prix = '';

    $today = new \DateTime();

    $bookingTime = new \DateTime('now');
    $bookingTime = date_format($bookingTime, 'H:i');

    $quatorzeHeure = date('14:00');
    // Date de résa en format date
    $bookingDateNoString = date_create_from_format('d/m/Y', $bookingDate);

    if ($age >= 0 && $age < 4) {
      $prix = $this->tarifgratuit;
    } elseif ($age >= 4 && $age < 12) {
      $prix = $this->tarifenfant;
    } elseif ($age >= 12 && $age < 60) {
      $prix = $this->tarifnormal;
    } elseif ($age >= 60) {
      $prix = $this->tarifsenior;
    }
    if ($discount == 1) {
      return $prix = $this->tarifpreferentiel;
    }
    // Si la date de résa est aujourd'hui même
    if ($today == $bookingDateNoString) {
      // Si il est 14h00 passé
      if ($bookingTime > $quatorzeHeure) {
        $ticket == 0;
        return $prix/2;
      }
    }
    elseif ($ticket == 0) {
      return $prix/2;
    }
    
    return $prix;
  }
  
  // Prix total
  public function recupPrixTotal($prixVisitor, $listVisitors)
  { 
    $prixTotal = '';
    foreach ($listVisitors as $visitor) {
      $prixTotal += $visitor->prix;
    }
    return $prixTotal;    
  }     
}
