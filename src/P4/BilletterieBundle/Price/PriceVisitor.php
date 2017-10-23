<?php
// src/P4/BilletterieBundle/Price/PriceVisitor.php

namespace P4\BilletterieBundle\Price;

use Doctrine\ORM\EntityManagerInterface;

class PriceVisitor
{
  /**
   * @var EntityManagerInterface
   */
  private $em;

  public function __construct(EntityManagerInterface $em)
  {
    $this->em = $em;
  }

  public function price($age)
  {
    /*$advertRepository      = $this->em->getRepository('OCPlatformBundle:Advert');
    $advertSkillRepository = $this->em->getRepository('OCPlatformBundle:AdvertSkill');

    $date = new \Datetime($days.' days ago');

    $listAdverts = $advertRepository->getAdvertsPurge($date);

    foreach ($listAdverts as $advert) {
      $advertSkills = $advertSkillRepository->findBy(array('advert' => $advert));

      foreach ($advertSkills as $advertSkill) {
        $this->em->remove($advertSkill);
      }
      $this->em->remove($advert);
    }
    $this->em->flush();*/
  }  
}
