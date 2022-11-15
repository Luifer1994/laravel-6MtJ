<?php

namespace App\Http\Modules\Users\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'             => 'required|string',
            'last_name'        => 'required|string',
            'document_type_id' => 'required|exists:document_types,id',
            'document_number'  => 'required|string',
            'phone'            => 'nullable|string',
            'email'            => 'required|email|unique:users,email,' . $this->id.',id',
            'type'             => 'required|string|in:employee,client,supplier',
            'password'         => 'required_if:type,==,employee',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 400));
    }
}
