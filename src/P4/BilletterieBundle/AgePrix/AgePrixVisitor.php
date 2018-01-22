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

  public function recupPrixTotal($prixVisitor, $listVisitors)
  { 
    $prixTotal = '';
    foreach ($listVisitors as $visitor) {
      $prixTotal += $visitor->prix;
    }
    return $prixTotal;    
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
    // $today = date_format($today, 'd/m/Y');

    $bookingTime = new \DateTime('now');
    $bookingTime = date_format($bookingTime, 'H:i');

    $quatorzeHeure = date('14:00');

    // $format = 'dd/mm/yyyy';
    // $bookingDateNoString = \DateTime::createFromFormat($format, $bookingDate);
    // $bookingDateNoString = \DateTime::createFromFormat('dd/mm/yyyy', $bookingDate);
    // $bookingDateNoString = \DateTime::createFromFormat($bookingDate, 'dd/mm/yy');

    $bookingDateNoString = date_create_from_format('d/m/Y', $bookingDate);

    // $bookingDateNoString = date_create_from_format($bookingDate, 'd-m-Y');

    // $bookingDateNoString = strtotime($bookingDate);

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

    if ($today == $bookingDateNoString) {
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

  /*
  public function prixCalcul($age, $discount, $ticket)
  { 
    $prix = '';

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
    if ($ticket == 0) {
      return $prix/2;
    }
    return $prix;
  }
  */ 
}
