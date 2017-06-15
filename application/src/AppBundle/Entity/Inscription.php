<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

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
     * @Groups({"all_inscriptions"})
     */
    private $id;

    /**
     * @var Newsletter
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="Newsletter", inversedBy="inscriptions")
     * @ORM\JoinColumn(name="newsletter_id", referencedColumnName="id", nullable=false)
     * @Groups({"all_inscriptions"})
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
     * @Groups({"all_inscriptions"})
     */
    private $listeDiffusionSource;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Newsletter
     */
    public function getNewsletter()
    {
        return $this->newsletter;
    }

    /**
     * @param Newsletter $newsletter
     */
    public function setNewsletter($newsletter)
    {
        $this->newsletter = $newsletter;
    }

    /**
     * @return Destinataire
     */
    public function getDestinataire()
    {
        return $this->destinataire;
    }

    /**
     * @param Destinataire $destinataire
     */
    public function setDestinataire($destinataire)
    {
        $this->destinataire = $destinataire;
    }

    /**
     * @return Campagne
     */
    public function getCampagneSource()
    {
        return $this->campagneSource;
    }

    /**
     * @param Campagne $campagneSource
     */
    public function setCampagneSource($campagneSource)
    {
        $this->campagneSource = $campagneSource;
    }

    /**
     * @return ListeDiffusion
     */
    public function getListeDiffusionSource()
    {
        return $this->listeDiffusionSource;
    }

    /**
     * @param ListeDiffusion $listeDiffusionSource
     */
    public function setListeDiffusionSource($listeDiffusionSource)
    {
        $this->listeDiffusionSource = $listeDiffusionSource;
    }

}