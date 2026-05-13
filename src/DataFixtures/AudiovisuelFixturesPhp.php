<?php

namespace App\DataFixtures;

use App\Entity\Audiovisuel;
use App\Entity\TypeAudiovisuel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AudiovisuelFixturesPhp extends Fixture implements DependentFixtureInterface
{
    public const LABYRINTHE = 'labyrinthe';
    public const CHAMPSDULOU = 'champsdulou';
    public const JURASSICWORLD = 'jurassicworld';
    public const BREAKINGBAD = 'breakingbad';
    public function load(ObjectManager $manager): void
    {
        $labyrinthe = new Audiovisuel();
        $labyrinthe->setTitre('Le Labyrinthe');
        $labyrinthe->setTypeAudiovisuel($this->getReference(TypeAudiovisuelFixturesPhp::FILM_REFERENCE, TypeAudiovisuel::class));
        $labyrinthe->setRealisateur('Wes Ball');
        $labyrinthe->setDateCreation(new \DateTime('2014-09-19'));
        $labyrinthe->setDuree(113);
        $labyrinthe->setAffiche('https://fr.web.img6.acsta.net/pictures/14/05/28/12/15/568567.jpg');
        $labyrinthe->setDescription('Dans un monde post-apocalyptique, un groupe d\'adolescents se retrouve piégé dans un labyrinthe géant rempli de créatures mortelles. Ils doivent trouver un moyen de s\'échapper tout en découvrant les secrets de ce lieu mystérieux.');

        $manager->persist($labyrinthe);
        $this->addReference(self::LABYRINTHE, $labyrinthe);

        $champsdulou = new Audiovisuel();
        $champsdulou->setTitre('Le Champs du Loup');
        $champsdulou->setTypeAudiovisuel($this->getReference(TypeAudiovisuelFixturesPhp::FILM_REFERENCE, TypeAudiovisuel::class));
        $champsdulou->setRealisateur('Antonin Baudry');
        $champsdulou->setDateCreation(new \DateTime('2019-01-01'));
        $champsdulou->setDuree(115);
        $champsdulou->setAffiche('https://fr.web.img6.acsta.net/pictures/19/09/19/14/23/568567.jpg');
        $champsdulou->setDescription('Le film suit Chanteraide, une des « oreilles d\'or » de la Marine nationale, spécialiste de la guerre acoustique. Il occupe un rôle essentiel à bord des sous-marins mais lors d\'une mission, il commet une erreur d\'analyse qui met en danger tout un équipage.');

        $manager->persist($champsdulou);
        $this->addReference(self::CHAMPSDULOU, $champsdulou);

        $jurassicworld = new Audiovisuel();
        $jurassicworld->setTitre('Jurassic World : Le Monde d\'après');
        $jurassicworld->setTypeAudiovisuel($this->getReference(TypeAudiovisuelFixturesPhp::FILM_REFERENCE, TypeAudiovisuel::class));
        $jurassicworld->setRealisateur('Colin Trevorrow');
        $jurassicworld->setDateCreation(new \DateTime('2022-06-01'));
        $jurassicworld->setDuree(146);
        $jurassicworld->setAffiche('https://fr.web.img6.acsta.net/pictures/22/05/30/09/44/568567.jpg');
        $jurassicworld->setDescription('Quatre ans après la destruction de l\'île Nublar, les dinosaures vivent désormais et se reproduisent dans le monde entier, avec des conséquences imprévisibles. Alors que les humains tentent de coexister avec les dinosaures, une nouvelle menace émerge, mettant en péril l\'équilibre fragile entre les deux espèces.');

        $manager->persist($jurassicworld);
        $this->addReference(self::JURASSICWORLD, $jurassicworld);

        $breakingbad = new Audiovisuel();
        $breakingbad->setTitre('Breaking Bad');
        $breakingbad->setTypeAudiovisuel($this->getReference(TypeAudiovisuelFixturesPhp::SERIE_REFERENCE, TypeAudiovisuel::class));
        $breakingbad->setRealisateur('Vince Gilligan');
        $breakingbad->setDateCreation(new \DateTime('2008-01-20'));
        $breakingbad->setAffiche('https://fr.web.img6.acsta.net/pictures/18/09/26/10/44/568567.jpg');
        $breakingbad->setDescription('Walter White, un professeur de chimie du lycée, apprend qu\'il est atteint d\'un cancer du poumon en phase terminale. Pour assurer l\'avenir financier de sa famille après sa mort, il décide de se lancer dans la fabrication et la vente de méthamphétamine avec l\'aide de son ancien élève, Jesse Pinkman. Cependant, leur entreprise illégale les entraîne dans un monde dangereux de crime et de violence.');
        
        $manager->persist($breakingbad);
        $this->addReference(self::BREAKINGBAD, $breakingbad);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            TypeAudiovisuelFixturesPhp::class,
        ];
    }
}
