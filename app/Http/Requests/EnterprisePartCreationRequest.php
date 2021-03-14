<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnterprisePartCreationRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email',
            'is_academic_part' => 'required'
        ];
    }

    public function message()
    {
        return [
            'name.required' => 'Must define the Enterprise Part Name',
            'email.required' => 'Must specify the head of the Enterprise Part',
            'is_academic_part' => 'Must define the Enterprise Part type',
        ];
    }
}
