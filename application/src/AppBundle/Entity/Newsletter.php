<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Application\FOS\UserBundle\Entity\User;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NewsletterRepository")
 * @ORM\Table(name="newsletter")
 */
class Newsletter
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     * @Assert\NotBlank()
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateProchainEnvoi;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(type="string", columnDefinition="ENUM('jour', 'semaine', 'mois', 'annee')", nullable=false)
     */
    private $periodiciteUnite;

    /**
     * @var integer
     * @Assert\NotBlank()
     * @ORM\Column(type="integer", nullable=false)
     */
    private $periodiciteValeur;

    /**
     * @var User
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="Application\FOS\UserBundle\Entity\User", inversedBy="newsletters")
     * @ORM\JoinColumn(name="createur_id", referencedColumnName="id", nullable=false)
     */
    private $createur;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="ContenuNewsletter", mappedBy="newsletter")
     */
    private $contenus;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Inscription", mappedBy="newsletter")
     */
    private $inscriptions;

    /**
     * @var Campagne
     * @ORM\ManyToOne(targetEntity="Campagne", inversedBy="newsletters")
     * @ORM\JoinColumn(name="campagne_id", referencedColumnName="id", nullable=true)
     */
    private $campagne;
}