<?php
declare(strict_types=1);

namespace App\Checkout\Payement\Service;

//use App\Entity\Cote;


// use App\Cart\Model\Checkout;
// use App\Checkout\Payment\Model\PaymentMethod;
// use App\Store\Service\Store\StoreManager;

/**
 * @author Philipp Wahala <philipp.wahala@gmail.com>
 */
class PaymentMethodManager
{
    // /**
    //  * @var StoreManager
    //  */
    // private $storeManager;

    // public function __construct(StoreManager $storeManager)
    // {
    //     $this->storeManager = $storeManager;
    // }

    public function getPaymentMethods()
    {
       // $configPaymentMethods = $this->storeManager->getPaymentMethods();

        $paymentMethods = [
            'Paypal' =>'paypal express'
        ];

        // foreach ($configPaymentMethods as $configPaymentMethod) {
        //     $paymentMethod = $this->loadPaymentMethod($configPaymentMethod, $checkout);

        //     if ($paymentMethod) {
        //         $paymentMethods[$paymentMethod->getName()] = $paymentMethod;
        //     }
        // }

        return $paymentMethods;
    }

    // private function loadPaymentMethod(string $configPaymentMethod, Checkout $checkout): ?PaymentMethod
    // {
    //     $paymentMethod = new PaymentMethod();
    //     $paymentMethod->setName($configPaymentMethod);

    //     return $paymentMethod;
    // }
}