<?php
// src/P4/BilletterieBundle/Age/AgeVisitor.php

namespace P4\BilletterieBundle\Age;

use Doctrine\ORM\EntityManagerInterface;

class AgeVisitor
{
  private $dateBirth;

  public function ageCalcul($dateBirth)
  {  
    $date1 = new \DateTime(); // date actuelle
    foreach ($dateBirth as $date2) {
      $age = $date1->diff($date2, true)->y; // le y = nombre d'années
      //return $age;     
    }
   
  }  
}
