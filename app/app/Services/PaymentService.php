<?php


namespace App\Services;


use App\Entities\Payment;
use App\Entities\Payments\UniqPaymentCodeGenerator;
use App\Http\Requests\PaymentsRequest;
use App\Repositories\Interfaces\PaymentRepositoryInterface;

class PaymentService
{
    public $repository;

    public function __construct(PaymentRepositoryInterface $repository)
    {
        $this->repository=$repository;
    }

    public function create(PaymentsRequest $request):Payment
    {

        $payment=Payment::create($request,new UniqPaymentCodeGenerator());
        return$this->repository->save($payment);
    }

    public function edit(int $id,PaymentsRequest $request):void
    {
        $payment=$this->repository->get($id);
        $payment->edit($request);
        $this->repository->save($payment);
    }
}
