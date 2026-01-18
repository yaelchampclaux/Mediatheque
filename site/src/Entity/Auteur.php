<?php

namespace App\Entity;

use App\Repository\AuteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AuteurRepository::class)]
class Auteur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le nom ou pseudonyme est requis')]
    private ?string $nomoupseudo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prenom = null;

    #[ORM\ManyToOne(inversedBy: 'auteurs')]
    #[ORM\JoinColumn(onDelete: 'SET NULL')]
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

    public function __toString(): string
    {
        if (empty($this->prenom)) {
            return $this->nomoupseudo ?? 'Auteur inconnu';
        }
        return $this->prenom . ' ' . $this->nomoupseudo;
    }
    
    public function getNomComplet(): string
    {
        return $this->__toString();
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