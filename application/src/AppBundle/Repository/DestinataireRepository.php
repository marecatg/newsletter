<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Destinataire;

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

    /**
     * @param $destinataires array
     * @return boolean
     */
    public function destinatairesNExistePas($destinataires)
    {
        $em = $this->getEntityManager();

        $qb = $em->createQueryBuilder()
            ->select('d')
            ->from('AppBundle:Destinataire', 'd');

        foreach ($destinataires as $id => $destinataire)
        {
            $qb->orWhere($qb->expr()->andX(
                $qb->expr()->eq('d.nom', ":nom_".$id),
                $qb->expr()->eq('d.prenom', ":prenom_".$id),
                $qb->expr()->eq('d.email', ":email_".$id)
            ));
            $qb->setParameter("nom_".$id, $destinataire->getNom())
                ->setParameter("prenom_".$id, $destinataire->getPrenom())
                ->setParameter("email_".$id, $destinataire->getEmail());
        }

        $nbResult = count($qb->getQuery()->getResult());

        return $nbResult === 0;
    }
}