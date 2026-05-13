<?php

namespace App\DataFixtures;

use App\Entity\Audiovisuel;
use App\Entity\Saison;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SaisonFixturesPhp extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $saison1 = new Saison();
        $saison1->setNumero(1);
        $saison1->setTitre('Saison 1');
        $saison1->setNbEpisode(7);
        $saison1->setAudiovisuel($this->getReference(AudiovisuelFixturesPhp::BREAKINGBAD, Audiovisuel::class));

        $manager->persist($saison1);
        $manager->flush();

        $saison2 = new Saison();
        $saison2->setNumero(2);
        $saison2->setTitre('Saison 2');
        $saison2->setNbEpisode(10);
        $saison2->setAudiovisuel($this->getReference(AudiovisuelFixturesPhp::BREAKINGBAD, Audiovisuel::class));   

        $manager->persist($saison2);
        $manager->flush();

        $saison3 = new Saison();
        $saison3->setNumero(3);
        $saison3->setTitre('Saison 3');
        $saison3->setNbEpisode(13);
        $saison3->setAudiovisuel($this->getReference(AudiovisuelFixturesPhp::BREAKINGBAD, Audiovisuel::class)); 

        $manager->persist($saison3);
        $manager->flush();

        $saison4 = new Saison();
        $saison4->setNumero(4);
        $saison4->setTitre('Saison 4');
        $saison4->setNbEpisode(13);
        $saison4->setAudiovisuel($this->getReference(AudiovisuelFixturesPhp::BREAKINGBAD, Audiovisuel::class)); 

        $manager->persist($saison4);
        $manager->flush();

        $saison5 = new Saison();
        $saison5->setNumero(5);
        $saison5->setTitre('Saison 5');
        $saison5->setNbEpisode(16);
        $saison5->setAudiovisuel($this->getReference(AudiovisuelFixturesPhp::BREAKINGBAD, Audiovisuel::class)); 

        $manager->persist($saison5);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AudiovisuelFixturesPhp::class,
        ];
    }
}
