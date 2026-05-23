<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\AudiovisuelRepository;
use App\Repository\NoteRepository;
use App\Repository\SaisonRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Audiovisuel;
use App\Form\FilmFormType;
use App\Form\SerieAnimeFormType;
use App\Repository\TypeAudiovisuelRepository;
use App\Entity\Saison;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

final class AudiovisuelController extends AbstractController
{
    /* ============================================================
    Partie Film (Récupération, ajout, suppression et modification)
    ============================================================ */
    #[Route('/film', name: 'app_film')]
    public function getFilm(AudiovisuelRepository $audiovisuelRepository, Request $request): Response
    {
        $page = max(1, $request->query->getInt('page', 1));
        $data = $audiovisuelRepository->getPaginationFilm($page, 15);
        
        return $this->render('audiovisuel/films/home.html.twig', [
            'films' => $data['films'] ?? null,
            'page' => $data['page'],
            'pages' => $data['pages'],
            'total' => $data['total'],
        ]);
    }

    #[Route('/film/{id}', name: 'app_film_detail')]
    public function getFilmDetail(AudiovisuelRepository $audiovisuelRepository, NoteRepository $noteRepository, int $id): Response
    {
        $audiovisuel = $audiovisuelRepository->getAudiovisuelById($id);
        $note = $noteRepository->getNoteByAudiovisuelId($id);
        return $this->render('/audiovisuel/details/details.html.twig', [
            'audiovisuel' => $audiovisuel[0],
            'notes' => $note ?? null,
        ]);
    }
    
    #[Route('/add/film', name: 'app_film_add')]
    public function addFilm(Request $request, EntityManagerInterface $entityManager, TypeAudiovisuelRepository $typeRepository, SluggerInterface $slugger, #[Autowire('%kernel.project_dir%/public/images')] string $afficheRepertoire): Response
    {
        $audiovisuel = new Audiovisuel();
        $form = $this->createForm(FilmFormType::class, $audiovisuel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $audiovisuel->setTitre($form->get('titre')->getData());
            $audiovisuel->setDescription($form->get('description')->getData());
            $audiovisuel->setRealisateur($form->get('realisateur')->getData());
            $audiovisuel->setDateCreation($form->get('dateCreation')->getData());
            $audiovisuel->setDuree($form->get('duree')->getData());
            
            $typeAudiovisuel = $typeRepository->find(1);
            $audiovisuel->setTypeAudiovisuel($typeAudiovisuel);

            /* =====================================
                        PARTIE AFFICHE
            ===================================== */
            $afficheFile = $form->get('affiche')->getData();
            $nomSafe = (string) $slugger->slug((string) $form->get('titre')->getData());
            $extension = strtolower((string) $afficheFile->getClientOriginalExtension());
            $extensionsAutorisees = ['jpg', 'jpeg', 'png'];

            if ($nomSafe === '') {
                $nomSafe = 'film';
            }

            if (!in_array($extension, $extensionsAutorisees, true)) {
                $this->addFlash('danger', 'Format non supporte. Utilise JPG ou PNG.');

                return $this->render('audiovisuel/films/addFilm.html.twig', [
                    'filmForm' => $form->createView(),
                ]);
            }

            $nomFichier = $nomSafe . '.' . $extension;

            try {
                $afficheFile->move($afficheRepertoire, $nomFichier);
            } catch (FileException) {
                $this->addFlash('danger', 'Erreur pendant l\'upload de l\'affiche.');

                return $this->render('audiovisuel/films/addFilm.html.twig', [
                    'filmForm' => $form->createView(),
                ]);
            }

            $audiovisuel->setAffiche('/images/' . $nomFichier);  

            $entityManager->persist($audiovisuel);
            $entityManager->flush();

            $this->addFlash('success', 'Film créer avec succès');

            return $this->redirectToRoute('app_film');
        }

        return $this->render('audiovisuel/films/addFilm.html.twig', [
            'filmForm' => $form->createView(),
        ]);
    }

    #[Route('/film/edit/{id}', name: 'app_film_edit')]
    public function editFilm(Audiovisuel $audiovisuel, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FilmFormType::class, $audiovisuel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Film modifié avec succès');
            return $this->redirectToRoute('app_film');
        }

        return $this->render('audiovisuel/films/addFilm.html.twig', [
            'filmForm' => $form->createView(),
        ]);
    }

