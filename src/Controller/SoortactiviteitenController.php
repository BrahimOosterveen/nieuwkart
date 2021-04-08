<?php

namespace App\Controller;

use App\Entity\Soortactiviteiten;
use App\Form\SoortactiviteitenType;
use App\Repository\SoortactiviteitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/soortactiviteiten")
 */
class SoortactiviteitenController extends AbstractController
{
    /**
     * @Route("/soortactiviteit/", name="soortactiviteiten_index", methods={"GET"})
     */
    public function index(): Response
    {
        $soortactiviteitRepository=$this->getDoctrine()->getRepository(Soortactiviteiten::class);
        return $this->render('soortactiviteiten/index.html.twig', [
            'soortactiviteitens' => $soortactiviteitRepository->findAll(),
        ]);
    }



    /**
     * @Route("/soortactiviteiten/{id}", name="soortactiviteiten_show", methods={"GET"})
     */
    public function show(Soortactiviteiten $soortactiviteiten): Response
    {
        return $this->render('soortactiviteiten/show.html.twig', [
            'soortactiviteiten' => $soortactiviteiten,
        ]);
    }

    /**
     * @Route("/soortactiviteiten/{id}/edit", name="soortactiviteiten_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Soortactiviteiten $soortactiviteiten): Response
    {
        $form = $this->createForm(SoortactiviteitenType::class, $soortactiviteiten);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('soortactiviteiten_index');
        }

        return $this->render('soortactiviteiten/edit.html.twig', [
            'soortactiviteiten' => $soortactiviteiten,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="soortactiviteiten_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Soortactiviteiten $soortactiviteiten): Response
    {
        if ($this->isCsrfTokenValid('delete'.$soortactiviteiten->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($soortactiviteiten);
            $entityManager->flush();
        }

        return $this->redirectToRoute('soortactiviteiten_index');
    }
}
