<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class StoreitemsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'kode_item' => 'required|string|max:255',
            'nama_item' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'kode_item.required' => 'Kode item wajib diisi.',
            'kode_item.string' => 'Kode item harus berupa string.',
            'kode_item.max' => 'Kode item tidak boleh lebih dari 255 karakter.',
            'nama_item.required' => 'Nama item wajib diisi.',
            'nama_item.string' => 'Nama item harus berupa string.',
            'nama_item.max' => 'Nama item tidak boleh lebih dari 255 karakter.',
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
