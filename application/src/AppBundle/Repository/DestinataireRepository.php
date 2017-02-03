<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class DestinataireRepository extends EntityRepository
{
    public function getDestinataireNotInListeDiffusion()
    {
        $em = $this->getEntityManager();

        $q = $em->createQueryBuilder()
            ->select('d')
            ->from('AppBundle:Destinataire', 'd')
            ->leftJoin('d.listesDiffusion', 'ld')
            ->having('COUNT(ld.id) = 0')
            ->groupBy('d.id');

        return $q->getQuery()->getResult();
    }
}