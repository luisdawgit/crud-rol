<?php

namespace App\Controller;
use App\Entity\Personaje;
use App\Form\PersonajeType;

use App\Repository\AtributoRepository;
use App\Repository\VirtudRepository;
use App\Repository\HabilidadRepository;
use App\Repository\TrasfondoRepository;
use App\Repository\PersonajeRepository;
use App\Repository\PersonajeAtributoRepository;
use App\Repository\PersonajeHabilidadRepository;
use App\Repository\PersonajeTrasfondoRepository;
use App\Repository\PersonajeVirtudRepository;
use App\Repository\PersonajeDisciplinaRepository;

use App\Repository\ClanDisciplinaRepository;
use App\Repository\ClanRepository;
use App\Repository\DisciplinaRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\PersonajeAtributo;
use App\Entity\PersonajeTrasfondo;
use App\Entity\Habilidad;
use App\Entity\PersonajeHabilidad;
use App\Entity\PersonajeDisciplina;
use App\Entity\PersonajeVirtud;

use App\Service\PointAllocationService;


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
            
            //Asigna el usuario actual al personaje creado
            $personaje->setUsuario($this->getUser());
            
            //Comprobar nombre ini
            $existente = $entityManager->getRepository(Personaje::class)->findOneBy([
                'nombre' => $personaje->getNombre(),
                'usuario' => $this->getUser()
            ]);

            if ($existente) {
                $this->addFlash('error', 'Ya tienes un personaje con ese nombre. Por favor, elige otro nombre.');
                return $this->redirectToRoute('app_personaje_new');//--
            }
            //Comprobar nombre fin

            $entityManager->persist($personaje);
            $entityManager->flush();

            return $this->redirectToRoute('app_personaje_disciplinas', [
                'id' => $personaje->getId()
            ]);
        }

        return $this->renderForm('personaje/new.html.twig', [
            'personaje' => $personaje,
            'form' => $form,
        ]);
    }

    private function agruparPorCategoria($rasgos)
    {
        $agrupados = [];

        foreach ($rasgos as $rasgo) {
            $agrupados[$rasgo->getCategoria()][] = $rasgo;
        }

        return $agrupados;
    }


    //atributos init
    #[Route('/{id}/atributos', name: 'app_personaje_atributos', methods: ['GET','POST'])]
    public function atributos(
        Personaje $personaje,
        AtributoRepository $atributoRepository,
        PersonajeAtributoRepository $personajeAtributoRepository,
        Request $request,
        EntityManagerInterface $entityManager,
        PointAllocationService $pointAllocation
    ): Response
    {
        if ($personaje->getUsuario() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $atributos = $atributoRepository->findAll();
        $atributosAgrupados = $this->agruparPorCategoria($atributos);


        // procesar formulario
        if ($request->isMethod('POST')) {

            $data = $request->request->all('atributos');

                
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
            }

            if (!$pointAllocation->validarDistribucion(
                $data,
                function ($atributoId) use ($atributoRepository) {

                    return $atributoRepository
                        ->find($atributoId)
                        ->getCategoria();
                },
                [3,5,7],
                1
            )) {

                $this->addFlash(
                    'error',
                    'Debes repartir los puntos como 7 / 5 / 3'
                );

                return $this->redirectToRoute(
                    'app_personaje_atributos',
                    ['id' => $personaje->getId()]
                );
            }
            
            //Validacion puntos gratuitos fin
            
            foreach ($data as $atributoId => $nivel) {

                $atributo = $atributoRepository->find($atributoId);
                //Evitar duplicados y actualizar si ya existe un registro ini
                $pa = $personajeAtributoRepository->findOneBy([
                    'personaje' => $personaje,
                    'atributo' => $atributo
                ]);

                if(!$pa)
                {
                    $pa = new PersonajeAtributo();
                    $pa->setPersonaje($personaje);
                    $pa->setAtributo($atributo);
                }
                //Evitar duplicados y actualizar si ya existe un registro fin

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
    //atributos fin

    
    //habilidad init
    #[Route('/{id}/habilidades', name: 'app_personaje_habilidades', methods: ['GET','POST'])]
    public function habilidades(
        Personaje $personaje,
        HabilidadRepository $habilidadRepository,
        PersonajeHabilidadRepository $personajeHabilidadRepository,
        Request $request,
        EntityManagerInterface $entityManager,
        PointAllocationService $pointAllocation
    ): Response
    {
        if ($personaje->getUsuario() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $habilidades = $habilidadRepository->findAll(); // luego lo cambiamos a HabilidadRepository

        $habilidadesAgrupadas = $this->agruparPorCategoria($habilidades);


        if ($request->isMethod('POST')) {

            $data = $request->request->all('habilidades');

            if (!$pointAllocation->validarDistribucion(
                $data,
                function ($habilidadId) use ($habilidadRepository) {

                    return $habilidadRepository
                        ->find($habilidadId)
                        ->getCategoria();

                },
                [5, 9, 13],
                0
            )) {

                $this->addFlash(
                    'error',
                    'Debes repartir las habilidades como 13 / 9 / 5'
                );

                return $this->redirectToRoute(
                    'app_personaje_habilidades',
                    ['id' => $personaje->getId()]
                );
            }

            foreach ($data as $habilidadId => $nivel) {

                $habilidad = $habilidadRepository->find($habilidadId);

                //Evitar duplicados y actualizar si ya existe un registro ini
                $ph = $personajeHabilidadRepository->findOneBy([
                    'personaje' => $personaje,
                    'habilidad' => $habilidad
                ]);

                if (!$ph) {
                    $ph = new PersonajeHabilidad();
                    $ph->setPersonaje($personaje);
                    $ph->setHabilidad($habilidad);
                }
                //Evitar duplicados y actualizar si ya existe un registro fin

                $ph->setNivel((int)$nivel);

                $entityManager->persist($ph);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_personaje_trasfondos', [
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


    //Trasfondos init
    #[Route('/{id}/trasfondos', name: 'app_personaje_trasfondos', methods: ['GET','POST'])]
    public function trasfondos(
        Personaje $personaje,
        TrasfondoRepository $trasfondoRepository,
        PersonajeTrasfondoRepository $personajeTrasfondoRepository,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response
    {
        if ($personaje->getUsuario() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $trasfondos = $trasfondoRepository->findAll();
        $trasfondosAgrupados = ['Trasfondos' => $trasfondos];

        if ($request->isMethod('POST')) {

            $data = $request->request->all('trasfondos');

//Validacion puntos gratuitos transfondos ini
            $totalPuntos = array_sum($data);
            if ($totalPuntos !== 5) {
                $this->addFlash('error', 'Debes repartir un total de 5 puntos en trasfondos');
                
                return $this->redirectToRoute('app_personaje_trasfondos', [
                    'id' => $personaje->getId()
                ]);
            }
//Validacion puntos gratuitos transfondos fin

            foreach ($data as $trasfondoId => $nivel) {
                $trasfondo = $trasfondoRepository->find($trasfondoId);

                //Evitar duplicados y actualizar si ya existe un registro ini
                $pt = $personajeTrasfondoRepository->findOneBy([
                    'personaje' => $personaje,
                    'trasfondo' => $trasfondo
                ]);

                if (!$pt) {
                    $pt = new PersonajeTrasfondo();
                    $pt->setPersonaje($personaje);
                    $pt->setTrasfondo($trasfondo);
                }
                //Evitar duplicados y actualizar si ya existe un registro fin

                $pt->setNivel((int)$nivel);

                $entityManager->persist($pt);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_personaje_virtudes', [
                'id' => $personaje->getId()
            ]);
        }

        return $this->render('personaje/wizard/point_allocation.html.twig', [
            'personaje' => $personaje,
            'titulo' => 'Trasfondos',
            'rasgosAgrupados' => $trasfondosAgrupados,
            'inputName' => 'trasfondos',
            'minimo' => 0,
            'maximo' => 3
        ]);
    }
    //Trasfondos fin

    //virtudes init
    #[Route('/{id}/virtudes', name: 'app_personaje_virtudes', methods: ['GET','POST'])]
    public function virtudes(
        Personaje $personaje,
        VirtudRepository $virtudRepository,
        PersonajeVirtudRepository $personajeVirtudRepository,
        Request $request,
        EntityManagerInterface $entityManager,
        PointAllocationService $pointAllocation
    ): Response
    {
        if ($personaje->getUsuario() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $virtudes = $virtudRepository->findAll();
        $virtudesAgrupadas = ['Virtudes' => $virtudes];

        if ($request->isMethod('POST')) {
            $data = $request->request->all('virtudes');//disciplinas

            $totalPuntos = array_sum($data);
            //ultimo cambio ini
            if (!$pointAllocation->validarTotal(
                $data,
                7,
                1
            )) {

                $this->addFlash(
                    'error',
                    'Debes repartir exactamente 7 puntos en virtudes'
                );

                return $this->redirectToRoute(
                    'app_personaje_virtudes',
                    ['id' => $personaje->getId()]
                );
            }
            //ultimo cambio fin

            foreach ($data as $virtudId => $nivel) {
                $virtud = $virtudRepository->find($virtudId);

                //Evitar duplicados y actualizar si ya existe un registro ini
                $pv = $personajeVirtudRepository->findOneBy([
                    'personaje' => $personaje,
                    'virtud' => $virtud
                ]);

                if (!$pv) {
                    $pv = new PersonajeVirtud();
                    $pv->setPersonaje($personaje);
                    $pv->setVirtud($virtud);
                }
                //Evitar duplicados y actualizar si ya existe un registro fin

                $pv->setNivel((int) $nivel);

                $entityManager->persist($pv);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_personaje_show', [
                'id' => $personaje->getId()
            ]);
        }

        return $this->render('personaje/wizard/point_allocation.html.twig', [
            'personaje' => $personaje,
            'titulo' => 'Virtudes',
            'rasgosAgrupados' => $virtudesAgrupadas,
            'inputName' => 'virtudes',
            'minimo' => 1,
            'maximo' => 5
        ]);

        $humanidad = $consciencia + $autocontrol;
        $fuerzaVoluntad = $coraje;

        $personaje->setHumanidad($humanidad);
        $personaje->setFuerzaVoluntad($fuerzaVoluntad);
    }
    //virtudes fin

    //disciplinas init
    #[Route('/{id}/disciplinas', name: 'app_personaje_disciplinas', methods: ['GET','POST'])]
    public function disciplinas(
        Personaje $personaje,
        DisciplinaRepository $disciplinaRepository,
        PersonajeDisciplinaRepository $personajeDisciplinaRepository,
        Request $request,
        EntityManagerInterface $entityManager,
        PointAllocationService $pointAllocation
    ): Response
    {
        if ($personaje->getUsuario() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $disciplinas = [];

        foreach (
            $personaje->getClan()->getClanDisciplinas()
            as $clanDisciplina
        ) {
            $disciplinas[] = $clanDisciplina->getDisciplina();
        }

        $disciplinasAgrupadas = [
            'Disciplinas' => $disciplinas
        ];
        
        if ($request->isMethod('POST')) {
            $data = $request->request->all('disciplinas');

            $totalPuntos = array_sum($data);
            //ultimo cambio ini
            if (!$pointAllocation->validarTotal(
                $data,
                3,
                0
            )) {

                $this->addFlash(
                    'error',
                    'Debes repartir exactamente 3 puntos en disciplinas'
                );

                return $this->redirectToRoute(
                    'app_personaje_disciplinas',
                    ['id' => $personaje->getId()]
                );
            }
            //ultimo cambio fin

            foreach ($data as $disciplinaId => $nivel) {
                $disciplina = $disciplinaRepository->find($disciplinaId);

                //Evitar duplicados y actualizar si ya existe un registro ini
                $pd = $personajeDisciplinaRepository->findOneBy([
                    'personaje' => $personaje,
                    'disciplina' => $disciplina
                ]);

                if (!$pd) {
                    $pd = new PersonajeDisciplina();
                    $pd->setPersonaje($personaje);
                    $pd->setDisciplina($disciplina);
                }
                //Evitar duplicados y actualizar si ya existe un registro fin

                $pd->setNivel((int)$nivel);

                $entityManager->persist($pd);
            }

            $entityManager->flush();

            return $this->redirectToRoute(
                'app_personaje_atributos',
                ['id' => $personaje->getId()]
            );
        }

        return $this->render('personaje/wizard/point_allocation.html.twig', [
            'titulo' => 'Disciplinas',
            'rasgosAgrupados' => $disciplinasAgrupadas,
            'inputName' => 'disciplinas',
            'minimo' => 0,
            'maximo' => 3,
        ]);

        $humanidad = $consciencia + $autocontrol;
        $fuerzaVoluntad = $coraje;

        $personaje->setHumanidad($humanidad);
        $personaje->setFuerzaVoluntad($fuerzaVoluntad);
    }
    //disciplinas fin



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