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


    /**
     * @Route("/checkout/view", name="checkout_review")
     */
    public function review(Request $request,SerializerInterface $serialize, EntityManagerInterface $em)
    {
         $token = $this->payum->getHttpRequestVerifier()->verify($request);

        $gateway = $this->payum->getGateway($token->getGatewayName());
        try {
            $gateway->execute(new Sync($token));
        } catch (RequestNotSupportedException $e) {
        }

        $gateway->execute($status = new GetHumanStatus($token));

        if (!$status->isAuthorized()) {
            throw new \Exception(' Le Payement n\'a pas été authorisé');
        }
        // $checkout=new Payment();
        // $form = $this->createForm(PaymentType::class,$checkout);

        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     // capture
            $captureToken = $this->payum->getTokenFactory()->createCaptureToken(
                $token->getGatewayName(),
                $status->getFirstModel(),
                'checkout_finalize' //$this->utils->generateUrl('checkout_finalize', UrlGeneratorInterface::ABSOLUTE_URL)
            );

            return $this->redirect($captureToken->getTargetUrl());

           
        

        return $this->render('checkout/review.html.twig',
            [
                //'form' => $form,
                'status' => $status,
            ]
           
        );

      
    
       // return new Response('review page');
    }


    /**
     * @Route("/checkout/finalize", name="checkout_finalize")
     */
     public function finalize(Request $request)
    {
        $token = $this->payum->getHttpRequestVerifier()->verify($request);

        $gateway = $this->payum->getGateway($token->getGatewayName());
        try {
            $gateway->execute(new Sync($token));
        } catch (RequestNotSupportedException $e) {
        }

        $gateway->execute($status = new GetHumanStatus($token));

        if (!$status->isCaptured()) {
            throw new \Exception('Payment n\'a pas  été capturé ');

            // @todo add payment failure msg
            //$view = View::createRouteRedirect('checkout_payment');

            //return $view;
        }
        // $cart = $this->cartManager->loadCart();
        // $this->cartManager->resetCart($cart);

        $request->getSession()->set('order_id', $status->getFirstModel()->getId());

        

        return $this->redirectToRoute('checkout_success');
    }

    /**
     * @Route("/checkout/success", name="checkout_success")
     */
    public function checkoutSuccess(){
        $this->addFlash('success','Le payement a reussi');
        return $this->redirectToRoute('candidat_index');
    }
}
