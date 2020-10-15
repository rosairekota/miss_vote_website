<?php
declare(strict_types=1);

namespace App\Entity\Payment;
use Doctrine\ORM\Mapping as ORM;
use Payum\Core\Model\Payment as BasePayment;


/**
 * @ORM\Entity
 */
class Payment extends BasePayment
{
     /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @var int $id
     */
    protected $id;
    
    public function getId(): int
    {
        return $this->id;
    }
}
