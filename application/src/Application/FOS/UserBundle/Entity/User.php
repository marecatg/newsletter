<?php

namespace Application\FOS\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Entity\User as FOSUser;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Newsletter;

/**
 * @ORM\Entity
 * @ORM\Table(name="utilisateur")
 */
class User extends FOSUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Newsletter", mappedBy="createur")
     */
    private $newsletters;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(type="string", nullable=false)
     */
    private $nom;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(type="string", nullable=false)
     */
    private $prenom;

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
    public function getNewsletters()
    {
        return $this->newsletters;
    }

    /**
     * @param Newsletter $newsletters
     */
    public function setNewsletters($newsletters)
    {
        $this->newsletters = $newsletters;
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
