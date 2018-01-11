<?php
namespace Oradt\ServiceBundle\Services;
use Oradt\StoreBundle\Entity\SystemCron;

class CronService
{
	private $em = null;
	
	public function __construct($entityManager)
	{
		$this->em = $entityManager;
	}
	
	public function saveJob(SystemCron $Job)
	{
		$this->em->persist($Job);
		$this->em->flush();
		
	}
	
	public function updateJob(SystemCron $Job)
	{
		$array = array('name' => $Job->getName());
		$syscron = $this->em->getRepository ( 'OradtStoreBundle:SystemCron' )->findOneBy( $array );
		if(empty($syscron))
		{
			//return false;
			self::saveJob($Job);
			return;
		}
		$syscron->setRunStamp($Job->getRunStamp());
		$this->em->persist ( $syscron );
		$this->em->flush ();
	}
	
	public function getJobs()
	{
		$repEntity = $this->em->getRepository('OradtStoreBundle:SystemCron');
		return $repEntity->findAll();
	}
}
