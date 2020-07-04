<?php


namespace App\Entities\Payments;


use App\Entities\Payments\Interfaces\PaymentCodeGeneratorInterface;

class UniqPaymentCodeGenerator implements PaymentCodeGeneratorInterface
{
    public function generate()
    {
        $pool = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, 16)), 0, 16);
    }
}
