<?php

namespace Oradt\ServiceBundle\Services;
use Doctrine\ORM\EntityManager;
/**
 */
class ParserVcardService
{

    private $em;
    private $logger;
    private $container;

    /**
     * __construct
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager, $logger, $container)
    {
        $this->em = $entityManager;
        $this->logger = $logger;
        $this->container = $container;
    }

    public function parserVcard()
    {

        $fileImcService = $this->container->get('file_imc_service');
        $parse = $fileImcService->parse('vCard');
        $cardinfo = $parse->fromFile('D:/sample.vcf');
        print_r($cardinfo);
        exit;
    }

}

?>
