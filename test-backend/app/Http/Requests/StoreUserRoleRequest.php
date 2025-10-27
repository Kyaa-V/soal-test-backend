<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUserRoleRequest extends FormRequest
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
            'users_id' => 'required|exists:users,id',
            'roles_id' => 'required|exists:roles,id',
        ];
    }

    public function messages()
    {
        return [
            'users_id.required' => 'User ID wajib diisi tidak boleh kosong.',
            'users_id.exists' => 'User ID tidak valid.',
            'roles_id.required' => 'Role ID wajib diisi tidak boleh kosong.',
            'roles_id.exists' => 'Role ID tidak valid.',
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
