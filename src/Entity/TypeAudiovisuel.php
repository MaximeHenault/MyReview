<?php

namespace App\Entity;

use App\Repository\TypeAudiovisuelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeAudiovisuelRepository::class)]
class TypeAudiovisuel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    /**
     * @var Collection<int, Audiovisuel>
     */
    #[ORM\OneToMany(targetEntity: Audiovisuel::class, mappedBy: 'typeAudiovisuel')]
    private Collection $audiovisuels;

    public function __construct()
    {
        $this->audiovisuels = new ArrayCollection();
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
     * @return Collection<int, Audiovisuel>
     */
    public function getAudiovisuels(): Collection
    {
        return $this->audiovisuels;
    }

    public function addAudiovisuel(Audiovisuel $audiovisuel): static
    {
        if (!$this->audiovisuels->contains($audiovisuel)) {
            $this->audiovisuels->add($audiovisuel);
            $audiovisuel->setTypeAudiovisuel($this);
        }

        return $this;
    }

    public function removeAudiovisuel(Audiovisuel $audiovisuel): static
    {
        if ($this->audiovisuels->removeElement($audiovisuel)) {
            // set the owning side to null (unless already changed)
            if ($audiovisuel->getTypeAudiovisuel() === $this) {
                $audiovisuel->setTypeAudiovisuel(null);
            }
        }

        return $this;
    }
}
