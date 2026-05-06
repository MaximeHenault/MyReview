<?php

namespace App\Entity;

use App\Repository\AudiovisuelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AudiovisuelRepository::class)]
class Audiovisuel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 70)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 80, nullable: true)]
    private ?string $realisateur = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $dateCreation = null;

    #[ORM\Column(nullable: true)]
    private ?int $duree = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $affiche = null;

    /**
     * @var Collection<int, Note>
     */
    #[ORM\OneToMany(targetEntity: Note::class, mappedBy: 'audiovisuel')]
    private Collection $notes;

    #[ORM\ManyToOne(inversedBy: 'audiovisuels')]
    private ?TypeAudiovisuel $typeAudiovisuel = null;

    /**
     * @var Collection<int, Saison>
     */
    #[ORM\OneToMany(targetEntity: Saison::class, mappedBy: 'audiovisuel', cascade: ['persist'], orphanRemoval: true)]
    private Collection $saisons;

    /**
     * @var Collection<int, AudiovisuelGenre>
     */
    #[ORM\OneToMany(targetEntity: AudiovisuelGenre::class, mappedBy: 'audiovisuel')]
    private Collection $audiovisuelGenres;

    public function __construct()
    {
        $this->notes = new ArrayCollection();
        $this->saisons = new ArrayCollection();
        $this->audiovisuelGenres = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getRealisateur(): ?string
    {
        return $this->realisateur;
    }

    public function setRealisateur(?string $realisateur): static
    {
        $this->realisateur = $realisateur;

        return $this;
    }

    public function getDateCreation(): ?\DateTime
    {
        return $this->dateCreation;
    }

    public function setDateCreation(?\DateTime $dateCreation): static
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(?int $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    public function getAffiche(): ?string
    {
        return $this->affiche;
    }

    public function setAffiche(?string $affiche): static
    {
        $this->affiche = $affiche;

        return $this;
    }

    /**
     * @return Collection<int, Note>
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): static
    {
        if (!$this->notes->contains($note)) {
            $this->notes->add($note);
            $note->setAudiovisuel($this);
        }

        return $this;
    }

    public function removeNote(Note $note): static
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getAudiovisuel() === $this) {
                $note->setAudiovisuel(null);
            }
        }

        return $this;
    }

    public function getTypeAudiovisuel(): ?TypeAudiovisuel
    {
        return $this->typeAudiovisuel;
    }

    public function setTypeAudiovisuel(?TypeAudiovisuel $typeAudiovisuel): static
    {
        $this->typeAudiovisuel = $typeAudiovisuel;

        return $this;
    }

    /**
     * @return Collection<int, Saison>
     */
    public function getSaisons(): Collection
    {
        return $this->saisons;
    }

    public function addSaison(Saison $saison): static
    {
        if (!$this->saisons->contains($saison)) {
            $this->saisons->add($saison);
            $saison->setAudiovisuel($this);
        }

        return $this;
    }

    public function removeSaison(Saison $saison): static
    {
        if ($this->saisons->removeElement($saison)) {
            // set the owning side to null (unless already changed)
            if ($saison->getAudiovisuel() === $this) {
                $saison->setAudiovisuel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AudiovisuelGenre>
     */
    public function getAudiovisuelGenres(): Collection
    {
        return $this->audiovisuelGenres;
    }

    public function addAudiovisuelGenre(AudiovisuelGenre $audiovisuelGenre): static
    {
        if (!$this->audiovisuelGenres->contains($audiovisuelGenre)) {
            $this->audiovisuelGenres->add($audiovisuelGenre);
            $audiovisuelGenre->setAudiovisuel($this);
        }

        return $this;
    }

    public function removeAudiovisuelGenre(AudiovisuelGenre $audiovisuelGenre): static
    {
        if ($this->audiovisuelGenres->removeElement($audiovisuelGenre)) {
            // set the owning side to null (unless already changed)
            if ($audiovisuelGenre->getAudiovisuel() === $this) {
                $audiovisuelGenre->setAudiovisuel(null);
            }
        }

        return $this;
    }
}
