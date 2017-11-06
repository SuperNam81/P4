<?php
// src/P4/BilletterieBundle/Age/AgeVisitor.php

namespace P4\BilletterieBundle\Age;

use Doctrine\ORM\EntityManagerInterface;

class AgeVisitor
{
  public function age($dateBirth)
  {  
    $date = new \DateTime(); // date actuelle
    $age = $date->diff($dateBirth, true)->y;
    return $age;
  }

  public function prixCalcul($age, $discount, $ticket)
  {  

  }  
}
