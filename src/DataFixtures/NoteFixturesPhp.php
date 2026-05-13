<?php

namespace App\DataFixtures;

use App\Entity\Audiovisuel;
use App\Entity\Note;
use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class NoteFixturesPhp extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $note1 = new Note();
        $note1->setNote(4);
        $note1->setCommentaire('Très bon film, j\'ai adoré !');
        $note1->setDateCreation(new \DateTime());
        $note1->setAudiovisuel($this->getReference(AudiovisuelFixturesPhp::LABYRINTHE, Audiovisuel::class));
        $note1->setUtilisateur($this->getReference(UtilisateurFixturesPhp::NOTE_USER_REFERENCE, Utilisateur::class));

        $manager->persist($note1);
        $manager->flush();

        $note2 = new Note();
        $note2->setNote(3);
        $note2->setCommentaire('Bon film, mais pas exceptionnel.');
        $note2->setDateCreation(new \DateTime());
        $note2->setAudiovisuel($this->getReference(AudiovisuelFixturesPhp::CHAMPSDULOU, Audiovisuel::class));
        $note2->setUtilisateur($this->getReference(UtilisateurFixturesPhp::NOTE_USER_REFERENCE, Utilisateur::class));

        $manager->persist($note2);
        $manager->flush();

        $note3 = new Note();
        $note3->setNote(5);
        $note3->setCommentaire('Un chef-d\'œuvre, à voir absolument !');
        $note3->setDateCreation(new \DateTime());
        $note3->setAudiovisuel($this->getReference(AudiovisuelFixturesPhp::JURASSICWORLD, Audiovisuel::class));
        $note3->setUtilisateur($this->getReference(UtilisateurFixturesPhp::NOTE_USER_REFERENCE, Utilisateur::class));
        
        $manager->persist($note3);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AudiovisuelFixturesPhp::class,
            UtilisateurFixturesPhp::class,
        ];
    }
}
