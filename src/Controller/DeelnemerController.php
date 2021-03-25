<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DeelnemerController extends AbstractController
{
    /**
     * @Route("/user/activiteiten", name="activiteiten")
     */
    public function activiteitenAction()
    {
        $usr= $this->get('security.token_storage')->getToken()->getUser();

        $beschikbareActiviteiten=$this->getDoctrine()
            ->getRepository('App:Activiteiten')
            ->getBeschikbareActiviteiten($usr->getId());

        $ingeschrevenActiviteiten=$this->getDoctrine()
            ->getRepository('App:Activiteiten')
            ->getIngeschrevenActiviteiten($usr->getId());

        $totaal=$this->getDoctrine()
            ->getRepository('App:Activiteiten')
            ->getTotaal($ingeschrevenActiviteiten);


        return $this->render('deelnemer/activiteiten.html.twig', [
            'beschikbare_activiteiten'=>$beschikbareActiviteiten,
            'ingeschreven_activiteiten'=>$ingeschrevenActiviteiten,
            'totaal'=>$totaal,
        ]);
    }

    /**
     * @Route("/user/inschrijven/{id}", name="inschrijven")
     */
    public function inschrijvenActiviteitAction($id)
    {

        $activiteit = $this->getDoctrine()
            ->getRepository('App:Activiteiten')
            ->find($id);
        $usr= $this->get('security.token_storage')->getToken()->getUser();
        $usr->addActiviteit($activiteit);

        $em = $this->getDoctrine()->getManager();
        $em->persist($usr);
        $em->flush();

        return $this->redirectToRoute('activiteiten');
    }

    /**
     * @Route("/user/uitschrijven/{id}", name="uitschrijven")
     */
    public function uitschrijvenActiviteitAction($id)
    {
        $activiteit = $this->getDoctrine()
            ->getRepository('App:Activiteiten')
            ->find($id);
        $usr= $this->get('security.token_storage')->getToken()->getUser();
        $usr->removeActiviteit($activiteit);
        $em = $this->getDoctrine()->getManager();
        $em->persist($usr);
        $em->flush();
        return $this->redirectToRoute('activiteiten');
    }

}
