<?php

namespace App\Controller;


use App\Entity\Activiteiten;
use App\Entity\Soortactiviteiten;
use App\Entity\User;
use App\Form\ActiviteitType;
use App\Form\SoortactiviteitenType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class MedewerkerController extends AbstractController
{
    /**
     * @Route("/admin/activiteiten", name="activiteitenoverzicht")
     */
    public function activiteitenOverzichtAction()
    {

        $activiteiten=$this->getDoctrine()
            ->getRepository('App:Activiteiten')
            ->findAll();

        return $this->render('medewerker/activiteiten.html.twig', [
            'activiteiten'=>$activiteiten
        ]);
    }

    /**
     * @Route("/admin/deelnemers", name="deelnemers")
     */
    public function deelnemersOverzichtAction(UserRepository $userRepository)
    {



        return $this->render('medewerker/deelnemers.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }


    /**
     * @Route("/admin/deelnemer/update/{id}", name="update_deelnemer", methods={"GET","POST"})
     */
    public function updatedeelnemerAction($id,Request $request,User $user, UserPasswordEncoderInterface $encoder)
    {
        $a=$this->getDoctrine()
            ->getRepository('App:User')
            ->find($id);

        $form = $this->createForm(UserType::class, $a);
        $form->add('save', SubmitType::class, array('label'=>"aanpassen"));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $encoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash(
                'notice',
                'activiteit aangepast!'
            );
            return $this->redirectToRoute('beheer');
        }

        $user=$this->getDoctrine()
            ->getRepository('App:User')
            ->findAll();

        return $this->render('medewerker/deelnemer.html.twig',array('form'=>$form->createView(),'naam'=>'aanpassen','aantal'=>count($user)));
    }

    /**
     * @Route("/admin/user/{id}/delete", name="user_delete", methods={"DELETE"})
     */
    public function userDelete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/admin/details/{id}", name="details")
     */
    public function detailsAction($id)
    {
        $activiteiten=$this->getDoctrine()
            ->getRepository('App:Activiteiten')
            ->findAll();
        $activiteit=$this->getDoctrine()
            ->getRepository('App:Activiteiten')
            ->find($id);

        $deelnemers=$this->getDoctrine()
            ->getRepository('App:User')
            ->getDeelnemers($id);


        return $this->render('medewerker/details.html.twig', [
            'activiteit'=>$activiteit,
            'deelnemers'=>$deelnemers,
            'aantal'=>count($activiteiten)
        ]);
    }

    /**
     * @Route("/admin/beheer", name="beheer")
     */
    public function beheerAction()
    {
        $activiteiten=$this->getDoctrine()
            ->getRepository('App:Activiteiten')
            ->findAll();

        return $this->render('medewerker/beheer.html.twig', [
            'activiteiten'=>$activiteiten
        ]);
    }

    /**
     * @Route("/admin/add", name="add")
     */
    public function addAction(Request $request)
    {
        // create a user and a contact
        $a=new Activiteiten();

        $form = $this->createForm(ActiviteitType::class, $a);
        $form->add('save', SubmitType::class, array('label'=>"voeg toe"));
        //$form->add('reset', ResetType::class, array('label'=>"reset"));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($a);
            $em->flush();

            $this->addFlash(
                'notice',
                'activiteit toegevoegd!'
            );
            return $this->redirectToRoute('beheer');
        }
        $activiteiten=$this->getDoctrine()
            ->getRepository('App:Activiteiten')
            ->findAll();
        return $this->render('medewerker/add.html.twig',array('form'=>$form->createView(),'naam'=>'toevoegen','aantal'=>count($activiteiten)
        ));
    }

    /**
     * @Route("/admin/update/{id}", name="update")
     */
    public function updateAction($id,Request $request)
    {
        $a=$this->getDoctrine()
            ->getRepository('App:Activiteiten')
            ->find($id);

        $form = $this->createForm(ActiviteitType::class, $a);
        $form->add('save', SubmitType::class, array('label'=>"aanpassen"));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            // tells Doctrine you want to (eventually) save the contact (no queries yet)
            $em->persist($a);


            // actually executes the queries (i.e. the INSERT query)
            $em->flush();
            $this->addFlash(
                'notice',
                'activiteit aangepast!'
            );
            return $this->redirectToRoute('beheer');
        }

        $activiteiten=$this->getDoctrine()
            ->getRepository('App:Activiteiten')
            ->findAll();

        return $this->render('medewerker/add.html.twig',array('form'=>$form->createView(),'naam'=>'aanpassen','aantal'=>count($activiteiten)));
    }

    /**
     * @Route("/admin/delete/{id}", name="delete")
     */
    public function deleteAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $a= $this->getDoctrine()
            ->getRepository('App:Activiteiten')->find($id);
        $em->remove($a);
        $em->flush();

        $this->addFlash(
            'notice',
            'activiteit verwijderd!'
        );
        return $this->redirectToRoute('beheer');

    }


    /**
     * @Route("/admin/soortactiviteiten/new", name="soortactiviteiten_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $soortactiviteiten = new Soortactiviteiten();
        $form = $this->createForm(SoortactiviteitenType::class, $soortactiviteiten);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($soortactiviteiten);
            $entityManager->flush();

            return $this->redirectToRoute('soortactiviteiten_index');
        }

        return $this->render('soortactiviteiten/new.html.twig', [
            'soortactiviteiten' => $soortactiviteiten,
            'form' => $form->createView(),
        ]);
    }


}
