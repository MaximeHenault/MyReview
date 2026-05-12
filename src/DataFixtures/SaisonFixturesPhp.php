<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SaisonFixturesPhp extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $saison1 = new Saison();
        $saison1->setNumero(1);
        $saison1->setDateSortie(new \DateTime('2008-01-20'));
        $saison1->setAudiovisuel($this->getReference('breakingbad'));

        $manager->persist($saison1);
        $manager->flush();

        $saison2 = new Saison();
        $saison2->setNumero(2);
        $saison2->setDateSortie(new \DateTime('2009-03-08'));
        $saison2->setAudiovisuel($this->getReference('breakingbad'));   

        $manager->persist($saison2);
        $manager->flush();

        $saison3 = new Saison();
        $saison3->setNumero(3);
        $saison3->setDateSortie(new \DateTime('2010-03-21'));
        $saison3->setAudiovisuel($this->getReference('breakingbad')); 

        $manager->persist($saison3);
        $manager->flush();

        $saison4 = new Saison();
        $saison4->setNumero(4);
        $saison4->setDateSortie(new \DateTime('2011-07-17'));
        $saison4->setAudiovisuel($this->getReference('breakingbad')); 

        $manager->persist($saison4);
        $manager->flush();

        $saison5 = new Saison();
        $saison5->setNumero(5);
        $saison5->setDateSortie(new \DateTime('2012-07-15'));
        $saison5->setAudiovisuel($this->getReference('breakingbad')); 

        $manager->persist($saison5);
        $manager->flush();
    }
}
