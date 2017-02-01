<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

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
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(type="string", nullable=false)
     */
    private $email;

    /**
     * @var boolean
     * @Assert\NotBlank()
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $actif = true;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Inscription", mappedBy="destinataire")
     */
    private $inscriptions;
}