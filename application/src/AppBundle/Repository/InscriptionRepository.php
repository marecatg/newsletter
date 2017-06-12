<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class InscriptionRepository extends EntityRepository
{

    public function getAllWithListeDiffusion()
    {

        $em = $this->getEntityManager();

        $q = $em->createQueryBuilder();
        $q->select('i.id as inscriptionId', 'n.id as newsletterId', 'i.listeDiffusionSource as idListeSource')
            ->from('AppBundle:Inscription', 'i')
            ->join('i.newsletter', 'n')
            ->where($q->expr()->isNotNull('i.listeDiffusionSource'))
            ->groupBy('n.id', 'i.listeDiffusionSource');

        return $q->getQuery()->getResult();
    }
}