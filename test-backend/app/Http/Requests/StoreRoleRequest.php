<?php

namespace App\Http\Requests;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:roles,name'
        ];
    }

        public function messages()
    {
        return [
            'name.required' => 'Nama wajib diisi tidak boleh kosong.',
            'name.string' => 'Nama harus berupa string.',
            'name.unique' => 'Nama sudah terdaftar.'
        ];
    }

        protected function failedAuthorization()
    {
        throw new AuthorizationException('Unauthorized');
    }

    protected function prepareForValidation()
    {
        $this->headers->set('Accept', 'application/json');
    }

    protected function failedValidation(Validator $validator)
    {
        // Force return JSON response dengan format konsisten
        throw new HttpResponseException(
            response()->json([
                'payload' => [
                    'message' => 'Validation failed',
                    'success' => false,
                    'errors' => $validator->errors()
                ]
            ], 422)
        );
    }

}
