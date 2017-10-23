<?php
// src/P4/BilletterieBundle/Age/AgeVisitor.php

namespace P4\BilletterieBundle\Age;

use Doctrine\ORM\EntityManagerInterface;

class AgeVisitor
{
  /**
   * @var EntityManagerInterface
   */
  private $em;

  public function __construct(EntityManagerInterface $em)
  {
    $this->em = $em;
  }

  public function age($days)
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
