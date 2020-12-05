<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * @Route("/contact")
 */
class ContactController 
{  
    private  Environment $twig;
    public function __construct(Environment $twig)
    {
        $this->twig=$twig;
    }

   /**
    * @Route("/", name="contact_index")
    */
   public function __invoke():Response
   {
       return new Response($this->twig->render('contact/index.html.twig',[]));
   }
    
}
