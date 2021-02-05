<?php

namespace App\Entity;

use App\Repository\VoitureRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VoitureRepository::class)
 */
class Voiture
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20, unique=true)
     */
    private $Matricule;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $Marque;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $Couleur;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $Carburant;

    /**
     * @ORM\Column(type="integer")
     */
    private $places;

    /**
     * @ORM\Column(type="string", length=300)
     */
    private $Description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Disponibilite;

    /**
     * @ORM\Column(type="date")
     */
    private $datemiseencirculation;

    /**
     * @ORM\Column(type="string")
     */
    private $idAgence;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function __toString()
    {
        return $this->Matricule;
    }
    public function getMatricule(): ?string
    {
        return $this->Matricule;
    }

    public function setMatricule(string $Matricule): self
    {
        $this->Matricule = $Matricule;

        return $this;
    }

    public function getMarque(): ?string
    {
        return $this->Marque;
    }

    public function setMarque(string $Marque): self
    {
        $this->Marque = $Marque;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->Couleur;
    }

    public function setCouleur(string $Couleur): self
    {
        $this->Couleur = $Couleur;

        return $this;
    }

    public function getCarburant(): ?string
    {
        return $this->Carburant;
    }

    public function setCarburant(string $Carburant): self
    {
        $this->Carburant = $Carburant;

        return $this;
    }

    public function getPlaces(): ?int
    {
        return $this->places;
    }

    public function setPlaces(int $places): self
    {
        $this->places = $places;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getDisponibilite(): ?bool
    {
        return $this->Disponibilite;
    }

    public function setDisponibilite(bool $Disponibilite): self
    {
        $this->Disponibilite = $Disponibilite;

        return $this;
    }

    public function getDatemiseencirculation(): ?\DateTimeInterface
    {
        return $this->datemiseencirculation;
    }

    public function setDatemiseencirculation(\DateTimeInterface $datemiseencirculation): self
    {
        $this->datemiseencirculation = $datemiseencirculation;

        return $this;
    }

    public function getIdAgence(): ?string
    {
        return $this->idAgence;
    }

    public function setIdAgence(string $idAgence): self
    {
        $this->idAgence = $idAgence;

        return $this;
    }
}
