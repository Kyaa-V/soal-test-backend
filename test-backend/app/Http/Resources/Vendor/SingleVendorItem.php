<?php

namespace App\Http\Resources\Vendor;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SingleVendorItem extends JsonResource
{
    private $statusCode, $success, $message,$data;

    public function __construct($statusCode, $success, $message, $data)
    {
        $this->statusCode = $statusCode;
        $this->success = $success;
        $this->message = $message;
        $this->data = $data;
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toResponse($request)
    {
        return response()->json([
            'payload' => [
                'message' => $this->message,
                'success' => $this->success,
                'data' => new SingleVendorCollection($this->data)
            ]
        ],$this->statusCode);
    }
}
