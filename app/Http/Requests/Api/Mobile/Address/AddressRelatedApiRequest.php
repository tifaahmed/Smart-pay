<?php

namespace App\Http\Requests\Api\Mobile\Address;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\Address;

use Auth;

class AddressRelatedApiRequest extends FormRequest
{
    public function __construct()
    {
        $this->authorization_message = '';
    }
    public function authorize()
    {
        $model = Address::find($this->id);
        if (!$model) {
            $this->authorization_message = 'id not found';
            return false;
        }
        if ($model->user_id != Auth::user()->id ) {
            $this->authorization_message = 'not your auth data';
            return false;           
        }
        return true;
    }
    protected function failedAuthorization()
    {
        throw new \Illuminate\Auth\Access\AuthorizationException($this->authorization_message);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {        
        $all=[];
        

        return $all;
    }

}