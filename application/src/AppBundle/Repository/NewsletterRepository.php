<?php
namespace AppBundle\Repository;

use AppBundle\AppBundle;
use AppBundle\Entity\ContenuNewsletter;
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Collections\ArrayCollection;

class NewsletterRepository extends EntityRepository
{
    public function getAllLast() {
        $em = $this->getEntityManager();

        $q = $em->createQueryBuilder();
        $q->select('n')
            ->from('AppBundle:Newsletter', 'n')
            ->leftJoin('n.contenus', 'c')
            ->orderBy('c.id');
        $newsletters = $q->getQuery()->getResult();

        return $this->keepLastContenus($newsletters);
    }

    public function getLast($id) {
        $em = $this->getEntityManager();

        $q = $em->createQueryBuilder();
        $q->select('n')
            ->from('AppBundle:Newsletter', 'n')
            ->leftJoin('n.contenus', 'c')
            ->where('n.id = :id')
            ->orderBy('c.id')
            ->setParameter('id', $id);
        $newsletters = $q->getQuery()->getResult();

        return $this->keepLastContenus($newsletters);
    }

    private function keepLastContenus($newsletters) {
        foreach($newsletters as $n) {
            $contenuLight = new ArrayCollection();
            $contenuLight->add($n->getContenus()[$n->getContenus()->count() - 1]);
            $n->setContenus($contenuLight);
        }

        return $newsletters;
    }

    public function getNewsletterNotInCampagne()
    {
        $em = $this->getEntityManager();

        $q = $em->createQueryBuilder()
            ->select('n')
            ->from('AppBundle:Newsletter', 'n')
            ->leftJoin('n.campagne', 'c')
            ->having('COUNT(c.id) = 0')
            ->groupBy('n.id');

        $newsletters = $q->getQuery()->getResult();

        return $this->keepLastContenus($newsletters);
    }
}