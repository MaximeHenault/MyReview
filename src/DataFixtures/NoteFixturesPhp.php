<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class NoteFixturesPhp extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $note1 = new Note();
        $note1->setNote(4);
        $note1->setCommentaire('Très bon film, j\'ai adoré !');
        $note1->setAudiovisuel($this->getReference('labyrinthe'));
        $note1->setUtilisateur($this->getReference('utilisateur_note'));

        $manager->persist($note1);
        $manager->flush();

        $note2 = new Note();
        $note2->setNote(3);
        $note2->setCommentaire('Bon film, mais pas exceptionnel.');
        $note2->setAudiovisuel($this->getReference('champsdulou'));
        $note2->setUtilisateur($this->getReference('utilisateur_note'));

        $manager->persist($note2);
        $manager->flush();

        $note3 = new Note();
        $note3->setNote(5);
        $note3->setCommentaire('Un chef-d\'œuvre, à voir absolument !');
        $note3->setAudiovisuel($this->getReference('jurassicworld'));
        $note3->setUtilisateur($this->getReference('utilisateur_note'));
        
        $manager->persist($note3);
        $manager->flush();
    }
}
