<?php

namespace App\Http\Controllers;

use App\Entities\Payment;
use App\Exceptions\EntitiesNotSaveException;
use App\Http\Requests\PaymentsRequest;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public $service;

    public function __construct(PaymentService $service)
    {
        $this->service=$service;
    }

    public function create()
    {
        return view('payments.create');
    }

    public function store(PaymentsRequest $request)
    {

        try{
            $this->service->create($request);
        }catch (EntitiesNotSaveException $e){

        }

        /*$request->user()->payments()->create([
            'amount'=>$request->amount,
            'email'=>$request->email,
            'currency'=>$request->currency
        ]);*/
    }

    public function dashboard()
    {
        return view('dashboard');
    }
}
