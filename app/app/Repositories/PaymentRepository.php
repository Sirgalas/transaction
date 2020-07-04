<?php


namespace App\Repositories;
use App\Entities\Payment;
use App\Exceptions\EntitiesNotFindException;
use App\Repositories\Interfaces\PaymentRepositoryInterface;
use App\Exceptions\EntitiesNotSaveException;

class PaymentRepository implements PaymentRepositoryInterface
{
    public function get(int $id):Payment
    {
        if(!$payment=Payment::find($id)){
            throw new EntitiesNotFindException('not find',404);
        }
        return $payment;
    }

    public function save(Payment $payment):Payment
    {
        if(!$payment->save()){
            throw new EntitiesNotSaveException('not save',500);
        }
        return $payment;
    }

    public function remove(int $id): void
    {
        $payment=$this->get($id);
        $payment->delete();
    }
}
