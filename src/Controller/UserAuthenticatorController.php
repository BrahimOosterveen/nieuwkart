<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserAuthenticatorController extends AbstractController
{

//    /**
//     * @Route("/login", name="login")
//     */
//    public function loginAction(Request $request, AuthenticationUtils $authUtils)
//    {
//        // get the login error if there is one
//        $error = $authUtils->getLastAuthenticationError();
//
//        // last username entered by the user
//        $lastUsername = $authUtils->getLastUsername();
//        if (isset($error)) {
//            $this->addFlash(
//                'error',
//                'Gegevens kloppen niet. Probeer opnieuw.'
//            );
//        } else {
//
//            $this->addFlash(
//                'notice',
//                'Vul uw gegevens in'
//            );
//        }
//        return $this->render('bezoeker/login.html.twig', array(
//            'last_username' => $lastUsername,
//            'error'         => $error,
//        ));
//    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

//        if (isset($error)) {
//            $this->addFlash(
//                'error',
//                'Gegevens kloppen niet. Probeer opnieuw.'
//            );
//        }
//        else {
//
//            $this->addFlash(
//                'notice',
//                'Vul uw gegevens in'
//            );
//        }

        return $this->render('bezoeker/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
