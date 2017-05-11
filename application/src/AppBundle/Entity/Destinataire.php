<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use JMS\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DestinataireRepository")
 * @ORM\Table(name="destinataire")
 */
class Destinataire
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"destinataire"})
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(type="string", nullable=false)
     * @Groups({"destinataire"})
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Groups({"destinataire"})
     */
    private $nom;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Groups({"destinataire"})
     */
    private $prenom;

    /**
     * @var boolean
     * @Assert\NotBlank()
     * @ORM\Column(type="boolean", nullable=false)
     * @Groups({})
     */
    private $actif = true;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Inscription", mappedBy="destinataire")
     * @Groups({})
     */
    private $inscriptions;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="ListeDiffusion", mappedBy="destinataires", cascade={"persist"})
     * @ORM\JoinTable(name="destinataire_liste_diffusion")
     * @Groups({})
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

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }
}