<?php
// src/P4/BilletterieBundle/Age/AgeVisitor.php

namespace P4\BilletterieBundle\Age;

use Doctrine\ORM\EntityManagerInterface;

class AgeVisitor
{
  private $tarifgratuit;
  private $tarifenfant;
  private $tarifnormal;
  private $tarifsenior;

  public function __construct($tarifgratuit, $tarifenfant, $tarifnormal, $tarifsenior)
  {
    $this->tarifgratuit    = $tarifgratuit;
    $this->tarifenfant    = $tarifenfant;
    $this->tarifnormal    = $tarifnormal;
    $this->tarifsenior    = $tarifsenior;
  }

  public function age($dateBirth)
  {  
    $date = new \DateTime(); // date actuelle
    $age = $date->diff($dateBirth, true)->y;
    return $age;
  }

  public function prixCalcul($age)
  { 
    $prix = '';

    if ($age >= 0 && $age <= 4) {
      $prix = $this->tarifgratuit;
    } elseif ($age > 4 && $age <= 12) {
      $prix = $this->tarifenfant;
    } elseif ($age > 12 && $age < 60) {
      $prix = $this->tarifnormal;
    } elseif ($age >= 60) {
      $prix = $this->tarifsenior;
    }
    return $prix;
  } 
}
