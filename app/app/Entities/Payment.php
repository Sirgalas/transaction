<?php

namespace App\Entities;

use App\Entities\Payments\Interfaces\PaymentCodeGeneratorInterface;
use App\Http\Requests\PaymentsRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Class Payment
 *
 * @package App\Entities
 * @property integer $id
 * @property string $email
 * @property integer $user_id
 * @property integer $amount
 * @property string $currency
 * @property string $name
 * @property string $description
 * @property string $message
 * @property string $attachment
 * @property string $code
 * @property integer $status_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Payment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Payment whereAttachment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Payment whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Payment whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Payment whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Payment whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Payment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Payment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Payment whereUserId($value)
 * @mixin \Eloquent
 */
class Payment extends Model
{
    public static $tableName='payments';

    protected $guarded=[];
    public static function create(PaymentsRequest $request,PaymentCodeGeneratorInterface $paymentCodeGenerator):self
    {
        $payment=new static();
         $payment->status_id=PaymentStatus::NEW;
         $payment->email=$request->email;
         $payment->user_id= Auth::user()->id;
         $payment->amount=$request->amount;
         $payment->currency=$request->currency;
         $payment->name=$request->name;
         $payment->description=$request->description;
         $payment->message=$request->message;
         $payment->attachment=$request->attachment;
         $payment->code=$paymentCodeGenerator->generate();
        return $payment;
    }

    public function edit(PaymentsRequest $request):void
    {

        $this->email=$request->email;
        $this->user_id=$request->user_id;
        $this->amount=$request->amount;
        $this->currency=$request->currency;
        $this->name=$request->name;
        $this->description=$request->description;
        $this->message=$request->message;
        $this->attachment=$request->attachment;
    }

}
