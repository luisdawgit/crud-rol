<?php

namespace App\Controller;
use App\Entity\Personaje;
use App\Form\PersonajeType;
use App\Repository\PersonajeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/personaje')]
class PersonajeController extends AbstractController
{
#[Route('/', name: 'app_personaje_index', methods: ['GET'])]
public function index(PersonajeRepository $personajeRepository): Response
{
    return $this->render('personaje/index.html.twig', [
        'personajes' => $personajeRepository->findBy([
            'usuario' => $this->getUser()
        ]),
    ]);
}

    #[Route('/new', name: 'app_personaje_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $personaje = new Personaje();
        $form = $this->createForm(PersonajeType::class, $personaje);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $personaje->setUsuario($this->getUser());//Añadido para asignar el usuario actual al personaje creado
            
            $entityManager->persist($personaje);
            $entityManager->flush();

            return $this->redirectToRoute('app_personaje_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('personaje/new.html.twig', [
            'personaje' => $personaje,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_personaje_show', methods: ['GET'])]
    public function show(Personaje $personaje): Response
    {
        if ($personaje->getUsuario() !== $this->getUser()) {
        throw $this->createAccessDeniedException();
        }

        return $this->render('personaje/show.html.twig', [
            'personaje' => $personaje,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_personaje_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Personaje $personaje, EntityManagerInterface $entityManager): Response
    {
        if ($personaje->getUsuario() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(PersonajeType::class, $personaje);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_personaje_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('personaje/edit.html.twig', [
            'personaje' => $personaje,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_personaje_delete', methods: ['POST'])]
    public function delete(Request $request, Personaje $personaje, EntityManagerInterface $entityManager): Response
    {
        if ($personaje->getUsuario() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        if ($this->isCsrfTokenValid('delete'.$personaje->getId(), $request->request->get('_token'))) {
            $entityManager->remove($personaje);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_personaje_index', [], Response::HTTP_SEE_OTHER);
    }
}