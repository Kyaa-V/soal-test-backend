<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrderItemsRequest extends FormRequest
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
            'items' => 'required|array|min:1',
            'id_order' => 'required|exists:orders,id_order',
            'items.*.id_item' => 'required|exists:items,id_item',
            'items.*.jumlah_item' => 'required|integer',
            'items.*.harga_item' => 'required|integer'
        ];
    }

        public function messages()
    {
        return [
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
