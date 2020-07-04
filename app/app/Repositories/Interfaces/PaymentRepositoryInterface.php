<?php


namespace App\Repositories\Interfaces;


use App\Entities\Payment;

interface PaymentRepositoryInterface
{
    public function get(int $id):Payment;

    public function save(Payment $payment):Payment;

    public function remove(int $id):void;

}
