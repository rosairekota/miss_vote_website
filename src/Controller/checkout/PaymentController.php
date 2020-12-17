<?php
namespace App\Controller\checkout;

use Payum\Core\Payum;
use App\Form\PaymentType;
use Payum\Core\Request\Sync;
use App\Entity\Payment\Payment;
use Payum\Core\Request\GetHumanStatus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Payum\Core\Exception\RequestNotSupportedException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PaymentController extends AbstractController{

private Payum $payum;
private EntityManagerInterface $doctrine;

 public function __construct(Payum $payum,EntityManagerInterface $doctrine)
    {
        $this->payum = $payum;
        $this->doctrine = $doctrine;
    }

    /**
     * @Route("/checkout/payment/", name="checkout_payment")
     */
    public function home(){

        return $this->render('checkout/payment.html.twig',[
            'montant'   =>100
        ]);
    }

   /**
     * @Route("/checkout/payment/paypal", name="checkout_payment_paypal")
     */
    public function index(Request $request,SerializerInterface $serialize, EntityManagerInterface $em)
    {

        //$checkout = $this->checkoutFacade->getCheckout();


        if ($request->query->get('return')) {
            $token = $this->payum->getHttpRequestVerifier()->verify($request);

            throw new \Exception('never');

            $view = new JsonResponse([
                'request' => $request->request->all(),
                'query' => $request->query->all(),
            ], JsonResponse::HTTP_OK,['Content-Type'=>'application/javascript'], true);


            return $view;
        }

        if ($request->query->get('cancel')) {
            // redirect to payment page with info that payment was cancelled
            $view = new JsonResponse([
                'request' => $request->request->all(),
                'query' => $request->query->all(),
            ], JsonResponse::HTTP_OK,['Content-Type'=>'application/javascript'], true);


            return $view;
        }

        $payment = new Payment();
        //$payment->setNumber($checkout->getId());
        //$payment->setNumber('12345');
        $payment->setNumber(uniqid());
        $payment->setCurrencyCode('USD');
        $payment->setTotalAmount(300);
        $payment->setDescription('A description');
        $payment->setClientId('anId');
        $payment->setClientEmail('foo@example.com');
        $em->persist($payment);
        $em->flush($payment);

        $authorizeToken = $this->payum->getTokenFactory()->createAuthorizeToken(
            'paypal',
            $payment,
            'checkout_review' //$this->utils->generateUrl('checkout_payment_paypal', ['return' => 1], UrlGeneratorInterface::ABSOLUTE_URL)
        );

        $view = $this->redirect($authorizeToken->getTargetUrl());

        return $view;
    }
 

   /**
     * @Route("/checkout/view", name="checkout_review")
     */
   public function __invoke(Request $request,EntityManagerInterface $em, SessionInterface $session)
    {
        $cotes=$session->get('cotesSession',[]);
         
        $token = $this->payum->getHttpRequestVerifier()->verify($request);

        $gateway = $this->payum->getGateway($token->getGatewayName());
        try {
            $gateway->execute(new Sync($token));
        } catch (RequestNotSupportedException $e) {
        }

        $gateway->execute($status = new GetHumanStatus($token));

         if (!$status->isAuthorized()) {
            $this->addFlash('danger','Payement n\'a pas été autorisé !');
            //throw new \Exception('Payement n\'a pas été autorisé !');
        }

        // on verfifie si le payement a reussi ou autorise
        if($status->isAuthorized() && !empty($cotes)){

            $con=$em->getConnection();
                     $sql="INSERT INTO cote(votant_id,candidat_id,cote_votant,montant_paye,datevote) VALUES(:votant_id, :candidat_id, :cote_votant, :montant_paye, NOW())";
    
                    $con->prepare($sql);
                    $con->executeUpdate($sql,$cotes);
           $this->addFlash('success','Payement a reussi avec succès! Votre vote est validé!');
             
            return $this->redirectToRoute('candidat_show',['id'=>$cotes['candidat_id']],301);
        }
      
        //session_destroy();
        return $this->render('checkout/review.html.twig',[]);
    }
        //  $payment = $status->getFirstModel();
        // $form = $this->createForm(PaymentType::class,$payment);

        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     // capture
        //     $captureToken = $this->payum->getTokenFactory()->createCaptureToken(
        //         $token->getGatewayName(),
        //         $status->getFirstModel(),
        //         'checkout_finalize' //$this->utils->generateUrl('checkout_finalize', UrlGeneratorInterface::ABSOLUTE_URL)
        //     );

        //     $view = $captureToken->getTargetUrl();

        //     return $view;
        // }

       
    //     return $this->render('checkout/review.html.twig',[
    //             'form' => $form->createView(),
    //             'status' => $status,
    //         ]);
    
}
