<?php

namespace App\Controller;

use App\Entity\Personaje;
use App\Entity\PersonajeDisciplina;
use App\Form\PersonajeDisciplinaType;
use App\Repository\PersonajeDisciplinaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/disciplina')]
class PersonajeDisciplinaController extends AbstractController
{
    #[Route('/', name: 'app_personaje_disciplina_index', methods: ['GET'])]
    public function index(PersonajeDisciplinaRepository $personajeDisciplinaRepository): Response
    {
        return $this->render('personaje_disciplina/index.html.twig', [
            'personaje_disciplinas' => $personajeDisciplinaRepository->findAll(),
        ]);
    }

    #[Route('/personaje/{id}/disciplina/new', name: 'app_personaje_disciplina_new', methods: ['GET', 'POST'])]
    public function new(Personaje $personaje, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Seguridad: comprobar que el personaje es del usuario
        if ($personaje->getUsuario() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $personajeDisciplina = new PersonajeDisciplina();
        $personajeDisciplina->setPersonaje($personaje);

        $form = $this->createForm(PersonajeDisciplinaType::class, $personajeDisciplina);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Nivel inicial si no se especifica
            if ($personajeDisciplina->getNivel() === null) {
                $personajeDisciplina->setNivel(1);
            }

            $entityManager->persist($personajeDisciplina);
            $entityManager->flush();

            return $this->redirectToRoute('app_personaje_show', [
                'id' => $personaje->getId()
            ]);
        }

        return $this->renderForm('personaje_disciplina/new.html.twig', [
            'personaje_disciplina' => $personajeDisciplina,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_personaje_disciplina_show', methods: ['GET'])]
    public function show(PersonajeDisciplina $personajeDisciplina): Response
    {
        return $this->render('personaje_disciplina/show.html.twig', [
            'personaje_disciplina' => $personajeDisciplina,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_personaje_disciplina_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PersonajeDisciplina $personajeDisciplina, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PersonajeDisciplinaType::class, $personajeDisciplina);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_personaje_disciplina_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('personaje_disciplina/edit.html.twig', [
            'personaje_disciplina' => $personajeDisciplina,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_personaje_disciplina_delete', methods: ['POST'])]
    public function delete(Request $request, PersonajeDisciplina $personajeDisciplina, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$personajeDisciplina->getId(), $request->request->get('_token'))) {
            $entityManager->remove($personajeDisciplina);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_personaje_disciplina_index', [], Response::HTTP_SEE_OTHER);
    }
}