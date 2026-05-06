<?php

namespace App\Controller;

use App\Entity\Audiovisuel;
use App\Entity\Note;
use App\Form\NoteFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class NoteController extends AbstractController
{
    #[Route('/avis/{id}', name: 'app_avis')]
    public function note(Request $request, EntityManagerInterface $entityManager, Audiovisuel $audiovisuel): Response
    {
        $note = new Note();
        $form = $this->createForm(NoteFormType::class, $note);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $note->setNote($form->get('note')->getData());
            $note->setCommentaire($form->get('commentaire')->getData());
            $note->setDateCreation(new \DateTime());
            $note->setAudiovisuel($audiovisuel);
            $note->setUtilisateur($this->getUser());

            $entityManager->persist($note);
            $entityManager->flush();

            $this->addFlash('success', 'Note ajoutée avec succès');

            return $this->redirectToRoute('app_film_detail', ['id' => $audiovisuel->getId()]);
        }

        return $this->render('Note/index.html.twig', [
            'noteForm' => $form,
            'audiovisuel' => $audiovisuel,
        ]);
    }

    #[Route('/avis/edit/{id}', name: 'app_avis_edit')]
    public function editAvis(Note $note, Request $request, EntityManagerInterface $entityManager, Audiovisuel $audiovisuel): Response
    {
        $form = $this->createForm(NoteFormType::class, $note);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Avis modifié avec succès');
            return $this->redirectToRoute('app_film_detail', ['id' => $note->getAudiovisuel()->getId()]);
        }

        return $this->render('Note/index.html.twig', [
            'noteForm' => $form->createView(),
            'audiovisuel' => $audiovisuel,
        ]);
    }

    #[Route('/avis/delete/{id}', name: 'app_avis_delete', methods: ['POST'])]
    public function deleteAvis(Note $note, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete_avis_' . $note->getId(), $request->request->get('_token'))) {
            $entityManager->remove($note);
            $entityManager->flush();
            $this->addFlash('success', 'Avis supprimé');
        }

        return $this->redirectToRoute('app_film_detail', ['id' => $note->getAudiovisuel()->getId()]);
    }
}
