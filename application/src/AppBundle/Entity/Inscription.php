<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InscriptionRepository")
 * @ORM\Table(name="inscription")
 */
class Inscription
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Newsletter
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="Newsletter", inversedBy="inscriptions")
     * @ORM\JoinColumn(name="newsletter_id", referencedColumnName="id", nullable=false)
     */
    private $newsletter;

    /**
     * @var Destinataire
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="Destinataire", inversedBy="inscriptions")
     * @ORM\JoinColumn(name="destinataire_id", referencedColumnName="id", nullable=false)
     */
    private $destinataire;

    /**
     * @var Campagne
     * @ORM\Column(name="campagne_source", type="integer", nullable=true)
     */
    private $campagneSource;

    /**
     * @var ListeDiffusion
     * @ORM\Column(name="liste_diffusion_source", type="integer", nullable=true)
     */
    private $listeDiffusionSource;

}