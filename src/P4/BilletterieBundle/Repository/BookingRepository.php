<?php

namespace P4\BilletterieBundle\Repository;

/**
 * BookingRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BookingRepository extends \Doctrine\ORM\EntityRepository
{
	/*public function getDateBirth()
	{
		$qb = $this->createQueryBuilder('v');

		// On peut ajouter ce qu'on veut avant
		$qb
		->where('a.author = :author')
		->setParameter('author', 'Marine')
		;

		// On applique notre condition sur le QueryBuilder
		$this->whereCurrentYear($qb);

		// On peut ajouter ce qu'on veut après
		$qb->orderBy('a.date', 'DESC');

		return $qb
		->getQuery()
		->getResult()
		;
	}*/
}