    #[Route('/film/delete/{id}', name: 'app_film_delete', methods: ['POST'])]
    public function deleteFilm(Audiovisuel $audiovisuel, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete_film_' . $audiovisuel->getId(), $request->request->get('_token'))) {
            $entityManager->remove($audiovisuel);
            $entityManager->flush();
            $this->addFlash('success', 'Film supprimé');
        }

        return $this->redirectToRoute('app_film');
    }


    /* ============================================================
    Partie série (Récupération, ajout, suppression et modification)
    ============================================================ */
    #[Route('/serie', name: 'app_serie')]
    public function getSerie(AudiovisuelRepository $audiovisuelRepository, Request $request): Response
    {
        $page = max(1, $request->query->getInt('page', 1));
        $data = $audiovisuelRepository->getPaginationSerieAnime($page, 15, 2);

        return $this->render('audiovisuel/series/home.html.twig', [
            'series' => $data['series'] ?? null,
            'page' => $data['page'],
            'pages' => $data['pages'],
            'total' => $data['total'],
        ]);
    }

    #[Route('/serie/{id}', name: 'app_serie_detail')]
    public function getSerieDetail(AudiovisuelRepository $audiovisuelRepository, NoteRepository $noteRepository, SaisonRepository $saisonRepository, int $id): Response
    {
        $audiovisuel = $audiovisuelRepository->getAudiovisuelById($id);
        $note = $noteRepository->getNoteByAudiovisuelId($id);
        $saison = $saisonRepository->getSaisonByAudiovisuelId($id);
        return $this->render('/audiovisuel/details/details.html.twig', [
            'audiovisuel' => $audiovisuel[0],
            'notes' => $note ?? null,
            'saisons' => $saison,
        ]);
    }
    

    #[Route('/serie/edit/{id}', name: 'app_serie_edit')]
    public function editSerie(Audiovisuel $audiovisuel, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SerieAnimeFormType::class, $audiovisuel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Film modifié avec succès');
            return $this->redirectToRoute('app_serie');
        }

        return $this->render('audiovisuel/addSerieAnime.html.twig', [
            'serieanimeForm' => $form->createView(),
            'type_id' => 1,
        ]);
    }

    #[Route('/serie/delete/{id}', name: 'app_serie_delete', methods: ['POST'])]
    public function SerieFilm(Audiovisuel $audiovisuel, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete_serie_' . $audiovisuel->getId(), $request->request->get('_token'))) {
            $entityManager->remove($audiovisuel);
            $entityManager->flush();
            $this->addFlash('success', 'Série supprimé');
        }

        return $this->redirectToRoute('app_serie');
    }

    /* ============================================================
    Partie animé (Récupération, ajout, suppression et modification)
    ============================================================ */
    #[Route('/anime', name: 'app_anime')]
    public function getAnime(AudiovisuelRepository $audiovisuelRepository, Request $request): Response
    {
        $page = max(1, $request->query->getInt('page', 1));
        $data = $audiovisuelRepository->getPaginationSerieAnime($page, 15, 3);

        return $this->render('audiovisuel/animes/home.html.twig', [
            'animes' => $data['animes'] ?? null,
            'page' => $data['page'],
            'pages' => $data['pages'],
            'total' => $data['total'],
        ]);
    }

    #[Route('/anime/{id}', name: 'app_anime_detail')]
    public function getAnimeDetail(AudiovisuelRepository $audiovisuelRepository, NoteRepository $noteRepository, int $id): Response
    {
        $audiovisuel = $audiovisuelRepository->getAudiovisuelById($id);
        $note = $noteRepository->getNoteByAudiovisuelId($id);
        return $this->render('/audiovisuel/details/details.html.twig', [
            'audiovisuel' => $audiovisuel[0],
            'notes' => $note ?? null,
        ]);
    }

    #[Route('/anime/edit/{id}', name: 'app_anime_edit')]
    public function editAnime(Audiovisuel $audiovisuel, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SerieAnimeFormType::class, $audiovisuel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Film modifié avec succès');
            return $this->redirectToRoute('app_anime');
        }

        return $this->render('audiovisuel/addSerieAnime.html.twig', [
            'serieanimeForm' => $form->createView(),
            'type_id' => 3,
        ]);
    }

    #[Route('/anime/delete/{id}', name: 'app_anime_delete', methods: ['POST'])]
    public function deleteAnime(Audiovisuel $audiovisuel, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete_anime_' . $audiovisuel->getId(), $request->request->get('_token'))) {
            $entityManager->remove($audiovisuel);
            $entityManager->flush();
            $this->addFlash('success', 'Animé supprimé');
        }

        return $this->redirectToRoute('app_anime');
    }

    /* ============================================================
    Partie série et animé (Récupération, ajout, suppression et modification)
    ============================================================ */

    #[Route('/add/serieanime', name: 'app_serieanime_add', methods: ['POST'])]
    public function addSerieAnime(Request $request, EntityManagerInterface $entityManager, TypeAudiovisuelRepository $typeRepository): Response
    {
        $type_id = $request->request->get('type_id');
        $audiovisuel = new Audiovisuel();
        $saison = new Saison();
        $form = $this->createForm(SerieAnimeFormType::class, $audiovisuel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeAudiovisuel = $typeRepository->find($type_id);

            $audiovisuel->setTitre($form->get('titre')->getData());
            $audiovisuel->setDescription($form->get('description')->getData());
            $audiovisuel->setRealisateur($form->get('realisateur')->getData());
            $audiovisuel->setDateCreation($form->get('dateCreation')->getData());
            $audiovisuel->setDuree($form->get('duree')->getData());
            $audiovisuel->setTypeAudiovisuel($typeAudiovisuel);

            $saison->setNumero($form->get('numero')->getData());
            $saison->setTitre($form->get('titreSaison')->getData());
            $saison->setNbEpisode($form->get('nbepisode')->getData());
            $saison->setAudiovisuel($audiovisuel);

            /* =====================================
                        PARTIE AFFICHE
            ===================================== */
            $afficheFile = $form->get('affiche')->getData();
            $nomSafe = (string) $slugger->slug((string) $form->get('titre')->getData());
            $extension = strtolower((string) $afficheFile->getClientOriginalExtension());
            $extensionsAutorisees = ['jpg', 'jpeg', 'png'];

            if ($nomSafe === '') {
                $nomSafe = 'film';
            }

            if (!in_array($extension, $extensionsAutorisees, true)) {
                $this->addFlash('danger', 'Format non supporte. Utilise JPG ou PNG.');

                return $this->render('audiovisuel/films/addFilm.html.twig', [
                    'filmForm' => $form->createView(),
                ]);
            }

            $nomFichier = $nomSafe . '.' . $extension;

            try {
                $afficheFile->move($afficheRepertoire, $nomFichier);
            } catch (FileException) {
                $this->addFlash('danger', 'Erreur pendant l\'upload de l\'affiche.');

                return $this->render('audiovisuel/films/addFilm.html.twig', [
                    'filmForm' => $form->createView(),
                ]);
            }

            $audiovisuel->setAffiche('/images/' . $nomFichier);  

            $entityManager->persist($audiovisuel, $saison);
            $entityManager->flush();

            $this->addFlash('success', 'Série créer avec succès');

            return $this->redirectToRoute('app_serie');
        }

        return $this->render('audiovisuel/addSerieAnime.html.twig', [
            'serieanimeForm' => $form,
            'type_id' => $type_id,
        ]);
    }
}
