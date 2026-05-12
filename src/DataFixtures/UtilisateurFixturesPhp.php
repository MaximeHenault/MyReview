<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UtilisateurFixturesPhp extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $utilisateurNote = new Utilisateur();
        $utilisateurNote->setEmail('utilisateur_note@example.com');
        $utilisateurNote->setPassword('password_note');
        $utilisateurNote->setUsername('utilisateur_note');
        $utilisateurNote->setRoles(['ROLE_NOTE']);
        $utilisateurNote->setPassword('password');

        $manager->persist($utilisateurNote);
        $manager->flush();

        $utilisateurAdmin = new Utilisateur();
        $utilisateurAdmin->setEmail('utilisateur_admin@example.com');
        $utilisateurAdmin->setPassword('password_admin');
        $utilisateurAdmin->setUsername('utilisateur_admin');
        $utilisateurAdmin->setRoles(['ROLE_ADMIN']);
        $utilisateurAdmin->setPassword('password');

        $manager->persist($utilisateurAdmin);
        $manager->flush();

        $utilisateurSuperAdmin = new Utilisateur();
        $utilisateurSuperAdmin->setEmail('utilisateur_super_admin@example.com');
        $utilisateurSuperAdmin->setPassword('password_super_admin');
        $utilisateurSuperAdmin->setUsername('utilisateur_super_admin');
        $utilisateurSuperAdmin->setRoles(['ROLE_SUPER_ADMIN']);
        $utilisateurSuperAdmin->setPassword('password');

        $manager->persist($utilisateurSuperAdmin);
        $manager->flush();
    }
}
