<?php

namespace App\Entity;

use App\Repository\AuteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuteurRepository::class)]
class Auteur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomoupseudo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prenom = null;

    #[ORM\ManyToOne(inversedBy: 'auteurs')]
    private ?TypeAuteur $type = null;

    /**
     * @var Collection<int, Oeuvre>
     */
    #[ORM\ManyToMany(targetEntity: Oeuvre::class, mappedBy: 'auteurs')]
    private Collection $oeuvres;

    public function __construct()
    {
        $this->oeuvres = new ArrayCollection();
    }

    public function __toString()
    {
        return (($this->prenom == '')||($this->prenom == NULL)) ? $this->nomoupseudo : $this->nomoupseudo . ' ' . $this->prenom;
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomoupseudo(): ?string
    {
        return $this->nomoupseudo;
    }

    public function setNomoupseudo(string $nomoupseudo): static
    {
        $this->nomoupseudo = $nomoupseudo;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getType(): ?TypeAuteur
    {
        return $this->type;
    }

    public function setType(?TypeAuteur $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, Oeuvre>
     */
    public function getOeuvres(): Collection
    {
        return $this->oeuvres;
    }

    public function addOeuvre(Oeuvre $oeuvre): static
    {
        if (!$this->oeuvres->contains($oeuvre)) {
            $this->oeuvres->add($oeuvre);
            $oeuvre->addAuteur($this);
        }

        return $this;
    }

    public function removeOeuvre(Oeuvre $oeuvre): static
    {
        if ($this->oeuvres->removeElement($oeuvre)) {
            $oeuvre->removeAuteur($this);
        }

        return $this;
    }
}
