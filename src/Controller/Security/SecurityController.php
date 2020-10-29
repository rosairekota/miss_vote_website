<?php

namespace App\Controller\Security;


use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    
     /**
     * @Route("/login", name="security_login")
     */
    public function login(AuthenticationUtils $auth)
    {

        $this->addFlash('success',' Connectez-vous maintenant!');
        $lastusername = $auth->getLastUsername();
        return $this->render('security/login.html.twig', [
            'last_username' => $lastusername,
            'error' => $auth->getLastAuthenticationError()
        ]);
    }

    public function logout()
    {
    }
}
