<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContenuNewsletterRepository")
 * @ORM\Table(name="contenu_newsletter")
 */
class ContenuNewsletter
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"newsletter_list"})
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(type="string", nullable=false)
     * @Groups({"newsletter_list"})
     */
    private $nom;

    /**
     * @var Newsletter
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="Newsletter", inversedBy="contenus")
     * @ORM\JoinColumn(name="newsletter_id", referencedColumnName="id", nullable=false)
     */
    private $newsletter;

    /**
     * @var \DateTime
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateModification;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(type="text", nullable=false)
     */
    private $contenuHTML;

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
     * @return \DateTime
     */
    public function getDateModification()
    {
        return $this->dateModification;
    }

    /**
     * @param \DateTime $dateModification
     */
    public function setDateModification($dateModification)
    {
        $this->dateModification = $dateModification;
    }

    /**
     * @return string
     */
    public function getContenuHTML()
    {
        return $this->contenuHTML;
    }

    /**
     * @param string $contenuHTML
     */
    public function setContenuHTML($contenuHTML)
    {
        $this->contenuHTML = $contenuHTML;
    }
}