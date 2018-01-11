<?php

namespace Oradt\ServiceBundle\Services;

use Doctrine\ORM\EntityManager;
use Oradt\StoreBundle\Entity\ApiStatistic;
use Oradt\Utils\RandomString;
use Oradt\Utils\Codes;
use PDO;

class ApiStatisticService {
	private $em;
	private $container;
	
	/**
	 * __construct
	 *
	 * @param EntityManager $entityManager        	
	 */
	public function __construct(EntityManager $entityManager, $container) {
		$this->em = $entityManager;
		$this->container = $container;
	}
	public function updateReference($apiname, $method) {
		$dtime = new \DateTime ();
		$timestamp = $dtime->getTimestamp ();
		$dtime->setTimestamp ( $timestamp - $timestamp % (60 * 60) );
		// $datetime = $dtime->format ( 'Y-m-d H:i:s' );
		
		$entity = $this->em->getRepository ( 'OradtStoreBundle:ApiStatistic' )->findOneBy ( array (
				'dateTime' => $dtime,
				'apiName' => $apiname,
				'method' => $method 
		) );
		
		if (empty ( $entity )) {
			$entity = new ApiStatistic ();
			$random = new RandomString ();
			$uuid = $random->make ( 32 );
			$entity->setUuid ( $uuid );
			$entity->setDateTime ( $dtime );
			$entity->setApiName ( $apiname );
			$entity->setMethod ( $method );
			$entity->setCallTimes ( 1 );
		} else {
			$entity->setCallTimes ( $entity->getCallTimes () + 1 );
		}
		
		$this->em->persist ( $entity );
		$this->em->flush ();
	}
}

?>