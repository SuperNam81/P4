<?php
// src/P4/BilletterieBundle/Age/AgeVisitor.php

namespace P4\BilletterieBundle\Age;

use Doctrine\ORM\EntityManagerInterface;

class AgeVisitor
{
  /* Avec DateBirth en dur dans le Controleur
  public function ageCalcul($dateBirth)
  {  
    $date = new \DateTime(); // date actuelle
    $age = $date->diff($dateBirth, true)->y;
    return $age;
  }
  */

  /* Avec un tableau de DateBirth */
  public function ageCalcul($dateBirth)
  {  
    $date1 = new \DateTime(); // date actuelle
    foreach ($dateBirth as $dob => $date2) {
      $age = $date1->diff($date2, true)->y;
      return $age;
    }
  }  

}
