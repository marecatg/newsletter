<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

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
     * @Groups({"liste_info"})
     */
    private $id;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Destinataire", mappedBy="listesDiffusion")
     * @Groups({})
     */
    private $destinataires;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(type="string", nullable=false)
     * @Groups({"liste_info"})
     */
    private $nom;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return ArrayCollection
     */
    public function getDestinataires()
    {
        return $this->destinataires;
    }

    /**
     * @param ArrayCollection $destinataires
     */
    public function setDestinataires($destinataires)
    {
        $this->destinataires = $destinataires;
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
}