<?php

namespace App\Entity;

use App\Repository\AudiovisuelGenreRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AudiovisuelGenreRepository::class)]
class AudiovisuelGenre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'audiovisuelGenres')]
    private ?Audiovisuel $audiovisuel = null;

    #[ORM\ManyToOne(inversedBy: 'audiovisuelGenres')]
    private ?Genre $genre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAudiovisuel(): ?Audiovisuel
    {
        return $this->audiovisuel;
    }

    public function setAudiovisuel(?Audiovisuel $audiovisuel): static
    {
        $this->audiovisuel = $audiovisuel;
        return $this;
    }

    public function getGenre(): ?Genre
    {
        return $this->genre;
    }

    public function setGenre(?Genre $genre): static
    {
        $this->genre = $genre;

        return $this;
    }
}
