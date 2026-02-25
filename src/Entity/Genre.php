<?php

namespace App\Entity;

use App\Repository\GenreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GenreRepository::class)]
class Genre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    /**
     * @var Collection<int, AudiovisuelGenre>
     */
    #[ORM\OneToMany(targetEntity: AudiovisuelGenre::class, mappedBy: 'genre')]
    private Collection $audiovisuelGenres;

    public function __construct()
    {
        $this->audiovisuelGenres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

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
            $audiovisuelGenre->setGenre($this);
        }

        return $this;
    }

    public function removeAudiovisuelGenre(AudiovisuelGenre $audiovisuelGenre): static
    {
        if ($this->audiovisuelGenres->removeElement($audiovisuelGenre)) {
            // set the owning side to null (unless already changed)
            if ($audiovisuelGenre->getGenre() === $this) {
                $audiovisuelGenre->setGenre(null);
            }
        }

        return $this;
    }
}
