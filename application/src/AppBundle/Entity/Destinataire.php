<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DestinataireRepository")
 * @ORM\Table(name="destinataire")
 * @JMS\ExclusionPolicy("all")
 */
class Destinataire
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(type="string", nullable=false)
     * @Expose
     */
    private $email;

    /**
     * @var boolean
     * @Assert\NotBlank()
     * @ORM\Column(type="boolean", nullable=false)
     * @Expose
     */
    private $actif = true;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Inscription", mappedBy="destinataire")
     */
    private $inscriptions;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="ListeDiffusion", inversedBy="destinataires")
     * @ORM\JoinTable(name="destinataire_liste_diffusion")
     */
    private $listesDiffusion;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return boolean
     */
    public function isActif()
    {
        return $this->actif;
    }

    /**
     * @param boolean $actif
     */
    public function setActif($actif)
    {
        $this->actif = $actif;
    }

    /**
     * @return ArrayCollection
     */
    public function getInscriptions()
    {
        return $this->inscriptions;
    }

    /**
     * @param ArrayCollection $inscriptions
     */
    public function setInscriptions($inscriptions)
    {
        $this->inscriptions = $inscriptions;
    }

    /**
     * @return mixed
     */
    public function getListesDiffusion()
    {
        return $this->listesDiffusion;
    }

    /**
     * @param mixed $listesDiffusion
     */
    public function setListesDiffusion($listesDiffusion)
    {
        $this->listesDiffusion = $listesDiffusion;
    }
}