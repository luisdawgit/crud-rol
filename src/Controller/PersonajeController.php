<?php

namespace App\Controller;
use App\Entity\Personaje;
use App\Form\PersonajeType;
use App\Repository\PersonajeRepository;
use App\Repository\AtributoRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\PersonajeAtributo;

use App\Repository\HabilidadRepository;
use App\Entity\Habilidad;
use App\Entity\PersonajeHabilidad;

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

            return $this->redirectToRoute('app_personaje_atributos', [
                'id' => $personaje->getId()
            ]);
        }

        return $this->renderForm('personaje/new.html.twig', [
            'personaje' => $personaje,
            'form' => $form,
        ]);
    }

#[Route('/{id}/atributos', name: 'app_personaje_atributos', methods: ['GET','POST'])]
public function atributos(
    Personaje $personaje,
    AtributoRepository $atributoRepository,
    Request $request,
    EntityManagerInterface $entityManager
): Response
{
    if ($personaje->getUsuario() !== $this->getUser()) {
        throw $this->createAccessDeniedException();
    }

    $atributos = $atributoRepository->findAll();
    $atributosAgrupados = [];

    foreach ($atributos as $atributo) {
        $atributosAgrupados[$atributo->getCategoria()][] = $atributo;
    }


    // NUEVO: procesar formulario
    if ($request->isMethod('POST')) {

        $data = $request->request->all('atributos');

        // Agrupar puntos por categoría
        $puntosPorCategoria = [
            'Fisico' => 0,
            'Social' => 0,
            'Mental' => 0
            ];
            
        //Validacion puntos gratuitos ini
        foreach ($data as $atributoId => $nivel) {

            
            $atributo = $atributoRepository->find($atributoId);
            //Validar que los Nosferatu no puedan subir Apariencia mas de 1 ini
            if (
                $personaje->getClan()->getNombre() === 'Nosferatu' &&
                $atributo->getNombre() === 'Apariencia' &&
                (int)$nivel > 1
            ) {
                $this->addFlash('error', 'Los Nosferatu no pueden subir Apariencia');
            
                return $this->redirectToRoute('app_personaje_atributos', [
                    'id' => $personaje->getId()
                ]);
            }
            //Validar que los Nosferatu no puedan subir Apariencia mas de 1 fin

            // puntos extra (nivel - 1)
            $extra = ((int)$nivel) - 1;

            $categoria = $atributo->getCategoria();

            $puntosPorCategoria[$categoria] += $extra;
        }
        
        $valores = array_values($puntosPorCategoria);
        sort($valores);

        if ($valores !== [3, 5, 7]) {
            $this->addFlash('error', 'Debes repartir los puntos como 7 / 5 / 3');

            return $this->redirectToRoute('app_personaje_atributos', [
                'id' => $personaje->getId()
            ]);
        }

        //Validacion puntos gratuitos fin
        
        foreach ($data as $atributoId => $nivel) {

            $atributo = $atributoRepository->find($atributoId);

            $pa = new PersonajeAtributo();
            $pa->setPersonaje($personaje);
            $pa->setAtributo($atributo);
            $pa->setNivel((int)$nivel);

            $entityManager->persist($pa);
        }

        $entityManager->flush();

        return $this->redirectToRoute('app_personaje_habilidades', [
            'id' => $personaje->getId()
        ]);
    }

    return $this->render('personaje/wizard/point_allocation.html.twig', [
        'personaje' => $personaje,
        'titulo' => 'Atributos',
        'rasgosAgrupados' => $atributosAgrupados,
        'inputName' => 'atributos',
        'minimo' => 1,
        'maximo' => 5
    ]);
}

//habilidad init
#[Route('/{id}/habilidades', name: 'app_personaje_habilidades', methods: ['GET','POST'])]
public function habilidades(
    Personaje $personaje,
    HabilidadRepository $habilidadRepository,
    Request $request,
    EntityManagerInterface $entityManager
): Response
{
    if ($personaje->getUsuario() !== $this->getUser()) {
        throw $this->createAccessDeniedException();
    }

    $habilidades = $habilidadRepository->findAll(); // luego lo cambiamos a HabilidadRepository

    $habilidadesAgrupadas = [];

    foreach ($habilidades as $hab) {
        $habilidadesAgrupadas[$hab->getCategoria()][] = $hab;
    }

    if ($request->isMethod('POST')) {

        $data = $request->request->all('habilidades');

        $puntosPorCategoria = [
            'Talentos' => 0,
            'Tecnicas' => 0,
            'Conocimientos' => 0
        ];

        //Sumar puntos de habilidad init
        foreach ($data as $habilidadId => $nivel) {

            $habilidad = $habilidadRepository->find($habilidadId);

            $categoria = $habilidad->getCategoria();

            $puntosPorCategoria[$categoria] += (int)$nivel;
        }
        //Sumar puntos de habilidad fin

        //validar puntos habilidades 13/9/5 ini
        $valores = array_values($puntosPorCategoria);

        sort($valores);

        if ($valores !== [5,9,13]) {

            $this->addFlash(
                'error',
                'Debes repartir las habilidades como 13 / 9 / 5'
            );

            return $this->redirectToRoute(
                'app_personaje_habilidades',
                ['id' => $personaje->getId()]
            );
        }
        //validar puntos habilidades 13/9/5 fin

        
        foreach ($data as $habilidadId => $nivel) {

            $habilidad = $entityManager->getRepository(Habilidad::class)->find($habilidadId);

            $ph = new PersonajeHabilidad();
            $ph->setPersonaje($personaje);
            $ph->setHabilidad($habilidad);
            $ph->setNivel((int)$nivel);

            $entityManager->persist($ph);
        }

        $entityManager->flush();

        return $this->redirectToRoute('app_personaje_show', [
            'id' => $personaje->getId()
        ]);
    }

    return $this->render('personaje/wizard/point_allocation.html.twig', [
        'personaje' => $personaje,
        'titulo' => 'Habilidades',
        'rasgosAgrupados' => $habilidadesAgrupadas,
        'inputName' => 'habilidades',
        'minimo' => 0,
        'maximo' => 3
    ]);
}
//habilidad fin



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