<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class PaymentStatus extends Model
{
    const NEW=1;

    protected $guarded=[];
}
