<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ListeDiffusionRepository")
 * @ORM\Table(name="liste_diffusion")
 */
class ListeDiffusion
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Destinataire", mappedBy="listesDissusion")
     */
    private $destinataires;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private $nom;
}