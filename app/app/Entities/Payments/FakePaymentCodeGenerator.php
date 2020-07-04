<?php


namespace App\Entities\Payments;


use App\Entities\Payments\Interfaces\PaymentCodeGeneratorInterface;

class FakePaymentCodeGenerator implements PaymentCodeGeneratorInterface
{
    public function generate()
    {
        return "TESTCODE123456";
    }
}
