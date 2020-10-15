<?php
namespace App\Controller\checkout;

use Payum\Core\Payum;
use App\Entity\Payment\Payment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

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
        $payment->setCurrencyCode('EUR');
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
}