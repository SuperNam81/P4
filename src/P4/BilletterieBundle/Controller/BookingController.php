<?php

namespace P4\BilletterieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use P4\BilletterieBundle\Entity\Booking;
use P4\BilletterieBundle\Form\BookingType;
use P4\BilletterieBundle\Entity\Visitor;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use P4\BilletterieBundle\Entity\Test;
use P4\BilletterieBundle\Form\TestType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Query\ResultSetMappingBuilder;


class BookingController extends Controller
{
	public function indexAction(Request $request)
	{
		$booking = new Booking();
		$form = $this->createForm(BookingType::class, $booking);

		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())  
		{
			$em = $this->getDoctrine()->getManager();
			$em->persist($booking);
			$em->flush();
			// Après enregistrement en bdd, récapitulatif
			return $this->redirectToRoute('p4_billetterie_recap', array('id' => $booking->getId()));
		}
		// Récupération des dates où le nombre de visiteur > 5
		$em = $this->getDoctrine()->getManager();
		$dateVisitorMax = $em->getRepository('P4BilletterieBundle:Visitor')->getDateVisitorMaxArray();	

		return $this->render('P4BilletterieBundle:Booking:index.html.twig', array(
			'form' => $form->createView(),
			'dateVisitorMax' => $dateVisitorMax,
		));
	}
	
	public function recapAction($id, Booking $booking)
	{
		$em = $this->getDoctrine()->getManager();
		// Récupération de la réservation
		$booking = $em->getRepository('P4BilletterieBundle:Booking')->find($id);
		// Récupération des visiteurs liés à la réservation
		$listVisitors = $em
		->getRepository('P4BilletterieBundle:Visitor')
		->findBy(array('booking' => $booking))
		;
		// Calcul de l'age, du prix par visiteur et du prix total
		foreach ($listVisitors as $visitor) {
			$visitor->age = $this->container->get('p4_billetterie.ageprix_visitor')->ageCalcul($visitor->getDateBirth());
			$visitor->prix = $this->container->get('p4_billetterie.ageprix_visitor')->prixCalcul($visitor->age, $visitor->getDiscount(), $booking->ticket);
			$booking->prixTotal += $visitor->prix;
		}
		return $this->render('P4BilletterieBundle:Booking:recap.html.twig', array(
		  'booking' => $booking,
		  'listVisitors' => $listVisitors,
		));
	}

 	public function testAction(Request $request)
	{
		$booking = new Booking();
		$form = $this->createForm(BookingType::class, $booking);

		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())  
		{
			$em = $this->getDoctrine()->getManager();
			$em->persist($booking);
			$em->flush();
			return $this->redirectToRoute('p4_billetterie_recap', array('id' => $booking->getId()));
		}	

		/*	I */
		// $rsm = new ResultSetMappingBuilder($this->_em);
		// $rsm->addRootEntityFromClassMetadata('P4\BilletterieBundle\Entity\Visitor', 'v');
		// $rsm->addJoinedEntityFromClassMetadata('P4\BilletterieBundle\Entity\Booking', 'b');

		// $sql = 'SELECT COUNT(v.booking_id) AS nbrVisiteurParBooking, b.bookingDate FROM p4_visitor AS v INNER JOIN p4_booking AS b ON v.booking_id = b.id GROUP BY b.bookingDate HAVING nbrVisiteurParBooking >= 5';
		 
		// $query = $this->_em->createNativeQuery($sql, $rsm);
		// //$query->setParameter(':userId', $_userId);
		// return $query->getScalarResult();
			

		/* II */
		// init vars
		// $where = '';
		// $parameters = array();

		// // tout d'abords, nous créons le builder pour mapper les résultats en entités doctrine compréhensible :
		// $rsm = new ResultSetMappingBuilder($this->_em);
		// $rsm->addRootEntityFromClassMetadata('My\UserBundle\Entity\User', 'u'); // on définie l'entité de base qui apparaîtra dans le FROM
		// $rsm->addScalarResult('compatibility', 'compatibility'); // on déclare notre champ personnalisé
		// $rsm->addJoinedEntityFromClassMetadata('My\UserBundle\Entity\Keyword', 'kComp', 'u', 'keywords', array(
		// 'id' => 'kCompid',
		// 'title' => 'kComptitle',
		// )); // et enfin, on ajoute les relations que l'on désire récupérer. Notez qu'il faut obligatoirement renommer manuellement les champs qui ont le même nom que ceux que l'on pourrait trouver dans l'entité principale, ici "id" et "title".

		// // maintenant, nous allons définir des conditions manuellement
		// if ($_search->getTitle() !== null) {
		// $where .= ' AND u.title = :title';
		// $parameters['title'] = $_search->getTitle();
		// }

		// // On rédige la requête en sql. On insère l'objet de mapping des résultat en tant que select et les conditions WHERE. Remarquez qu'on peut maintenant tout à fait écraser les jointures et en créer plusieurs.
		// $sql = 'SELECT ' . $rsm . ', SUM(CASE WHEN kComp.slug = kSearch.slug THEN 1 ELSE 0 END) as compatibility
		// FROM `fos_user` u
		// LEFT JOIN keyword kSearch ON kSearch.user_id = :userId
		// LEFT JOIN keyword kComp ON kComp.user_id = u.id AND kComp.slug = kSearch.slug
		// WHERE u.id <> :userId ' . $where . '
		// GROUP BY u.id
		// ORDER BY u.last_activity ASC'
		// ;

		// // Il ne reste plus qu'à créer l'objet de requête native et à lui passer les paramètres qu'on a défini plus haut.
		// $query = $this->_em->createNativeQuery($sql, $rsm);
		// $query->setParameters($parameters);
		// $query->setParameter('userId', $_search->getUser()->getId());
		

		/* III */
		$em = $this->getDoctrine()->getManager();
		$dateVisitorMax = $em->getRepository('P4BilletterieBundle:Visitor')->getDateVisitorMaxArray();	


		/* IV */
		// $rsm = new ResultSetMappingBuilder($this->getEntityManager());

		// $rsm->addRootEntityFromClassMetadata('Reh:File', 'd', array('id' => 'fileID'));
		// //Jointures
		// $rsm->addJoinedEntityFromClassMetadata('Reh:FileStage', 'de', 'd', "stages", array("id" => "fileStageID"));
		// $rsm->addJoinedEntityFromClassMetadata('Reh:FileStageStatus', 'e', "de", "status", array("id" => "fileStageStatusID"));
		// $rsm->addJoinedEntityFromClassMetadata('Reh:FileStatus', 'fs', "d", "status", array("id" => "fileStageStatusID"));
		// //SQL
		// $sql = "SELECT *, d.id as fileID, e.id as fileStageStatusID,de.id as fileStageID,
		// ifnull(d.delai_reflexion, DATE_ADD(de.date, INTERVAL e.delai DAY)) as echeance
		// from dossier d
		// inner join etape_dossier de on de.id_dossier = d.id
		// inner join etape e on de.id_etape = e.id
		// inner join
		// where d.id_coordinateur = :userID
		// and d.statut != :status
		// group by d.id
		// order by echeance DESC";
		// //Exécution
		// $query = $this->_em->createNativeQuery($sql, $rsm);
		// $query->setParameter("userID", $userID);
		// $query->setParameter("status", File::STATUS_ARCHIVED);
		// $result = $query->getResult();
		

		/* V */
		//$em = $this->getDoctrine()->getManager()
		// $rsm = new ResultSetMappingBuilder($this->getDoctrine()->getManager());

		// $rsm->addRootEntityFromClassMetadata('P4\BilletterieBundle\Entity\Visitor', 'v', array('id' => 'id1',));

		// $rsm->addJoinedEntityFromClassMetadata('P4\BilletterieBundle\Entity\Booking', 'b', 'v', 'id', array('id' => 'id2',));

		// $sql = 'SELECT COUNT(v.booking_id) AS nbrVisiteurParBooking, b.bookingDate FROM p4_visitor AS v INNER JOIN p4_booking AS b ON v.booking_id = b.id GROUP BY b.bookingDate HAVING nbrVisiteurParBooking >= 5';
		
		// $query = $this->getDoctrine()->getManager()->createNativeQuery($sql, $rsm);
		// return $query->getScalarResult();
		//$dateVisitorMax = $query->getScalarResult();
			


		return $this->render('P4BilletterieBundle:Booking:test.html.twig', array(
			'form' => $form->createView(),
			'dateVisitorMax' => $dateVisitorMax,
		));
	} 
}
