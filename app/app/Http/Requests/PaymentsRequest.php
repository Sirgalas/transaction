<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PaymentsRequest
 * @package App\Http\Requests
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
 */
class PaymentsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'=>'required|email',
            'amount'=>'required|integer|min:100',
            'currency'=>'required|string|max:3',
            'name'=>'required|string',
            'description'=>'string',
            'message'=>'string',
            //'user_id'=>'required|integer',
        ];
    }

    /*public function messages()
    {
        return [
            'user_id.exists'=>'Такого пользователя нет в базе',
            'image.image'=>'Картинка имеет не подходяший формат'
        ];
    }*/
}
