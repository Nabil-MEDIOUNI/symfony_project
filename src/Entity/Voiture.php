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
     * @ORM\Column(type="string", length=20)
     */
    private $Matricule;

    /**
     * @ORM\Column(type="string", length=15, unique=true)
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
    private $NbrPlace;

    /**
     * @ORM\Column(type="string", length=300)
     */
    private $Description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Disponibite;

    /**
     * @ORM\Column(type="date")
     */
    private $datemiseencirculation;

    /**
     * @ORM\Column(type="integer")
     */
    private $idAgence;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNbrPlace(): ?int
    {
        return $this->NbrPlace;
    }

    public function setNbrPlace(int $NbrPlace): self
    {
        $this->NbrPlace = $NbrPlace;

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

    public function getDisponibite(): ?bool
    {
        return $this->Disponibite;
    }

    public function setDisponibite(bool $Disponibite): self
    {
        $this->Disponibite = $Disponibite;

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

    public function getIdAgence(): ?int
    {
        return $this->idAgence;
    }

    public function setIdAgence(int $idAgence): self
    {
        $this->idAgence = $idAgence;

        return $this;
    }
}
