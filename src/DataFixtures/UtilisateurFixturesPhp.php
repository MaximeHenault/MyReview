<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UtilisateurFixturesPhp extends Fixture
{
    public const NOTE_USER_REFERENCE = 'utilisateur_note';
    public const ADMIN_USER_REFERENCE = 'utilisateur_admin';
    public const SUPER_ADMIN_USER_REFERENCE = 'utilisateur_super_admin';

    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $utilisateurNote = new Utilisateur();
        $utilisateurNote->setEmail('utilisateur_note@example.com');
        $utilisateurNote->setPassword($this->hasher->hashPassword($utilisateurNote, 'pass_note'));
        $utilisateurNote->setUsername('utilisateur_note');
        $utilisateurNote->setRoles(['ROLE_NOTE']);

        $manager->persist($utilisateurNote);
        $this->addReference(self::NOTE_USER_REFERENCE, $utilisateurNote);

        $utilisateurAdmin = new Utilisateur();
        $utilisateurAdmin->setEmail('utilisateur_admin@example.com');
        $utilisateurAdmin->setPassword($this->hasher->hashPassword($utilisateurAdmin, 'pass_admin'));
        $utilisateurAdmin->setUsername('utilisateur_admin');
        $utilisateurAdmin->setRoles(['ROLE_ADMIN']);

        $manager->persist($utilisateurAdmin);
        $this->addReference(self::ADMIN_USER_REFERENCE, $utilisateurAdmin);

        $utilisateurSuperAdmin = new Utilisateur();
        $utilisateurSuperAdmin->setEmail('utilisateur_super_admin@example.com');
        $utilisateurSuperAdmin->setPassword($this->hasher->hashPassword($utilisateurSuperAdmin, 'pass_super_admin'));
        $utilisateurSuperAdmin->setUsername('utilisateur_super_admin');
        $utilisateurSuperAdmin->setRoles(['ROLE_SUPER_ADMIN']);

        $manager->persist($utilisateurSuperAdmin);
        $this->addReference(self::SUPER_ADMIN_USER_REFERENCE, $utilisateurSuperAdmin);

        $manager->flush();
    }
}
