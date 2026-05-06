<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\AudiovisuelRepository;
use Doctrine\DBAL\ParameterType;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(AudiovisuelRepository $audiovisuelRepository, Request $request): Response
    {
        $data = $audiovisuelRepository->getStats();

        return $this->render('home/index.html.twig', [
            'films' => $data['total_films'] ?? null,
            'series' => $data['total_series'] ?? null,
            'animes' => $data['total_animes'] ?? null,
            'notes' => $data['total_notes'] ?? null,
        ]);
    }

    #[Route('/search', name: 'search')]
    public function search(Request $request, AudiovisuelRepository $repo): JsonResponse
    {
        $q = trim((string) $request->query->get('q', ''));

        if ($q === '') {
            return $this->json([]);
        }

        $conn = $repo->getEntityManager()->getConnection();
        $rows = $conn->executeQuery(
            '
                SELECT id, titre, affiche, type_audiovisuel_id
                FROM audiovisuel
                WHERE LOWER(titre) LIKE LOWER(:contain)
                ORDER BY CASE WHEN LOWER(titre) LIKE LOWER(:start) THEN 0 ELSE 1 END, titre ASC
                LIMIT 6
            ',
            [
                'start' => $q . '%',
                'contain' => '%' . $q . '%',
            ],
            [
                'start' => ParameterType::STRING,
                'contain' => ParameterType::STRING,
            ]
        )->fetchAllAssociative();

        $results = array_map(function (array $a) {
            $typeId = (int) ($a['type_audiovisuel_id'] ?? 0);
            $route = match ($typeId) {
                1 => 'app_film_detail',
                2 => 'app_serie_detail',
                3 => 'app_anime_detail',
                default => 'app_home',
            };

            return [
                'id' => (int) $a['id'],
                'title' => $a['titre'],
                'poster' => $a['affiche'] ?: '/images/logo.png',
                'url' => $this->generateUrl($route, ['id' => (int) $a['id']]),
            ];
        }, $rows);

        return $this->json($results);
    }
}

