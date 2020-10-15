<?php
declare(strict_types=1);

namespace App\Entity\Payment;
use Doctrine\ORM\Mapping as ORM;
use Payum\Core\Model\Token as BaseToken;
/**
 * @ORM\Entity
 */
class PaymentToken extends BaseToken
{
}