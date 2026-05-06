<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AdminController extends AbstractController
{
    #[Route('/admin/users/new', name: 'app_user_new')]
    public function createNewUser(): Response
    {
        return $this->render('admin/User.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
