<?php

namespace App\Entity;

use App\Repository\OeuvreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OeuvreRepository::class)]
class Oeuvre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    #[ORM\Column(nullable: true)]
    private ?int $annee = null;

    /**
     * @var Collection<int, Auteur>
     */
    #[ORM\ManyToMany(targetEntity: Auteur::class, inversedBy: 'oeuvres')]
    private Collection $auteurs;

    /**
     * @var Collection<int, Edition>
     */
    #[ORM\ManyToMany(targetEntity: Edition::class, inversedBy: 'oeuvres')]
    private Collection $editions;

    #[ORM\ManyToOne(inversedBy: 'oeuvres')]
    private ?TypeOeuvre $type = null;

    #[ORM\ManyToOne(inversedBy: 'oeuvres')]
    private ?Serie $serie = null;

    #[ORM\ManyToOne(inversedBy: 'oeuvres')]
    private ?Lieu $lieu = null;

    public function __construct()
    {
        $this->auteurs = new ArrayCollection();
        $this->editions = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->titre ?? 'Nouvelle œuvre';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;
        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): static
    {
        $this->photo = $photo;
        return $this;
    }

    public function getAnnee(): ?int
    {
        return $this->annee;
    }

    public function setAnnee(?int $annee): static
    {
        $this->annee = $annee;
        return $this;
    }

    /**
     * @return Collection<int, Auteur>
     */
    public function getAuteurs(): Collection
    {
        return $this->auteurs;
    }

    public function addAuteur(Auteur $auteur): static
    {
        if (!$this->auteurs->contains($auteur)) {
            $this->auteurs->add($auteur);
        }
        return $this;
    }

    public function removeAuteur(Auteur $auteur): static
    {
        $this->auteurs->removeElement($auteur);
        return $this;
    }

    /**
     * @return Collection<int, Edition>
     */
    public function getEditions(): Collection
    {
        return $this->editions;
    }

    public function addEdition(Edition $edition): static
    {
        if (!$this->editions->contains($edition)) {
            $this->editions->add($edition);
        }
        return $this;
    }

    public function removeEdition(Edition $edition): static
    {
        $this->editions->removeElement($edition);
        return $this;
    }

    public function getType(): ?TypeOeuvre
    {
        return $this->type;
    }

    public function setType(?TypeOeuvre $type): static
    {
        $this->type = $type;
        return $this;
    }

    public function getSerie(): ?Serie
    {
        return $this->serie;
    }

    public function setSerie(?Serie $serie): static
    {
        $this->serie = $serie;
        return $this;
    }

    public function getLieu(): ?Lieu
    {
        return $this->lieu;
    }

    public function setLieu(?Lieu $lieu): static
    {
        $this->lieu = $lieu;
        return $this;
    }
}