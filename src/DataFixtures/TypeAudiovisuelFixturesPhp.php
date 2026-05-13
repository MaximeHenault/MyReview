<?php

namespace App\DataFixtures;

use App\Entity\TypeAudiovisuel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TypeAudiovisuelFixturesPhp extends Fixture
{
    public const FILM_REFERENCE = 'Film';
    public const SERIE_REFERENCE = 'Série';
    
    public function load(ObjectManager $manager): void
    {
        $film = new TypeAudiovisuel();
        $film->setNom('Film');
        $manager->persist($film);
        $this->addReference(self::FILM_REFERENCE, $film);

        $serie = new TypeAudiovisuel();
        $serie->setNom('Série');
        $manager->persist($serie);
        $this->addReference(self::SERIE_REFERENCE, $serie);

        $manager->flush();
    }
}
