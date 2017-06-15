<?php

namespace AppBundle\Entity;

use AppBundle\Model\PeriodiciteUnite;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Application\FOS\UserBundle\Entity\User;
use JMS\Serializer\Annotation\Groups;

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
     * @Groups({"newsletter_list", "newsletter_last_contenu", "all_inscriptions"})
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(type="string", nullable=false)
     * @Groups({"newsletter_list", "newsletter_last_contenu"})
     */
    private $nom;

    /**
     * @var \DateTime
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"newsletter_last_contenu"})
     */
    private $dateProchainEnvoi;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Groups({"newsletter_last_contenu"})
     * @ORM\Column(type="string", columnDefinition="ENUM('jour', 'semaine', 'mois', 'annee')", nullable=false)
     */
    private $periodiciteUnite;

    /**
     * @var integer
     * @Assert\NotBlank()
     * @Groups({"newsletter_last_contenu"})
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
     * @ORM\OneToMany(targetEntity="ContenuNewsletter", mappedBy="newsletter", cascade={"persist", "remove"})
     * @Groups({"newsletter_last_contenu"})
     */
    private $contenus;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Inscription", mappedBy="newsletter", cascade={"remove", "persist"})
     */
    private $inscriptions;

    /**
     * @var Campagne
     * @ORM\ManyToOne(targetEntity="Campagne", inversedBy="newsletters")
     * @ORM\JoinColumn(name="campagne_id", referencedColumnName="id", nullable=true)
     */
    private $campagne;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * @return \DateTime
     */
    public function getDateProchainEnvoi()
    {
        return $this->dateProchainEnvoi;
    }

    /**
     * @param \DateTime $dateProchainEnvoi
     */
    public function setDateProchainEnvoi($dateProchainEnvoi)
    {
        $this->dateProchainEnvoi = $dateProchainEnvoi;
    }

    /**
     * @return string
     */
    public function getPeriodiciteUnite()
    {
        return $this->periodiciteUnite;
    }

    /**
     * @param string $periodiciteUnite
     */
    public function setPeriodiciteUnite($periodiciteUnite)
    {
        $this->periodiciteUnite = $periodiciteUnite;
    }

    /**
     * @return int
     */
    public function getPeriodiciteValeur()
    {
        return $this->periodiciteValeur;
    }

    /**
     * @param int $periodiciteValeur
     */
    public function setPeriodiciteValeur($periodiciteValeur)
    {
        $this->periodiciteValeur = $periodiciteValeur;
    }

    /**
     * @return User
     */
    public function getCreateur()
    {
        return $this->createur;
    }

    /**
     * @param User $createur
     */
    public function setCreateur($createur)
    {
        $this->createur = $createur;
    }

    /**
     * @return ArrayCollection
     */
    public function getContenus()
    {
        return $this->contenus;
    }

    /**
     * @param ArrayCollection $contenus
     */
    public function setContenus($contenus)
    {
        $this->contenus = $contenus;
    }

    /**
     * @return ArrayCollection
     */
    public function getInscriptions()
    {
        return $this->inscriptions;
    }

    /**
     * @param array $inscriptions
     */
    public function setInscriptions($inscriptions)
    {
        $this->inscriptions = $inscriptions;
    }

    /**
     * @return Campagne
     */
    public function getCampagne()
    {
        return $this->campagne;
    }

    /**
     * @param Campagne $campagne
     */
    public function setCampagne($campagne)
    {
        $this->campagne = $campagne;
    }

    public function incrementeDateEnvoi() {

        $date = $this->dateProchainEnvoi->format('Y-m-d');
        switch($this->periodiciteUnite) {
            case PeriodiciteUnite::JOUR:
                $date = date('Y-m-d', strtotime($date . ' + '. $this->periodiciteValeur . ' days'));
                break;
            case PeriodiciteUnite::SEMAINE:
                $date = date('Y-m-d', strtotime($date . ' + '. $this->periodiciteValeur . ' weeks'));
                break;
            case PeriodiciteUnite::MOIS:
                $date = date('Y-m-d', strtotime($date . ' + '. $this->periodiciteValeur . ' months'));
                break;
            case PeriodiciteUnite::ANNEE:
                $date = date('Y-m-d', strtotime($date . ' + '. $this->periodiciteValeur . ' years'));
                break;
        }

        $this->dateProchainEnvoi = new \DateTime($date);

        return true;
    }

    /**
     * @param $date \DateTime
     * @return false|string
     */
    public function prochaineDateEnvoi(\DateTime $date) {

        $date = $date->format('Y-m-d');
        switch($this->periodiciteUnite) {
            case PeriodiciteUnite::JOUR:
                $date = date('Y-m-d', strtotime($date . ' + '. $this->periodiciteValeur . ' days'));
                break;
            case PeriodiciteUnite::SEMAINE:
                $date = date('Y-m-d', strtotime($date . ' + '. $this->periodiciteValeur . ' weeks'));
                break;
            case PeriodiciteUnite::MOIS:
                $date = date('Y-m-d', strtotime($date . ' + '. $this->periodiciteValeur . ' months'));
                break;
            case PeriodiciteUnite::ANNEE:
                $date = date('Y-m-d', strtotime($date . ' + '. $this->periodiciteValeur . ' years'));
                break;
        }

        return new \DateTime($date);
    }
}